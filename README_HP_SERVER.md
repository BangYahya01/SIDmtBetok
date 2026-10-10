# SERVER HP — Termux (PHP + SQLite)

## Install Termux
1. Install Termux (F-Droid / Play Store).
2. `pkg update && pkg upgrade`
3. `pkg install php git`

## Clone & Setup
```
git clone <repo-url>
cd web_desa
cp .env.example .env
# Edit .env jika perlu (SQLite: DB_DRIVER=sqlite)

## Jalankan Server
```
php -S 0.0.0.0:8080 -t .
```
Akses dari browser HP / jaringan lokal:
```
http://<IP_HP>:8080
```

## Akses dari Internet (Ngrok)
```
pkg install wget
wget https://bin.equinox.io/c/bNyj1mQVYrq/ngrok-v3-stable-linux-arm.tgz
tar xvzf ngrok-v3-stable-linux-arm.tgz
./ngrok http 8080
```

## Catatan
- `database.sqlite` akan dibuat otomatis saat akses pertama.
- File `.env` dan `.gitignore` sudah disertakan.
- Jangan commit `.env` (password) atau `database.sqlite`.
