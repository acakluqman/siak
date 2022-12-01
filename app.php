<?php
require_once('./config.php');
require_once('./function/akses.php');
require_once('./function/input.php');

// cek apakah sudah login
if (!$_SESSION['is_login']) {
    // kembali ke halaman login
    header('Location:login.php');
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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Panel &bullet; RT02/RW03</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= $base_url . 'plugins/fontawesome-free/css/all.min.css' ?>">
    <link rel="stylesheet" href="<?= $base_url . 'plugins/select2/css/select2.min.css' ?>">
    <link rel="stylesheet" href="<?= $base_url . 'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css' ?>">
    <link rel="stylesheet" href="<?= $base_url . 'plugins/datatables-responsive/css/responsive.bootstrap4.min.css' ?>">
    <link rel="stylesheet" href="<?= $base_url . 'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css' ?>">
    <link rel="stylesheet" href="<?= $base_url . 'plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css' ?>">
    <link rel="stylesheet" href="<?= $base_url . 'dist/css/adminlte.min.css' ?>">
    <link rel="stylesheet" href="<?= $base_url . 'plugins/overlayScrollbars/css/OverlayScrollbars.min.css' ?>">
    <link rel="shortcut icon" href="<?= $base_url . 'dist/img/pemkot.png' ?>" type="image/x-icon">
    <script src="<?= $base_url . 'plugins/jquery/jquery.min.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/select2/js/select2.min.js' ?>"></script>
    <?php if (!isset($_GET['page']) || $_GET['page'] == 'dashboard') { ?>
        <link rel="stylesheet" href="<?= $base_url . 'plugins/chart.js/Chart.min.css' ?>">
        <script src="<?= $base_url . 'plugins/chart.js/Chart.min.js' ?>"></script>
    <?php } ?>
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
            <a href="app.php?page=dashboard" class="brand-link">
                <img src="<?= $base_url . 'dist/img/pemkot.png' ?>" alt="Logo" class="brand-image" style="opacity: .8">
                <span class="brand-text font-weight-light">SI KEPENDUDUKAN</span>
            </a>

            <div class="sidebar">
                <nav class="mt-2" aria-label="nav-sidebar">
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="dist/img/default-profile.png" class="img-circle" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="#" class="d-block"><?= $_SESSION['nama'] ?></a>
                        </div>
                    </div>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="app.php?page=dashboard" class="nav-link <?= !isset($_GET['page']) || $_GET['page'] == 'dashboard' ? 'active' : '' ?>">
                                <span class="nav-icon fas fa-tachometer-alt"></span>
                                <p>BERANDA</p>
                            </a>
                        </li>

                        <!-- login sebagai operator, ketua rt dan ketua rw -->
                        <?php if (in_array($_SESSION['level'], [2, 3, 4])) : ?>
                            <li class="nav-item">
                                <a href="app.php?page=warga" class="nav-link <?= isset($_GET['page']) && in_array($_GET['page'], ['warga', 'edit_warga', 'detail_warga', 'tambah_warga']) ? 'active' : '' ?>">
                                    <span class="nav-icon fas fa-users"></span>
                                    <p>DATA WARGA</p>
                                </a>
                            </li>

                            <li class="nav-item <?= isset($_GET['page']) && in_array($_GET['page'], ['lap_kematian', 'lap_kelahiran', 'lap_mutasi', 'tambah_lap_kelahiran', 'tambah_lap_mutasi']) ? 'menu-open' : '' ?>">
                                <a href="#" class="nav-link <?= isset($_GET['page']) && in_array($_GET['page'], ['lap_kematian', 'lap_kelahiran', 'lap_mutasi', 'tambah_lap_kelahiran', 'tambah_lap_mutasi']) ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-chart-line"></i>
                                    <p>
                                        LAPORAN
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="app.php?page=lap_kematian" class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'lap_kematian' ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Kematian</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="app.php?page=lap_kelahiran" class="nav-link <?= isset($_GET['page']) && in_array($_GET['page'], ['lap_kelahiran', 'tambah_lap_kelahiran'])  ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Kelahiran</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="app.php?page=lap_mutasi" class="nav-link <?= isset($_GET['page']) && in_array($_GET['page'], ['lap_mutasi', 'tambah_lap_mutasi']) ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Mutasi</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="app.php?page=pengajuan" class="nav-link <?= isset($_GET['page']) && in_array($_GET['page'], ['pengajuan', 'detail_pengajuan', 'validasi_pengajuan']) ? 'active' : '' ?>">
                                    <span class="nav-icon fa fa-file-alt"></span>
                                    <p>PENGAJUAN SURAT</p>
                                </a>
                            </li>
                        <?php endif ?>

                        <!-- login sebagai admin -->
                        <?php if ($_SESSION['level'] == 1) : ?>
                            <li class="nav-item">
                                <a href="app.php?page=pengguna" class="nav-link <?= isset($_GET['page']) && in_array($_GET['page'], ['pengguna', 'edit_pengguna'])  ? 'active' : '' ?>">
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
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <?php
            // load file sesuai request
            if (isset($_GET['page'])) {
                if (file_exists('pages/panel/' . $_GET['page'] . '.php')) {
                    include_once('pages/panel/' . $_GET['page'] . '.php');
                } else {
                    include_once('pages/error/404.php');
                }
            } else {
                include_once('pages/panel/dashboard.php');
            }
            ?>
        </div>
    </div>

    <script src="<?= $base_url . 'plugins/jquery-ui/jquery-ui.min.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
    <?php if (!isset($_GET['page']) || $_GET['page'] == 'dashboard') : ?>
        <script src="<?= $base_url . 'plugins/chart.js/Chart.min.js' ?>"></script>
    <?php endif ?>
    <script src="<?= $base_url . 'plugins/datatables/jquery.dataTables.min.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/datatables-responsive/js/dataTables.responsive.min.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/datatables-responsive/js/responsive.bootstrap4.min.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/bootstrap-datepicker/locales/bootstrap-datepicker.id.min.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/moment/moment.min.js' ?>"></script>
    <script src="<?= $base_url . 'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js' ?>"></script>
    <script src="<?= $base_url . 'dist/js/adminlte.js' ?>"></script>
    <script>
        $('#logout').click(function() {
            location.href = 'login.php?event=90';
            return false;
        });
        $(function() {
            $('.table').DataTable({
                "language": {
                    "lengthMenu": "_MENU_",
                    "search": "",
                }
            });

            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
                weekStart: 0,
                endDate: '+0d',
                language: "id"
            });
        })
    </script>
</body>

</html>