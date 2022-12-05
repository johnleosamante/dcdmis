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
<!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>
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
					<div class="masthead container-fluid">

				  <div class="media" style="margin-top: 10px;margin-bottom:10px">
					<div class="col-lg-12" style="padding:10px;">
							<img src="../logo/logo.png" width="50" height="50" align="left" style="padding:1px;">
							<label style="padding:0px;margin:0px;font-size:25px;">DEPARTMENT OF EDUCATION</label><br/>
							<small style="padding:0px;margin:0px;font-size:14px;">PAGADIAN CITY DIVISION </small><hr>
											
						</div>
						
				  </div>
				    
				  
				</div>
			 </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
					 <div class="panel-heading">
                     <a href="#myprocurement" class="btn btn-primary" style="float:right;" data-toggle="modal">New Procurement</a>
					  
				  <h2>List of Procurement</h2>
				  		<?php
						if (isset($_POST['philgeps_add']))
						{
							mysqli_query($con,"INSERT INTO tbl_philgeps VALUES('".$_POST['referenceNo']."','".$_POST['Notice_of_Title']."','".$_POST['Mode_of_procurement']."','".$_POST['classification']."','".$_POST['Agencyname']."','".$_POST['Pub_date']."','".$_POST['Close_date']."','New')");
							if (mysqli_affected_rows($con)==1)
							{
							$Err = "Successfully saved";
									echo '<script type="text/javascript">
										$(document).ready(function(){						
										$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
										});</script>
										';	
								echo '<div class="alert alert-success">'.$Err.'</div>';
							}
						}
						?>						
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          <table width="100%" class="table table-striped table-bordered table-hover"  id="dataTables-example">
                     <thead>
								<tr>
									<th width="15%">Bid Notice Reference Number</th>
									<th >Notice of Title</th>
									<th>Mode of Procurement</th>
									<th>Classification</th>
									<th>Agency Name</th>
									<th width="15%">Publish Date</th>
									<th width="15%">Closing Date</th>
								</tr>
								
							</thead>
							<tbody>
							<?php
							$result=mysqli_query($con,"SELECT * FROM tbl_philgeps WHERE Status<>'Done'");
							while($row=mysqli_fetch_array($result))
							{
							echo '<tr>
									<td>'.$row['BidReference'].'</td>
									<td>'.$row['Notice_title'].'</td>
									<td>'.$row['Mode_of_procurement'].'</td>
									<td>'.$row['Classification'].'</td>
									<td>'.$row['Agency_name'].'</td>
									<td>'.$row['Publish_date'].'</td>
									<td>'.$row['Closing_date'].'</td>
								</tr>';
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
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="myprocurement" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>NEW PROCUREMENT</center></h3>
        </div>
		<form action="philgeps.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c" Method="POST">
        <div class="modal-body">
		<label>Bid Notice Reference Number:</label>
		<input type="text" class="form-control" name="referenceNo" required autofocus>
		<label>Notice of Title:</label>
		<textarea name="Notice_of_Title" class="form-control" rows="3" required ></textarea>
		<label>Mode of Procurement:</label>
		<select name="Mode_of_procurement" class="form-control">
		<option value="">--Select--</option>
		<option value="DepEd-City">DepEd City </option>
		<option value="DepEd-Region">DepEd Region</option>
		</select>
		<label>Classification:</label>
		<select name="classification" class="form-control">
		<option value="">--Select--</option>
		<option value="DepEd-City">DepEd City </option>
		<option value="DepEd-Region">DepEd Region</option>
		</select>
		<label>Agency Name:</label>
		<input type="text" name="Agencyname" class="form-control" required>
		<label>Publish Date:</label>
		<input type="date" name="Pub_date" class="form-control" required>
		
		<label>Closing Date:</label>
		<input type="date" name="Close_date" class="form-control" required>
				
		</div>
		 <div class="modal-footer">
		<input type="submit" name="philgeps_add" Value="SUBMIT" class="btn btn-success">
		</div>
		</form>
		
		      </div>
		      </div>
			  </div></div>
		
	