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
					} elseif ($url == 'list_of_school') {
						include("list_of_school.php");
					} elseif ($url == 'list_of_activity') {
						include("list_of_activity.php");
					} elseif ($url == 'transaction') {
						include("transactions.php");
					} elseif ($url == 'view_log') {
						include("view-log.php");
					} elseif ($url == 'announcement') {
						include("list_of_announcement.php");
					} elseif ($url == 'update_transaction') {
						include("edit-transaction.php");
					} elseif ($url == 'transaction_verifier') {
						include("document-verifier.php");
					} elseif ($url == 'canceled_transaction') {
						include("canceled-transaction.php");
					} elseif ($url == 'quatame') {
						include("evaluation-form.php");
					} elseif ($url == 'payroll') {
						include("payroll-history.php");
					} elseif ($url == 'update_activity') {
						include("edit_activity.php");
					} elseif ($url == 'add_participant') {
						include("my_participant.php");
					} elseif ($url == 'view_payroll') {
						include("view-payroll.php");
					} elseif ($url == 'settings') {
						include("setting.php");
					} elseif ($url == 'view_list') {
						include("view_list.php");
					} elseif ($url == 'new_participants') {
						include("new_participants.php");
					} elseif ($url == 'memo_details') {
						include("memo_details.php");
					} elseif ($url == 'all_notification') {
						include("all_notification.php");
					} elseif ($url == 'request_for_vehicle') {
						include("request_for_vehicle.php");
					} elseif ($url == 'vehicle_request_form') {
						include("vehicle_request_form.php");
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