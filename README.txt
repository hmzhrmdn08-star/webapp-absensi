SMK BINA INFORMATIKA XI-2 TJKT — VERSI HTML/CSS/JS

FILE:
- login.html: halaman login demo
- index.html: dashboard
- style.css: seluruh tampilan responsif
- app.js: navigasi, CRUD, pencarian, ekspor CSV, penyimpanan browser

CARA PAKAI DI GITHUB PAGES:
1. Upload semua file ini ke root repository GitHub.
2. Pastikan index.html ada di root.
3. Repository > Settings > Pages > Deploy from a branch > pilih main dan /(root).
4. Buka alamat GitHub Pages. Halaman pertama index.html akan meminta login jika sesi belum aktif.

LOGIN DEMO: admin / admin123

PENTING:
- GitHub Pages hanya hosting statis. Versi ini mengubah fitur database PHP/MySQL menjadi penyimpanan localStorage di browser.
- Data hanya tersimpan pada browser/perangkat yang digunakan, tidak tersinkron ke perangkat lain, dan bisa hilang jika data situs browser dihapus.
- Login ini hanya simulasi sisi browser dan BUKAN sistem keamanan sungguhan. Jangan gunakan untuk data pribadi/sensitif atau mempublikasikan data siswa asli.
- Untuk login admin aman dan database bersama, diperlukan backend/API dan database terpisah.
- Tampilan pixel/retro, menu dashboard, struktur kelas, absensi, jadwal pelajaran, jadwal piket, tugas, CRUD, pencarian absensi, statistik, efek scanline/audio, dan ekspor CSV tersedia.
