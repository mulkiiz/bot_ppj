<?php
/**
 * webhook.php — Endpoint webhook Telegram Bot Brilian 2026
 * Versi mysqli (tanpa PDO), kompatibel PHP 7.3+
 *
 * OPTIMASI v2:
 *  - Persistent MySQL connection (prefix p:)
 *  - sendMessage() segera, lalu fastcgi_finish_request()
 *  - Audit log & rate-limit INSERT dijalankan SETELAH response ditutup
 *  - curl timeout dipisah: connect 2s, total 4s
 */

require __DIR__ . '/config.php';

// 1. Verifikasi secret webhook
$incomingSecret = $_SERVER['HTTP_X_TELEGRAM_BOT_API_SECRET_TOKEN'] ?? '';
if (!hash_equals($WEBHOOK_SECRET, $incomingSecret)) {
    http_response_code(403);
    exit('Forbidden');
}

// 2. Parse update Telegram
$raw    = file_get_contents('php://input');
$update = json_decode($raw, true);
if (!$update || !isset($update['message'])) {
    http_response_code(200);
    exit('OK');
}

$msg          = $update['message'];
$chatId       = (int) $msg['chat']['id'];
$telegramId   = (int) $msg['from']['id'];
$telegramName = trim(($msg['from']['first_name'] ?? '') . ' ' . ($msg['from']['last_name'] ?? ''));
$text         = trim($msg['text'] ?? '');

// 3. Koneksi MySQL via mysqli — PERSISTENT (prefix p:)
$mysqli = @new mysqli('p:' . $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_error) {
    error_log("DB error: " . $mysqli->connect_error);
    sendMessage($BOT_TOKEN, $chatId, "⚠️ Server sedang gangguan, coba lagi nanti.");
    exit;
}
$mysqli->set_charset('utf8mb4');

// Container untuk pekerjaan yang ditunda hingga setelah response ditutup
$pendingAudit = null;       // [tgId, tgName, username, status]
$pendingRateInsert = false; // bool — apakah perlu insert rate_limit

// 4. Routing /start /help
if ($text === '/start' || $text === '/help') {
    $help = "👋 *Bot Brilian 2026 — Cek Akun Moodle*\n\n"
          . "Kirim pesan dengan format:\n"
          . "`KODE_DESA SPASI 4_DIGIT_TERAKHIR_HP_KADES`\n\n"
          . "Contoh:\n"
          . "`1409082010 2657`\n\n"
          . "Bot akan membalas username & password login Moodle Anda.\n\n"
          . "_4 digit HP yang dimaksud adalah 4 angka terakhir nomor HP Kepala Desa Anda._\n\n"
          . "⚠️ Batas 5 permintaan / jam.";
    sendMessage($BOT_TOKEN, $chatId, $help, 'Markdown');
    finishRequest();
    exit;
}

if ($text === '/stats' && in_array($telegramId, $ADMIN_TELEGRAM_IDS, true)) {
    $res = $mysqli->query("SELECT status, COUNT(*) c FROM audit_log
                           WHERE created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
                           GROUP BY status");
    $reply = "📊 *Stats 24 jam terakhir:*\n";
    while ($r = $res->fetch_assoc()) $reply .= "• {$r['status']}: {$r['c']}\n";
    sendMessage($BOT_TOKEN, $chatId, $reply, 'Markdown');
    finishRequest();
    exit;
}

// 5. Rate limit check (cepat — pakai index)
$stmt = $mysqli->prepare("SELECT COUNT(*) FROM rate_limit
                          WHERE telegram_id = ?
                            AND created_at >= DATE_SUB(NOW(), INTERVAL 1 HOUR)");
$stmt->bind_param('i', $telegramId);
$stmt->execute();
$stmt->bind_result($used);
$stmt->fetch();
$stmt->close();

if ($used >= $RATE_LIMIT_PER_HOUR) {
    sendMessage($BOT_TOKEN, $chatId,
        "⏱ Anda sudah mencapai batas $RATE_LIMIT_PER_HOUR permintaan/jam. "
      . "Silakan coba lagi 1 jam lagi.");
    $pendingAudit = [$telegramId, $telegramName, null, 'rate_limited'];
    finishRequest();
    runDeferred($mysqli, $pendingAudit, false);
    exit;
}

// 6. Parse input
if (!preg_match('/^(\d{10})\s+(\d{4})$/', $text, $m)) {
    sendMessage($BOT_TOKEN, $chatId,
        "❌ Format salah.\n\n"
      . "Kirim: `KODEDESA SPASI 4DIGITHP`\n"
      . "Contoh: `1409082010 2657`\n\n"
      . "Ketik /help untuk panduan.", 'Markdown');
    $pendingAudit = [$telegramId, $telegramName, null, 'invalid_format'];
    $pendingRateInsert = true;
    finishRequest();
    runDeferred($mysqli, $pendingAudit, $pendingRateInsert);
    exit;
}

$queryUsername = $m[1];
$queryHp4      = $m[2];

// 7. Verifikasi 2 faktor (cepat — pakai index username)
$stmt = $mysqli->prepare("SELECT username, password, hp_last4, nama_desa, kecamatan, kabupaten
                          FROM users WHERE username = ?");
$stmt->bind_param('s', $queryUsername);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    sendMessage($BOT_TOKEN, $chatId, "❌ Kode desa tidak ditemukan dalam database peserta.");
    $pendingAudit = [$telegramId, $telegramName, $queryUsername, 'user_not_found'];
    $pendingRateInsert = true;
    finishRequest();
    runDeferred($mysqli, $pendingAudit, $pendingRateInsert);
    exit;
}

if (!hash_equals($user['hp_last4'], $queryHp4)) {
    sendMessage($BOT_TOKEN, $chatId,
        "❌ Verifikasi gagal.\n\n"
      . "4 digit HP Kepala Desa tidak cocok. Pastikan Anda perangkat desa yang berwenang.");
    $pendingAudit = [$telegramId, $telegramName, $queryUsername, 'wrong_2fa'];
    $pendingRateInsert = true;
    finishRequest();
    runDeferred($mysqli, $pendingAudit, $pendingRateInsert);
    exit;
}

// 8. Sukses
$reply = "✅ *Selamat Datang Peserta Desa BRILiaN 2026*\n"
       . "🏘 Desa *{$user['nama_desa']}*\n"
       . "📍 Kec. {$user['kecamatan']}, {$user['kabupaten']}\n\n"
       . "📅 *Kickoff:* Kamis, 7 Mei 2026\n"
       . "Waktu: 08:00 sd 12:00 WIB\n"
       . "Join Zoom: bit.ly/KickoffDesaBrilian2026\n\n"
       . "🔐 *Akun LMS Joglo*\n"
       . "username: `{$user['username']}`\n"
       . "password: `{$user['password']}`\n"
       . "Login: https://joglo.unsoed.ac.id/login/index.php\n\n"
       . "ℹ️ Info: Tri Wahyu — https://wa.me/6287887650978\n"
       . "👥 WA group peserta: https://chat.whatsapp.com/H5hycX2YeUz7IEWAHZ8cJf";

sendMessage($BOT_TOKEN, $chatId, $reply, 'Markdown');

$pendingAudit = [$telegramId, $telegramName, $queryUsername, 'success'];
$pendingRateInsert = true;
finishRequest();
runDeferred($mysqli, $pendingAudit, $pendingRateInsert);
exit;

// =============================================================
function sendMessage($token, $chatId, $text, $parseMode = null) {
    $payload = ['chat_id' => $chatId, 'text' => $text];
    if ($parseMode) $payload['parse_mode'] = $parseMode;

    $ch = curl_init("https://api.telegram.org/bot$token/sendMessage");
    curl_setopt_array($ch, [
        CURLOPT_POST            => true,
        CURLOPT_POSTFIELDS      => http_build_query($payload),
        CURLOPT_RETURNTRANSFER  => true,
        CURLOPT_CONNECTTIMEOUT  => 2,
        CURLOPT_TIMEOUT         => 4,
    ]);
    curl_exec($ch);
    curl_close($ch);
}

/**
 * Kirim HTTP 200 ke Telegram & tutup koneksi sekarang juga,
 * supaya pekerjaan DB di bawah tidak menahan response.
 */
function finishRequest() {
    http_response_code(200);
    if (function_exists('fastcgi_finish_request')) {
        // Mode PHP-FPM (paling umum di cPanel modern)
        fastcgi_finish_request();
        return;
    }
    // Fallback untuk mod_php / CGI
    @ignore_user_abort(true);
    @set_time_limit(30);
    if (!headers_sent()) {
        header('Connection: close');
        header('Content-Length: 2');
    }
    echo 'OK';
    @ob_end_flush();
    @flush();
}

/**
 * Operasi DB yang dijalankan SETELAH response ditutup.
 * User sudah dapat balasan, ini cuma housekeeping.
 */
function runDeferred($mysqli, $auditTuple, $insertRate) {
    // Cleanup rate_limit lama — hanya kadang-kadang (10% kemungkinan)
    // supaya tidak setiap request ngorek tabel.
    if (random_int(1, 10) === 1) {
        $mysqli->query("DELETE FROM rate_limit WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 HOUR)");
    }

    if ($insertRate && $auditTuple) {
        $tgId = $auditTuple[0];
        $stmt = $mysqli->prepare("INSERT INTO rate_limit (telegram_id) VALUES (?)");
        $stmt->bind_param('i', $tgId);
        $stmt->execute();
        $stmt->close();
    }

    if ($auditTuple) {
        list($tgId, $tgName, $username, $status) = $auditTuple;
        $stmt = $mysqli->prepare("INSERT INTO audit_log
                                  (telegram_id, telegram_name, query_username, status)
                                  VALUES (?, ?, ?, ?)");
        $stmt->bind_param('isss', $tgId, $tgName, $username, $status);
        $stmt->execute();
        $stmt->close();
    }
}
