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

// data warga
$sqlWarga = $conn->prepare("SELECT *
        FROM warga
        WHERE nik = :nik");
$sqlWarga->execute(['nik' => $_GET['id']]);
$warga = $sqlWarga->fetchObject();

if (isset($_POST['submit'])) {
    $kartu_keluarga = secureInput($_POST['kartu_keluarga']);
    $nik = secureInput($_POST['nik']);
    $nama = secureInput($_POST['nama']);
    $jk = secureInput($_POST['jk']);
    $tmp_lahir = secureInput($_POST['tmp_lahir']);
    $tgl_lahir = secureInput($_POST['tgl_lahir']);
    $gol_darah = secureInput($_POST['gol_darah']);
    $id_agama = secureInput($_POST['id_agama']);
    $id_pendidikan = secureInput($_POST['id_pendidikan']);
    $id_pekerjaan = secureInput($_POST['id_pekerjaan']);
    $id_status_kawin = secureInput($_POST['id_status_kawin']);
    $id_status_hubungan = secureInput($_POST['id_status_hubungan']);

    // validasi kartu keluarga harus 16 digit
    if (strlen($kartu_keluarga) != 16) {
        $alert->warning('Format kartu keluarga tidak valid!');
    } else {
        // validasi nik harus 16 digit
        if (strlen($nik) != 16) {
            $alert->warning('Format NIK tidak valid!');
        } else {
            // update data warga ke db
            $update = $conn->prepare("UPDATE warga SET kartu_keluarga = :kartu_keluarga, nama = :nama, jk = :jk, tmp_lahir = :tmp_lahir, tgl_lahir = :tgl_lahir, gol_darah = :gol_darah, id_agama = :id_agama, id_pendidikan = :id_pendidikan, id_pekerjaan = :id_pekerjaan, id_status_kawin = :id_status_kawin, id_status_hubungan = :id_status_hubungan WHERE nik = :nik");
            $update->execute([
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

            if ($update) $alert->success('Berhasil memperbarui data warga!', 'app.php?page=edit_warga&id=' . $warga->nik, true);
            else $alert->error('Gagal memperbarui data warga. Silahkan ulangi kembali!', 'app.php?page=edit_warga&id=' . $warga->nik, true);
        }
    }
}

?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Data Warga</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="app.php">Beranda</a></li>
                    <li class="breadcrumb-item">Data Warga</li>
                    <li class="breadcrumb-item active">Edit Data Warga</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <?= $alert->display() ?>
    <div class="card">
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . '?page=edit_warga&id=' . $warga->nik) ?>" class="form" method="post">
            <div class="card-body">
                <div class="form-group row">
                    <label for="nik" class="col-sm-3 col-form-label">NIK</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="nik" id="nik" value="<?= $warga->nik ?>" placeholder="NIK" minlength="16" maxlength="16" inputmode="numeric" required readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kartu_keluarga" class="col-sm-3 col-form-label">Nomor Kartu Keluarga</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="kartu_keluarga" id="kartu_keluarga" value="<?= $warga->kartu_keluarga ?>" placeholder="Nomor Kartu Keluarga" minlength="16" maxlength="16" inputmode="numeric" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama" class="col-sm-3 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama" id="nama" value="<?= $warga->nama ?>" placeholder="Nama Lengkap" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jk" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-9">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jk" id="jkl" value="L" <?= $warga->jk == 'L' ? 'checked' : '' ?>>
                            <label class="form-check-label">Laki-Laki</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jk" id="jkp" value="P" <?= $warga->jk == 'P' ? 'checked' : '' ?>>
                            <label class="form-check-label">Perempuan</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jk" class="col-sm-3 col-form-label">Tempat, Tanggal Lahir</label>
                    <div class="col-sm-3 mb-2">
                        <input type="text" class="form-control" name="tmp_lahir" id="tgl_lahir" value="<?= $warga->tmp_lahir ?>" placeholder="Tempat Lahir" required>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control datepicker" name="tgl_lahir" id="tgl_lahir" value="<?= date_format(date_create($warga->tgl_lahir), 'd-m-Y') ?>" placeholder="Tanggal Lahir" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jk" class="col-sm-3 col-form-label">Golongan Darah</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="gol_darah" id="gol_darah">
                            <option value="A" <?= $warga->gol_darah == 'A' ? 'selected' : '' ?>>A</option>
                            <option value="B" <?= $warga->gol_darah == 'B' ? 'selected' : '' ?>>B</option>
                            <option value="AB" <?= $warga->gol_darah == 'AB' ? 'selected' : '' ?>>AB</option>
                            <option value="O" <?= $warga->gol_darah == 'O' ? 'selected' : '' ?>>O</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jk" class="col-sm-3 col-form-label">Agama</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_agama" id="id_agama">
                            <?php foreach ($agama->fetchAll() as $agama) : ?>
                                <option value="<?= $agama['id_agama'] ?>" <?= $warga->id_agama == $agama['id_agama'] ? 'selected' : '' ?>><?= $agama['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jk" class="col-sm-3 col-form-label">Pendidikan Terakhir</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_pendidikan" id="id_pendidikan">
                            <?php foreach ($pendidikan->fetchAll() as $pendidikan) : ?>
                                <option value="<?= $pendidikan['id_pendidikan'] ?>" <?= $warga->id_agama == $pendidikan['id_pendidikan'] ? 'selected' : '' ?>><?= $pendidikan['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jk" class="col-sm-3 col-form-label">Pekerjaan</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_pekerjaan" id="id_pekerjaan">
                            <?php foreach ($pekerjaan->fetchAll() as $pekerjaan) : ?>
                                <option value="<?= $pekerjaan['id_pekerjaan'] ?>" <?= $warga->id_pekerjaan == $pekerjaan['id_pekerjaan'] ? 'selected' : '' ?>><?= $pekerjaan['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jk" class="col-sm-3 col-form-label">Status Perkawinan</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_status_kawin" id="id_status_kawin">
                            <?php foreach ($status_kawin->fetchAll() as $status_kawin) : ?>
                                <option value="<?= $status_kawin['id_status_kawin'] ?>" <?= $warga->id_status_kawin == $status_kawin['id_status_kawin'] ? 'selected' : '' ?>><?= $status_kawin['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jk" class="col-sm-3 col-form-label">Status Hubungan</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_status_hubungan" id="id_status_hubungan">
                            <?php foreach ($status_hubungan->fetchAll() as $status_hubungan) : ?>
                                <option value="<?= $status_hubungan['id_status_hubungan'] ?>" <?= $warga->id_status_hubungan == $status_hubungan['id_status_hubungan'] ? 'selected' : '' ?>><?= $status_hubungan['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jk" class="col-sm-3 col-form-label">&nbsp;</label>
                    <div class="col-sm-9">
                        <a href="app.php?page=warga" class="btn btn-danger"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i> Kembali</a>
                        <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save mr-2" aria-hidden="true"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </form>
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