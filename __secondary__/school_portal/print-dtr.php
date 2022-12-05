<?php
session_start();
include_once("../../pcdmis/vendor/jquery/function.php");
$gmonth=mb_strimwidth($_POST['date_from'],5,2);
$gmon=mb_strimwidth($_POST['date_from'],5,2);
$gdate=mb_strimwidth($_POST['date_to'],8,2);
$gYear=mb_strimwidth($_POST['date_to'],0,4);


if ($gmonth=='1' || $gmonth=='01')
{
$gmonth='January';	
}
elseif ($gmonth=='2' || $gmonth=='02')
{
$gmonth='Febuary';		
}
elseif ($gmonth=='3' || $gmonth=='03')
{
$gmonth='March';		
}
elseif ($gmonth=='4' || $gmonth=='04')
{
$gmonth='April';		
}
elseif ($gmonth=='5' || $gmonth=='05')
{
$gmonth='May';		
}
elseif ($gmonth=='6' || $gmonth=='06')
{
$gmonth='June';		
}
elseif ($gmonth=='7' || $gmonth=='07')
{
$gmonth='July';		
}
elseif ($gmonth=='8' || $gmonth=='08')
{
$gmonth='August';		
}
elseif ($gmonth=='9' || $gmonth=='09')
{
$gmonth='September';		
}elseif ($gmonth=='10')
{
$gmonth='October';		
}
elseif ($gmonth=='11')
{
$gmonth='November';		
}
elseif ($gmonth=='12')
{
$gmonth='December';		
}


require('../../pcdmis/code128.php');
$pdf=new PDF_Code128('L','mm','Legal');



//set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';
    include "qrlib.php";  

	$img1='../../pcdmis/shs/h1.png';	
	$img2='../../pcdmis/logo/logo.png';
	
	//Add New Page
	$pdf->AliasNbPages('{pages}');
	$pdf->AddPage();
	$pdf->SetFont('Arial','',8);

	
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
     $finame = $PNG_TEMP_DIR.$_SESSION['per_id'].'.png';
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 5;
   $_REQUEST['data']=$_SESSION['per_id'];
    if (isset($_REQUEST['data'])) {        
        // user data
        $finame = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $finame, $errorCorrectionLevel, $matrixPointSize, 2);    
    } else {    
        QRcode::png('PHP QR Code :)', $finame, $errorCorrectionLevel, $matrixPointSize, 2);    
    }    






$img3=$PNG_WEB_DIR.basename($finame);

//Display Images
$pdf->Image($img1,70,15,8);
$pdf->Image($img1,160,15,8);
$pdf->Image($img1,250,15,8);
$pdf->Image($img1,340,15,8);

//Next collunm
$pdf->Image($img2,15,15,7);
$pdf->Image($img2,105,15,7);
$pdf->Image($img2,195,15,7);
$pdf->Image($img2,285,15,7);

//Next collunm
$pdf->Image($img3,10,195,10);
$pdf->Image($img3,100,195,10);
$pdf->Image($img3,190,195,10);
$pdf->Image($img3,280,195,10);

//Header Information
	$pdf->Cell(75,3,'Republic of the Philippines',0,0,'C');
	$pdf->Cell(15,3,'',0,0,'C');
	$pdf->Cell(75,3,'Republic of the Philippines',0,0,'C');
	$pdf->Cell(15,3,'',0,0,'C');
	$pdf->Cell(75,3,'Republic of the Philippines',0,0,'C');
	$pdf->Cell(15,3,'',0,0,'C');
	$pdf->Cell(75,3,'Republic of the Philippines',0,1,'C');
	
	
	$pdf->Cell(75,3,'Department of Education',0,0,'C');
	$pdf->Cell(15,3,'',0,0,'C');
	$pdf->Cell(75,3,'Department of Education',0,0,'C');
	$pdf->Cell(15,3,'',0,0,'C');
	$pdf->Cell(75,3,'Department of Education',0,0,'C');
	$pdf->Cell(15,3,'',0,0,'C');
	$pdf->Cell(75,3,'Department of Education',0,1,'C');
	
	$pdf->Cell(75,3,'Region IX, Zamboanga Peninsula',0,0,'C');
	$pdf->Cell(15,3,'',0,0,'C');
	$pdf->Cell(75,3,'Region IX, Zamboanga Peninsula',0,0,'C');
	$pdf->Cell(15,3,'',0,0,'C');
	$pdf->Cell(75,3,'Region IX, Zamboanga Peninsula',0,0,'C');
	$pdf->Cell(15,3,'',0,0,'C');
	$pdf->Cell(75,3,'Region IX, Zamboanga Peninsula',0,1,'C');
	
	$pdf->Cell(75,3,'DIVISION OF PAGADIAN CITY',0,0,'C');
	$pdf->Cell(15,3,'',0,0,'C');
	$pdf->Cell(75,3,'DIVISION OF PAGADIAN CITY',0,0,'C');
	$pdf->Cell(15,3,'',0,0,'C');
	$pdf->Cell(75,3,'DIVISION OF PAGADIAN CITY',0,0,'C');
	$pdf->Cell(15,3,'',0,0,'C');
	$pdf->Cell(75,3,'DIVISION OF PAGADIAN CITY',0,1,'C');
	
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(75,3,'Pagadian City',0,0,'C');
	$pdf->Cell(15,3,'',0,0,'C');
	$pdf->Cell(75,3,'Pagadian City',0,0,'C');
	$pdf->Cell(15,3,'',0,0,'C');
	$pdf->Cell(75,3,'Pagadian City',0,0,'C');
	$pdf->Cell(15,3,'',0,0,'C');
	$pdf->Cell(75,3,'Pagadian City',0,1,'C');
	
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(75,3,'DAILY TIME RECORD',0,0,'C');
	$pdf->Cell(15,3,'',0,0,'C');
	$pdf->Cell(75,3,'DAILY TIME RECORD',0,0,'C');
	$pdf->Cell(15,3,'',0,0,'C');
	$pdf->Cell(75,3,'DAILY TIME RECORD',0,0,'C');
	$pdf->Cell(15,3,'',0,0,'C');
	$pdf->Cell(75,3,'DAILY TIME RECORD',0,1,'C');
	
	$myname=mysqli_query($con,"SELECT * FROM tbl_employee WHERE Emp_ID='".$_SESSION['per_id']."' AND Emp_Status = 'Active'  LIMIT 1");
	$myinfo=mysqli_fetch_assoc($myname); 
	$mname=mb_strimwidth($myinfo['Emp_MName'],0,1);
	
	$pdf->Cell(74,3,$myinfo['Emp_FName'].' '.$mname.'. '.$myinfo['Emp_LName'],0,0,'C');
	$pdf->Cell(19,0,'',0,0,'C');
	$pdf->Cell(70,3,$myinfo['Emp_FName'].' '.$mname.'. '.$myinfo['Emp_LName'],0,0,'C');
	$pdf->Cell(20,0,'',0,0,'C');
	$pdf->Cell(70,3,$myinfo['Emp_FName'].' '.$mname.'. '.$myinfo['Emp_LName'],0,0,'C');
	$pdf->Cell(20,0,'',0,0,'C');
	$pdf->Cell(70,3,$myinfo['Emp_FName'].' '.$mname.'. '.$myinfo['Emp_LName'],0,1,'C');
	
	//Next Line
	$pdf->Cell(20,0,'',0,0,'C');
	$pdf->Cell(34,0,'',1,0,'C');
	
	//Next Line
	$pdf->Cell(55,0,'',0,0,'C');
	$pdf->Cell(34,0,'',1,0,'C');
	
	//Next Line
	$pdf->Cell(60,0,'',0,0,'C');
	$pdf->Cell(34,0,'',1,0,'C');
	
	//Next Line
	$pdf->Cell(55,0,'',0,0,'C');
	$pdf->Cell(34,0,'',1,1,'C');
	
	$pdf->SetFont('Arial','i',8);
	$pdf->Cell(70,4,'(Name)',0,0,'C');
	
	$pdf->Cell(20,4,'',0,0,'C');
	$pdf->Cell(70,4,'(Name)',0,0,'C');
	
	$pdf->Cell(20,4,'',0,0,'C');
	$pdf->Cell(70,4,'(Name)',0,0,'C');
	
	$pdf->Cell(20,4,'',0,0,'C');
	$pdf->Cell(70,4,'(Name)',0,1,'C');
	
	
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(20,4,'For the Month: ',0,0);
	$pdf->Cell(70,4,$gmonth.' 1 - '.$gdate.' , '.$gYear,0,0);
	
	$pdf->Cell(20,4,'For the Month: ',0,0);
	$pdf->Cell(70,4,$gmonth.' 1 - '.$gdate.' , '.$gYear,0,0);
	
	$pdf->Cell(20,4,'For the Month: ',0,0);
	$pdf->Cell(70,4,$gmonth.' 1 - '.$gdate.' , '.$gYear,0,0);
	
	$pdf->Cell(20,4,'For the Month: ',0,0);
	$pdf->Cell(70,4,$gmonth.' 1 - '.$gdate.' , '.$gYear,0,1);
	
	
	
	
	$pdf->Cell(89.3,4,'Office hour for arrival       Regular days ________',0,0);
	$pdf->Cell(90,4,'Office hour for arrival       Regular days ________',0,0);
	$pdf->Cell(90,4,'Office hour for arrival       Regular days ________',0,0);
	$pdf->Cell(90,4,'Office hour for arrival       Regular days ________',0,1);
	
	$pdf->Cell(90,4,'and departure                     Saturdays ________',0,0);
	$pdf->Cell(90,4,'and departure                     Saturdays ________',0,0);
	$pdf->Cell(90,4,'and departure                     Saturdays ________',0,0);
	$pdf->Cell(90,4,'and departure                     Saturdays ________',0,1);
	
	$pdf->SetFont('Arial','',6);
	
	
	//First column
	$pdf->Cell(10,8,'Day',1,0,'C');
	$pdf->Cell(22,4,'A.M',1,0,'C');
	$pdf->Cell(22,4,'P.M',1,0,'C');
	$pdf->Cell(22,4,'Undertime',1,0,'C');
	
	//second column
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,8,'Day',1,0,'C');
	$pdf->Cell(22,4,'A.M',1,0,'C');
	$pdf->Cell(22,4,'P.M',1,0,'C');
	$pdf->Cell(22,4,'Undertime',1,0,'C');
	
	//Third column
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,8,'Day',1,0,'C');
	$pdf->Cell(22,4,'A.M',1,0,'C');
	$pdf->Cell(22,4,'P.M',1,0,'C');
	$pdf->Cell(22,4,'Undertime',1,0,'C');
	
	//Fourth column
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,8,'Day',1,0,'C');
	$pdf->Cell(22,4,'A.M',1,0,'C');
	$pdf->Cell(22,4,'P.M',1,0,'C');
	$pdf->Cell(22,4,'Undertime',1,1,'C');
	
	//First column
	$pdf->Cell(10,4,'',0,0,'C');
	$pdf->Cell(11,4,'Arrival',1,0,'C');
	$pdf->Cell(11,4,'Departure',1,0,'C');
	$pdf->Cell(11,4,'Arrival',1,0,'C');
	$pdf->Cell(11,4,'Departure',1,0,'C');
	$pdf->Cell(11,4,'Hours',1,0,'C');
	$pdf->Cell(11,4,'Minutes',1,0,'C');
	
	//second column
	$pdf->Cell(22,4,'',0,0,'C');
	$pdf->Cell(11,4,'Arrival',1,0,'C');
	$pdf->Cell(11,4,'Departure',1,0,'C');
	$pdf->Cell(11,4,'Arrival',1,0,'C');
	$pdf->Cell(11,4,'Departure',1,0,'C');
	$pdf->Cell(11,4,'Hours',1,0,'C');
	$pdf->Cell(11,4,'Minutes',1,0,'C');
	
	//third column
	$pdf->Cell(22,4,'',0,0,'C');
	$pdf->Cell(11,4,'Arrival',1,0,'C');
	$pdf->Cell(11,4,'Departure',1,0,'C');
	$pdf->Cell(11,4,'Arrival',1,0,'C');
	$pdf->Cell(11,4,'Departure',1,0,'C');
	$pdf->Cell(11,4,'Hours',1,0,'C');
	$pdf->Cell(11,4,'Minutes',1,0,'C');
	
	//Fourth column
	$pdf->Cell(22,4,'',0,0,'C');
	$pdf->Cell(11,4,'Arrival',1,0,'C');
	$pdf->Cell(11,4,'Departure',1,0,'C');
	$pdf->Cell(11,4,'Arrival',1,0,'C');
	$pdf->Cell(11,4,'Departure',1,0,'C');
	$pdf->Cell(11,4,'Hours',1,0,'C');
	$pdf->Cell(11,4,'Minutes',1,1,'C');
	
	
	//Data started
	$myinfoDTR=mysqli_query($con,"SELECT * FROM tbl_dtr WHERE tbl_dtr.DTRDate BETWEEN '".$_POST['date_from']."' AND '".$_POST['date_to']."' AND tbl_dtr.Emp_ID='".$_SESSION['per_id']."' ORDER By DTRDate Asc");
	$days=mysqli_num_rows($myinfoDTR);
	if (mysqli_num_rows($myinfoDTR)==0)
	{
	$mydate=1;
	//First row
	
	while($mydate<=31)
	{
	$tempDate = $gYear.'-'.$gmon.'-'.$mydate;
	$days=date('l',strtotime($tempDate));
	$myday=mb_strimwidth($days,0,3);
	
	if ($days=='Saturday')
	{
	$pdf->Cell(10,3.5,$mydate.'('.$myday.')',1,0);
	$pdf->Cell(44,3.5,'SATURDAY',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');	
		
	}elseif ($days=='Sunday')
	{
	$pdf->Cell(10,3.5,$mydate.'('.$myday.')',1,0);
	$pdf->Cell(44,3.5,'SUNDAY',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');	
		
	}else{
	$pdf->Cell(10,3.5,$mydate.'('.$myday.')',1,0);
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');	
	}
	
	//Second Form
	if ($days=='Saturday')
	{
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,$mydate.'('.$myday.')',1,0);
	$pdf->Cell(44,3.5,'SATURDAY',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');	
		
	}elseif ($days=='Sunday')
	{
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,$mydate.'('.$myday.')',1,0);
	$pdf->Cell(44,3.5,'SUNDAY',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');	
		
	}else{
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,$mydate.'('.$myday.')',1,0);
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	}
	
	//Third Form
	if ($days=='Saturday')
	{
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,$mydate.'('.$myday.')',1,0);
	$pdf->Cell(44,3.5,'SATURDAY',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');	
		
	}elseif ($days=='Sunday')
	{
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,$mydate.'('.$myday.')',1,0);
	$pdf->Cell(44,3.5,'SUNDAY',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');	
	}else{	
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,$mydate.'('.$myday.')',1,0);
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	}
	//Fourth Form
	if ($days=='Saturday')
	{
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,$mydate.'('.$myday.')',1,0);
	$pdf->Cell(44,3.5,'SATURDAY',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,1,'C');	
		
	}elseif ($days=='Sunday')
	{
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,$mydate.'('.$myday.')',1,0);
	$pdf->Cell(44,3.5,'SUNDAY',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,1,'C');	
	}else{	
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,$mydate.'('.$myday.')',1,0);
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,1,'C');
	}
	$mydate++;
	}
	
	}else{
	$no=0;
	
	while($row=mysqli_fetch_array($myinfoDTR))
	{
		$no++;
	$myyear=mb_strimwidth($row['DTRDate'],8,2);
	while ($myyear>$no)
	{
		$tempDate = $gYear.'-'.$gmon.'-'.$no;
		$days=date('l',strtotime($tempDate));
		$myday=mb_strimwidth($days,0,3);
		if($no<10)
		{	
		//First Form
		if ($days=='Saturday')
	{
	$pdf->Cell(10,3.5,$no.'('.$myday.')',1,0);
	$pdf->Cell(44,3.5,'SATURDAY',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');	
		
	}elseif ($days=='Sunday')
	{
	$pdf->Cell(10,3.5,$no.'('.$myday.')',1,0);
	$pdf->Cell(44,3.5,'SUNDAY',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');	
		
	}else{
		$pdf->Cell(10,3.5,'0'.$no.'('.$myday.')',1,0);
		$pdf->Cell(11,3.5,'',1,0,'C');
		$pdf->Cell(11,3.5,'',1,0,'C');
		$pdf->Cell(11,3.5,'',1,0,'C');
		$pdf->Cell(11,3.5,'',1,0,'C');
		$pdf->Cell(11,3.5,'',1,0,'C');
		$pdf->Cell(11,3.5,'',1,0,'C');
	}
		
		//Second Form
		if ($days=='Saturday')
	{
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,$no.'('.$myday.')',1,0);
	$pdf->Cell(44,3.5,'SATURDAY',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');	
		
	}elseif ($days=='Sunday')
	{
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,$no.'('.$myday.')',1,0);
	$pdf->Cell(44,3.5,'SUNDAY',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');	
		
	}else{
		$pdf->Cell(12,4,'',0,0,'C');
		$pdf->Cell(10,3.5,'0'.$no.'('.$myday.')',1,0);
		$pdf->Cell(11,3.5,'',1,0,'C');
		$pdf->Cell(11,3.5,'',1,0,'C');
		$pdf->Cell(11,3.5,'',1,0,'C');
		$pdf->Cell(11,3.5,'',1,0,'C');
		$pdf->Cell(11,3.5,'',1,0,'C');
		$pdf->Cell(11,3.5,'',1,0,'C');
	}
		//Third Form
		if ($days=='Saturday')
	{
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,$no.'('.$myday.')',1,0);
	$pdf->Cell(44,3.5,'SATURDAY',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');	
		
	}elseif ($days=='Sunday')
	{
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,$no.'('.$myday.')',1,0);
	$pdf->Cell(44,3.5,'SUNDAY',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');	
		
	}else{
		$pdf->Cell(12,4,'',0,0,'C');
		$pdf->Cell(10,3.5,'0'.$no.'('.$myday.')',1,0);
		$pdf->Cell(11,3.5,'',1,0,'C');
		$pdf->Cell(11,3.5,'',1,0,'C');
		$pdf->Cell(11,3.5,'',1,0,'C');
		$pdf->Cell(11,3.5,'',1,0,'C');
		$pdf->Cell(11,3.5,'',1,0,'C');
		$pdf->Cell(11,3.5,'',1,0,'C');
	}
		//Fourth Form
		if ($days=='Saturday')
	{
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,$no.'('.$myday.')',1,0);
	$pdf->Cell(44,3.5,'SATURDAY',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,1,'C');	
		
	}elseif ($days=='Sunday')
	{
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,$no.'('.$myday.')',1,0);
	$pdf->Cell(44,3.5,'SUNDAY',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,1,'C');	
		
	}else{
		$pdf->Cell(12,4,'',0,0,'C');
		$pdf->Cell(10,3.5,'0'.$no.'('.$myday.')',1,0);
		$pdf->Cell(11,3.5,'',1,0,'C');
		$pdf->Cell(11,3.5,'',1,0,'C');
		$pdf->Cell(11,3.5,'',1,0,'C');
		$pdf->Cell(11,3.5,'',1,0,'C');
		$pdf->Cell(11,3.5,'',1,0,'C');
		$pdf->Cell(11,3.5,'',1,1,'C');
	}
		}else{
			//First Form
			if ($days=='Saturday')
				{
				$pdf->Cell(10,3.5,$no.'('.$myday.')',1,0);
				$pdf->Cell(44,3.5,'SATURDAY',1,0,'C');
				$pdf->Cell(11,3.5,'',1,0,'C');
				$pdf->Cell(11,3.5,'',1,0,'C');	
					
				}elseif ($days=='Sunday')
				{
				$pdf->Cell(10,3.5,$no.'('.$myday.')',1,0);
				$pdf->Cell(44,3.5,'SUNDAY',1,0,'C');
				$pdf->Cell(11,3.5,'',1,0,'C');
				$pdf->Cell(11,3.5,'',1,0,'C');	
					
				}else{
			$pdf->Cell(10,3.5,$no.'('.$myday.')',1,0);
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');	
				}
			//Second Form
			if ($days=='Saturday')
			{
			$pdf->Cell(12,4,'',0,0,'C');
			$pdf->Cell(10,3.5,$no.'('.$myday.')',1,0);
			$pdf->Cell(44,3.5,'SATURDAY',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');	
				
			}elseif ($days=='Sunday')
			{
			$pdf->Cell(12,4,'',0,0,'C');
			$pdf->Cell(10,3.5,$no.'('.$myday.')',1,0);
			$pdf->Cell(44,3.5,'SUNDAY',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');	
				
			}else{
			$pdf->Cell(12,4,'',0,0,'C');
			$pdf->Cell(10,3.5,$no.'('.$myday.')',1,0);
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			}
			//Third Form
			if ($days=='Saturday')
			{
			$pdf->Cell(12,4,'',0,0,'C');
			$pdf->Cell(10,3.5,$no.'('.$myday.')',1,0);
			$pdf->Cell(44,3.5,'SATURDAY',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');	
				
			}elseif ($days=='Sunday')
			{
			$pdf->Cell(12,4,'',0,0,'C');
			$pdf->Cell(10,3.5,$no.'('.$myday.')',1,0);
			$pdf->Cell(44,3.5,'SUNDAY',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');	
				
			}else{
			$pdf->Cell(12,4,'',0,0,'C');
			$pdf->Cell(10,3.5,$no.'('.$myday.')',1,0);
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			}
			//Fourth Form
			if ($days=='Saturday')
				{
				$pdf->Cell(12,4,'',0,0,'C');
				$pdf->Cell(10,3.5,$no.'('.$myday.')',1,0);
				$pdf->Cell(44,3.5,'SATURDAY',1,0,'C');
				$pdf->Cell(11,3.5,'',1,0,'C');
				$pdf->Cell(11,3.5,'',1,1,'C');	
					
				}elseif ($days=='Sunday')
				{
				$pdf->Cell(12,4,'',0,0,'C');
				$pdf->Cell(10,3.5,$no.'('.$myday.')',1,0);
				$pdf->Cell(44,3.5,'SUNDAY',1,0,'C');
				$pdf->Cell(11,3.5,'',1,0,'C');
				$pdf->Cell(11,3.5,'',1,1,'C');	
					
				}else{
			$pdf->Cell(12,4,'',0,0,'C');
			$pdf->Cell(10,3.5,$no.'('.$myday.')',1,0);
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,0,'C');
			$pdf->Cell(11,3.5,'',1,1,'C');
				}
			}
	$no++;
	}
	//First Line
	$myday=mb_strimwidth($row['MyDays'],0,3);
	
	$pdf->Cell(10,3.5,$myyear.'('.$myday.')',1,0);
	
	if($row['TimeINAM']=="00:00:00")
	{
		$pdf->Cell(11,3.5,'',1,0,'C');	
	}else{
		$pdf->Cell(11,3.5,$row['TimeINAM'],1,0,'C');
	}
	if ($row['TimeOUTAM']=="00:00:00")
	{
		$pdf->Cell(11,3.5,'',1,0,'C');
	}else{
		$pdf->Cell(11,3.5,$row['TimeOUTAM'],1,0,'C');
	}
	if ($row['TimeINPM']=="00:00:00")
	{
		$pdf->Cell(11,3.5,'',1,0,'C');
	}else{
	$pdf->Cell(11,3.5,$row['TimeINPM'],1,0,'C');
	}
	if ($row['TimeOUTPM']=="00:00:00")
	{
		$pdf->Cell(11,3.5,'',1,0,'C');
	}else{
	$pdf->Cell(11,3.5,$row['TimeOUTPM'],1,0,'C');
	}
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');
	
	
	
	//Second Form
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,$myyear.'('.$myday.')',1,0);
	if($row['TimeINAM']=="00:00:00")
	{
		$pdf->Cell(11,3.5,'',1,0,'C');	
	}else{
		$pdf->Cell(11,3.5,$row['TimeINAM'],1,0,'C');
	}
	if ($row['TimeOUTAM']=="00:00:00")
	{
		$pdf->Cell(11,3.5,'',1,0,'C');
	}else{
		$pdf->Cell(11,3.5,$row['TimeOUTAM'],1,0,'C');
	}
	if ($row['TimeINPM']=="00:00:00")
	{
		$pdf->Cell(11,3.5,'',1,0,'C');
	}else{
	$pdf->Cell(11,3.5,$row['TimeINPM'],1,0,'C');
	}
	if ($row['TimeOUTPM']=="00:00:00")
	{
		$pdf->Cell(11,3.5,'',1,0,'C');
	}else{
	$pdf->Cell(11,3.5,$row['TimeOUTPM'],1,0,'C');
	}
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');	
	
	
	//Third Form
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,$myyear.'('.$myday.')',1,0);
	if($row['TimeINAM']=="00:00:00")
	{
		$pdf->Cell(11,3.5,'',1,0,'C');	
	}else{
		$pdf->Cell(11,3.5,$row['TimeINAM'],1,0,'C');
	}
	if ($row['TimeOUTAM']=="00:00:00")
	{
		$pdf->Cell(11,3.5,'',1,0,'C');
	}else{
		$pdf->Cell(11,3.5,$row['TimeOUTAM'],1,0,'C');
	}
	if ($row['TimeINPM']=="00:00:00")
	{
		$pdf->Cell(11,3.5,'',1,0,'C');
	}else{
	$pdf->Cell(11,3.5,$row['TimeINPM'],1,0,'C');
	}
	if ($row['TimeOUTPM']=="00:00:00")
	{
		$pdf->Cell(11,3.5,'',1,0,'C');
	}else{
	$pdf->Cell(11,3.5,$row['TimeOUTPM'],1,0,'C');
	}
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,0,'C');	

	//Fourth Form
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,$myyear.'('.$myday.')',1,0);
	if($row['TimeINAM']=="00:00:00")
	{
		$pdf->Cell(11,3.5,'',1,0,'C');	
	}else{
		$pdf->Cell(11,3.5,$row['TimeINAM'],1,0,'C');
	}
	if ($row['TimeOUTAM']=="00:00:00")
	{
		$pdf->Cell(11,3.5,'',1,0,'C');
	}else{
		$pdf->Cell(11,3.5,$row['TimeOUTAM'],1,0,'C');
	}
	if ($row['TimeINPM']=="00:00:00")
	{
		$pdf->Cell(11,3.5,'',1,0,'C');
	}else{
	$pdf->Cell(11,3.5,$row['TimeINPM'],1,0,'C');
	}
	if ($row['TimeOUTPM']=="00:00:00")
	{
		$pdf->Cell(11,3.5,'',1,0,'C');
	}else{
	$pdf->Cell(11,3.5,$row['TimeOUTPM'],1,0,'C');
	}
	
	$pdf->Cell(11,3.5,'',1,0,'C');
	$pdf->Cell(11,3.5,'',1,1,'C');
	
	}//Last Data
	
		while($myyear<$gdate)
			{
				$myyear++;	
				$tempDate = $gYear.'-'.$gmon.'-'.$myyear;
				$days=date('l',strtotime($tempDate));
				$myday=mb_strimwidth($days,0,3);
				if ($myyear<10)
				{
					//First Form
					if ($days=='Saturday')
						{
						$pdf->Cell(10,3.5,'0'.$myyear.'('.$myday.')',1,0);
						$pdf->Cell(44,3.5,'SATURDAY',1,0,'C');
						$pdf->Cell(11,3.5,'',1,0,'C');
						$pdf->Cell(11,3.5,'',1,0,'C');	
							
						}elseif ($days=='Sunday')
						{
						$pdf->Cell(10,3.5,'0'.$myyear.'('.$myday.')',1,0);
						$pdf->Cell(44,3.5,'SUNDAY',1,0,'C');
						$pdf->Cell(11,3.5,'',1,0,'C');
						$pdf->Cell(11,3.5,'',1,0,'C');	
							
						}else{
					$pdf->Cell(10,3.5,'0'.$myyear.'('.$myday.')',1,0);
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');	
						}					
					//Second Form
					if ($days=='Saturday')
					{
					$pdf->Cell(12,4,'',0,0,'C');
					$pdf->Cell(10,3.5,'0'.$myyear.'('.$myday.')',1,0);
					$pdf->Cell(44,3.5,'SATURDAY',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');	
						
					}elseif ($days=='Sunday')
					{
					$pdf->Cell(12,4,'',0,0,'C');
					$pdf->Cell(10,3.5,'0'.$myyear.'('.$myday.')',1,0);
					$pdf->Cell(44,3.5,'SUNDAY',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');	
						
					}else{
					$pdf->Cell(12,4,'',0,0,'C');
					$pdf->Cell(10,3.5,'0'.$myyear.'('.$myday.')',1,0);
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					}
					//Third Form
					if ($days=='Saturday')
					{
					$pdf->Cell(12,4,'',0,0,'C');
					$pdf->Cell(10,3.5,'0'.$myyear.'('.$myday.')',1,0);
					$pdf->Cell(44,3.5,'SATURDAY',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');	
						
					}elseif ($days=='Sunday')
					{
					$pdf->Cell(12,4,'',0,0,'C');
					$pdf->Cell(10,3.5,'0'.$myyear.'('.$myday.')',1,0);
					$pdf->Cell(44,3.5,'SUNDAY',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');	
						
					}else{
					$pdf->Cell(12,4,'',0,0,'C');
					$pdf->Cell(10,3.5,'0'.$myyear.'('.$myday.')',1,0);
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					}
					//Fourth Form
					if ($days=='Saturday')
					{
					$pdf->Cell(12,4,'',0,0,'C');
					$pdf->Cell(10,3.5,'0'.$myyear.'('.$myday.')',1,0);
					$pdf->Cell(44,3.5,'SATURDAY',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,1,'C');	
						
					}elseif ($days=='Sunday')
					{
					$pdf->Cell(12,4,'',0,0,'C');
					$pdf->Cell(10,3.5,'0'.$myyear.'('.$myday.')',1,0);
					$pdf->Cell(44,3.5,'SUNDAY',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,1,'C');	
						
					}else{
					$pdf->Cell(12,4,'',0,0,'C');
					$pdf->Cell(10,3.5,'0'.$myyear.'('.$myday.')',1,0);
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,1,'C');
					}
				}else{
				//First Form
				if ($days=='Saturday')
						{
						$pdf->Cell(10,3.5,$myyear.'('.$myday.')',1,0);
						$pdf->Cell(44,3.5,'SATURDAY',1,0,'C');
						$pdf->Cell(11,3.5,'',1,0,'C');
						$pdf->Cell(11,3.5,'',1,0,'C');	
							
						}elseif ($days=='Sunday')
						{
						$pdf->Cell(10,3.5,$myyear.'('.$myday.')',1,0);
						$pdf->Cell(44,3.5,'SUNDAY',1,0,'C');
						$pdf->Cell(11,3.5,'',1,0,'C');
						$pdf->Cell(11,3.5,'',1,0,'C');	
							
						}else{
						$pdf->Cell(10,3.5,$myyear.'('.$myday.')',1);
						$pdf->Cell(11,3.5,'',1,0,'C');
						$pdf->Cell(11,3.5,'',1,0,'C');
						$pdf->Cell(11,3.5,'',1,0,'C');
						$pdf->Cell(11,3.5,'',1,0,'C');
						$pdf->Cell(11,3.5,'',1,0,'C');
						$pdf->Cell(11,3.5,'',1,0,'C');	
						}					
					//Second Form
					if ($days=='Saturday')
					{
					$pdf->Cell(12,4,'',0,0,'C');
					$pdf->Cell(10,3.5,$myyear.'('.$myday.')',1,0);
					$pdf->Cell(44,3.5,'SATURDAY',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');	
						
					}elseif ($days=='Sunday')
					{
					$pdf->Cell(12,4,'',0,0,'C');
					$pdf->Cell(10,3.5,$myyear.'('.$myday.')',1,0);
					$pdf->Cell(44,3.5,'SUNDAY',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');	
						
					}else{
					$pdf->Cell(12,4,'',0,0,'C');
					$pdf->Cell(10,3.5,$myyear.'('.$myday.')',1,0);
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					}
					//Third Form
					if ($days=='Saturday')
					{
					$pdf->Cell(12,4,'',0,0,'C');
					$pdf->Cell(10,3.5,$myyear.'('.$myday.')',1,0);
					$pdf->Cell(44,3.5,'SATURDAY',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');	
						
					}elseif ($days=='Sunday')
					{
					$pdf->Cell(12,4,'',0,0,'C');
					$pdf->Cell(10,3.5,$myyear.'('.$myday.')',1,0);
					$pdf->Cell(44,3.5,'SUNDAY',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');	
						
					}else{
					$pdf->Cell(12,4,'',0,0,'C');
					$pdf->Cell(10,3.5,$myyear.'('.$myday.')',1,0);
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					}
					//Fourth Form
					if ($days=='Saturday')
					{
					$pdf->Cell(12,4,'',0,0,'C');
					$pdf->Cell(10,3.5,$myyear.'('.$myday.')',1,0);
					$pdf->Cell(44,3.5,'SATURDAY',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,1,'C');	
						
					}elseif ($days=='Sunday')
					{
					$pdf->Cell(12,4,'',0,0,'C');
					$pdf->Cell(10,3.5,$myyear.'('.$myday.')',1,0);
					$pdf->Cell(44,3.5,'SUNDAY',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,1,'C');	
						
					}else{
					$pdf->Cell(12,4,'',0,0,'C');
					$pdf->Cell(10,3.5,$myyear.'('.$myday.')',1,0);
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,0,'C');
					$pdf->Cell(11,3.5,'',1,1,'C');	
					}
				}
			}
	
	
	}
	
	//Last Data
	/*
	$pdf->Cell(10,3.5,'',0,0);
	$pdf->Cell(44,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,0,'C');
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,'',0,0);
	$pdf->Cell(44,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,0,'C');
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,'',0,0);
	$pdf->Cell(44,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,0,'C');
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,'',0,0);
	$pdf->Cell(44,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,1,'C');
	
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,'',0,0);
	$pdf->Cell(44,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,0,'C');
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,'',0,0);
	$pdf->Cell(44,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,0,'C');
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,'',0,0);
	$pdf->Cell(44,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,0,'C');
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,'',0,0);
	$pdf->Cell(44,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,1,'C');
	
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,'',0,0);
	$pdf->Cell(44,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,0,'C');
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,'',0,0);
	$pdf->Cell(44,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,0,'C');
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,'',0,0);
	$pdf->Cell(44,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,0,'C');
	$pdf->Cell(12,4,'',0,0,'C');
	$pdf->Cell(10,3.5,'',0,0);
	$pdf->Cell(44,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,0,'C');
	$pdf->Cell(11,3.5,'',0,1,'C');*/
	
    $pdf->SetFont('Arial','i',6);	
	
	//First Line info
    $pdf->Cell(0,1,"",0,1);	
	$pdf->Cell(70,3,"I certify on my honor that the above is true and correct report of the hours",0,0);
	
	//Second Line info
	$pdf->Cell(20,3,"",0,0);
	$pdf->Cell(70,3,"I certify on my honor that the above is true and correct report of the hours",0,0);
	
	//Third Line info
	$pdf->Cell(20,3,"",0,0);
	$pdf->Cell(70,3,"I certify on my honor that the above is true and correct report of the hours",0,1);
	
	//First Line info
	$pdf->Cell(70,3,"of work performed, record of which was made daily at the time of arrival ",0,0);
	
	//Second Line info
	$pdf->Cell(20,3,"",0,0);
	$pdf->Cell(70,3,"of work performed, record of which was made daily at the time of arrival ",0,0);
	
	//Third Line info
	$pdf->Cell(20,3,"",0,0);
	$pdf->Cell(70,3,"of work performed, record of which was made daily at the time of arrival ",0,0);
	
	//Fourth Line info
	$pdf->Cell(20,3,"",0,0);
	$pdf->Cell(70,3,"of work performed, record of which was made daily at the time of arrival ",0,1);
	
	//First Line info
	$pdf->Cell(70,3,"and departure from office.",0,0);
	
	//Second Line info
	$pdf->Cell(20,3,"",0,0);
	$pdf->Cell(70,3,"and departure from office.",0,0);
	
	//Third Line info
	$pdf->Cell(20,3,"",0,0);
	$pdf->Cell(70,3,"and departure from office.",0,0);
	
	//Fourth Line info
	$pdf->Cell(20,3,"",0,0);
	$pdf->Cell(70,3,"and departure from office.",0,1);
	
	$pdf->SetFont('Arial','',6);	
	//First Line 
    $pdf->Cell(0,5,"",0,1);
	$pdf->Cell(70,0,"",1,0,'C');
	
	//Second Line
	$pdf->Cell(20,0,"",0,0);
	$pdf->Cell(70,0,"",1,0,'C');
	
	//third Line
	$pdf->Cell(20,0,"",0,0);
	$pdf->Cell(70,0,"",1,0,'C');
	
	//Fourth Line
	$pdf->Cell(20,0,"",0,0);
	$pdf->Cell(70,0,"",1,1,'C');
	
	//First Line
    $pdf->Cell(70,3,"VERIFIED as to the prescribed office hours.",0,0,'C');
    
	//Second Line
	$pdf->Cell(20,3,"",0,0);
    $pdf->Cell(70,3,"VERIFIED as to the prescribed office hours.",0,0,'C');
	
	//Third Line
	$pdf->Cell(20,3,"",0,0);
    $pdf->Cell(70,3,"VERIFIED as to the prescribed office hours.",0,0,'C');
	
	//Fourth Line
	$pdf->Cell(20,3,"",0,0);
    $pdf->Cell(70,3,"VERIFIED as to the prescribed office hours.",0,1,'C');
	
	
	//Signaturies
	$myoffice=mysqli_query($con,"SELECT * FROM tbl_station WHERE Emp_ID ='".$_SESSION['per_id']."' LIMIT 1");
	$myrow=mysqli_fetch_array($myoffice);
	
	//First Line 
	$pdf->Cell(0,5,"",0,1,'C');
    $pdf->Cell(70,3,$_SESSION['Principal'],0,0,'C');
    
	//Second Line 
	$pdf->Cell(20,3,"",0,0,'C');
	$pdf->Cell(70,3,$_SESSION['Principal'],0,0,'C');
	
	//Third Line 
	$pdf->Cell(20,3,"",0,0,'C');
	$pdf->Cell(70,3,$_SESSION['Principal'],0,0,'C');
	
	//Fourth Line 
	$pdf->Cell(20,3,"",0,0,'C');
	$pdf->Cell(70,3,$_SESSION['Principal'],0,1,'C');
	
	
	//First Line 
    $pdf->Cell(0,0,"",0,1);
	$pdf->Cell(70,0,"",1,0,'C');
	
	//Second Line
	$pdf->Cell(20,0,"",0,0);
	$pdf->Cell(70,0,"",1,0,'C');
	
	//third Line
	$pdf->Cell(20,0,"",0,0);
	$pdf->Cell(70,0,"",1,0,'C');
	
	//Fourth Line
	$pdf->Cell(20,0,"",0,0);
	$pdf->Cell(70,0,"",1,1,'C');
	
	//First Line
	if ( $_SESSION['PrinCat']=="TEACHER" ||  $_SESSION['PrinCat']=="Teacher")
	{
		$pdf->Cell(70,3,"Teacher In-charge",0,0,'C');
	}else{
		 $pdf->Cell(70,3,"School Principal",0,0,'C');
	}
	//Second Line 
	$pdf->Cell(20,3,"",0,0,'C');
	
	if ( $_SESSION['PrinCat']=="TEACHER" ||  $_SESSION['PrinCat']=="Teacher")
	{
		$pdf->Cell(70,3,"Teacher In-charge",0,0,'C');
	}else{
		 $pdf->Cell(70,3,"School Principal",0,0,'C');
	}
	//Third Line 
	$pdf->Cell(20,3,"",0,0,'C');
	if ( $_SESSION['PrinCat']=="TEACHER" ||  $_SESSION['PrinCat']=="Teacher")
	{
		$pdf->Cell(70,3,"Teacher In-charge",0,0,'C');
	}else{
		 $pdf->Cell(70,3,"School Principal",0,0,'C');
	}
	//Fourth Line 
	$pdf->Cell(20,3,"",0,0,'C');
	if ( $_SESSION['PrinCat']=="TEACHER" ||  $_SESSION['PrinCat']=="Teacher")
	{
		$pdf->Cell(70,3,"Teacher In-charge",0,0,'C');
	}else{
		 $pdf->Cell(70,3,"School Principal",0,0,'C');
	}
		
	//First Line
    $pdf->Cell(70,3,"(In-charge)",0,0,'C');
	
	//Second Line 
	$pdf->Cell(20,3,"",0,0,'C');
	$pdf->Cell(70,3,"In-charge",0,0,'C');
	
	//Third Line 
	$pdf->Cell(20,3,"",0,0,'C');
	$pdf->Cell(70,3,"In-charge",0,0,'C');
	
	//Fourth Line 
	$pdf->Cell(20,3,"",0,0,'C');
	$pdf->Cell(70,3,"In-charge",0,1,'C');
	
	
//Generate Barcode
//$pdf->Cell(0,2,"",0,1,'C');
$code=$_SESSION['per_id'];
	

$pdf->Code128(22,195,$code,20,10);
$pdf->Code128(112,195,$code,20,10);
$pdf->Code128(203,195,$code,20,10);
$pdf->Code128(295,195,$code,20,10);


//View Output
$pdf->Output();
?>
