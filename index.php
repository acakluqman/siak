<?php
require_once('./config.php');

if (!isset($_SESSION['is_login'])) {
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SI Kependudukan</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
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
            <a href="index.php" class="brand-link">
                <img src="dist/img/pemkot.png" alt="Logo" class="brand-image" style="opacity: .8">
                <span class="brand-text font-weight-light">SIPENDU</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Alexander Pierce</a>
                    </div>
                </div>

                <nav class="mt-2" aria-label="nav-sidebar">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="index.php?page=dashboard" class="nav-link <?= !isset($_GET['page']) || $_GET['page'] == 'dashboard' ? 'active' : '' ?>">
                                <span class="nav-icon fas fa-tachometer-alt"></span>
                                <p>DASHBOARD</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="index.php?page=penduduk" class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'penduduk' ? 'active' : '' ?>">
                                <span class="nav-icon fas fa-users"></span>
                                <p>DATA PENDUDUK</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="index.php?page=pengguna" class="nav-link <?= isset($_GET['page']) && $_GET['page'] == 'pengguna' ? 'active' : '' ?>">
                                <span class="nav-icon fas fa-user"></span>
                                <p>DATA PENGGUNA</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="login.php?event=90" class="nav-link">
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
                <strong>Version</strong> 3.2.0
            </div>
        </footer>
    </div>

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="plugins/sparklines/sparkline.js"></script>
    <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="dist/js/adminlte.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="dist/js/pages/dashboard.js"></script>
</body>

</html>