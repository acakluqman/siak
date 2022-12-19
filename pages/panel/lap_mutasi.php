<?php
// validasi hak akses
aksesOnly([1, 2, 3, 4]);

if (isset($_POST['fjenis']) && !empty($_POST['fjenis'])) {
    $mutasi = $conn->prepare("SELECT *
        FROM rwt_mutasi
        LEFT JOIN warga ON warga.nik = rwt_mutasi.nik
        WHERE rwt_mutasi.jenis_mutasi = :jenis
        ORDER BY rwt_mutasi.tgl_lapor DESC");
    $mutasi->execute(['jenis' => $_POST['fjenis']]);
} else {
    $mutasi = $conn->prepare("SELECT *
        FROM rwt_mutasi
        LEFT JOIN warga ON warga.nik = rwt_mutasi.nik
        ORDER BY rwt_mutasi.tgl_lapor DESC");
    $mutasi->execute();
}

// tahun laporan
$tahun = $conn->prepare("SELECT DISTINCT(YEAR(tgl_mutasi)) AS tahun FROM rwt_mutasi");
$tahun->execute();

// proses hapus data
if (isset($_POST['delete'])) {
    $nik = $_POST['nik'];
    $delete = $conn->prepare("DELETE FROM rwt_mutasi WHERE md5(nik) = :nik");
    $delete->execute(['nik' => $nik]);

    if ($delete) $alert->success('Berhasil menghapus data!', 'app.php?page=lap_mutasi', true);
    else $alert->error('Gagal menghapus data. Silahkan ulangi kembali!', 'app.php?page=lap_mutasi', true);
}
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <?php if (in_array($_SESSION['level'], [1, 4])) { ?>
                    <div class="card-header">
                        <a href="app.php?page=tambah_lap_mutasi" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data Mutasi</a>
                        <button class="btn btn-danger" data-toggle="modal" data-target="#modal-laporan"><i class="fa fa-file-pdf" aria-hidden="true"></i> Cetak Laporan</button>
                    </div>
                <?php } ?>
                <div class="card-body">
                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . '?page=lap_mutasi') ?>" id="form" method="post">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="fjenis" class="control-label">Jenis Mutasi</label>
                                <select name="fjenis" id="fjenis" class="form-control" onchange="this.form.submit()">
                                    <option value="">Semua Jenis Mutasi</option>
                                    <option value="masuk" <?= isset($_POST['fjenis']) && $_POST['fjenis'] == 'masuk' ? 'selected' : '' ?>>Mutasi Masuk</option>
                                    <option value="keluar <?= isset($_POST['fjenis']) && $_POST['fjenis'] == 'keluar' ? 'selected' : '' ?>">Mutasi Keluar</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
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
                                <?php if (in_array($_SESSION['level'], [1, 4])) : ?>
                                    <th class="wd-5"></th>
                                <?php endif ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($mutasi->fetchAll() as $row) : ?>
                                <tr data-id="<?= md5($row['nik']) ?>">
                                    <td class="text-center"><?= $no++ ?>.</td>
                                    <td><?= $row['nik'] ?></td>
                                    <td><?= $row['nama'] ?></td>
                                    <td><span class="badge badge-<?= $row['jenis_mutasi'] == 'keluar' ? 'danger' : 'success' ?>">Mutasi <?= ucwords($row['jenis_mutasi']) ?></span></td>
                                    <td><?= date_format(date_create($row['tgl_mutasi']), 'd M Y') ?></td>
                                    <td><?= date_format(date_create($row['tgl_lapor']), 'd M Y H:i A') ?></td>
                                    <?php if (in_array($_SESSION['level'], [1, 4])) : ?>
                                        <td class="text-center">
                                            <button title="Hapus" class="btn btn-sm btn-danger delete">
                                                <span class="fa fa-trash-alt"></span> Hapus
                                            </button>
                                        </td>
                                    <?php endif ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php if (in_array($_SESSION['level'], [1, 4])) { ?>
            <div class="modal fade" id="modal-delete">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Hapus Data Mutasi?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="app.php?page=lap_mutasi" class="form" method="post">
                            <input type="hidden" name="nik" id="nik" value="" readonly>
                            <div class="modal-body">
                                <p>Apakah Anda yakin akan menghapus data mutasi?</p>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                <button type="submit" name="delete" class="btn btn-danger">Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal-laporan">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Cetak Laporan Mutasi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="cetak-laporan.php" target="_blank" method="post">
                            <input type="hidden" name="action" value="lap_mutasi" readonly>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="jenis" class="control-label">Jenis Mutasi</label>
                                    <select class="form-control" name="jenis" id="jenis">
                                        <option value="masuk">Mutasi Masuk</option>
                                        <option value="keluar">Mutasi Keluar</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tahun" class="control-label">Tahun</label>
                                    <select class="form-control" name="tahun" id="tahun">
                                        <?php foreach ($tahun->fetchAll() as $row) : ?>
                                            <option value="<?= $row['tahun'] ?>">Tahun <?= $row['tahun'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" name="cetak" class="btn btn-primary">Cetak Laporan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
</section>

<script>
    $(function() {
        $('#fjenis').select2();

        $('#jenis, #tahun').select2({
            dropdownParent: $('#modal-laporan')
        });
    })
    $('button.delete').on('click', function(e) {
        e.preventDefault();
        var nik = $(this).closest('tr').data('id');
        $('#modal-delete').data('nik', nik).modal('show');
        $('#modal-delete #nik').val(nik);
        console.log(nik)
    });
</script>