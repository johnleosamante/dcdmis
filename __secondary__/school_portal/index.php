<?php
include_once("../_includes_/function.php");
if($_SESSION['uid']=="")
	{
		header('location:http://'.$_SERVER['HTTP_HOST'].'/');
	}else{
		if ((time() - $_SESSION['last_login_timestamp'])>14400)//14400=240*60
		{
			header("location:../logout.php");
		}else{
			$_SESSION['last_login_timestamp']= time();
		}
	}
$mysched=mysqli_query($con,"SELECT * FROM tbl_distribution_schedule");
$rowdata=mysqli_fetch_assoc($mysched);
//$_SESSION['quarter']=$rowdata['QuarterNo'];					 		
//$_SESSION['week']=$rowdata['WeekNo'];	

foreach ($_GET as $key => $data)
{
$link=$_GET[$key]=base64_decode(urldecode($data));
	
}
$str=sha1(GetSiteTitle());
?>

		
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
     
	
    <META http-equiv='Content-Type' content='text/html; charset=windows-1252'>
	<META HTTP-EQUIV='expires' CONTENT='FRI, 13 MAR 2021 12:00:00 GMT'>
 
    <META HTTP-EQUIV='Pragma' CONTENT='no-cache'>
    <META HTTP-EQUIV='Cache-Control' CONTENT='no-cache'>
    <META http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="DepEd Pagadian">
      <title><?php echo GetSiteTitle(); ?></title>
	  <script src="../pcdmis/js/plupload.full.min.js"></script>
	<link rel="shortcut icon" href="../pcdmis/logo/logo.png">
    <!-- Bootstrap Core CSS -->
    <link href="../pcdmis/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../pcdmis/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../pcdmis/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../pcdmis/vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../pcdmis/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="../pcdmis/vendor/jquery/jquery.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
					require("tagline.php");
			    ?>
            </div>
			
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <?php
				require("header-menu.php")
				?>
                <!-- /.dropdown -->
            </ul>
			
			    <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation" style="margin-top:78px;">
                <div class="sidebar-nav navbar-collapse">
                   <?php
				   require("menu.php");
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
	  
        
					
      </div>
    </div>
 </div>
           
              
            <!-- /.row -->
            <div class="row">	

			<?php
			if (!isset($link))
					{
						  include("dashboard.php");
					}else{
			 if ($link=='dashboard')
			 {
				 require("dashboard.php");
			 }
			 
			 else if ($link=='personnel')
			 {
				 require("personnel.php");
			 }
			 
			 else if ($link=='retirable')
			 {
				 require("retirable.php");
			 }
			 
			 else if ($link=='leaves')
			 {
				 require("leaves.php");
			 }
			 
			 else if ($link=='temporaryleave')
			 {
				 require("temporary_leave.php");
			 }
			 
			 else if ($link=='erf')
			 {
				 require("erf.php");
			 }
			 
			 else if ($link=='steps')
			 {
				 require("steps.php");
			 }
			  else if ($link=='lrmds')
			 {
				 require("lrmds-report.php");
			 }
			  else if ($link=='ictreport')
			 {
				 require("ict_portal.php");
			 }
			 else if ($link=='mpsreport')
			 {
				 require("my_MPS.php");
			 }
			  else if ($link=='mooereport')
			 {
				 require("mooe.php");
			 }
			  else if ($link=='Elementary')
			 {
				 require("elementary_learner.php");
			 }
			 else if ($link=='Junior')
			 {
				 require("junior_learner.php");
			 }
			  else if ($link=='Senior')
			 {
				 require("senior_learner.php");
			 }
			  else if ($link=='Section')
			 {
				 require("sections.php");
			 }
			  else if ($link=='Modules')
			 {
				 require("list_of_modules.php");
			 }
			 else if ($link=='Transactions')
			 {
				 require("transactions.php");
			 }
			  else if ($link=='view_log')
			 {
				 $_SESSION['TransCode']=$_GET['id'];
				 require("view-log.php");
			 }
			  else if ($link=='textbook')
			 {
				 
				 require("textbook.php");
			 }
			  else if ($link=='list_of_section')
			 {
				 
				 require("list_of_section.php");
			 }
			 else if ($link=='registered')
			 {
				 
				 require("list_of_registered.php");
			 }
			  else if ($link=='track')
			 {
				 
				 require("list_of_track.php");
			 }
			  else if ($link=='senior_subject')
			 {
				 
				 require("senior_high_subject.php");
			 }
			 else if ($link=='junior_subject')
			 {
				 
				 require("junior_high_subject.php");
			 }
			  else if ($link=='subject_by_section')
			 {
				
				 require("subject-by-section.php");
			 }
			  else if ($link=='list_of_student')
			 {
				
				 require("list-of-student.php");
			 }
			else if ($link=='view_qualification')
			 {
				
				 require("view_qualification.php");
			 }
			 else if ($link=='individual_info')
			 {
				
				 require("individual_info.php");
			 } else if ($link=='viewlist')
			 {
				
				 require("view-list.php");
			 }
			 else if ($link=='pds')
			 {
				
				 require("pds.php");
			 }
			  else if ($link=='leave_credit')
			 {
				
				 require("leave_credit.php");
			 }
			  else if ($link=='service_record')
			 {
				
				 require("service_record.php");
			 }
			 else if ($link=='helpdesk')
			 {
				
				 require("helpdesk.php");
			 }
			  else if ($link=='website')
			 {
				
				 require("website.php");
			 }
			 else if ($link=='principal_message')
			 {
				
				 require("principal_message.php");
			 }
			 else if ($link=='history')
			 {
				
				 require("school_history.php");
			 }
			 else if ($link=='school_chart')
			 {
				
				 require("school_organization.php");
			 }
			  else if ($link=='pta')
			 {
				
				 require("pta_chart.php");
			 } else if ($link=='ssg')
			 {
				
				 require("ssg_chart.php");
			 } else if ($link=='ict')
			 {
				
				 require("ict_chart.php");
			 }else if ($link=='reply')
			 {
				
				 require("view_reply.php");
			 }else if ($link=='library')
			 {
				
				 require("school_library.php");
			 }
			 else if ($link=='CompLab')
			 {
				
				 require("computer_laboratory.php");
			 }else if ($link=='HELaboratory')
			 {
				
				 require("he_laboratory.php");
			 }
			 else if ($link=='download')
			 {
				
				 require("download_file.php");
			 }
			 else if ($link=='news')
			 {
				
				 require("school_news.php");
			 }
			  else if ($link=='directory')
			 {
				
				 require("directory.php");
			 }
			 else if ($link=='slider')
			 {
				
				 require("image_slider.php");
			 }
			  else if ($link=='header')
			 {
				
				 require("website_header.php");
			 }
			 elseif($link=='psdsreport')
			 {
				require("psds_report.php"); 
			 }
			  elseif($link=='class_room')
			 {
				require("meeting_room.php"); 
			 } elseif($link=='dbea')
			 {
				require("dbea.php"); 
			 }elseif($link=='addNewExaminee')
			 {
				require("addExaminee.php"); 
			 }elseif($link=='dtr')
			 {
				require("daily_time_record.php"); 
			 }elseif($link=='view_date')
			 {
				require("view_date.php"); 
			 }elseif($link=='assessment')
			 {
				require("assessment.php"); 
			 }elseif($link=='esat')
			 {
				require("esat.php"); 
			 }elseif($link=='monitoring')
			 {
				require("monitoring.php"); 
			 }elseif($link=='available_module')
			 {
				require("available_module.php"); 
			 }elseif($link=='activity_sheets')
			 {
				require("activity_sheets.php"); 
			 }elseif($link=='activity_question')
			 {
				require("activity_question.php"); 
			 }elseif($link=='school_obligation')
			 {
				require("school_obligation.php"); 
			 }elseif($link=='view_obligation_list')
			 {
				require("view_obligation_list.php"); 
			 }elseif($link=='settings')
			 {
				require("setting.php"); 
			 }elseif($link=='form10')
			 {
				require("form10.php"); 
			 }elseif($link=='ict_monitoring')
			 {
				require("ict_monitoring.php"); 
			 }elseif($link=='school_governance')
			 {
				require("school_governance.php"); 
			 }elseif($link=='pisa')
			 {
				require("pisa.php"); 
			 }elseif($link=='view_participant')
			 {
				require("view_participant.php"); 
			 }elseif($link=='participant')
			 {
				require("list_participant.php"); 
			 }elseif($link=='dcppackages')
			 {
				require("dcppackages.php"); 
			 }elseif($link=='computer_utilization')
			 {
				require("computer_utilization.php"); 
			 }elseif($link=='technical_assistance')
			 {
				require("technical_assistance.php"); 
			 }elseif($link=='asds_report')
			 {
				require("asds_report.php"); 
			 }elseif($link=='AnnexA1')
			 {
				require("AnnexA1.php"); 
			 }elseif($link=='AnnexA2')
			 {
				require("AnnexA2.php"); 
			 }elseif($link=='AnnexA3')
			 {
				require("AnnexA3.php"); 
			 }elseif($link=='AnnexA4')
			 {
				require("AnnexA4.php"); 
			 }elseif($link=='AnnexA5')
			 {
				require("AnnexA5.php"); 
			 }elseif($link=='AnnexA6')
			 {
				require("AnnexA6.php"); 
			 }elseif($link=='AnnexA7')
			 {
				require("AnnexA7.php"); 
			 }elseif($link=='AnnexA8')
			 {
				require("AnnexA8.php"); 
			 }elseif($link=='AnnexA9')
			 {
				require("AnnexA9.php"); 
			 }elseif($link=='AnnexA10')
			 {
				require("AnnexA10.php"); 
			 }
			 //Annex 1
			 elseif($link=='view_report_card')
			 {
				require("view_report_card.php"); 
			 }elseif($link=='view_report_office')
			 {
				require("view_report_office.php"); 
			 }
			 //Annex 2
			 elseif($link=='view_report_ledger')
			 {
				require("view_report_ledger.php"); 
			 }
			 //Annex 3
			 elseif($link=='view_ics_reports')
			 {
				require("view_ics_reports.php"); 
			 } 
			 //Annex 4
			 elseif($link=='view_issued_reports')
			 {
				require("view_issued_reports.php"); 
			 } 
			 //Annex 5
			 elseif($link=='view_transfer_reports')
			 {
				require("view_transfer_reports.php"); 
			 } //Annex 6
			 elseif($link=='view_annexA6')
			 {
				require("view_annexA6.php"); 
			 }//Annex 7
			 elseif($link=='view_annex7')
			 {
				require("view_annex7.php"); 
			 }//Annex 8
			 elseif($link=='view_annexa8')
			 {
				require("view_annexa8.php"); 
			 }//Annex 9
			 elseif($link=='view_annexa9')
			 {
				require("view_annex9.php"); 
			 }//Annex 10
			 elseif($link=='view_annex10')
			 {
				require("view_annex10.php"); 
			 }//View Essat
			 elseif($link=='view_esst_consol')
			 {
				require("view_esst_consol.php"); 
			 }
			}
			?>


			<!-- /.panel-body -->
                    </div> </div> 
                    </div> 
				
          
            
   


    <!-- Bootstrap Core JavaScript -->
    <script src="../pcdmis/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../pcdmis/vendor/metisMenu/metisMenu.min.js"></script>

    
      <!-- Custom Theme JavaScript -->
    <script src="../pcdmis/dist/js/sb-admin-2.js"></script>

<!-- DataTables JavaScript -->
    <script src="../pcdmis/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../pcdmis/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../pcdmis/vendor/datatables-responsive/dataTables.responsive.js"></script>

   <!-- Flot Charts JavaScript -->
    <script src="../pcdmis/vendor/flot/excanvas.min.js"></script>
    <script src="../pcdmis/vendor/flot/jquery.flot.js"></script>
    <script src="../pcdmis/vendor/flot/jquery.flot.pie.js"></script>
    <script src="../pcdmis/vendor/flot/jquery.flot.resize.js"></script>
    <script src="../pcdmis/vendor/flot/jquery.flot.time.js"></script>
    <script src="../pcdmis/vendor/flot-tooltip/jquery.flot.tooltip.min.js"></script>
    <!-- <script src="../../pcdmis/data/flot-data.js"></script>

	
    Custom Theme JavaScript -->
    <script src="../pcdmis/dist/js/sb-admin-2.js"></script>

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
 <div class="panel-body">

    <!-- Modal -->
      <div class="modal fade" id="myRetiree" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>Details of Retirees</h4>
        </div>
        <div class="modal-body">
          <table class="table table-bordered">
				<tr>
					<th>#</th>
					<th>District</th>
					<th># of Employee</th>
					<th></th>
					
				</tr>
				<?php
				$no=0;
				$myDistrict=mysqli_query($con,"SELECT * FROM tbl_district ORDER BY District_code Asc")or die("Error destict data");
				while($rowdist=mysqli_fetch_array($myDistrict))
				{
				$no=$no+1;
				$d_data=mysqli_Query($con,"SELECT * FROM tbl_school INNER JOIN tbl_district ON tbl_school.District_code = tbl_district.District_code INNER JOIN tbl_station ON tbl_school.SchoolID=tbl_station.Emp_Station INNER JOIN tbl_employee ON tbl_station.Emp_ID =tbl_employee.Emp_ID WHERE tbl_school.District_code ='".$rowdist['District_code']."' AND tbl_station.Emp_age>='60' AND tbl_employee.Emp_Status <>'Retired'")or die ("Error Employee Query");	
				echo '<tr>
					<td>'.$no.'</td>
					<td>'.$rowdist['District_Name'].'</td>
					<td>'.mysqli_num_rows($d_data).'</td>
					<td class="dropdown">						
					    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-gear fa-fw"></i> <i class="fa fa-caret-down"></i>
						</a>
							<ul class="dropdown-menu dropdown-user">
								<li>
									<a href="validate.php?district='.$rowdist['District_code'].'"><i class="fa   fa-male   fa-fw"></i> View List</a>
								</li>
																
							</ul>							
					</td>
				</tr>';
				}
					?>
		  </table>
        </div>
        
      </div>
    </div>
  </div>
  </div>
  
  
<!-- Modal -->
 <div class="panel-body">

    <!-- Modal -->
      <div class="modal fade" id="myStep" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>List of Request for Transfer </h4>
        </div>
        <div class="modal-body">
          <table class="table table-bordered">
				<tr>
					<th>#</th>
					<th>Request by</th>
					<th>From </th>
					<th>Transfer To</th>
					<th>Reason to Transfer</th>
					<th>Status</th>
					
				</tr>
				<?php
				$no=0;
				$myrequest=mysqli_query($con,"SELECT * FROM tbl_transfer_data INNER JOIN tbl_employee ON tbl_transfer_data.Trans_Emp_ID=tbl_employee.Emp_ID")or die("Error transfer data");
				while($rtransfer=mysqli_fetch_array($myrequest))
				{
				$no=$no+1;
				echo '<tr>
					<td>'.$no.'</td>
					<td>'.$rtransfer['Emp_LName'].', '.$rtransfer['Emp_FName'].'</td>
					<td>'.$rtransfer['Trans_From'].'</td>
					<td>'.$rtransfer['Trans_TO'].'</td>
					<td>'.$rtransfer['Trans_Reason'].'</td>
					<td>'.$rtransfer['Trans_Status'].'</td>
					<td class="dropdown">						
					    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-gear fa-fw"></i> <i class="fa fa-caret-down"></i>
						</a>
							<ul class="dropdown-menu dropdown-user">
								<li>
									<a href=".php?id='.$rtransfer['Emp_ID'].'"><i class="fa   fa-user   fa-fw"></i> Confirm</a>
								</li>
								<li>
									<a href=""><i class="fa   fa-recycle   fa-fw"></i> Disapproved</a>
								</li>
																
							</ul>							
					</td>
				</tr>';
				}
					?>
		  </table>
                   
                   
        </div>
       </div>
    </div>
  </div>
  </div>
  
  

  
  
<!-- Modal -->
 <div class="panel-body">

    <!-- Modal -->
      <div class="modal fade" id="myRequest" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog">
 
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>Summary Details </h4>
        </div>
        <div class="modal-body">
		<table width="100%" class="table table-striped table-bordered table-hover" >
				<tr>
					<th rowspan="2">#</th>
					<th rowspan="2">Request by</th>
					<th rowspan="2">Request for</th>
					<th rowspan="2">Date Apply</th>
					<th rowspan="2"># of Days</th>
					<th colspan="2">Inclusive Date</th>
					<th rowspan="2">Status</th>
					<th rowspan="2"></th>
				</tr>
					<th>From</th>
					<th>To</th>
				<tr>
				</tr>
				<?php
				$no=0;
					$request_data=mysqli_Query($con,"SELECT * FROM tbl_request INNER JOIN tbl_employee ON tbl_request.Emp_ID=tbl_employee.Emp_ID INNER JOIN tbl_leave ON tbl_request.Request_for=tbl_leave.LeaveCode")or die("error data request");
					while($row_request=mysqli_fetch_array($request_data))
					{
						$no=$no+1;
						echo '<tr>
					<td>'.$no.'</td>
					<td>'.$row_request['Emp_LName'].', '.$row_request['Emp_FName'].'</td>
					<td>'.$row_request['LeaveDescription'].'</td>
					<td>'.$row_request['Date_apply'].'</td>
					<td style="text-align:center">'.$row_request['Number_of_days'].'</td>
					<td>'.$row_request['Request_From'].'</td>
					<td>'.$row_request['Request_To'].'</td>
					<td>'.$row_request['Request_status'].'</td>
					<td class="dropdown">						
					    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-gear fa-fw"></i> <i class="fa fa-caret-down"></i>
						</a>
							<ul class="dropdown-menu dropdown-user">';
							if ($row_request['Request_status']=='Approved')
								{

							echo '<li><a href="my_approval.php?code='.$row_request['No'].'" data-target="#viewattach" data-toggle="modal"><i class="fa   fa-thumbs-o-up   fa-fw"></i> Confirm</a></li>';
								
								}else{
							echo '<li>
									<a href="update_request.php?code='.$row_request['No'].' &&TIN='.$row_request['Emp_ID'].'"><i class="fa   fa-thumbs-o-up   fa-fw"></i> Approved</a>
								</li><li>
									<a href="delete_request.php?code='.$row_request['No'].' &&TIN='.$row_request['Emp_ID'].'"><i class="fa  fa-trash-o   fa-fw"></i> Disapproved</a>
								</li>';
								}
							echo '								
							</ul>							
					</td>
				</tr>';
					}
				?>
		  </table>
        </div>
        <div class="modal-footer">
		<h3>List of Pending Request</h3>
        </div>
      </div>
    </div>
  </div>
  </div>
  
  
    <!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="viewattach" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	

	</div></div>
</div>
  </div>
 
 
 
              <!-- Modal -->
	 <div class="modal fade" id="access" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			<button type="button" class="close" aria-hidden="true" data-dismiss="modal">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Confirm</h4>
			</div>
			 
			<div class="modal-body">
			<img src="../pcdmis/logo/check.png" width="100%" height="50%">
			<center><h3>Successfully Submitted!</h3></center>
		   	</div>
           <div class="modal-footer">
		   <a href="" class="btn btn-success">Continue...</a>
			</center>
		 </div>	

	</div></div>
	</div>
 

	
              <!-- Modal -->
	 <div class="modal fade" id="error" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			<button type="button" class="close" aria-hidden="true" data-dismiss="modal">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Error</h4>
			</div>
			 
			<div class="modal-body">
			<img src="../pcdmis/logo/error.png" width="100%" height="50%">
			<center><h3>Transaction has a problem!!!</h3></center>
		   	</div>
           <div class="modal-footer">
		   <a href="" class="btn btn-success">Continue...</a>
			</center>
		 </div>	

	</div></div>
	</div>
	
              <!-- Modal -->
	 <div class="modal fade" id="verifier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			<button type="button" class="close" aria-hidden="true" data-dismiss="modal">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Document Verifier</h4>
			</div>
			 
			<div class="modal-body">
			<img src="../pcdmis/logo/check.png" width="100%" height="50%">
			<center><h3>Transaction Successfully Submitted</h3></center>
		   	</div>
           <div class="modal-footer">
		   <a href="./" class="btn btn-success">Continue...</a>
			</center>
		 </div>	

	</div></div>
	</div>
