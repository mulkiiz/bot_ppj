<?php
/**
 * EMAIL BLAST — New Desa BRILiaN 2026
 *
 * Standalone script untuk blast email ke 456 desa via SMTP cPanel
 * (editor@jurnalsinta.id).
 *
 * CARA PAKAI:
 *   1. Pastikan PHPMailer sudah di /miz.jurnalsinta.id/PHPMailer/src/
 *   2. Pastikan poster & PDF sudah di /miz.jurnalsinta.id/assets/
 *   3. Edit konstanta DB_PASS dan SMTP_PASSWORD
 *   4. Akses via browser:
 *        - DRY RUN  : ?secret=brilian2026rahasia&mode=dry
 *        - TEST 1   : ?secret=brilian2026rahasia&mode=test&to=email_anda@gmail.com
 *        - LIVE     : ?secret=brilian2026rahasia&mode=live
 *        - STATS    : ?secret=brilian2026rahasia&mode=stats
 *
 * ⚠️ SETELAH SELESAI: HAPUS FILE INI atau rename jadi nama acak.
 */

set_time_limit(0);
ignore_user_abort(false);
header('Content-Type: text/plain; charset=utf-8');

// ============================================================
// LOAD PHPMailer
// ============================================================
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ============================================================
// KONSTANTA — EDIT DI SINI
// ============================================================
const BLAST_SECRET      = 'YOUR_BLAST_SECRET';

// SMTP cPanel
const SMTP_HOST         = 'mail.jurnalsinta.id';
const SMTP_PORT         = 465;                            // SSL: 465, TLS: 587
const SMTP_SECURE       = 'ssl';                          // 'ssl' atau 'tls'
const SMTP_USERNAME     = 'you@yourdomain.tld';
const SMTP_PASSWORD     = 'YOUR_SMTP_PASSWORD';   // password email cPanel

// Sender info
const FROM_EMAIL        = 'editor@jurnalsinta.id';
const FROM_NAME         = 'Panitia Desa BRILiaN 2026';
const REPLY_TO_EMAIL    = 'editor@jurnalsinta.id';
const REPLY_TO_NAME     = 'Panitia Desa BRILiaN 2026';

// Database
const DB_HOST           = 'localhost';
const DB_USER           = 'YOUR_DB_USER';
const DB_PASS           = 'YOUR_DB_PASSWORD';
const DB_NAME           = 'YOUR_DB_NAME';

// Throttle: 5 detik antar email = 720 email/jam (aman untuk cPanel)
const SLEEP_PER_EMAIL_S = 5;

// Lampiran
const POSTER_PATH       = __DIR__ . '/assets/poster_brilian2026.jpg';
const PDF_PATH          = __DIR__ . '/assets/undangan_brilian2026.pdf';

// Info acara
const KICKOFF_DATE      = 'Kamis, 7 Mei 2026';
const KICKOFF_REG       = '08.00 WIB';
const KICKOFF_START     = '09.00 – 12.00 WIB';
const ZOOM_LINK_FULL    = 'https://bit.ly/KickoffDesaBrilian2026';
const LMS_LOGIN_URL     = 'https://joglo.unsoed.ac.id/login/index.php';
const WA_PANITIA_NAMA   = 'Tri Wahyu';
const WA_PANITIA_NOMOR  = '087887650978';
const WA_GROUP_LINK     = 'https://chat.whatsapp.com/H5hycX2YeUz7IEWAHZ8cJf';

const EMAIL_SUBJECT     = 'Undangan Kickoff New Desa BRILiaN 2026 — Kamis, 7 Mei 2026';

// ============================================================
// AUTH
// ============================================================
$secret = $_GET['secret'] ?? '';
if (!hash_equals(BLAST_SECRET, $secret)) {
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
    CREATE TABLE IF NOT EXISTS email_blast_log (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(120) NOT NULL,
        username VARCHAR(20),
        nama_desa VARCHAR(120),
        status VARCHAR(20),
        response TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        INDEX(email),
        INDEX(status),
        INDEX(created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");

// Tambah tabel cache email Kades (dari Excel) supaya tidak perlu re-import
$mysqli->query("
    CREATE TABLE IF NOT EXISTS email_recipients (
        username VARCHAR(20) PRIMARY KEY,
        email VARCHAR(120) NOT NULL,
        nama_desa VARCHAR(120),
        kecamatan VARCHAR(120),
        kabupaten VARCHAR(120),
        provinsi VARCHAR(120),
        INDEX(email)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");

// ============================================================
// MODE: stats
// ============================================================
if ($mode === 'stats') {
    echo "=== STATISTIK EMAIL BLAST ===\n\n";
    $r = $mysqli->query("SELECT status, COUNT(*) AS n FROM email_blast_log GROUP BY status ORDER BY n DESC");
    while ($row = $r->fetch_assoc()) {
        printf("%-15s : %d\n", $row['status'], $row['n']);
    }

    echo "\n=== ERROR TERAKHIR (10) ===\n";
    $r = $mysqli->query("
        SELECT email, nama_desa, response, created_at FROM email_blast_log
        WHERE status != 'success' ORDER BY id DESC LIMIT 10
    ");
    while ($row = $r->fetch_assoc()) {
        printf("[%s] %s (%s) -- %s\n",
               $row['created_at'], $row['email'], $row['nama_desa'], $row['response']);
    }
    exit;
}

// ============================================================
// AMBIL TARGET dari email_recipients
// Kalau tabel kosong, perlu di-import dulu (lihat instruksi)
// ============================================================
$res = $mysqli->query("SELECT COUNT(*) AS n FROM email_recipients");
$count_recipients = (int)$res->fetch_assoc()['n'];

if ($count_recipients === 0) {
    echo "❌ Tabel email_recipients masih kosong.\n\n";
    echo "Anda harus import data dulu via phpMyAdmin:\n";
    echo "1. Buka phpMyAdmin → DB jurz2196_brilian_bot\n";
    echo "2. Pilih tabel email_recipients → tab Import\n";
    echo "3. Upload file CSV: brevo_contacts_brilian2026.csv\n";
    echo "   (CSV yang sudah saya generate sebelumnya)\n";
    echo "4. Format: CSV, separator: koma, enclosed: \"\n";
    echo "5. Centang 'first line of file contains column names'\n";
    echo "6. Klik Import\n\n";
    echo "Setelah import, jalankan ulang script ini.\n";
    exit;
}

$res = $mysqli->query("
    SELECT username, email, nama_desa, kecamatan, kabupaten, provinsi
    FROM email_recipients
    ORDER BY username
");
$targets = [];
while ($row = $res->fetch_assoc()) {
    // Lookup password dari tabel users
    $stmt = $mysqli->prepare("SELECT password FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param('s', $row['username']);
    $stmt->execute();
    $pw_row = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $row['password'] = $pw_row['password'] ?? '';
    $targets[] = $row;
}
$total = count($targets);

echo "=== EMAIL BLAST — New Desa BRILiaN 2026 ===\n";
echo "Mode      : " . strtoupper($mode) . "\n";
echo "Target    : {$total} alamat email\n";
echo "Throttle  : " . SLEEP_PER_EMAIL_S . " detik / email\n";
echo "Estimasi  : " . round($total * SLEEP_PER_EMAIL_S / 60, 1) . " menit\n";
echo str_repeat('-', 50) . "\n\n";

// Cek lampiran ada/tidak
if (!file_exists(POSTER_PATH)) {
    exit("❌ File poster tidak ditemukan: " . POSTER_PATH . "\n");
}
if (!file_exists(PDF_PATH)) {
    exit("❌ File PDF tidak ditemukan: " . PDF_PATH . "\n");
}
echo "✓ Poster   : " . round(filesize(POSTER_PATH)/1024) . " KB\n";
echo "✓ PDF      : " . round(filesize(PDF_PATH)/1024) . " KB\n\n";

// ============================================================
// MODE: dry
// ============================================================
if ($mode === 'dry') {
    echo "*** DRY RUN — tidak ada email dikirim ***\n\n";
    echo "Sample 5 target pertama:\n";
    foreach (array_slice($targets, 0, 5) as $i => $t) {
        echo "  " . ($i+1) . ". {$t['email']} — Desa {$t['nama_desa']} ({$t['username']})\n";
    }
    echo "\nUntuk test 1 email ke alamat Anda: ?mode=test&to=email_anda@gmail.com\n";
    echo "Untuk live blast: ?mode=live\n";
    exit;
}

// ============================================================
// MODE: test (kirim 1 email ke alamat tertentu)
// ============================================================
if ($mode === 'test') {
    $test_to = $_GET['to'] ?? '';
    if (!filter_var($test_to, FILTER_VALIDATE_EMAIL)) {
        exit("❌ Parameter 'to' kosong atau bukan email valid.\n" .
             "Contoh: ?mode=test&to=email_anda@gmail.com\n");
    }

    echo "📧 Mengirim test email ke: {$test_to}\n";
    echo "    (memakai data desa pertama sebagai contoh)\n\n";

    $sample = $targets[0];
    $sample['email'] = $test_to;  // override email tujuan

    [$ok, $resp] = sendEmail($sample);
    echo $ok ? "✅ BERHASIL: {$resp}\n" : "❌ GAGAL: {$resp}\n";
    echo "\nCek inbox (& folder Spam) di {$test_to}\n";
    exit;
}

// ============================================================
// MODE: live
// ============================================================
if ($mode !== 'live') {
    exit("Mode tidak valid. Pakai: dry, test, live, atau stats.\n");
}

echo "🚀 LIVE BLAST DIMULAI...\n";
echo "(Total durasi: ~" . round($total * SLEEP_PER_EMAIL_S / 60) . " menit)\n";
echo "(Jangan tutup browser sampai selesai!)\n\n";

$stmt_log = $mysqli->prepare("
    INSERT INTO email_blast_log (email, username, nama_desa, status, response)
    VALUES (?, ?, ?, ?, ?)
");

$ok = 0; $fail = 0; $skip = 0;
$start = microtime(true);

foreach ($targets as $i => $t) {
    $email     = $t['email'];
    $username  = $t['username'];
    $nama_desa = $t['nama_desa'];

    // Idempotent: skip kalau sudah pernah sukses
    $check = $mysqli->prepare("
        SELECT 1 FROM email_blast_log WHERE email = ? AND status = 'success' LIMIT 1
    ");
    $check->bind_param('s', $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $skip++;
        $check->close();
        printf("[%4d/%d] SKIP   %s (sudah pernah)\n", $i+1, $total, $email);
        continue;
    }
    $check->close();

    [$success, $response] = sendEmail($t);

    $status = $success ? 'success' : 'failed';
    $stmt_log->bind_param('sssss', $email, $username, $nama_desa, $status, $response);
    $stmt_log->execute();

    if ($success) {
        $ok++;
        printf("[%4d/%d] OK     %s — Desa %s\n", $i+1, $total, $email, $nama_desa);
    } else {
        $fail++;
        printf("[%4d/%d] FAIL   %s — %s\n", $i+1, $total, $email, $response);
    }

    @ob_flush(); @flush();
    sleep(SLEEP_PER_EMAIL_S);
}

$elapsed = round(microtime(true) - $start, 1);

echo "\n" . str_repeat('=', 50) . "\n";
echo "SELESAI dalam {$elapsed} detik (" . round($elapsed/60,1) . " menit)\n";
echo "  Sukses : {$ok}\n";
echo "  Gagal  : {$fail}\n";
echo "  Skip   : {$skip}\n";
echo "  Total  : {$total}\n";
echo "\nCek detail: ?mode=stats\n";

// ============================================================
// FUNCTIONS
// ============================================================
function sendEmail($t) {
    $mail = new PHPMailer(true);
    try {
        // SMTP setup
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USERNAME;
        $mail->Password   = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Port       = SMTP_PORT;
        $mail->CharSet    = 'UTF-8';
        $mail->Timeout    = 30;

        // Sender
        $mail->setFrom(FROM_EMAIL, FROM_NAME);
        $mail->addReplyTo(REPLY_TO_EMAIL, REPLY_TO_NAME);

        // Recipient
        $mail->addAddress($t['email']);

        // Embed poster (inline image)
        $mail->addEmbeddedImage(POSTER_PATH, 'poster_brilian', 'poster_brilian2026.jpg');

        // Attach PDF
        $mail->addAttachment(PDF_PATH, 'Undangan_Kickoff_DesaBRILiaN2026.pdf');

        // Content
        $mail->isHTML(true);
        $mail->Subject = EMAIL_SUBJECT;
        $mail->Body    = buildEmailHTML($t);
        $mail->AltBody = buildEmailPlainText($t);

        $mail->send();
        return [true, "ok"];
    } catch (Exception $e) {
        return [false, $mail->ErrorInfo ?: $e->getMessage()];
    }
}

function buildEmailHTML($t) {
    $nama_desa = htmlspecialchars($t['nama_desa']);
    $kec       = htmlspecialchars($t['kecamatan']);
    $kab       = htmlspecialchars($t['kabupaten']);
    $prov      = htmlspecialchars($t['provinsi']);
    $username  = htmlspecialchars($t['username']);
    $password  = htmlspecialchars($t['password']);
    $wa_intl   = normalizeWA(WA_PANITIA_NOMOR);
    $ENV_ZOOM  = ZOOM_LINK_FULL;
    $ENV_LMS   = LMS_LOGIN_URL;
    $ENV_WAGRP = WA_GROUP_LINK;

    return <<<HTML
<!DOCTYPE html>
<html lang="id">
<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;color:#333;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f4f6f8;">
<tr><td align="center" style="padding:24px 12px;">
<table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.06);">

<tr><td style="background:#003d7a;padding:24px;text-align:center;">
<h1 style="margin:0;color:#ffffff;font-size:22px;">🎉 New Desa BRILiaN 2026</h1>
<p style="margin:8px 0 0 0;color:#cfe2ff;font-size:14px;">BRI × Universitas Jenderal Soedirman</p>
</td></tr>

<tr><td style="padding:0;">
<img src="cid:poster_brilian" alt="Poster Kickoff Desa BRILiaN 2026" style="display:block;width:100%;height:auto;max-width:600px;">
</td></tr>

<tr><td style="padding:28px 28px 12px 28px;">
<p style="margin:0 0 10px 0;font-size:16px;">Yth. Kepala Desa <strong>{$nama_desa}</strong>,</p>
<p style="margin:0;font-size:14px;color:#555;">Kec. {$kec}, {$kab}, {$prov}</p>
</td></tr>

<tr><td style="padding:8px 28px;font-size:15px;line-height:1.7;color:#333;">
<p>Apakah Anda ingin agar Desa Anda bukan lagi sekadar cerita masa lalu?<br>
Apakah Anda ingin agar Desa Anda menjadi pusat masa depan Indonesia?</p>
<p>Mari bergerak bersama menuju <strong>Desa 5.0</strong> — sinergi teknologi dan <em>human-centered leadership</em> untuk membangun ekosistem desa yang mandiri & berkelanjutan.</p>
<p>Kami mengundang Bapak/Ibu Kepala Desa untuk hadir dalam acara <strong>Kick-Off New Desa BRILiaN 2026 — Batch 1</strong>, kerjasama LPPM Universitas Jenderal Soedirman dengan PT. Bank Rakyat Indonesia (Persero), Tbk.</p>
</td></tr>

<tr><td style="padding:12px 28px;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#fff8e1;border-left:4px solid #ffa000;border-radius:4px;">
<tr><td style="padding:16px 18px;">
<p style="margin:0 0 8px 0;font-size:13px;color:#7a5800;font-weight:bold;text-transform:uppercase;">📅 Jadwal Kickoff</p>
<p style="margin:0 0 4px 0;font-size:17px;font-weight:bold;color:#1a1a1a;">Kamis, 7 Mei 2026</p>
<p style="margin:0 0 4px 0;font-size:14px;color:#555;">⏰ Registrasi 08.00 WIB | Acara 09.00 – 12.00 WIB</p>
<p style="margin:0;font-size:14px;color:#555;">🔗 Live via Zoom: <a href="{$ENV_ZOOM}" style="color:#003d7a;">bit.ly/KickoffDesaBrilian2026</a></p>
</td></tr></table>
</td></tr>

<tr><td style="padding:8px 28px 16px 28px;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#e8f5e9;border-left:4px solid #43a047;border-radius:4px;">
<tr><td style="padding:16px 18px;">
<p style="margin:0 0 10px 0;font-size:13px;color:#2e7d32;font-weight:bold;text-transform:uppercase;">🔐 Akun LMS Joglo Anda</p>
<p style="margin:0 0 4px 0;font-size:14px;"><strong>Username:</strong> <code style="background:#fff;padding:3px 8px;border-radius:3px;font-family:'Courier New',monospace;">{$username}</code></p>
<p style="margin:0 0 10px 0;font-size:14px;"><strong>Password:</strong> <code style="background:#fff;padding:3px 8px;border-radius:3px;font-family:'Courier New',monospace;">{$password}</code></p>
<p style="margin:0;font-size:13px;color:#555;">🌐 Login: <a href="{$ENV_LMS}" style="color:#003d7a;">joglo.unsoed.ac.id</a></p>
</td></tr></table>
</td></tr>

<tr><td align="center" style="padding:8px 28px 24px 28px;">
<a href="{$ENV_ZOOM}" style="display:inline-block;background:#003d7a;color:#ffffff;text-decoration:none;padding:14px 32px;border-radius:6px;font-size:16px;font-weight:bold;">Join Zoom Kickoff →</a>
</td></tr>

<tr><td style="padding:0 28px 16px 28px;">
<p style="margin:0;padding:12px 16px;background:#f5f5f5;border-radius:4px;font-size:13px;color:#555;">
📎 <strong>Undangan resmi LPPM Unsoed</strong> dalam format PDF terlampir pada email ini.
</p>
</td></tr>

<tr><td style="padding:8px 28px 24px 28px;border-top:1px solid #eee;">
<p style="margin:12px 0 6px 0;font-size:13px;color:#666;"><strong>Kontak Panitia:</strong></p>
<p style="margin:0 0 4px 0;font-size:14px;">👤 Tri Wahyu — <a href="https://wa.me/{$wa_intl}" style="color:#003d7a;">WhatsApp</a></p>
<p style="margin:0;font-size:14px;">👥 Grup WhatsApp Peserta: <a href="{$ENV_WAGRP}" style="color:#003d7a;">Klik untuk bergabung</a></p>
</td></tr>

<tr><td style="background:#f8f9fa;padding:18px 28px;text-align:center;border-top:1px solid #eee;">
<p style="margin:0;font-size:11px;color:#aaa;">© 2026 LPPM Universitas Jenderal Soedirman × PT. Bank Rakyat Indonesia (Persero), Tbk.</p>
</td></tr>

</table></td></tr></table>
</body></html>
HTML;
}

function buildEmailPlainText($t) {
    $msg  = "🎉 SELAMAT DATANG PESERTA NEW DESA BRILiaN 2026\n";
    $msg .= "Desa {$t['nama_desa']}\n";
    $msg .= "Kec. {$t['kecamatan']}, {$t['kabupaten']}, {$t['provinsi']}\n\n";
    $msg .= "KICK-OFF BATCH 1\n";
    $msg .= "\"Desa 5.0: Sinergi Teknologi dan Human-Centered Leadership\"\n\n";
    $msg .= "Hari/Tanggal : " . KICKOFF_DATE . "\n";
    $msg .= "Registrasi   : " . KICKOFF_REG . "\n";
    $msg .= "Acara        : " . KICKOFF_START . "\n";
    $msg .= "Zoom         : " . ZOOM_LINK_FULL . "\n\n";
    $msg .= "AKUN LMS JOGLO\n";
    $msg .= "Username : {$t['username']}\n";
    $msg .= "Password : {$t['password']}\n";
    $msg .= "Login    : " . LMS_LOGIN_URL . "\n\n";
    $msg .= "Info: " . WA_PANITIA_NAMA . " — https://wa.me/" . normalizeWA(WA_PANITIA_NOMOR) . "\n";
    $msg .= "Grup WA Peserta: " . WA_GROUP_LINK . "\n\n";
    $msg .= "Undangan resmi LPPM Unsoed terlampir pada email ini.";
    return $msg;
}

function normalizeWA($nomor) {
    $n = preg_replace('/\D/', '', $nomor);
    if (substr($n, 0, 1) === '0') {
        $n = '62' . substr($n, 1);
    }
    return $n;
}
