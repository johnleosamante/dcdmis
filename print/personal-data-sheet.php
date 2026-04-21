$fill$fil$fi$f$<?php
// print/personal-data-sheet.php
$width = 215.9;
$height = 330.2;
$margin = 5;

require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/country.php');
require_once(root() . '/includes/database/family-background.php');
require_once(root() . '/includes/database/education.php');
require_once(root() . '/includes/database/eligibility.php');
require_once(root() . '/includes/database/experience.php');
require_once(root() . '/includes/database/voluntary-work.php');
require_once(root() . '/includes/database/learning-development.php');
require_once(root() . '/includes/database/special-skill.php');
require_once(root() . '/includes/database/recognition.php');
require_once(root() . '/includes/database/membership.php');
require_once(root() . '/includes/database/other-information.php');
require_once(root() . '/includes/database/references.php');
require_once(root() . '/includes/database/card-type.php');

$employeeId = sanitize(decode($_GET['id']));
$e = employee($employeeId);
$employee = userName($e['id']);
$title = "CS Form No. 212 Revised 2025 {$url} | {$employee}";

if (!$e) {
    redirect(uri() . '/hrmis');
}

class PDS extends FPDF
{
    public function Header()
    {
        if ($this->PageNo() == 1) {
            $this->SetFont('Arial', 'BI', 8);
            $this->Cell(0, 4, 'CS Form No. 212', 0, 1, 'L');

            $this->SetFont('Arial', 'I', 7);
            $this->Cell(0, 3, 'Revised 2025', 0, 1, 'L');

            $this->SetFont('Arial', 'B', 18);
            $this->Cell(0, 6, 'PERSONAL DATA SHEET', 0, 1, 'C');
            $this->Ln(3);

            $this->SetFont('Arial', 'BI', 8);
            $this->MultiCell(0, 3, "WARNING: Any misrepresentation made in the Personal Data Sheet and the Work Experience Sheet shall cause the filing of administrative/criminal case/s against the person concerned.", 0, 'L');
            $this->Cell(0, 3, 'READ THE ATTACHED GUIDE TO FILLING OUT THE PERSONAL DATA SHEET (PDS) BEFORE ACCOMPLISHING THE PDS FORM.', 0, 1, 'L');

            $this->SetFont('Arial', '', 7);
            $this->Cell(140, 4, 'Print legibly if accomplished through own handwriting. Tick appropriate boxes ( [  ] ) and use separate sheet if necessary. Indicate N/A if not applicable.  DO NOT ABBREVIATE.', 0, 0, 'L');
            $this->Ln(5);
        }
    }

    public function Footer()
    {
        $this->SetY(-10);
        $this->SetFont('Arial', 'I', 7);
        $this->Cell(0, 5, 'CS FORM 212 (Revised 2025), Page ' . $this->PageNo() . ' of 4', 0, 0, 'R');
    }

    public function SectionTitle($title, $width = 200, $height = 5)
    {
        $this->SetFont('Arial', 'BI', 9);
        $this->SetFillColor(150, 150, 150);
        $this->SetTextColor(255, 255, 255);
        $this->Cell($width, $height, $title, 0, 0, 'L', true);
        $this->SetTextColor(0, 0, 0);
    }

    public function Label($text, $w, $h = 6, $border = 0, $align = 'L', $fill = true, $multiline = false, $font = 6, $style = '')
    {
        $this->SetFont('Arial', $style, $font);
        if ($fill) {
            $this->SetFillColor(234, 234, 234);
        }

        if (!$multiline) {
            $stringWidth = $this->GetStringWidth($text);
            if ($stringWidth > $w) {
                $truncated = $text;
                while ($this->GetStringWidth("{$truncated}...") > $w && strlen($truncated) > 0) {
                    $truncated = substr($truncated, 0, -2);
                }
                $text = "{$truncated}...";
            }

            $this->Cell($w, $h, $text, $border, 0, $align, $fill);
        } else {
            $this->MultiCell($w, $h, $text, $border, $align, $fill);
        }
    }

    public function Value($text, $w, $h = 6, $border = 1, $align = 'L', $multiline = false)
    {
        $this->SetFont('Arial', '', 8);

        if (!$multiline) {
            $stringWidth = $this->GetStringWidth($text);
            if ($stringWidth > $w) {
                $truncated = $text;
                while ($this->GetStringWidth("{$truncated}...") > $w && strlen($truncated) > 0) {
                    $truncated = substr($truncated, 0, -2);
                }
                $text = "{$truncated}...";
            }

            $this->Cell($w, $h, $text, $border, 0, $align);
        } else {
            $this->MultiCell($w, $h, $text, $border, $align);
        }
    }
}

$pdf = new PDS('P', 'mm', [$width, $height]);
$pdf->SetTitle($title);
$pdf->SetAutoPageBreak(true, 5);
$pdf->SetMargins($margin, $margin, $margin);

// ==========================================================
// PAGE 1
// ==========================================================
$pdf->AddPage();

// I. PERSONAL INFORMATION
$pdf->SectionTitle('I. PERSONAL INFORMATION', $width - ($margin * 2));

$pdf->SetXY($margin, 40);
$pdf->Label(' 1. SURNAME', 32);
$pdf->Value(e($e['last_name']), 174);

$pdf->SetXY($margin, 46);
$pdf->Label(' 2. FIRST NAME', 32);
$pdf->Value(e($e['first_name']), 125);
$pdf->Label('NAME EXTENSION (JR., SR)', 49, 6, 1, 'L');
$pdf->SetX(197);
$pdf->Value(toHandleNull($e['name_extension'], 'N/A'), 14, 6, 0);
$pdf->SetXY($margin, 52);
$pdf->Label('     MIDDLE NAME', 32);
$pdf->Value(e($e['middle_name']), 174);

$pdf->SetXY($margin, 58);
$pdf->Label('', 32, 12, 1);
$pdf->SetXY($margin, 59);
$pdf->Label(" 3. DATE OF BIRTH\n    (dd/mm/yyyy)", 35, 3, 0, 'L', false, true);
$pdf->SetXY(37, 58);
$pdf->Value(toDate($e['birthdate'], 'd/m/Y'), 48, 12, 1, 'C');

$pdf->SetXY($margin, 70);
$pdf->Label(' 4. PLACE OF BIRTH', 32, 6, 1);
$pdf->Value(e($e['place_of_birth']), 48);

$pdf->SetXY($margin, 76);
$pdf->Label(' 5. SEX AT BIRTH', 32, 6, 1);
$pdf->Value('', 48);
$pdf->SetXY(39, 77.5);
$sex = strtolower($e['sex']);
$pdf->Value($sex === 'male' ? '/' : '', 3, 3);
$pdf->SetXY(43, 76);
$pdf->Value('Male', 10, 6, 0);
$pdf->SetXY(65, 77.5);
$pdf->Value($sex === 'female' ? '/' : '', 3, 3);
$pdf->SetXY(69, 76);
$pdf->Value('Female', 25, 6, 0);

$pdf->SetXY($margin, 82);
$pdf->Label('', 32, 14, 1);
$pdf->SetXY($margin, 83);
$pdf->Label(' 6. CIVIL STATUS', 31, 6);
$pdf->SetXY(39, 83.5);
$civilStatus = strtolower($e['civil_status']);
$pdf->Value($civilStatus === 'single' ? '/' : '', 3, 3);
$pdf->SetXY(43, 82);
$pdf->Value('Single', 10, 6, 0);
$pdf->SetXY(65, 83.5);
$pdf->Value($civilStatus === 'married' ? '/' : '', 3, 3);
$pdf->SetXY(69, 82);
$pdf->Value('Married', 25, 6, 0);
$pdf->SetXY(39, 87.5);
$pdf->Value($civilStatus === 'widowed' ? '/' : '', 3, 3);
$pdf->SetXY(43, 86);
$pdf->Value('Widowed', 15, 6, 0);
$pdf->SetXY(65, 87.5);
$pdf->Value($civilStatus === 'separated' ? '/' : '', 3, 3);
$pdf->SetXY(69, 86);
$pdf->Value('Separated', 25, 6, 0);
$pdf->SetXY(39, 91.5);
$pdf->Value($civilStatus === 'others' ? '/' : '', 3, 3);
$pdf->SetXY(43, 90);
$pdf->Value('Other/s:', 15, 6, 0);
$pdf->SetXY(55, 91.25);
$pdf->Value(strtoupper($e['specify_other_civil_status'] ?? 'N/A'), 25, 4, 0);

$pdf->SetXY($margin, 96);
$pdf->Label(' 7. HEIGHT (m)', 32, 7, 1);
$pdf->Value(strtoupper($e['height'] ?? 'N/A'), 48, 7);

$pdf->SetXY($margin, 103);
$pdf->Label(' 8. WEIGHT (kg)', 32, 7, 1);
$pdf->Value(strtoupper($e['weight'] ?? 'N/A'), 48, 7);

$pdf->SetXY($margin, 110);
$pdf->Label(' 9. BLOOD TYPE', 32, 7, 1);
$pdf->Value(strtoupper($e['blood_type'] ?? 'N/A'), 48, 7);

$pdf->SetXY($margin, 117);
$pdf->Label(' 10. UMID ID NO.', 32, 7, 1);
$pdf->Value(strtoupper($e['umid_id'] ?? 'N/A'), 48, 7);

$pdf->SetXY($margin, 124);
$pdf->Label(' 11. PAG-IBIG ID NO.', 32, 7, 1);
$pdf->Value(strtoupper($e['pagibig'] ?? 'N/A'), 48, 7);

$pdf->SetXY($margin, 131);
$pdf->Label(' 12. PHILHEALTH NO.', 32, 7, 1);
$pdf->Value(strtoupper($e['philhealth'] ?? 'N/A'), 48, 7);

$pdf->SetXY($margin, 138);
$pdf->Label(' 13. PhilSys Number (PSN):', 32, 7, 1);
$pdf->Value(strtoupper($e['philsys'] ?? 'N/A'), 48, 7);

$pdf->SetXY($margin, 145);
$pdf->Label(' 14. TIN NO.', 32, 7, 1);
$pdf->Value(strtoupper($e['tin'] ?? 'N/A'), 48, 7);

$pdf->SetXY($margin, 152);
$pdf->Label(' 15. AGENCY EMPLOYEE NO.', 32, 7, 1);
$pdf->Value(strtoupper($e['agency_id'] ?? 'N/A'), 48, 7);

$pdf->SetXY(85, 58);
$pdf->Label('', 47, 24, 1);
$pdf->SetXY(85, 59);
$pdf->Label(' 16. CITIZENSHIP', 40, 5, 0);
$pdf->SetXY(80, 72);
$pdf->Label("If holder of dual citizenship,\nplease indicate the details.", 40, 3, 0, 'C', false, true);

$pdf->SetXY(134, 60);
$pdf->Value(strtolower(citizenship($e['citizenship_id'])['name']) === 'filipino' ? '/' : '', 3, 3);
$pdf->SetXY(138, 58.5);
$pdf->Value('Filipino', 10, 7, 0);

$pdf->SetXY(150, 60);
$dualCitizenshipType = strtolower($e['dual_citizenship_type']);
$pdf->Value($dualCitizenshipType !== 'N/A' ? '/' : '', 3, 3);
$pdf->SetXY(155, 58.5);
$pdf->Value('Dual Citizenship', 25, 7, 0);

$pdf->SetXY(155, 65);
$pdf->Value($dualCitizenshipType === 'by birth' ? '/' : '', 3, 3);
$pdf->SetXY(159, 63.5);
$pdf->Value('by birth', 10, 7, 0);
$pdf->SetXY(173, 65);
$pdf->Value($dualCitizenshipType === 'by naturalization' ? '/' : '', 3, 3);
$pdf->SetXY(177, 63.5);
$pdf->Value('by naturalization', 25, 7, 0);

$pdf->SetXY(132, 71);
$pdf->Value('Pls. indicate country:', 77, 5, 0, 'C');
$pdf->SetXY(132, 76);
$country = $e['dual_citizenship_country_id'] !== null ? strtoupper(country($e['dual_citizenship_country_id'])) : 'N/A';
$pdf->Value($country, 79, 6, 1, 'C');

$pdf->SetXY(85, 82);
$pdf->Label('', 31, 28, 1);
$pdf->SetXY(85, 83);
$pdf->Label(' 17. RESIDENTIAL ADDRESS', 30, 5);
$pdf->SetXY(86, 104);
$pdf->Label('ZIP CODE', 30, 5, 0, 'C');
$pdf->SetXY(116, 82);
$pdf->Value(strtoupper($e['residence_lot'] ?? 'N/A'), 47.5, 5, 0, 'C');
$pdf->Value(strtoupper($e['residence_street'] ?? 'N/A'), 47.5, 5, 0, 'C');
$pdf->SetXY(117, 86);
$pdf->Label('House/Block/Lot No.', 46.5, 3, 0, 'C', false);
$pdf->Label('Street', 47.5, 3, 0, 'C', false);
$pdf->SetXY(116, 89);
$pdf->Value(strtoupper($e['residence_subdivision'] ?? 'N/A'), 47.5, 5, 0, 'C');
$pdf->Value(strtoupper($e['residence_barangay'] ?? 'N/A'), 47.5, 5, 0, 'C');
$pdf->SetXY(117, 93);
$pdf->Label('Subdivision/Village', 46.5, 3, 0, 'C', false);
$pdf->Label('Barangay', 47.5, 3, 0, 'C', false);
$pdf->SetXY(116, 96);
$pdf->Value(strtoupper($e['residence_city'] ?? 'N/A'), 47.5, 5, 0, 'C');
$pdf->Value(strtoupper($e['residence_province'] ?? 'N/A'), 47.5, 5, 0, 'C');
$pdf->SetXY(117, 100);
$pdf->Label('City/Municipality', 46.5, 3, 0, 'C', false);
$pdf->Label('Province', 47.5, 3, 0, 'C', false);
$pdf->SetXY(116, 103);
$pdf->Value(strtoupper($e['residence_zip'] ?? 'N/A'), 95, 7, 1, 'C');

$pdf->SetXY(85, 110);
$pdf->Label('', 31, 28, 1);
$pdf->SetXY(85, 111);
$pdf->Label(' 18. PERMANENT ADDRESS', 30, 5);
$pdf->SetXY(86, 132);
$pdf->Label('ZIP CODE', 30, 5, 0, 'C');
$pdf->SetXY(116, 110);
$pdf->Value(strtoupper($e['permanent_lot'] ?? 'N/A'), 47.5, 5, 0, 'C');
$pdf->Value(strtoupper($e['permanent_street'] ?? 'N/A'), 47.5, 5, 0, 'C');
$pdf->SetXY(117, 114);
$pdf->Label('House/Block/Lot No.', 46.5, 3, 0, 'C', false);
$pdf->Label('Street', 47.5, 3, 0, 'C', false);
$pdf->SetXY(116, 117);
$pdf->Value(strtoupper($e['permanent_subdivision'] ?? 'N/A'), 47.5, 5, 0, 'C');
$pdf->Value(strtoupper($e['permanent_barangay'] ?? 'N/A'), 47.5, 5, 0, 'C');
$pdf->SetXY(117, 121);
$pdf->Label('Subdivision/Village', 46.5, 3, 0, 'C', false);
$pdf->Label('Barangay', 47.5, 3, 0, 'C', false);
$pdf->SetXY(116, 124);
$pdf->Value(strtoupper($e['permanent_city'] ?? 'N/A'), 47.5, 5, 0, 'C');
$pdf->Value(strtoupper($e['permanent_province'] ?? 'N/A'), 47.5, 5, 0, 'C');
$pdf->SetXY(117, 128);
$pdf->Label('City/Municipality', 46.5, 3, 0, 'C', false);
$pdf->Label('Province', 47.5, 3, 0, 'C', false);
$pdf->SetXY(116, 131);
$pdf->Value(strtoupper($e['permanent_zip'] ?? 'N/A'), 95, 7, 1, 'C');

$pdf->SetXY(85, 138);
$pdf->Label(' 19. TELEPHONE NO.', 31, 7, 1);
$pdf->Value(strtoupper($e['telephone'] ?? 'N/A'), 95, 7);

$pdf->SetXY(85, 145);
$pdf->Label(' 20. MOBILE NO.', 31, 7, 1);
$pdf->Value(strtoupper($e['mobile_number'] ?? 'N/A'), 95, 7);

$pdf->SetXY(85, 152);
$pdf->Label(' 21. E-MAIL ADDRESS (if any)', 31, 7, 1);
$pdf->Value(strtolower($e['email_address'] ?? 'N/A'), 95, 7);

// II. FAMILY BACKGROUND
$pdf->SetXY($margin, 159);
$pdf->SectionTitle('II. FAMILY BACKGROUND', $width - ($margin * 2));
$pdf->SetXY($margin, 164);
$pdf->Label(' 22. SPOUSE\'S SURNAME', 32);
$f = family($employeeId);
$pdf->Value(strtoupper($f['spouse_last_name'] ?? 'N/A'), 79);
$pdf->SetXY($margin, 170);
$pdf->Label('         FIRST NAME', 32);
$pdf->Value(strtoupper($f['spouse_first_name'] ?? 'N/A'), 48);
$pdf->Label('NAME EXTENSION', 31, 6, 1);
$pdf->SetXY(106, 170);
$pdf->Value(strtoupper($f['spouse_name_extension'] ?? 'N/A'), 10, 6, 0);
$pdf->SetXY($margin, 176);
$pdf->Label('         MIDDLE NAME', 32);
$pdf->Value(strtoupper($f['spouse_middle_name'] ?? 'N/A'), 79);
$pdf->SetXY($margin, 182);
$pdf->Label('      OCCUPATION', 32, 6, 1);
$pdf->Value(strtoupper($f['spouse_occupation'] ?? 'N/A'), 79);
$pdf->SetXY($margin, 188);
$pdf->Label('      EMPLOYER/BUSINESS', 32, 6, 1);
$pdf->Value(strtoupper($f['spouse_employer'] ?? 'N/A'), 79);
$pdf->SetXY($margin, 194);
$pdf->Label('      BUSINESS ADDRESS', 32, 6, 1);
$pdf->Value(strtoupper($f['spouse_employer_address'] ?? 'N/A'), 79);
$pdf->SetXY($margin, 200);
$pdf->Label('      TELEPHONE NO.', 32, 6, 1);
$pdf->Value(strtoupper($f['spouse_telephone'] ?? 'N/A'), 79);
$pdf->SetXY($margin, 206);
$pdf->Label(' 24. FATHER\'S SURNAME', 32);
$pdf->Value(strtoupper($f['father_last_name'] ?? 'N/A'), 79);
$pdf->Line($margin, 206, 37, 206);
$pdf->SetXY($margin, 212);
$pdf->Label('      FIRST NAME', 32);
$pdf->Value(strtoupper($f['father_first_name'] ?? 'N/A'), 48);
$pdf->Label('NAME EXTENSION', 31, 6, 1);
$pdf->SetXY(106, 212);
$pdf->Value(strtoupper($f['father_name_extension'] ?? 'N/A'), 10, 6, 0);
$pdf->SetXY($margin, 218);
$pdf->Label('      MIDDLE NAME', 32);
$pdf->Value(strtoupper($f['father_middle_name'] ?? 'N/A'), 79);
$pdf->SetXY($margin, 224);
$pdf->Label(' 25. MOTHER\'S MAIDEN NAME', 111, 6);
$pdf->Line($margin, 224, 116, 224);
$pdf->Line(116, 224, 116, 230);
$pdf->SetXY($margin, 230);
$pdf->Label('      SURNAME', 32);
$pdf->Value(strtoupper($f['mother_last_name'] ?? 'N/A'), 79);
$pdf->SetXY($margin, 236);
$pdf->Label('      FIRST NAME', 32);
$pdf->Value(strtoupper($f['mother_first_name'] ?? 'N/A'), 79);
$pdf->SetXY($margin, 242);
$pdf->Label('      MIDDLE NAME', 32);
$pdf->Value(strtoupper($f['mother_middle_name'] ?? 'N/A'), 79);

$pdf->SetXY($margin + 32 + 79, 164);
$pdf->Label(' 23. NAME OF CHILDREN (Write in full and list all)', 63, 6, 1);
$pdf->Label("DATE OF BIRTH\n(dd/mm/yyyy)", 32, 3, 1, 'C', true, true);
$pdf->SetXY($margin + 32 + 79, 170);

$pdf->Value('', 63);
$pdf->Value('', 32);
$pdf->SetXY($margin + 32 + 79, 176);
$pdf->Value('', 63);
$pdf->Value('', 32);
$pdf->SetXY($margin + 32 + 79, 182);
$pdf->Value('', 63);
$pdf->Value('', 32);
$pdf->SetXY($margin + 32 + 79, 188);
$pdf->Value('', 63);
$pdf->Value('', 32);
$pdf->SetXY($margin + 32 + 79, 194);
$pdf->Value('', 63);
$pdf->Value('', 32);
$pdf->SetXY($margin + 32 + 79, 200);
$pdf->Value('', 63);
$pdf->Value('', 32);
$pdf->SetXY($margin + 32 + 79, 206);
$pdf->Value('', 63);
$pdf->Value('', 32);
$pdf->SetXY($margin + 32 + 79, 212);
$pdf->Value('', 63);
$pdf->Value('', 32);
$pdf->SetXY($margin + 32 + 79, 218);
$pdf->Value('', 63);
$pdf->Value('', 32);
$pdf->SetXY($margin + 32 + 79, 224);
$pdf->Value('', 63);
$pdf->Value('', 32);
$pdf->SetXY($margin + 32 + 79, 230);
$pdf->Value('', 63);
$pdf->Value('', 32);
$pdf->SetXY($margin + 32 + 79, 236);
$pdf->Value('', 63);
$pdf->Value('', 32);

// III. EDUCATIONAL BACKGROUND
$pdf->SetXY($margin, 247);
$pdf->SectionTitle('III. EDUCATIONAL BACKGROUND', $width - ($margin * 2));
$pdf->SetXY($margin, 252);
$pdf->Label('LEVEL', 32, 12, 1, 'C');
$pdf->SetXY($margin, 252);
$pdf->Label(' 26.', 5, 6, 0, 'L');
$pdf->SetXY($margin + 32, 252);
$pdf->Label("\nNAME OF SCHOOL\n(Write in full)\n\n", 48, 3, 1, 'C', true, true);
$pdf->SetXY($margin + 32 + 48, 252);
$pdf->Label("\nBASIC EDUCATION / DEGREE / COURSE\n(Write in full)\n\n", 47, 3, 1, 'C', true, true);
$pdf->SetXY($margin + 32 + 48 + 47, 252);
$pdf->Label('PERIOD OF ATTENDANCE', 30, 6, 1, 'C');
$pdf->SetXY($margin + 32 + 48 + 47, 258);
$pdf->Label('From', 15, 6, 1, 'C');
$pdf->Label('To', 15, 6, 1, 'C');

$pdf->SetXY($margin + 32 + 48 + 47 + 30, 252);
$pdf->Label('HIGHEST LEVEL/UNITS EARNED (if not graduated)', 17, 3, 1, 'C', true, true);
$pdf->SetXY($margin + 32 + 48 + 47 + 30 + 17, 252);
$pdf->Label("\nYEAR\nGRADUATED\n\n", 16, 3, 1, 'C', true, true);
$pdf->SetXY($margin + 32 + 48 + 47 + 30 + 17 + 16, 252);
$pdf->Label('SCHOLARSHIP/ ACADEMIC HONORS RECEIVED', 16, 3, 1, 'C', true, true);

$levels = ['ELEMENTARY', 'SECONDARY', 'VOCATIONAL/TRADE COURSE', 'COLLEGE', 'GRADUATE STUDIES'];
foreach ($levels as $l) {
    $pdf->Label($l, 32, 9, 1, 'C');
    $pdf->Value('', 48, 9);
    $pdf->Value('', 47, 9);
    $pdf->Value('', 15, 9);
    $pdf->Value('', 15, 9);
    $pdf->Value('', 17, 9);
    $pdf->Value('', 16, 9);
    $pdf->Value('', 16, 9);
    $pdf->Ln();
}
$pdf->SetFillColor(234, 234, 234);
$pdf->SetFont('Arial', 'I', '7');
$pdf->SetTextColor(255, 0, 0);
$pdf->Cell($width - ($margin * 2), 4, '(Continue on separate sheet if necessary)', 1, 1, 'C', true);

$pdf->SetTextColor(0);
$pdf->SetXY($margin, $height - 17);
$pdf->Label('SIGNATURE', 32, 7, 1, 'C', true, false, 10, 'BI');

$pdf->SetTextColor(255, 0, 0);
$pdf->SetFontSize(7);
$pdf->Cell(95, 6, '(wet signature/e-signature/digital certificate)', 0, 1, 'C');

$pdf->SetTextColor(0);
$pdf->SetXY($margin + 127, $height - 17);
$pdf->Label('DATE', 30, 7, 1, 'C', true, false, 10, 'BI');

// personal information
// residential address
$pdf->Line(116, 89, $width - $margin, 89);
$pdf->Line(116, 96, $width - $margin, 96);

// permanent address
$pdf->Line(116, 117, $width - $margin, 117);
$pdf->Line(116, 124, $width - $margin, 124);


$pdf->SetLineWidth(0.4);
// page borders
$pdf->Line($margin, $margin, $width - $margin, $margin);
$pdf->Line($margin, $margin, $margin, $height - $margin - 5);
$pdf->Line($margin, $height - $margin - 5, $width - $margin, $height - $margin - 5);
$pdf->Line($width - $margin, $margin, $width - $margin, $height - $margin - 5);

// personal information borders
$pdf->Line($margin, 35, $width - $margin, 35);
$pdf->Line($margin, 40, $width - $margin, 40);

$pdf->Line(85, 58, 85, 159); // vertical border

// family background borders
$pdf->Line($margin, 159, $width - $margin, 159);
$pdf->Line($margin, 164, $width - $margin, 164);

// educational background borders
$pdf->Line($margin, 247, $width - $margin, 247);
$pdf->Line($margin, 252, $width - $margin, 252);

// page bottom
$pdf->Line($margin, $height - 21, $width - $margin, $height - 21);
$pdf->Line($margin, $height - 17, $width - $margin, $height - 17);

// ==========================================================
// PAGE 2
// ==========================================================
$pdf->AddPage();

// IV. CIVIL SERVICE ELIGIBILITY
$pdf->SectionTitle('IV. CIVIL SERVICE ELIGIBILITY');
$pdf->Label(' 27. CAREER SERVICE/ RA 1080 (BOARD/ BAR) UNDER SPECIAL LAWS/ CES/ CSEE', 60, 10, 1, 'C');
$pdf->Label('RATING', 15, 10, 1, 'C');
$pdf->Label('DATE OF EXAM', 20, 10, 1, 'C');
$pdf->Label('PLACE OF EXAMINATION / CONFERMENT', 60, 10, 1, 'C');
$pdf->Label('LICENSE (if applicable)', 40, 5, 1, 'C');
$pdf->Ln(5);
$pdf->SetXY(165, $pdf->GetY());
$pdf->Label('NUMBER', 20, 5, 1, 'C');
$pdf->Label('Date of Validity', 20, 5, 1, 'C');
$pdf->Ln();

for ($i = 0; $i < 7; $i++) {
    $pdf->Value('', 60, 5);
    $pdf->Value('', 15, 5);
    $pdf->Value('', 20, 5);
    $pdf->Value('', 60, 5);
    $pdf->Value('', 20, 5);
    $pdf->Value('', 20, 5);
    $pdf->Ln();
}
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell(195, 5, '(Continue on separate sheet if necessary)', 1, 1, 'C', true);

// V. WORK EXPERIENCE
$pdf->SectionTitle('V. WORK EXPERIENCE');
$pdf->SetFont('Arial', 'I', 7);
$pdf->Cell(195, 4, ' (Include private employment. Start from your recent work) Description of duties should be indicated in the attached Work Experience sheet.', 1, 1, 'L', true);

$pdf->Label(' 28. INCLUSIVE DATES', 30, 5, 1, 'C');
$pdf->Label('POSITION TITLE', 45, 10, 1, 'C');
$pdf->Label('DEPARTMENT / AGENCY / OFFICE / COMPANY', 50, 10, 1, 'C');
$pdf->Label('MONTHLY SALARY', 15, 10, 1, 'C');
$pdf->Label('SALARY/ JOB/ PAY GRADE', 20, 10, 1, 'C');
$pdf->Label('STATUS OF APPT', 20, 10, 1, 'C');
$pdf->Label('GOV\'T SERVICE', 15, 10, 1, 'C');
$pdf->Ln(5);
$pdf->SetXY(10, $pdf->GetY());
$pdf->Label('From', 15, 5, 1, 'C');
$pdf->Label('To', 15, 5, 1, 'C');
$pdf->Ln();

for ($i = 0; $i < 28; $i++) {
    $pdf->Value('', 15, 5);
    $pdf->Value('', 15, 5);
    $pdf->Value('', 45, 5);
    $pdf->Value('', 50, 5);
    $pdf->Value('', 15, 5);
    $pdf->Value('', 20, 5);
    $pdf->Value('', 20, 5);
    $pdf->Value('', 15, 5);
    $pdf->Ln();
}
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell(195, 5, '(Continue on separate sheet if necessary)', 1, 1, 'C', true);

// ==========================================================
// PAGE 3
// ==========================================================
$pdf->AddPage();

// VI. VOLUNTARY WORK
$pdf->SectionTitle('VI. VOLUNTARY WORK OR INVOLVEMENT IN CIVIC / NON-GOVERNMENT / PEOPLE / VOLUNTARY ORGANIZATION/S');
$pdf->Label(' 29. NAME & ADDRESS OF ORGANIZATION', 85, 10, 1, 'C');
$pdf->Label('INCLUSIVE DATES', 30, 5, 1, 'C');
$pdf->Label('NUMBER OF HOURS', 20, 10, 1, 'C');
$pdf->Label('POSITION / NATURE OF WORK', 60, 10, 1, 'C');
$pdf->Ln(5);
$pdf->SetXY(95, $pdf->GetY());
$pdf->Label('From', 15, 5, 1, 'C');
$pdf->Label('To', 15, 5, 1, 'C');
$pdf->Ln();

for ($i = 0; $i < 7; $i++) {
    $pdf->Value('', 85, 5);
    $pdf->Value('', 15, 5);
    $pdf->Value('', 15, 5);
    $pdf->Value('', 20, 5);
    $pdf->Value('', 60, 5);
    $pdf->Ln();
}
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell(195, 5, '(Continue on separate sheet if necessary)', 1, 1, 'C', true);

// VII. LEARNING AND DEVELOPMENT
$pdf->SectionTitle('VII. LEARNING AND DEVELOPMENT (L&D) INTERVENTIONS/TRAINING PROGRAMS ATTENDED');
$pdf->SetFont('Arial', 'I', 7);
$pdf->Cell(195, 4, ' (Start from the most recent L&D/training program and include only the relevant L&D/training taken for the last five (5) years for Division Chief/Executive/Managerial positions)', 1, 1, 'L', true);

$pdf->Label(' 30. TITLE OF LEARNING AND DEVELOPMENT', 85, 10, 1, 'C');
$pdf->Label('INCLUSIVE DATES', 30, 5, 1, 'C');
$pdf->Label('NUMBER OF HOURS', 15, 10, 1, 'C');
$pdf->Label('Type of LD', 15, 10, 1, 'C');
$pdf->Label('CONDUCTED / SPONSORED BY', 50, 10, 1, 'C');
$pdf->Ln(5);
$pdf->SetXY(95, $pdf->GetY());
$pdf->Label('From', 15, 5, 1, 'C');
$pdf->Label('To', 15, 5, 1, 'C');
$pdf->Ln();

for ($i = 0; $i < 18; $i++) {
    $pdf->Value('', 85, 5);
    $pdf->Value('', 15, 5);
    $pdf->Value('', 15, 5);
    $pdf->Value('', 15, 5);
    $pdf->Value('', 15, 5);
    $pdf->Value('', 50, 5);
    $pdf->Ln();
}
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell(195, 5, '(Continue on separate sheet if necessary)', 1, 1, 'C', true);

// VIII. OTHER INFORMATION
$pdf->SectionTitle('VIII. OTHER INFORMATION');
$pdf->Label(' 31. SPECIAL SKILLS and HOBBIES', 55, 5, 1, 'C');
$pdf->Label(' 32. NON-ACADEMIC DISTINCTIONS', 80, 5, 1, 'C');
$pdf->Label(' 33. MEMBERSHIP IN ASSOC/ORG', 60, 5, 1, 'C');
$pdf->Ln();

for ($i = 0; $i < 7; $i++) {
    $pdf->Value('', 55, 5);
    $pdf->Value('', 80, 5);
    $pdf->Value('', 60, 5);
    $pdf->Ln();
}
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell(195, 5, '(Continue on separate sheet if necessary)', 1, 1, 'C', true);

// ==========================================================
// PAGE 4
// ==========================================================
$pdf->AddPage();
// Question 34-40
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(195, 3, '', 0, 1);
$pdf->SetXY(10, 15);

$yStart = $pdf->GetY();
$q34 = "34. Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be appointed,\n\n  a. within the third degree?\n  b. within the fourth degree (for Local Government Unit - Career Employees)?";
$q35 = "35. a. Have you ever been found guilty of any administrative offense?\n\n  b. Have you been criminally charged before any court?";
$q36 = "36. Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?";
$q37 = "37. Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?";
$q38 = "38. a. Have you ever been a candidate in a national or local election held within the last year (except Barangay election)?\n\n  b. Have you resigned from the government service during the three (3)-month period before the last election to promote/actively campaign for a national or local candidate?";
$q39 = "39. Have you acquired the status of an immigrant or permanent resident of another country?";
$q40 = "40. Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:\n\n  a. Are you a member of any indigenous group?\n  b. Are you a person with disability?\n  c. Are you a solo parent?";

$questions = [
    $q34 => 30,
    $q35 => 20,
    $q36 => 15,
    $q37 => 20,
    $q38 => 25,
    $q39 => 15,
    $q40 => 35
];

foreach ($questions as $q => $h) {
    $rY = $pdf->GetY();
    $pdf->SetFont('Arial', '', 7);
    $pdf->SetFillColor(234, 234, 234);
    $pdf->MultiCell(130, 4, $q, 1, 'L', true);
    $aH = max($h, $pdf->GetY() - $rY);
    if ($aH > $pdf->GetY() - $rY) {
        $pdf->SetXY(10, $rY);
        $pdf->Cell(130, $aH, '', 1, 0); // draw border
    }

    $pdf->SetXY(140, $rY);
    $pdf->Cell(65, $aH, '', 1, 0);
    $pdf->SetXY(142, $rY + 2);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(15, 3, "[ ] YES", 0, 0);
    $pdf->Cell(15, 3, "[ ] NO", 0, 0);
    $pdf->SetXY(142, $rY + 6);
    $pdf->SetFont('Arial', '', 7);
    $pdf->MultiCell(60, 4, "If YES, give details:\n___________________________________\n___________________________________", 0, 'L');
    $pdf->SetXY(10, $rY + $aH);
}

$pdf->Ln();

// References
$pdf->Label(' 41. REFERENCES (Person not related by consanguinity or affinity to applicant /appointee)', 195, 5, 1, 'L');
$pdf->Ln();
$pdf->Label('NAME', 80, 5, 1, 'C');
$pdf->Label('ADDRESS', 80, 5, 1, 'C');
$pdf->Label('TEL. NO.', 35, 5, 1, 'C');
$pdf->Ln();
for ($i = 0; $i < 3; $i++) {
    $pdf->Value('', 80, 7);
    $pdf->Value('', 80, 7);
    $pdf->Value('', 35, 7);
    $pdf->Ln();
}

$pdf->Ln(2);

// Gov ID box under references
$y = $pdf->GetY();
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell(195, 5, '42. DECLARATION', 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 8);
$txt = "I declare under oath that I have personally accomplished this Personal Data Sheet which is a true, correct and complete statement pursuant to the provisions of pertinent laws, rules and regulations of the Republic of the Philippines. I authorize the agency head/authorized representative to verify/validate the contents stated herein.";
$pdf->MultiCell(195, 5, $txt, 1, 'J');

$y2 = $pdf->GetY();
// Right Side box ID pic
$pdf->SetXY(155, $y2 + 5);
$pdf->Cell(45, 45, '', 1, 0, 'C');
$pdf->SetXY(155, $y2 + 10);
$pdf->SetFont('Arial', '', 7);
$pdf->MultiCell(45, 4, "ID picture taken within\nthe last  6 months\n3.5 cm. X 4.5 cm\n(passport size)", 0, 'C');

$pdf->SetXY(10, $y2 + 5);
// Government Issued ID
$pdf->Cell(70, 30, '', 1, 0);
$pdf->SetXY(10, $y2 + 5);
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(70, 5, 'Government Issued ID (i.e.Passport, GSIS, SSS, PRC, Driver\'s License, etc.)', 0, 1, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(70, 5, 'PLEASE INDICATE ID Number and Date of Issuance', 0, 1, 'C');
$pdf->Cell(70, 5, 'Government Issued ID: _________________________________', 0, 1, 'L');
$pdf->Cell(70, 5, 'ID/License/Passport No.: _______________________________', 0, 1, 'L');
$pdf->Cell(70, 5, 'Date/Place of Issuance: ________________________________', 0, 1, 'L');

$pdf->SetXY(85, $y2 + 5);
// Right Thumbmark
$pdf->Cell(55, 30, '', 1, 0);
$pdf->SetXY(85, $y2 + 10);
$pdf->Cell(55, 20, 'Right Thumbmark', 0, 0, 'C');

$pdf->SetXY(100, $y2 + 55);
$pdf->Cell(80, 10, 'Signature', 'T', 1, 'C');

$pdf->SetXY(20, $y2 + 55);
$pdf->Cell(60, 10, 'Date Accomplished', 'T', 1, 'C');