<?php
// print/service-record.php
$logoSize = 19.5;
$margin = 8.89;
$width = 215.9;
$height = 330.2;
$lineY = 50;
$multiplePage = true;
$showQR = false;
$showStationInfo = true;
$isSchoolPortal = false;
$section = null;
$school = schoolById(divisionId());
$stationLogo = root() . '/' . $school['logo'];
$address = $school['address'];
$telephone = $school['telephone'];
$email = $school['email'];
$website = $school['website'];
$fbPage = $school['fb_page'];
$footerSpace = 0;

require_once(root() . '/print/print-layout.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/experience.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/section.php');
require_once(root() . '/includes/database/utility.php');

$employeeId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;

$employee = employee($employeeId);

if (!$employee) {
    redirect(customUri($activeApp, 'Service Record'));
}

$lname = $employee['last_name'];
$fname = $employee['first_name'];
$mname = $employee['middle_name'];
$ext = $employee['name_extension'];
$title = "{$url} | " . toName($lname, $fname, $mname, $ext, true) . ' | ' . date('Y-m-d');
$bp = toHandleNull($employee['gsis_bp']);
$agencyId = toHandleNull($employee['agency_id']);
$bdate = date('F d, Y', $employee['birthdate']);
$bplace = $employee['place_of_birth'];
$signatory = section('PER')['head_id'];
$position = position($signatory)['official_title'];
$pdf = new PDF('P', 'mm', array($width, $height));
$pdf->SetTitle($title);
$pdf->AliasNbPages();
$pdf->SetMargins($margin, 11 + $logoSize, $margin);
$pdf->SetAutoPageBreak(true, 35);
$pdf->AddPage();
$pdf->AddFont('calibri', '', 'calibri.php');
$pdf->AddFont('calibrib', 'B', 'calibrib.php');
$pdf->AddFont('calibrii', 'I', 'calibrii.php');
$pdf->AddFont('timesb', 'B', 'timesb.php');
$tableWidth = $width - ($margin * 2);
$lineHeight = 8;
$colOne = $tableWidth * 0.12;
$colTwo = $tableWidth * 0.37;
$colThree = $tableWidth * 0.2;
$colFour = $tableWidth * 0.12;
$colFive = $tableWidth * 0.12;
$colSix = $tableWidth * 0.07;
$minCounter = 15;
$maxCounter = 23;

$pdf->SetFont('timesb', 'B', 16);
$pdf->Cell(0, 0, 'STATEMENT OF SERVICE RECORD IN THE GOVERNMENT', 0, 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('calibrii', 'I', 9);
$pdf->Cell(0, 0, '(To Be Accomplished By Employer)', 0, 0, 'C');
$pdf->Ln(10);
$pdf->SetFont('calibrib', 'B', 10);
$pdf->Cell(35, 4, $bp, 0, 0, 'C');
$currentY = $pdf->GetY();
$pdf->Line($margin, $currentY + 4, $margin + 35, $currentY + 4);
$pdf->SetX($width - $margin - 35);
$pdf->Cell(35, 4, $agencyId, 0, 0, 'C');
$pdf->Line($width - $margin - 35, $currentY + 4, $width - $margin, $currentY + 4);
$pdf->SetFont('calibri', '', 10);
$pdf->Ln(4);
$pdf->Cell(35, 4, 'BP Number', 0, 0, 'C');
$pdf->SetX($width - $margin - 35);
$pdf->Cell(35, 4, 'Employee Number', 0, 0, 'C');
$pdf->Ln(10);
$pdf->SetX($margin + 3);
$pdf->Cell(15, 4, 'NAME:', 0, 0, 'L');
$pdf->SetFont('calibrib', 'B', 10);
$pdf->Cell(40, 4, strtoupper($lname), 0, 0, 'C');
$pdf->Cell(40, 4, strtoupper($fname), 0, 0, 'C');
$pdf->Cell(40, 4, strtoupper(toHandleNull($mname, 'N/A')), 0, 0, 'C');
$pdf->SetFont('calibri', '', 9);
$pdf->Cell(0, 4, '(If married women give also full maiden)', 0, 0, 'L');
$currentY = $pdf->GetY();
$pdf->Line($margin + 18, $currentY + 4, $margin + 138, $currentY + 4);
$pdf->Ln(4);
$pdf->SetX($margin + 18);
$pdf->Cell(40, 4, '(Surname)', 0, 0, 'C');
$pdf->Cell(40, 4, '(Given Name)', 0, 0, 'C');
$pdf->Cell(40, 4, '(Middle Name)', 0, 0, 'C');
$pdf->Ln(10);
$pdf->SetX($margin + 3);
$pdf->Cell(15, 4, 'BIRTH:', 0, 0, 'L');
$pdf->SetFont('calibrib', 'B', 10);
$pdf->Cell(35, 4, strtoupper($bdate), 0, 0, 'C');
$pdf->Cell(85, 4, strtoupper(toHandleNull($bplace, 'N/A')), 0, 0, 'C');
$currentY = $pdf->GetY();
$pdf->Line($margin + 18, $currentY + 4, $margin + 138, $currentY + 4);
$pdf->SetFont('calibri', '', 9);
$pdf->Cell(55, 4, '(Data herein should be checked from birth', 0, 0, 'L');
$pdf->Ln(4);
$pdf->SetX($margin + 18);
$pdf->Cell(35, 4, 'DATE', 0, 0, 'C');
$pdf->Cell(85, 4, 'PLACE', 0, 0, 'C');
$pdf->Cell(55, 4, 'or baptismal certificate or some other)', 0, 0, 'L');
$pdf->Ln(10);
$pdf->SetFont('calibri', '', 10);
$pdf->MultiCell($tableWidth, $lineHeight / 2, '            This is to certify that the above named employee actually rendered services in this Office as shown by the service record below, each line of which is supported by appointments and other papers actually issued and approved by the authorities concerned.');
$pdf->Ln($lineHeight / 2);

$pdf->SetFont('calibrib', 'B', 9);
$pdf->MultiCell($colOne, $lineHeight / 2, "SERVICE\n(Inclusive Dates)", 1, 'C');
$pdf->SetY($pdf->GetY() - $lineHeight);
$pdf->SetX($margin + $colOne);
$pdf->Cell($colTwo, $lineHeight, 'RECORDS OF APPOINTMENT', 1, 0, 'C');
$pdf->Cell($colThree, $lineHeight, 'OFFICE ENTITY / DIVISION', 1, 0, 'C');
$pdf->MultiCell($colFour, $lineHeight / 2, "LEAVE\nWITHOUT PAY", 1, 'C');
$pdf->SetY($pdf->GetY() - $lineHeight);
$pdf->SetX($margin + $colOne + $colTwo + $colThree + $colFour);
$pdf->Cell($colFive, $lineHeight, 'SEPARATION', 1, 0, 'C');
$pdf->SetX($margin + $colOne + $colTwo + $colThree + $colFour + $colFive);
$pdf->Cell($colSix, $lineHeight * 2, 'REMARKS', 1, 0, 'C');
$pdf->Ln($lineHeight);
$pdf->Cell($colOne / 2, $lineHeight, 'From', 1, 0, 'C');
$pdf->Cell($colOne / 2, $lineHeight, 'To', 1, 0, 'C');
$pdf->Cell($colTwo / 3, $lineHeight, 'Designation', 1, 0, 'C');
$pdf->MultiCell($colTwo / 3, $lineHeight / 2, "Employment\nStatus", 1, 'C');
$pdf->SetY($pdf->GetY() - $lineHeight);
$pdf->SetX($margin + $colOne + (($colTwo / 3) * 2));
$pdf->MultiCell($colTwo / 3, $lineHeight / 2, "Annual\nSalary", 1, 'C');
$pdf->SetY($pdf->GetY() - $lineHeight);
$pdf->SetX($margin + $colOne + $colTwo);
$pdf->MultiCell($colThree, $lineHeight / 2, "Station/Place/Branch of\n Assignment", 1, 'C');
$pdf->SetY($pdf->GetY() - $lineHeight);
$pdf->SetX($margin + $colOne + $colTwo + $colThree);
$pdf->Cell($colFour / 2, $lineHeight, 'From', 1, 0, 'C');
$pdf->Cell($colFour / 2, $lineHeight, 'To', 1, 0, 'C');
$pdf->Cell($colFive / 2, $lineHeight, 'Date', 1, 0, 'C');
$pdf->Cell($colFive / 2, $lineHeight, 'Cause', 1, 0, 'C');
$pdf->Ln($lineHeight);

$services = governmentService($employeeId);
$pdf->SetFont('calibri', '', 8);

if ($services) {
    foreach ($services as $service) {
        // Prepare designation and assignment columns to compute required row height
        $origFontFamily = 'calibri';
        $origFontSize = 8;
        $pdf->SetFont($origFontFamily, '', $origFontSize);

        $designation = trim($service['designation']);
        $assignment = trim($service['agency_company']);

        // target widths for wrapping columns
        $wDesignation = $colTwo / 3;
        $wAssignment = $colThree;

        // function to estimate lines for text at current font
        $estimateLines = function ($txt, $w) use ($pdf) {
            $txt = trim($txt);
            if ($txt === '')
                return 1;
            $width = $pdf->GetStringWidth($txt);
            $lines = (int) ceil($width / ($w - 1));
            return max(1, $lines);
        };

        // keep original font size (no resizing)
        $fontSize = $origFontSize;
        $pdf->SetFont($origFontFamily, '', $fontSize);

        $dLines = $estimateLines($designation, $wDesignation);
        $aLines = $estimateLines($assignment, $wAssignment);
        $maxLines = max($dLines, $aLines, 1);
        // cap at 5 lines
        $maxRows = 5;
        if ($maxLines > $maxRows) {
            $maxLines = $maxRows;
        }

        // use a compact fixed line height to avoid extra spacing
        $lineH = 3; // 3mm per wrapped line
        $rowH = $lineH * $maxLines;

        // helper: trim text to a maximum number of lines
        $fitToLines = function ($txt, $w, $maxLines) use ($pdf) {
            $words = preg_split('/\s+/', trim($txt));
            $lines = [];
            $current = '';
            foreach ($words as $word) {
                $test = $current === '' ? $word : $current . ' ' . $word;
                if ($pdf->GetStringWidth($test) <= $w - 1) {
                    $current = $test;
                } else {
                    $lines[] = $current;
                    $current = $word;
                    if (count($lines) == $maxLines) {
                        break;
                    }
                }
            }
            if (count($lines) < $maxLines && $current !== '') {
                $lines[] = $current;
            }
            // if text was trimmed, add ellipsis on last line
            if (count($lines) == $maxLines) {
                $reconstructed = implode(' ', $lines);
                if (strlen($reconstructed) < strlen($txt)) {
                    $lines[$maxLines - 1] = rtrim($lines[$maxLines - 1], '.') . '...';
                }
            }
            return implode("\n", $lines);
        };

        // build padded/wrapped versions for the limited lines
        $designationP = $fitToLines($designation, $wDesignation, $maxLines);
        $assignmentP = $fitToLines($assignment, $wAssignment, $maxLines);
        // pad shorter texts to reach maxLines
        $pad = function ($txt, $linesNeeded) {
            $current = substr_count($txt, "\n") + 1;
            if ($current < $linesNeeded) {
                $txt .= str_repeat("\n", $linesNeeded - $current);
            }
            return $txt;
        };
        $designationP = $pad($designationP, $maxLines);
        $assignmentP = $pad($assignmentP, $maxLines);

        // prepare other columns text
        $dateFrom = toDate($service['from_date'], 'm/d/y');
        $dateTo = $service['is_present'] ? 'PRESENT' : toDate($service['to_date'], 'm/d/y');
        $employment = strtoupper($service['appointment_status']);
        $salary = toCurrency($service['monthly_salary'] * 12, '');
        $leave = toHandleNull($service['leave_wo_pay'], 'N/A');
        $sepDate = $service['for_separation'] === '1' ? toDate($service['separation_date'], 'm/d/y') : 'N/A';
        $sepCause = $service['for_separation'] === '1' ? toHandleNull($service['separation_cause'], 'N/A') : 'N/A';
        $remarks = toHandleNull($service['salary_grade_step_increment']);

        $x = $pdf->GetX();
        $y = $pdf->GetY();

        // Date From (single line, but row height expands)
        $pdf->SetXY($x, $y);
        $pdf->Cell($colOne / 2, $rowH, $dateFrom, 1, 0, 'C');

        // Date To
        $pdf->Cell($colOne / 2, $rowH, $dateTo, 1, 0, 'C');

        // designation (wrapping) with single rectangle border
        $pdf->SetXY($x + $colOne, $y);
        $pdf->Rect($x + $colOne, $y, $wDesignation, $rowH);
        $pdf->MultiCell($wDesignation, $lineH, $designationP, 0, 'C');

        // Employment Status (fixed height)
        $pdf->SetXY($x + $colOne + $wDesignation, $y);
        $pdf->Cell($colTwo / 3, $rowH, $employment, 1, 0, 'C');

        // Annual Salary
        $pdf->Cell($colTwo / 3, $rowH, $salary, 1, 0, 'C');

        // assignment (wrapping) with single rectangle border
        $pdf->SetXY($x + $colOne + $colTwo, $y);
        $pdf->Rect($x + $colOne + $colTwo, $y, $wAssignment, $rowH);
        $pdf->MultiCell($wAssignment, $lineH, $assignmentP, 0, 'C');

        // other fixed small columns: leave, separation, remarks
        $pdf->SetXY($x + $colOne + $colTwo + $colThree, $y);
        $pdf->Cell($colFour, $rowH, $leave, 1, 0, 'C');

        $pdf->Cell($colFive / 2, $rowH, $sepDate, 1, 0, 'C');
        $pdf->Cell($colFive / 2, $rowH, $sepCause, 1, 0, 'C');
        $pdf->Cell($colSix, $rowH, $remarks, 1, 0, 'C');

        // move to next row position
        $pdf->SetXY($x, $y + $rowH);
    }
} else {
    $pdf->SetFontSize(10);
    $pdf->Cell($tableWidth, $lineHeight * 2, '----- NO DATA AVAILABLE -----', 1, 0, 'C');
}

$pdf->Ln($lineHeight / 2);
$pdf->SetFont('calibri', '', 10);
$pdf->MultiCell($tableWidth, $lineHeight / 2, '            Issued in compliance with Executive Order No. 54 dated August 10, 1954 and in accordance with Circular No. 58 dated August 10, 1954 of the System.');
$pdf->Ln($lineHeight);
$pdf->Cell(0, 0, 'Verified and found correct:');
$pdf->Ln($lineHeight);
$pdf->SetFont('timesb', 'B', 10);
$pdf->Cell($tableWidth / 3 + 5, $lineHeight, userName($signatory, true), 0, 0, 'C');
$pdf->Line($margin, $pdf->GetY() + $lineHeight - 2, $margin + $tableWidth / 3 + 5, $pdf->GetY() + $lineHeight - 2);
$pdf->SetFont('calibri', '', 10);
$pdf->SetX($tableWidth / 3 * 2);
$pdf->Cell(40, $lineHeight, date('F j, Y'), 0, 0, 'C');
$pdf->Line(($tableWidth / 3) * 2, $pdf->GetY() + $lineHeight - 2, (($tableWidth / 3) * 2) + 40, $pdf->GetY() + $lineHeight - 2);
$pdf->Ln($lineHeight / 2);
$pdf->SetFont('calibrii', 'I', '9');
$pdf->Cell($tableWidth / 3 + 5, $lineHeight, '(Chief or Head of Office)', 0, 0, 'C');
$pdf->SetFont('calibri', '', 10);
$pdf->SetX($tableWidth / 3 * 2);
$pdf->Cell(40, $lineHeight, 'Date', 0, 0, 'C');
$pdf->Ln($lineHeight - 2);
$pdf->AddFont('times', '', 'times.php');
$pdf->SetFont('times', '', 10);
$pdf->Cell($tableWidth / 3 + 5, $lineHeight, "{$position} (Personnel Officer)", 0, 0, 'C');
$pdf->Line($margin, $pdf->GetY() + $lineHeight - 2, $margin + $tableWidth / 3 + 5, $pdf->GetY() + $lineHeight - 2);
$pdf->Line(($tableWidth / 3) * 2, $pdf->GetY() + $lineHeight - 2, (($tableWidth / 3) * 2) + 40, $pdf->GetY() + $lineHeight - 2);
$pdf->Ln($lineHeight / 2);
$pdf->SetFont('calibrii', 'I', '9');
$pdf->Cell($tableWidth / 3 + 5, $lineHeight, '(Designation)', 0, 0, 'C');
$pdf->SetFont('calibri', '', 10);
$pdf->SetX($tableWidth / 3 * 2);
$pdf->Cell(40, $lineHeight, 'Control No.', 0, 0, 'C');