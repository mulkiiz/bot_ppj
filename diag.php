<?php
/**
 * diag.php — Cek kesehatan setup bot.
 * Versi mysqli + bind_result (tanpa PDO, tanpa mysqlnd).
 * Buka: https://miz.jurnalsinta.id/diag.php
 * Setelah selesai, HAPUS file ini dari server.
 */

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header('Content-Type: text/plain; charset=utf-8');

echo "=== DIAGNOSTIK BOT BRILIAN 2026 ===\n\n";

// ---------------------------------------------------------------------
echo "[1] PHP version: " . PHP_VERSION . "\n";
echo "    PDO MySQL  : " . (extension_loaded('pdo_mysql') ? 'ada OK' : 'TIDAK ADA') . "\n";
echo "    MySQLi     : " . (extension_loaded('mysqli')    ? 'ada OK' : 'TIDAK ADA!') . "\n";
echo "    mysqlnd    : " . (extension_loaded('mysqlnd')   ? 'ada OK' : 'tidak ada (tidak masalah)') . "\n";
echo "    cURL       : " . (extension_loaded('curl')      ? 'ada OK' : 'TIDAK ADA!') . "\n";
echo "    OpenSSL    : " . (extension_loaded('openssl')   ? 'ada OK' : 'TIDAK ADA!') . "\n\n";

// ---------------------------------------------------------------------
echo "[2] File config.php: ";
if (!file_exists(__DIR__ . '/config.php')) {
    echo "TIDAK DITEMUKAN!\n"; exit;
}
echo "ada OK\n";
require __DIR__ . '/config.php';
echo "    BOT_TOKEN     : " . (empty($BOT_TOKEN) || strpos($BOT_TOKEN,'GANTI')===0 ? 'BELUM DIISI!' : 'terisi OK ('.substr($BOT_TOKEN,0,10).'...)') . "\n";
echo "    WEBHOOK_SECRET: " . (empty($WEBHOOK_SECRET) || strpos($WEBHOOK_SECRET,'GANTI')===0 ? 'BELUM DIISI!' : 'terisi OK ('.strlen($WEBHOOK_SECRET).' karakter)') . "\n";
echo "    DB_NAME       : $DB_NAME\n";
echo "    DB_USER       : $DB_USER\n\n";

// ---------------------------------------------------------------------
echo "[3] Koneksi MySQL (via mysqli): ";
$mysqli = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_error) {
    echo "GAGAL!\n    Error: " . $mysqli->connect_error . "\n"; exit;
}
$mysqli->set_charset('utf8mb4');
echo "berhasil OK\n\n";

// ---------------------------------------------------------------------
echo "[4] Tabel:\n";
foreach (['users','rate_limit','audit_log'] as $t) {
    $res = $mysqli->query("SELECT COUNT(*) AS c FROM $t");
    if ($res) {
        $r = $res->fetch_assoc();
        echo "    $t : ada OK ({$r['c']} baris)\n";
    } else {
        echo "    $t : TIDAK ADA - " . $mysqli->error . "\n";
    }
}
echo "\n";

// ---------------------------------------------------------------------
echo "[5] Cek user uji 1409082010:\n";
$stmt = $mysqli->prepare("SELECT username, password, hp_last4, nama_desa FROM users WHERE username = ?");
if (!$stmt) {
    echo "    GAGAL prepare: " . $mysqli->error . "\n\n";
} else {
    $uname = '1409082010';
    $stmt->bind_param('s', $uname);
    $stmt->execute();
    $stmt->bind_result($u_username, $u_password, $u_hp4, $u_desa);
    $found = $stmt->fetch();
    $stmt->close();
    if ($found) {
        echo "    Ditemukan OK\n";
        echo "    Password: $u_password\n";
        echo "    HP last4: $u_hp4\n";
        echo "    Desa    : $u_desa\n";
    } else {
        echo "    TIDAK DITEMUKAN!\n";
    }
    echo "\n";
}

// ---------------------------------------------------------------------
echo "[6] Konektivitas ke api.telegram.org (getMe):\n";
$ch = curl_init("https://api.telegram.org/bot$BOT_TOKEN/getMe");
curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER=>true, CURLOPT_TIMEOUT=>10]);
$resp = curl_exec($ch); $err = curl_error($ch); $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
if ($err) {
    echo "    GAGAL! cURL error: $err\n";
} else {
    $data = json_decode($resp, true);
    if (!empty($data['ok'])) {
        echo "    HTTP $code - berhasil OK\n";
        echo "    Bot @" . $data['result']['username'] . "\n";
    } else {
        echo "    HTTP $code - GAGAL!\n    Response: $resp\n";
    }
}
echo "\n";

// ---------------------------------------------------------------------
echo "[7] Status webhook di Telegram:\n";
$ch = curl_init("https://api.telegram.org/bot$BOT_TOKEN/getWebhookInfo");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$resp = curl_exec($ch); curl_close($ch);
$info = json_decode($resp, true);
if (!empty($info['ok'])) {
    $r = $info['result'];
    echo "    URL              : " . (!empty($r['url']) ? $r['url'] : '(KOSONG!)') . "\n";
    echo "    Pending updates  : " . (isset($r['pending_update_count']) ? $r['pending_update_count'] : 0) . "\n";
    if (!empty($r['last_error_date'])) {
        echo "    !! LAST ERROR    : " . date('Y-m-d H:i:s', $r['last_error_date']) . "\n";
        echo "    !! ERROR MESSAGE : " . (isset($r['last_error_message']) ? $r['last_error_message'] : '?') . "\n";
    } else {
        echo "    Last error       : (tidak ada) OK\n";
    }
}
echo "\n";

// ---------------------------------------------------------------------
echo "[8] Tes akses webhook.php:\n";
$scheme = !empty($_SERVER['HTTPS']) ? 'https' : 'http';
$dir    = rtrim(dirname($_SERVER['REQUEST_URI']), '/');
$url    = "$scheme://" . $_SERVER['HTTP_HOST'] . $dir . "/webhook.php";
$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 5,
    CURLOPT_CUSTOMREQUEST  => 'POST',
    CURLOPT_POSTFIELDS     => '{}',
]);
$resp = curl_exec($ch); $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo "    URL : $url\n";
echo "    HTTP: $code (harusnya 403 - tanpa secret token)\n";
echo "    Body: " . trim($resp) . "\n\n";

echo "=== SELESAI - hapus file diag.php setelah pakai ===\n";