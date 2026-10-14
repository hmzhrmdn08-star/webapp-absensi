<?php
session_start();
require_once 'koneksi.php';

// PROTEKSI KETAT: Jika belum login, lemparkan kembali ke Halaman Login Awal
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$page = $_GET['page'] ?? 'dashboard';

// --- HANDLER CRUD ACTIONS ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // ABSENSI
    if ($action === 'add_absensi') {
        $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
        $tgl = $_POST['tanggal'];
        $ket = $_POST['keterangan'];
        mysqli_query($koneksi, "INSERT INTO absensi (nis, nama_siswa, kelas, tanggal, keterangan) VALUES ('$nis', '$nama', 'XI-2 TJKT', '$tgl', '$ket')");
    } elseif ($action === 'edit_absensi') {
        $id = (int)$_POST['id'];
        $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
        $tgl = $_POST['tanggal'];
        $ket = $_POST['keterangan'];
        mysqli_query($koneksi, "UPDATE absensi SET nis='$nis', nama_siswa='$nama', tanggal='$tgl', keterangan='$ket' WHERE id=$id");
    } elseif ($action === 'delete_absensi') {
        $id = (int)$_POST['id'];
        mysqli_query($koneksi, "DELETE FROM absensi WHERE id=$id");
    }

    // JADWAL PELAJARAN
    if ($action === 'add_jadwal') {
        $hari = $_POST['hari'];
        $jam = mysqli_real_escape_string($koneksi, $_POST['jam']);
        $mapel = mysqli_real_escape_string($koneksi, $_POST['mapel']);
        $guru = mysqli_real_escape_string($koneksi, $_POST['guru']);
        $ruang = mysqli_real_escape_string($koneksi, $_POST['ruangan']);
        mysqli_query($koneksi, "INSERT INTO jadwal_pelajaran (hari, jam, mata_pelajaran, guru, ruangan) VALUES ('$hari', '$jam', '$mapel', '$guru', '$ruang')");
    } elseif ($action === 'edit_jadwal') {
        $id = (int)$_POST['id'];
        $hari = $_POST['hari'];
        $jam = mysqli_real_escape_string($koneksi, $_POST['jam']);
        $mapel = mysqli_real_escape_string($koneksi, $_POST['mapel']);
        $guru = mysqli_real_escape_string($koneksi, $_POST['guru']);
        $ruang = mysqli_real_escape_string($koneksi, $_POST['ruangan']);
        mysqli_query($koneksi, "UPDATE jadwal_pelajaran SET hari='$hari', jam='$jam', mata_pelajaran='$mapel', guru='$guru', ruangan='$ruang' WHERE id=$id");
    } elseif ($action === 'delete_jadwal') {
        $id = (int)$_POST['id'];
        mysqli_query($koneksi, "DELETE FROM jadwal_pelajaran WHERE id=$id");
    }

    // JADWAL PIKET (FULL CRUD: DENGAN HAPUS)
    if ($action === 'add_piket') {
        $hari = $_POST['hari'];
        $siswa = mysqli_real_escape_string($koneksi, $_POST['nama_siswa']);
        mysqli_query($koneksi, "INSERT INTO jadwal_piket (hari, nama_siswa) VALUES ('$hari', '$siswa')");
    } elseif ($action === 'edit_piket') {
        $id = (int)$_POST['id'];
        $hari = $_POST['hari'];
        $siswa = mysqli_real_escape_string($koneksi, $_POST['nama_siswa']);
        mysqli_query($koneksi, "UPDATE jadwal_piket SET hari='$hari', nama_siswa='$siswa' WHERE id=$id");
    } elseif ($action === 'delete_piket') {
        $id = (int)$_POST['id'];
        mysqli_query($koneksi, "DELETE FROM jadwal_piket WHERE id=$id");
    }

    // STRUKTUR KELAS
    if ($action === 'add_struktur') {
        $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
        $ket = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
        mysqli_query($koneksi, "INSERT INTO struktur_kelas (jabatan, nama, keterangan) VALUES ('$jabatan', '$nama', '$ket')");
    } elseif ($action === 'edit_struktur') {
        $id = (int)$_POST['id'];
        $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
        $ket = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
        mysqli_query($koneksi, "UPDATE struktur_kelas SET jabatan='$jabatan', nama='$nama', keterangan='$ket' WHERE id=$id");
    } elseif ($action === 'delete_struktur') {
        $id = (int)$_POST['id'];
        mysqli_query($koneksi, "DELETE FROM struktur_kelas WHERE id=$id");
    }

    // TUGAS
    if ($action === 'add_tugas') {
        $mapel = mysqli_real_escape_string($koneksi, $_POST['mapel']);
        $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
        $desk = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
        $dl = $_POST['dl_date'];
        $status = $_POST['status'];
        mysqli_query($koneksi, "INSERT INTO tugas (mata_pelajaran, judul_tugas, deskripsi, dl_date, status) VALUES ('$mapel', '$judul', '$desk', '$dl', '$status')");
    } elseif ($action === 'edit_tugas') {
        $id = (int)$_POST['id'];
        $mapel = mysqli_real_escape_string($koneksi, $_POST['mapel']);
        $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
        $desk = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
        $dl = $_POST['dl_date'];
        $status = $_POST['status'];
        mysqli_query($koneksi, "UPDATE tugas SET mata_pelajaran='$mapel', judul_tugas='$judul', deskripsi='$desk', dl_date='$dl', status='$status' WHERE id=$id");
    } elseif ($action === 'delete_tugas') {
        $id = (int)$_POST['id'];
        mysqli_query($koneksi, "DELETE FROM tugas WHERE id=$id");
    }

    header("Location: index.php?page=" . $page);
    exit();
}

// Stats Data
$tot_siswa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as c FROM absensi"))['c'];
$tot_hadir = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as c FROM absensi WHERE keterangan='Hadir'"))['c'];
$tot_izin  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as c FROM absensi WHERE keterangan='Izin'"))['c'];
$tot_sakit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as c FROM absensi WHERE keterangan='Sakit'"))['c'];
$tot_alfa  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as c FROM absensi WHERE keterangan='Alfa'"))['c'];
$tot_tugas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as c FROM tugas WHERE status!='Selesai'"))['c'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard XI-2 TJKT - SMK BINA INFORMATIKA</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0b0c10;
            --panel-bg: #151821;
            --primary: #00ff66;
            --secondary: #00e5ff;
            --accent: #ff0055;
            --yellow: #ffea00;
            --purple: #bf00ff;
            --text: #ffffff;
            --border: 3px solid #ffffff;
        }

        * { box-sizing: border-box; font-family: 'Press Start 2P', monospace; }

        body {
            background-color: var(--bg-color); color: var(--text);
            margin: 0; padding: 0;
            background-image: 
                linear-gradient(rgba(0, 255, 102, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 255, 102, 0.04) 1px, transparent 1px);
            background-size: 25px 25px;
        }

        .scanline-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.25) 50%);
            background-size: 100% 4px; z-index: 99; pointer-events: none;
        }

        /* VARIASI 1: MARQUEE NEON RUNNING TEXT */
        .marquee-container {
            background: #000; border-bottom: 2px solid var(--primary);
            padding: 8px 0; overflow: hidden; white-space: nowrap;
        }
        .marquee-text {
            display: inline-block; padding-left: 100%;
            animation: marquee 22s linear infinite;
            font-size: 8px; color: var(--yellow); text-shadow: 0 0 5px var(--yellow);
        }
        @keyframes marquee { 0% { transform: translate(0, 0); } 100% { transform: translate(-100%, 0); } }

        header {
            background: #050608; border-bottom: var(--border); padding: 15px 25px;
            display: flex; justify-content: space-between; align-items: center;
        }

        .logo { font-size: 13px; color: var(--yellow); text-shadow: 3px 3px var(--accent); }
        .logo span { color: var(--primary); display: block; font-size: 9px; margin-top: 5px; }

        .top-controls { display: flex; align-items: center; gap: 12px; }
        .effect-btn {
            background: #111; color: var(--secondary); border: 2px solid var(--secondary);
            font-size: 8px; padding: 6px 10px; cursor: pointer; box-shadow: 2px 2px 0 #000;
        }
        .btn-logout {
            background: var(--accent); color: #fff; padding: 8px 12px;
            text-decoration: none; border: 2px solid #fff; font-size: 8px;
            box-shadow: 3px 3px 0 #000;
        }

        .container { display: flex; min-height: calc(100vh - 105px); }

        nav {
            width: 270px; background: var(--panel-bg);
            border-right: var(--border); padding: 20px 12px;
        }

        .nav-item {
            display: block; padding: 14px 10px; margin-bottom: 10px;
            background: #090a0e; color: var(--text); text-decoration: none;
            font-size: 8px; border: 2px solid #fff; box-shadow: 3px 3px 0 #000;
            line-height: 1.4; transition: 0.1s;
        }
        .nav-item:hover, .nav-item.active {
            background: var(--primary); color: #000;
            transform: translate(-2px, -2px); box-shadow: 5px 5px 0 #000;
        }

        main { flex: 1; padding: 25px; overflow-x: hidden; }

        /* Stats Grid & Animated Cards */
        .stats-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 15px; margin-bottom: 25px;
        }
        .stat-card {
            background: #11141d; border: 2px solid #fff; padding: 15px;
            text-align: center; box-shadow: 4px 4px 0 #000; position: relative;
        }
        .stat-title { font-size: 7px; color: #aaa; margin-bottom: 8px; display: block; }
        .stat-num { font-size: 16px; font-weight: bold; }

        /* Panels & Tables */
        .panel {
            background: var(--panel-bg); border: var(--border);
            box-shadow: 8px 8px 0 #000; padding: 20px; margin-bottom: 25px;
        }
        .panel-title {
            font-size: 11px; color: var(--secondary); margin-bottom: 20px;
            display: flex; justify-content: space-between; align-items: center;
        }

        .pixel-table { width: 100%; border-collapse: collapse; font-size: 8px; }
        .pixel-table th, .pixel-table td { border: 2px solid #fff; padding: 10px; text-align: left; }
        .pixel-table th { background: #000; color: var(--yellow); }
        .pixel-table tr:nth-child(even) { background: #1c202d; }

        /* VARIASI 2: ANIMATED SPRITE & HERO CARD */
        .hero-banner {
            background: linear-gradient(135deg, #1b003a, #001a33);
            border: 3px solid var(--cyan); padding: 20px; margin-bottom: 25px;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 6px 6px 0 #000; position: relative;
        }
        .hero-text { max-width: 70%; }
        .sprite-box {
            font-size: 45px; animation: pixelHop 1.2s infinite ease-in-out alternate;
        }
        @keyframes pixelHop { 0% { transform: translateY(0); } 100% { transform: translateY(-12px); } }

        /* Badges & Buttons */
        .badge { padding: 4px 6px; font-size: 7px; border: 1px solid #fff; display: inline-block; }
        .badge-hadir { background: var(--primary); color: #000; }
        .badge-izin { background: var(--secondary); color: #000; }
        .badge-sakit { background: var(--yellow); color: #000; }
        .badge-alfa { background: var(--accent); color: #fff; }

        .btn {
            padding: 6px 10px; font-size: 7px; border: 2px solid #fff;
            cursor: pointer; box-shadow: 2px 2px 0 #000; color: #000;
            background: var(--yellow); margin-right: 4px;
        }
        .btn-add { background: var(--primary); color: #000; }
        .btn-danger { background: var(--accent); color: #fff; }

        .search-box {
            padding: 8px; background: #000; border: 2px solid #fff;
            color: #fff; font-size: 8px; width: 200px; outline: none;
        }

        .modal {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.85); justify-content: center; align-items: center; z-index: 100;
        }
        .modal-content {
            background: var(--panel-bg); border: 4px solid #fff;
            padding: 25px; width: 100%; max-width: 500px; box-shadow: 10px 10px 0 #000;
        }
        .form-control { margin-bottom: 12px; }
        .form-control label { display: block; font-size: 7px; margin-bottom: 5px; color: var(--yellow); }
        .form-control input, .form-control select, .form-control textarea {
            width: 100%; padding: 8px; background: #000; color: #fff;
            border: 2px solid #fff; font-size: 8px; outline: none;
        }

        .structure-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px;
        }
        .struct-card {
            background: #11141d; border: 3px solid var(--purple); padding: 15px; box-shadow: 5px 5px 0 #000;
        }
    </style>
</head>
<body>

<div class="scanline-overlay" id="scanlines"></div>

<!-- ANIMASI RUNNING TEXT NEON -->
<div class="marquee-container">
    <div class="marquee-text">
        ⚡ WELCOME ADMINISTRATOR TO CLASS SYSTEM XI-2 TJKT (TEKNIK JARINGAN KOMPUTER & TELEKOMUNIKASI) --- 🕹️ JADWAL PIKET WAKTU PAGI HARAP DILAKSANAKAN SEBELUM 06:45 --- 🚀 SMK BINA INFORMATIKA RETRO DASHBOARD
    </div>
</div>

<header>
    <div class="logo">
        👾 SMK BINA INFORMATIKA
        <span>CLASS SYSTEM: XI-2 TJKT</span>
    </div>
    <div class="top-controls">
        <button class="effect-btn" onclick="toggleScanlines()">CRT SCANLINES</button>
        <button class="effect-btn" onclick="toggleAudio()" id="audioBtn">SFX: ON</button>
        <a href="logout.php" class="btn-logout">LOGOUT [X]</a>
    </div>
</header>

<div class="container">
    <nav>
        <a href="index.php?page=dashboard" class="nav-item <?= $page === 'dashboard' ? 'active' : '' ?>" onclick="playSfx()">📊 DASHBOARD OVERVIEW</a>
        <a href="index.php?page=struktur" class="nav-item <?= $page === 'struktur' ? 'active' : '' ?>" onclick="playSfx()">🏛️ STRUKTUR KELAS</a>
        <a href="index.php?page=absensi" class="nav-item <?= $page === 'absensi' ? 'active' : '' ?>" onclick="playSfx()">📋 ABSENSI (25 SISWA)</a>
        <a href="index.php?page=jadwal" class="nav-item <?= $page === 'jadwal' ? 'active' : '' ?>" onclick="playSfx()">⏰ JADWAL (SENIN-JUMAT)</a>
        <a href="index.php?page=piket" class="nav-item <?= $page === 'piket' ? 'active' : '' ?>" onclick="playSfx()">🧹 JADWAL PIKET KELAS</a>
        <a href="index.php?page=tugas" class="nav-item <?= $page === 'tugas' ? 'active' : '' ?>" onclick="playSfx()">📝 MENU TUGAS KELAS</a>
    </nav>

    <main>

        <!-- VARIASI HERO BANNER -->
        <div class="hero-banner">
            <div class="hero-text">
                <span style="color:var(--yellow); font-size:9px;">[SYSTEM LOGGED IN]</span>
                <h2 style="font-size:12px; color:var(--primary); margin: 8px 0;">HALAMAN DASHBOARD UTAMA</h2>
                <p style="font-size:7px; line-height:1.6; color:#ccc; margin:0;">
                    Selamat datang kembali, <strong><?= htmlspecialchars($_SESSION['nama']) ?></strong>! Semua menu dapat diakses dan diubah secara interaktif.
                </p>
            </div>
            <div class="sprite-box">📡</div>
        </div>

        <!-- STATS GRID -->
        <div class="stats-grid">
            <div class="stat-card" style="border-color: var(--secondary);">
                <span class="stat-title">TOTAL SISWA</span>
                <span class="stat-num" style="color: var(--secondary);"><?= $tot_siswa ?></span>
            </div>
            <div class="stat-card" style="border-color: var(--primary);">
                <span class="stat-title">HADIR</span>
                <span class="stat-num" style="color: var(--primary);"><?= $tot_hadir ?></span>
            </div>
            <div class="stat-card" style="border-color: var(--secondary);">
                <span class="stat-title">IZIN</span>
                <span class="stat-num" style="color: var(--secondary);"><?= $tot_izin ?></span>
            </div>
            <div class="stat-card" style="border-color: var(--yellow);">
                <span class="stat-title">SAKIT</span>
                <span class="stat-num" style="color: var(--yellow);"><?= $tot_sakit ?></span>
            </div>
            <div class="stat-card" style="border-color: var(--accent);">
                <span class="stat-title">ALFA</span>
                <span class="stat-num" style="color: var(--accent);"><?= $tot_alfa ?></span>
            </div>
            <div class="stat-card" style="border-color: var(--purple);">
                <span class="stat-title">TUGAS AKTIF</span>
                <span class="stat-num" style="color: var(--purple);"><?= $tot_tugas ?></span>
            </div>
        </div>

        <?php if ($page === 'dashboard'): ?>
            <div class="panel">
                <div class="panel-title">⚡ RINGKASAN AKTIVITAS KELAS</div>
                <p style="font-size: 8px; line-height: 1.8; color: #ccc;">
                    Sistem Manajemen Kelas XI-2 TJKT dilengkapi fitur perekaman presensi 25 siswa, pemetaan jadwal mata pelajaran laboratorium TJKT, serta pengorganisasian regu piket harian.
                </p>
                <div style="margin-top: 15px; padding: 15px; background: #000; border: 2px dashed var(--primary);">
                    <span style="color: var(--yellow); font-size: 8px;">📌 PEMBERITAHUAN TJKT:</span>
                    <p style="font-size: 8px; margin-top: 8px; color: var(--primary);">
                        > Praktikum Fiber Optik dilaksanakan setiap hari Rabu di Lab FO.<br>
                        > Tugas Konfigurasi Router MikroTik harap diselesaikan sebelum batas deadline.
                    </p>
                </div>
            </div>

        <?php elseif ($page === 'struktur'): ?>
            <!-- STRUKTUR KELAS -->
            <div class="panel">
                <div class="panel-title">
                    <span>🏛️ STRUKTUR ORGANISASI KELAS</span>
                    <button class="btn btn-add" onclick="openModal('modalAddStruktur')">+ TAMBAH JABATAN</button>
                </div>
                <div class="structure-grid">
                    <?php
                    $res = mysqli_query($koneksi, "SELECT * FROM struktur_kelas");
                    while ($row = mysqli_fetch_assoc($res)):
                    ?>
                    <div class="struct-card">
                        <span style="color:var(--yellow); font-size:9px; display:block; margin-bottom:8px;">👑 <?= htmlspecialchars($row['jabatan']) ?></span>
                        <span style="font-size:9px; display:block;"><?= htmlspecialchars($row['nama']) ?></span>
                        <span style="color:var(--secondary); font-size:7px; display:block; margin-top:5px;"><?= htmlspecialchars($row['keterangan']) ?></span>
                        <div style="margin-top: 15px; text-align: right;">
                            <button class="btn" onclick='editStruktur(<?= json_encode($row) ?>)'>EDIT</button>
                            <form method="POST" style="display:inline;" onsubmit="return confirm('Hapus data?')">
                                <input type="hidden" name="action" value="delete_struktur">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button class="btn btn-danger">HAPUS</button>
                            </form>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <div id="modalAddStruktur" class="modal">
                <div class="modal-content">
                    <h3 style="font-size:9px; color:var(--yellow)">TAMBAH STRUKTUR</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="add_struktur">
                        <div class="form-control"><label>JABATAN</label><input type="text" name="jabatan" required></div>
                        <div class="form-control"><label>NAMA</label><input type="text" name="nama" required></div>
                        <div class="form-control"><label>KETERANGAN</label><input type="text" name="keterangan"></div>
                        <button type="submit" class="btn btn-add" style="width:100%; margin-top:10px;">SIMPAN</button>
                        <button type="button" class="btn btn-danger" style="width:100%; margin-top:5px;" onclick="closeModal('modalAddStruktur')">BATAL</button>
                    </form>
                </div>
            </div>

            <div id="modalEditStruktur" class="modal">
                <div class="modal-content">
                    <h3 style="font-size:9px; color:var(--yellow)">EDIT STRUKTUR</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="edit_struktur">
                        <input type="hidden" name="id" id="edit_struct_id">
                        <div class="form-control"><label>JABATAN</label><input type="text" name="jabatan" id="edit_struct_jabatan" required></div>
                        <div class="form-control"><label>NAMA</label><input type="text" name="nama" id="edit_struct_nama" required></div>
                        <div class="form-control"><label>KETERANGAN</label><input type="text" name="keterangan" id="edit_struct_ket"></div>
                        <button type="submit" class="btn btn-add" style="width:100%; margin-top:10px;">UPDATE</button>
                        <button type="button" class="btn btn-danger" style="width:100%; margin-top:5px;" onclick="closeModal('modalEditStruktur')">BATAL</button>
                    </form>
                </div>
            </div>

        <?php elseif ($page === 'absensi'): ?>
            <!-- ABSENSI (25 SISWA) -->
            <div class="panel">
                <div class="panel-title">
                    <span>📋 REKAP ABSENSI SISWA</span>
                    <div>
                        <input type="text" id="absensiSearch" class="search-box" placeholder="🔍 Cari Siswa..." onkeyup="filterAbsensi()">
                        <button class="btn btn-add" onclick="openModal('modalAddAbsensi')">+ TAMBAH</button>
                    </div>
                </div>
                <table class="pixel-table" id="absensiTable">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NIS</th>
                            <th>NAMA SISWA</th>
                            <th>KELAS</th>
                            <th>TANGGAL</th>
                            <th>KETERANGAN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $res = mysqli_query($koneksi, "SELECT * FROM absensi ORDER BY id ASC");
                        while ($row = mysqli_fetch_assoc($res)):
                            $badge = strtolower($row['keterangan']);
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td style="color:var(--yellow)"><?= $row['nis'] ?></td>
                            <td><?= htmlspecialchars($row['nama_siswa']) ?></td>
                            <td><?= htmlspecialchars($row['kelas']) ?></td>
                            <td><?= $row['tanggal'] ?></td>
                            <td><span class="badge badge-<?= $badge ?>"><?= $row['keterangan'] ?></span></td>
                            <td>
                                <button class="btn" onclick='editAbsensi(<?= json_encode($row) ?>)'>EDIT</button>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Hapus absensi?')">
                                    <input type="hidden" name="action" value="delete_absensi">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button class="btn btn-danger">HAPUS</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div id="modalAddAbsensi" class="modal">
                <div class="modal-content">
                    <h3 style="font-size:9px; color:var(--yellow)">TAMBAH ABSENSI</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="add_absensi">
                        <div class="form-control"><label>NIS</label><input type="text" name="nis" required></div>
                        <div class="form-control"><label>NAMA SISWA</label><input type="text" name="nama" required></div>
                        <div class="form-control"><label>TANGGAL</label><input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" required></div>
                        <div class="form-control">
                            <label>KETERANGAN</label>
                            <select name="keterangan">
                                <option value="Hadir">Hadir</option>
                                <option value="Izin">Izin</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Alfa">Alfa</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-add" style="width:100%; margin-top:10px;">SIMPAN</button>
                        <button type="button" class="btn btn-danger" style="width:100%; margin-top:5px;" onclick="closeModal('modalAddAbsensi')">BATAL</button>
                    </form>
                </div>
            </div>

            <div id="modalEditAbsensi" class="modal">
                <div class="modal-content">
                    <h3 style="font-size:9px; color:var(--yellow)">EDIT ABSENSI</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="edit_absensi">
                        <input type="hidden" name="id" id="edit_absensi_id">
                        <div class="form-control"><label>NIS</label><input type="text" name="nis" id="edit_absensi_nis" required></div>
                        <div class="form-control"><label>NAMA SISWA</label><input type="text" name="nama" id="edit_absensi_nama" required></div>
                        <div class="form-control"><label>TANGGAL</label><input type="date" name="tanggal" id="edit_absensi_tanggal" required></div>
                        <div class="form-control">
                            <label>KETERANGAN</label>
                            <select name="keterangan" id="edit_absensi_ket">
                                <option value="Hadir">Hadir</option>
                                <option value="Izin">Izin</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Alfa">Alfa</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-add" style="width:100%; margin-top:10px;">UPDATE</button>
                        <button type="button" class="btn btn-danger" style="width:100%; margin-top:5px;" onclick="closeModal('modalEditAbsensi')">BATAL</button>
                    </form>
                </div>
            </div>

        <?php elseif ($page === 'jadwal'): ?>
            <!-- JADWAL PELAJARAN -->
            <div class="panel">
                <div class="panel-title">
                    <span>⏰ JADWAL PELAJARAN (SENIN - JUMAT)</span>
                    <button class="btn btn-add" onclick="openModal('modalAddJadwal')">+ TAMBAH JADWAL</button>
                </div>
                <table class="pixel-table">
                    <thead>
                        <tr>
                            <th>HARI</th>
                            <th>JAM</th>
                            <th>MATA PELAJARAN</th>
                            <th>GURU</th>
                            <th>RUANGAN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $res = mysqli_query($koneksi, "SELECT * FROM jadwal_pelajaran ORDER BY FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'), jam ASC");
                        while ($row = mysqli_fetch_assoc($res)):
                        ?>
                        <tr>
                            <td style="color:var(--yellow);"><?= $row['hari'] ?></td>
                            <td><?= htmlspecialchars($row['jam']) ?></td>
                            <td><?= htmlspecialchars($row['mata_pelajaran']) ?></td>
                            <td><?= htmlspecialchars($row['guru']) ?></td>
                            <td><?= htmlspecialchars($row['ruangan']) ?></td>
                            <td>
                                <button class="btn" onclick='editJadwal(<?= json_encode($row) ?>)'>EDIT</button>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Hapus jadwal?')">
                                    <input type="hidden" name="action" value="delete_jadwal">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button class="btn btn-danger">HAPUS</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div id="modalAddJadwal" class="modal">
                <div class="modal-content">
                    <h3 style="font-size:9px; color:var(--yellow)">TAMBAH JADWAL</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="add_jadwal">
                        <div class="form-control">
                            <label>HARI</label>
                            <select name="hari">
                                <option value="Senin">Senin</option><option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option><option value="Kamis">Kamis</option><option value="Jumat">Jumat</option>
                            </select>
                        </div>
                        <div class="form-control"><label>JAM</label><input type="text" name="jam" required></div>
                        <div class="form-control"><label>MAPEL</label><input type="text" name="mapel" required></div>
                        <div class="form-control"><label>GURU</label><input type="text" name="guru" required></div>
                        <div class="form-control"><label>RUANGAN</label><input type="text" name="ruangan" required></div>
                        <button type="submit" class="btn btn-add" style="width:100%; margin-top:10px;">SIMPAN</button>
                        <button type="button" class="btn btn-danger" style="width:100%; margin-top:5px;" onclick="closeModal('modalAddJadwal')">BATAL</button>
                    </form>
                </div>
            </div>

            <div id="modalEditJadwal" class="modal">
                <div class="modal-content">
                    <h3 style="font-size:9px; color:var(--yellow)">EDIT JADWAL</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="edit_jadwal">
                        <input type="hidden" name="id" id="edit_jadwal_id">
                        <div class="form-control">
                            <label>HARI</label>
                            <select name="hari" id="edit_jadwal_hari">
                                <option value="Senin">Senin</option><option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option><option value="Kamis">Kamis</option><option value="Jumat">Jumat</option>
                            </select>
                        </div>
                        <div class="form-control"><label>JAM</label><input type="text" name="jam" id="edit_jadwal_jam" required></div>
                        <div class="form-control"><label>MAPEL</label><input type="text" name="mapel" id="edit_jadwal_mapel" required></div>
                        <div class="form-control"><label>GURU</label><input type="text" name="guru" id="edit_jadwal_guru" required></div>
                        <div class="form-control"><label>RUANGAN</label><input type="text" name="ruangan" id="edit_jadwal_ruang" required></div>
                        <button type="submit" class="btn btn-add" style="width:100%; margin-top:10px;">UPDATE</button>
                        <button type="button" class="btn btn-danger" style="width:100%; margin-top:5px;" onclick="closeModal('modalEditJadwal')">BATAL</button>
                    </form>
                </div>
            </div>

        <?php elseif ($page === 'piket'): ?>
            <!-- JADWAL PIKET (FULL CRUD) -->
            <div class="panel">
                <div class="panel-title">
                    <span>🧹 JADWAL PIKET KELAS</span>
                    <button class="btn btn-add" onclick="openModal('modalAddPiket')">+ TAMBAH PIKET</button>
                </div>
                <table class="pixel-table">
                    <thead>
                        <tr>
                            <th>HARI</th>
                            <th>ANGGOTA PIKET</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $res = mysqli_query($koneksi, "SELECT * FROM jadwal_piket ORDER BY FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')");
                        while ($row = mysqli_fetch_assoc($res)):
                        ?>
                        <tr>
                            <td style="color:var(--yellow); width: 140px;"><?= $row['hari'] ?></td>
                            <td><?= htmlspecialchars($row['nama_siswa']) ?></td>
                            <td style="width: 150px;">
                                <button class="btn" onclick='editPiket(<?= json_encode($row) ?>)'>EDIT</button>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Hapus piket?')">
                                    <input type="hidden" name="action" value="delete_piket">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button class="btn btn-danger">HAPUS</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div id="modalAddPiket" class="modal">
                <div class="modal-content">
                    <h3 style="font-size:9px; color:var(--yellow)">TAMBAH PIKET</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="add_piket">
                        <div class="form-control">
                            <label>HARI</label>
                            <select name="hari">
                                <option value="Senin">Senin</option><option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option><option value="Kamis">Kamis</option><option value="Jumat">Jumat</option>
                            </select>
                        </div>
                        <div class="form-control"><label>NAMA SISWA</label><textarea name="nama_siswa" rows="4" required></textarea></div>
                        <button type="submit" class="btn btn-add" style="width:100%; margin-top:10px;">SIMPAN</button>
                        <button type="button" class="btn btn-danger" style="width:100%; margin-top:5px;" onclick="closeModal('modalAddPiket')">BATAL</button>
                    </form>
                </div>
            </div>

            <div id="modalEditPiket" class="modal">
                <div class="modal-content">
                    <h3 style="font-size:9px; color:var(--yellow)">EDIT PIKET</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="edit_piket">
                        <input type="hidden" name="id" id="edit_piket_id">
                        <div class="form-control">
                            <label>HARI</label>
                            <select name="hari" id="edit_piket_hari">
                                <option value="Senin">Senin</option><option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option><option value="Kamis">Kamis</option><option value="Jumat">Jumat</option>
                            </select>
                        </div>
                        <div class="form-control"><label>NAMA SISWA</label><textarea name="nama_siswa" id="edit_piket_siswa" rows="4" required></textarea></div>
                        <button type="submit" class="btn btn-add" style="width:100%; margin-top:10px;">UPDATE</button>
                        <button type="button" class="btn btn-danger" style="width:100%; margin-top:5px;" onclick="closeModal('modalEditPiket')">BATAL</button>
                    </form>
                </div>
            </div>

        <?php elseif ($page === 'tugas'): ?>
            <!-- MENU TUGAS -->
            <div class="panel">
                <div class="panel-title">
                    <span>📝 DAFTAR TUGAS SISWA</span>
                    <button class="btn btn-add" onclick="openModal('modalAddTugas')">+ TAMBAH TUGAS</button>
                </div>
                <table class="pixel-table">
                    <thead>
                        <tr>
                            <th>MAPEL</th>
                            <th>JUDUL TUGAS</th>
                            <th>DESKRIPSI</th>
                            <th>DEADLINE</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $res = mysqli_query($koneksi, "SELECT * FROM tugas ORDER BY dl_date ASC");
                        while ($row = mysqli_fetch_assoc($res)):
                        ?>
                        <tr>
                            <td style="color:var(--secondary)"><?= htmlspecialchars($row['mata_pelajaran']) ?></td>
                            <td><?= htmlspecialchars($row['judul_tugas']) ?></td>
                            <td style="font-size:7px; color:#ddd;"><?= htmlspecialchars($row['deskripsi']) ?></td>
                            <td style="color:var(--yellow)"><?= $row['dl_date'] ?></td>
                            <td><span class="badge"><?= $row['status'] ?></span></td>
                            <td>
                                <button class="btn" onclick='editTugas(<?= json_encode($row) ?>)'>EDIT</button>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Hapus tugas?')">
                                    <input type="hidden" name="action" value="delete_tugas">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button class="btn btn-danger">HAPUS</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div id="modalAddTugas" class="modal">
                <div class="modal-content">
                    <h3 style="font-size:9px; color:var(--yellow)">TAMBAH TUGAS</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="add_tugas">
                        <div class="form-control"><label>MAPEL</label><input type="text" name="mapel" required></div>
                        <div class="form-control"><label>JUDUL</label><input type="text" name="judul" required></div>
                        <div class="form-control"><label>DESKRIPSI</label><textarea name="deskripsi" rows="3"></textarea></div>
                        <div class="form-control"><label>DEADLINE</label><input type="date" name="dl_date" required></div>
                        <div class="form-control">
                            <label>STATUS</label>
                            <select name="status">
                                <option value="Belum Selesai">Belum Selesai</option>
                                <option value="Proses">Proses</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-add" style="width:100%; margin-top:10px;">SIMPAN</button>
                        <button type="button" class="btn btn-danger" style="width:100%; margin-top:5px;" onclick="closeModal('modalAddTugas')">BATAL</button>
                    </form>
                </div>
            </div>

            <div id="modalEditTugas" class="modal">
                <div class="modal-content">
                    <h3 style="font-size:9px; color:var(--yellow)">EDIT TUGAS</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="edit_tugas">
                        <input type="hidden" name="id" id="edit_tugas_id">
                        <div class="form-control"><label>MAPEL</label><input type="text" name="mapel" id="edit_tugas_mapel" required></div>
                        <div class="form-control"><label>JUDUL</label><input type="text" name="judul" id="edit_tugas_judul" required></div>
                        <div class="form-control"><label>DESKRIPSI</label><textarea name="deskripsi" id="edit_tugas_desk" rows="3"></textarea></div>
                        <div class="form-control"><label>DEADLINE</label><input type="date" name="dl_date" id="edit_tugas_dl" required></div>
                        <div class="form-control">
                            <label>STATUS</label>
                            <select name="status" id="edit_tugas_status">
                                <option value="Belum Selesai">Belum Selesai</option>
                                <option value="Proses">Proses</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-add" style="width:100%; margin-top:10px;">UPDATE</button>
                        <button type="button" class="btn btn-danger" style="width:100%; margin-top:5px;" onclick="closeModal('modalEditTugas')">BATAL</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </main>
</div>

<script>
let soundActive = true;

function playSfx(freq = 520, type = 'square', duration = 0.08) {
    if (!soundActive) return;
    try {
        const ctx = new (window.AudioContext || window.webkitAudioContext)();
        const osc = ctx.createOscillator();
        const gain = ctx.createGain();
        osc.type = type;
        osc.frequency.value = freq;
        gain.gain.setValueAtTime(0.08, ctx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + duration);
        osc.connect(gain);
        gain.connect(ctx.destination);
        osc.start();
        osc.stop(ctx.currentTime + duration);
    } catch(e) {}
}

function toggleAudio() {
    soundActive = !soundActive;
    document.getElementById('audioBtn').innerText = soundActive ? 'SFX: ON' : 'SFX: OFF';
}

function toggleScanlines() {
    const scanlines = document.getElementById('scanlines');
    scanlines.style.display = scanlines.style.display === 'none' ? 'block' : 'none';
}

function openModal(id) {
    playSfx(650, 'sine');
    document.getElementById(id).style.display = 'flex';
}

function closeModal(id) {
    playSfx(300, 'square');
    document.getElementById(id).style.display = 'none';
}

function editAbsensi(data) {
    document.getElementById('edit_absensi_id').value = data.id;
    document.getElementById('edit_absensi_nis').value = data.nis;
    document.getElementById('edit_absensi_nama').value = data.nama_siswa;
    document.getElementById('edit_absensi_tanggal').value = data.tanggal;
    document.getElementById('edit_absensi_ket').value = data.keterangan;
    openModal('modalEditAbsensi');
}

function editJadwal(data) {
    document.getElementById('edit_jadwal_id').value = data.id;
    document.getElementById('edit_jadwal_hari').value = data.hari;
    document.getElementById('edit_jadwal_jam').value = data.jam;
    document.getElementById('edit_jadwal_mapel').value = data.mata_pelajaran;
    document.getElementById('edit_jadwal_guru').value = data.guru;
    document.getElementById('edit_jadwal_ruang').value = data.ruangan;
    openModal('modalEditJadwal');
}

function editPiket(data) {
    document.getElementById('edit_piket_id').value = data.id;
    document.getElementById('edit_piket_hari').value = data.hari;
    document.getElementById('edit_piket_siswa').value = data.nama_siswa;
    openModal('modalEditPiket');
}

function editStruktur(data) {
    document.getElementById('edit_struct_id').value = data.id;
    document.getElementById('edit_struct_jabatan').value = data.jabatan;
    document.getElementById('edit_struct_nama').value = data.nama;
    document.getElementById('edit_struct_ket').value = data.keterangan;
    openModal('modalEditStruktur');
}

function editTugas(data) {
    document.getElementById('edit_tugas_id').value = data.id;
    document.getElementById('edit_tugas_mapel').value = data.mata_pelajaran;
    document.getElementById('edit_tugas_judul').value = data.judul_tugas;
    document.getElementById('edit_tugas_desk').value = data.deskripsi;
    document.getElementById('edit_tugas_dl').value = data.dl_date;
    document.getElementById('edit_tugas_status').value = data.status;
    openModal('modalEditTugas');
}

function filterAbsensi() {
    const input = document.getElementById("absensiSearch").value.toUpperCase();
    const table = document.getElementById("absensiTable");
    const tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        let tdName = tr[i].getElementsByTagName("td")[2];
        let tdNis = tr[i].getElementsByTagName("td")[1];
        if (tdName || tdNis) {
            let txtName = tdName.textContent || tdName.innerText;
            let txtNis = tdNis.textContent || tdNis.innerText;
            if (txtName.toUpperCase().indexOf(input) > -1 || txtNis.toUpperCase().indexOf(input) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
</script>

</body>
</html>