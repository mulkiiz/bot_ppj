<?php
/**
 * Konfigurasi Bot Brilian 2026 — TEMPLATE.
 * Copy file ini jadi config.php, lalu isi nilai asli.
 * config.php TIDAK boleh dipush ke git (sudah di .gitignore).
 */

// --- Database MySQL ---
$DB_HOST = 'localhost';
$DB_NAME = 'YOUR_DB_NAME';
$DB_USER = 'YOUR_DB_USER';
$DB_PASS = 'YOUR_DB_PASSWORD';

// --- Telegram ---
// Dapatkan token dari @BotFather di Telegram
$BOT_TOKEN = 'YOUR_BOT_TOKEN';

// Secret webhook — harus sama saat set webhook & saat verify.
// Generate: php myrandom.php  (bin2hex(random_bytes(16)))
$WEBHOOK_SECRET = 'YOUR_WEBHOOK_SECRET';

// --- Rate limit ---
$RATE_LIMIT_PER_HOUR = 5;   // maks query per jam per Telegram user

// --- Admin (opsional, untuk command /stats) ---
// Telegram user ID admin (dapatkan dari @userinfobot)
$ADMIN_TELEGRAM_IDS = [
    // 123456789,
];
