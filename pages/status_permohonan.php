<?php

// ambil nama pak RT
$rt = $conn->prepare("SELECT * FROM pengguna p LEFT JOIN warga w ON w.nik = p.nik WHERE p.id_level = 2 LIMIT 1");
$rt->execute();
$namart = $rt->fetch();

// ambil nama pak RW
$rw = $conn->prepare("SELECT * FROM pengguna p LEFT JOIN warga w ON w.nik = p.nik WHERE p.id_level = 3 LIMIT 1");
$rw->execute();
$namarw = $rw->fetch();

if (isset($_REQUEST['submit']) or isset($_REQUEST['nik'])) {
    $nik = secureInput($_REQUEST['nik']);
    $tahun = secureInput(substr($_REQUEST['kode_permohonan'], 0, 2));
    $bulan = secureInput(substr($_REQUEST['kode_permohonan'], 2, 2));
    $id = secureInput(substr($_REQUEST['kode_permohonan'], 4));

    $query = $conn->prepare("SELECT rp.*, w.nama FROM rwt_pengajuan rp LEFT JOIN warga w ON w.nik = rp.nik WHERE rp.nik = :nik AND rp.id_pengajuan = :id_pengajuan AND LEFT(rp.tgl_ajuan, 7) = :tgl_ajuan LIMIT 1");
    $query->execute(['nik' => $nik, 'id_pengajuan' => (int) $id, 'tgl_ajuan' => '20' . $tahun . '-' . $bulan]);
    $data = $query->fetch();

    if (!$query->rowCount()) $alert->error('Data permohonan tidak ditemukan. Silahkan cek kembali NIK dan kode permohonan!', 'index.php?page=status_permohonan', true);
}
?>
<div class="content pt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <?= $alert->display() ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Status Permohonan</h3>
                    </div>
                    <div class="card-body">
                        <form action="" class="form" method="post">
                            <div class="form-group">
                                <label for="NIK">NIK</label>
                                <input type="text" class="form-control" name="nik" id="nik" value="<?= isset($_REQUEST['nik']) ? $_REQUEST['nik'] : '' ?>" placeholder="Masukkan NIK Pemohon" required>
                            </div>
                            <div class="form-group">
                                <label for="kode_permohonan">Kode Permohonan</label>
                                <input type="text" class="form-control" name="kode_permohonan" id="kode_permohonan" value="<?= isset($_REQUEST['kode_permohonan']) ? $_REQUEST['kode_permohonan'] : '' ?>" placeholder="Masukkan Kode Permohonan" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Cek Status</button>
                        </form>

                        <?php if (!empty($data)) : ?>
                            <div class="pt-4" id="result">
                                <?php if ($data['no_surat'] != '') : ?>
                                    <div class="form-group row mb-0 mb-0">
                                        <label class="control-label col-md-3">Nomor Surat</label>
                                        <div class="col-md-9">
                                            <p><?= $data['no_surat'] ?: '-' ?></p>
                                        </div>
                                    </div>
                                <?php endif ?>

                                <div class="form-group row mb-0 mb-0">
                                    <label class="control-label col-md-3">NIK Pemohon</label>
                                    <div class="col-md-9">
                                        <p><?= $data['nik'] ?></p>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <label class="control-label col-md-3">Nama Pemohon</label>
                                    <div class="col-md-9">
                                        <p><?= $data['nama'] ?></p>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <label class="control-label col-md-3">Tanggal Permohonan</label>
                                    <div class="col-md-9">
                                        <p><?= tglIndo(date_format(date_create($data['tgl_ajuan']), 'Y-m-d')) . ' ' . date_format(date_create($data['tgl_ajuan']), 'H:i A') ?></p>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <label class="control-label col-md-3">Tujuan</label>
                                    <div class="col-md-9">
                                        <p><?= $data['tujuan'] ?></p>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <label class="control-label col-md-3">Keperluan</label>
                                    <div class="col-md-9">
                                        <p><?= $data['keperluan'] ?></p>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <label class="control-label col-md-3">Keterangan</label>
                                    <div class="col-md-9">
                                        <p><?= $data['keterangan'] ?></p>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <label class="control-label col-md-3">Status Permohonan</label>
                                    <div class="col-md-9">
                                        <table class="w-100">
                                            <tr>
                                                <?php
                                                if ($data['validasi_rt'] && $data['tgl_validasi_rt']) {
                                                    echo '<td><i class="fa fa-check-circle text-success"></i></td><td style="width: 95%;">Disetujui Ketua RT (' . $namart['nama'] . ')</td>';
                                                } elseif (!$data['validasi_rt'] && $data['tgl_validasi_rt']) {
                                                    echo '<td><i class="fa fa-exclamation-circle text-danger"></i></td><td style="width: 95%;">Ditolak Ketua RT<br><span class="text-muted"><em>' . $data['catatan_val_rt'] . '</em></span></td>';
                                                } elseif (is_null($data['validasi_rt']) && is_null($data['tgl_validasi_rt'])) {
                                                    echo '<td><i class="fa fa-minus-circle text-muted"></i></td><td style="width: 95%;">Menunggu Validasi Ketua RT</td>';
                                                }
                                                ?>
                                            </tr>
                                            <tr>
                                                <?php
                                                if ($data['validasi_rt'] && $data['tgl_validasi_rt']) {
                                                    if ($data['validasi_rw'] && $data['tgl_validasi_rw']) {
                                                        echo '<td><i class="fa fa-check-circle text-success"></i></td><td style="width: 95%;">Disetujui Ketua RW (' . $namarw['nama'] . ')</td>';
                                                    } elseif (!$data['validasi_rw'] && $data['tgl_validasi_rw']) {
                                                        echo '<td><i class="fa fa-exclamation-circle text-danger"></i></td><td style="width: 95%;">Ditolak Ketua RW<br><span class="text-muted"><em>' . $data['catatan_val_rw'] . '</em></span></td>';
                                                    } elseif (is_null($data['validasi_rw']) && is_null($data['tgl_validasi_rw'])) {
                                                        echo '<td><i class="fa fa-minus-circle text-muted"></i></td><td style="width: 95%;">Menunggu Validasi Ketua RW</td>';
                                                    }
                                                }
                                                ?>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <?php if (isset($_POST['submit']) && $data['validasi_rt'] && $data['tgl_validasi_rt'] && $data['validasi_rw'] && $data['tgl_validasi_rw']) { ?>
                                    <div class="form-group row mb-0">
                                        <label class="control-label col-md-3">&nbsp;</label>
                                        <div class="col-md-9">
                                            <a href="<?= $base_url . 'cetak.php?id=' . md5($data['id_pengajuan']) . '&code=' . md5($data['nik']) ?>" target="_blank" class="btn btn-danger mt-4"><i class="fa fa-file-pdf mr-3" aria-hidden="true"></i>Unduh Surat</a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>