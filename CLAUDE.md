# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

**Agen Harian PPJ — LPPM Unsoed**: a single PHP cron script that assembles a **daily morning briefing** and sends it to Telegram. It has no framework, no build step, and no test suite — one standalone script plus config and data. Comments and user-facing strings are in Indonesian.

The entire runtime is [`cron/agen_harian.php`](cron/agen_harian.php). Everything else supports it. Deeper module/config notes live in [`cron/AGEN_HARIAN.md`](cron/AGEN_HARIAN.md) — read it before changing the agent.

## Runtime & deployment

- **Target host:** cPanel shared hosting, **PHP 7.4** (`ea-php74`, pinned in `.htaccess`). Local dev is XAMPP under `C:\xampp\htdocs\botppj` (MariaDB 10.4, `mysql -uroot` no password).
- **Cron:** runs daily 07:00 WIB. Production path `/home/jurz2196/public_html/ppj/cron/agen_harian.php`.
- **cURL** for all outbound HTTP (Telegram + data sources), with CA bundle `includes/cacert.pem` (relative `../includes/cacert.pem`, overridable via `CA_BUNDLE_PATH`).
- **`mysqli` only** — assume **no mysqlnd**. The jadwal query uses `bind_param` + `bind_result` (not `get_result`) for that reason. Keep new DB code in that style.

## How to run

```bash
# Preview locally — renders the message, does NOT send to Telegram
C:\xampp\php\php.exe cron/agen_harian.php preview

# Real send — delivers to TELEGRAM_CHAT_ID
C:\xampp\php\php.exe cron/agen_harian.php

# Browser (on server): with CRON_SECRET
#   https://<host>/cron/agen_harian.php?key=<CRON_SECRET>[&preview=1]
```

**`preview` mode** is the key dev affordance: it skips `kirim_telegram()`, prints the assembled HTML, and does not fatal when the (normally mandatory) kurs module fails — so you can inspect output without spamming Telegram.

## Architecture

`agen_harian.php` is procedural, organized as numbered modules. Each `ambil_*()` / `cek_*()` gathers one section (returns `null` on failure → rendered as "data tidak tersedia"), then `bangun_pesan()` assembles the Telegram HTML and `kirim_telegram()` sends it. Only **kurs is mandatory** (its failure aborts the run and sends an error notice); every other module is best-effort.

| Module | Source | Notes |
|--------|--------|-------|
| 1 Kurs USD/IDR | `open.er-api.com` | **mandatory** |
| 2 Emas Dunia (XAU) | `goldapi.io` | needs `GOLD_API_KEY` |
| 3 Emas Galeri24 | scrape `galeri24.co.id` | dumps `galeri24_raw.html` on parse-fail |
| 4 Status Jurnal | `cek_host()` over `jos.unsoed.ac.id` + `jurnal.unsoed.ac.id` | reachability + judol-keyword scan; hosts listed in the execution block |
| 6 Catatan Ekonomi | Groq LLM | needs `GROQ_API_KEY`; only facts, no advice |
| 7 Jadwal Kuliah | **MySQL `jadwal_kuliah`** | reminder of today's classes, grouped per prodi |

(Module 5 was a World Cup section, since removed.)

To **add a host** to the status check, extend the `$hosts` array in the execution block. To **add a section** to the message, add its render into `bangun_pesan()` and wire the data fetch in the `try` block.

## Database (jadwal kuliah)

Only module 7 touches a DB. Schema + seed: [`cron/sql/jadwal_kuliah.sql`](cron/sql/jadwal_kuliah.sql).

```bash
mysql -u<user> -p <db> < cron/sql/jadwal_kuliah.sql
```

The seed is regenerated from an instructor's `jadwal mengajar.xlsx` (columns → `kodemk, namamk, prodi, kelas, hari, kapasitas, terisi, ruang, jam_mulai, jam_selesai`). `hari` is an uppercase Indonesian ENUM (`SENIN`…`MINGGU`); the query filters on today. Rendering helpers in the script: `label_prodi()` (adds S1/S2), `ringkas_ruang()` (`GEDUNG TEKNIK C 101` → `C101`), `icon_mk()` (per-course emoji).

## Secrets & config

`cron/config.agen.php` holds all secrets and is **gitignored** — copy the template and fill real values:

```bash
cp cron/config.agen.example.php cron/config.agen.php
```

Keys: `GROQ_API_KEY`, `GOLD_API_KEY`, `TELEGRAM_BOT_TOKEN`, `TELEGRAM_CHAT_ID`, `CRON_SECRET`, and `AGEN_DB_*` (DB creds for module 7). Local dev uses `AGEN_DB_USER='root'` with an empty password; set real cPanel DB creds on the server. Generated artifacts `cron/log_agen_harian.txt` and `cron/galeri24_raw.html` are also gitignored.
