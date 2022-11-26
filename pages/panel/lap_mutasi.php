<?php
// validasi hak akses
aksesOnly([2, 3, 4]);

// ambil data warga kecuali data warga yang sudah ada di table rwt_kematian dan mutasi keluar
$warga = $conn->prepare("SELECT * FROM (SELECT w.nik, w.kartu_keluarga, w.nama, w.jk, w.tmp_lahir, w.tgl_lahir, timestampdiff(year, w.tgl_lahir, curdate()) as umur, w.id_status_kawin, w.id_status_hubungan, p.nama AS pekerjaan
    FROM warga w
    LEFT JOIN ref_pekerjaan p ON p.id_pekerjaan = w.id_pekerjaan
    WHERE NOT EXISTS (SELECT nik FROM rwt_kematian k WHERE k.nik = w.nik)) AS w1
    WHERE NOT EXISTS (SELECT * FROM rwt_mutasi m WHERE m.nik = w1.nik AND m.jenis_mutasi = 'keluar')
    ORDER BY w1.nama ASC");
$warga->execute();
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
                        <input type="hidden" name="id" id="id" value="" readonly>
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
    $(function(){
        $('#nik').select2({
            dropdownParent: $('#modal-tambah'),
        });
    })
</script>