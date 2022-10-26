<?php
// validasi hak akses
aksesOnly(4);

// data warga
$warga = $conn->prepare("SELECT w.nik, w.kartu_keluarga, w.nama, w.jk, w.tmp_lahir, w.tgl_lahir, p.nama AS pekerjaan FROM warga w LEFT JOIN ref_pekerjaan p ON p.id_pekerjaan = w.id_pekerjaan ORDER BY w.nama ASC");
$warga->execute();
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
    <div class="card">
        <form action="" class="form" method="post">
            <div class="card-body">
                <a href="app.php?page=warga" class="btn btn-danger"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i> Kembali</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2" aria-hidden="true"></i> Simpan</button>
            </div>
        </form>
    </div>
</section>