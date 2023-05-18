<?php
// print/index.php
include_once('../includes/function.php');

if (!isset($_SESSION[alias() . '_user_id']) || !isset($_SESSION[alias() . '_portal'])) {
  redirect(uri() . '/login');
}

include_once(root() . '/includes/plugin/fpdf/fpdf.php');
include_once(root() . '/includes/database/database.php');
include_once(root() . '/includes/database/section.php');
include_once(root() . '/includes/database/school.php');
include_once(root() . '/includes/database/district.php');
include_once(root() . '/includes/database/utility.php');
include_once(root() . '/includes/string.php');
include_once(root() . '/includes/plugin/phpqrcode/qrlib.php');

foreach ($_GET as $key => $data) {
  $url = $_GET[$key] = decode($data);
  $page = sanitize($url);
}

$code = strtoupper($_GET['id']);
$title = '';
$logo_size = 24;
$margin = 25.4;
$width = 210;
$height = 297;
$lineY = 60;
$department_logo = root() . '/assets/img/department.png';
$division_name = 'DIPOLOG CITY SCHOOLS DIVISION';
$section = strtoupper(station_name($_SESSION[alias() . '_station']));
$is_school = $_SESSION[alias() . '_portal'] === 'school_portal';
$school = fetch_array(school_details_by_id($_SESSION[alias() . '_station_id']));
$district = fetch_assoc(district($school['district']))['name'];
$station_logo = root() . '/' . $school['logo'];
$address = $school['address'];
$telephone = $school['telephone'];
$email = $school['email'];
$website = $school['website'];
$fb_page = $school['fb_page'];

class PDF extends FPDF {
  function Header() {
    global $division_name;
    global $department_logo;
    global $logo_size;
    global $width;
    global $margin;
    global $is_school;
    global $section;
    global $address;
    global $district;
    global $lineY;
    $this->Image($department_logo, ($width / 2) - ($logo_size / 2), 8, $logo_size);
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
    $this->Cell(0, 0, $division_name, 0, 0, 'C');
    $this->Ln(5);
    $this->SetFont('tahomabd',  'B', 11);
    $this->Cell(0, 0, $section, 0, 0, 'C');
    if ($is_school) {
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
    global $station_logo;
    global $address;
    global $telephone;
    global $email;
    global $website;
    global $fb_page;
    global $address;
    global $telephone;
    global $email;
    global $website;
    global $logo_size;
    global $margin;
    global $height;
    global $width;
    global $code;
    $footer_space = 27;

    $this->Line($margin, $height - 33, $width - $margin, $height - 33);
    $this->Image($station_logo, $margin, $height - 32, $logo_size);
    $this->SetY(-28);
    $this->AddFont('calibri', '', 'calibri.php');
    $this->SetFont('calibri', '', 10);

    if (strlen($address) > 0) {
      $this->SetX($logo_size + $footer_space);
      $this->Cell(0, 0, "Address: {$address}");
      $this->Ln(4);
    }

    if (strlen($telephone) > 0) {
      $this->SetX($logo_size + $footer_space);
      $this->Cell(0, 0, "Telephone No: {$telephone}");
      $this->Ln(4);
    }

    if (strlen($email) > 0) {
      $this->SetX($logo_size + $footer_space);
      $this->Cell(0, 0, "Email Address: {$email}");
      $this->Ln(4);
    }

    if (strlen($website) > 0) {
      $this->SetX($logo_size + $footer_space);
      $this->Cell(0, 0, "Website: {$website}");
      $this->Ln(4);
    }

    if (strlen($fb_page) > 0) {
      $this->SetX($logo_size + $footer_space);
      $this->Cell(0, 0, "FB Page: {$fb_page}");
    }

    if (!empty($code)) {
      $PNG_TEMP_DIR_ROOT = root() . '/temp';
      $PNG_TEMP_DIR = root() . '/temp/qr';
      $errorCorrectionLevel = 'L';
      $matrixPointSize = 5;
      $filename = $PNG_TEMP_DIR . '/' . md5($code . $errorCorrectionLevel . $matrixPointSize) . '.png';

      if (!file_exists($PNG_TEMP_DIR_ROOT)) {
        mkdir($PNG_TEMP_DIR_ROOT);
      }

      if (!file_exists($PNG_TEMP_DIR)) {
        mkdir($PNG_TEMP_DIR);
      }

      QRcode::png($code, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

      $this->Image($filename, $width - $margin - $logo_size, $height - 32, $logo_size);
    }

    $this->SetY(-6);
    $this->Cell(0, 0, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'C');
  }
}

if (!isset($url) || $url === '') {
  redirect(custom_uri('dts', '404'));
} else {
  $file = '';
  switch ($url) {
    case 'Document Tracking Slip':
      $title = $url . ' : ' . $code;
      $file = 'document-tracking-slip';
      break;
    default:
      redirect(custom_uri('dts', '404'));
      break;
  }

  $pdf = new PDF('P', 'mm', array($width, $height));
  $pdf->SetTitle($title);
  $pdf->AliasNbPages();
  $pdf->SetMargins($margin, 11 + $logo_size, $margin);
  $pdf->SetAutoPageBreak(true, 35);
  $pdf->AddPage();
  $pdf->AddFont('calibri', '', 'calibri.php');
  $pdf->AddFont('calibrib', 'B', 'calibrib.php');

  include_once(root() . "/print/{$file}.php");

  $pdf->Output();
}
