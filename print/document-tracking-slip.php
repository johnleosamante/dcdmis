<?php
// print/document-tracking-slip.php
$logoSize = 19.5;
$margin = 25.4;
$width = 210;
$height = 297;
$lineY = 55;
$multiplePage = true;
$showBarCode = true;
$showQR = true;
$showStationInfo = false;
$code = strtoupper(sanitize(decode($_GET['id'])));
$title = "{$url} : {$code}";

require_once(root() . '/includes/database/document.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/database/section.php');

$document = documentOrigin($code);

$originStationId = $document['created_from'];
$section = strtoupper(stationName($originStationId));
$school = schoolByAlias($originStationId);
$isSchoolPortal = $school !== false;
$stationLogo = !empty($school['logo']) ? root() . '/' . $school['logo'] : null;
$address = $school['address'] ?? '';
$telephone = $school['telephone'] ?? '';
$email = $school['email'] ?? '';
$website = $school['website'] ?? '';
$fbPage = $school['fb_page'] ?? '';

$dateCreated = toDate($document['created_at'], 'F d, Y');
$processedAt = toDatetime($document['processed_at'], ' ');
$description = toHandleEncoding($document['description']);
$employee = toHandleEncoding(userName($document['processor_id'], true));
$employeePosition = toHandleEncoding(position($document['processor_id'])['official_title']);
$documentStatus = strtolower(documentTransactionStatus($document['status_id']));
$details = toHandleEncoding($document['details']);
$status = str_contains($documentStatus, 'complete') ? " (Completed | $processedAt)" : '';
$status = str_contains($documentStatus, 'cancel') ? " (Canceled | $processedAt)" : $status;

require_once(root() . '/print/print-layout.php');

$pdf = new PDF('P', 'mm', [$width, $height]);
$pdf->SetTitle($title);
$pdf->AliasNbPages();
$pdf->SetMargins($margin, 11 + $logoSize, $margin);
$pdf->SetAutoPageBreak(true, 50);
$pdf->AddPage();
$pdf->AddFont('calibri', '', 'calibri.php');
$pdf->AddFont('calibrib', 'B', 'calibrib.php');
$pdf->SetFont('calibrib', 'B', 18);
$pdf->Cell(0, 0, 'DOCUMENT TRACKING SLIP', 0, 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('calibri', '', 9);
$pdf->Cell(0, 0, '(Document Attachment)', 0, 0, 'C');
$pdf->Ln(10);
$pdf->SetFont('calibri', '', 11);
$pdf->Cell(0, 0, $dateCreated, 0, 0, 'R');
$pdf->Ln(5);
$pdf->SetFont('calibrib', 'B', 17);
$pdf->Cell(0, 0, $code);
$pdf->SetFont('calibri', '', 11);
if (!empty($status)) {
    $pdf->Ln(5);
    $pdf->Cell(0, 0, toHandleEncoding($status), 0, 0, 'L');
}
$pdf->Ln(10);
$pdf->Write(5, $description);
$pdf->Ln(15);
$currentY = $pdf->GetY() - 5;
$innerPage = $width - ($margin * 2);
$pdf->Cell($innerPage / 2, 0, 'Prepared by:');
$pdf->Ln(10);
$pdf->SetFont('calibrib', 'B', 11);
$pdf->Cell($innerPage / 2, 0, $employee, 0, 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('calibri', '', 11);
$pdf->Cell($innerPage / 2, 0, $employeePosition, 0, 0, 'C');

if ($document['processor_id'] !== $document['head_id']) {
    $pdf->SetY($currentY);
    $stationHead = toHandleEncoding(userName($document['head_id'], true));
    $stationHeadPosition = toHandleEncoding(position($document['head_id'])['official_title']);
    $pdf->Ln(5);
    $pdf->SetX($width / 2);
    $pdf->Cell($innerPage / 2, 0, 'Noted by:');
    $pdf->Ln(10);
    $pdf->SetX($width / 2);
    $pdf->SetFont('calibrib', 'B', 11);
    $pdf->Cell($innerPage / 2, 0, $stationHead, 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->SetX($width / 2);
    $pdf->SetFont('calibri', '', 11);
    $pdf->Cell($innerPage / 2, 0, $stationHeadPosition, 0, 0, 'C');
    $pdf->Ln();
}

if (strlen($details)) {
    $pdf->Ln(12);
    $pdf->SetX($margin);
    $pdf->SetFont('calibrib', 'B', 11);
    $pdf->Cell($margin, 0, 'NOTE:');
    $pdf->Ln(2);
    $pdf->SetFont('calibri', '', 9);
    $pdf->Write(5, $details);
    $pdf->Ln(20);
}