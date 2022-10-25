<?php
require_once('./config.php');
require_once('./function/akses.php');

// cek apakah sudah login
if (!$_SESSION['is_login']) {
    // kembali ke halaman login
    header('location:login.php');
    exit();
}

// otomatis logout jika tidak ada aktifitas selama 1 jam
$time = $_SERVER['REQUEST_TIME'];
if (isset($_SESSION['last_activity']) && ($time - $_SESSION['last_activity']) > 3600) {
    session_unset();
    session_destroy();
}
$_SESSION['last_activity'] = $time;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel &bullet; RT02/RW03</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= $base_url . 'plugins/fontawesome-free/css/all.min.css' ?>">
    <link rel="stylesheet" href="<?= $base_url . 'plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css' ?>">
    <link rel="stylesheet" href="<?= $base_url . 'plugins/icheck-bootstrap/icheck-bootstrap.min.css' ?>">
    <link rel="stylesheet" href="<?= $base_url . 'plugins/jqvmap/jqvmap.min.css' ?>">
    <link rel="stylesheet" href="<?= $base_url . 'dist/css/adminlte.min.css' ?>">
    <link rel="stylesheet" href="<?= $base_url . 'plugins/overlayScrollbars/css/OverlayScrollbars.min.css' ?>">
    <link rel="stylesheet" href="<?= $base_url . 'plugins/daterangepicker/daterangepicker.css' ?>">
    <link rel="stylesheet" href="<?= $base_url . 'plugins/summernote/summernote-bs4.min.css' ?>">
    <link rel="shortcut icon" href="./dist/img/pemkot.png" type="image/x-icon">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light" aria-label="nav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <span class="fas fa-bars"></span>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary">
            <a href="index.php?page=dashboard" class="brand-link">
                <img src="<?= $base_url . 'dist/img/pemkot.png' ?>" alt="Logo" class="brand-image" style="opacity: .8">
                <span class="brand-text font-weight-light">SI KEPENDUDUKAN</span>
            </a>

            <div class="sidebar">
                <nav class="mt-2" aria-label="nav-sidebar">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="index.php?page=dashboard" class="nav-link <?= !isset($_GET['page']) || $_GET['page'] == 'dashboard' ? 'active' : '' ?>">
                                <span class="nav-icon fas fa-tachometer-alt"></span>
                                <p>BERANDA</p>
                            </a>
                        </li>

                        <?php if (in_array($_SESSION['level'], [2, 3, 4])) : ?>
                            <li class="nav-item">
                                <a href="index.php?page=warga" class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'warga' ? 'active' : '' ?>">
                                    <span class="nav-icon fas fa-users"></span>
                                    <p>DATA WARGA</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="index.php?page=pengajuan" class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'pengajuan' ? 'active' : '' ?>">
                                    <span class="nav-icon fa fa-file-alt"></span>
                                    <p>PENGAJUAN SURAT</p>
                                </a>
                            </li>
                        <?php endif ?>

                        <?php if ($_SESSION['level'] == 1) : ?>
                            <li class="nav-item">
                                <a href="index.php?page=pengguna" class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'pengguna' ? 'active' : '' ?>">
                                    <span class="nav-icon fas fa-user"></span>
                                    <p>DATA PENGGUNA</p>
                                </a>
                            </li>
                        <?php endif ?>

                        <li class="nav-item">
                            <a href="#" id="logout" class="nav-link">
                                <span class="nav-icon fas fa-sign-out-alt"></span>
                                <p>KELUAR</p>
                            </a>
                        </li>

                        <!-- <li class="nav-item menu-open">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="./index.html" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Dashboard v1</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./index2.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Dashboard v2</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./index3.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Dashboard v3</p>
                  </a>
                </li>
              </ul>
            </li> -->
                    </ul>
                </nav>
            </div>
        </aside>

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
                include_once('pages/dashboard.php');
            }
            ?>
        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; 2022 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <strong>Version</strong> 1.0
            </div>
        </footer>
    </div>

    <script src="<?= $base_url . 'plugins/jquery/jquery.min.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/jquery-ui/jquery-ui.min.js' ?>"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="<?= $base_url . 'plugins/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/chart.js/Chart.min.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/sparklines/sparkline.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/jqvmap/jquery.vmap.min.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/jqvmap/maps/jquery.vmap.usa.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/jquery-knob/jquery.knob.min.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/moment/moment.min.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/daterangepicker/daterangepicker.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/summernote/summernote-bs4.min.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js' ?>"></script>
    <script src="<?= $base_url . 'dist/js/adminlte.js' ?>"></script>
    <script src="<?= $base_url . 'dist/js/demo.js' ?>"></script>
    <script src="<?= $base_url . 'dist/js/pages/dashboard.js' ?>"></script>
    <script>
        $('#logout').click(function() {
            location.href = 'login.php?event=90';
            return false;
        });
    </script>
</body>

</html>