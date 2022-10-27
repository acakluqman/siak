<?php

use Mpdf\QrCode\Output;
use Mpdf\QrCode\QrCode;

require_once('./config.php');
require_once('./function/input.php');

$mpdf = new \Mpdf\Mpdf(['format' => 'A5-P', 'margin_left' => 10, 'margin_right' => 10, 'margin_top' => 10, 'margin_bottom' => 10, 'margin_header' => 10, 'margin_footer' => 10]);
$qrCode = new QrCode(md5('Lorem ipsum sit dolor'));
// Save black on white PNG image 100 px wide to filename.png. Colors are RGB arrays.
$output = new Output\Png();
$data = $output->output($qrCode, 100, [255, 255, 255], [0, 0, 0]);
file_put_contents('filename.png', $data);

// Echo a SVG file, 100 px wide, black on white.
// Colors can be specified in SVG-compatible formats
// $output = new Output\Svg();
// echo $output->output($qrCode, 100, 'white', 'black');

// Echo an HTML table
// $output = new Output\Html();
// echo $output->output($qrCode);
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
$html .= '<strong>RT:</strong> 02 <strong>RW:</strong> 02';
$html .= '<br/>';
$html .= '<strong>KELURAHAN:</strong> KETINTANG';
$html .= '</p>';
$html .= '<p style="text-align: center;">';
$html .= '<strong><u>SURAT PENGANTAR / KETERANGAN</u></strong>';
$html .= '<br>';
$html .= 'No. 3545/543/24.02.03.02/2022';
$html .= '</p>';

$html .= '<p>Yang bertanda tangan di bawah ini, menerangkan:</p>';

// content
$html .= '<table>';
$html .= '<tr>';
$html .= '<td>Nama Lengkap</td>';
$html .= '<td>: </td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Alamat</td>';
$html .= '<td>: </td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Pekerjaan</td>';
$html .= '<td>: </td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Jenis Kelamin</td>';
$html .= '<td>: </td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Tempat, Tanggal Lahir</td>';
$html .= '<td>: </td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Agama</td>';
$html .= '<td>: </td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Status Perkawinan</td>';
$html .= '<td>: </td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Kewarganegaraan</td>';
$html .= '<td>: </td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Nomor KK / KTP</td>';
$html .= '<td>: </td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Tujuan</td>';
$html .= '<td>: </td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Keperluan</td>';
$html .= '<td>: </td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td>Keterangan Lainnya</td>';
$html .= '<td>: </td>';
$html .= '</tr>';
$html .= '</table>';

$html .= '<p>Demikian agar mendapat bantuan seperlunya.</p>';

$html .= '<p style="text-align: right;">Surabaya, 26 Oktober 2022</p>';

// tanda tangan
$html .= '<table style="width: 100%;">';
$html .= '<tr>';
$html .= '<td style="width: 25% !important; text-align: center;">Yang bersangkutan<br/><img src="filename.png"><br/>Luqman Hakim</td>';
$html .= '<td style="width: 50% !important;"></td>';
$html .= '<td style="width: 25% !important; text-align: center;">Ketua RT 02<br/><img src="filename.png"><br/>Nama Ketua RT 02</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td></td>';
$html .= '<td style="text-align: center;">No. xxxxxxxxxxxxxx<br/>Mengetahui:<br/>Ketua RW 03<br/><img src="filename.png"><br/>Nama Ketua RW</td>';
$html .= '<td></td>';
$html .= '</tr>';
$html .= '</table>';

$html .= '</body>';
$html .= '</html>';
$mpdf->WriteHTML($html);
$mpdf->Output();
