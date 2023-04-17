<?php
// print/index.php
require_once('../includes/function.php');

if (!isset($_SESSION[alias() . '_user_id']) || !isset($_SESSION[alias() . '_portal'])) {
  redirect(uri() . '/login');
}

require_once(root() . '/includes/plugin/fpdf/fpdf.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/document.php');

foreach ($_GET as $key => $data) {
  $url = $_GET[$key] = decode($data);
  $page = real_escape_string($url);
}

$code = strtoupper($_GET['id']);

class PDF extends FPDF {
  const DEPARTMENT_LOGO = '/assets/img/department.png';
  const DIVISION_LOGO = '/assets/img/division.png';
  const A4_HEIGHT = 297;
  const A4_WIDTH = 210;

  function Header() {
    $this->Image(root() . self::DEPARTMENT_LOGO, 93, 10, 24);
    $this->AddFont('OLDENGL', '', 'OLDENGL.php');
    $this->AddFont('tahomabd', 'B', 'tahomabd.php');
    $this->SetFont('OLDENGL', '', 12);
    $this->Cell(0, 55, 'Republic of the Philippines', 0, 0, 'C');
    $this->Ln(33);
    $this->SetFont('OLDENGL', '', 18);
    $this->Cell(0, 0, 'Department of Education', 0, 0, 'C');
    $this->SetFont('tahomabd', 'B', 10);
    $this->Ln(6);
    $this->Cell(0, 0, 'Region IX - Zamboanga Peninsula', 0, 0, 'C');
    $this->Ln(5);
    $this->Cell(0, 0, 'Schools Division of Dipolog City', 0, 0, 'C');
    $this->Line(20, 57, self::A4_WIDTH - 20, 57);
  }

  function Footer() {
    $this->Line(20, self::A4_HEIGHT - 33, self::A4_WIDTH - 20, self::A4_HEIGHT - 33);
    $this->Image(root() . self::DIVISION_LOGO, 20, self::A4_HEIGHT - 32, 24);
    $this->SetY(-28);
    $this->SetX(45);
    $this->AddFont('calibri', '', 'calibri.php');
    $this->SetFont('calibri', '', 10);
    $this->Cell(0, 0, 'Address: Purok Farmers, Olingan, Dipolog City');
    $this->Ln(4);
    $this->SetX(45);
    $this->Cell(0, 0, 'Telephone No: (065) 908-2583');
    $this->Ln(4);
    $this->SetX(45);
    $this->Cell(0, 0, 'Email Address: dipolog.city@deped.gov.ph');
    $this->Ln(4);
    $this->SetX(45);
    $this->Cell(0, 0, 'Website: https://dipologcitydivision.net');
    $this->Ln(4);
    $this->SetX(45);
    $this->Cell(0, 0, 'FB Page: https://facebook.com/depeddipologcity');
    $this->SetY(-5);
    $this->Cell(0, 0, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'C');
  }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->AddFont('calibri', '', 'calibri.php');
$pdf->AddFont('calibrib', 'B' , 'calibrib.php');
$pdf->SetY(65);

if (!isset($url) || $url === '') {
  redirect(custom_uri('dts', '404'));
} else {
  $file = '';
  switch ($url) {
    case 'Document Tracking Slip':
      $file = 'document-tracking-slip';
      break;
    case 'Document Information':
      $file = 'document-information';
      break;
    default:
      redirect(custom_uri('dts', '404'));
      break;
  }

  $pdf->SetTitle($url . ' : ' . $code);

  include_once(root() . "/print/{$file}.php");

  $pdf->Output();
}
?>