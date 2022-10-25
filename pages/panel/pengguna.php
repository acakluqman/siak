<?php
// validasi hak akses
aksesOnly(1);
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Pengguna</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                    <li class="breadcrumb-item active">Data Pengguna</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card">
        <div class="card-header">
            <a href="" class="btn btn-primary"><i class="fa fa-user-plus"></i> Tambah</a>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover w-100" id="pengguna">
                <thead>
                    <tr>
                        <th class="text-center w-auto">No.</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Alamat Email</th>
                        <th>Level</th>
                        <th>Tanggal Daftar</th>
                        <th class="w-auto"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $conn->prepare("select p.*, w.nama, l.nama as level from pengguna p left join warga w on w.nik = p.nik left join ref_level_pengguna l on l.id_level = p.id_level order by w.nama asc");
                    $stmt->execute();

                    $no = 1;
                    foreach ($stmt->fetchAll() as $row) :
                    ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?>.</td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['username'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['level'] ?></td>
                            <td><?= date_format(date_create($row['tgl_registrasi']), 'd M Y H:i A') ?></td>
                            <td class="text-center">
                                <a href="" title="Edit" class="btn btn-sm btn-success"><span class="fas fa-user-edit"></span> Edit</a>
                                <a href="" title="Hapus" class="btn btn-sm btn-danger"><span class="fa fa-trash-alt"></span> Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            Footer
        </div>
    </div>
</section>