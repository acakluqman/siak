<?php
// validasi hak akses
aksesOnly(1);

// ambil data warga
$stmt = $conn->prepare("SELECT nik, nama FROM warga w WHERE NOT EXISTS (SELECT nik FROM pengguna p WHERE p.nik = w.nik) ORDER BY w.nama ASC");
$stmt->execute();
$warga = $stmt->fetchAll();

// proses tambah pengguna
if (isset($_POST['username'])) {
    $nik = secureInput($_POST['nik']);
    $username = secureInput(strtolower($_POST['username']));
    $email = secureInput(strtolower($_POST['email']));
    $password = secureInput($_POST['password']);
    $konfirmasi = secureInput($_POST['konfirmasi']);
    $level = secureInput($_POST['level']);

    if ($password != $konfirmasi) {
        // validasi password
        $alert->error('Konfirmasi password tidak cocok dengan password!');
    } else {
        // validasi cek apakah user sudah ada
        $pengguna = $conn->prepare("SELECT id_pengguna FROM pengguna WHERE nik = :nik LIMIT 1");
        $pengguna->execute(['nik' => $nik]);
        // user sudah ada
        if ($pengguna->rowCount()) {
            // pengguna sudah digunakan
            $alert->error('Pengguna sudah terdaftar. Silahkan pilih pengguna yang lain!');
        } else {
            // cek username
            $stmt = $conn->prepare("SELECT username FROM pengguna WHERE username = :username LIMIT 1");
            $stmt->execute(['username' => $username]);

            if ($stmt->rowCount()) {
                // username sudah ada
                $alert->error('Username sudah dipakai. Silahkan gunakan username lain!');
            } else {
                // cek email
                $stmt = $conn->prepare("SELECT email FROM pengguna WHERE email = :email LIMIT 1");
                $stmt->execute(['email' => $email]);

                if ($stmt->rowCount()) {
                    // email sudah ada
                    $alert->error('Email sudah dipakai. Silahkan gunakan alamat email lain!');
                } else {
                    // user belum ada, insert ke db
                    $stmt = $conn->prepare("INSERT INTO pengguna (nik, username, email, password, id_level, tgl_registrasi) VALUES (:nik, :username, :email, :password, :id_level, :tgl_registrasi)");
                    $insert = $stmt->execute([
                        'nik' => $nik,
                        'username' => strtolower($username),
                        'email' => strtolower($email),
                        'password' => password_hash($password, PASSWORD_DEFAULT),
                        'id_level' => $level,
                        'tgl_registrasi' => date('Y-m-d H:i:s')
                    ]);

                    if ($insert) $alert->success('Berhasil menambahkan data pengguna!');
                    else $alert->error('Gagal menambahkan data pengguna. Silahkan ulangi kembali!');
                }
            }
        }
    }
}
// proses hapus pengguna
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $delete = $conn->prepare("DELETE FROM pengguna WHERE md5(id_pengguna) = :id");
    $delete->execute(['id' => $id]);

    if ($delete) $alert->success('Berhasil menghapus data pengguna!');
    else $alert->error('Gagal menghapus data pengguna. Silahkan ulangi kembali!');
}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Pengguna</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="app.php">Beranda</a></li>
                    <li class="breadcrumb-item active">Data Pengguna</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <?= $alert->display() ?>
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah">
                <i class="fa fa-user-plus mr-2"></i> Tambah
            </button>
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
                        <tr data-id="<?= md5($row['id_pengguna']) ?>">
                            <td class="text-center"><?= $no++ ?>.</td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['username'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['level'] ?></td>
                            <td><?= date_format(date_create($row['tgl_registrasi']), 'd M Y H:i A') ?></td>
                            <td class="text-center">
                                <a href="app.php?page=edit_pengguna&id=<?= md5($row['id_pengguna']) ?>" title="Edit" class="btn btn-sm btn-success"><span class="fas fa-user-edit"></span> Edit</a>
                                <button type="button" title="Hapus" class="btn btn-sm btn-danger delete"><span class="fa fa-trash-alt"></span> Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modalTambah" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . '?page=pengguna'); ?>" class="form" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nik">Pilih Pengguna</label>
                            <select class="form-control" name="nik" id="nik">
                                <?php foreach ($warga as $row) : ?>
                                    <option value="<?= $row['nik'] ?>"><?= $row['nik'] . ' - ' . $row['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" value="" placeholder="Username" minlength="6" required="required">
                        </div>
                        <div class="form-group">
                            <label for="email">Alamat Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="" placeholder="Alamat Email" required="required" inputmode="email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" value="" placeholder="Password" minlength="6" required="required">
                        </div>
                        <div class="form-group">
                            <label for="konfirmasi">Konfirmasi</label>
                            <input type="password" name="konfirmasi" id="konfirmasi" class="form-control" value="" placeholder="Konfirmasi Password" minlength="6" required="required">
                        </div>
                        <div class="form-group">
                            <label for="level">Hak Akses</label>
                            <select class="form-control" name="level" id="level">
                                <option value="1">Administrator</option>
                                <option value="2">Ketua RT</option>
                                <option value="3">Ketua RW</option>
                                <option value="4">Operator</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Pengguna?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="app.php?page=pengguna" class="form" method="post">
                    <input type="hidden" name="id" id="id" value="" readonly>
                    <div class="modal-body">
                        <p>Apakah Anda yakin akan menghapus data pengguna tersebut?</p>
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
    $(function() {
        $('#nik').select2({
            dropdownParent: $('#modal-tambah')
        });

        $('#level').select2({
            minimumResultsForSearch: -1
        });
    })

    $('button.delete').on('click', function(e) {
        e.preventDefault();
        var id = $(this).closest('tr').data('id');
        $('#modal-delete').data('id', id).modal('show');
        $('#modal-delete #id').val(id);
        console.log(id)
    });
</script>