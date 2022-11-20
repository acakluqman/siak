<?php
// validasi hak akses
aksesOnly([2, 3, 4]);
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Laporan Kelahiran Baru</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="app.php">Beranda</a></li>
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item active">Laporan Kelahiran Baru</li>
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus"></i> Tambah Data Kelahiran</button>
            </div>
        <?php } ?>
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No.</th>
                        <th>NIK</th>
                        <th>Nama Warga</th>
                        <th>Tanggal Lahir</th>
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
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <?php if ($_SESSION['level'] == 4) { ?>
        <div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modalTambah" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Laporan Data Kelahiran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . '?page=lap_kelahiran'); ?>" class="form" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="kartu_keluarga">Nomor Kartu Keluarga</label>
                                <input type="number" class="form-control" name="kartu_keluarga" id="kartu_keluarga" placeholder="Nomor Kartu Keluarga" required maxlength="16" minlength="16" inputmode="numeric">
                            </div>

                            <div class="form-group">
                                <label for="tgl_lahir">NIK</label>
                                <input type="number" class="form-control" name="nik" id="nik" placeholder="Nomor Induk Kependudukan" required maxlength="16" minlength="16" inputmode="numeric">
                            </div>

                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input type="text" class="form-control datepicker" name="tgl_lahir" id="tgl_lahir" placeholder="Tanggal Meninggal" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
</section>