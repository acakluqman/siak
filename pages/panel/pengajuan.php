<?php
// validasi hak akses
aksesOnly([1, 2, 3, 4]);

// data pengajuan
$permohonan = $conn->prepare("SELECT p.*, w.nama FROM rwt_pengajuan p LEFT JOIN warga w ON w.nik = p.nik ORDER BY p.tgl_ajuan DESC");
$permohonan->execute();

// proses hapus pengajuan
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $delete = $conn->prepare("DELETE FROM rwt_pengajuan WHERE md5(id_pengajuan) = :id");
    $delete->execute(['id' => $id]);

    if ($delete) $alert->success('Berhasil menghapus data pengajuan!', 'app.php?page=pengajuan', true);
    else $alert->error('Gagal menghapus data pengajuan. Silahkan ulangi kembali!', 'app.php?page=pengajuan', true);
}
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
    <?= $alert->display() ?>
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover w-100" aria-describedby="pengajuan" id="pengajuan">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th>NIK</th>
                        <th width="15%">Nama Pemohon</th>
                        <th>Keperluan</th>
                        <th width="15%" class="text-center">Tanggal Pengajuan</th>
                        <th>Status</th>
                        <?php if ($_SESSION['level'] == 1) : ?>
                            <th></th>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($permohonan->fetchAll() as $key => $row) : ?>
                        <tr data-id="<?= md5($row['id_pengajuan']) ?>">
                            <td class="text-center align-middle"><?= ($key + 1) ?>.</td>
                            <td class="align-middle"><a href="app.php?page=detail_pengajuan&id=<?= md5($row['id_pengajuan']) ?>"><?= $row['nik'] ?></a></td>
                            <td class="align-middle"><?= $row['nama'] ?></td>
                            <td class="align-middle">
                                <p style="line-height: 1.5em; height: 3em; overflow: hidden;">
                                    <?= $row['keperluan'] ?>
                                </p>
                            </td>
                            <td class="align-middle text-center"><?= date_format(date_create($row['tgl_ajuan']), 'd M Y H:i A') ?></td>
                            <td class="align-middle">
                                <?php
                                if (is_null($row['validasi_rt'])) {
                                    echo '<span class="badge badge-warning text-light">Menunggu Persetujuan RT</span>';
                                } elseif ($row['validasi_rt'] == 0 && !is_null($row['tgl_validasi_rt'])) {
                                    echo '<span class="badge badge-danger">Ditolak RT</span>';
                                } else {
                                    if ($row['validasi_rt'] == 1 && is_null($row['validasi_rw'])) {
                                        echo '<span class="badge badge-warning text-light">Menunggu Persetujuan RW</span>';
                                    } elseif ($row['validasi_rt'] == 1 && $row['validasi_rw'] == 1) {
                                        echo '<span class="badge badge-success">Disetujui</span>';
                                    } elseif ($row['validasi_rt'] == 1 && $row['validasi_rw'] == 0) {
                                        echo '<span class="badge badge-danger">Ditolak RW</span>';
                                    }
                                }
                                ?>
                            </td>
                            <?php if ($_SESSION['level'] == 1) : ?>
                                <td class="align-middle">
                                    <a href="app.php?page=edit_pengajuan&id=<?= md5($row['id_pengajuan']) ?>" class="btn btn-sm btn-success">
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

    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Pengajuan?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="app.php?page=pengajuan" class="form" method="post">
                    <input type="hidden" name="id" id="id" value="" readonly>
                    <div class="modal-body">
                        <p>Apakah Anda yakin akan menghapus data pengajuan tersebut?</p>
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
        var id = $(this).closest('tr').data('id');
        console.log(id)
        $('#modal-delete').data('id', id).modal('show');
        $('#modal-delete #id').val(id);
    });
</script>