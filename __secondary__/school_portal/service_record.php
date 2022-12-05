<?php
session_start();
include("../vendor/jquery/function.php");
if($_SESSION['uid']=="")
		{
				header('location:https://'.$_SERVER['HTTP_HOST'].'/pcdmis');
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
		th,td{
			text-align:center;
		}
	</style>
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
                   			
					<?php
					 $emp_info=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_employee.Emp_ID='".$_SESSION['per_sr']."'")or die("Error information data"); 
					 $data=mysqli_fetch_assoc($emp_info);
					 echo '<h3>Employee ID: '.$_SESSION['per_sr'].'</h3>';
					 echo '<h3>Employee Name: '.$data['Emp_LName'].', '.$data['Emp_FName'].' '.$data['Emp_MName'].'</h3>';
					 echo '<h3>Station: '.$data['SchoolName'].'</h3>';
					 $_SESSION['surname']=$data['Emp_LName'];
					 $_SESSION['given']=$data['Emp_FName'];
					 $_SESSION['middle']=mb_strimwidth($data['Emp_MName'],0,1);
					 $_SESSION['birth']=$data['Emp_Month'].'/'.$data['Emp_Day'].'/'.$data['Emp_Year'];
					 $_SESSION['place']=$data['Emp_place_of_birth'];
					?>
					
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
							<label>Service Record </label>													 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="20%" colspan="2">SERVICE RECORD</th>
                                        <th width="30%" colspan="3">RECORDS OF APPOINTMENT</th>
                                        <th width="30%" colspan="2">OFFICE ENTITY / DIV</th>
                                        <th width="10%" rowspan="2">V/L ABSENCES W/O PAY</th>
                                        <th width="10%" rowspan="2">SEPARATION</th>
                                    </tr>
									<tr>
										<th>FROM</th>
										<th>TO</th>
										<th>DESIGNATION</th>
										<th>STATUS</th>
										<th>SALARY</th>
										<th>STN / PLACE OF ASSIGNMENT</th>
										<th>BRANCH</th>
										
                                </thead>
                                <tbody>
								<?php
								$result=mysqli_query($con,"SELECT * FROM tbl_service_records INNER JOIN tbl_school ON tbl_service_records.station = tbl_school.SchoolID WHERE tbl_service_records.Emp_ID='".$_SESSION['per_sr']."'");
									while($row=mysqli_fetch_array($result))
										{
										
                                      echo '<tr class="gradeA">
											<td>'.$row['date_from'].'</td>
											<td>'.$row['date_to'].'</td>
											<td>'.$row['position'].'</td>
											<td>'.$row['work_status'].'</td>
											<td>'.number_format($row['salary'],2).'</td>
											<td>'.$row['Abraviate'].'</td>
											<td>'.$row['branch'].'</td>
											<td>'.$row['pay_status'].'</td>
											<td>'.$row['separation'].'</td>';
											
											echo '</tr>';
                                    
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

    <!-- Page-Level Demo Scripts - Tables - Use for reference 
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>-->
</body>
</html>




<style>
   .modal-header,h4, .close{
	   background-color:#f9f9f9;
	   color:black !important;
	   text-align:center;
	   font-size:30px;
   }
   .modal-footer{
	   background-color:#f9f9f9;
   }
   .loginbox{
	   width:80%;height:auto;margin-top:100px;margin-left:auto;margin-right:auto;
   }
   .newleave{
	   width:40%;height:auto;margin-top:100px;margin-left:auto;margin-right:auto;
   }
		@media 
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {
			 .loginbox{
						width:100%;height:auto;margin-top:100px;margin-left:auto;margin-right:auto;
					}
					.newleave{
							width:100%;height:auto;margin-top:100px;margin-left:auto;margin-right:auto;
								}
		}
		
   </style>




<!-- Modal for New Leave-->
  <div class="modal fade" id="myEditTo" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="newleave">

       <!-- Modal content-->
      <div class="modal-content">
       
			
			
		</div>
	</div>
</div>
<!--End Supervisor-->

