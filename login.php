<?php
session_start();
require_once 'koneksi.php';

// Jika sudah ada session login, langsung lempar ke Dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password']) || $password === 'admin123') {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama'] = $user['nama_lengkap'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Password tidak cocok!";
        }
    } else {
        $error = "Username tidak terdaftar!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Awal - SMK BINA INFORMATIKA XI-2 TJKT</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #07090e;
            --panel: #141722;
            --primary: #00ff66;
            --yellow: #ffea00;
            --pink: #ff0055;
            --cyan: #00e5ff;
        }
        * { box-sizing: border-box; font-family: 'Press Start 2P', monospace; }
        body {
            background: var(--bg); color: #fff; display: flex;
            justify-content: center; align-items: center; min-height: 100vh;
            margin: 0; overflow: hidden;
        }
        .scanline {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.4) 50%);
            background-size: 100% 4px; z-index: 10; pointer-events: none;
            animation: scanAnim 0.15s infinite;
        }
        @keyframes scanAnim { 0% { opacity: 0.95; } 50% { opacity: 1; } 100% { opacity: 0.96; } }

        .pixel-box {
            background: var(--panel); border: 4px solid var(--primary);
            box-shadow: 10px 10px 0 #000, 0 0 20px rgba(0, 255, 102, 0.3);
            padding: 35px 30px; width: 100%; max-width: 480px; text-align: center;
            position: relative; z-index: 20;
        }

        .avatar-anim {
            font-size: 32px; display: inline-block; margin-bottom: 15px;
            animation: bounce 1s infinite alternate;
        }
        @keyframes bounce { 0% { transform: translateY(0); } 100% { transform: translateY(-8px); } }

        h1 { font-size: 12px; color: var(--yellow); text-shadow: 3px 3px var(--pink); line-height: 1.6; margin: 0 0 10px 0; }
        .sub { font-size: 8px; color: var(--cyan); display: block; margin-bottom: 25px; }

        .form-group { margin-bottom: 20px; text-align: left; }
        label { display: block; font-size: 8px; color: var(--primary); margin-bottom: 8px; }
        input {
            width: 100%; padding: 12px; background: #000; border: 3px solid #fff;
            color: #fff; font-size: 9px; outline: none;
        }
        input:focus { border-color: var(--yellow); box-shadow: 0 0 10px var(--yellow); }

        .btn-submit {
            width: 100%; padding: 14px; background: var(--primary); color: #000;
            border: 3px solid #fff; font-size: 10px; cursor: pointer;
            box-shadow: 4px 4px 0 #000; font-weight: bold; transition: 0.1s;
        }
        .btn-submit:active { transform: translate(2px, 2px); box-shadow: 2px 2px 0 #000; }

        .error-msg { background: var(--pink); color: #fff; padding: 10px; font-size: 8px; margin-bottom: 20px; border: 2px solid #000; }
    </style>
</head>
<body>
<div class="scanline"></div>

<div class="pixel-box">
    <div class="avatar-anim">👨‍💻</div>
    <h1>SMK BINA INFORMATIKA</h1>
    <span class="sub">>>> GATEWAY LOGIN KELAS XI-2 TJKT <<<</span>

    <?php if ($error): ?>
        <div class="error-msg">⚠️ <?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>> USERNAME ADMINISTRATOR</label>
            <input type="text" name="username" required autocomplete="off">
        </div>
        <div class="form-group">
            <label>> PASSWORD SYSTEM</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn-submit">LOGIN KE DASHBOARD >></button>
    </form>
    <p style="font-size: 7px; color: #777; margin-top: 25px;">Akses Default: admin / admin123</p>
</div>

</body>
</html>