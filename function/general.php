<?php

function generateNoSurat()
{
    global $conn;

    $sql = $conn->prepare("SELECT no_surat FROM rwt_pengajuan WHERE no_surat IS NOT NULL ORDER BY no_surat DESC LIMIT 1");
    $sql->execute();
    $result = $sql->fetch();
    if (!empty($result)) {
        $max = explode('/', $result['no_surat']);

        $urutan = (int) $max[0];
        $urutan++;
    } else {
        $urutan = 1;
    }

    return sprintf("%03s", $urutan) . "/24.02.03.02/" . date('Y');
}

function tglIndo($tanggal)
{
    $bulan = array(
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );

    $exp = explode('-', $tanggal);

    return $exp[2] . ' ' . $bulan[(int)$exp[1]] . ' ' . $exp[0];
}
