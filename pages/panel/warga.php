<?php
// validasi hak akses
aksesOnly([2, 3, 4]);

// data warga
$warga = $conn->prepare("SELECT w.nik, w.kartu_keluarga, w.nama, w.jk, w.tmp_lahir, w.tgl_lahir, p.nama AS pekerjaan FROM warga w LEFT JOIN ref_pekerjaan p ON p.id_pekerjaan = w.id_pekerjaan ORDER BY w.nama ASC");
$warga->execute();
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Warga</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="app.php">Beranda</a></li>
                    <li class="breadcrumb-item active">Data Warga</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card">
        <?php if ($_SESSION['level'] == 4) : ?>
            <div class="card-header">
                <a href="app.php?page=tambah_warga" class="btn btn-primary"><span class="fa fa-user-plus"></span> Tambah</a>
            </div>
        <?php endif ?>
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover w-100" aria-describedby="warga" id="warga">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%;">No.</th>
                        <th>NIK</th>
                        <th>Kartu Keluarga</th>
                        <th>Nama Lengkap</th>
                        <th>LP</th>
                        <th>Tempat, Tanggal Lahir</th>
                        <th>Pekerjaan</th>
                        <?php if ($_SESSION['level'] == 4) : ?>
                            <th></th>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($warga->fetchAll() as $key => $row) : ?>
                        <tr>
                            <td class="text-center"><?= ($key + 1) ?>.</td>
                            <td>
                                <?php if ($_SESSION['level'] == 4) : ?>
                                    <a href="<?= $base_url . 'app.php?page=detail_warga' ?>"><?= $row['nik'] ?></a>
                                <?php else : ?>
                                    <?= $row['nik'] ?>
                                <?php endif ?>
                            </td>
                            <td><?= $row['kartu_keluarga'] ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['jk'] ?></td>
                            <td><?= $row['tmp_lahir'] . ', ' . date_format(date_create($row['tgl_lahir']), 'd M Y') ?></td>
                            <td><?= $row['pekerjaan'] ?></td>
                            <?php if ($_SESSION['level'] == 4) : ?>
                                <td class="text-center">
                                    <a href="app.php?page=edit_warga" class="btn btn-sm btn-success">
                                        <span class="fas fa-user-edit"></span> Edit
                                    </a>
                                    <a href="" title="Hapus" class="btn btn-sm btn-danger">
                                        <span class="fa fa-trash-alt"></span> Hapus
                                    </a>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</section>