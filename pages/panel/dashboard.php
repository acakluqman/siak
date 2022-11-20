<?php
// hitung jumlah pengguna
$pengguna = $conn->prepare("SELECT * FROM pengguna");
$pengguna->execute();

// hitung jumlah warga
$warga = $conn->prepare("SELECT * FROM warga");
$warga->execute();

// hitung jumlah riwayat pengajuan surat
$pengajuan = $conn->prepare("SELECT * FROM rwt_pengajuan");
$pengajuan->execute();
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
                labels: ['Jan 22', 'Feb 22', 'Mar 22', 'Apr 22', 'Mei 22', 'Jun 22', 'Jul 22', 'Agu 22', 'Sep 22', 'Okt 22', 'Nov 22', 'Des 22'],
                datasets: [{
                    data: [86, 114, 106, 106, 107, 111, 133, 221, 783, 2478, 356, 324],
                    label: "Angka Kematian",
                    borderColor: "#c45850",
                    fill: false
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Jumlah Angka Kematian per Bulan'
                }
            }
        });

        // grafik kelahiran
        new Chart(document.getElementById("grafik-kelahiran"), {
            type: 'line',
            data: {
                labels: ['Jan 22', 'Feb 22', 'Mar 22', 'Apr 22', 'Mei 22', 'Jun 22', 'Jul 22', 'Agu 22', 'Sep 22', 'Okt 22', 'Nov 22', 'Des 22'],
                datasets: [{
                    data: [655, 345, 65, 46, 546, 23, 57, 56, 65, 54, 454, 65],
                    label: "Angka Kelahiran",
                    borderColor: "#8e5ea2",
                    fill: false
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Jumlah Angka Kelahiran per Bulan'
                }
            }
        });

        // grafik jumlah penduduk berdasarkan jenis kelamin
        new Chart(document.getElementById("grafik-kelamin"), {
            type: 'doughnut',
            data: {
                labels: ["Laki-Laki", "Perempuan"],
                datasets: [{
                    label: "Penduduk",
                    backgroundColor: ["#3e95cd", "#8e5ea2"],
                    data: [2478, 5267]
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
                labels: ["Balita", "Remaja"],
                datasets: [{
                    label: "Penduduk",
                    backgroundColor: ["#e8c3b9", "#c45850"],
                    data: [2478, 5267]
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
                labels: ['Jan 22', 'Feb 22', 'Mar 22', 'Apr 22', 'Mei 22', 'Jun 22', 'Jul 22', 'Agu 22', 'Sep 22', 'Okt 22', 'Nov 22', 'Des 22'],
                datasets: [{
                    data: [655, 345, 65, 46, 546, 23, 57, 56, 65, 54, 454, 65],
                    label: "Jumlah Permintaan",
                    borderColor: "#3cba9f",
                    fill: false
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Jumlah Angka Permintaan Surat Keterangan'
                }
            }
        });
    </script>
<?php } ?>