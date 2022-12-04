<?php

use Mpdf\QrCode\Output;
use Mpdf\QrCode\QrCode;

require_once('./config.php');
require_once('./function/input.php');
require_once('./function/general.php');

// ambil data pengajuan
$datasurat = $conn->prepare("SELECT rp.*, w.alamat, w.kartu_keluarga, w.nama, w.jk, w.tgl_lahir, w.tmp_lahir, p.nama AS pekerjaan, a.nama AS agama, k.nama AS status_kawin
        FROM rwt_pengajuan rp 
        LEFT JOIN warga w ON w.nik = rp.nik 
        LEFT JOIN ref_pekerjaan p ON p.id_pekerjaan = w.id_pekerjaan
        LEFT JOIN ref_agama a ON a.id_agama = w.id_agama
        LEFT JOIN ref_status_kawin k ON k.id_status_kawin = w.id_status_kawin
        WHERE md5(rp.id_pengajuan) = :id_pengajuan
        AND md5(rp.nik) = :nik
        LIMIT 1");
$datasurat->execute(['id_pengajuan' => $_GET['id'], 'nik' => $_GET['code']]);
$surat = $datasurat->fetchObject();

// ambil nama pak RT
$rt = $conn->prepare("SELECT * FROM pengguna p LEFT JOIN warga w ON w.nik = p.nik WHERE p.id_level = 2 LIMIT 1");
$rt->execute();
$namart = $rt->fetch();

// ambil nama pak RW
$rw = $conn->prepare("SELECT * FROM pengguna p LEFT JOIN warga w ON w.nik = p.nik WHERE p.id_level = 3 LIMIT 1");
$rw->execute();
$namarw = $rw->fetch();

$mpdf = new \Mpdf\Mpdf(['format' => 'A5-P', 'margin_left' => 10, 'margin_right' => 10, 'margin_top' => 10, 'margin_bottom' => 10, 'margin_header' => 10, 'margin_footer' => 10]);

// qr code
$arr = array('page' => 'status_permohonan', 'nik' => $surat->nik, 'kode_permohonan' => date_format(date_create($surat->tgl_ajuan), 'ym') . sprintf("%03s", (int) $surat->id_pengajuan));
$qr = new QrCode($base_url . 'index.php?' . http_build_query($arr));
$output = new Output\Png();
$data = $output->output($qr, 100, [255, 255, 255], [0, 0, 0]);
file_put_contents('./tmp/' . md5($surat->id_pengajuan) . '.png', $data);

$html = '';
$html .= '<html>';
$html .= '<head>';
$html .= '<title>Surat Keterangan</title>';
$html .= '<style>';
$html .= 'body { font-size: 12px; }';
$html .= '</style>';
$html .= '</head>';
$html .= '<body>';
// header
$html .= '<p>';
$html .= '<strong>RT:</strong> 02 <strong>RW:</strong> 03';
$html .= '<br/>';
$html .= '<strong>KELURAHAN:</strong> KETINTANG';
$html .= '</p>';
$html .= '<p style="text-align: center;">';
$html .= '<strong><u>SURAT PENGANTAR / KETERANGAN</u></strong>';
$html .= '<br>';
$html .= 'No. ' . $surat->no_surat;
$html .= '</p>';

$html .= '<p>Yang bertanda tangan di bawah ini, menerangkan:</p>';

// content
$html .= '<table>';
$html .= '<tr>';
$html .= '<td>Nama Lengkap</td>';
$html .= '<td>: ' . $surat->nama . '</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Alamat</td>';
$html .= '<td>: ' . $surat->alamat . '</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Pekerjaan</td>';
$html .= '<td>: ' . $surat->pekerjaan . '</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Jenis Kelamin</td>';
$jk = $surat->jk == 'L' ? 'Laki-Laki' : 'Perempuan';
$html .= '<td>: ' . $jk . '</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Tempat, Tanggal Lahir</td>';
$html .= '<td>: ' . $surat->tmp_lahir . ', ' . tglIndo(date_format(date_create($surat->tgl_lahir), 'Y-m-d')) . '</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Agama</td>';
$html .= '<td>: ' . $surat->agama . '</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Status Perkawinan</td>';
$html .= '<td>: ' . $surat->status_kawin . '</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Kewarganegaraan</td>';
$html .= '<td>: WNI</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Nomor KK / KTP</td>';
$html .= '<td>: ' . $surat->kartu_keluarga . ' / ' . $surat->nik . '</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Tujuan</td>';
$html .= '<td>: ' . $surat->tujuan . '</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Keperluan</td>';
$html .= '<td>: ' . $surat->keperluan . '</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Keterangan Lainnya</td>';
$html .= '<td>: ' . $surat->keterangan . '</td>';
$html .= '</tr>';
$html .= '</table>';

$html .= '<p>Demikian agar mendapat bantuan seperlunya.</p>';

$html .= '<p style="text-align: right;">Surabaya, ' . tglIndo(date_format(date_create($surat->tgl_validasi_rw), 'Y-m-d')) . '</p>';

// tanda tangan
$html .= '<table style="width: 100%;">';
$html .= '<tr>';
$html .= '<td style="width: 25% !important; text-align: center;">Yang bersangkutan<br/><img src="./tmp/' . md5($surat->id_pengajuan) . '.png"><br/>' . $surat->nama . '</td>';
$html .= '<td style="width: 50% !important;"></td>';
$html .= '<td style="width: 25% !important; text-align: center;">Ketua RT 02<br/><img src="./tmp/' . md5($surat->id_pengajuan) . '.png"><br/>' . $namart['nama'] . '</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td></td>';
$html .= '<td style="text-align: center;">No. ' . $surat->no_surat . '<br/>Mengetahui:<br/>Ketua RW 03<br/><img src="./tmp/' . md5($surat->id_pengajuan) . '.png"><br/>' . $namarw['nama'] . '</td>';
$html .= '<td></td>';
$html .= '</tr>';
$html .= '</table>';

$html .= '</body>';
$html .= '</html>';
$mpdf->WriteHTML($html);
$mpdf->Output();
