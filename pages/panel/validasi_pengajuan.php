<?php
// validasi hak akses
aksesOnly([2, 3]);
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Validasi Pengajuan Surat</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="app.php">Beranda</a></li>
                    <li class="breadcrumb-item">Pengajuan Surat</li>
                    <li class="breadcrumb-item active">Validasi Pengajuan Surat</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card">
        <form action="" class="form" method="post">
            <div class="card-body">
                <a href="app.php?page=pengajuan" class="btn btn-danger"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i> Kembali</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2" aria-hidden="true"></i> Simpan</button>
            </div>
        </form>
    </div>
</section>