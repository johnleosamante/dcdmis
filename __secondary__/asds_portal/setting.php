<?php
session_start();
include("../vendor/jquery/function.php");
if($_SESSION['uid']=="")
		{
			header('location:http://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}
		$result=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station =tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE tbl_employee.Emp_ID='".$_SESSION['uid']."'");
$row_record=mysqli_fetch_assoc($result);

if (isset($_POST['save']))
{
	mysqli_query($con,"UPDATE tbl_employee SET tbl_employee.Emp_TIN='".$_POST['myTIN']."' WHERE tbl_employee.Emp_ID='".$_SESSION['uid']."' LIMIT 1");
	   header('location:http://'.$_SERVER['HTTP_HOST'].'/pcdmis/asds_portal/setting.php');
}

if (isset($_POST['update']))
	{
		if ($_POST['password']<>$_POST['confirm'])
		{
			?>
			<script>
			{
				alert("Password not match!!");
			}
			</script>
			<?php
		}else{
			$pass=md5($_POST['password']);
			mysqli_query($con,"UPDATE tbl_user SET password='".$pass."' WHERE usercode='".$_SESSION['uid']."' LIMIT 1");
		  header('location:http://'.$_SERVER['HTTP_HOST'].'/pcdmis/asds_portal/setting.php');
	}
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
	
	        
    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>
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

	<style>
	th{
		text-transform:uppercase;
	}
	</style>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
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
				<img src="../logo/logo.png" width="50" height="50" align="left" style="padding:1px;">
				<label style="padding:0px;margin:0px;font-size:25px;">DEPARTMENT OF EDUCATION</label><br/>
				<small style="padding:0px;margin:0px;font-size:14px;">PAGADIAN CITY DIVISION </small>
								
            </div>
			
      </div>
    </div>
 </div>
 
            <!-- /.row -->
            <div class="row">
                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
							<h4>General Account Settings</h4>
							
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            
                          <ul class="nav nav-tabs">
                                <li class="active">
									<a href="#erf" data-toggle="tab"> User Information</a>
                                </li>
                                <li>
									<a href="#step" data-toggle="tab"> Security and Login</a>
                                </li>
						</ul>
			
							<div class="tab-content">
                                <div class="tab-pane fade in active" id="erf">
								<h3 class="page-header">Account Details</h3>
								<b>
								<table>
								  <?php
									echo '<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i> Employee ID:</td><td>'.$row_record['Emp_ID'].'</td></tr>
									     <tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i> Name:</td><td>'.$row_record['Emp_LName'].', '.$row_record['Emp_FName'].' '.$row_record['Emp_MName'].'</td></tr>
										
										<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i> Position:</td><td> '.$row_record['Job_description'].'</td></tr>
										
										<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i> Station:</td><td> '.$row_record['SchoolName'].'</td></tr>
										
										<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i> Address: </td><td>'.$row_record['Emp_Address'].'</td></tr>
										
										<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i> Contact Number:</td><td> '.$row_record['Emp_Cell_No'].'</td></tr>
										
										<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i> Email Address: </td><td>'.$row_record['Emp_Email'].'</td></tr>
										
										<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i> TIN: </td><td>'.$row_record['Emp_TIN'].' <a href="" data-toggle="modal" data-target="#myTIN">Edit</a></td></tr>';
									?>
								</table>
								</b>
								</div>
								 <div class="tab-pane fade" id="step">
								  <div class="col-lg-4">
										<div class="panel panel-default">
										<form action="" Method="POST">
											<div class="panel-heading">
												<h3>Change Password</h3>
											</div>
											<div class="panel-body">
											
											<label>Email:</label>
											<?php
												echo '<input type="email" name="Email" value="'.$row_record['Emp_Email'].'" class="form-control" disabled>';
											?>
											<label>Password:</label>
												<input type="password" name="password" Placeholder="Password" class="form-control">
												<div class="divider"></div>
												<label>Confirm:</label>
												<input type="password" name="confirm" Placeholder="Confirm" class="form-control">
											</div>
											<div class="panel-footer">
													<input type="submit" name="update" value="Change" class="btn btn-primary">
											</div>
											</form>
										</div>
									</div>
								
								</div>
							</div>
			
			
			  
        </div>

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
<!-- Modal -->
<!-- Modal for Re-assign-->
   <div class="panel-body">

    <!-- Modal -->
      <div class="modal fade" id="myTIN" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog">
   
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>Update Tax Indentification Number </h4>
        </div>
        <div class="modal-body">
            <div class="row">
				<form action="" Method="POST">
               
                      <div class="panel-body" >
                       <label>Tax Indentification Number</label>    
						<input type="text" name="myTIN" placeholder="TIN" class="form-control">	
					</div>
				<div class="panel-footer">
				<input type="submit" class="btn btn-primary" name="save" value="SUBMIT">
				</form>
				</div>
           
        </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  
  