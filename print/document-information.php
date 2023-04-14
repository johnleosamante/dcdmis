<?php
// print/document-tracking-slip.php
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Print Documentation: ' . $code);
$pdf->Output();
?>