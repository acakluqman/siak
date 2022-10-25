<?php
include_once('config.php');

// proses login
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM pengguna p LEFT JOIN warga w ON w.nik = p.nik WHERE p.username = :username LIMIT 1");
    $stmt->execute(['username' => $username]);

    // cek apakah ada user dengan username tersebut
    if ($stmt->rowCount()) {
        $pengguna = $stmt->fetchObject();
        // verifikasi password
        if (password_verify($password, $pengguna->password)) {
            // buat session
            $_SESSION['session_id'] = session_id();
            $_SESSION['is_login'] = true;
            $_SESSION['id'] = $pengguna->id_pengguna;
            $_SESSION['username'] = $pengguna->username;
            $_SESSION['nama'] = $pengguna->nama;
            $_SESSION['email'] = $pengguna->email;
            $_SESSION['level'] = $pengguna->id_level;

            header('Location:index.php');
            exit();
        } else {
            // password tidak cocok
            $alert->error('Password tidak cocok. Silahkan ulangi kembali!');
        }
    } else {
        // data pengguna tidak ditemukan dengan username tersebut
        $alert->error('Username tidak ditemukan. Silahkan ulangi kembali!');
    }
}

// proses logout
if (isset($_GET['event']) && $_GET['event'] == 90) {
    session_unset();
    session_destroy();
    session_write_close();
    session_regenerate_id(true);

    header('Location:login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Silahkan Login &bullet; RT02/RW03</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">
    <link rel="shortcut icon" href="./dist/img/pemkot.png" type="image/x-icon">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <div class="login-logo">
                    <img src="./dist/img/pemkot.png" alt="Pemkot Surabaya" width="80px">
                </div>

                <p class="login-box-msg">Silahkan login untuk masuk ke sistem</p>

                <?= $alert->display() ?>

                <form action="login.php" method="post" autocomplete="off">
                    <div class="input-group mb-3">
                        <input type="text" name="username" id="username" class="form-control" placeholder="Alamat Email atau Username" autofocus autocomplete="username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block mb-3">MASUK</button>
                </form>

                <p class="mb-1">
                    Kembali ke <a href="index.php">halaman depan</a>
                </p>
            </div>
        </div>
    </div>

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
</body>

</html>