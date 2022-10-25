<?php
require_once('./config.php');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat Datang &bullet; RT02/RW03</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= $base_url . 'plugins/fontawesome-free/css/all.min.css' ?>">
    <link rel="stylesheet" href="<?= $base_url . 'plugins/bs-stepper/css/bs-stepper.min.css' ?>">
    <link rel="stylesheet" href="<?= $base_url . 'dist/css/adminlte.min.css' ?>">
    <link rel="shortcut icon" href="./dist/img/pemkot.png" type="image/x-icon">
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="/" class="navbar-brand">
                    <img src="./dist/img/pemkot.png" alt="Logo" class="brand-image">
                    <span class="brand-text font-weight-light">RT02/RW03</span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link <?= !isset($_GET['page']) || $_GET['page'] == 'layanan' ? 'active' : '' ?>">Layanan</a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=cek-permohonan" class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'cek-permohonan' ? 'active' : '' ?>">Cek Permohonan</a>
                        </li>
                        <li class="nav-item">
                            <a href="login.php" class="nav-link">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content-wrapper">
            <?php
            // load file sesuai request
            if (isset($_GET['page'])) {
                if (file_exists('pages/' . $_GET['page'] . '.php')) {
                    include_once('pages/' . $_GET['page'] . '.php');
                } else {
                    include_once('pages/error/404.php');
                }
            } else {
                include_once('pages/layanan.php');
            }
            ?>
        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <strong>&copy; 2022 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>
    </div>

    <script src="<?= $base_url . 'plugins/jquery/jquery.min.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/bs-stepper/js/bs-stepper.min.js' ?>"></script>
    <script src="<?= $base_url . 'dist/js/adminlte.min.js' ?>"></script>
    <script src="<?= $base_url . 'dist/js/demo.js' ?>"></script>
    <?php if (isset($_GET['page']) && $_GET['page'] == 'permohonan') : ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.stepper = new Stepper(document.querySelector('.bs-stepper'))
            })
        </script>
    <?php endif; ?>
</body>

</html>