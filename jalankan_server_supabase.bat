@echo off
SETLOCAL

REM Ubah nilai di bawah sesuai project Supabase Anda
SET DB_DRIVER=supabase
SET DB_HOST=aws-0-ap-southeast-1.pooler.supabase.com
SET DB_PORT=5432
SET DB_NAME=postgres
SET DB_USER=postgres
SET DB_PASS=GANTI_PASSWORD_SUPABASE_ANDA
SET DATABASE_URL=postgresql://postgres:GANTI_PASSWORD_SUPABASE_ANDA@db.NAMA_PROJECT.supabase.co:5432/postgres?sslmode=require

echo Menjalankan server lokal web_desa dengan koneksi Supabase...
"C:\xampp\php\php.exe" -S localhost:8000

ENDLOCAL
