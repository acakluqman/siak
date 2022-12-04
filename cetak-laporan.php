<?php

use Mpdf\QrCode\Output;
use Mpdf\QrCode\QrCode;


require_once('./config.php');
require_once('./function/general.php');

$mpdf = new \Mpdf\Mpdf(['format' => 'A4-L', 'margin_left' => 10, 'margin_right' => 10, 'margin_top' => 10, 'margin_bottom' => 10, 'margin_header' => 10, 'margin_footer' => 10, 'default_font' => 'sans-serif']);
$mpdf->SetHTMLFooter('<table border="0" width="100%"><tr><td style="text-align: left;">Halaman {PAGENO}</td><td style="text-align: right;">Dicetak pada ' . tglIndo(date('Y-m-d')) . '</td></tr></table>');

$html = '';
$html .= '<html>';
$html .= '<head>';
$html .= '<title>Cetak Laporan</title>';
$html .= '<style>';
$html .= 'body {font-size: 12px; font-family: Times, Georgia, "Times New Roman", serif !important;}';
$html .= '#table {
    border-collapse: collapse;
    width: 100%;
  }
  
  #table td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
  }
  
  #table tr:nth-child(even) {
    background-color: #dddddd;
  }';
$html .= '</style>';
$html .= '</head>';
$html .= '<body>';

switch ($_POST['action']) {
    case 'lap_mutasi':
        $html .= '<h3 style="text-align: center;">';
        $html .= 'LAPORAN MUTASI ' . strtoupper($_POST['jenis']) . ' RT02/RW03<br/>KELURAHAN KETINTANG<br/>TAHUN ' . $_REQUEST['tahun'];
        $html .= '</h3>';
        $html .= '<br>';

        for ($i = 1; $i <= 12; $i++) {
            $sql = $conn->prepare("SELECT * FROM rwt_mutasi m LEFT JOIN warga w ON w.nik = m.nik WHERE YEAR(m.tgl_mutasi) = :tahun AND MONTH(m.tgl_mutasi) = :bulan AND m.jenis_mutasi = '" . $_POST['jenis'] . "' ORDER BY m.tgl_mutasi ASC");
            $sql->execute(['tahun' => $_POST['tahun'], 'bulan' => sprintf("%02s", $i)]);
            $data = $sql->fetchAll();

            if (empty($data)) continue;

            $bulan = array(
                1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            );

            $html .= "<h4>Bulan " . $bulan[$i] . " " . $_POST['tahun'] . "</h4>";

            $html .= "<table id='table' style='width: 100%;' border='1'>";
            $html .= "<thead>";
            $html .= "<tr>";
            $html .= "<th style='text-align: center;'>No.</th>";
            $html .= "<th style='width: 25%;'>NIK</th>";
            $html .= "<th style='width: 30%;'>Nama</th>";
            $html .= "<th style='width: 20%;'>Tanggal Mutasi</th>";
            $html .= "<th style='width: 20%;'>Tanggal Lapor</th>";
            $html .= "</tr>";
            $html .= "</thead>";

            $html .= "<tbody>";
            $no = 1;
            foreach ($data as $row) {
                $html .= "<tr>";
                $html .= "<td style='text-align: center; width: 5%;'>" . $no++ . ".</td>";
                $html .= "<td>" . $row['nik'] . "</td>";
                $html .= "<td>" . $row['nama'] . "</td>";
                $html .= "<td>" . tglIndo(date_format(date_create($row['tgl_lahir']), 'Y-m-d')) . "</td>";
                $html .= "<td>" . tglIndo(date_format(date_create($row['tgl_lapor']), 'Y-m-d')) . "</td>";
                $html .= "</tr>";
            }
            $html .= "</tbody>";
            $html .= "</table>";
        }

        break;

    case 'lap_lahir':
        $html .= '<h3 style="text-align: center;">';
        $html .= 'LAPORAN KELAHIRAN RT02/RW03<br/>KELURAHAN KETINTANG<br/>TAHUN ' . $_REQUEST['tahun'];
        $html .= '</h3>';
        $html .= '<br>';

        for ($i = 1; $i <= 12; $i++) {
            $sql = $conn->prepare("SELECT * FROM rwt_kelahiran l LEFT JOIN warga w ON w.nik = l.nik WHERE YEAR(w.tgl_lahir) = :tahun AND MONTH(w.tgl_lahir) = :bulan ORDER BY l.tgl_lapor ASC");
            $sql->execute(['tahun' => $_POST['tahun'], 'bulan' => sprintf("%02s", $i)]);
            $data = $sql->fetchAll();

            if (empty($data)) continue;

            $bulan = array(
                1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            );

            $html .= "<h4>Bulan " . $bulan[$i] . " " . $_POST['tahun'] . "</h4>";

            $html .= "<table id='table' style='width: 100%;' border='1'>";
            $html .= "<thead>";
            $html .= "<tr>";
            $html .= "<th style='text-align: center;'>No.</th>";
            $html .= "<th style='width: 25%;'>NIK</th>";
            $html .= "<th style='width: 30%;'>Nama</th>";
            $html .= "<th style='width: 20%;'>Tanggal Lahir</th>";
            $html .= "<th style='width: 20%;'>Tanggal Lapor</th>";
            $html .= "</tr>";
            $html .= "</thead>";

            $html .= "<tbody>";
            $no = 1;
            foreach ($data as $row) {
                $html .= "<tr>";
                $html .= "<td style='text-align: center; width: 5%;'>" . $no++ . ".</td>";
                $html .= "<td>" . $row['nik'] . "</td>";
                $html .= "<td>" . $row['nama'] . "</td>";
                $html .= "<td>" . tglIndo(date_format(date_create($row['tgl_lahir']), 'Y-m-d')) . "</td>";
                $html .= "<td>" . tglIndo(date_format(date_create($row['tgl_lapor']), 'Y-m-d')) . "</td>";
                $html .= "</tr>";
            }
            $html .= "</tbody>";
            $html .= "</table>";
        }
        break;

    case 'lap_mati':
        $html .= '<h3 style="text-align: center;">';
        $html .= 'LAPORAN KEMATIAN RT02/RW03<br/>KELURAHAN KETINTANG<br/>TAHUN ' . $_REQUEST['tahun'];
        $html .= '</h3>';
        $html .= '<br>';

        for ($i = 1; $i <= 12; $i++) {
            $sql = $conn->prepare("SELECT * FROM rwt_kematian m LEFT JOIN warga w ON w.nik = m.nik WHERE YEAR(m.tgl_meninggal) = :tahun AND MONTH(m.tgl_meninggal) = :bulan ORDER BY m.tgl_meninggal ASC");
            $sql->execute(['tahun' => $_POST['tahun'], 'bulan' => sprintf("%02s", $i)]);
            $data = $sql->fetchAll();

            if (empty($data)) continue;

            $bulan = array(
                1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            );

            $html .= "<h4>Bulan " . $bulan[$i] . " " . $_POST['tahun'] . "</h4>";

            $html .= "<table id='table' style='width: 100%;' border='1'>";
            $html .= "<thead>";
            $html .= "<tr>";
            $html .= "<th style='text-align: center; width: 5%;'>No.</th>";
            $html .= "<th style='width: 25%;'>NIK</th>";
            $html .= "<th style='width: 30%;'>Nama</th>";
            $html .= "<th style='width: 20%;'>Tanggal Meninggal</th>";
            $html .= "<th style='width: 20%;'>Tanggal Lapor</th>";
            $html .= "</tr>";
            $html .= "</thead>";

            $html .= "<tbody>";
            $no = 1;
            foreach ($data as $row) {
                $html .= "<tr>";
                $html .= "<td style='text-align: center;'>" . $no++ . ".</td>";
                $html .= "<td>" . $row['nik'] . "</td>";
                $html .= "<td>" . $row['nama'] . "</td>";
                $html .= "<td>" . tglIndo(date_format(date_create($row['tgl_meninggal']), 'Y-m-d')) . "</td>";
                $html .= "<td>" . tglIndo(date_format(date_create($row['tgl_lapor']), 'Y-m-d')) . "</td>";
                $html .= "</tr>";
            }
            $html .= "</tbody>";
            $html .= "</table>";
        }

        break;

    default:
        # code...
        break;
}

$html .= '</body>';
$html .= '</html>';
$mpdf->WriteHTML($html);
$mpdf->Output();
