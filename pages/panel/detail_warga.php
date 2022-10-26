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
                <h1>Detail Data Warga</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="app.php">Beranda</a></li>
                    <li class="breadcrumb-item">Data Warga</li>
                    <li class="breadcrumb-item active">Detail Data Warga</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card">
        <div class="card-body">
            <a href="app.php?page=warga" class="btn btn-danger"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i> Kembali</a>
        </div>
    </div>
</section>