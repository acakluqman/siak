<?php
include_once('./config.php');

if (isset($_POST['username'])) {
    $_SESSION['session_id'] = session_id();
    $_SESSION['is_login'] = true;
    $_SESSION['id'] = $_POST['username'];
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['nama'] = $_POST['username'];
    $_SESSION['email'] = $_POST['username'];
    $_SESSION['level'] = $_POST['username'];

    header('location:index.php');
    exit();
}

if (isset($_GET['event']) && $_GET['event'] == 90) {
    session_unset();
    session_destroy();
    session_write_close();
    session_regenerate_id(true);
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <div class="login-logo">
                    <img src="./dist/img/pemkot.png" alt="Pemkot Surabaya" width="80px">
                </div>

                <p class="login-box-msg">Silahkan login untuk masuk ke sistem</p>

                <form action="./login.php" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="username" id="username" class="form-control" placeholder="Alamat Email atau Username">
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
                    <a href="">Lupa password</a>
                </p>
                <p class="mb-0">
                    <a href="" class="text-center">Register a new membership</a>
                </p>
            </div>
        </div>
    </div>

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
</body>

</html>