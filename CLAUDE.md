# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A Telegram bot + broadcast tooling for **Desa BRILiaN 2026**, an Indonesian village-training program. Village officials message the bot with `KODEDESA 4DIGITHP`; the bot verifies them against a MySQL `users` table and replies with their Moodle/LMS Joglo credentials (username + password) plus event info. Companion scripts blast the same credentials to participants over Telegram and email.

There is no framework, no package manager, no build step, and no test suite. It is a handful of standalone PHP scripts deployed by uploading files to shared cPanel hosting. Comments and user-facing strings are in Indonesian.

A second, unrelated subsystem also lives here: **`cron/agen_harian.php`** — a daily Telegram briefing agent (kurs/emas, journal-server status check for `jos.unsoed.ac.id`, Groq economic note). It shares nothing with the BRILiaN credential bot except being PHP + Telegram + cURL. See [`cron/AGEN_HARIAN.md`](cron/AGEN_HARIAN.md) for its modules, config (`cron/config.agen.php`, gitignored), and cron schedule. It uses `includes/cacert.pem` as the cURL CA bundle.

## Runtime & deployment

- **Target host:** cPanel shared hosting, **PHP 7.4** (`ea-php74`, pinned in `.htaccess`), domain `miz.jurnalsinta.id`. Local dev is XAMPP under `C:\xampp\htdocs\botppj`.
- **DB access is `mysqli` only** — assume **no PDO and no mysqlnd**. That is why prepared statements use `bind_param` + `bind_result`/`get_result` rather than PDO. Keep new DB code in that style; do not introduce PDO.
- **Telegram delivery uses raw cURL** to `api.telegram.org/bot<TOKEN>/sendMessage`. No SDK.
- **Deploy = upload the changed `.php` file(s)** to the host. To (re)point Telegram at the webhook, call the Telegram `setWebhook` API with the URL and the `X_TELEGRAM_BOT_API_SECRET_TOKEN` secret — there is no `set_webhook.php` checked in, so do it manually or add one.
- `myrandom.php` just prints `bin2hex(random_bytes(16))` — used to generate a new webhook/secret value.
- `diag.php` is a health-check page (extensions present, config filled, DB reachable). It and the blast scripts are meant to be **deleted from the server after use** (noted in their own headers).

## Architecture / big picture

### Two webhook handlers exist — `webhook.php` is the live one

`webhook.php` and `bot.php` are **two generations of the same Telegram handler** and expect **different database schemas**. Do not assume they are interchangeable.

- **`webhook.php` (current/active)** — loads secrets from `config.php` (`require`), uses a **persistent** connection (`p:` host prefix), sends the reply first then calls `finishRequest()` (`fastcgi_finish_request`) and runs audit/rate-limit inserts in `runDeferred()` *after* the response is closed. Rate limiting is a **dedicated `rate_limit` table**; audit rows go to `audit_log(telegram_id, telegram_name, query_username, status, created_at)`. Supports an admin-only `/stats`.
- **`bot.php` (older)** — hardcodes the same secrets as `const`s instead of using `config.php`, does everything synchronously, and uses a **different `audit_log` shape** (`chat_id, input_text, status, ts`) with rate limiting counted from `audit_log` itself (no `rate_limit` table).

The downstream broadcast scripts read the **`webhook.php` schema** (`audit_log.query_username`, `created_at`), which confirms `webhook.php` is the one in production. **When changing bot behavior, edit `webhook.php`.** Treat `bot.php` as legacy reference unless explicitly told otherwise.

### Auth model (the core logic)

Two-factor lookup, no sessions: `username` = 10-digit village code (Kemendagri), second factor = last 4 digits of the village head's phone (`users.hp_last4`), compared with `hash_equals`. Input is validated with `preg_match('/^(\d{10})\s+(\d{4})$/', ...)`. Rate limit is 5 requests/hour per Telegram user. Every attempt is logged to `audit_log` with a `status` string (`success`, `wrong_2fa`, `user_not_found`, `invalid_format`, `rate_limited`, …) — these status strings are also what `/stats` and the broadcast targeting query group on, so keep them stable.

### Broadcast / blast scripts (browser-triggered, not cron)

`broadcast.php` (Telegram) and `email_blast.php` (email via PHPMailer + cPanel SMTP) are one-shot admin scripts run by opening a URL with `?secret=<...>&mode=<...>`. Both share the same `mode` protocol:

- `mode=dry` (default) — count/preview targets, send nothing
- `mode=live` — actually send
- `mode=stats` — summarize the script's own `*_log` table
- `email_blast.php` also has `mode=test&to=<email>` to send one test message

Idempotency: before sending, each checks its log table for an existing `status='success'` row for that recipient and skips it, so re-running `live` resumes rather than duplicates. `broadcast.php` writes `broadcast_log`; `email_blast.php` writes `email_blast_log`.

**Targeting differs between the two:** `broadcast.php` derives its audience from real bot usage — the most recent `success` per `telegram_id` in `audit_log`, joined to `users` on `query_username`. `email_blast.php` reads a separate **`email_recipients`** table and looks each row's password up from `users`.

### `index.php` is unrelated

`index.php` is a large (~1600-line) static Folium/Leaflet map export — pure HTML/JS, **no PHP, no DB**, not part of the bot. Ignore it when working on bot logic.

### `assets/`

`poster_brilian2026.jpg(.jpeg)` and `undangan_brilian2026.pdf` are the attachments `email_blast.php` sends.

## Database tables (inferred from queries — no schema file in repo)

- **`users`** — `username` (village code, PK-ish), `password`, `hp_last4`, `nama_desa`, `kecamatan`, `kabupaten` (source of truth for credentials)
- **`audit_log`** — active shape: `telegram_id, telegram_name, query_username, status, created_at`
- **`rate_limit`** — `telegram_id, created_at` (old rows pruned opportunistically in `runDeferred`)
- **`broadcast_log`** — `telegram_id, username, status, response, created_at`
- **`email_recipients`** — `username, email, nama_desa, kecamatan, kabupaten, provinsi`
- **`email_blast_log`** — `email, nama_desa, status, response, created_at`

## Secrets & config

`config.php` holds live DB creds, the bot token, and the webhook secret, and is intended **not** to be committed to a public repo (per its own header). Note that `bot.php`, `broadcast.php`, and `email_blast.php` currently **duplicate those same secrets inline as `const`s** rather than including `config.php` — if you rotate a token, DB password, or the webhook/broadcast/blast secret, update it in `config.php` **and** in each of those scripts, or they will silently use the stale value.
