<?php
// validasi hak akses
aksesOnly([2, 3, 4]);
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Laporan Mutasi Warga</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="app.php">Beranda</a></li>
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item active">Laporan Mutasi Warga</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <?= $alert->display() ?>
    <div class="card">
        <?php if ($_SESSION['level'] == 4) { ?>
            <div class="card-header">
                <a href="" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data Mutasi</a>
            </div>
        <?php } ?>
        <div class="card-body">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">No.</th>
                            <th>NIK</th>
                            <th>Nama Warga</th>
                            <th>Jenis Mutasi</th>
                            <th>Tanggal Mutasi</th>
                            <th>Tanggal Laporan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>