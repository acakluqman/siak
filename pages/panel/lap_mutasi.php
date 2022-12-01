<?php
// validasi hak akses
aksesOnly([2, 3, 4]);

$mutasi = $conn->prepare("SELECT * FROM rwt_mutasi LEFT JOIN warga ON warga.nik = rwt_mutasi.nik ORDER BY rwt_mutasi.tgl_lapor DESC");
$mutasi->execute();

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
    <div class="card">
        <?php if ($_SESSION['level'] == 4) { ?>
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus"></i> Tambah Data Mutasi</button>
            </div>
        <?php } ?>
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
                        <?php if ($_SESSION['level'] == 4) : ?>
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
                            <td><?= date_format(date_create($row['tgl_mutasi']), 'd m Y') ?></td>
                            <td><?= date_format(date_create($row['tgl_lapor']), 'd M Y H:i A') ?></td>
                            <?php if ($_SESSION['level'] == 4) : ?>
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

    <?php if ($_SESSION['level'] == 4) { ?>
        <div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modalTambah" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Laporan Data Mutasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . '?page=lap_mutasi'); ?>" class="form" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="mutasim">Jenis Mutasi</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="jenis_mutasi" id="mutasim" value="masuk" checked> Mutasi Masuk
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="jenis_mutasi" id="mutasik" value="keluar"> Mutasi Keluar
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div id="mutasimasuk">

                            </div>

                            <div id="mutasikeluar">
                                <div class="form-group">
                                    <label for="nik">Pilih Warga</label>
                                    <select class="form-control" name="nik" id="nik" required>
                                        <?php foreach ($warga as $row) : ?>
                                            <option value="<?= $row['nik'] ?>"><?= $row['nik'] . ' - ' . $row['nama'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="tgl_mutasi">Tanggal Mutasi</label>
                                    <input type="text" class="form-control datepicker" name="tgl_mutasi" id="tgl_mutasi" placeholder="Tanggal Mutasi" required>
                                </div>
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
    <?php } ?>
</section>

<script>
    $(function() {
        $('#nik').select2({
            dropdownParent: $('#modal-tambah'),
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