<?php
// validasi hak akses
aksesOnly(4);

// data agama
$agama = $conn->prepare("SELECT * FROM ref_agama");
$agama->execute();


// proses tambah warga
if (isset($_POST['kartu_keluarga'])) {
    $kartu_keluarga = secureInput($_POST['kartu_keluarga']);
    $nik = secureInput($_POST['nik']);
    $nama = secureInput($_POST['nama']);
    $jk = secureInput($_POST['jk']);
    $tmp_lahir = secureInput($_POST['tmp_lahir']);
    $tgl_lahir = secureInput($_POST['tgl_lahir']);
    $gol_darah = secureInput($_POST['gol_darah']);
    $id_agama = secureInput($_POST['id_agama']);
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
                try {
                    $conn->beginTransaction();

                    // simpan data warga ke db
                    $insert = $conn->prepare("INSERT INTO warga (nik, kartu_keluarga, nama, jk, tmp_lahir, tgl_lahir, gol_darah, id_agama, id_pendidikan, id_pekerjaan, id_status_kawin, id_status_hubungan) VALUES (:nik, :kartu_keluarga, :nama, :jk, :tmp_lahir, :tgl_lahir, :gol_darah, :id_agama, :id_pendidikan, :id_pekerjaan, :id_status_kawin, :id_status_hubungan)");
                    $insert->execute([
                        'nik' => $nik,
                        'kartu_keluarga' => $kartu_keluarga,
                        'nama' => implode('-', array_map('ucfirst', explode('-', ucwords($nama)))),
                        'jk' => $jk,
                        'tmp_lahir' => ucwords(strtolower($tmp_lahir)),
                        'tgl_lahir' => date_format(date_create($tgl_lahir), 'Y-m-d'),
                        'gol_darah' => $gol_darah ?: null,
                        'id_agama' => $id_agama,
                        'id_pendidikan' => 2,
                        'id_pekerjaan' => 1,
                        'id_status_kawin' => 1,
                        'id_status_hubungan' => 4
                    ]);

                    // simpan laporan kelahiran
                    $lahir = $conn->prepare("INSERT INTO rwt_kelahiran (nik, tgl_lapor) VALUES (:nik, :tgl_lapor)");
                    $lahir->execute(['nik' => $nik, 'tgl_lapor' => date('Y-m-d H:i:s')]);

                    $conn->commit();

                    if ($insert) $alert->success('Berhasil menambahkan data laporan kelahiran!');
                    else $alert->error('Gagal menambahkan data laporan kelahiran. Silahkan ulangi kembali!');
                } catch (PDOException $e) {
                    $conn->rollBack();

                    $alert->error('Gagal menambahkan data laporan kelahiran. Silahkan ulangi kembali! ' . $e->getMessage());
                }
            }
        }
    }
}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tambah Laporan Kelahiran</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="app.php">Beranda</a></li>
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item active">Laporan Kelahiran</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <?= $alert->display() ?>
    <div class="card">
        <div class="card-body">
            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . '?page=tambah_lap_kelahiran'); ?>" class="form form-horizontal" method="post">
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
                        <input type="text" class="form-control" name="tmp_lahir" id="tgl_lahir" placeholder="Tempat Lahir" required>
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
                    <label class="col-sm-3 col-form-label">&nbsp;</label>
                    <div class="col-sm-9">
                        <a href="app.php?page=lap_kelahiran" class="btn btn-danger"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2" aria-hidden="true"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    $(function() {
        $('#gol_darah, #id_agama').select2({
            minimumResultsForSearch: -1
        });

        $('#id_status_hubungan').select2();
    })
</script>