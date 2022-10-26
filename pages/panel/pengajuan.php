<?php
// validasi hak akses
aksesOnly([2, 3, 4]);

// data pengajuan
$permohonan = $conn->prepare("SELECT p.*, w.nama FROM rwt_pengajuan p LEFT JOIN warga w ON w.nik = p.nik ORDER BY p.tgl_ajuan DESC");
$permohonan->execute();
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Pengajuan Surat</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="app.php">Beranda</a></li>
                    <li class="breadcrumb-item active">Data Pengajuan Surat</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover w-100" aria-describedby="pengajuan" id="pengajuan">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th>NIK</th>
                        <th>Nama Pemohon</th>
                        <th>Keperluan</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($permohonan->fetchAll() as $key => $row) : ?>
                        <tr>
                            <td class="text-center"><?= ($key + 1) ?>.</td>
                            <td><?= $row['nik'] ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['keperluan'] ?></td>
                            <td><?= $row['tgl_ajuan'] ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</section>