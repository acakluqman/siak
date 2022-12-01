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

$warga = $conn->prepare("SELECT * FROM (SELECT w.nik, w.nama
    FROM warga w
    WHERE NOT EXISTS (SELECT nik FROM rwt_kematian k WHERE k.nik = w.nik)) AS w1
    WHERE NOT EXISTS (SELECT * FROM rwt_mutasi m WHERE m.nik = w1.nik AND m.jenis_mutasi = 'keluar')
    ORDER BY w1.nama ASC");
$warga->execute();

// proses tambah mutasi
if (isset($_POST['jenis_mutasi'])) {
    $jenis_mutasi = $_POST['jenis_mutasi'];
    $nikk = $_POST['nikk'];
    $nikm = $_POST['nikm'];
    $tgl_mutasi = date('Y-m-d');
    $kartu_keluarga = $_POST['kartu_keluarga'];
    $nama = $_POST['nama'];
    $jk = $_POST['jk'];
    $tmp_lahir = $_POST['tmp_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $gol_darah = $_POST['gol_darah'];
    $id_agama = $_POST['id_agama'];

    if ($_POST['jenis_mutasi'] == 'keluar') {
        $insert = $conn->prepare("INSERT INTO rwt_mutasi (jenis_mutasi, nik, tgl_mutasi) VALUES(:jenis_mutasi, :nik, :tgl_mutasi)");
        $insert->execute(['jenis_mutasi' => $jenis_mutasi, 'nik' => $nikk, 'tgl_mutasi' => $tgl_mutasi]);

        if ($insert) $alert->success('Berhasil menambahkan data mutasi!', 'app.php?page=lap_mutasi', true);
        else $alert->error('Gagal menambahkan data mutasi. Silahkan ulangi kembali!', 'app.php?page=lap_mutasi', true);
    } else {
        // validasi kartu keluarga
        // harus 16 digit
        if (strlen($kartu_keluarga) != 16) {
            $alert->warning('Format kartu keluarga tidak valid!');
        } else {
            // validasi nik
            // harus 16 digit
            if (strlen($nikm) != 16) {
                $alert->warning('Format NIK tidak valid!');
            } else {
                // cek nik apakah sudah ada di db
                $qnik = $conn->prepare('SELECT nik FROM warga WHERE nik = :nik LIMIT 1');
                $qnik->execute(['nik' => $nikm]);

                // nik sudah ada di db
                if ($qnik->rowCount()) {
                    $alert->warning('NIK sudah ada. Periksa kembali NIK yang diinputkan!');
                } else {
                    try {
                        $conn->beginTransaction();

                        // simpan data warga ke db
                        $insert = $conn->prepare("INSERT INTO warga (nik, kartu_keluarga, nama, jk, tmp_lahir, tgl_lahir, gol_darah, id_agama, id_pendidikan, id_pekerjaan, id_status_kawin, id_status_hubungan) VALUES (:nik, :kartu_keluarga, :nama, :jk, :tmp_lahir, :tgl_lahir, :gol_darah, :id_agama, :id_pendidikan, :id_pekerjaan, :id_status_kawin, :id_status_hubungan)");
                        $insert->execute([
                            'nik' => $nikm,
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

                        // simpan data mutasi
                        $insert = $conn->prepare("INSERT INTO rwt_mutasi (jenis_mutasi, nik, tgl_mutasi) VALUES(:jenis_mutasi, :nik, :tgl_mutasi)");
                        $insert->execute(['jenis_mutasi' => $jenis_mutasi, 'nik' => $nikk, 'tgl_mutasi' => $tgl_mutasi]);

                        $conn->commit();

                        if ($insert) $alert->success('Berhasil menambahkan data mutasi!', 'app.php?page=lap_mutasi', true);
                        else $alert->error('Gagal menambahkan data mutasi. Silahkan ulangi kembali!', 'app.php?page=lap_mutasi', true);
                    } catch (PDOException $e) {
                        $conn->rollBack();

                        $alert->error('Gagal menambahkan data laporan mutasi. Silahkan ulangi kembali! ' . $e->getMessage());
                    }
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
            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . '?page=tambah_lap_mutasi'); ?>" name="form" class="form" method="post">
                <div class="form-group row">
                    <label for="mutasim" class="col-sm-3 col-form-label">Jenis Mutasi</label>
                    <div class="col-sm-9">
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

                <div class="form-group row">
                    <label for="tgl_mutasi" class="col-sm-3 col-form-label">Tanggal Mutasi</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control datepicker" name="tgl_mutasi" id="tgl_mutasi" placeholder="Tanggal Mutasi" required>
                    </div>
                </div>

                <div id="mutasimasuk">
                    <div class="form-group row">
                        <label for="kartu_keluarga" class="col-sm-3 col-form-label">Nomor Kartu Keluarga</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="kartu_keluarga" id="kartu_keluarga" placeholder="Nomor Kartu Keluarga" minlength="16" maxlength="16" inputmode="numeric" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nik" class="col-sm-3 col-form-label">NIK</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="nikm" id="nikm" placeholder="NIK" minlength="16" maxlength="16" inputmode="numeric" required>
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
                        <label for="tmp_lahir" class="col-sm-3 col-form-label">Tempat, Tanggal Lahir</label>
                        <div class="col-sm-3 mb-2">
                            <input type="text" class="form-control" name="tmp_lahir" id="tmp_lahir" placeholder="Tempat Lahir" required>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control datepicker" name="tgl_lahir" id="tgl_lahir" placeholder="Tanggal Lahir" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="gol_darah" class="col-sm-3 col-form-label">Golongan Darah</label>
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
                        <label for="id_agama" class="col-sm-3 col-form-label">Agama</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="id_agama" id="id_agama">
                                <?php foreach ($agama->fetchAll() as $agama) : ?>
                                    <option value="<?= $agama['id_agama'] ?>"><?= $agama['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_pendidikan" class="col-sm-3 col-form-label">Pendidikan Terakhir</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="id_pendidikan" id="id_pendidikan">
                                <?php foreach ($pendidikan->fetchAll() as $pendidikan) : ?>
                                    <option value="<?= $pendidikan['id_pendidikan'] ?>"><?= $pendidikan['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_pekerjaan" class="col-sm-3 col-form-label">Pekerjaan</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="id_pekerjaan" id="id_pekerjaan">
                                <?php foreach ($pekerjaan->fetchAll() as $pekerjaan) : ?>
                                    <option value="<?= $pekerjaan['id_pekerjaan'] ?>"><?= $pekerjaan['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_status_kawin" class="col-sm-3 col-form-label">Status Perkawinan</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="id_status_kawin" id="id_status_kawin">
                                <?php foreach ($status_kawin->fetchAll() as $status_kawin) : ?>
                                    <option value="<?= $status_kawin['id_status_kawin'] ?>"><?= $status_kawin['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_status_hubungan" class="col-sm-3 col-form-label">Status Hubungan</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="id_status_hubungan" id="id_status_hubungan">
                                <?php foreach ($status_hubungan->fetchAll() as $status_hubungan) : ?>
                                    <option value="<?= $status_hubungan['id_status_hubungan'] ?>"><?= $status_hubungan['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="mutasikeluar" style="display: none;">
                    <div class="form-group row">
                        <label for="nikk" class="col-sm-3 col-form-label">Pilih Warga</label>
                        <div class="col-sm-9">
                            <select class="form-control select2" name="nikk" id="nikk" required>
                                <?php foreach ($warga as $row) : ?>
                                    <option value="<?= $row['nik'] ?>"><?= $row['nik'] . ' - ' . $row['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">&nbsp;</label>
                    <div class="col-sm-9">
                        <a href="app.php?page=lap_mutasi" class="btn btn-danger"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i> Kembali</a>
                        <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save mr-2" aria-hidden="true"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    var radio = document.form.jenis_mutasi;
    var keluar = document.getElementById('mutasikeluar');
    var masuk = document.getElementById('mutasimasuk');
    var prev = null;

    $(function() {
        $('#gol_darah, #id_agama, #id_status_kawin').select2({
            minimumResultsForSearch: -1
        });

        $('#id_pendidikan, #id_pekerjaan, #id_status_hubungan').select2();

        $('#nikk').select2();

        for (var i = 0; i < radio.length; i++) {
            radio[i].onclick = function() {
                if (this.value == "masuk") {
                    document.getElementById('nikk').required = false;
                    masuk.style.display = 'block';
                    keluar.style.display = 'none';
                } else {
                    document.getElementById('nikm').required = false;
                    document.getElementById('kartu_keluarga').required = false;
                    document.getElementById('nama').required = false;
                    document.getElementById('tmp_lahir').required = false;
                    document.getElementById('tgl_lahir').required = false;
                    masuk.style.display = 'none';
                    keluar.style.display = 'block';
                }
            };
        }
    })
</script>