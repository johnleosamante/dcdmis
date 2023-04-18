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
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/database/utility.php');

foreach ($_GET as $key => $data) {
  $url = $_GET[$key] = decode($data);
  $page = real_escape_string($url);
}

$code = strtoupper($_GET['id']);
$address = 'Purok Farmers, Olingan, Dipolog City';
$telephone = '(065) 908-2583';
$email = 'dipolog.city@deped.gov.ph';
$website = 'https://dipologcitydivision.net';
$fb_page = 'https://facebook.com/depeddipologcity';
$division_name = 'DIPOLOG CITY SCHOOLS DIVISION';
$department_logo = root() . '/assets/img/department.png';
$station_logo = root() . '/assets/img/division.png';

$title = '';
$logo_size = 24;
$margin = 25.4;
$width = 210;
$height = 297;

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
    $this->Ln(5);
    $this->SetFont('OLDENGL', '', 18);
    $this->Cell(0, 0, 'Department of Education', 0, 0, 'C');
    $this->Ln(5);
    $this->SetFont('tahomabd', 'B', 10);
    $this->Cell(0, 0, 'Region IX - Zamboanga Peninsula', 0, 0, 'C');
    $this->Ln(5);
    $this->Cell(0, 0, $division_name, 0, 0, 'C');
    $this->Line($margin, 53, $width - $margin, 53);
    $this->Ln(6);
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
    $this->Line($margin, $height - 33, $width - $margin, $height - 33);
    $this->Image($station_logo, $margin, $height - 32, $logo_size);
    $this->SetY(-28);
    $this->AddFont('calibri', '', 'calibri.php');
    $this->SetFont('calibri', '', 10);
    $this->SetX($logo_size + 28);
    $this->Cell(0, 0, "Address: {$address}");
    $this->Ln(4);
    $this->SetX($logo_size + 28);
    $this->Cell(0, 0, "Telephone No: {$telephone}");
    $this->Ln(4);
    $this->SetX($logo_size + 28);
    $this->Cell(0, 0, "Email Address: {$email}");
    $this->Ln(4);
    $this->SetX($logo_size + 28);
    $this->Cell(0, 0, "Website: {$website}");
    $this->Ln(4);
    $this->SetX($logo_size + 28);
    $this->Cell(0, 0, "FB Page: {$fb_page}");
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