<?php
// print/certificate-of-appreciation.php
$logoSize = 24;
$margin = 25.4;
$width = 297;
$height = 210;
$lineY = 55;
$multiplePage = false;
$isSchoolPortal = false;
$section = $district = null;
$school = fetchArray(schoolDetailsById('143'));
$stationLogo = root() . '/' . $school['logo'];
$address = $school['address'];
$telephone = $school['telephone'];
$email = $school['email'];
$website = $school['website'];
$fbPage = $school['fb_page'];

require_once(root() . '/print/print-layout.php');

$pdf = new PDF('L', 'mm', array($width, $height));
$pdf->SetTitle($title);
$pdf->AliasNbPages();
$pdf->SetMargins($margin, 11 + $logoSize, $margin);
$pdf->SetAutoPageBreak(true, 35);
$pdf->AddPage();
$pdf->AddFont('calibri', '', 'calibri.php');
$pdf->AddFont('calibrib', 'B', 'calibri.php');
$pdf->Ln(0);
$pdf->SetFont('OLDENGL', '', 32);
$pdf->Cell(0, 0, 'Certificate of Participation', 0, 0, 'C');
$pdf->SetFont('calibri', '', 11);
$pdf->Cell(0, 0, 'is ', 0, 0, 'C');

require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/learning-development.php');
require_once(root() . '/includes/database/position.php');

$employeeId = isset($_GET['p']) ? sanitize(decode($_GET['p'])) : null;

$training = fetchAssoc(attendedTraining($code, $employeeId));
?>