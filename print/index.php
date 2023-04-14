<?php
// print/index.php
require_once('../includes/function.php');
require_once(root() . '/includes/plugin/fpdf/fpdf.php');
include_once(root() . '/includes/database/database.php');
include_once(root() . '/includes/database/document.php');

foreach ($_GET as $key => $data) {
  $url = $_GET[$key] = decode($data);
  $page = real_escape_string($url);
}

$code = $_GET['id'];

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

if (!isset($url) || $url === '') {
  redirect(custom_uri('dts', '404'));
} else {
  $file = '';
  switch ($url) {
    case 'Document Tracking Slip':
      $file = 'document-tracking-slip';
      break;
    case 'Document Information':
      $file = 'document-information';
      break;
    default:
      redirect(custom_uri('dts', '404'));
      break;
  }

  $pdf->SetTitle($url . ' : ' . $code);

  include_once(root() . "/print/{$file}.php");

  $pdf->Output();
}
?>