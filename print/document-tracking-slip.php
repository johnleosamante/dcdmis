<?php
// print/document-tracking-slip.php
$document = fetch_assoc(document_origin($code));
$section = strtoupper(station_name($document['from']));
$date_created = to_date($document['datetime'], '', 'F d, Y');
$description = $document['description'];
$employee = strtoupper(user_name($document['user']));
$employee_position = fetch_assoc(position($document['user']))['position'];

/* Station Header */
$pdf->SetY(65);
$pdf->SetFont('calibrib',  'B', 15);
$pdf->Cell(0, 0, $section, 0, 0, 'C');

if ($is_school) {
  $pdf->Ln(5);
  $pdf->SetFont('calibrib',  'B', 12);
  $pdf->Cell(0, 0, strtoupper($address), 0, 0, 'C');
  $pdf->Ln(5);
  $pdf->SetFont('calibrib',  'B', 14);
  $pdf->Cell(0, 0, strtoupper($district), 0, 0, 'C');
}

$pdf->Ln(15);

/* Document body */
$pdf->SetFont('calibrib',  'B', 18);
$pdf->Cell(0, 0, 'DOCUMENT TRACKING SLIP', 0, 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('calibri',  '', 9);
$pdf->Cell(0, 0, '(Document Attachment)', 0, 0, 'C');
$pdf->Ln(15);

$pdf->SetFont('calibri',  '', 11);
$pdf->Cell(0, 0, $date_created, 0, 0, 'R');
$pdf->Ln(10);
$pdf->SetFont('calibrib',  'B', 17);
$pdf->Cell(0, 0, $code);
$pdf->Ln(10);
$pdf->SetFont('calibri',  '', 11);
$pdf->Write(5, $description);
$pdf->Ln(20);

/* Document creator */
$inner_page = $width - ($margin * 2);
$pdf->Cell($inner_page / 2, 0, 'Prepared by:');
$pdf->Ln(15);
$pdf->SetFont('calibrib', 'B', 11);
$pdf->Cell($inner_page / 2, 0, $employee, 0, 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('calibri', '', 11);
$pdf->Cell($inner_page / 2, 0, $employee_position, 0, 0, 'C');

/* Noted by Station Head if document was not created by Head */
$section_head = $is_school ? $school : fetch_assoc(section($document['from']));

if ($document['user'] !== $section_head['head']) {
  $station_head = strtoupper(user_name($section_head['head']));
  $station_head_position = fetch_assoc(position($section_head['head']))['position'];

  $pdf->Ln(10);
  $pdf->SetX($width / 2);
  $pdf->Cell($inner_page / 2, 0, 'Noted by:');
  $pdf->Ln(15);
  $pdf->SetX($width / 2);
  $pdf->SetFont('calibrib', 'B', 11);
  $pdf->Cell($inner_page / 2, 0, $station_head, 0, 0, 'C');
  $pdf->Ln(5);
  $pdf->SetX($width / 2);
  $pdf->SetFont('calibri', '', 11);
  $pdf->Cell($inner_page / 2, 0, $station_head_position, 0, 0, 'C');
  $pdf->Ln();
}

/* QR Code */
require_once(root() . '/includes/plugin/phpqrcode/qrlib.php');

$PNG_TEMP_DIR = root() . '/temp/qr';
$errorCorrectionLevel = 'L';
$matrixPointSize = 5;
$filename = $PNG_TEMP_DIR . '/' . md5($code . $errorCorrectionLevel . $matrixPointSize) . '.png';

if (!file_exists($PNG_TEMP_DIR)) {
  mkdir($PNG_TEMP_DIR);
}

QRcode::png($code, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

$pdf->Image($filename, $width - $margin - $logo_size, $height - 32, $logo_size);
?>