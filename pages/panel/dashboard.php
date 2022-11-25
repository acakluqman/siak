<?php
// hitung jumlah pengguna
$pengguna = $conn->prepare("SELECT * FROM pengguna");
$pengguna->execute();

// hitung jumlah warga
$warga = $conn->prepare("SELECT * FROM (
    SELECT *
    FROM warga w
    WHERE NOT EXISTS (SELECT nik FROM rwt_kematian k WHERE k.nik = w.nik)) AS w1
    WHERE NOT EXISTS (SELECT * FROM rwt_mutasi m WHERE m.nik = w1.nik)");
$warga->execute();

// hitung jumlah riwayat pengajuan surat
$pengajuan = $conn->prepare("SELECT * FROM rwt_pengajuan");
$pengajuan->execute();

// hitung jumlah warga laki-laki
$hitungL = $conn->prepare("SELECT COUNT(*) AS jml FROM (
    SELECT *
    FROM warga w
    WHERE NOT EXISTS (SELECT nik FROM rwt_kematian k WHERE k.nik = w.nik)) AS w1
    WHERE NOT EXISTS (SELECT * FROM rwt_mutasi m WHERE m.nik = w1.nik)
    AND w1.jk = :jk");
$hitungL->execute(['jk' => 'L']);
$jumlahL = $hitungL->fetch();

// hitung jumlah warga perempuan
$hitungP = $conn->prepare("SELECT COUNT(*) AS jml FROM (
    SELECT *
    FROM warga w
    WHERE NOT EXISTS (
        SELECT nik FROM rwt_kematian k WHERE k.nik = w.nik)
        ) AS w1
    WHERE NOT EXISTS (
        SELECT * FROM rwt_mutasi m WHERE m.nik = w1.nik
        )
    AND w1.jk = :jk");
$hitungP->execute(['jk' => 'P']);
$jumlahP = $hitungP->fetch();

// grafik kematian
$kematian = array();
for ($i = 12; $i >= 0; $i -= 1) {
    $tahun_bulan = date("Y-m", strtotime("-$i Months"));
    // hitung jumlah kematian berdasarkan bulan dan tahun
    $hitungJml = $conn->prepare("SELECT COUNT(*) AS jumlah FROM rwt_kematian WHERE DATE_FORMAT(tgl_meninggal, '%Y-%m') = :bulan_tahun");
    $hitungJml->execute(['bulan_tahun' => $tahun_bulan]);
    $jumlah = $hitungJml->fetch();

    $kematian['bulan'][] = date_format(date_create($tahun_bulan), 'M Y');
    $kematian['jumlah'][] = $jumlah['jumlah'];
}

// grafik kelahiran
$kelahiran = array();
for ($i = 12; $i >= 0; $i -= 1) {
    $tahun_bulan = date("Y-m", strtotime("-$i Months"));
    // hitung jumlah kelahiran berdasarkan bulan dan tahun
    $hitungJml = $conn->prepare("SELECT COUNT(*) AS jumlah FROM rwt_kelahiran k LEFT JOIN warga w ON w.nik = k.nik WHERE DATE_FORMAT(w.tgl_lahir, '%Y-%m') = :bulan_tahun");
    $hitungJml->execute(['bulan_tahun' => $tahun_bulan]);
    $jumlah = $hitungJml->fetch();

    $kelahiran['bulan'][] = date_format(date_create($tahun_bulan), 'M Y');
    $kelahiran['jumlah'][] = $jumlah['jumlah'];
}

// grafik umur
$grafikUmur = $conn->prepare("SELECT COUNT(IF(umur < 5, 1, null)) AS 'balita', COUNT(IF(umur BETWEEN 5 AND 11, 1, null)) AS 'anak', COUNT(IF(umur BETWEEN 12 AND 25, 1, null)) AS 'remaja', COUNT(IF(umur BETWEEN 26 AND 45, 1, null)) AS 'dewasa', COUNT(IF(umur BETWEEN 45 AND 55, 1, null)) AS 'pralansia', COUNT(IF(umur > 55, 1, null)) AS 'lansia' FROM (
    SELECT w1.nama, w1.tgl_lahir, timestampdiff(year, tgl_lahir, CURDATE()) AS umur FROM (
        SELECT *
        FROM warga w
        WHERE NOT EXISTS (
            SELECT nik FROM rwt_kematian k WHERE k.nik = w.nik)
            ) AS w1
            WHERE NOT EXISTS (
                SELECT * FROM rwt_mutasi m WHERE m.nik = w1.nik
                )) AS grafik_umur");
$grafikUmur->execute();

$umur = array();
foreach ($grafikUmur->fetchObject() as $key => $row) {
    $umur['usia'][] = ucfirst($key);
    $umur['jumlah'][] = $row;
}

// grafik pengajuan
$surat = array();
for ($i = 12; $i >= 0; $i -= 1) {
    $tahun_bulan = date("Y-m", strtotime("-$i Months"));
    // hitung jumlah pengajuan surat berdasarkan bulan dan tahun
    $hitungJml = $conn->prepare("SELECT COUNT(*) AS jumlah FROM rwt_pengajuan WHERE DATE_FORMAT(tgl_ajuan, '%Y-%m') = :bulan_tahun");
    $hitungJml->execute(['bulan_tahun' => $tahun_bulan]);
    $jumlah = $hitungJml->fetch();

    $surat['bulan'][] = date_format(date_create($tahun_bulan), 'M Y');
    $surat['jumlah'][] = $jumlah['jumlah'];
}

?>
<section class="content pt-4">
    <div class="container-fluid">
        <div class="row">
            <?php if ($_SESSION['level'] == 1) : ?>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $pengguna->rowCount() ?></h3>
                            <p>Total Pengguna</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                    </div>
                </div>
            <?php endif ?>

            <?php if ($_SESSION['level'] == 4) : ?>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $warga->rowCount() ?></h3>
                            <p>Total Warga</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-stalker"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $pengajuan->rowCount() ?></h3>
                            <p>Total Pengajuan</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-paper-outline"></i>
                        </div>
                    </div>
                </div>
            <?php endif ?>

            <?php if (in_array($_SESSION['level'], [2, 3])) : ?>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>53</h3>
                            <p>Total Warga</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-stalker"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>44</h3>
                            <p>Total Pengajuan</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-paper-outline"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>65</h3>
                            <p>Menunggu Validasi</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-compose"></i>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</section>
<?php if (in_array($_SESSION['level'], [2, 3, 4])) { ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Grafik Kematian</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="grafik-kematian" width="800" height="450"></canvas>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Grafik Kelahiran</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="grafik-kelahiran" width="800" height="450"></canvas>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Grafik Mutasi Keluar Masuk</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="grafik-mutasi" width="800" height="450"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Jumlah Penduduk Berdasarkan Jenis Kelamin</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="grafik-kelamin" width="800" height="450"></canvas>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Jumlah Penduduk Berdasarkan Umur</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="grafik-umur" width="800" height="450"></canvas>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Jumlah Permintaan Surat Keterangan</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="grafik-surat" width="800" height="450"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // grafik kematian
        new Chart(document.getElementById("grafik-kematian"), {
            type: 'line',
            data: {
                labels: <?= json_encode($kematian['bulan']) ?>,
                datasets: [{
                    data: <?= json_encode($kematian['jumlah']) ?>,
                    label: "Angka Kematian",
                    borderColor: "#c45850",
                    fill: false
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Jumlah Angka Kematian per Bulan'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            precision: 0,
                            beginAtZero: true,
                        },
                    }, ],
                },
            }
        });

        // grafik kelahiran
        new Chart(document.getElementById("grafik-kelahiran"), {
            type: 'line',
            data: {
                labels: <?= json_encode($kelahiran['bulan']) ?>,
                datasets: [{
                    data: <?= json_encode($kelahiran['jumlah']) ?>,
                    label: "Angka Kelahiran",
                    borderColor: "#8e5ea2",
                    fill: false
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Jumlah Angka Kelahiran per Bulan'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            precision: 0,
                            beginAtZero: true,
                        },
                    }, ],
                },
            }
        });

        // grafik jumlah penduduk berdasarkan jenis kelamin
        new Chart(document.getElementById("grafik-kelamin"), {
            type: 'doughnut',
            data: {
                labels: ["Laki-Laki", "Perempuan"],
                datasets: [{
                    label: "Warga",
                    backgroundColor: ["#3e95cd", "#8e5ea2"],
                    data: [<?= $jumlahL['jml'] ?>, <?= $jumlahP['jml'] ?>]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Jumlah Perbandingan Penduduk Berdasarkan Jenis Kelamin'
                }
            }
        });

        // grafik mutasi
        new Chart(document.getElementById("grafik-mutasi"), {
            type: 'bar',
            data: {
                labels: ["2019", "2020", "2021", "2022"],
                datasets: [{
                    label: "Mutasi Keluar",
                    backgroundColor: "#c45850",
                    data: [133, 221, 783, 2478]
                }, {
                    label: "Mutasi Masuk",
                    backgroundColor: "#3e95cd",
                    data: [408, 547, 675, 734]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Grafik Mutasi Keluar Masuk Warga'
                }
            }
        });

        // grafik jumlah penduduk berdasarkan umur
        new Chart(document.getElementById("grafik-umur"), {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($umur['usia']) ?>,
                datasets: [{
                    label: "Warga",
                    backgroundColor: ["#e8c3b9", "#c45850", "#3e95cd", "#8e5ea2", "#3cba9f", "#c476g4"],
                    data: <?= json_encode($umur['jumlah']) ?>
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Jumlah Perbandingan Penduduk Berdasarkan Umur'
                }
            }
        });

        // grafik surat
        new Chart(document.getElementById("grafik-surat"), {
            type: 'line',
            data: {
                labels: <?= json_encode($surat['bulan']) ?>,
                datasets: [{
                    data: <?= json_encode($surat['jumlah']) ?>,
                    label: "Jumlah Permintaan",
                    borderColor: "#3cba9f",
                    fill: false
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Jumlah Angka Permintaan Surat Keterangan'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            precision: 0,
                            beginAtZero: true,
                        },
                    }],
                },
            }
        });
    </script>
<?php } ?>