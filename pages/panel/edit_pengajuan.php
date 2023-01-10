<?php
// validasi hak akses
aksesOnly([1]);

$sqlDetail = $conn->prepare("SELECT p.*, w.nama
    FROM rwt_pengajuan p
    LEFT JOIN warga w ON w.nik = p.nik
    WHERE md5(p.id_pengajuan) = :id");
$sqlDetail->execute(['id' => $_GET['id']]);
$detail = $sqlDetail->fetchObject();

if (!$detail) $alert->warning('Data pengajuan tidak ditemukan!', 'app.php?page=pengajuan', true);

// proses simpan edit
if (isset($_POST['submit'])) {
    $id = $_GET['id'];
    $tujuan = $_POST['tujuan'];
    $keperluan = $_POST['keperluan'];
    $keterangan = $_POST['keterangan'];

    $update = $conn->prepare("UPDATE rwt_pengajuan SET keperluan = :keperluan, tujuan = :tujuan, keterangan = :keterangan WHERE md5(id_pengajuan) = :id");
    $update->execute(['id' => $id, 'tujuan' => $tujuan, 'keperluan' => $keperluan, 'keterangan' => $keterangan]);

    if ($update) $alert->success('Berhasil memperbarui data pengajuan!', 'app.php?page=pengajuan', true);
    else $alert->error('Gagal memperbarui data pengajuan. Silahkan ulangi kembali!', 'app.php?page=edit_pengajuan&id=' . $_GET['id'], true);
}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detail Pengajuan Surat</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="app.php">Beranda</a></li>
                    <li class="breadcrumb-item">Pengajuan Surat</li>
                    <li class="breadcrumb-item active">Edit Pengajuan Surat</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <?= $alert->display() ?>
    <div class="card">
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . '?page=edit_pengajuan&id=' . $_GET['id']) ?>" class="form" method="post">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">NIK</label>
                    <div class="col-sm-10">
                        <p><?= $detail->nik ?></p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <p><?= $detail->nama ?></p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tanggal Pengajuan</label>
                    <div class="col-sm-10">
                        <p><?= date_format(date_create($detail->tgl_ajuan), 'd M Y H:i A') ?></p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tujuan Pengajuan</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="tujuan" id="tujuan"><?= $detail->tujuan ?></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Keperluan Pengajuan</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="keperluan" id="keperluan"><?= $detail->keperluan ?></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Keterangan Pengajuan</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="keterangan" id="keterangan"><?= $detail->keterangan ?></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Bukti KTP</label>
                    <div class="col-sm-10">
                        <img src="<?= $base_url . $detail->filektp ?>" alt="ktp" height="150px">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Status Pengajuan</label>
                    <div class="col-sm-10">
                        <?php
                        if (is_null($detail->validasi_rt)) {
                            echo '<p class="pt-1"><span class="badge badge-warning text-light">Menunggu Persetujuan RT</span></p>';
                        } elseif ($detail->validasi_rt == 0 && !is_null($detail->tgl_validasi_rt)) {
                            echo '<p class="pt-1"><span class="badge badge-danger">Ditolak RT</span></p>';
                        } else {
                            if ($detail->validasi_rt == 1 && is_null($detail->validasi_rw)) {
                                echo '<p class="pt-1"><span class="badge badge-warning text-light">Menunggu Persetujuan RW</span></p>';
                            } elseif ($detail->validasi_rt == 1 && $detail->validasi_rw == 1) {
                                echo '<p class="pt-1"><span class="badge badge-success">Disetujui</span></p>';
                            } elseif ($detail->validasi_rt == 1 && $detail->validasi_rw == 0) {
                                echo '<p class="pt-1"><span class="badge badge-danger">Ditolak RW</span></p>';
                            }
                        }
                        ?>
                    </div>
                </div>

                <?php if (in_array($_SESSION['level'], [2, 3, 4])) : ?>
                    <?php if (!is_null($detail->validasi_rt) || !is_null($detail->validasi_rw)) : ?>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Riwayat Validasi</label>
                            <div class="col-sm-10">
                                <p class="pt-1">
                                    <?php if ($detail->validasi_rt == 1 && !is_null($detail->tgl_validasi_rt)) : ?>
                                        <i class="fa fa-check-circle text-success" aria-hidden="true"></i> Disetujui RT pada <?= date_format(date_create($detail->tgl_validasi_rt), 'd M Y H:i A') ?>
                                    <?php elseif ($detail->validasi_rt == 0 && !is_null($detail->tgl_validasi_rt)) : ?>
                                        <i class="fa fa-times-circle text-danger" aria-hidden="true"></i> Ditolak RT pada <?= date_format(date_create($detail->tgl_validasi_rt), 'd M Y H:i A') ?>
                                    <?php endif ?>

                                    <?php if ($detail->validasi_rt == 1 && $detail->validasi_rw == 1 && !is_null($detail->tgl_validasi_rw)) : ?>
                                        <br /><i class="fa fa-check-circle text-success" aria-hidden="true"></i> Disetujui RW pada <?= date_format(date_create($detail->tgl_validasi_rw), 'd M Y H:i A') ?>
                                    <?php elseif ($detail->validasi_rw == 0 && !is_null($detail->tgl_validasi_rw)) : ?>
                                        <br /><i class="fa fa-times-circle text-danger" aria-hidden="true"></i> Ditolak RW pada <?= date_format(date_create($detail->tgl_validasi_rw), 'd M Y H:i A') ?>
                                    <?php else : ?>
                                    <?php endif ?>
                                </p>
                            </div>
                        </div>
                    <?php endif ?>

                    <?php if ($_SESSION['level'] == 2 && is_null($detail->validasi_rt) || $_SESSION['level'] == 3 && $detail->validasi_rt == 1 && is_null($detail->validasi_rw)) : ?>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Validasi <?= $_SESSION['level'] == 2 ? 'RT' : 'RW' ?></label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="validasi" id="validasi1" value="1"> Setujui
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="validasi" id="validasi0" value="0"> Tolak
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Catatan (Opsional)</label>
                            <div class="col-sm-10">
                                <textarea name="catatan" id="catatan" class="form-control" rows="3" placeholder="Catatan (Opsional)"></textarea>
                            </div>
                        </div>
                    <?php endif ?>
                <?php endif ?>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">&nbsp;</label>
                    <div class="col-sm-10">
                        <a href="app.php?page=pengajuan" class="btn btn-danger"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i> Kembali</a>
                        <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>