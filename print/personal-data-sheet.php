<?php
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

// ─────────────────────────────────────────────────────────────────────────────
// Helper: return "N/A" when value is empty/null/whitespace
// ─────────────────────────────────────────────────────────────────────────────
function naIfEmpty($value): string
{
    $v = trim((string) ($value ?? ''));
    return ($v === '' || strtoupper($v) === 'N/A') ? 'N/A' : strtoupper($v);
}

// Returns value as uppercase; if empty → 'N/A'
function uc_na($value): string
{
    return naIfEmpty($value);
}

// ─────────────────────────────────────────────────────────────────────────────
// PDS PDF class
// ─────────────────────────────────────────────────────────────────────────────
class PDS extends FPDF
{
    // ── Header ────────────────────────────────────────────────────────────────
    public function Header()
    {
        if ($this->PageNo() == 1) {
            $this->SetFont('Arial', 'BI', 8);
            $this->Cell(0, 4, 'CS Form No. 212', 0, 1, 'L');

            $this->SetFont('Arial', 'I', 7);
            $this->Cell(0, 3.5, 'Revised 2025', 0, 1, 'L');

            $this->SetFont('Arial', 'B', 16);
            $this->Cell(0, 6, 'PERSONAL DATA SHEET', 0, 1, 'C');
            $this->Ln(2);

            $this->SetFont('Arial', 'BI', 7);
            $this->MultiCell(0, 3.5, "WARNING: Any misrepresentation made in the Personal Data Sheet and the Work Experience Sheet shall cause the filing of administrative/criminal case/s against the person concerned.", 0, 'L');
            $this->Cell(0, 3.5, 'READ THE ATTACHED GUIDE TO FILLING OUT THE PERSONAL DATA SHEET (PDS) BEFORE ACCOMPLISHING THE PDS FORM.', 0, 1, 'L');

            $this->SetFont('Arial', '', 6.5);
            $this->Cell(0, 4, 'Print legibly. Tick appropriate boxes ( [  ] ) and use separate sheet if necessary. Indicate N/A if not applicable. DO NOT ABBREVIATE.', 0, 1, 'L');
            $this->Ln(1);
        }

        if ($this->PageNo() == 2) {
            $this->SetFont('Arial', 'BI', 8);
            $this->Cell(0, 4, 'CS Form No. 212', 0, 1, 'L');
            $this->SetFont('Arial', 'I', 7);
            $this->Cell(0, 3.5, 'Revised 2025', 0, 1, 'L');
            $this->Ln(1);
        }

        if ($this->PageNo() == 3) {
            $this->SetFont('Arial', 'BI', 8);
            $this->Cell(0, 4, 'CS Form No. 212', 0, 1, 'L');
            $this->SetFont('Arial', 'I', 7);
            $this->Cell(0, 3.5, 'Revised 2025', 0, 1, 'L');
            $this->Ln(1);
        }

        if ($this->PageNo() == 4) {
            $this->SetFont('Arial', 'BI', 8);
            $this->Cell(0, 4, 'CS Form No. 212', 0, 1, 'L');
            $this->SetFont('Arial', 'I', 7);
            $this->Cell(0, 3.5, 'Revised 2025', 0, 1, 'L');
            $this->Ln(1);
        }
    }

    // ── Footer ────────────────────────────────────────────────────────────────
    public function Footer()
    {
        $this->SetY(-10);
        $this->SetFont('Arial', 'I', 7);
        $this->Cell(0, 5, 'CS FORM 212 (Revised 2025), Page ' . $this->PageNo() . ' of 4', 0, 0, 'R');
    }

    // ── Section Title (grey band) ─────────────────────────────────────────────
    public function SectionTitle($text, $w = null, $h = 5)
    {
        if ($w === null)
            $w = $this->GetPageWidth() - ($this->lMargin + $this->rMargin);
        $this->SetFont('Arial', 'BI', 8);
        $this->SetFillColor(150, 150, 150);
        $this->SetTextColor(255, 255, 255);
        $this->Cell($w, $h, '  ' . $text, 0, 1, 'L', true);
        $this->SetTextColor(0, 0, 0);
        $this->SetFillColor(255, 255, 255);
    }

    // ── Label cell (light grey fill) ─────────────────────────────────────────
    public function Label($text, $w, $h = 5.5, $border = 0, $align = 'L', $fill = true, $multiline = false, $fontSize = 6, $style = '')
    {
        $this->SetFont('Arial', $style, $fontSize);
        if ($fill) {
            $this->SetFillColor(234, 234, 234);
        } else {
            $this->SetFillColor(255, 255, 255);
        }

        if ($multiline) {
            $this->MultiCell($w, $h, $text, $border, $align, $fill);
        } else {
            // truncate if too wide
            if ($this->GetStringWidth($text) > $w) {
                while ($this->GetStringWidth($text . '...') > $w && strlen($text) > 0) {
                    $text = substr($text, 0, -1);
                }
                $text .= '...';
            }
            $this->Cell($w, $h, $text, $border, 0, $align, $fill);
        }
        $this->SetFillColor(255, 255, 255);
    }

    // ── Value cell (white fill, bordered) ─────────────────────────────────────
    public function Value($text, $w, $h = 5.5, $border = 1, $align = 'L', $multiline = false)
    {
        $this->SetFont('Arial', '', 8);

        if ($multiline) {
            $this->MultiCell($w, $h, $text, $border, $align);
        } else {
            if ($this->GetStringWidth($text) > $w - 1) {
                while ($this->GetStringWidth($text . '...') > $w - 1 && strlen($text) > 0) {
                    $text = substr($text, 0, -1);
                }
                $text .= '...';
            }
            $this->Cell($w, $h, $text, $border, 0, $align);
        }
    }

    // ── Tick box ─────────────────────────────────────────────────────────────
    public function Tick($checked, $label, $tickW = 4, $labelW = 14, $h = 5.5)
    {
        $this->SetFont('Arial', '', 7.5);
        $this->SetFillColor(255, 255, 255);
        $mark = $checked ? 'X' : ' ';
        $this->Cell($tickW, $h, "[{$mark}]", 0, 0, 'C');
        $this->SetFont('Arial', '', 7);
        $this->Cell($labelW, $h, $label, 0, 0, 'L');
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// Initialise PDF
// ─────────────────────────────────────────────────────────────────────────────
$pdf = new PDS('P', 'mm', [$width, $height]);
$pdf->SetTitle($title);
$pdf->SetAutoPageBreak(false, 5);
$pdf->SetMargins($margin, $margin, $margin);
$pdf->SetDisplayMode('real');

// Pre-fetch all data
$f = family($employeeId);
$eduList = educationalBackgrounds($employeeId);
$eligList = eligibilities($employeeId);
$expList = experiences($employeeId);
$volList = voluntaryWorks($employeeId);
$ldList = attendedTrainings($employeeId);
$skillList = specialSkills($employeeId);
$recogList = recognitions($employeeId);
$memberList = memberships($employeeId);
$refList = references($employeeId);
$otherInfo = otherInformation($employeeId);
$childList = children($employeeId);

// Column totals
$usableW = $width - ($margin * 2); // 205.9 mm

// ─────────────────────────────────────────────────────────────────────────────
//  PAGE 1
// ─────────────────────────────────────────────────────────────────────────────
$pdf->AddPage();
// Borders drawn at end of page

// ── I. PERSONAL INFORMATION ──────────────────────────────────────────────────
$pdf->SectionTitle('I. PERSONAL INFORMATION', $usableW, 5);

$rowH = 6;   // standard row height
$lW = 38;  // label column width (left panel)
$dataW = $usableW - $lW; // right panel total

// Row: SURNAME
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($lW, $rowH, '  1. SURNAME', 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($dataW, $rowH, strtoupper($e['last_name'] ?? ''), 1, 1, 'L');

// Row: FIRST NAME
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($lW, $rowH, '  2. FIRST NAME', 1, 0, 'L', true);
$nameExtW = 52;
$firstW = $dataW - $nameExtW;
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($firstW, $rowH, strtoupper($e['first_name'] ?? ''), 1, 0, 'L');
// NAME EXTENSION sub-label + value
$extLW = 36;
$extVW = $nameExtW - $extLW;
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($extLW, $rowH, 'NAME EXTENSION (JR., SR)', 1, 0, 'C', true);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($extVW, $rowH, uc_na($e['name_extension']), 1, 1, 'C');

// Row: MIDDLE NAME
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($lW, $rowH, '     MIDDLE NAME', 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($dataW, $rowH, strtoupper($e['middle_name'] ?? ''), 1, 1, 'L');

// ── Split into 2 columns from here ──────────────────────────────────────────
// Left panel width (items 3–15 plus right side items 16–21)
$leftW = 85;  // left column (personal details)
$rightW = $usableW - $leftW; // right column (citizenship + addresses + contact)

$yAfterNames = $pdf->GetY();

// ── LEFT COLUMN: items 3-15 ───────────────────────────────────────────────
$pdf->SetXY($margin, $yAfterNames);

// Item 3: DATE OF BIRTH  (2-row block height = 12)
$dob3H = 12;
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($lW, $dob3H, '', 1, 0, 'L', true); // border-only label box
$xAfterLabel3 = $pdf->GetX();
$yLabel3 = $pdf->GetY();
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($leftW - $lW, $dob3H, toDate($e['birthdate'], 'd/m/Y'), 1, 1, 'C');
// Overlay label text
$pdf->SetXY($margin, $yLabel3);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->MultiCell($lW, 3, " 3. DATE OF BIRTH\n    (dd/mm/yyyy)", 0, 'L', true);

// Item 4: PLACE OF BIRTH
$pdf->SetXY($margin, $yAfterNames + $dob3H);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($lW, $rowH, '  4. PLACE OF BIRTH', 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($leftW - $lW, $rowH, uc_na($e['place_of_birth']), 1, 1, 'C');

// Item 5: SEX AT BIRTH
$pdf->SetXY($margin, $yAfterNames + $dob3H + $rowH);
$sexH = $rowH;
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($lW, $sexH, '  5. SEX AT BIRTH', 1, 0, 'L', true);
$sexVal = strtolower($e['sex'] ?? '');
$xSex = $pdf->GetX();
$ySex = $pdf->GetY();
$pdf->SetFont('Arial', '', 7);
$pdf->Tick($sexVal === 'male', 'Male', 4, 16, $sexH);
$pdf->Tick($sexVal === 'female', 'Female', 4, 16, $sexH);
$pdf->Ln();

// Item 6: CIVIL STATUS (3-row block = 18)
$civilH = 18;
$pdf->SetXY($margin, $yAfterNames + $dob3H + $rowH + $sexH);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($lW, $civilH, '', 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 6);
$xCivil = $pdf->GetX();
$yCivil = $pdf->GetY();
$cs = strtolower($e['civil_status'] ?? '');
// Tick boxes stacked
$pdf->SetXY($xCivil, $yCivil);
$pdf->Tick($cs === 'single', 'Single', 4, 18, 5.5);
$pdf->Tick($cs === 'married', 'Married', 4, 18, 5.5);
$pdf->Ln();
$pdf->SetXY($xCivil, $yCivil + 6);
$pdf->Tick($cs === 'widowed', 'Widowed', 4, 18, 5.5);
$pdf->Tick($cs === 'separated', 'Separated', 4, 16, 5.5);
$pdf->Ln();
$pdf->SetXY($xCivil, $yCivil + 12);
$pdf->Tick($cs === 'others', 'Others: ', 4, 12, 5.5);
$pdf->SetFont('Arial', '', 7);
$otherCS = uc_na($e['specify_other_civil_status'] ?? '');
$pdf->Cell($leftW - $lW - 16, 5.5, ($cs === 'others' ? $otherCS : ''), 0, 1, 'L');
// Civil status label overlay
$pdf->SetXY($margin, $yAfterNames + $dob3H + $rowH + $sexH);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->MultiCell($lW, 4.5, " 6. CIVIL STATUS", 0, 'L', true);

// Items 7-15: single-row fields (height = rowH each)
$singleItems = [
    ['  7. HEIGHT (m)', 'height'],
    ['  8. WEIGHT (kg)', 'weight'],
    ['  9. BLOOD TYPE', 'blood_type'],
    [' 10. UMID ID NO.', 'umid_id'],
    [' 11. PAG-IBIG ID NO.', 'pagibig'],
    [' 12. PHILHEALTH NO.', 'philhealth'],
    [' 13. PhilSys Number (PSN):', 'philsys'],
    [' 14. TIN NO.', 'tin'],
    [' 15. AGENCY EMPLOYEE NO.', 'agency_id'],
];
$yItems = $yAfterNames + $dob3H + $rowH + $sexH + $civilH;
foreach ($singleItems as $item) {
    $pdf->SetXY($margin, $yItems);
    $pdf->SetFont('Arial', '', 6);
    $pdf->SetFillColor(234, 234, 234);
    $pdf->Cell($lW, $rowH, $item[0], 1, 0, 'L', true);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell($leftW - $lW, $rowH, uc_na($e[$item[1]] ?? ''), 1, 1, 'C');
    $yItems += $rowH;
}

// ── RIGHT COLUMN: items 16-21 ────────────────────────────────────────────────
$xRight = $margin + $leftW;

// Item 16: CITIZENSHIP (block height = 24)
$citizenH = 24;
$pdf->SetXY($xRight, $yAfterNames);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($rightW, $citizenH, '', 1, 0, 'L', true);
// Label
$pdf->SetXY($xRight, $yAfterNames);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->MultiCell($rightW, 3.5, " 16. CITIZENSHIP", 0, 'L', true);
// Tick Filipino
$citizenName = strtolower(citizenship($e['citizenship_id'])['name'] ?? '');
$pdf->SetXY($xRight + 1, $yAfterNames + 4);
$pdf->Tick($citizenName === 'filipino', 'Filipino', 4, 18, 5);
// Tick Dual
$dualType = strtolower($e['dual_citizenship_type'] ?? 'n/a');
$isDual = ($dualType !== '' && $dualType !== 'n/a');
$pdf->SetXY($xRight + 30, $yAfterNames + 4);
$pdf->Tick($isDual, 'Dual Citizenship', 4, 30, 5);
// Sub-ticks for dual citizenship
$pdf->SetXY($xRight + 3, $yAfterNames + 10);
$pdf->Tick($isDual && $dualType === 'by birth', 'by birth', 4, 20, 4.5);
$pdf->SetXY($xRight + 30, $yAfterNames + 10);
$pdf->Tick($isDual && $dualType === 'by naturalization', 'by naturalization', 4, 35, 4.5);
// Country label & value
$pdf->SetXY($xRight + 1, $yAfterNames + 15.5);
$pdf->SetFont('Arial', '', 6);
$pdf->Cell($rightW - 2, 3.5, 'If dual citizen, indicate country:', 0, 1, 'L');
$pdf->SetXY($xRight + 1, $yAfterNames + 19.5);
$dualCountryId = $e['dual_citizenship_country_id'];
$dualCountry = ($dualCountryId !== null && ($c = country($dualCountryId))) ? strtoupper($c['name']) : 'N/A';
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell($rightW - 2, 3.5, $dualCountry, 'B', 1, 'C');

// Items 17-18: RESIDENTIAL & PERMANENT ADDRESS (block height = 28 each)
$addrH = 28;
$addrLabelW = 30;
$addrValueW = $rightW - $addrLabelW;

// Helper to draw address block
$drawAddress = function ($label, $itemNo, $lot, $street, $subdiv, $brgy, $city, $province, $zip, $xStart, $yStart) use ($pdf, $rightW, $addrH, $addrLabelW) {
    $pdf->SetXY($xStart, $yStart);
    $pdf->SetFont('Arial', '', 6);
    $pdf->SetFillColor(234, 234, 234);
    $pdf->Cell($addrLabelW, $addrH, '', 1, 0, 'L', true);
    // Label overlay
    $pdf->SetXY($xStart, $yStart);
    $pdf->MultiCell($addrLabelW, 3.5, " {$itemNo}. {$label}", 0, 'L', true);

    $halfW = ($rightW - $addrLabelW) / 2;
    $rX = $xStart + $addrLabelW;

    // Row 1: Lot No. | Street
    $pdf->SetXY($rX, $yStart);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell($halfW, 5, strtoupper($lot ?? 'N/A'), 1, 0, 'C');
    $pdf->Cell($halfW, 5, strtoupper($street ?? 'N/A'), 1, 1, 'C');
    $pdf->SetXY($rX, $yStart + 5);
    $pdf->SetFont('Arial', '', 5.5);
    $pdf->SetFillColor(234, 234, 234);
    $pdf->Cell($halfW, 3.5, 'House/Block/Lot No.', 0, 0, 'C', true);
    $pdf->Cell($halfW, 3.5, 'Street', 0, 1, 'C', true);

    // Row 2: Subdivision | Barangay
    $pdf->SetXY($rX, $yStart + 8.5);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell($halfW, 5, strtoupper($subdiv ?? 'N/A'), 1, 0, 'C');
    $pdf->Cell($halfW, 5, strtoupper($brgy ?? 'N/A'), 1, 1, 'C');
    $pdf->SetXY($rX, $yStart + 13.5);
    $pdf->SetFont('Arial', '', 5.5);
    $pdf->SetFillColor(234, 234, 234);
    $pdf->Cell($halfW, 3.5, 'Subdivision/Village', 0, 0, 'C', true);
    $pdf->Cell($halfW, 3.5, 'Barangay', 0, 1, 'C', true);

    // Row 3: City/Municipality | Province
    $pdf->SetXY($rX, $yStart + 17);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell($halfW, 5, strtoupper($city ?? 'N/A'), 1, 0, 'C');
    $pdf->Cell($halfW, 5, strtoupper($province ?? 'N/A'), 1, 1, 'C');
    $pdf->SetXY($rX, $yStart + 22);
    $pdf->SetFont('Arial', '', 5.5);
    $pdf->SetFillColor(234, 234, 234);
    $pdf->Cell($halfW, 3.5, 'City/Municipality', 0, 0, 'C', true);
    $pdf->Cell($halfW, 3.5, 'Province', 0, 1, 'C', true);

    // Zip code row
    $zipLW = $addrLabelW;
    $pdf->SetXY($xStart, $yStart + 25.5);
    $pdf->SetFont('Arial', '', 6);
    $pdf->SetFillColor(234, 234, 234);
    $pdf->Cell($zipLW, 5.5, 'ZIP CODE', 1, 0, 'C', true);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell($rightW - $zipLW, 5.5, strtoupper($zip ?? 'N/A'), 1, 1, 'C');
};

$yResidential = $yAfterNames + $citizenH;
$drawAddress(
    'RESIDENTIAL ADDRESS',
    '17',
    $e['residence_lot'] ?? '',
    $e['residence_street'] ?? '',
    $e['residence_subdivision'] ?? '',
    $e['residence_barangay'] ?? '',
    $e['residence_city'] ?? '',
    $e['residence_province'] ?? '',
    $e['residence_zip'] ?? '',
    $xRight,
    $yResidential
);

$yPermanent = $yResidential + $addrH + 5.5; // +zip row
$drawAddress(
    'PERMANENT ADDRESS',
    '18',
    $e['permanent_lot'] ?? '',
    $e['permanent_street'] ?? '',
    $e['permanent_subdivision'] ?? '',
    $e['permanent_barangay'] ?? '',
    $e['permanent_city'] ?? '',
    $e['permanent_province'] ?? '',
    $e['permanent_zip'] ?? '',
    $xRight,
    $yPermanent
);

// Items 19-21: Telephone, Mobile, Email
$yContact = $yPermanent + $addrH + 5.5;
$contactItems = [
    [' 19. TELEPHONE NO.', 'telephone'],
    [' 20. MOBILE NO.', 'mobile_number'],
    [' 21. E-MAIL ADDRESS (if any)', 'email_address'],
];
foreach ($contactItems as $ci) {
    $pdf->SetXY($xRight, $yContact);
    $pdf->SetFont('Arial', '', 6);
    $pdf->SetFillColor(234, 234, 234);
    $pdf->Cell($addrLabelW, $rowH, $ci[0], 1, 0, 'L', true);
    $pdf->SetFont('Arial', '', 8);
    $val = ($ci[1] === 'email_address')
        ? strtolower($e[$ci[1]] ?? 'N/A')
        : uc_na($e[$ci[1]] ?? '');
    $pdf->Cell($rightW - $addrLabelW, $rowH, $val, 1, 1, 'L');
    $yContact += $rowH;
}

// ── II. FAMILY BACKGROUND ─────────────────────────────────────────────────────
$yFamily = max($yItems, $yContact);
$pdf->SetXY($margin, $yFamily);
$pdf->SectionTitle('II. FAMILY BACKGROUND', $usableW, 5);

$yFamily += 5;

// Split: left (spouse/parents) 111mm | right (children) 94.9mm
$spouseW = 111;
$childrenW = $usableW - $spouseW;
$childNameW = $childrenW - 28;
$childDobW = 28;

// Children header
$pdf->SetXY($margin + $spouseW, $yFamily);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($childNameW, 8, ' 23. NAME OF CHILDREN (Write in full)', 1, 0, 'L', true);
$pdf->SetFillColor(234, 234, 234);
$pdf->MultiCell($childDobW, 4, "DATE OF BIRTH\n(dd/mm/yyyy)", 1, 'C', true);
$pdf->SetXY($margin + $spouseW, $yFamily + 8);

// Spouse rows
$spouseLW = 38;
$spouseVW = $spouseW - $spouseLW;

$pdf->SetXY($margin, $yFamily);
// 22. SPOUSE SURNAME
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($spouseLW, $rowH, ' 22. SPOUSE\'S SURNAME', 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($spouseVW, $rowH, uc_na($f['spouse_last_name'] ?? ''), 1, 1, 'L');

// FIRST NAME
$pdf->SetXY($margin, $yFamily + $rowH);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($spouseLW, $rowH, '      FIRST NAME', 1, 0, 'L', true);
$sExtLW = 28;
$sNameW = $spouseVW - $sExtLW - 10;
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($sNameW, $rowH, uc_na($f['spouse_first_name'] ?? ''), 1, 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($sExtLW, $rowH, 'NAME EXTENSION', 1, 0, 'C', true);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10, $rowH, uc_na($f['spouse_name_extension'] ?? ''), 1, 1, 'C');

// MIDDLE NAME
$pdf->SetXY($margin, $yFamily + $rowH * 2);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($spouseLW, $rowH, '      MIDDLE NAME', 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($spouseVW, $rowH, uc_na($f['spouse_middle_name'] ?? ''), 1, 1, 'L');

// OCCUPATION
$pdf->SetXY($margin, $yFamily + $rowH * 3);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($spouseLW, $rowH, '      OCCUPATION', 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($spouseVW, $rowH, uc_na($f['spouse_occupation'] ?? ''), 1, 1, 'L');

// EMPLOYER/BUSINESS NAME
$pdf->SetXY($margin, $yFamily + $rowH * 4);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($spouseLW, $rowH, '      EMPLOYER/BUSINESS NAME', 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($spouseVW, $rowH, uc_na($f['spouse_employer'] ?? ''), 1, 1, 'L');

// BUSINESS ADDRESS
$pdf->SetXY($margin, $yFamily + $rowH * 5);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($spouseLW, $rowH, '      BUSINESS ADDRESS', 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($spouseVW, $rowH, uc_na($f['spouse_employer_address'] ?? ''), 1, 1, 'L');

// TELEPHONE NO.
$pdf->SetXY($margin, $yFamily + $rowH * 6);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($spouseLW, $rowH, '      TELEPHONE NO.', 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($spouseVW, $rowH, uc_na($f['spouse_telephone'] ?? ''), 1, 1, 'L');

// 24. FATHER'S NAME
$pdf->SetXY($margin, $yFamily + $rowH * 7);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($spouseLW, $rowH, ' 24. FATHER\'S SURNAME', 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($spouseVW, $rowH, uc_na($f['father_last_name'] ?? ''), 1, 1, 'L');

$pdf->SetXY($margin, $yFamily + $rowH * 8);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($spouseLW, $rowH, '      FIRST NAME', 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($sNameW, $rowH, uc_na($f['father_first_name'] ?? ''), 1, 0, 'L');
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($sExtLW, $rowH, 'NAME EXTENSION', 1, 0, 'C', true);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10, $rowH, uc_na($f['father_name_extension'] ?? ''), 1, 1, 'C');

$pdf->SetXY($margin, $yFamily + $rowH * 9);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($spouseLW, $rowH, '      MIDDLE NAME', 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($spouseVW, $rowH, uc_na($f['father_middle_name'] ?? ''), 1, 1, 'L');

// 25. MOTHER'S MAIDEN NAME
$pdf->SetXY($margin, $yFamily + $rowH * 10);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($spouseLW, $rowH, ' 25. MOTHER\'S MAIDEN NAME', 1, 0, 'L', true);
$pdf->Cell($spouseVW, $rowH, '', 1, 1, 'L', true);

$pdf->SetXY($margin, $yFamily + $rowH * 11);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($spouseLW, $rowH, '      SURNAME', 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($spouseVW, $rowH, uc_na($f['mother_last_name'] ?? ''), 1, 1, 'L');

$pdf->SetXY($margin, $yFamily + $rowH * 12);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($spouseLW, $rowH, '      FIRST NAME', 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($spouseVW, $rowH, uc_na($f['mother_first_name'] ?? ''), 1, 1, 'L');

$pdf->SetXY($margin, $yFamily + $rowH * 13);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($spouseLW, $rowH, '      MIDDLE NAME', 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($spouseVW, $rowH, uc_na($f['mother_middle_name'] ?? ''), 1, 1, 'L');

// Children column (12 rows shown, PDS standard = 12 rows)
$childRowH = $rowH;
$childRowMax = 12;
$yChildStart = $yFamily + 8; // after header
for ($ci = 0; $ci < $childRowMax; $ci++) {
    $c = $childList[$ci] ?? null;
    $cName = $c ? strtoupper(trim(($c['first_name'] ?? '') . ' ' . ($c['last_name'] ?? ''))) : '';
    $cDob = $c ? toDate($c['birthdate'], 'd/m/Y') : '';
    $pdf->SetXY($margin + $spouseW, $yChildStart + ($ci * $childRowH));
    $pdf->SetFont('Arial', '', 7.5);
    $pdf->Cell($childNameW, $childRowH, $cName, 1, 0, 'L');
    $pdf->Cell($childDobW, $childRowH, $cDob, 1, 1, 'C');
}

$yAfterFamily = $yFamily + ($rowH * 14);

// ── III. EDUCATIONAL BACKGROUND ───────────────────────────────────────────────
$pdf->SetXY($margin, $yAfterFamily);
$pdf->SectionTitle('III. EDUCATIONAL BACKGROUND', $usableW, 5);

$yEdu = $yAfterFamily + 5;

// Education column widths: Level | School | Course | From | To | Highest | Year Grad | Honors
$eduCols = [
    'Level' => 30,
    'School' => 48,
    'Course' => 40,
    'From' => 14,
    'To' => 14,
    'Highest' => 18,
    'YearGrad' => 16,
    'Honors' => 25.9,
];
$total = array_sum($eduCols);

// Header row (2-row height)
$pdf->SetXY($margin, $yEdu);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($eduCols['Level'], 10, " 26.\n\nLEVEL", 1, 0, 'C', true);
$pdf->MultiCell($eduCols['School'], 5, "\nNAME OF SCHOOL\n(Write in full)", 1, 'C', true);
$pdf->SetXY($margin + $eduCols['Level'] + $eduCols['School'], $yEdu);
$pdf->MultiCell($eduCols['Course'], 5, "\nBASIC EDUCATION/\nDEGREE/COURSE\n(Write in full)", 1, 'C', true);
$xPeriod = $margin + $eduCols['Level'] + $eduCols['School'] + $eduCols['Course'];
$pdf->SetXY($xPeriod, $yEdu);
$pdf->Cell($eduCols['From'] + $eduCols['To'], 5, 'PERIOD OF ATTENDANCE', 1, 0, 'C', true);
$pdf->SetXY($xPeriod, $yEdu + 5);
$pdf->Cell($eduCols['From'], 5, 'From', 1, 0, 'C', true);
$pdf->Cell($eduCols['To'], 5, 'To', 1, 0, 'C', true);
$pdf->SetXY($xPeriod + $eduCols['From'] + $eduCols['To'], $yEdu);
$pdf->MultiCell($eduCols['Highest'], 5, "HIGHEST\nLEVEL/UNITS\nEARNED\n(if not graduated)", 1, 'C', true);
$pdf->SetXY($xPeriod + $eduCols['From'] + $eduCols['To'] + $eduCols['Highest'], $yEdu);
$pdf->MultiCell($eduCols['YearGrad'], 5, "\nYEAR\nGRADUATED", 1, 'C', true);
$pdf->SetXY($xPeriod + $eduCols['From'] + $eduCols['To'] + $eduCols['Highest'] + $eduCols['YearGrad'], $yEdu);
$pdf->MultiCell($eduCols['Honors'], 5, "SCHOLARSHIP/\nACADEMIC HONORS\nRECEIVED", 1, 'C', true);

$yEduRows = $yEdu + 10;
$eduRowH = 9;
$levels = ['ELEMENTARY', 'SECONDARY', 'VOCATIONAL/TRADE COURSE', 'COLLEGE', 'GRADUATE STUDIES'];
$levelMap = [
    'ELEMENTARY' => 'Elementary',
    'SECONDARY' => 'Secondary',
    'VOCATIONAL/TRADE COURSE' => 'Vocational/Trade Course',
    'COLLEGE' => 'College',
    'GRADUATE STUDIES' => 'Graduate Studies',
];
foreach ($levels as $lvl) {
    $eduRow = null;
    foreach ($eduList as $ed) {
        if (strtoupper(trim($ed['level'])) === $lvl || strtolower(trim($ed['level'])) === strtolower($levelMap[$lvl])) {
            $eduRow = $ed;
            break;
        }
    }
    $pdf->SetXY($margin, $yEduRows);
    $pdf->SetFont('Arial', '', 6.5);
    $pdf->SetFillColor(234, 234, 234);
    $pdf->Cell($eduCols['Level'], $eduRowH, $lvl, 1, 0, 'C', true);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell($eduCols['School'], $eduRowH, $eduRow ? strtoupper($eduRow['school'] ?? 'N/A') : '', 1, 0, 'L');
    $pdf->Cell($eduCols['Course'], $eduRowH, $eduRow ? strtoupper($eduRow['course'] ?? 'N/A') : '', 1, 0, 'L');
    $pdf->Cell($eduCols['From'], $eduRowH, $eduRow ? ($eduRow['from_year'] ?? 'N/A') : '', 1, 0, 'C');
    $pdf->Cell($eduCols['To'], $eduRowH, $eduRow ? ($eduRow['is_present'] ? 'PRESENT' : ($eduRow['to_year'] ?? 'N/A')) : '', 1, 0, 'C');
    $pdf->Cell($eduCols['Highest'], $eduRowH, $eduRow ? strtoupper($eduRow['highest_level'] ?? 'N/A') : '', 1, 0, 'C');
    $pdf->Cell($eduCols['YearGrad'], $eduRowH, $eduRow ? ($eduRow['year_graduated'] ?? 'N/A') : '', 1, 0, 'C');
    $pdf->Cell($eduCols['Honors'], $eduRowH, $eduRow ? strtoupper($eduRow['honors_received'] ?? 'N/A') : '', 1, 1, 'C');
    $yEduRows += $eduRowH;
}

// Continue notice
$pdf->SetXY($margin, $yEduRows);
$pdf->SetFont('Arial', 'I', 7);
$pdf->SetFillColor(234, 234, 234);
$pdf->SetTextColor(255, 0, 0);
$pdf->Cell($usableW, 4, '(Continue on separate sheet if necessary)', 1, 1, 'C', true);
$pdf->SetTextColor(0, 0, 0);

$yBottom = $yEduRows + 4;

// ── Signature block at bottom of page 1 ──────────────────────────────────────
$ySignature = $height - $margin - 20;
$pdf->SetXY($margin, $ySignature);
$pdf->SetFont('Arial', 'BI', 9);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell(100, 7, 'SIGNATURE', 1, 0, 'C', true);

$pdf->SetXY($margin + 120, $ySignature);
$pdf->Cell(40, 7, 'DATE', 1, 0, 'C', true);

$pdf->SetXY($margin, $ySignature + 7);
$pdf->SetFont('Arial', 'I', 6.5);
$pdf->SetTextColor(255, 0, 0);
$pdf->Cell(100, 5, '(wet signature/e-signature/digital certificate)', 0, 0, 'C');
$pdf->SetTextColor(0, 0, 0);

// Page 1 outer border
$pdf->SetLineWidth(0.4);
$pdf->Rect($margin, $margin, $usableW, $height - $margin * 2 - 5);

// ─────────────────────────────────────────────────────────────────────────────
//  PAGE 2
// ─────────────────────────────────────────────────────────────────────────────
$pdf->AddPage();
$pdf->SetAutoPageBreak(false, 5);

$y2 = $pdf->GetY();

// ── IV. CIVIL SERVICE ELIGIBILITY ────────────────────────────────────────────
$pdf->SectionTitle('IV. CIVIL SERVICE ELIGIBILITY', $usableW, 5);

// Column widths (total = usableW)
$eligCols = [
    'Career' => 65,
    'Rating' => 15,
    'Date' => 20,
    'Place' => 55,
    'LicNo' => 26,
    'LicVal' => 24.9,
];

$yElig = $y2 + 5;
$pdf->SetXY($margin, $yElig);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($eligCols['Career'], 10, " 27. CAREER SERVICE/RA 1080 (BOARD/BAR) UNDER\n SPECIAL LAWS/CES/CSEE", 1, 0, 'L', true);
$pdf->Cell($eligCols['Rating'], 10, "RATING\n(if applicable)", 1, 0, 'C', true);
$pdf->Cell($eligCols['Date'], 10, "DATE OF\nEXAM/\nCONFERMENT", 1, 0, 'C', true);
$pdf->Cell($eligCols['Place'], 10, "PLACE OF EXAMINATION/\nCONFERMENT", 1, 0, 'C', true);

$licTotal = $eligCols['LicNo'] + $eligCols['LicVal'];
$pdf->Cell($licTotal, 5, 'LICENSE (if applicable)', 1, 1, 'C', true);
$pdf->SetXY($margin + $eligCols['Career'] + $eligCols['Rating'] + $eligCols['Date'] + $eligCols['Place'], $yElig + 5);
$pdf->Cell($eligCols['LicNo'], 5, 'NUMBER', 1, 0, 'C', true);
$pdf->Cell($eligCols['LicVal'], 5, 'Date of Validity', 1, 1, 'C', true);

$eligRowH = 6;
$eligMax = 8; // PDS standard: 8 rows
$yEligRows = $yElig + 10;
for ($ei = 0; $ei < $eligMax; $ei++) {
    $elig = $eligList[$ei] ?? null;
    $pdf->SetXY($margin, $yEligRows);
    $pdf->SetFont('Arial', '', 7.5);
    $pdf->Cell($eligCols['Career'], $eligRowH, $elig ? strtoupper($elig['title'] ?? 'N/A') : '', 1, 0, 'L');
    $pdf->Cell($eligCols['Rating'], $eligRowH, $elig ? ($elig['rating'] ?? 'N/A') : '', 1, 0, 'C');
    $pdf->Cell($eligCols['Date'], $eligRowH, $elig ? toDate($elig['examination_date'], 'd/m/Y') : '', 1, 0, 'C');
    $pdf->Cell($eligCols['Place'], $eligRowH, $elig ? strtoupper($elig['examination_venue'] ?? 'N/A') : '', 1, 0, 'L');
    $pdf->Cell($eligCols['LicNo'], $eligRowH, $elig ? strtoupper($elig['license_number'] ?? 'N/A') : '', 1, 0, 'C');
    $expiry = '';
    if ($elig) {
        $expiry = $elig['has_expiration'] ? toDate($elig['expiration_date'], 'd/m/Y') : 'N/A';
    }
    $pdf->Cell($eligCols['LicVal'], $eligRowH, $expiry, 1, 1, 'C');
    $yEligRows += $eligRowH;
}

$pdf->SetXY($margin, $yEligRows);
$pdf->SetFont('Arial', 'I', 7);
$pdf->SetFillColor(234, 234, 234);
$pdf->SetTextColor(255, 0, 0);
$pdf->Cell($usableW, 4, '(Continue on separate sheet if necessary)', 1, 1, 'C', true);
$pdf->SetTextColor(0, 0, 0);

// ── V. WORK EXPERIENCE ────────────────────────────────────────────────────────
$yWE = $yEligRows + 4;
$pdf->SetXY($margin, $yWE);
$pdf->SectionTitle('V. WORK EXPERIENCE', $usableW, 5);
$yWE += 5;
$pdf->SetXY($margin, $yWE);
$pdf->SetFont('Arial', 'I', 6.5);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($usableW, 4, ' (Include private employment. Start from your recent work) Description of duties should be indicated in the attached Work Experience sheet.', 1, 1, 'L', true);
$yWE += 4;

$expCols = [
    'From' => 15,
    'To' => 15,
    'Position' => 42,
    'Agency' => 47,
    'Salary' => 14,
    'Grade' => 18,
    'Status' => 20,
    'GovSvc' => 14.9,
];
$pdf->SetXY($margin, $yWE);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($expCols['From'] + $expCols['To'], 5, ' 28. INCLUSIVE DATES', 1, 0, 'C', true);
$pdf->Cell($expCols['Position'], 10, "POSITION TITLE\n(Write in full/\nDo not abbreviate)", 1, 0, 'C', true);
$pdf->Cell($expCols['Agency'], 10, "DEPARTMENT/AGENCY/\nOFFICE/COMPANY\n(Write in full/Do not\nabbreviate)", 1, 0, 'C', true);
$pdf->Cell($expCols['Salary'], 10, "MONTHLY\nSALARY", 1, 0, 'C', true);
$pdf->Cell($expCols['Grade'], 10, "SALARY/JOB/\nPAY GRADE &\nSTEP INCREMENT\n(Format \"00-0\")", 1, 0, 'C', true);
$pdf->Cell($expCols['Status'], 10, "STATUS OF\nAPPOINTMENT", 1, 0, 'C', true);
$pdf->Cell($expCols['GovSvc'], 10, "GOV'T\nSERVICE\n(Y/N)", 1, 1, 'C', true);
$pdf->SetXY($margin, $yWE + 5);
$pdf->Cell($expCols['From'], 5, 'From', 1, 0, 'C', true);
$pdf->Cell($expCols['To'], 5, 'To', 1, 1, 'C', true);

$expRowH = 6;
$expMax = 28; // standard row count
$yExpRows = $yWE + 10;
for ($xi = 0; $xi < $expMax; $xi++) {
    $exp = $expList[$xi] ?? null;
    $pdf->SetXY($margin, $yExpRows);
    $pdf->SetFont('Arial', '', 7);
    $from = $exp ? toDate($exp['from_date'], 'd/m/Y') : '';
    $to = $exp ? ($exp['is_present'] ? 'PRESENT' : toDate($exp['to_date'], 'd/m/Y')) : '';
    $pdf->Cell($expCols['From'], $expRowH, $from, 1, 0, 'C');
    $pdf->Cell($expCols['To'], $expRowH, $to, 1, 0, 'C');
    $pdf->Cell($expCols['Position'], $expRowH, $exp ? strtoupper($exp['designation'] ?? 'N/A') : '', 1, 0, 'L');
    $pdf->Cell($expCols['Agency'], $expRowH, $exp ? strtoupper($exp['agency_company'] ?? 'N/A') : '', 1, 0, 'L');
    $pdf->Cell($expCols['Salary'], $expRowH, $exp ? number_format((float) ($exp['monthly_salary'] ?? 0), 2) : '', 1, 0, 'C');
    $pdf->Cell($expCols['Grade'], $expRowH, $exp ? strtoupper($exp['salary_grade_step_increment'] ?? 'N/A') : '', 1, 0, 'C');
    $pdf->Cell($expCols['Status'], $expRowH, $exp ? strtoupper($exp['appointment_status'] ?? 'N/A') : '', 1, 0, 'C');
    $govSvc = '';
    if ($exp) {
        $govSvc = ($exp['is_government_service'] == 1) ? 'Y' : 'N';
    }
    $pdf->Cell($expCols['GovSvc'], $expRowH, $govSvc, 1, 1, 'C');
    $yExpRows += $expRowH;
}

$pdf->SetXY($margin, $yExpRows);
$pdf->SetFont('Arial', 'I', 7);
$pdf->SetFillColor(234, 234, 234);
$pdf->SetTextColor(255, 0, 0);
$pdf->Cell($usableW, 4, '(Continue on separate sheet if necessary)', 1, 1, 'C', true);
$pdf->SetTextColor(0, 0, 0);

// ── Signature block page 2 ────────────────────────────────────────────────────
$ySign2 = $height - $margin - 20;
$pdf->SetXY($margin, $ySign2);
$pdf->SetFont('Arial', 'BI', 9);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell(100, 7, 'SIGNATURE', 1, 0, 'C', true);
$pdf->SetXY($margin + 120, $ySign2);
$pdf->Cell(40, 7, 'DATE', 1, 0, 'C', true);
$pdf->SetXY($margin, $ySign2 + 7);
$pdf->SetFont('Arial', 'I', 6.5);
$pdf->SetTextColor(255, 0, 0);
$pdf->Cell(100, 5, '(wet signature/e-signature/digital certificate)', 0, 0, 'C');
$pdf->SetTextColor(0, 0, 0);

$pdf->SetLineWidth(0.4);
$pdf->Rect($margin, $margin, $usableW, $height - $margin * 2 - 5);

// ─────────────────────────────────────────────────────────────────────────────
//  PAGE 3
// ─────────────────────────────────────────────────────────────────────────────
$pdf->AddPage();
$y3 = $pdf->GetY();

// ── VI. VOLUNTARY WORK ────────────────────────────────────────────────────────
$pdf->SectionTitle('VI. VOLUNTARY WORK OR INVOLVEMENT IN CIVIC/NON-GOVERNMENT/PEOPLE/VOLUNTARY ORGANIZATION/S', $usableW, 5);

$yVol = $y3 + 5;
$volCols = [
    'Org' => 80,
    'From' => 15,
    'To' => 15,
    'Hours' => 20,
    'Nature' => 75.9,
];
$pdf->SetXY($margin, $yVol);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($volCols['Org'], 10, " 29. NAME & ADDRESS OF ORGANIZATION\n (Write in full)", 1, 0, 'L', true);
$pdf->Cell($volCols['From'] + $volCols['To'], 5, 'INCLUSIVE DATES', 1, 0, 'C', true);
$pdf->Cell($volCols['Hours'], 10, "NUMBER\nOF HOURS", 1, 0, 'C', true);
$pdf->Cell($volCols['Nature'], 10, "POSITION/NATURE OF WORK", 1, 1, 'C', true);
$pdf->SetXY($margin + $volCols['Org'], $yVol + 5);
$pdf->Cell($volCols['From'], 5, 'From', 1, 0, 'C', true);
$pdf->Cell($volCols['To'], 5, 'To', 1, 1, 'C', true);

$volRowH = 6;
$volMax = 7; // standard = 7 rows
$yVolRows = $yVol + 10;
for ($vi = 0; $vi < $volMax; $vi++) {
    $vol = $volList[$vi] ?? null;
    $pdf->SetXY($margin, $yVolRows);
    $pdf->SetFont('Arial', '', 7.5);
    $pdf->Cell($volCols['Org'], $volRowH, $vol ? strtoupper($vol['organization'] ?? 'N/A') : '', 1, 0, 'L');
    $pdf->Cell($volCols['From'], $volRowH, $vol ? toDate($vol['from_date'], 'd/m/Y') : '', 1, 0, 'C');
    $pdf->Cell($volCols['To'], $volRowH, $vol ? ($vol['is_present'] ? 'PRESENT' : toDate($vol['to_date'], 'd/m/Y')) : '', 1, 0, 'C');
    $pdf->Cell($volCols['Hours'], $volRowH, $vol ? ($vol['number_of_hours'] ?? 'N/A') : '', 1, 0, 'C');
    $pdf->Cell($volCols['Nature'], $volRowH, $vol ? strtoupper($vol['position_nature_of_work'] ?? 'N/A') : '', 1, 1, 'L');
    $yVolRows += $volRowH;
}

$pdf->SetXY($margin, $yVolRows);
$pdf->SetFont('Arial', 'I', 7);
$pdf->SetFillColor(234, 234, 234);
$pdf->SetTextColor(255, 0, 0);
$pdf->Cell($usableW, 4, '(Continue on separate sheet if necessary)', 1, 1, 'C', true);
$pdf->SetTextColor(0, 0, 0);

// ── VII. LEARNING AND DEVELOPMENT ─────────────────────────────────────────────
$yLD = $yVolRows + 4;
$pdf->SetXY($margin, $yLD);
$pdf->SectionTitle('VII. LEARNING AND DEVELOPMENT (L&D) INTERVENTIONS/TRAINING PROGRAMS ATTENDED', $usableW, 5);
$yLD += 5;
$pdf->SetXY($margin, $yLD);
$pdf->SetFont('Arial', 'I', 6.5);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($usableW, 4, ' (Start from the most recent L&D/training program and include only the relevant L&D/training taken for the last five (5) years for Division Chief/Executive/Managerial positions)', 1, 1, 'L', true);
$yLD += 4;

$ldCols = [
    'Title' => 80,
    'From' => 15,
    'To' => 15,
    'Hours' => 15,
    'Type' => 15,
    'Conducted' => 65.9,
];
$pdf->SetXY($margin, $yLD);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($ldCols['Title'], 10, " 30. TITLE OF LEARNING AND DEVELOPMENT\n (L&D) INTERVENTIONS/TRAINING PROGRAMS\n (Write in full)", 1, 0, 'L', true);
$pdf->Cell($ldCols['From'] + $ldCols['To'], 5, 'INCLUSIVE DATES', 1, 0, 'C', true);
$pdf->Cell($ldCols['Hours'], 10, "NUMBER\nOF HOURS", 1, 0, 'C', true);
$pdf->Cell($ldCols['Type'], 10, "TYPE OF\nLD\n(Managerial/\nSupervisory/\nTechnical/etc)", 1, 0, 'C', true);
$pdf->Cell($ldCols['Conducted'], 10, "CONDUCTED/SPONSORED BY\n(Write in full)", 1, 1, 'C', true);
$pdf->SetXY($margin + $ldCols['Title'], $yLD + 5);
$pdf->Cell($ldCols['From'], 5, 'From', 1, 0, 'C', true);
$pdf->Cell($ldCols['To'], 5, 'To', 1, 1, 'C', true);

$ldRowH = 5.5;
$ldMax = 18; // standard = 18 rows (PDS 2025)
$yLDRows = $yLD + 10;
for ($li = 0; $li < $ldMax; $li++) {
    $ld = $ldList[$li] ?? null;
    $pdf->SetXY($margin, $yLDRows);
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell($ldCols['Title'], $ldRowH, $ld ? strtoupper($ld['title'] ?? 'N/A') : '', 1, 0, 'L');
    $pdf->Cell($ldCols['From'], $ldRowH, $ld ? toDate($ld['start_date'], 'd/m/Y') : '', 1, 0, 'C');
    $pdf->Cell($ldCols['To'], $ldRowH, $ld ? toDate($ld['end_date'], 'd/m/Y') : '', 1, 0, 'C');
    $pdf->Cell($ldCols['Hours'], $ldRowH, $ld ? ($ld['number_of_hours'] ?? 'N/A') : '', 1, 0, 'C');
    $pdf->Cell($ldCols['Type'], $ldRowH, $ld ? strtoupper($ld['training_type'] ?? 'N/A') : '', 1, 0, 'C');
    $pdf->Cell($ldCols['Conducted'], $ldRowH, $ld ? strtoupper($ld['sponsored_by'] ?? 'N/A') : '', 1, 1, 'L');
    $yLDRows += $ldRowH;
}

$pdf->SetXY($margin, $yLDRows);
$pdf->SetFont('Arial', 'I', 7);
$pdf->SetFillColor(234, 234, 234);
$pdf->SetTextColor(255, 0, 0);
$pdf->Cell($usableW, 4, '(Continue on separate sheet if necessary)', 1, 1, 'C', true);
$pdf->SetTextColor(0, 0, 0);

// ── VIII. OTHER INFORMATION ───────────────────────────────────────────────────
$yOI = $yLDRows + 4;
$pdf->SetXY($margin, $yOI);
$pdf->SectionTitle('VIII. OTHER INFORMATION', $usableW, 5);
$yOI += 5;

$oiSkillW = 55;
$oiRecogW = 76;
$oiMemberW = $usableW - $oiSkillW - $oiRecogW;

$pdf->SetXY($margin, $yOI);
$pdf->SetFont('Arial', '', 6);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($oiSkillW, 5, ' 31. SPECIAL SKILLS AND HOBBIES', 1, 0, 'L', true);
$pdf->Cell($oiRecogW, 5, ' 32. NON-ACADEMIC DISTINCTIONS / RECOGNITION', 1, 0, 'L', true);
$pdf->Cell($oiMemberW, 5, ' 33. MEMBERSHIP IN ASSOCIATION/ORGANIZATION', 1, 1, 'L', true);

$oiRowH = 5.5;
$oiMax = 7; // standard = 7 rows
$yOIRows = $yOI + 5;
for ($oi = 0; $oi < $oiMax; $oi++) {
    $skill = $skillList[$oi] ?? null;
    $recog = $recogList[$oi] ?? null;
    $member = $memberList[$oi] ?? null;
    $pdf->SetXY($margin, $yOIRows);
    $pdf->SetFont('Arial', '', 7.5);
    $pdf->Cell($oiSkillW, $oiRowH, $skill ? strtoupper($skill['name'] ?? '') : '', 1, 0, 'L');
    $pdf->Cell($oiRecogW, $oiRowH, $recog ? strtoupper($recog['title'] ?? '') : '', 1, 0, 'L');
    $pdf->Cell($oiMemberW, $oiRowH, $member ? strtoupper($member['organization'] ?? '') : '', 1, 1, 'L');
    $yOIRows += $oiRowH;
}

$pdf->SetXY($margin, $yOIRows);
$pdf->SetFont('Arial', 'I', 7);
$pdf->SetFillColor(234, 234, 234);
$pdf->SetTextColor(255, 0, 0);
$pdf->Cell($usableW, 4, '(Continue on separate sheet if necessary)', 1, 1, 'C', true);
$pdf->SetTextColor(0, 0, 0);

// ── Signature block page 3 ────────────────────────────────────────────────────
$ySign3 = $height - $margin - 20;
$pdf->SetXY($margin, $ySign3);
$pdf->SetFont('Arial', 'BI', 9);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell(100, 7, 'SIGNATURE', 1, 0, 'C', true);
$pdf->SetXY($margin + 120, $ySign3);
$pdf->Cell(40, 7, 'DATE', 1, 0, 'C', true);
$pdf->SetXY($margin, $ySign3 + 7);
$pdf->SetFont('Arial', 'I', 6.5);
$pdf->SetTextColor(255, 0, 0);
$pdf->Cell(100, 5, '(wet signature/e-signature/digital certificate)', 0, 0, 'C');
$pdf->SetTextColor(0, 0, 0);

$pdf->SetLineWidth(0.4);
$pdf->Rect($margin, $margin, $usableW, $height - $margin * 2 - 5);

// ─────────────────────────────────────────────────────────────────────────────
//  PAGE 4
// ─────────────────────────────────────────────────────────────────────────────
$pdf->AddPage();
$y4 = $pdf->GetY();

// ── Questions 34-40 ───────────────────────────────────────────────────────────
$qLabelW = 130; // question text column
$qAnswerW = $usableW - $qLabelW; // YES/NO + details column

$questions = [
    34 => [
        'text' => "34. Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be appointed,\n\n  a. within the third degree?\n  b. within the fourth degree (for Local Government Unit - Career Employees)?",
        'minH' => 32,
        'yes_a' => isset($otherInfo['has_third_degree']) ? ($otherInfo['has_third_degree'] == 1) : false,
        'no_a' => isset($otherInfo['has_third_degree']) ? ($otherInfo['has_third_degree'] == 0) : false,
        'yes_b' => isset($otherInfo['has_fourth_degree']) ? ($otherInfo['has_fourth_degree'] == 1) : false,
        'no_b' => isset($otherInfo['has_fourth_degree']) ? ($otherInfo['has_fourth_degree'] == 0) : false,
        'details' => $otherInfo['relation_details'] ?? '',
        'multi' => true,
    ],
    35 => [
        'text' => "35. a. Have you ever been found guilty of any administrative offense?\n\n  b. Have you been criminally charged before any court?",
        'minH' => 22,
        'yes_a' => isset($otherInfo['was_guilty']) ? ($otherInfo['was_guilty'] == 1) : false,
        'no_a' => isset($otherInfo['was_guilty']) ? ($otherInfo['was_guilty'] == 0) : false,
        'yes_b' => isset($otherInfo['was_charged']) ? ($otherInfo['was_charged'] == 1) : false,
        'no_b' => isset($otherInfo['was_charged']) ? ($otherInfo['was_charged'] == 0) : false,
        'details' => ($otherInfo['guilty_details'] ?? '') . ' ' . ($otherInfo['case_status'] ?? ''),
        'multi' => true,
    ],
    36 => [
        'text' => "36. Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?",
        'minH' => 15,
        'yes_a' => isset($otherInfo['was_convicted']) ? ($otherInfo['was_convicted'] == 1) : false,
        'no_a' => isset($otherInfo['was_convicted']) ? ($otherInfo['was_convicted'] == 0) : false,
        'details' => $otherInfo['conviction_details'] ?? '',
        'multi' => false,
    ],
    37 => [
        'text' => "37. Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?",
        'minH' => 20,
        'yes_a' => isset($otherInfo['was_separated']) ? ($otherInfo['was_separated'] == 1) : false,
        'no_a' => isset($otherInfo['was_separated']) ? ($otherInfo['was_separated'] == 0) : false,
        'details' => $otherInfo['separation_details'] ?? '',
        'multi' => false,
    ],
    38 => [
        'text' => "38. a. Have you ever been a candidate in a national or local election held within the last year (except Barangay election)?\n\n  b. Have you resigned from the government service during the three (3)-month period before the last election to promote/actively campaign for a national or local candidate?",
        'minH' => 28,
        'yes_a' => isset($otherInfo['was_candidate']) ? ($otherInfo['was_candidate'] == 1) : false,
        'no_a' => isset($otherInfo['was_candidate']) ? ($otherInfo['was_candidate'] == 0) : false,
        'yes_b' => isset($otherInfo['have_resigned']) ? ($otherInfo['have_resigned'] == 1) : false,
        'no_b' => isset($otherInfo['have_resigned']) ? ($otherInfo['have_resigned'] == 0) : false,
        'details' => ($otherInfo['candidacy_details'] ?? '') . ' ' . ($otherInfo['resignation_details'] ?? ''),
        'multi' => true,
    ],
    39 => [
        'text' => "39. Have you acquired the status of an immigrant or permanent resident of another country?",
        'minH' => 14,
        'yes_a' => isset($otherInfo['is_immigrant']) ? ($otherInfo['is_immigrant'] == 1) : false,
        'no_a' => isset($otherInfo['is_immigrant']) ? ($otherInfo['is_immigrant'] == 0) : false,
        'details' => isset($otherInfo['immigrant_country_id']) && $otherInfo['immigrant_country_id'] && ($c = country($otherInfo['immigrant_country_id'])) ? $c['name'] : '',
        'multi' => false,
    ],
    40 => [
        'text' => "40. Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:\n\n  a. Are you a member of any indigenous group?\n  b. Are you a person with disability?\n  c. Are you a solo parent?",
        'minH' => 34,
        'yes_a' => isset($otherInfo['is_indigenous']) ? ($otherInfo['is_indigenous'] == 1) : false,
        'no_a' => isset($otherInfo['is_indigenous']) ? ($otherInfo['is_indigenous'] == 0) : false,
        'yes_b' => isset($otherInfo['with_disability']) ? ($otherInfo['with_disability'] == 1) : false,
        'no_b' => isset($otherInfo['with_disability']) ? ($otherInfo['with_disability'] == 0) : false,
        'yes_c' => isset($otherInfo['is_solo_parent']) ? ($otherInfo['is_solo_parent'] == 1) : false,
        'no_c' => isset($otherInfo['is_solo_parent']) ? ($otherInfo['is_solo_parent'] == 0) : false,
        'details' => trim(($otherInfo['indigenous_group'] ?? '') . ' ' . ($otherInfo['disability'] ?? '')),
        'multi' => true,
        'triple' => true,
    ],
];

$yQ = $y4;
foreach ($questions as $qNo => $q) {
    $rY = $yQ;
    $pdf->SetXY($margin, $rY);
    $pdf->SetFont('Arial', '', 7);
    $pdf->SetFillColor(234, 234, 234);
    $pdf->MultiCell($qLabelW, 4, $q['text'], 1, 'L', true);
    $actualH = max($q['minH'], $pdf->GetY() - $rY);

    // Ensure label box fills full height
    if ($actualH > $pdf->GetY() - $rY) {
        $pdf->SetXY($margin, $rY);
        $pdf->Cell($qLabelW, $actualH, '', 1, 0);
    }

    // Answer column
    $pdf->SetXY($margin + $qLabelW, $rY);
    $pdf->Cell($qAnswerW, $actualH, '', 1, 0);

    // YES / NO row A
    $aY = $rY + 2;
    $pdf->SetXY($margin + $qLabelW + 2, $aY);
    $pdf->SetFont('Arial', '', 7.5);
    $yesA = isset($q['yes_a']) && $q['yes_a'] ? 'X' : ' ';
    $noA = isset($q['no_a']) && $q['no_a'] ? 'X' : ' ';
    $pdf->Cell(12, 4, "[{$yesA}] YES", 0, 0);
    $pdf->Cell(12, 4, "[{$noA}] NO", 0, 0);

    // YES / NO row B (if multi)
    if (!empty($q['multi'])) {
        $bY = $aY + 8;
        $pdf->SetXY($margin + $qLabelW + 2, $bY);
        $yesB = isset($q['yes_b']) && $q['yes_b'] ? 'X' : ' ';
        $noB = isset($q['no_b']) && $q['no_b'] ? 'X' : ' ';
        $pdf->Cell(12, 4, "[{$yesB}] YES", 0, 0);
        $pdf->Cell(12, 4, "[{$noB}] NO", 0, 0);
    }

    // YES / NO row C (if triple = Q40)
    if (!empty($q['triple'])) {
        $cY = $aY + 16;
        $pdf->SetXY($margin + $qLabelW + 2, $cY);
        $yesC = isset($q['yes_c']) && $q['yes_c'] ? 'X' : ' ';
        $noC = isset($q['no_c']) && $q['no_c'] ? 'X' : ' ';
        $pdf->Cell(12, 4, "[{$yesC}] YES", 0, 0);
        $pdf->Cell(12, 4, "[{$noC}] NO", 0, 0);
    }

    // If YES details
    $detailText = trim($q['details'] ?? '');
    $pdf->SetXY($margin + $qLabelW + 2, $rY + $actualH - 14);
    $pdf->SetFont('Arial', '', 6.5);
    $pdf->MultiCell($qAnswerW - 4, 3.5, "If YES, give details:\n" . ($detailText ?: '___________________________________'), 0, 'L');

    $yQ += $actualH;
    $pdf->SetXY($margin, $yQ);
}

$pdf->Ln(2);

// ── 41. REFERENCES ────────────────────────────────────────────────────────────
$yRef = $pdf->GetY();
$pdf->SetXY($margin, $yRef);
$pdf->SetFont('Arial', '', 6.5);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($usableW, 5, ' 41. REFERENCES (Person not related by consanguinity or affinity to applicant/appointee)', 1, 1, 'L', true);

$refNameW = 80;
$refAddrW = 80;
$refTelW = $usableW - $refNameW - $refAddrW;
$pdf->SetFont('Arial', '', 6.5);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($refNameW, 5, 'NAME', 1, 0, 'C', true);
$pdf->Cell($refAddrW, 5, 'ADDRESS', 1, 0, 'C', true);
$pdf->Cell($refTelW, 5, 'TEL. NO.', 1, 1, 'C', true);

$refRowH = 7;
$refMax = 3;
for ($ri = 0; $ri < $refMax; $ri++) {
    $ref = $refList[$ri] ?? null;
    $pdf->SetFont('Arial', '', 7.5);
    $pdf->Cell($refNameW, $refRowH, $ref ? strtoupper($ref['name'] ?? 'N/A') : '', 1, 0, 'L');
    $pdf->Cell($refAddrW, $refRowH, $ref ? strtoupper($ref['address'] ?? 'N/A') : '', 1, 0, 'L');
    $pdf->Cell($refTelW, $refRowH, $ref ? ($ref['contact'] ?? 'N/A') : '', 1, 1, 'C');
}

$pdf->Ln(2);

// ── 42. DECLARATION ───────────────────────────────────────────────────────────
$yDecl = $pdf->GetY();
$pdf->SetXY($margin, $yDecl);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(234, 234, 234);
$pdf->Cell($usableW, 5, '42. DECLARATION', 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 7.5);
$declText = "I declare under oath that I have personally accomplished this Personal Data Sheet which is a true, correct and complete statement pursuant to the provisions of pertinent laws, rules and regulations of the Republic of the Philippines. I authorize the agency head/authorized representative to verify/validate the contents stated herein. I am aware that any misrepresentation made in this document and its attachments shall cause the filing of administrative/criminal case/s against me.";
$pdf->MultiCell($usableW, 4.5, $declText, 1, 'J');

$yAfterDecl = $pdf->GetY();

// ── Bottom blocks: Gov ID | Thumbmark | Photo ─────────────────────────────────
$blockH = 45;
$govIDW = 75;
$thumbW = 55;
$photoW = $usableW - $govIDW - $thumbW;

// Government Issued ID box
$pdf->SetXY($margin, $yAfterDecl + 3);
$pdf->SetFont('Arial', '', 6);
$pdf->Cell($govIDW, $blockH, '', 1, 0);
$pdf->SetXY($margin, $yAfterDecl + 3);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell($govIDW, 5, 'Government Issued ID (i.e. Passport, GSIS, SSS, PRC, Driver\'s License, etc.)', 0, 1, 'C');
$pdf->SetXY($margin, $yAfterDecl + 8);
$pdf->SetFont('Arial', '', 6.5);
$pdf->Cell($govIDW, 4, 'PLEASE INDICATE ID Number and Date of Issuance', 0, 1, 'C');
$pdf->SetXY($margin, $yAfterDecl + 13);
$pdf->Cell($govIDW, 5, 'Government Issued ID: ____________________________', 0, 1, 'L');
$pdf->SetXY($margin, $yAfterDecl + 18);
$pdf->Cell($govIDW, 5, 'ID/License/Passport No.: ________________________', 0, 1, 'L');
$pdf->SetXY($margin, $yAfterDecl + 23);
$pdf->Cell($govIDW, 5, 'Date/Place of Issuance: _________________________', 0, 1, 'L');

// Right Thumbmark box
$pdf->SetXY($margin + $govIDW, $yAfterDecl + 3);
$pdf->Cell($thumbW, $blockH, '', 1, 0);
$pdf->SetXY($margin + $govIDW, $yAfterDecl + 18);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($thumbW, 5, 'Right Thumbmark', 0, 0, 'C');

// ID Photo box
$pdf->SetXY($margin + $govIDW + $thumbW, $yAfterDecl + 3);
$pdf->Cell($photoW, $blockH, '', 1, 0);
$pdf->SetXY($margin + $govIDW + $thumbW, $yAfterDecl + 5);
$pdf->SetFont('Arial', '', 7);
$pdf->MultiCell($photoW, 4, "ID picture taken within\nthe last 6 months\n3.5 cm. X 4.5 cm\n(passport size)", 0, 'C');

// Signature & Date accomplished lines
$ySigLine = $yAfterDecl + $blockH + 5;
$pdf->SetXY($margin, $ySigLine);
$pdf->SetFont('Arial', '', 7.5);
$pdf->Cell(70, 8, 'Date Accomplished', 'T', 0, 'C');
$pdf->SetXY($margin + 100, $ySigLine);
$pdf->Cell(85, 8, 'Signature', 'T', 0, 'C');

// Page 4 outer border
$pdf->SetLineWidth(0.4);
$pdf->Rect($margin, $margin, $usableW, $height - $margin * 2 - 5);