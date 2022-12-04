<?php
if (isset($_POST['submit'])) {
    $nik = secureInput($_POST['nik']);
    $tahun = secureInput(substr($_POST['kode_permohonan'], 0, 2));
    $bulan = secureInput(substr($_POST['kode_permohonan'], 2, 2));
    $id = secureInput(substr($_POST['kode_permohonan'], 4));

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
                                <input type="text" class="form-control" name="nik" id="nik" value="<?= isset($_POST['nik']) ? $_POST['nik'] : '' ?>" placeholder="Masukkan NIK Pemohon" required>
                            </div>
                            <div class="form-group">
                                <label for="kode_permohonan">Kode Permohonan</label>
                                <input type="text" class="form-control" name="kode_permohonan" id="kode_permohonan" value="<?= isset($_POST['kode_permohonan']) ? $_POST['kode_permohonan'] : '' ?>" placeholder="Masukkan Kode Permohonan" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Cek Status</button>
                        </form>

                        <?php if (isset($_POST['kode_permohonan'])) : ?>
                            <div class="pt-4" id="result">
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
                                        <p><?= date_format(date_create($data['tgl_ajuan']), 'd M Y H:i A') ?></p>
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
                                                    echo '<td><i class="fa fa-check-circle text-success"></i></td><td style="width: 95%;">Disetujui Ketua RT</td>';
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
                                                        echo '<td><i class="fa fa-check-circle text-success"></i></td><td style="width: 95%;">Disetujui Ketua RW</td>';
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

                                <?php if ($data['validasi_rt'] && $data['tgl_validasi_rt'] && $data['validasi_rw'] && $data['tgl_validasi_rw']) { ?>
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