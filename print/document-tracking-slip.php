<?php
// print/document-tracking-slip.php
include_once(root() . '/includes/database/document.php');
include_once(root() . '/includes/database/employee.php');
include_once(root() . '/includes/database/position.php');

$document = fetch_assoc(document_origin($code));
$date_created = to_date($document['datetime'], 'F d, Y');
$description = $document['description'];
$employee = strtoupper(user_name($document['user']));
$employee_position = fetch_assoc(position($document['user']))['position'];

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

$inner_page = $width - ($margin * 2);

$pdf->Cell($inner_page / 2, 0, 'Prepared by:');
$pdf->Ln(15);
$pdf->SetFont('calibrib', 'B', 11);
$pdf->Cell($inner_page / 2, 0, $employee, 0, 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('calibri', '', 11);
$pdf->Cell($inner_page / 2, 0, $employee_position, 0, 0, 'C');

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
?>