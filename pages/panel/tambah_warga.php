<?php
// validasi hak akses
aksesOnly(4);

// data agama
$agama = $conn->prepare("SELECT * FROM ref_agama");
$agama->execute();

// data pendidikan
$pendidikan = $conn->prepare("SELECT * FROM ref_pendidikan");
$pendidikan->execute();

// data pekerjaan
$pekerjaan = $conn->prepare("SELECT * FROM ref_pekerjaan");
$pekerjaan->execute();

// data status kawin
$status_kawin = $conn->prepare("SELECT * FROM ref_status_kawin");
$status_kawin->execute();

// data status hubungan
$status_hubungan = $conn->prepare("SELECT * FROM ref_status_hubungan");
$status_hubungan->execute();

// proses tambah warga
if (isset($_POST['kartu_keluarga'])) {
    $kartu_keluarga = secureInput($_POST['kartu_keluarga']);
    $nik = secureInput($_POST['nik']);
    $nama = secureInput($_POST['nama']);
    $jk = secureInput($_POST['jk']);
    $tmp_lahir = secureInput($_POST['tmp_lahir']);
    $tgl_lahir = secureInput($_POST['tgl_lahir']);
    $gol_darah = $_POST['gol_darah'] ?: null;
    $id_agama = secureInput($_POST['id_agama']);
    $id_pendidikan = secureInput($_POST['id_pendidikan']);
    $id_pekerjaan = secureInput($_POST['id_pekerjaan']);
    $id_status_kawin = secureInput($_POST['id_status_kawin']);
    $id_status_hubungan = secureInput($_POST['id_status_hubungan']);

    // validasi kartu keluarga
    // harus 16 digit
    if (strlen($kartu_keluarga) != 16) {
        $alert->warning('Format kartu keluarga tidak valid!');
    } else {
        // validasi nik
        // harus 16 digit
        if (strlen($nik) != 16) {
            $alert->warning('Format NIK tidak valid!');
        } else {
            // cek nik apakah sudah ada di db
            $qnik = $conn->prepare('SELECT nik FROM warga WHERE nik = :nik LIMIT 1');
            $qnik->execute(['nik' => $nik]);

            // nik sudah ada di db
            if ($qnik->rowCount()) {
                $alert->warning('NIK sudah ada. Periksa kembali NIK yang diinputkan!');
            } else {
                // simpan data warga ke db
                $insert = $conn->prepare("INSERT INTO warga (nik, kartu_keluarga, nama, jk, tmp_lahir, tgl_lahir, gol_darah, id_agama, id_pendidikan, id_pekerjaan, id_status_kawin, id_status_hubungan) VALUES (:nik, :kartu_keluarga, :nama, :jk, :tmp_lahir, :tgl_lahir, :gol_darah, :id_agama, :id_pendidikan, :id_pekerjaan, :id_status_kawin, :id_status_hubungan)");
                $insert->execute([
                    'nik' => $nik,
                    'kartu_keluarga' => $kartu_keluarga,
                    'nama' => implode('-', array_map('ucfirst', explode('-', ucwords($nama)))),
                    'jk' => $jk,
                    'tmp_lahir' => ucwords(strtolower($tmp_lahir)),
                    'tgl_lahir' => date_format(date_create($tgl_lahir), 'Y-m-d'),
                    'gol_darah' => $gol_darah,
                    'id_agama' => $id_agama,
                    'id_pendidikan' => $id_pendidikan,
                    'id_pekerjaan' => $id_pekerjaan,
                    'id_status_kawin' => $id_status_kawin,
                    'id_status_hubungan' => $id_status_hubungan
                ]);

                if ($insert) $alert->success('Berhasil menambahkan data warga!');
                else $alert->error('Gagal menambahkan data warga. Silahkan ulangi kembali!');
            }
        }
    }
}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tambah Data Warga</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="app.php">Beranda</a></li>
                    <li class="breadcrumb-item">Data Warga</li>
                    <li class="breadcrumb-item active">Tambah Data Warga</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <?= $alert->display() ?>
    <div class="card">
        <div class="card-body">
            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . '?page=tambah_warga'); ?>" class="form form-horizontal" method="post">
                <div class="form-group row">
                    <label for="kartu_keluarga" class="col-sm-3 col-form-label">Nomor Kartu Keluarga</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="kartu_keluarga" id="kartu_keluarga" placeholder="Nomor Kartu Keluarga" minlength="16" maxlength="16" inputmode="numeric" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nik" class="col-sm-3 col-form-label">NIK</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="nik" id="nik" placeholder="NIK" minlength="16" maxlength="16" inputmode="numeric" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama" class="col-sm-3 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Lengkap" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jk" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-9">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jk" id="jkl" value="L" checked>
                            <label class="form-check-label">Laki-Laki</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jk" id="jkp" value="P">
                            <label class="form-check-label">Perempuan</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jk" class="col-sm-3 col-form-label">Tempat, Tanggal Lahir</label>
                    <div class="col-sm-3 mb-2">
                        <input type="text" class="form-control" name="tmp_lahir" id="tmp_lahir" placeholder="Tempat Lahir" required>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control datepicker" name="tgl_lahir" id="tgl_lahir" placeholder="Tanggal Lahir" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jk" class="col-sm-3 col-form-label">Golongan Darah</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="gol_darah" id="gol_darah">
                            <option value="">Tidak Tahu</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jk" class="col-sm-3 col-form-label">Agama</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_agama" id="id_agama">
                            <?php foreach ($agama->fetchAll() as $agama) : ?>
                                <option value="<?= $agama['id_agama'] ?>"><?= $agama['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jk" class="col-sm-3 col-form-label">Pendidikan Terakhir</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_pendidikan" id="id_pendidikan">
                            <?php foreach ($pendidikan->fetchAll() as $pendidikan) : ?>
                                <option value="<?= $pendidikan['id_pendidikan'] ?>"><?= $pendidikan['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jk" class="col-sm-3 col-form-label">Pekerjaan</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_pekerjaan" id="id_pekerjaan">
                            <?php foreach ($pekerjaan->fetchAll() as $pekerjaan) : ?>
                                <option value="<?= $pekerjaan['id_pekerjaan'] ?>"><?= $pekerjaan['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jk" class="col-sm-3 col-form-label">Status Perkawinan</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_status_kawin" id="id_status_kawin">
                            <?php foreach ($status_kawin->fetchAll() as $status_kawin) : ?>
                                <option value="<?= $status_kawin['id_status_kawin'] ?>"><?= $status_kawin['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jk" class="col-sm-3 col-form-label">Status Hubungan</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_status_hubungan" id="id_status_hubungan">
                            <?php foreach ($status_hubungan->fetchAll() as $status_hubungan) : ?>
                                <option value="<?= $status_hubungan['id_status_hubungan'] ?>"><?= $status_hubungan['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <a href="app.php?page=warga" class="btn btn-danger"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i> Kembali</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2" aria-hidden="true"></i> Simpan</button>
            </form>
        </div>
    </div>
</section>

<script>
    $(function() {
        $('#gol_darah, #id_agama, #id_status_kawin').select2({
            minimumResultsForSearch: -1
        });

        $('#id_pendidikan, #id_pekerjaan, #id_status_hubungan').select2();
    })
</script>