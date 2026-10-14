SMK BINA INFORMATIKA XI-2 TJKT — CLOUD DATABASE EDITION

Fungsi: HTML/CSS/JS, QR absensi, cetak laporan, dan sinkronisasi data cloud Supabase.
Data yang dikelola admin akan sama saat dibuka di laptop/HP lain setelah login ke akun yang sama.

SETUP SEKALI SAJA
1. Buka https://supabase.com/dashboard dan pilih project: zabplgnxokuhjgnjuqxf.
2. Buka SQL Editor > New query. Buka file supabase-schema.sql, salin seluruh isinya ke SQL Editor, lalu tekan Run.
3. Buka Project Settings > API Keys (atau Data API/API Keys sesuai tampilan). Salin Publishable key yang berawalan sb_publishable_. JANGAN salin service_role/secret key.
4. Buka supabase-config.js lalu ganti TEMPEL_PUBLISHABLE_KEY_SB_PUBLISHABLE_DI_SINI dengan publishable key tadi. URL project sudah terisi.
5. Di Supabase Dashboard > Authentication > Users, pilih Add user/Create new user. Buat email dan password admin. Gunakan akun ini untuk login ke website. Jangan buat pendaftaran publik.
6. Upload SEMUA file dalam folder ini ke root repository GitHub, termasuk supabase-config.js dan supabase-schema.sql. Pastikan index.html di root.
7. Di Supabase > Authentication > URL Configuration, set Site URL ke URL GitHub Pages milikmu, misalnya https://USERNAME.github.io/NAMA-REPO/ (ganti sesuai URL asli). Tambahkan URL yang sama ke Redirect URLs jika diperlukan.
8. Buka situs GitHub Pages, login dengan email/password admin yang dibuat di Supabase. Tambah data, lalu buka situs di perangkat lain dan login akun sama.

CATATAN PENTING
- Supabase publishable key memang digunakan di frontend; jangan pernah memasukkan service_role/secret key.
- Database memakai RLS dan hanya pengguna yang login lewat Supabase Auth dapat membaca/menulis data. Siapa pun yang dibuat sebagai user terautentikasi pada project ini saat ini memiliki akses data; buat hanya akun yang dipercaya.
- Data lokal lama akan dipakai untuk membuat record cloud jika database masih kosong. Jika cloud sudah berisi data, data cloud menjadi sumber utama.
- Perubahan disimpan ke cloud setelah jeda singkat. Untuk perubahan langsung antarperangkat, aktifkan Realtime untuk tabel public.class_data di Supabase Database > Publications/Replication bila menu itu tersedia. Tanpa Realtime, muat ulang halaman di perangkat lain untuk melihat data terbaru.
- Jangan upload data pribadi yang tidak perlu.
