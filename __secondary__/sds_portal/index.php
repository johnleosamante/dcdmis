<?php
include("../_includes_/function.php");
if($_SESSION['uid']=="")
	{
		header('location:'.GetSiteURL());
	}else{
		if ((time() - $_SESSION['last_login_timestamp'])>14400)//14400=240*60
		{
			header('location:' . GetSiteURL() . '/logout');
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
$url=$_GET[$key]=base64_decode(urldecode($data));
	
}
$str=sha1(GetSiteTitle());
?>

		
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
     
	
    
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
					include("../_includes_/layout/navbar-brand.php");
			    ?>
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
                <div class="sidebar-nav navbar-collapse" >
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
				if (!isset($url)){
					 include("dashboard.php");
				}else{
				 if ($url=='dashboard')
			 {
				 include("dashboard.php");
			 }
			 elseif ($url=='list_of_school')
			 {
				 include("list_of_school.php");
			 }
			  elseif ($url=='leaves')
			 {
				 include("leaves.php");
			 }
			 elseif ($url=='transaction')
			 {
				 include("view-transaction.php");
			 }
			  elseif ($url=='view_log')
			 {
				 include("view-log.php");
			 }
			 elseif ($url=='announcement')
			 {
				 include("list_of_announcement.php");
			 }
			elseif ($url=='update_transaction')
			 {
				 include("edit-transaction.php");
			 }elseif ($url=='transaction_verifier')
			 {
				 include("document-verifier.php");
			 }
			 elseif ($url=='canceled_transaction')
			 {
				 include("canceled-transaction.php");
			 }
			 elseif ($url=='quatame')
			 {
				 include("evaluation-form.php");
			 }
			 elseif ($url=='view_school')
			 {
				 include("view_profile.php");
			 }
			  elseif ($url=='service_rcord')
			 {
				 include("service_record.php");
			 }
			  elseif ($url=='list_of_activity')
			 {
				 include("list_of_activity.php");
			 }
			  elseif ($url=='erf')
			 {
				 include("erf.php");
			 }
			  elseif ($url=='steps')
			 {
				 include("steps.php");
			 }
			  elseif ($url=='personnel')
			 {
				 include("personnel.php");
			 }
			   elseif ($url=='retirable')
			 {
				 include("retirable.php");
			 }
			  elseif ($url=='leaves')
			 {
				 include("leaves.php");
			 }
			   elseif ($url=='myprofile')
			 {
				 include("my_porfile.php");
			 }
			 elseif ($url=='district')
			 {
				 include("view_details.php");
			 }
			 elseif ($url=='transfer')
			 {
				 include("request_for_transfer.php");
			 }
			  elseif ($url=='dtr')
			 {
				 include("dtr.php");
			 }elseif ($url=='view_list')
			 {
				 include("view_list.php");
			 }elseif ($url=='other_list')
			 {
				 include("other_list.php");
			 }
			  elseif ($url=='newtransaction')
			 {
				 include("newtransaction.php");
			 }elseif ($url=='settings')
			{
				include("setting.php");
			}elseif ($url=='view_list')
			{
			include("view_list.php");
			}elseif ($url=='new_participants')
			{
			 include("new_participants.php");
			}elseif ($url=='new_participants')
			{
			 include("new_participants.php");
			}elseif ($url=='profile')
			{
			 include("profile.php");
			}elseif ($url=='memo_details')
			{
			 include("memo_details.php");
			}elseif ($url=='all_notification')
			{
			 include("all_notification.php");
			}elseif ($url=='ipcrf')
			{
			 include("ipcrf.php");
			}elseif ($url=='division_memo')
			{
			 include("division_memo.php");
			}elseif ($url=='division_advisory')
			{
			 include("division_advisory.php");
			}elseif ($url=='locators')
			{
			 include("locators.php");
			}elseif ($url=='vehicle')
			{
			 include("vehicle.php");
			}elseif ($url=='pts')
			{
			 include("personnel_bulletin.php");
			}elseif ($url=='ipcrfconsol')
			{
			 include("ipcrfconsol.php");
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
	

	</div></div>
</div>
  </div>
 
 
 

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
				$myDistrict=mysqli_query($con,"SELECT * FROM tbl_district ORDER BY District_code Asc");
				while($rowdist=mysqli_fetch_array($myDistrict))
				{
				$no=$no+1;
				$d_data=mysqli_query($con,"SELECT * FROM tbl_school INNER JOIN tbl_district ON tbl_school.District_code = tbl_district.District_code INNER JOIN tbl_station ON tbl_school.SchoolID=tbl_station.Emp_Station INNER JOIN tbl_employee ON tbl_station.Emp_ID =tbl_employee.Emp_ID WHERE tbl_school.District_code ='".$rowdist['District_code']."' AND tbl_station.Emp_age>='60' AND tbl_employee.Emp_Status <>'Retired'")or die ("Error Employee Query");	
				echo '<tr>
					<td>'.$no.'</td>
					<td>'.$rowdist['District_Name'].'</td>
					<td>'.mysqli_num_rows($d_data).'</td>
					<td>						
					   
					<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&d='.urlencode(base64_encode($rowdist['District_code'])).'&v='.urlencode(base64_encode("district")).'"> View</a>
														
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
      <div class="modal fade" id="mytransaction" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
         <div style="width:60%;height:auto;margin-left:auto;margin-right:auto;">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>List of Pending transactions </h4>
        </div>
        <div class="modal-body" style="overflow-x:auto;">
		 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%" >#</th>
                                        <th width="15%" >Transaction Code</th>
                                        <th width="20%" >Title</th>
										<th width="20%" >Date/Time Created</th>
                                        <th width="20%"> From </th>
                                        <th width="5%" ></th>
                                        
                                    </tr>
									
                                </thead>
                                <tbody>
								<?php
								$no=0;
								$mytrans=mysqli_query($con,"SELECT * FROM tbl_transactions WHERE Trans_Stats='On Process' ORDER BY Date_time  Desc");
								while($row=mysqli_fetch_array($mytrans))
								{
									$no++;
									echo '<tr>
											<td>'.$no.'</td>
											<td>'.$row['TransCode'].'</td>
											<td>'.$row['Title'].'</td>
											<td>'.$row['Date_time'].'</td>
											<td>'.$row['Trans_from'].'</td>
											<td><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&id='.urlencode(base64_encode($row['TransCode'])).'&v='.urlencode(base64_encode("view_log")).'"><i class="fa  fa-desktop  fa-fw"></i></a> </td>
											
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

