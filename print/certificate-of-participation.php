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

require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/learning-development.php');
require_once(root() . '/includes/database/position.php');

$employeeId = isset($_GET['p']) ? sanitize(decode($_GET['p'])) : null;
$trainings = attendedTraining($code, $employeeId);

if (numRows($trainings) === 0) {
  redirect(customUri($activeApp, '404'));
}

$employee = fetchAssoc(employee($employeeId));
$employeeName = toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'], true);
$pronoun = $employee['sex'] === 'Male' ? 'his' : 'her';
$training = fetchAssoc($trainings);
$trainingTitle = $training['title'];
$trainingDate = 'November 9-11, 2022';
$trainingVenue = $training['venue'];
$givenDate = '11th day of November, 2022';

$pdf = new PDF('L', 'mm', array($width, $height));
$pdf->SetTitle($title);
$pdf->AliasNbPages();
$pdf->SetMargins($margin, 11 + $logoSize, $margin);
$pdf->SetAutoPageBreak(true, 35);
$pdf->AddPage();
$pdf->AddFont('calibri', '', 'calibri.php');
$pdf->AddFont('calibrib', 'B', 'calibri.php');
$pdf->AddFont('timesb', 'B', 'timesb.php');
$pdf->Ln(0);
$pdf->SetFont('OLDENGL', '', 32);
$pdf->Cell(0, 0, 'Certificate of Participation', 0, 0, 'C');
$pdf->Ln(10);
$pdf->SetFont('calibri', '', 11);
$pdf->Cell(0, 0, 'is presented to', 0, 0, 'C');
$pdf->Ln(15);
$pdf->SetFont('timesb', 'B', 26);
$pdf->Cell(0, 0, strtoupper($employeeName), 0, 0, 'C');
$pdf->Ln(10);
$pdf->SetFont('calibri', '', 11);
$pdf->Cell(0, 0, "for {$pronoun} participation during the", 0, 0, 'C');
$pdf->Ln(2);
$pdf->SetFont('timesb', 'B', 12);
$pdf->MultiCell(0, 6, html_entity_decode(strtoupper($trainingTitle), ENT_QUOTES), 0, 'C');
$pdf->Ln(2);
$pdf->SetFont('calibri', '', 11);
$pdf->Cell(0, 0, "held on {$trainingDate} at", 0, 0, 'C');
$pdf->Ln(5);
$pdf->Cell(0, 0, html_entity_decode($trainingVenue, ENT_QUOTES) . '.', 0, 0, 'C');
$pdf->Ln(10);
$pdf->Cell(0, 0, "Given this {$givenDate}", 0, 0, 'C');
$pdf->Ln(5);
$pdf->Cell(0, 0, 'at ' . html_entity_decode($trainingVenue, ENT_QUOTES) . '.', 0, 0, 'C');
?>