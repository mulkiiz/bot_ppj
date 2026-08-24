<?php
/**
 * Bot Telegram @mizpbg_bot — Desa BRILiaN 2026
 * Stack: PHP 7.3 + MySQL (mysqli)
 * Mode: Webhook
 *
 * Update 1 Mei 2026:
 * - Template pesan kredensial diganti format Brilian 2026
 * - Tambah info Kickoff Zoom, kontak panitia, link WA group
 *
 * CARA EDIT KONSTANTA: ubah nilai di blok KONSTANTA di bawah, save, upload.
 */

// ============================================================
// KONSTANTA — edit di sini kalau perlu ubah info
// ============================================================
const BOT_TOKEN        = 'YOUR_BOT_TOKEN';           // dari @BotFather
const WEBHOOK_SECRET   = 'YOUR_WEBHOOK_SECRET';      // sesuai set_webhook.php

const DB_HOST          = 'localhost';
const DB_USER          = 'YOUR_DB_USER';
const DB_PASS          = 'YOUR_DB_PASSWORD';
const DB_NAME          = 'YOUR_DB_NAME';

const RATE_LIMIT_MAX   = 5;       // max attempts per jam
const RATE_LIMIT_WIN   = 3600;    // window detik (1 jam)

// Info acara — edit kalau berubah
const ZOOM_LINK        = 'bit.ly/KickoffDesaBrilian2026';
const KICKOFF_DATE     = 'Kamis, 7 Mei 2026';
const LMS_LOGIN_URL    = 'https://joglo.unsoed.ac.id/login/index.php';

// Kontak & grup — ganti placeholder begitu data final tersedia
const WA_PANITIA_NAMA  = 'Tri Wahyu';
const WA_PANITIA_NOMOR = '0812XXXXXXXX';                                   // format: 08xxx (tanpa +62)
const WA_GROUP_LINK    = 'https://chat.whatsapp.com/PLACEHOLDER';

// ============================================================
// SECURITY: validasi secret webhook
// ============================================================
$received_secret = $_SERVER['HTTP_X_TELEGRAM_BOT_API_SECRET_TOKEN'] ?? '';
if (!hash_equals(WEBHOOK_SECRET, $received_secret)) {
    http_response_code(403);
    exit('Forbidden');
}

// ============================================================
// PARSE INCOMING UPDATE
// ============================================================
$input = file_get_contents('php://input');
$update = json_decode($input, true);

if (!$update || !isset($update['message'])) {
    http_response_code(200);
    exit;
}

$msg     = $update['message'];
$chat_id = $msg['chat']['id'];
$text    = trim($msg['text'] ?? '');
$tg_user = $msg['from']['username'] ?? '';
$tg_name = trim(($msg['from']['first_name'] ?? '') . ' ' . ($msg['from']['last_name'] ?? ''));

// ============================================================
// DATABASE CONNECTION
// ============================================================
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    error_log('DB connect error: ' . $mysqli->connect_error);
    sendMessage($chat_id, "⚠️ Sistem sedang gangguan. Mohon coba lagi beberapa saat.");
    exit;
}
$mysqli->set_charset('utf8mb4');

// ============================================================
// ROUTING
// ============================================================
if ($text === '/start') {
    handleStart($mysqli, $chat_id, $tg_name);
} elseif ($text === '/help' || $text === '/bantuan') {
    handleHelp($chat_id);
} else {
    handleAuth($mysqli, $chat_id, $text, $tg_user, $tg_name);
}

$mysqli->close();
http_response_code(200);
exit;

// ============================================================
// HANDLER: /start
// ============================================================
function handleStart($mysqli, $chat_id, $tg_name) {
    $greet  = "Halo " . htmlspecialchars($tg_name) . "! 👋\n\n";
    $greet .= "Saya bot resmi *Desa BRILiaN 2026* untuk mendistribusikan kredensial LMS Joglo Unsoed.\n\n";
    $greet .= "Untuk mengambil akun pelatihan, silakan kirim pesan dengan format:\n";
    $greet .= "<code>KodeDesa 4DigitTerakhirHpKades</code>\n\n";
    $greet .= "Contoh: <code>3303082019 2924</code>\n\n";
    $greet .= "Ketik /bantuan untuk info lebih lanjut.";
    sendMessage($chat_id, $greet);
}

// ============================================================
// HANDLER: /help
// ============================================================
function handleHelp($chat_id) {
    $help  = "📘 <b>Cara Pakai Bot</b>\n\n";
    $help .= "1. Kirim pesan: <code>KodeDesa 4DigitTerakhirHpKades</code>\n";
    $help .= "   Contoh: <code>3303082019 2924</code>\n\n";
    $help .= "2. Bot akan kirim username & password LMS Joglo Anda.\n\n";
    $help .= "3. Login di " . LMS_LOGIN_URL . "\n\n";
    $help .= "<b>Catatan:</b>\n";
    $help .= "• Kode Desa = 10 digit dari Kemendagri\n";
    $help .= "• 4 Digit HP = 4 angka terakhir nomor HP Kepala Desa\n";
    $help .= "• Maksimal " . RATE_LIMIT_MAX . " percobaan per jam\n\n";
    $help .= "Kontak panitia: " . WA_PANITIA_NAMA . " — https://wa.me/" . normalizeWA(WA_PANITIA_NOMOR);
    sendMessage($chat_id, $help);
}

// ============================================================
// HANDLER: AUTHENTICATION
// ============================================================
function handleAuth($mysqli, $chat_id, $text, $tg_user, $tg_name) {
    // Rate limit check dulu
    if (isRateLimited($mysqli, $chat_id)) {
        sendMessage($chat_id,
            "⛔ Anda sudah mencoba terlalu sering.\n\n" .
            "Silakan tunggu 1 jam, lalu coba lagi.\n" .
            "Jika butuh bantuan: " . WA_PANITIA_NAMA . " (https://wa.me/" . normalizeWA(WA_PANITIA_NOMOR) . ")"
        );
        return;
    }

    // Parse input: harus 2 token (kode desa + 4 digit)
    $parts = preg_split('/\s+/', $text);
    if (count($parts) !== 2) {
        sendMessage($chat_id,
            "❌ Format salah.\n\n" .
            "Kirim: <code>KodeDesa 4DigitTerakhirHpKades</code>\n" .
            "Contoh: <code>3303082019 2924</code>"
        );
        logAttempt($mysqli, $chat_id, $text, 'format_invalid');
        return;
    }

    $kode_desa = trim($parts[0]);
    $hp_last4  = trim($parts[1]);

    // Validasi format dasar
    if (!preg_match('/^\d{10}$/', $kode_desa)) {
        sendMessage($chat_id, "❌ Kode Desa harus 10 digit angka.\nContoh: <code>3303082019</code>");
        logAttempt($mysqli, $chat_id, $text, 'kode_invalid');
        return;
    }
    if (!preg_match('/^\d{4}$/', $hp_last4)) {
        sendMessage($chat_id, "❌ 4 digit HP harus 4 angka.\nContoh: <code>2924</code>");
        logAttempt($mysqli, $chat_id, $text, 'hp_invalid');
        return;
    }

    // Cek ke DB
    $stmt = $mysqli->prepare(
        "SELECT username, password, hp_last4, nama_desa, kecamatan, kabupaten
         FROM users
         WHERE username = ?
         LIMIT 1"
    );
    $stmt->bind_param('s', $kode_desa);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();

    if (!$row) {
        sendMessage($chat_id,
            "❌ Kode Desa <code>" . htmlspecialchars($kode_desa) . "</code> tidak terdaftar.\n\n" .
            "Pastikan kode desa benar (10 digit dari Kemendagri)."
        );
        logAttempt($mysqli, $chat_id, $text, 'kode_not_found');
        return;
    }

    // Cek hp_last4 — kalau di DB kosong, info & arahkan ke panitia
    if ($row['hp_last4'] === '' || $row['hp_last4'] === null) {
        sendMessage($chat_id,
            "⚠️ Data HP Kepala Desa untuk <b>Desa " . htmlspecialchars($row['nama_desa']) . "</b> belum lengkap di sistem.\n\n" .
            "Mohon hubungi panitia: " . WA_PANITIA_NAMA . " (https://wa.me/" . normalizeWA(WA_PANITIA_NOMOR) . ")"
        );
        logAttempt($mysqli, $chat_id, $text, 'hp_db_empty');
        return;
    }

    // Verifikasi 4 digit HP
    if (!hash_equals((string)$row['hp_last4'], $hp_last4)) {
        sendMessage($chat_id,
            "❌ 4 digit HP tidak cocok dengan data Kepala Desa <b>" . htmlspecialchars($row['nama_desa']) . "</b>.\n\n" .
            "Pastikan 4 digit terakhir nomor HP Kades benar."
        );
        logAttempt($mysqli, $chat_id, $text, 'hp_mismatch');
        return;
    }

    // SUCCESS — kirim template Brilian 2026
    $reply = buildWelcomeMessage($row);
    sendMessage($chat_id, $reply);
    logAttempt($mysqli, $chat_id, $text, 'success');
}

// ============================================================
// TEMPLATE PESAN BRILIAN 2026
// ============================================================
function buildWelcomeMessage($row) {
    $nama_desa = htmlspecialchars($row['nama_desa']);
    $kec       = htmlspecialchars($row['kecamatan']);
    $kab       = htmlspecialchars($row['kabupaten']);
    $username  = htmlspecialchars($row['username']);
    $password  = htmlspecialchars($row['password']);

    $msg  = "🎉 <b>Selamat Datang Peserta Desa BRILiaN 2026</b>\n";
    $msg .= "Desa <b>{$nama_desa}</b>\n";
    $msg .= "Kec. {$kec}, {$kab}\n\n";
    $msg .= "📅 <b>Kickoff:</b> " . KICKOFF_DATE . "\n";
    $msg .= "🔗 Join Zoom: " . ZOOM_LINK . "\n\n";
    $msg .= "🔐 <b>Akun LMS Joglo</b>\n";
    $msg .= "username: <code>{$username}</code>\n";
    $msg .= "password: <code>{$password}</code>\n";
    $msg .= "Login: " . LMS_LOGIN_URL . "\n\n";
    $msg .= "ℹ️ Info: " . WA_PANITIA_NAMA . " — https://wa.me/" . normalizeWA(WA_PANITIA_NOMOR) . "\n";
    $msg .= "👥 WA group peserta: " . WA_GROUP_LINK;

    return $msg;
}

// ============================================================
// RATE LIMIT
// ============================================================
function isRateLimited($mysqli, $chat_id) {
    $cutoff = date('Y-m-d H:i:s', time() - RATE_LIMIT_WIN);
    $stmt = $mysqli->prepare(
        "SELECT COUNT(*) FROM audit_log
         WHERE chat_id = ? AND ts >= ?"
    );
    $stmt->bind_param('ss', $chat_id, $cutoff);
    $stmt->execute();
    $stmt->bind_result($cnt);
    $stmt->fetch();
    $stmt->close();

    return $cnt >= RATE_LIMIT_MAX;
}

function logAttempt($mysqli, $chat_id, $input, $status) {
    $stmt = $mysqli->prepare(
        "INSERT INTO audit_log (chat_id, input_text, status, ts)
         VALUES (?, ?, ?, NOW())"
    );
    $input_safe = mb_substr($input, 0, 200);
    $stmt->bind_param('sss', $chat_id, $input_safe, $status);
    $stmt->execute();
    $stmt->close();
}

// ============================================================
// HELPERS
// ============================================================
function sendMessage($chat_id, $text) {
    $url = 'https://api.telegram.org/bot' . BOT_TOKEN . '/sendMessage';
    $data = [
        'chat_id'                  => $chat_id,
        'text'                     => $text,
        'parse_mode'               => 'HTML',
        'disable_web_page_preview' => true,
    ];
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query($data),
        CURLOPT_TIMEOUT        => 10,
    ]);
    $resp = curl_exec($ch);
    if ($resp === false) {
        error_log('Telegram sendMessage error: ' . curl_error($ch));
    }
    curl_close($ch);
}

/**
 * Konversi nomor WA Indonesia ke format internasional (62xxx)
 * untuk dipakai di link wa.me
 * - "081234567890" → "6281234567890"
 * - "+6281234567890" → "6281234567890"
 * - "6281234567890" → "6281234567890"
 */
function normalizeWA($nomor) {
    $n = preg_replace('/\D/', '', $nomor);
    if (substr($n, 0, 1) === '0') {
        $n = '62' . substr($n, 1);
    }
    return $n;
}
