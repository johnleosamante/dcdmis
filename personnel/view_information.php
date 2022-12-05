<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
if ($_SESSION['EmpID']=="")
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

    <title>DepEd-Personnel ERF Information</title>

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
                    <h1 class="page-header">ERF Transaction History</h1>
		
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
				 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%" style="text-align:center;">#</th>	
                                        <th width="15%">Transaction Code</th>
                                        <th width="15%">Transaction Date</th>
                                        <th width="15%">Current Position</th>
                                        <th width="15%">Application for</th>
                                        <th width="15%">Application Status</th>
                                        <th width="7%"></th>
                                    </tr>
                                </thead>
                                <tbody>	
								<?php
								$no=0;
								$result=mysqli_query($con,"SELECT * FROM tbl_online_application INNER JOIN tbl_station ON tbl_online_application.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position =tbl_job.Job_code WHERE tbl_online_application.Emp_ID='".$_SESSION['EmpID']."' AND tbl_online_application.Transaction_number='".$_SESSION['TCode']."'");
								while($row=mysqli_fetch_array($result))
								{
									$no++;
								echo '<tr>
										<td style="text-align:center;">'.$no.'</td>
										<td>'.$row['Transaction_number'].'</td>
										<td>'.$row['Transaction_date'].'</td>
										<td>'.$row['Job_description'].'</td>
										<td>'.$row['Promotted_to'].'</td>
										<td>'.$row['Transaction_status'].'</td>
										<td class="dropdown" style="text-align:center;">
													
															<a class="dropdown-toggle" data-toggle="dropdown" href="#">
																<i class="fa fa-gear fa-fw"></i> <i class="fa fa-caret-down"></i>
															</a>
															<ul class="dropdown-menu dropdown-user">
																<li><a href="my_ERF_log.php?code='.$row['Transaction_number'].'" data-toggle="modal" data-target="#myerflog"><i class="fa  fa-user  fa-fw"></i> View Log</a>
																</li>';
															    if ($row['Transaction_status']=='For Printing')
																{
																	echo '<li><a href="for_printing.php?code='.$row['Transaction_number'].'" data-toggle="modal" data-target="#myerf"><i class="fa  fa-print  fa-fw"></i> Print Now</a>
																</li>';
																}																	
															echo '</ul>
															
													</td>
									</tr>';
								}
								?>
								</tbody>
                            </table>
			
			
			
            </div><!-- End Tab panes -->
 </div></div>
            
            
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
 <!-- Page-Level Demo Scripts - Tables - Use for reference -->
 
    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>
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
   .deploy{
	   width:50%;height:auto;margin-top:20px;margin-left:auto;margin-right:auto;
   }
   .loginbox{
	   width:1000px;height:auto;margin-top:10px;margin-left:auto;margin-right:auto;
   }
		@media 
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {
			 .loginbox{
						width:100%;height:auto;margin-top:100px;margin-left:auto;margin-right:auto;
					}
					.deploy{
							width:100%;height:auto;margin-top:20px;margin-left:auto;margin-right:auto;
							}
			}
		
   </style>


 <!-- Modal for Re-assign-->
    <div class="modal fade" id="myerflog" role="dialog" data-backdrop="static" data-keyboard="false">
     <div class="deploy">
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
			  </div></div>
			  
			  
			  <!-- Modal for Re-assign-->
    <div class="modal fade" id="myerf" role="dialog" data-backdrop="static" data-keyboard="false">
     <div class="loginbox">
    
      <!-- Modal content-->
      <div class="modal-content">
          
</div> </div></div>