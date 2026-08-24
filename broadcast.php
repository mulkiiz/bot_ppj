<?php
/**
 * BROADCAST TELEGRAM — New Desa BRILiaN 2026
 *
 * Disesuaikan dengan struktur audit_log existing:
 *   id, telegram_id, telegram_name, query_username, status, created_at
 *
 * CARA PAKAI:
 *   - DRY RUN  : https://miz.jurnalsinta.id/broadcast.php?secret=XXX&mode=dry
 *   - LIVE     : https://miz.jurnalsinta.id/broadcast.php?secret=XXX&mode=live
 *   - STATS    : https://miz.jurnalsinta.id/broadcast.php?secret=XXX&mode=stats
 *
 * ⚠️ HAPUS atau chmod 600 setelah broadcast selesai.
 */

set_time_limit(0);
ignore_user_abort(false);
header('Content-Type: text/plain; charset=utf-8');

// ============================================================
// KONSTANTA
// ============================================================
const BOT_TOKEN         = 'YOUR_BOT_TOKEN';
const BROADCAST_SECRET  = 'YOUR_BROADCAST_SECRET';

const DB_HOST           = 'localhost';
const DB_USER           = 'YOUR_DB_USER';
const DB_PASS           = 'YOUR_DB_PASSWORD';
const DB_NAME           = 'YOUR_DB_NAME';

const SLEEP_MS_PER_MSG  = 50;     // 50ms = 20 msg/detik

// Info acara — final
const KICKOFF_DATE      = 'Kamis, 7 Mei 2026';
const KICKOFF_REG       = '08.00 WIB';
const KICKOFF_START     = '09.00 – 12.00 WIB';
const ZOOM_LINK         = 'bit.ly/KickoffDesaBrilian2026';
const LMS_LOGIN_URL     = 'https://joglo.unsoed.ac.id/login/index.php';
const WA_PANITIA_NAMA   = 'Tri Wahyu';
const WA_PANITIA_NOMOR  = '087887650978';
const WA_GROUP_LINK     = 'https://chat.whatsapp.com/H5hycX2YeUz7IEWAHZ8cJf';

// ============================================================
// AUTH
// ============================================================
$secret = $_GET['secret'] ?? '';
if (!hash_equals(BROADCAST_SECRET, $secret)) {
    http_response_code(403);
    exit("Forbidden\n");
}
$mode = $_GET['mode'] ?? 'dry';

// ============================================================
// DB
// ============================================================
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    exit("DB error: " . $mysqli->connect_error . "\n");
}
$mysqli->set_charset('utf8mb4');

$mysqli->query("
    CREATE TABLE IF NOT EXISTS broadcast_log (
        id INT AUTO_INCREMENT PRIMARY KEY,
        telegram_id VARCHAR(32) NOT NULL,
        username VARCHAR(20),
        status VARCHAR(20),
        response TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        INDEX(telegram_id),
        INDEX(status),
        INDEX(created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");

// ============================================================
// MODE: stats
// ============================================================
if ($mode === 'stats') {
    echo "=== STATISTIK BROADCAST ===\n\n";
    $r = $mysqli->query("SELECT status, COUNT(*) AS n FROM broadcast_log GROUP BY status ORDER BY n DESC");
    while ($row = $r->fetch_assoc()) {
        printf("%-15s : %d\n", $row['status'], $row['n']);
    }

    echo "\n=== ERROR TERAKHIR (10) ===\n";
    $r = $mysqli->query("
        SELECT telegram_id, username, response, created_at FROM broadcast_log
        WHERE status != 'success' ORDER BY id DESC LIMIT 10
    ");
    while ($row = $r->fetch_assoc()) {
        printf("[%s] telegram_id=%s user=%s -- %s\n",
               $row['created_at'], $row['telegram_id'], $row['username'], $row['response']);
    }
    exit;
}

// ============================================================
// AMBIL TARGET
// Strategi: ambil 1 baris terakhir (created_at MAX) per telegram_id
// yang status='success', lalu join ke users via query_username.
// ============================================================
$sql_targets = "
    SELECT
        a.telegram_id,
        a.query_username,
        u.username,
        u.password,
        u.nama_desa,
        u.kecamatan,
        u.kabupaten
    FROM audit_log a
    INNER JOIN (
        SELECT telegram_id, MAX(created_at) AS last_at
        FROM audit_log
        WHERE status = 'success'
        GROUP BY telegram_id
    ) latest
        ON latest.telegram_id = a.telegram_id
       AND latest.last_at     = a.created_at
    INNER JOIN users u ON u.username = a.query_username
    WHERE a.status = 'success'
    GROUP BY a.telegram_id
";

$res = $mysqli->query($sql_targets);
if (!$res) {
    exit("Query error: " . $mysqli->error . "\n");
}

$targets = [];
while ($row = $res->fetch_assoc()) {
    $targets[] = $row;
}
$total = count($targets);

echo "=== BROADCAST TELEGRAM — New Desa BRILiaN 2026 ===\n";
echo "Mode      : " . strtoupper($mode) . "\n";
echo "Target    : {$total} telegram_id\n";
echo "Throttle  : " . SLEEP_MS_PER_MSG . "ms / message\n";
echo "Estimasi  : " . round($total * SLEEP_MS_PER_MSG / 1000) . " detik\n";
echo str_repeat('-', 50) . "\n\n";

if ($total === 0) {
    exit("Tidak ada target. Pastikan ada audit_log dengan status='success'.\n");
}

if ($mode === 'dry') {
    echo "*** DRY RUN — tidak ada pesan dikirim ***\n\n";
    echo "Sample 5 target pertama:\n";
    foreach (array_slice($targets, 0, 5) as $i => $t) {
        echo "  " . ($i+1) . ". telegram_id={$t['telegram_id']} | {$t['username']} | Desa {$t['nama_desa']}\n";
    }
    echo "\n=== PREVIEW PESAN ===\n";
    echo buildBroadcastMessage($targets[0]) . "\n";
    echo "\n=================================\n";
    echo "Untuk live broadcast: ganti mode=dry jadi mode=live\n";
    exit;
}

if ($mode !== 'live') {
    exit("Mode tidak valid. Pakai: dry, live, atau stats.\n");
}

// ============================================================
// LIVE BROADCAST
// ============================================================
$stmt_log = $mysqli->prepare("
    INSERT INTO broadcast_log (telegram_id, username, status, response) VALUES (?, ?, ?, ?)
");

$ok = 0; $fail = 0; $skip = 0;
$start = microtime(true);

foreach ($targets as $i => $t) {
    $telegram_id = $t['telegram_id'];
    $username    = $t['username'];

    // Idempotent: skip kalau sudah pernah sukses
    $check = $mysqli->prepare("
        SELECT 1 FROM broadcast_log WHERE telegram_id = ? AND status = 'success' LIMIT 1
    ");
    $check->bind_param('s', $telegram_id);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $skip++;
        $check->close();
        printf("[%4d/%d] SKIP   %s (sudah pernah)\n", $i+1, $total, $username);
        continue;
    }
    $check->close();

    $msg = buildBroadcastMessage($t);
    [$success, $response] = sendTelegram($telegram_id, $msg);

    $status = $success ? 'success' : 'failed';
    $stmt_log->bind_param('ssss', $telegram_id, $username, $status, $response);
    $stmt_log->execute();

    if ($success) {
        $ok++;
        printf("[%4d/%d] OK     %s -> telegram_id=%s\n", $i+1, $total, $username, $telegram_id);
    } else {
        $fail++;
        printf("[%4d/%d] FAIL   %s -> %s\n", $i+1, $total, $username, $response);
    }

    @ob_flush(); @flush();
    usleep(SLEEP_MS_PER_MSG * 1000);
}

$elapsed = round(microtime(true) - $start, 1);

echo "\n" . str_repeat('=', 50) . "\n";
echo "SELESAI dalam {$elapsed} detik\n";
echo "  Sukses : {$ok}\n";
echo "  Gagal  : {$fail}\n";
echo "  Skip   : {$skip}\n";
echo "  Total  : {$total}\n";
echo "\nCek detail: ?mode=stats\n";

// ============================================================
// FUNCTIONS
// ============================================================
function buildBroadcastMessage($t) {
    $msg  = "📢 *INFO PENTING — New Desa BRILiaN 2026*\n\n";
    $msg .= "🎉 Selamat Datang Peserta New Desa BRILiaN 2026\n";
    $msg .= "Desa *{$t['nama_desa']}*\n";
    $msg .= "Kec. {$t['kecamatan']}, {$t['kabupaten']}\n\n";
    $msg .= "📅 *KICK-OFF BATCH 1*\n";
    $msg .= "_\"Desa 5.0: Sinergi Teknologi dan Human-Centered Leadership dalam Membangun Future Village Ecosystem yang Berdaya serta Berkelanjutan\"_\n\n";
    $msg .= "🗓 " . KICKOFF_DATE . "\n";
    $msg .= "⏰ Registrasi: " . KICKOFF_REG . "\n";
    $msg .= "⏰ Acara: " . KICKOFF_START . "\n";
    $msg .= "🔗 Join Zoom: " . ZOOM_LINK . "\n\n";
    $msg .= "🔐 *Akun LMS Joglo*\n";
    $msg .= "username: `{$t['username']}`\n";
    $msg .= "password: `{$t['password']}`\n";
    $msg .= "Login: " . LMS_LOGIN_URL . "\n\n";
    $msg .= "ℹ️ Info: " . WA_PANITIA_NAMA . " — https://wa.me/" . normalizeWA(WA_PANITIA_NOMOR) . "\n";
    $msg .= "👥 WA group peserta: " . WA_GROUP_LINK;
    return $msg;
}

function sendTelegram($chat_id, $text) {
    $url = 'https://api.telegram.org/bot' . BOT_TOKEN . '/sendMessage';
    $data = [
        'chat_id'                  => $chat_id,
        'text'                     => $text,
        'parse_mode'               => 'Markdown',
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
    $err  = curl_error($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($resp === false) {
        return [false, "curl_error: {$err}"];
    }

    $j = json_decode($resp, true);
    if (!empty($j['ok'])) {
        return [true, "http_{$http}"];
    }

    $desc = $j['description'] ?? 'unknown';
    return [false, "http_{$http}: {$desc}"];
}

function normalizeWA($nomor) {
    $n = preg_replace('/\D/', '', $nomor);
    if (substr($n, 0, 1) === '0') {
        $n = '62' . substr($n, 1);
    }
    return $n;
}
