<?php
// validasi hak akses
aksesOnly([2, 3, 4]);

// ambil data riwayat kematian
$query = $conn->prepare('SELECT rk.id_rwt_kematian, w.nik, w.nama, rk.tgl_meninggal, rk.tgl_lapor
    FROM rwt_kematian rk
    LEFT JOIN warga w ON w.nik = rk.nik
    ORDER BY rk.tgl_meninggal ASC');
$query->execute();
$data = $query->fetchAll();

// ambil data warga kecuali data warga yang sudah ada di table rwt_kematian dan mutasi keluar
$warga = $conn->prepare("SELECT nik, nama FROM (
    SELECT *
    FROM warga w
    WHERE NOT EXISTS (SELECT nik FROM rwt_kematian k WHERE k.nik = w.nik)) AS w1
    WHERE NOT EXISTS (SELECT * FROM rwt_mutasi m WHERE m.nik = w1.nik AND m.jenis_mutasi = 'keluar')");
$warga->execute();

// proses simpan data kematian
if (isset($_POST['submit'])) {
    $nik = $_POST['nik'];
    $tgl_meninggal = date_format(date_create($_POST['tgl_meninggal']), 'Y-m-d');
    $insert = $conn->prepare("INSERT INTO rwt_kematian (nik, tgl_meninggal) VALUES (:nik, :tgl_meninggal)");
    $insert->execute(['nik' => $nik, 'tgl_meninggal' => $tgl_meninggal]);

    if ($insert) $alert->success('Berhasil menambahkan data kematian!', 'app.php?page=lap_kematian', true);
    else $alert->error('Gagal menambahkan data kematian. Silahkan ulangi kembali!', 'app.php?page=lap_kematian', true);
}

// proses hapus data kematian
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $delete = $conn->prepare("DELETE FROM rwt_kematian WHERE md5(id_rwt_kematian) = :id");
    $delete->execute(['id' => $id]);

    if ($delete) $alert->success('Berhasil menghapus data riwayat kematian!', 'app.php?page=lap_kematian', true);
    else $alert->error('Gagal menghapus data riwayat kematian. Silahkan ulangi kembali!', 'app.php?page=lap_kematian', true);
}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Laporan Kematian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="app.php">Beranda</a></li>
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item active">Laporan Kematian</li>
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus"></i> Tambah Data Kematian</button>
            </div>
        <?php } ?>
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No.</th>
                        <th>NIK</th>
                        <th>Nama Warga</th>
                        <th>Tanggal Meninggal</th>
                        <th>Tanggal Laporan</th>
                        <?php if ($_SESSION['level'] == 4) : ?>
                            <th class="w-5"></th>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($data as $row) {
                    ?>
                        <tr data-id="<?= md5($row['id_rwt_kematian']) ?>">
                            <td class="text-center"><?= $no++ ?>.</td>
                            <td><?= $row['nik'] ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= date_format(date_create($row['tgl_meninggal']), 'd M Y') ?></td>
                            <td><?= date_format(date_create($row['tgl_lapor']), 'd M Y H:i A') ?></td>
                            <?php if ($_SESSION['level'] == 4) : ?>
                                <td class="text-center">
                                    <button type="button" title="Hapus" class="btn btn-sm btn-danger delete"><span class="fa fa-trash-alt"></span> Hapus</button>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if ($_SESSION['level'] == 4) { ?>
        <div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modalTambah" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Laporan Data Kematian</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . '?page=lap_kematian'); ?>" class="form" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nik">Pilih Warga</label>
                                <select class="form-control" name="nik" id="nik" required>
                                    <?php foreach ($warga->fetchAll() as $w) : ?>
                                        <option value="<?= $w['nik'] ?>"><?= $w['nik'] . ' - ' . $w['nama'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tgl_meninggal">Tanggal Meninggal</label>
                                <input type="text" class="form-control datepicker" name="tgl_meninggal" id="tgl_meninggal" placeholder="Tanggal Meninggal" required>
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
                        <h5 class="modal-title">Hapus Data Kematian?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="app.php?page=lap_kematian" class="form" method="post">
                        <input type="hidden" name="id" id="id" value="" readonly>
                        <div class="modal-body">
                            <p>Apakah Anda yakin akan menghapus data kematian?</p>
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

        $('button.delete').on('click', function(e) {
            e.preventDefault();
            var id = $(this).closest('tr').data('id');
            $('#modal-delete').data('id', id).modal('show');
            $('#modal-delete #id').val(id);
            // console.log(id)
        });
    })
</script>