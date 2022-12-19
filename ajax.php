<?php
require_once('./config.php');
require_once('./function/input.php');

switch ($_POST['action']) {
    case 'cek_nik':
        $nik = secureInput($_POST['nik']);
        $stmt = $conn->prepare("SELECT * FROM (SELECT w.nik, w.nama 
            FROM warga w
            WHERE NOT EXISTS (SELECT nik FROM rwt_kematian k WHERE k.nik = w.nik)) AS w1
            WHERE NOT EXISTS (SELECT * FROM rwt_mutasi m WHERE m.nik = w1.nik AND m.jenis_mutasi = 'keluar')
            AND nik = :nik LIMIT 1");
        $stmt->execute(['nik' => $nik]);

        echo json_encode(['status' => $stmt->rowCount() ? 200 : 201, 'data' => $stmt->fetch()]);
        break;

    case 'cek_nik_tgl_lahir':
        $nik = secureInput($_POST['nik']);
        $tgl_lahir = date_format(date_create($_POST['tgl_lahir']), 'Y-m-d');

        $stmt = $conn->prepare("SELECT w.nik, w.nama FROM warga w WHERE NOT EXISTS (SELECT rk.nik FROM rwt_kematian rk WHERE rk.nik = w.nik) AND w.nik = :nik AND w.tgl_lahir = :tgl_lahir LIMIT 1");
        $stmt->execute(['nik' => $nik, 'tgl_lahir' => $tgl_lahir]);

        echo json_encode(['status' => $stmt->rowCount() ? 200 : 201, 'data' => $stmt->fetch()]);
        break;

    case 'pengajuan':
        $nik = secureInput($_POST['nik']);
        $tujuan = secureInput($_POST['tujuan']);
        $keperluan = secureInput($_POST['keperluan']);
        $keterangan = secureInput($_POST['keterangan']);

        // upload
        $temp = "upload/";
        if (!file_exists($temp)) mkdir($temp);
        $fileupload = $_FILES['fileupload']['tmp_name'];
        $ImageName = $_FILES['fileupload']['name'];
        $ImageType = $_FILES['fileupload']['type'];

        if (!empty($fileupload)) {
            $ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
            $ImageExt       = str_replace('.', '', $ImageExt); // Extension
            $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
            $NewImageName   = str_replace(' ', '', $ImageName . '.' . $ImageExt);

            move_uploaded_file($_FILES["fileupload"]["tmp_name"], $temp . $NewImageName); // Menyimpan file

            $stmt = $conn->prepare("INSERT INTO rwt_pengajuan (nik, tujuan, keperluan, keterangan, filektp) VALUES (:nik, :tujuan, :keperluan, :keterangan, :filektp)");
            $stmt->execute(['nik' => $nik, 'tujuan' => $tujuan, 'keperluan' => $keperluan, 'keterangan' => $keterangan, 'filektp' => $temp . $NewImageName]);

            echo json_encode(['status' => $stmt ? 200 : 201, 'message' => $stmt ? date('ym') . sprintf("%03d", $conn->lastInsertId())  : $conn->errorInfo()]);
        } else {
            echo json_encode(['status' => 201, 'message' => 'Gagal mengunggah file. Silahkan hubungi Admin!']);
        }

        break;

    default:
        # code...
        break;
}
