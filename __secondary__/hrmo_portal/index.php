<?php
include("../_includes_/function.php");
if ($_SESSION['uid'] == "") {
	header('location:' . GetSiteURL());
} else {
	if ((time() - $_SESSION['last_login_timestamp']) > 14400) //14400=240*60
	{
		header('location:' . GetSiteURL() . '/logout');
	} else {
		$_SESSION['last_login_timestamp'] = time();
	}
}
$mysched = mysqli_query($con, "SELECT * FROM tbl_distribution_schedule");
$rowdata = mysqli_fetch_assoc($mysched);
//$_SESSION['quarter']=$rowdata['QuarterNo'];					 		
//$_SESSION['week']=$rowdata['WeekNo'];	

foreach ($_GET as $key => $data) {
	$url = $_GET[$key] = base64_decode(urldecode($data));
}
$str = sha1(GetSiteTitle());
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN">

<html>

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

				<?php include_once('../_includes_/layout/navbar-brand.php'); ?>
			</div>

			<!-- /.navbar-header -->

			<ul class="nav navbar-top-links navbar-right">
				<?php
				include("header-menu.php");
				?>
				<!-- /.dropdown -->
			</ul>

			<!-- /.navbar-top-links -->

			<div class="navbar-default sidebar" role="navigation" style="margin-top:60px;">
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

					<div class="media" style="margin-top: 40px;margin-bottom:10px;">

					</div>
				</div>
			</div>


			<!-- /.row -->
			<div class="row" style="margin-top: 20px;">
				<?php

				if (!isset($url)) {
					include("dashboard.php");
				} else {
					if ($url == 'dashboard') {
						include("dashboard.php");
					} elseif ($url == 'activity') {
						include("list_of_activity.php");
					} elseif ($url == 'list_of_school') {
						include("list_of_school.php");
					} elseif ($url == 'quatame') {
						include("evaluation-form.php");
					} elseif ($url == 'transaction') {
						include("transactions.php");
					} elseif ($url == 'view_log') {
						include("view-log.php");
					} elseif ($url == 'personnel') {
						include("personnel.php");
					} elseif ($url == 'announcement') {
						include("announcement.php");
					} elseif ($url == 'update_transaction') {
						include("edit-transaction.php");
					} elseif ($url == 'canceled_transaction') {
						include("canceled-transaction.php");
					} elseif ($url == 'retirable') {
						include("retirable.php");
					} elseif ($url == 'leave') {
						include("leaves.php");
					} elseif ($url == 'archive') {
						include("archive.php");
					} elseif ($url == 'erf') {
						include("erf.php");
					} elseif ($url == 'steps') {
						include("steps.php");
					} elseif ($url == 'dts') {
						include("document-verifier.php");
					} elseif ($url == 'setting') {
						include("setting.php");
					} elseif ($url == 'view_school') {
						include("view_profile.php");
					} elseif ($url == 'view-school') {
						include("view-school.php");
					} elseif ($url == 'payroll_history') {
						include("payroll-history.php");
					} elseif ($url == 'view_payroll') {
						include("view-payroll.php");
					} elseif ($url == 'new_payroll') {
						include("new-payroll-transaction.php");
					} elseif ($url == 'settings') {
						include("setting.php");
					} elseif ($url == 'view_list') {
						include("view_list.php");
					} elseif ($url == 'new_participants') {
						include("new_participants.php");
					} elseif ($url == 'profile') {
						include("profile.php");
					} elseif ($url == 'service_record') {
						include("service_record.php");
					} elseif ($url == 'view_details') {
						include("view_details.php");
					} elseif ($url == 'request_for_transfer') {
						include("request_for_transfer.php");
					} elseif ($url == 'other_list') {
						include("other_list.php");
					} elseif ($url == 'memo_details') {
						include("memo_details.php");
					} elseif ($url == 'all_notification') {
						include("all_notification.php");
					} elseif ($url == 'request_for_vehicle') {
						include("request_for_vehicle.php");
					} elseif ($url == 'vehicle_request_form') {
						include("vehicle_request_form.php");
					} elseif ($url == 'personnel_201_file') {
						include("personnel_201_file.php");
					} elseif ($url == 'view_201_file') {
						include("view_201_file.php");
					}
				}

				?>

				<!-- /.panel-body -->
			</div>
		</div>
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
	<!-- Custom Theme JavaScript -->
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

<!-- Modal for Re-assign-->
<div class="panel-body">

	<!-- Modal -->
	<div class="modal fade" id="viewattach" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">


			</div>
		</div>
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
				<center>
					<h3>Successfully Submitted!</h3>
				</center>
			</div>
			<div class="modal-footer">
				<a href="" class="btn btn-success">Continue...</a>
				</center>
			</div>

		</div>
	</div>
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
				<center>
					<h3>Transaction has a problem!!!</h3>
				</center>
			</div>
			<div class="modal-footer">
				<a href="" class="btn btn-success">Continue...</a>
				</center>
			</div>

		</div>
	</div>
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
				<center>
					<h3>Transaction Successfully Submitted</h3>
				</center>
			</div>
			<div class="modal-footer">
				<a href="./" class="btn btn-success">Continue...</a>
				</center>
			</div>

		</div>
	</div>
</div>



<!-- Modal -->
<div class="panel-body">

	<!-- Modal -->
	<div class="modal fade" id="myRetiree" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">

					<h4>Details of Retirees</h4>
				</div>
				<div class="modal-body">
					<table class="table table-bordered">
						<tr>
							<th>#</th>
							<th>District</th>
							<th>Supervisor</th>
							<th># of Employee</th>
							<th width="7%"></th>

						</tr>
						<?php
						$no = 0;
						$myDistrict = mysqli_query($con, "SELECT * FROM tbl_district INNER JOIN tbl_employee ON tbl_district.Emp_ID = tbl_employee.Emp_ID ORDER BY District_code Asc") or die("Error destict data");
						while ($rowdist = mysqli_fetch_array($myDistrict)) {
							$no = $no + 1;
							$d_data = mysqli_Query($con, "SELECT * FROM tbl_school INNER JOIN tbl_district ON tbl_school.District_code = tbl_district.District_code INNER JOIN tbl_station ON tbl_school.SchoolID=tbl_station.Emp_Station INNER JOIN tbl_employee ON tbl_station.Emp_ID =tbl_employee.Emp_ID WHERE tbl_school.District_code ='" . $rowdist['District_code'] . "' AND tbl_station.Emp_age>='60' AND tbl_employee.Emp_Status <>'Retired'") or die("Error Employee Query");
							echo '<tr>
					<td>' . $no . '</td>
					<td>' . $rowdist['District_Name'] . '</td>
					<td>' . $rowdist['Emp_LName'] . ', ' . $rowdist['Emp_FName'] . '</td>
					<td style="text-align:center;">' . mysqli_num_rows($d_data) . '</td>
					<td>						
					    	<a href="./?' . $str . '7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&c=' . urlencode(base64_encode($rowdist['District_code'])) . '&v=' . urlencode(base64_encode("view_details")) . '" class="btn btn-info"> <i class="fa fa-desktop fa-fw"></i></a>
														
					</td>
				</tr>';
						}
						?>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
					<table class="table table-bordered">
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
						$no = 0;
						$request_data = mysqli_Query($con, "SELECT * FROM tbl_request INNER JOIN tbl_employee ON tbl_request.Emp_ID=tbl_employee.Emp_ID INNER JOIN tbl_leave ON tbl_request.Request_for=tbl_leave.LeaveCode") or die("error data request");
						while ($row_request = mysqli_fetch_array($request_data)) {
							$no = $no + 1;
							echo '<tr>
					<td>' . $no . '</td>
					<td>' . $row_request['Emp_LName'] . ', ' . $row_request['Emp_FName'] . '</td>
					<td>' . $row_request['LeaveDescription'] . '</td>
					<td>' . $row_request['Date_apply'] . '</td>
					<td style="text-align:center">' . $row_request['Number_of_days'] . '</td>
					<td>' . $row_request['Request_From'] . '</td>
					<td>' . $row_request['Request_To'] . '</td>
					<td>' . $row_request['Request_status'] . '</td>
					<td class="dropdown">						
					    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-gear fa-fw"></i> <i class="fa fa-caret-down"></i>
						</a>
							<ul class="dropdown-menu dropdown-user">';
							if ($row_request['Request_status'] == 'Approved') {

								echo '<li><a href="my_approval.php?code=' . $row_request['No'] . '" data-target="#myApproval" data-toggle="modal"><i class="fa   fa-thumbs-o-up   fa-fw"></i> Confirm</a></li>';
							} else {
								echo '<li>
									<a href="update_request.php?code=' . $row_request['No'] . ' &&TIN=' . $row_request['Emp_ID'] . '"><i class="fa   fa-thumbs-o-up   fa-fw"></i> Approved</a>
								</li><li>
									<a href="delete_request.php?code=' . $row_request['No'] . ' &&TIN=' . $row_request['Emp_ID'] . '"><i class="fa  fa-trash-o   fa-fw"></i> Disapproved</a>
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