<?php
include_once('../_includes_/function.php');

if ($_SESSION['uid'] == "") {
	header('location:' . GetSiteURL() . '/login');
} else {
	if ((time() - $_SESSION['last_login_timestamp']) > 14400) {
		//14400=240*60
		header('location:' . GetSiteURL() . '/logout');
	} else {
		$_SESSION['last_login_timestamp'] = time();
	}
}

$mysched = mysqli_query($con, "SELECT * FROM tbl_distribution_schedule");
$rowdata = mysqli_fetch_assoc($mysched);
//$_SESSION['quarter'] = $rowdata['QuarterNo'];
//$_SESSION['week'] = $rowdata['WeekNo'];

foreach ($_GET as $key => $data) {
	$url = $_GET[$key] = base64_decode(urldecode($data));
}

$str = sha1(GetSiteTitle());
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
	<meta http-equiv="Content-Security-Policy" content="">
	<META http-equiv='Content-Type' content='text/html; charset=windows-1252'>
	<META HTTP-EQUIV='expires' CONTENT='FRI, 13 MAR 2021 12:00:00 GMT'>
	<META HTTP-EQUIV='Pragma' CONTENT='no-cache'>
	<META HTTP-EQUIV='Cache-Control' CONTENT='no-cache'>
	<META http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="DepEd Dipolog City Schools Division <?php echo $url; ?>">
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
		//document.addEventListener('contextmenu', event => event.preventDefault());
	</script>
	<script>
		// var video = document.getElementById('video');
		// vendorURL = window.URL || window.webkitURL;
		// navigator.getUserMedia = navigator.getUserMedia || navigator.webkitUserMedia || navigator.mozUserMedia || navigator.msUserMedia;

		// navigator.mediaDevices.getUserMedia({
		// 	audio: true,
		// 	video: true
		// }).then(stream => {
		// 	document.getElementById("video").srcObject = stream;
		// });
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
					<div class="media" style="margin-top: 40px;margin-bottom:10px;"></div>
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
					} elseif ($url == 'ict_coordinator') {
						include("ict-coordinator.php");
					} elseif ($url == 'list_of_school') {
						include("list_of_school.php");
					} elseif ($url == 'HelpDesk') {
						include("HelpDesk.php");
					} elseif ($url == 'transaction') {
						include("transactions.php");
					} elseif ($url == 'view_log') {
						include("view-log.php");
					} elseif ($url == 'personnel') {
						include("personnel.php");
					} elseif ($url == 'requestReply') {
						include("reply.php");
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
					} elseif ($url == 'ict_form') {
						include("form1_ict.php");
					} elseif ($url == 'request_TA') {
						include("request_for_repair.php");
					} elseif ($url == 'view_school') {
						include("view_profile.php");
					} elseif ($url == 'readiness') {
						include("readiness.php");
					} elseif ($url == 'view-school') {
						include("view-school.php");
					} elseif ($url == 'dbea') {
						include("dbea.php");
					} elseif ($url == 'list_of_examinee') {
						include("list_of_examinee.php");
					} elseif ($url == 'list_of_subject') {
						include("list_of_subject.php");
					} elseif ($url == 'my_report') {
						include("my_report.php");
					} elseif ($url == 'Questionnairs') {
						include("Questionnairs.php");
					} elseif ($url == 'addquestion') {
						include("addquestion.php");
					} elseif ($url == 'registered') {
						include("registered.php");
					} elseif ($url == 'my_division') {
						include("my_division.php");
					} elseif ($url == 'my_school') {
						include("my_school.php");
					} elseif ($url == 'service_record') {
						include("service_record.php");
					} elseif ($url == 'post') {
						include("announcement.php");
					} elseif ($url == 'view_dtr') {
						include("view-dtr.php");
					} elseif ($url == 'mydate') {
						include("my-date.php");
					} elseif ($url == 'ipcrf') {
						include("ipcrf.php");
					} elseif ($url == 'lmupload') {
						include("lmupload.php");
					} elseif ($url == 'uploadfile') {
						include("uploadfile.php");
					} elseif ($url == 'written_work_set_work') {
						include("written_work_set_work.php");
					} elseif ($url == 'category') {
						include("gradelevel.php");
					} elseif ($url == 'subject_list') {
						include("subject_list.php");
					} elseif ($url == 'addreadingmaterial') {
						include("addreadingmaterial.php");
					} elseif ($url == 'summary_of_enrolment') {
						include("summary_of_enrolment.php");
					} elseif ($url == 'personnel_bulletin') {
						include("personnel_bulletin.php");
					} elseif ($url == 'class_room') {
						require("meeting_room.php");
					} elseif ($url == 'school_report') {
						require("school_report.php");
					} elseif ($url == 'view_school_subject') {
						require("view_school_subject.php");
					} elseif ($url == 'view_learner_per_section') {
						require("view_learner_per_section.php");
					} elseif ($url == 'individual_info') {
						require("individual_info.php");
					} elseif ($url == 'addoption') {
						require("addoption.php");
					} elseif ($url == 'trainings') {
						require("list_of_activity.php");
					} elseif ($url == 'view_list') {
						include("view_list.php");
					} elseif ($url == 'other_list') {
						include("other_list.php");
					} elseif ($url == 'new_participants') {
						include("new_participants.php");
					} elseif ($url == 'registered_list') {
						include("registered_list.php");
					} elseif ($url == 'list_of_attendance') {
						include("list_of_attendance.php");
					} elseif ($url == 'transaction_verifier') {
						include("document-verifier.php");
					}
					//Website information
					elseif ($url == 'website') {
						include("website.php");
					} elseif ($url == 'image_slider') {
						include("image_slider.php");
					} elseif ($url == 'sds_message') {
						include("sds_message.php");
					} elseif ($url == 'division_memo') {
						include("division_memo.php");
					} elseif ($url == 'division_history') {
						include("division_history.php");
					} elseif ($url == 'division_chart') {
						include("division_chart.php");
					} elseif ($url == 'bids_and_awards') {
						include("bids_and_awards.php");
					} elseif ($url == 'division_news') {
						include("division_new.php");
					} elseif ($url == 'downloads') {
						include("downloads.php");
					}
					//School information
					elseif ($url == 'school_Transactions') {
						include("school_Transactions.php");
					} elseif ($url == 'list_of_learner') {
						include("list_of_learner.php");
					} elseif ($url == 'list_of_section') {
						include("list_of_section.php");
					} elseif ($url == 'subject_by_section') {
						include("subject_by_section.php");
					} elseif ($url == 'track') {
						include("track.php");
					} elseif ($url == 'list_of_personnel') {
						include("list_of_personnel.php");
					}
					//Examination 
					elseif ($url == 'rat_exam') {
						include("rat_exam.php");
					} elseif ($url == 'pisa_exam') {
						include("pisa_exam.php");
					} elseif ($url == 'pisa_question') {
						include("pisa_question.php");
					} elseif ($url == 'memo_details') {
						include("memo_details.php");
					} elseif ($url == 'all_notification') {
						include("all_notification.php");
					} elseif ($url == 'ict_form_report') {
						include("ict_portal.php");
					} elseif ($url == 'cloud_storage') {
						include("cloud_storage.php");
					} elseif ($url == 'division_advisory') {
						include("division_advisory.php");
					} elseif ($url == 'locator_details') {
						include("locator_details.php");
					} elseif ($url == 'idmaker') {
						include("idmaker.php");
					} elseif ($url == 'dcppackage') {
						include("dcppackage.php");
					} elseif ($url == 'account_reset') {
						include("account_reset.php");
					} elseif ($url == 'dcpinventory') {
						include("dcpinventory.php");
					} elseif ($url == 'certificate_maker') {
						include("certificate_maker.php");
					} elseif ($url == 'supply_coordinator') {
						include("supply_coordinator.php");
					} elseif ($url == 'list_of_applicant') {
						include("list_of_applicant.php");
					} elseif ($url == 'kinder_level') {
						include("kinder_level.php");
					} elseif ($url == 'elementary_level') {
						include("elementary_level.php");
					} elseif ($url == 'secondary_level') {
						include("secondary_level.php");
					} elseif ($url == 'senior_high_level') {
						include("senior_high_level.php");
					} elseif ($url == 'individual_rating') {
						include("individual_rating.php");
					} elseif ($url == 'transaction_report') {
						include("transaction_report.php");
					} elseif ($url == 'pcdmis_update') {
						include("pcdmis_update.php");
					} elseif ($url == 'ipcrf_consol') {
						include("ipcrf_consol.php");
					} elseif ($url == 'view_ipcrf_by_school') {
						include("view_ipcrf_by_school.php");
					}
					//Sypply Inventory
					elseif ($url == 'asds_school') {
						include("asds_school.php");
					} elseif ($url == 'asds_report') {
						include("asds_report.php");
					} elseif ($url == 'AnnexA1') {
						include("AnnexA1.php");
					} elseif ($url == 'AnnexA2') {
						include("AnnexA2.php");
					} elseif ($url == 'AnnexA3') {
						include("AnnexA3.php");
					} elseif ($url == 'AnnexA4') {
						include("AnnexA4.php");
					} elseif ($url == 'AnnexA5') {
						include("AnnexA5.php");
					} elseif ($url == 'AnnexA6') {
						include("AnnexA6.php");
					} elseif ($url == 'AnnexA7') {
						include("AnnexA7.php");
					} elseif ($url == 'AnnexA8') {
						include("AnnexA8.php");
					} elseif ($url == 'AnnexA9') {
						include("AnnexA9.php");
					} elseif ($url == 'AnnexA10') {
						include("AnnexA10.php");
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
			<div class="modal-content"></div>
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
				<h3 class="text-center">Successfully Submitted!</h3>
			</div>
			<div class="modal-footer">
				<a href="" class="btn btn-success">Continue...</a>
			</div>
		</div>
	</div>
</div>