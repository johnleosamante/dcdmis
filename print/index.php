<?php
// print/index.php
require_once('../includes/function.php');

if (!isset($_SESSION[alias() . '_userId']) || !isset($_SESSION[alias() . '_portal'])) {
  redirect(uri() . '/login');
}

$userId = $_SESSION[alias() . '_userId'];
$portal = $_SESSION[alias() . '_portal'];
$isSchool = $portal === 'school_portal';
$station = $_SESSION[alias() . '_station'];
$stationId = $_SESSION[alias() . '_stationId'];

require_once(root() . '/includes/plugin/fpdf/fpdf.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/section.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/database/district.php');
require_once(root() . '/includes/database/utility.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/plugin/phpqrcode/qrlib.php');

foreach ($_GET as $key => $data) {
  $url = $_GET[$key] = decode($data);
  $page = sanitize($url);
}

$code = strtoupper($_GET['id']);
$title = '';
$logoSize = 24;
$margin = 25.4;
$width = 210;
$height = 297;
$lineY = 60;
$departmentLogo = root() . '/assets/img/department.png';
$divisionName = 'DIPOLOG CITY SCHOOLS DIVISION';
$section = strtoupper(stationName($station));
$school = fetchArray(schoolDetailsById($stationId));
$district = fetchAssoc(district($school['district']))['name'];
$stationLogo = root() . '/' . $school['logo'];
$address = $school['address'];
$telephone = $school['telephone'];
$email = $school['email'];
$website = $school['website'];
$fbPage = $school['fb_page'];

class PDF extends FPDF {
  function Header() {
    global $divisionName;
    global $departmentLogo;
    global $logoSize;
    global $width;
    global $margin;
    global $isSchool;
    global $section;
    global $address;
    global $district;
    global $lineY;
    $this->Image($departmentLogo, ($width / 2) - ($logoSize / 2), 8, $logoSize);
    $this->AddFont('OLDENGL', '', 'OLDENGL.php');
    $this->AddFont('tahomabd', 'B', 'tahomabd.php');
    $this->SetFont('OLDENGL', '', 12);
    $this->Cell(0, 0, 'Republic of the Philippines', 0, 0, 'C');
    $this->Ln(6);
    $this->SetFont('OLDENGL', '', 18);
    $this->Cell(0, 0, 'Department of Education', 0, 0, 'C');
    $this->Ln(6);
    $this->SetFont('tahomabd', 'B', 11);
    $this->Cell(0, 0, 'REGION IX - ZAMBOANGA PENINSULA', 0, 0, 'C');
    $this->Ln(5);
    $this->Cell(0, 0, $divisionName, 0, 0, 'C');
    $this->Ln(5);
    $this->SetFont('tahomabd',  'B', 11);
    $this->Cell(0, 0, $section, 0, 0, 'C');
    if ($isSchool) {
      $this->Ln(5);
      $this->Cell(0, 0, strtoupper($address), 0, 0, 'C');
      $this->Ln(5);
      $this->Cell(0, 0, strtoupper($district), 0, 0, 'C');
      $lineY = 70;
    }
    $this->Line($margin, $lineY, $width - $margin, $lineY);
    $this->Ln(15);
  }

  function Footer() {
    global $stationLogo;
    global $address;
    global $telephone;
    global $email;
    global $website;
    global $fbPage;
    global $address;
    global $telephone;
    global $email;
    global $website;
    global $logoSize;
    global $margin;
    global $height;
    global $width;
    global $code;
    $footerSpace = 27;

    $this->Line($margin, $height - 33, $width - $margin, $height - 33);
    $this->Image($stationLogo, $margin, $height - 32, $logoSize);
    $this->SetY(-28);
    $this->AddFont('calibri', '', 'calibri.php');
    $this->SetFont('calibri', '', 10);

    if (strlen($address) > 0) {
      $this->SetX($logoSize + $footerSpace);
      $this->Cell(0, 0, "Address: {$address}");
      $this->Ln(4);
    }

    if (strlen($telephone) > 0) {
      $this->SetX($logoSize + $footerSpace);
      $this->Cell(0, 0, "Telephone No: {$telephone}");
      $this->Ln(4);
    }

    if (strlen($email) > 0) {
      $this->SetX($logoSize + $footerSpace);
      $this->Cell(0, 0, "Email Address: {$email}");
      $this->Ln(4);
    }

    if (strlen($website) > 0) {
      $this->SetX($logoSize + $footerSpace);
      $this->Cell(0, 0, "Website: {$website}");
      $this->Ln(4);
    }

    if (strlen($fbPage) > 0) {
      $this->SetX($logoSize + $footerSpace);
      $this->Cell(0, 0, "FB Page: {$fbPage}");
    }

    if (!empty($code)) {
      $pngTempDirRoot = root() . '/temp';
      $pngTempDir = root() . '/temp/qr';
      $errorCorrectionLevel = 'L';
      $matrixPointSize = 5;
      $filename = $pngTempDir . '/' . md5($code . $errorCorrectionLevel . $matrixPointSize) . '.png';

      if (!file_exists($pngTempDirRoot)) {
        mkdir($pngTempDirRoot);
      }

      if (!file_exists($pngTempDir)) {
        mkdir($pngTempDir);
      }

      QRcode::png($code, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

      $this->Image($filename, $width - $margin - $logoSize, $height - 32, $logoSize);
    }

    $this->SetY(-6);
    $this->Cell(0, 0, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'C');
  }
}

if (!isset($url) || $url === '') {
  redirect(customUri('dts', '404'));
} else {
  $file = '';
  switch ($url) {
    case 'Document Tracking Slip':
      $title = $url . ' : ' . $code;
      $file = 'document-tracking-slip';
      break;
    default:
      redirect(customUri('dts', '404'));
      break;
  }

  $pdf = new PDF('P', 'mm', array($width, $height));
  $pdf->SetTitle($title);
  $pdf->AliasNbPages();
  $pdf->SetMargins($margin, 11 + $logoSize, $margin);
  $pdf->SetAutoPageBreak(true, 35);
  $pdf->AddPage();
  $pdf->AddFont('calibri', '', 'calibri.php');
  $pdf->AddFont('calibrib', 'B', 'calibrib.php');

  require_once(root() . "/print/{$file}.php");

  $pdf->Output();
}
