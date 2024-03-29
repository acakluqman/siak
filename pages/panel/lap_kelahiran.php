<?php
// validasi hak akses
aksesOnly([1, 2, 3, 4]);

$kelahiran = $conn->prepare("SELECT * FROM rwt_kelahiran LEFT JOIN warga ON warga.nik = rwt_kelahiran.nik ORDER BY rwt_kelahiran.tgl_lapor DESC");
$kelahiran->execute();

// tahun laporan kelahiran
$tahun = $conn->prepare("SELECT DISTINCT(YEAR(w.tgl_lahir)) AS tahun FROM rwt_kelahiran l LEFT JOIN warga w ON w.nik = l.nik ORDER BY tahun DESC");
$tahun->execute();

// proses hapus data
if (isset($_POST['delete'])) {
    $nik = $_POST['nik'];
    $delete = $conn->prepare("DELETE FROM rwt_kelahiran WHERE md5(nik) = :nik");
    $delete->execute(['nik' => $nik]);

    if ($delete) $alert->success('Berhasil menghapus data!', 'app.php?page=lap_kelahiran', true);
    else $alert->error('Gagal menghapus data. Silahkan ulangi kembali!', 'app.php?page=lap_kelahiran', true);
}
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
        <?php if (in_array($_SESSION['level'], [1, 4])) { ?>
            <div class="card-header">
                <a href="app.php?page=tambah_lap_kelahiran" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data Kelahiran</a>
                <button class="btn btn-danger" data-toggle="modal" data-target="#modal-laporan"><i class="fa fa-file-pdf" aria-hidden="true"></i> Cetak Laporan</button>
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
                        <?php if (in_array($_SESSION['level'], [1, 4])) : ?>
                            <th></th>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($kelahiran->fetchAll() as $data) : ?>
                        <tr data-id="<?= md5($data['nik']) ?>">
                            <td class="text-center"><?= $no++ ?>.</td>
                            <td><?= $data['nik'] ?></td>
                            <td><?= $data['nama'] ?></td>
                            <td><?= date_format(date_create($data['tgl_lahir']), 'd M Y') ?></td>
                            <td><?= date_format(date_create($data['tgl_lapor']), 'd M Y H:i A') ?></td>
                            <?php if (in_array($_SESSION['level'], [1, 4])) : ?>
                                <td class="text-center">
                                    <button title="Hapus" class="btn btn-sm btn-danger delete">
                                        <span class="fa fa-trash-alt"></span> Hapus
                                    </button>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus Data?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="app.php?page=lap_kelahiran" class="form" method="post">
                    <input type="text" name="nik" id="nik" value="" readonly>
                    <div class="modal-body">
                        <p>Apakah Anda yakin akan menghapus data tersebut?</p>
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
                    <h5 class="modal-title">Cetak Laporan Kelahiran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="cetak-laporan.php" target="_blank" method="post">
                    <input type="hidden" name="action" value="lap_lahir" readonly>
                    <div class="modal-body">
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
</section>

<script>
    $(function() {
        $('#tahun').select2({
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