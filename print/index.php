<?php
// print/index.php
require_once('../includes/function.php');
require_once(root() . '/includes/string.php');

if (!isset($_SESSION[alias() . '_userId']) || !isset($_SESSION[alias() . '_portal'])) {
  redirect(uri() . '/login');
}

$page = $url = sanitize(decode($_GET['v']));

if (!isset($url) || $url === '') {
  redirect(customUri($activeApp, '404'));
}

$code = strtoupper(sanitize(decode($_GET['id'])));
$file = $title = '';
$logoSize = 24;
$margin = 25.4;
$width = 210;
$height = 297;
$lineY = 60;

switch ($url) {
  case 'Document Tracking Slip':
    $title = $url . ' : ' . $code;
    $file = 'document-tracking-slip';
    break;
  default:
    redirect(customUri('dts', '404'));
    break;
}

require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/section.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/database/district.php');
require_once(root() . '/includes/database/utility.php');
require_once(root() . '/includes/plugin/fpdf/fpdf.php');
require_once(root() . '/includes/plugin/phpqrcode/qrlib.php');

$section = strtoupper(stationName($station));
$school = fetchArray(schoolDetailsById($stationId));
$district = fetchAssoc(district($school['district']))['name'];
$stationLogo = root() . '/' . $school['logo'];
$address = $school['address'];
$telephone = $school['telephone'];
$email = $school['email'];
$website = $school['website'];
$fbPage = $school['fb_page'];

require_once(root() . '/print/print-layout.php');

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
?>