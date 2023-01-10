<?php
// validasi hak akses
aksesOnly([1, 2, 3, 4]);

// data detail warga
$sqlWarga = $conn->prepare("SELECT w.*, a.nama AS nama_agama, p.nama AS nama_pendidikan, k.nama AS nama_pekerjaan, sk.nama AS status_kawin, sh.nama AS status_hubungan
        FROM warga w
        LEFT JOIN ref_agama a ON a.id_agama = w.id_agama
        LEFT JOIN ref_pendidikan p ON p.id_pendidikan = w.id_pendidikan
        LEFT JOIN ref_pekerjaan k ON k.id_pekerjaan = w.id_pekerjaan
        LEFT JOIN ref_status_kawin sk ON sk.id_status_kawin = w.id_status_kawin
        LEFT JOIN ref_status_hubungan sh ON sh.id_status_hubungan = w.id_status_hubungan
        WHERE w.nik = :nik");
$sqlWarga->execute(['nik' => $_GET['id']]);
$warga = $sqlWarga->fetch();

// ambil data anggota keluarga dalam satu kartu keluarga
$sqlKeluarga = $conn->prepare("SELECT w.*, a.nama AS nama_agama, p.nama AS nama_pendidikan, k.nama AS nama_pekerjaan, sk.nama AS status_kawin, sh.nama AS status_hubungan
        FROM warga w
        LEFT JOIN ref_agama a ON a.id_agama = w.id_agama
        LEFT JOIN ref_pendidikan p ON p.id_pendidikan = w.id_pendidikan
        LEFT JOIN ref_pekerjaan k ON k.id_pekerjaan = w.id_pekerjaan
        LEFT JOIN ref_status_kawin sk ON sk.id_status_kawin = w.id_status_kawin
        LEFT JOIN ref_status_hubungan sh ON sh.id_status_hubungan = w.id_status_hubungan
        WHERE kartu_keluarga = :kartu_keluarga
        ORDER BY id_status_hubungan ASC");
$sqlKeluarga->execute(['kartu_keluarga' => $warga['kartu_keluarga']]);
$keluarga = $sqlKeluarga->fetchAll();
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detail Data Warga</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="app.php">Beranda</a></li>
                    <li class="breadcrumb-item">Data Warga</li>
                    <li class="breadcrumb-item active">Detail Data Warga</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card">
        <div class="card-header">
            <a href="app.php?page=warga" class="btn btn-danger"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i> Kembali</a>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-6">
                    <label class="control-label">Nomor Kartu Keluarga</label>
                    <p><?= $warga['kartu_keluarga'] ?></p>
                </div>
                <div class="col-md-6">
                    <label class="control-label">Nomor Induk Kependudukan</label>
                    <p><?= $warga['nik'] ?></p>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label class="control-label">Nama Lengkap</label>
                    <p><?= $warga['nama'] ?></p>
                </div>
                <div class="col-md-6">
                    <label class="control-label">Jenis Kelamin</label>
                    <p><?= $warga['jk'] ?></p>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label class="control-label">Tempat, Tanggal Lahir</label>
                    <p><?= $warga['tmp_lahir'] . ', ' . date_format(date_create($warga['tgl_lahir']), 'd M Y') ?></p>
                </div>
                <div class="col-md-6">
                    <label class="control-label">Golongan Darah</label>
                    <p><?= $warga['gol_darah'] ?></p>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label class="control-label">Agama</label>
                    <p><?= $warga['nama_agama'] ?></p>
                </div>
                <div class="col-md-6">
                    <label class="control-label">Pendidikan</label>
                    <p><?= $warga['nama_pendidikan'] ?></p>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label class="control-label">Pekerjaan</label>
                    <p><?= $warga['nama_pekerjaan'] ?></p>
                </div>
                <div class="col-md-6">
                    <label class="control-label">Status Perkawinan</label>
                    <p><?= $warga['status_kawin'] ?></p>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label class="control-label">Status Hubungan</label>
                    <p><?= $warga['status_hubungan'] ?></p>
                </div>
                <div class="col-md-6">
                    <label class="control-label">Alamat</label>
                    <p><?= $warga['alamat'] ?: '-' ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Kartu Keluarga</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover" id="table">
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>LP</th>
                        <th>Tempat, Tanggal Lahir</th>
                        <th>Agama</th>
                        <th>Pendidikan</th>
                        <th>Jenis Pekerjaan</th>
                        <th>Darah</th>
                        <th>Status Perkawinan</th>
                        <th>Status Hubungan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($keluarga as $row) { ?>
                        <tr>
                            <td><?= $row['nik'] ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['jk'] ?></td>
                            <td><?= $row['tmp_lahir'] . ', ' . date_format(date_create($row['tgl_lahir']), 'd M Y') ?></td>
                            <td><?= $row['nama_agama'] ?></td>
                            <td><?= $row['nama_pendidikan'] ?></td>
                            <td><?= $row['nama_pekerjaan'] ?></td>
                            <td><?= $row['gol_darah'] ?></td>
                            <td><?= $row['status_kawin'] ?></td>
                            <td><?= $row['status_hubungan'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>