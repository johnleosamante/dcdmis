<?php
// print/index.php
require_once('../includes/function.php');

if (!isset($_SESSION[alias() . '_user_id']) || !isset($_SESSION[alias() . '_portal'])) {
  redirect(uri() . '/login');
}

require_once(root() . '/includes/plugin/fpdf/fpdf.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/section.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/database/document.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/district.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/utility.php');

foreach ($_GET as $key => $data) {
  $url = $_GET[$key] = decode($data);
  $page = real_escape_string($url);
}

$code = strtoupper($_GET['id']);
$is_school = $_SESSION[alias() . '_portal'] === 'school_portal';
$division_name = 'DIPOLOG CITY SCHOOLS DIVISION';
$department_logo = root() . '/assets/img/department.png';

$title = '';
$logo_size = 24;
$margin = 25.4;
$width = 210;
$height = 297;

$school = fetch_array(school_details_by_id(!$is_school ? '143' : $_SESSION[alias() . '_code']));
$station_logo = root() . '/' . $school['logo'];
$address = $school['address'];
$telephone = $school['telephone'];
$email = $school['email'];
$website = $school['website'];
$fb_page = $school['fb_page'];
$district = fetch_assoc(district($school['district']))['name'];
$lineY = 60;

class PDF extends FPDF {
  function Header() {
    global $division_name;
    global $department_logo;
    global $logo_size;
    global $width;
    global $margin;
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

    if ($this->PageNo() > 1) {
      $this->SetY(-6);
      $this->Cell(0, 0, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'C');
    }
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
    case 'Document Information':
      $title = $url . ' : ' . $code;
      $file = 'document-information';
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
?>