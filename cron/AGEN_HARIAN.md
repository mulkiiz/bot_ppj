# Agen Harian PPJ — LPPM Unsoed

Skrip cron yang menyusun **briefing harian** dan mengirimnya ke Telegram tiap pagi.
Berdiri sendiri (tidak berkaitan dengan crawler terbitan SIMONJU) — dipindahkan ke repo `bot_ppj` agar terpisah dari modul crawl.

- Skrip utama: [`agen_harian.php`](agen_harian.php)
- Zona waktu: `Asia/Jakarta`
- Jadwal server: tiap hari **07.00 WIB** via cron cPanel
- Akses browser (uji manual): `https://<host>/cron/agen_harian.php?key=CRON_SECRET`
- CLI: `php cron/agen_harian.php`

## Alur

`ambil_*()` mengumpulkan data tiap modul → `bangun_pesan()` merangkai HTML → `kirim_telegram()` kirim ke `TELEGRAM_CHAT_ID`.
Modul KURS bersifat **wajib** (gagal ambil kurs → seluruh run dibatalkan & kirim notifikasi error). Modul lain boleh `null` (tampil "data tidak tersedia").

## Modul

| # | Modul | Sumber | Catatan |
|---|-------|--------|---------|
| 1 | Kurs USD/IDR (+EUR/SGD/JPY) | `open.er-api.com` | wajib |
| 2 | Emas Dunia (XAU) | `goldapi.io` | butuh `GOLD_API_KEY`, boleh skip |
| 3 | Emas Galeri24 | scraping `galeri24.co.id` | anchor heading "Harga GALERI 24"; simpan `galeri24_raw.html` bila parsing gagal |
| 4 | PPJ — Status Jurnal | `jos.unsoed.ac.id` | cek reachability + deteksi kata kunci judol |
| 6 | Catatan Ekonomi | Groq LLM (`llama-3.3-70b`) | komentar 2 kalimat, hanya dari angka faktual; butuh `GROQ_API_KEY` |

**Modul 5 (Piala Dunia 2026) sudah dihapus.** Di `bangun_pesan()` disediakan slot komentar `// ---------- (slot konten baru) ----------` untuk konten pengganti.

## Konfigurasi (rahasia)

Secret dimuat dari `cron/config.agen.php` yang **tidak di-commit** (di-`.gitignore`).
Salin template lalu isi nilai asli:

```bash
cp cron/config.agen.example.php cron/config.agen.php
```

Kunci yang diisi: `GROQ_API_KEY`, `GOLD_API_KEY`, `TELEGRAM_BOT_TOKEN`, `TELEGRAM_CHAT_ID`, `CRON_SECRET`.

## Dependensi

- **cURL** dengan CA bundle `includes/cacert.pem` (path relatif `../includes/cacert.pem`, dapat dioverride via konstanta `CA_BUNDLE_PATH`).
- Ekstensi PHP: `curl`, `json`, `openssl`, `mbstring`.

## Berkas terkait

| Berkas | Peran | Git |
|--------|-------|-----|
| `agen_harian.php` | skrip utama | commit |
| `config.agen.example.php` | template secret | commit |
| `config.agen.php` | secret nyata | **ignored** |
| `../includes/cacert.pem` | CA bundle cURL | commit |
| `log_agen_harian.txt` | log run | **ignored** (generated) |
| `galeri24_raw.html` | dump diagnosa scraping | **ignored** (generated) |

## Deploy

Upload `cron/agen_harian.php` (+ `config.agen.php` berisi nilai produksi, di luar git) ke host.
Path cron produksi saat ini: `/home/jurz2196/public_html/ppj/cron/agen_harian.php`.
