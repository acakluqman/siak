<?php
// validasi hak akses
aksesOnly([2, 3, 4]);

// ambil data riwayat kematian
$query = $conn->prepare('SELECT w.nik, w.nama, rk.tgl_meninggal, rk.tgl_lapor FROM rwt_kematian rk LEFT JOIN warga w ON w.nik = rk.nik ORDER BY rk.tgl_meninggal ASC');
$query->execute();
$data = $query->fetchAll();

// ambil data warga kecuali data warga yang sudah ada di table rwt_kematian
$stmt = $conn->prepare("SELECT w.nik, w.nama FROM warga w WHERE NOT EXISTS (SELECT rk.nik FROM rwt_kematian rk WHERE rk.nik = w.nik) ORDER BY w.nama ASC");
$stmt->execute();
$warga = $stmt->fetchAll();

if (isset($_POST['submit'])) {
    $nik = $_POST['nik'];
    $tgl_meninggal = date_format(date_create($_POST['tgl_meninggal']), 'Y-m-d');
    $insert = $conn->prepare("INSERT INTO rwt_kematian (nik, tgl_meninggal) VALUES (:nik, :tgl_meninggal)");
    $insert->execute(['nik' => $nik, 'tgl_meninggal' => $tgl_meninggal]);

    if ($insert) $alert->success('Berhasil menambahkan data kematian!');
    else $alert->error('Gagal menambahkan data kematian. Silahkan ulangi kembali!');
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($data as $row) {
                    ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?>.</td>
                            <td><?= $row['nik'] ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= date_format(date_create($row['tgl_meninggal']), 'd M Y') ?></td>
                            <td><?= date_format(date_create($row['tgl_lapor']), 'd M Y H:i A') ?></td>
                            <td class="text-center">
                                <button type="button" title="Edit" class="btn btn-sm btn-success"><span class="fas fa-pencil-alt"></span> Edit</button>
                                <button type="button" title="Hapus" class="btn btn-sm btn-danger delete"><span class="fa fa-trash-alt"></span> Hapus</button>
                            
                            </td>
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
                                <select class="form-control select2" name="nik" id="nik" required>
                                    <?php foreach ($warga as $row) : ?>
                                        <option value="<?= $row['nik'] ?>"><?= $row['nik'] . ' - ' . $row['nama'] ?></option>
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
    <?php } ?>
</section>