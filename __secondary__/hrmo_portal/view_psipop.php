<?php
session_start();
include("../vendor/jquery/function.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
     
	 <META name='author' content='Marlon E. Caduyac'>
    <META http-equiv='Content-Type' content='text/html; charset=windows-1252'>
	<META HTTP-EQUIV='expires' CONTENT='FRI, 13 MAR 2020 12:00:00 GMT'>
    <META HTTP-EQUIV='Pragma' CONTENT='no-cache'>
    <META HTTP-EQUIV='Cache-Control' CONTENT='no-cache'>
    <META http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="DepEd Pagadian">

    <title>PCDMIS</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <?php
			   include("tagline.php");
			   ?>
            </div>
			
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <?php
				include("header-menu.php")
				?>
                <!-- /.dropdown -->
            </ul>
			
			    <!-- /.navbar-top-links -->

        </nav>

              <div class="pagecontent container-fluid">	
				<div class="panel panel-default">
				<div class="panel-heading">
				  <a href="index.php" style="cursor:pointer;float:right;padding:4px;" class="btn btn-primary">HOME</a>  
				  <!--	<a href="" style="cursor:pointer;float:right;" data-toggle="modal" data-target="#mySched" class="btn btn-primary">UPLOAD</a>-->

					<span class="label label-default pull-right"></span>
					 <p>PERSONAL SERVICES ITEMIZATION AND PLANTILLA OF PERSONNEL (PSIPOP)</p> 
				   </div>
				   <div class="form-group" style="margin: 20px 0; vertical-align: top;overflow-x:auto;">
               <table width="100%" class="table table-bordered">
			<tr>
				<th colspan="9" rowspan="1">Department: Department of Education</th>
				<th colspan="8" rowspan="1">Bureau/Agency: Office of the Secretary</th>
			</tr>
			<tr>
				<th rowspan="2">ITEM NUMBER</th>
				<th rowspan="2">POSITION TITLE and<br/> SALARY GRADE</th>
				<th colspan="2">ANNUAL SALARY</th>
				<th rowspan="2">S<br/>
					T<br/>
					E<br/>
					P</th>
				<th colspan="2">AREA</th>
				<th rowspan="2">L<br/>E<br/>V<br/>E<br/>L</th>
				<th rowspan="2">P/P/A <br/>ATTRIBUTION</th>
				<th rowspan="2">NAME OF INCUMBENT</th>
				<th rowspan="2">SEX</th>
				<th rowspan="2">DATE <br/>OF <br/>BIRTH</th>
				<th rowspan="2">TIN</th>
				<th rowspan="2">DATE OF <br/>ORIGINAL<br/> APPOINTMENT</th>
				<th rowspan="2">DATE OF<br/>LAST<br/>PROMOTION</th>
				<th rowspan="2">S<br/>
					T<br/>
					A<br/>
					T<br/>
					U<br/>
					S</th>
					<th rowspan="2">CIVIL<br/>SERVICE<br/>ELIGIBILITY</th>
			</tr>
		  <tr>
			<th>AUTHORIZED</th>
			<th>ACTUAL</th>
			<th>C<br/>O<br/>D<br/>E</th>
			<th>T<br/>Y<br/>P<br/>E</th>
		  </tr>
		  <?php
		  $result=mysqli_query($con,"SELECT * FROM psipop INNER JOIN tbl_employee ON psipop.TIN = tbl_employee.Emp_TIN INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position =tbl_job.Job_code ORDER BY tbl_employee.Emp_LName Asc")or die("PSIPOP query error");
		  while($row=mysqli_fetch_array($result))
			{
				$tdata=mb_strimwidth($row['Emp_Sex'],0,1);
				$stat=mb_strimwidth($row['Job_status'],0,1);
				echo '<tr>
						<td>'.$row['Item_Number'].'</td>
						<td>'.$row['Job_description'].' and SG-'.$row['Salary_Grade'].'</td>
						<td style="text-align:right;">'.number_format($row['Autorized'],2).'</td>
						<td style="text-align:right;">'.number_format($row['Actual'],2).'</td>
						<td>'.$row['Step'].'</td>
						<td>'.$row['Code'].'</td>
						<td>'.$row['Type'].'</td>
						<td>'.$row['Level'].'</td>
						<td>'.$row['Attribute'].'</td>
						<td>'.utf8_encode($row['Emp_LName'].', '.$row['Emp_FName']).'</td>
						<td>'.$tdata.'</td>
						<td>'.$row['Emp_Month'].'/'.$row['Emp_Day'].'/'.$row['Emp_Year'].'</td>
						<td>'.$row['TIN'].'</td>
						<td>'.$row['Emp_DOA'].'</td>
						<td>'.$row['Date_promoted'].'</td>
						<td>'.$stat.'</td>
						<td>'.$row['Elegibility'].'</td>
					 </tr>';
			}
		  ?>
		  </table>   		
						
					
					
               
            </div>
         </div>
       </div>
      </div>
         
        
            
    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>
</html>
