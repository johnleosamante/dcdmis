
<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
require('../pcdmis/code128.php');


$pdf=new PDF_Code128('P','mm','A4');

$img1='../pcdmis/shs/h1.png';	

//Add New Page
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->Image($img1,97,10,20);
$pdf->Image($img1,97,150,20);

    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0,20,"Driver's Copy",0,1,'R');
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF DIPOLOG CITY',0,1,'C');
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','I',14);
	$pdf->Cell(0,5,'VEHICLE REQUEST FORM',0,1,'C');
	$vehicle=mysqli_query($con,"SELECT * FROM tbl_vehicle_reservation INNER JOIN tbl_vehicle ON tbl_vehicle_reservation.VehicleCode = tbl_vehicle.VehicleCode WHERE tbl_vehicle_reservation.No='".$_GET['No']."' LIMIT 1") or die("Table Error");
	$rowvh=mysqli_fetch_assoc($vehicle);
	$daterequest=date('M j\, Y', strtotime($rowvh['RequestDate']));
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(30,6,'1. Date:',0,0);
	$pdf->Cell(60,6,$daterequest,0,0);
	$pdf->Cell(20,6,"Time out:",0,0);
	$pdf->Cell(30,6,$rowvh['RequestTimeOUT'],0,0);
	$pdf->Cell(20,6,"Time in:",0,0);
	$pdf->Cell(30,6,"",0,1);
	$pdf->Cell(30,6,'2. Driver:',0,0);
	$pdf->Cell(50,6,$rowvh['Driver'],0,1);
	$pdf->Cell(30,6,'3. Vehicle:',0,0);
	$pdf->Cell(50,6,$rowvh['Vehicle_Description'],0,0);
	$pdf->Cell(30,6,'Plate Number:',0,0);
	$pdf->Cell(30,6,$rowvh['PlateNo'],0,1);
	$pdf->Cell(30,6,'4. Destination:',0,0);
	$pdf->Cell(0,6,$rowvh['RequestDestination'],0,1);
	$pdf->Cell(30,6,'5. Passenger(s):',0,0);
	$pdf->Cell(0,6,$rowvh['RequestPassenger'],0,1);
	$pdf->Cell(30,6,'6. Purpose(s):',0,0);
	$pdf->Write(6,$rowvh['RequestPurposed']);
	$pdf->Cell(0,6,'',0,1,'C');
	$pdf->Cell(0,0,'',1,1,'C');
	
	$pdf->Cell(0,4,'',0,1,'C');
	$pdf->Cell(100,5,'Requested by:',0,0);
	$pdf->Cell(0,5,'Approved by:',0,1);
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(20,5,'',0,0);
	$pdf->Cell(100,5,$rowvh['Requestedby'],0,0);
	$pdf->Cell(0,5,'DANNY B. CORDOVA, Ed.D., CESO VI',0,1,'C');
	$pdf->Cell(120,5,'',0,0);
	$pdf->Cell(0,5,'Schools Division Superintendent',0,1,'C');
	
	//Next copy
	$pdf->Cell(0,20,'',0,1,'C');
	 $pdf->Cell(0,20,"OSDS Copy",0,1,'R');
	$pdf->Cell(0,5,'Republic of the Philippines',0,1,'C');
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(0,5,'Department of Education',0,1,'C');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'Region IX, Zamboanga Peninsula',0,1,'C');
	$pdf->Cell(0,5,'DIVISION OF DIPOLOG CITY',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(0,5,'',0,1);
	$pdf->SetFont('Arial','I',14);
	$pdf->Cell(0,5,'VEHICLE REQUEST FORM',0,1,'C');
	$vehicle=mysqli_query($con,"SELECT * FROM tbl_vehicle_reservation INNER JOIN tbl_vehicle ON tbl_vehicle_reservation.VehicleCode = tbl_vehicle.VehicleCode WHERE tbl_vehicle_reservation.No='".$_GET['No']."' LIMIT 1") or die("Table Error");
	$rowvh=mysqli_fetch_assoc($vehicle);
	$daterequest=date('M j\, Y', strtotime($rowvh['RequestDate']));
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(30,6,'1. Date:',0,0);
	$pdf->Cell(60,6,$daterequest,0,0);
	$pdf->Cell(20,6,"Time out:",0,0);
	$pdf->Cell(30,6,$rowvh['RequestTimeOUT'],0,0);
	$pdf->Cell(20,6,"Time in:",0,0);
	$pdf->Cell(30,6,"",0,1);
	$pdf->Cell(30,6,'2. Driver:',0,0);
	$pdf->Cell(50,6,$rowvh['Driver'],0,1);
	$pdf->Cell(30,6,'3. Vehicle:',0,0);
	$pdf->Cell(50,6,$rowvh['Vehicle_Description'],0,0);
	$pdf->Cell(30,6,'Plate Number:',0,0);
	$pdf->Cell(30,6,$rowvh['PlateNo'],0,1);
	$pdf->Cell(30,6,'4. Destination:',0,0);
	$pdf->Cell(0,6,$rowvh['RequestDestination'],0,1);
	$pdf->Cell(30,6,'5. Passenger(s):',0,0);
	$pdf->Cell(0,6,$rowvh['RequestPassenger'],0,1);
	$pdf->Cell(30,6,'6. Purpose(s):',0,0);
	$pdf->Write(6,$rowvh['RequestPurposed']);
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(0,0,'',1,1,'C');
	
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(100,5,'Requested by:',0,0);
	$pdf->Cell(0,5,'Approved by:',0,1);
	$pdf->Cell(0,5,'',0,1,'C');
	$pdf->Cell(20,5,'',0,0);
	$pdf->Cell(100,5,$rowvh['Requestedby'],0,0);
	$pdf->Cell(0,5,'DANNY B. CORDOVA, Ed.D., CESO VI',0,1,'C');
	$pdf->Cell(120,5,'',0,0);
	$pdf->Cell(0,5,'Schools Division Superintendent',0,1,'C');
   
	
   
	//Display the Output data
	$pdf->Output();
?>