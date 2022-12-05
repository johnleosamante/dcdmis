<?php
session_start();
include("../vendor/jquery/function.php");
if($_SESSION['uid']=="")
		{
			header('location:http://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}
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
<link rel="shortcut icon" href="../logo/logo.png">
	
	         
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
		ABBREVIATION
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
                <div class="col-lg-12">
                    <h1 class="page-header"><?php
					  $record=mysqli_query($con,"SELECT * FROM tbl_school WHERE SchoolID ='".$_SESSION['school_id']."' ORDER BY SchoolName Asc") or die ("Profile School Error");
					  $row=mysqli_fetch_assoc($record);
					  echo '<h3 class="media-heading" style="padding:4px;margin:4px;"><i class="fa  fa-map-marker  fa-fw"></i>'.$row['SchoolName'].'- School ID:'.$_SESSION['school_id'].'</h3> <p> 
							  <small class="text-muted" style="padding:4px;margin:4px;">'.$row['Address'].' </small>
							</p>';
					 $_SESSION['EmpID']=$row['Incharg_ID'];
					
					  ?></h1>
					
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
						<a href="#upload_emp" class="btn btn-primary" style="float:right;" data-toggle="modal">Upload Employee</a>
					
							<table style="padding:4px;margin:10px;">
						<?php
							$repre=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE tbl_employee.Emp_ID ='".$_SESSION['EmpID']."'") or die("Table not found!!!");
							$data=mysqli_fetch_assoc($repre);
							
							echo '<img src="'.$data['Picture'].'" width="150" height="150" align="left" style="padding:4px;" id="pic">
							<tr style="text-transform:uppercase;"><td>Employee ID #:</td><td style="color:blue;padding:4px;margin:4px;">'.$_SESSION['EmpID'].'</font></td></tr>
							<tr style="text-transform:uppercase;"><td>Name: </td><td style="color:blue;padding:4px;margin:4px;">'.$data['Emp_LName'].', '.$data['Emp_FName'].'</font></td></tr>
							<tr style="text-transform:uppercase;"><td>Sex: </td><td style="color:blue;padding:4px;margin:4px;">'.$data['Emp_Sex'].'</font></td></tr>
							<tr style="text-transform:uppercase;"><td>Position: </td><td style="color:blue;padding:4px;margin:4px;">'.$data['Job_description'].'</font></td></tr>
							<tr style="text-transform:uppercase;"><td>Contact No.: </td><td style="color:blue;padding:4px;margin:4px;">'.$data['Emp_Cell_No'].'</font></td></tr>';
					
						?>
								</table> 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;">No</th>
										<th>Empyee ID</th>
										<th>Employee Name</th>
										<th>Gender</th>
										<th>Home Address</th>
										<th>Position</th>
										<th>Action</th>
									</tr>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$recstudent=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_station.Emp_ID =tbl_employee.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_school.SchoolID='".$_SESSION['school_id']."' ORDER BY tbl_employee.Emp_LName Asc")or die ("View Teacher All Table not found!");
								$no=0;
									while($row=mysqli_fetch_array($recstudent))
										{
										$no+=1;
										echo '<tr>
												<td style="text-align:center;">'.$no.'</td><td>'.$row['Emp_ID'].'</a></td>
												<td style="text-transform:uppercase;">'.utf8_encode($row['Emp_LName'].', '.$row['Emp_FName']).'</td>
												<td style="text-transform:uppercase;">'.$row['Emp_Sex'].'</td>
												<td style="text-transform:uppercase;">'.$row['Emp_Address'].'</td>
												<td style="text-transform:uppercase;">'.$row['Job_description'].'</td>
												<td class="dropdown">
													
															<a class="dropdown-toggle" data-toggle="dropdown" href="#">
																<i class="fa fa-gear fa-fw"></i> <i class="fa fa-caret-down"></i>
															</a>
															<ul class="dropdown-menu dropdown-user">
																<li><a href="validate.php?EmpID='.$row['Emp_ID'].'"><i class="fa  fa-credit-card  fa-fw"></i> View PDS</a>
																</li>												
																<li><a href="validate.php?sr='.$row['Emp_ID'].'"><i class="fa fa-car  fa-fw"></i> Service Record</a>
																</li>
															</ul>
															
														
													</td></tr>';
										}
										
								?>
								
                                </tbody>
                            </table>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            </div>
           
            
    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

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


<!-- Modal for Re-assign-->
    <div class="modal fade" id="upload_emp" role="dialog" data-backdrop="static" data-keyboard="false">
     <div style="width:400px;height:auto;margin-top:50px;margin-left:auto;margin-right:auto;">
    
        
        <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>Select Excel File to upload</center></h3>
		 
        </div>
        <div class="modal-body">
		<form enctype="multipart/form-data" method="post" role="form" action="upload_employee_record.php">
		 <input type="file" name="file" id="file" size="150" accept=".csv">
        <p class="help-block">Only Excel/CSV File Import.</p>
		
			<button type="submit" class="btn btn-success" name="Import">Upload</button>
			</form>	  
			
			</div>
		</div>
		
		
		      </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign->
