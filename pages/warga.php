<?php
// validasi hak akses
aksesOnly([2, 3, 4]);
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Warga</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                    <li class="breadcrumb-item active">Data Warga</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card">
        <div class="card-header">
            <a href="" class="btn btn-primary"><span class="fa fa-user-plus"></span> Tambah</a>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover w-100" aria-describedby="warga" id="warga">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th>Kartu Keluarga</th>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>LP</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">.</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            Footer
        </div>
    </div>
</section>