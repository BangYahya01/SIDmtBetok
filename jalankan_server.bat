@echo off
title Server Website Desa Montong Betok - KKN 2026
echo =====================================================================
echo    PORTAL RESMI PEMERINTAH DESA MONTONG BETOK (PHP)
echo    Kecamatan Montong Gading, Kabupaten Lombok Timur, NTB
echo    Referensi: https://desamb.id/
echo =====================================================================
echo.
echo Menjalankan PHP Development Server...
echo Server URL : http://localhost:8000
echo Login Admin: http://localhost:8000/admin (user: admin / pass: admin123)
echo.
echo Tekan Ctrl+C untuk menghentikan server kapan saja.
echo.

start http://localhost:8000
"C:\xampp\php\php.exe" -S localhost:8000
pause
