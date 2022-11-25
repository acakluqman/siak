<?php
// validasi hak akses
aksesOnly(1);

// data pengguna
$pengguna = $conn->prepare("SELECT p.*, w.nama FROM pengguna p LEFT JOIN warga w ON w.nik = p.nik WHERE md5(p.id_pengguna) = :id LIMIT 1");
$pengguna->execute(['id' => $_GET['id']]);
$data = $pengguna->fetch();

if (isset($_POST['update'])) {
    $arr = array();
    $arr['id'] = $_POST['id'];
    $arr['username'] = secureInput(strtolower($_POST['username']));
    $arr['email'] = secureInput(strtolower($_POST['email']));
    $arr['level'] = $_POST['level'];

    if (isset($_POST['ubah_password'])) {
        if ($_POST['password'] != $_POST['konfirmasi']) {
            $alert->error('Konfirmasi password tidak sama. Silahkan ulangi kembali!', 'app.php?page=edit_pengguna&id=' . md5($_POST['id']), true);
        } else {
            $arr['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }
    }

    // cek apakah username sudah digunakan
    $cekUsername = $conn->prepare("SELECT username FROM pengguna WHERE username = :username AND id_pengguna != :id LIMIT 1");
    $cekUsername->execute(['username' => $arr['username'], 'id' => $arr['id']]);
    // cek apakah email sudah digunakan
    $cekEmail = $conn->prepare("SELECT email FROM pengguna WHERE email = :email AND id_pengguna != :id LIMIT 1");
    $cekEmail->execute(['email' => $arr['email'], 'id' => $arr['id']]);
    if ($cekUsername->rowCount()) {
        // username sudah digunakan
        $alert->error('Username <em>' . strtolower($_POST['username']) . '</em> sudah digunakan. Silahkan gunakan username yang lain!');
    } elseif ($cekEmail->rowCount()) {
        // email sudah digunakan
        $alert->error('Alamat email <em>' . strtolower($_POST['email']) . '</em> sudah digunakan. Silahkan gunakan email yang lain!');
    } else {
        if (isset($_POST['ubah_password'])) {
            $update = $conn->prepare("UPDATE pengguna SET username = :username, email = :email, password = :password, id_level = :level WHERE id_pengguna = :id");
        } else {
            $update = $conn->prepare("UPDATE pengguna SET username = :username, email = :email, id_level = :level WHERE id_pengguna = :id");
        }
        $update->execute($arr);

        if ($update) {
            $alert->success('Berhasil memperbarui data pengguna!', 'app.php?page=pengguna', true);
        } else {
            $alert->error('Gagal memperbarui data pengguna. Silahkan ulangi kembali!');
        }
    }
}

?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Pengguna</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="app.php">Beranda</a></li>
                    <li class="breadcrumb-item">Data Pengguna</li>
                    <li class="breadcrumb-item active">Edit Data Pengguna</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <?= $alert->display() ?>
    <div class="card">
        <div class="card-body">
            <form action="app.php?page=edit_pengguna&id=<?= md5($data['id_pengguna']) ?>" class="form form-horizontal" method="post">
                <input type="hidden" name="id" id="id" value="<?= $data['id_pengguna'] ?>" readonly>

                <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-md-6">
                        <input type="text" name="nama" id="nama" class="form-control" value="<?= $data['nama'] ?>" required="required" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-md-6">
                        <input type="text" name="username" id="username" class="form-control" value="<?= $data['username'] ?>" required="required">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Alamat Email</label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control" name="email" id="email" value="<?= $data['email'] ?>" placeholder="Alamat Email" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Level Pengguna</label>
                    <div class="col-sm-6">
                        <select class="form-control" name="level" id="level">
                            <option value="1" <?= $data['id_level'] == '1' ? 'selected' : '' ?>>Administrator</option>
                            <option value="2" <?= $data['id_level'] == '2' ? 'selected' : '' ?>>Ketua RT</option>
                            <option value="3" <?= $data['id_level'] == '3' ? 'selected' : '' ?>>Ketua RW</option>
                            <option value="4" <?= $data['id_level'] == '4' ? 'selected' : '' ?>>Operator</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Ubah Password</label>
                    <div class="col-sm-6">
                        <div class="form-check mb-2">
                            <input class="form-check-input" name="ubah_password" id="ubah_password" type="checkbox" onclick="changePassword()">
                            <label class="form-check-label">Ubah password untuk <?= $data['username'] ?></label>
                        </div>
                        <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password Baru" required disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Konfirmasi Ubah Password</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" name="konfirmasi" id="konfirmasi" value="" placeholder="Password Baru" required disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">&nbsp;</label>
                    <div class="col-sm-6">
                        <a href="app.php?page=pengguna" class="btn btn-danger"><i class="fa fa-arrow-left mr-2" aria-hidden="true"></i> Kembali</a>
                        <button type="submit" name="update" class="btn btn-primary"><i class="fas fa-save mr-2" aria-hidden="true"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    $(function() {
        $('#level').select2();
    })

    function changePassword() {
        var ubah_password = document.getElementById("ubah_password");
        var password = document.getElementById("password");
        var konfirmasi = document.getElementById("konfirmasi");

        if (ubah_password.checked == true) {
            password.removeAttribute('disabled');
            konfirmasi.removeAttribute('disabled');
        } else {
            password.disabled = true;
            konfirmasi.disabled = true;
            password.required = false;
            konfirmasi.required = false;
        }
    }
</script>