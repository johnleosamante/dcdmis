<?php
// print/print-layout.php
class PDF extends FPDF {
  function Header() {
    global $logoSize;
    global $width;
    global $margin;
    global $isSchoolPortal;
    global $section;
    global $address;
    global $lineY;
    $this->Image(root() . '/uploads/division/deped-seal.png', ($width / 2) - ($logoSize / 2), 8, $logoSize);
    $this->AddFont('OLDENGL', '', 'OLDENGL.php');
    $this->AddFont('TrajanPro-Regular', '', 'TrajanPro-Regular.php');
    $this->SetFont('OLDENGL', '', 12);
    $this->Cell(0, 0, 'Republic of the Philippines', 0, 0, 'C');
    $this->Ln(6);
    $this->SetFont('OLDENGL', '', 18);
    $this->Cell(0, 0, 'Department of Education', 0, 0, 'C');
    $this->Ln(6);
    $this->SetFont('TrajanPro-Regular', '', 10);
    $this->Cell(0, 0, 'REGION IX - ZAMBOANGA PENINSULA', 0, 0, 'C');
    $this->Ln(5);
    $this->Cell(0, 0, 'SCHOOLS DIVISION OF DIPOLOG CITY', 0, 0, 'C');

    if (!empty($section)) {
      $this->Ln(5);
      $this->Cell(0, 0, $section, 0, 0, 'C');
    }

    if ($isSchoolPortal) {
      $this->Ln(5);
      $this->Cell(0, 0, strtoupper($address), 0, 0, 'C');
      $lineY = $lineY + 5;
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
    global $showQR;
    global $code;
    global $multiplePage;
    global $isSchoolPortal;
    global $showStationInfo;

    if ($isSchoolPortal) {
      $this->Image(root() . '/uploads/division/footer-logos-schools.png', $margin, $height - 32, 0, $logoSize);
      
      if (!empty($stationLogo)) {
        $this->Image($stationLogo, 112, $height - 32, $logoSize);
      }

      $this->SetY(-28);
      $footerSpace = 100;
    } else {
      $this->Image(root() . '/uploads/division/footer-logos.png', $margin, $height - 32, 0, $logoSize);
      $footerSpace = 149;
    }

    if ($showStationInfo) {
      $this->SetY(-28);
      $this->AddFont('calibri', '', 'calibri.php');
      $this->SetFont('calibri', '', 10);

      if (strlen($address) > 0) {
        $this->SetX($footerSpace);
        $this->Cell(0, 0, "Address: {$address}");
        $this->Ln(4);
      }

      if (strlen($telephone) > 0) {
        $this->SetX($footerSpace);
        $this->Cell(0, 0, "Telephone No: {$telephone}");
        $this->Ln(4);
      }

      if (strlen($email) > 0) {
        $this->SetX($footerSpace);
        $this->Cell(0, 0, "Email Address: {$email}");
        $this->Ln(4);
      }

      if (strlen($website) > 0) {
        $this->SetX($footerSpace);
        $this->Cell(0, 0, "Website: {$website}");
        $this->Ln(4);
      }

      if (strlen($fbPage) > 0) {
        $this->SetX($footerSpace);
        $this->Cell(0, 0, "FB Page: {$fbPage}");
      }
    }

    if ($showQR) {
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

      $this->Image($filename, $width - $margin - $logoSize, $height - 33, $logoSize + 2);
      $this->Line($margin, $height - 33, $width - $margin, $height - 33);
    }

    if ($multiplePage) {
      $this->SetY(-6);
      $this->Cell(0, 0, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'C');
    }
  }
}
?>