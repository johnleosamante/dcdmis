<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PCDMIS-Subject load</title>
	<link rel="shortcut icon" href="../shs/h1.png">
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
	<style>
		th,td{
			text-align:center;
			text-transform:uppercase;
		}
	</style>
	<script>
{
   document.addEventListener('contextmenu', event => event.preventDefault());
}
   </script> 
</head>

<body>

    <div id="wrapper">

        <!-- Navigation 
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">-->
			<nav class="navbar navbar-default navbar-fixed-top">
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

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                   <?php
				   include("menu.php");
				   ?>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
              <div class="masthead container-fluid">
				<div class="media" style="margin-top: 50px;margin-bottom:10px">
					<div class="col-lg-12" style="padding:10px;">
					<img src="../logo/logo.jpg" width="50" height="50" align="left" style="padding:1px;">
					<label style="padding:0px;margin:0px;font-size:25px;">DEPARTMENT OF EDUCATION</label><br/>
					<small style="padding:0px;margin:0px;font-size:14px;">PAGADIAN CITY DIVISION </small><hr>			
				</div>
			</div>
					</div>
            </div>
							<ul class="nav nav-tabs">
							<?php
							/*$query=mysqli_query($con,"SELECT * FROM tbl_section INNER JOIN tbl_employee ON tbl_section.Emp_ID =tbl_employee.Emp_ID WHERE tbl_section.Emp_ID='".$_SESSION['EmpID']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND tbl_section.SchoolID='".$_SESSION['SchoolID']."'");
                           if (mysqli_num_rows($query)<>0)
						   {
							  $data=mysqli_fetch_assoc($query); 
							  $_SESSION['grade']=$data['Grade'];
							  $_SESSION['SecName']=$data['SecDesc'];
							 */ 
						   echo '<li class="active">
									<a href="#erf" data-toggle="tab"> Subject Load</a>
                                </li>';
								
                           echo '<li>
									<a href="#history" data-toggle="tab"> My Advisory</a>
                                </li>';
								/*
						   }else{
							  echo '<li class="active">
									<a href="#erf" data-toggle="tab"> Subject Load</a>
                                </li>';  
						   }*/	
							?>
							</ul>
			
							<div class="tab-content">
                                <div class="tab-pane fade in active" id="erf">
								<h3 class="page-header">LIST OF SUBJECT</h3>
								<div class="panel-body" style="overflow-x:auto;">
										<table width="100%" class="table table-striped table-bordered table-hover">
													<thead>
														<tr>
															<th rowspan="2">#</th>
															<th rowspan="2">Subject Code</th>
															<th rowspan="2">Discriptive Title</th>
															<th colspan="3">Schedule</th>
															<th rowspan="2"></th>
											
															</tr>
															<tr>
																<th>Time</th>
																<th>Day</th>
																<th>Room</th>
																
															</tr>
										
																</thead>
																<tbody>
																<?php
																$no=0;
																$result=mysqli_query($con,"SELECT * FROM tbl_subject_load INNER JOIN tbl_subject ON tbl_subject_load.SubCode = tbl_subject.SubCode WHERE tbl_subject_load.Emp_ID='".$_SESSION['EmpID']."' AND tbl_subject_load.School_Year='".$_SESSION['year']."'");
																while($row=mysqli_fetch_array($result))
																{
																	$no++;
																	echo '<tr>
																			<td>'.$no.'</td>
																			<td>'.$row['SubCode'].'</td>
																			<td>'.$row['SubDesc'].'</td>
																			<td>'.$row['Sub_Time'].'</td>
																			<td>'.$row['Sub_day'].'</td>
																			<td>'.$row['SecCode'].'</td>
																			<td class="dropdown">
															
																			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
																				<i class="fa fa-gear fa-fw"></i> <i class="fa fa-caret-down"></i>
																			</a>
																			<ul class="dropdown-menu dropdown-user">
																				<li><a href="" ><i class="fa  fa-user  fa-fw"></i> First Quarter</a>
																				</li>
																				<li><a href="" ><i class="fa  fa-user  fa-fw"></i> Second Quarter</a>
																				</li>
																				<li><a href="" ><i class="fa  fa-user  fa-fw"></i> Semestral Final</a>
																				</li>		
																			</ul>
															
														
													</td>
																		</tr>';
																}
																?>
																</tbody>
												</table>
									</div>
								</div>
								
															
								 <div class="tab-pane fade" id="history">
								 <?php
								echo ' <a href="search-lrn.php?link='.sha1("Deped pagadian city data management system v.1.0").'" class="btn btn-primary" style="float:right;">Enrol</a>';	
								if ($_SESSION['grade']=='Nursery' || $_SESSION['grade']=='Kinder 1' || $_SESSION['grade']=='Kinder 2')
								 {
									echo '<h3 class="page-header">'.$_SESSION['grade'].' - '. $_SESSION['SecName'].'  Adviser</h3>'; 
								 }else{
								echo '<h3 class="page-header">Grade '.$_SESSION['grade'].' - '. $_SESSION['SecName'].'  Adviser</h3>'; 
								 }
								 
								 
								?>
								<div class="panel-body" style="overflow-x:auto;">
							
							<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        
                                        <th width="10%">LRN</th>
                                        <th width="10%">Last Name</th>
                                        <th width="10%">First Name</th>
                                        <th width="10%">Middle Name</th>
                                        <th width="10%">Sex</th>
                                        <th width="10%">Birthdate</th>
                                        <th width="10%">Contact #</th>
                                        <th width="7%"></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								if ($_SESSION['grade']=='11' || $_SESSION['grade']=='12')
								{
								if ($_SESSION['Sem']="First Semester")
										{
									
											$secdata=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON first_semester.SecCode =tbl_section.SecCode WHERE first_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND first_semester.SchoolID='".$_SESSION['SchoolID']."'ORDER BY tbl_student.Lname Asc");
												
										}
										
										elseif ($_SESSION['Sem']="Second Semester")
										{
											$secdata=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON second_semester.SecCode =tbl_section.SecCode WHERE second_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."'AND second_semester.SchoolID='".$_SESSION['SchoolID']."' ORDER BY tbl_student.Lname Asc");
										
										}	
								}else{
									$secdata=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn =tbl_student.lrn INNER JOIN tbl_section ON tbl_learners.SecCode =tbl_section.SecCode WHERE tbl_section.Emp_ID='".$_SESSION['EmpID']."' AND tbl_learners.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."'AND tbl_learners.SchoolID='".$_SESSION['SchoolID']."' ORDER BY tbl_student.Lname Asc");
								}	
									while($row_secdata=mysqli_fetch_array($secdata))
									{
									
									echo '<tr>
											
											<td>'.$row_secdata['lrn'].'</td>
											<td>'.utf8_encode($row_secdata['Lname'].'</td>
											<td>'.$row_secdata['FName'].'</td>
											<td>'.$row_secdata['MName']).'</td>
											<td>'.$row_secdata['Gender'].'</td>
											<td>'.$row_secdata['Birthdate'].'</td>
											<td>'.$row_secdata['ContactNo'].'</td>
											<td class="dropdown">
													
															<a class="dropdown-toggle" data-toggle="dropdown" href="#">
																<i class="fa fa-gear fa-fw"></i> <i class="fa fa-caret-down"></i>
															</a>
															<ul class="dropdown-menu dropdown-user">
																<li><a href="#" ><i class="fa fa-user   fa-fw"></i> Profile</a>
																</li>
																<li><a href="#" ><i class="fa fa-list-alt fa-fw"></i> Form 9 (Form 138 A)</a>
																</li>
																<li><a href="#" ><i class="fa fa-comments fa-fw"></i> Form 10 (Form 137 A)</a>
																</li>
															</ul>
															
														
													</td>
									</tr>';
									}	
								?>
								</tbody>
							</table>
							
							
						</div>
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
 <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>
</body>
</html>
