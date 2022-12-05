<?php
session_start();
include("../vendor/jquery/function.php");
$_SESSION['dist']="";
$_SESSION['per_id']="";
if ($_SESSION['credit']=="")
{
	header('location:http://'.$_SERVER['HTTP_HOST'].'/pdmis/admin_portal/'); 
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
		th{
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
					 $emp_info=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_employee.Emp_ID='".$_SESSION['credit']."'")or die("Error information data"); 
					 $data=mysqli_fetch_assoc($emp_info);
					 echo '<img src="'.$data['Picture'].'" width="200" height="250"   style="padding:4px;margin:4px;border-radius:10px;" align="right">';
					 echo '<h3>Employee ID: '.$_SESSION['credit'].'</h3>';
					 echo '<h3>Employee Name: '.$data['Emp_LName'].', '.$data['Emp_FName'].' '.$data['Emp_MName'].'</h3>';
					 echo '<h3>Station: '.$data['SchoolName'].'</h3>';
					?>
					
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
						
						<ul class="nav nav-tabs">
                                <li class="active">
									<a href="#myCredit" data-toggle="tab"> Leave Credit</a>
                                </li>
                                <li>
									<a href="#myLeave" data-toggle="tab"> Leave Applied</a>
                                </li>
						</ul>													 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						
						<div class="tab-content">
                                <div class="tab-pane fade in active" id="myCredit">
								<a href="#myNewLeave" style="float:right" class="btn btn-primary" data-toggle="modal">New Leave Credit</a>
								<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="10%">Date</th>
                                        <th width="20%">Legal Basis / Memo / Special Order</th>
                                        <th width="15%">Type of Leave Credits</th>
                                        <th width="15%">Number of Days</th>
                                        <th width="30%">Type of Service Rendered</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=$sum=0;
									$myinfo=mysqli_query($con,"SELECT * FROM tbl_leave_credits INNER JOIN tbl_leave ON tbl_leave_credits.Type_of_leave_credit=tbl_leave.LeaveCode WHERE tbl_leave_credits.Emp_ID='".$_SESSION['credit']."'")or die ("Retirees Information error");
									while($row=mysqli_fetch_array($myinfo))
									{
										$no=$no+1;
										$sum=$sum+$row['Number_of_days'];
                                      echo '<tr class="gradeA">
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['Leave_date'].'</td>
											<td>'.$row['Legal_basis'].'</td>
											<td>'.$row['LeaveDescription'].'</td>
											<td style="text-align:center;">'.$row['Number_of_days'].'</td>
											<td>'.$row['Type_of_service_rendered'].'</td>
											</tr>';
                                    
									}	
										echo '<h3>Total Leave Credits: '.$sum.'</h3>';
									?>
                                </tbody>
                            </table>	
								</div>
								
								 <div class="tab-pane fade" id="myLeave">
								  
										<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%" rowspan="2">#</th>
                                        <th width="10%" rowspan="2">Date of Application</th>
                                        <th width="20%" rowspan="2">Type of Leave Credits</th>
                                        <th width="10%" rowspan="2">With / With out Pay</th>
                                        <th width="10%" rowspan="2">Number of Days</th>
                                        <th width="20%" rowspan="2">Reason for Leave of Absent</th>
                                        <th width="20%" colspan="2">Inclusive Date</th>
										<th width="5%" rowspan="2">Status</th>
                                    </tr>
									<tr>
										<th>From</th>
										<th>To</th>
                                </thead>
                                <tbody>
								<?php
								$no=$sum=$sum1=$sum2=0;
									$myinfo=mysqli_query($con,"SELECT * FROM tbl_leave_applied INNER JOIN tbl_leave ON tbl_leave_applied.Type_of_Leave=tbl_leave.LeaveCode WHERE tbl_leave_applied.Emp_ID='".$_SESSION['credit']."'")or die ("Credit Information error");
									while($row=mysqli_fetch_array($myinfo))
									{
										$no=$no+1;
										$sum=$sum+$row['Number_of_days'];
										if ($row['Leave_Status']=='With')
										{
										$sum2=$sum2+1;	
										}else{
											$sum1=$sum1+1;
										}
                                      echo '<tr class="gradeA">
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['Date_approved'].'</td>
											<td>'.$row['LeaveDescription'].'</td>
											<td>'.$row['Leave_Status'].'</td>
											<td style="text-align:center;">'.$row['Number_of_days'].'</td>
											<td>'.$row['Reason_for_leave_of_absent'].'</td>
											<td>'.$row['Date_From'].'</td>
											<td>'.$row['Date_To'].'</td>
											<td>'.$row['Status'].'</td>
											</tr>';
                                    
									}	
										echo '<h3>Total Leave Credits Applied: '.$sum.'</h3>';
										echo '<h3>Total Without Pay: '.$sum1.'</h3>';
										echo '<h3>Total With Pay: '.$sum2.'</h3>';
									?>
                                </tbody>
                            </table>		
										
										</div>
										
										
										
									</div>
								
								</div>
							</div>

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>

                <!-- /.col-lg-12 -->
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


<!-- Modal for New Leave-->
  <div class="modal fade" id="myNewLeave" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="newleave">

       <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
 
		  <h4 class="modal-title"><center>New Leave Credit Entry</center></h4>
		  	
        </div>
			<div class="modal-body">
		 <form role="form" action="save_credit.php" Method="POST" enctype="multipart/form-data">
				<div class="form-group">
					<!--Begin-->	
					<div class="row">
					 <div class="col-lg-12">
						      
                                   <div class="form-group">
                                        <label>Date </label>
                                            <input class="form-control" type="date" name="dcreate" required>
                                          </div>
                                        <div class="form-group">
                                            <label>Legal Basis / Memo / Special Order</label>
                                            <input class="form-control" name="legal" placeholder="Legal Basis / Memo / Special Order" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Type of Leave Credits</label>
                                            <select name="leave_type" class="form-control" required>
												<option value="">--Select--</option>
												<option value="Sick Leave">Sick Leave</option>
												<option value="Paternity Leave">Paternity Leave</option>
												<option value="Maternity Leave">Maternity Leave</option>
												<option value="Special Leave">Special Leave</option>
											</select>
                                        </div>
										<div class="form-group">
                                            <label>Number of Days</label>
                                            <input class="form-control" name="days" type="number" placeholder="Number of Days" required>
                                        </div>
										<div class="form-group">
                                            <label>Type of Service Rendered</label>
                                            <input class="form-control" name="service" placeholder="Type of Service Rendered" required>
                                        </div>
										
                                        <input type="submit" class="btn btn-primary" value="SAVE">
                                      
						
				
					<!--End-->	
					</div>
				</div>
			
			
				</div></form>
		    </div>
		</div>
	</div>
</div>
<!--End Supervisor-->

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
	   width:80%;height:auto;margin-top:10px;margin-left:auto;margin-right:auto;
   }
   .newleave{
	   width:40%;height:auto;margin-top:10px;margin-left:auto;margin-right:auto;
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