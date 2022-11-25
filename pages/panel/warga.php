<?php
// validasi hak akses
aksesOnly([2, 3, 4]);

// data warga
$warga = $conn->prepare("SELECT * FROM (SELECT w.nik, w.kartu_keluarga, w.nama, w.jk, w.tmp_lahir, w.tgl_lahir, p.nama AS pekerjaan FROM warga w
    LEFT JOIN ref_pekerjaan p ON p.id_pekerjaan = w.id_pekerjaan
    WHERE NOT EXISTS (SELECT nik FROM rwt_kematian k WHERE k.nik = w.nik)) AS w1
    WHERE NOT EXISTS (SELECT * FROM rwt_mutasi m WHERE m.nik = w1.nik)
    ORDER BY w1.nama ASC");
$warga->execute();

// proses hapus warga
if (isset($_POST['delete'])) {
    $nik = $_POST['nik'];
    $delete = $conn->prepare("DELETE FROM warga WHERE md5(nik) = :nik");
    $delete->execute(['nik' => $nik]);

    if ($delete) $alert->success('Berhasil menghapus data pengguna!');
    else $alert->error('Gagal menghapus data pengguna. Silahkan ulangi kembali!');
}
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . '?page=warga') ?>" class="form" method="post">
                    <div class="card-body">
                    </div>
                    <div class="card-footer">
                        <button type="submit" name="filter" class="btn btn-success"><i class="fa fa-search" aria-hidden="true"></i> Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-12">
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
                                <tr data-id="<?= md5($row['nik']) ?>">
                                    <td class="text-center"><?= ($key + 1) ?>.</td>
                                    <td>
                                        <?php if ($_SESSION['level'] == 4) : ?>
                                            <a href="<?= $base_url . 'app.php?page=detail_warga&id=' . $row['nik'] ?>"><?= $row['nik'] ?></a>
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
                                            <a href="app.php?page=edit_warga&id=<?= $row['nik'] ?>" class="btn btn-sm btn-success">
                                                <span class="fas fa-user-edit"></span> Edit
                                            </a>
                                            <button title="Hapus" class="btn btn-sm btn-danger delete">
                                                <span class="fa fa-trash-alt"></span> Hapus
                                            </button>
                                        </td>
                                    <?php endif ?>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Warga?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="app.php?page=warga" class="form" method="post">
                    <input type="hidden" name="nik" id="nik" value="" readonly>
                    <div class="modal-body">
                        <p>Apakah Anda yakin akan menghapus data warga tersebut?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" name="delete" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    $('button.delete').on('click', function(e) {
        e.preventDefault();
        var nik = $(this).closest('tr').data('id');
        $('#modal-delete').data('nik', nik).modal('show');
        $('#modal-delete #nik').val(nik);
        console.log(nik)
    });
</script>