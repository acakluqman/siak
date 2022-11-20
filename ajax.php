<?php
require_once('./config.php');
require_once('./function/input.php');

switch ($_POST['action']) {
    case 'cek_nik':
        $nik = secureInput($_POST['nik']);
        $stmt = $conn->prepare("SELECT w.nik, w.nama FROM warga w WHERE NOT EXISTS (SELECT rk.nik FROM rwt_kematian rk WHERE rk.nik = w.nik) AND w.nik = :nik LIMIT 1");
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

        $stmt = $conn->prepare("INSERT INTO rwt_pengajuan (nik, tujuan, keperluan, keterangan) VALUES (:nik, :tujuan, :keperluan, :keterangan)");
        $stmt->execute(['nik' => $nik, 'tujuan' => $tujuan, 'keperluan' => $keperluan, 'keterangan' => $keterangan]);

        echo json_encode(['status' => $stmt ? 200 : 201, 'message' => $stmt ? date('ym') . sprintf("%03d", $conn->lastInsertId())  : $conn->errorInfo()]);
        break;

    default:
        # code...
        break;
}
