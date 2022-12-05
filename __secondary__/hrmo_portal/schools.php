<?php
session_start();
include("../vendor/jquery/function.php");
$_SESSION['dist']="";
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
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;">
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
                    <h1 class="page-header">School Masterlist</h1>
					
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
							<a href="#mySchool" class="btn btn-primary"data-toggle="modal">New School</a>
							 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="25%">School Name</th>
                                        <th width="25%">Address</th>
                                        <th width="20%">Principal</th>
                                        <th width="15%">Category</th>
                                        <th width="7%"></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
									$myinfo=mysqli_query($con,"SELECT * FROM tbl_school ORDER BY SchoolName Asc")or die ("School Information error");
									while($row=mysqli_fetch_array($myinfo))
									{
									$no=$no+1;
									$empdata=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID WHERE tbl_station.Emp_Station ='".$row['SchoolID']."'");
									$emp=mysqli_fetch_assoc($empdata);
                                      echo '<tr class="gradeA">
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['SchoolName'].'</td>
											<td>'.$row['Address'].'</td>
											<td>'.$emp['Emp_LName'].', '.$emp['Emp_FName'].'</td>
											<td style="text-align:center;">'.$row['School_Category'].'</td>
											<td class="dropdown">
													
															<a class="dropdown-toggle" data-toggle="dropdown" href="#">
																<i class="fa fa-gear fa-fw"></i> <i class="fa fa-caret-down"></i>
															</a>
															<ul class="dropdown-menu dropdown-user">
																<li><a href="validate_personnel.php?id='.$row['SchoolID'].'"><i class="fa  fa-user  fa-fw"></i> List of Personnel</a>
																</li>
																
																
															</ul>
															
														
													</td>
											
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
	   width:1000px;height:auto;margin-top:10px;margin-left:auto;margin-right:auto;
   }
		@media 
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {
			 .loginbox{
						width:100%;height:auto;margin-top:100px;margin-left:auto;margin-right:auto;
					}
		}
		
   </style>





 <div class="modal fade" id="mySchool" role="dialog">
    <div style="width:500px;height:auto;margin-top:100px;margin-left:auto;margin-right:auto;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><center>NEW SCHOOL ENTRY</center></h4>
        </div>
        <div class="modal-body">
		<form action="save_school.php" method="POST" style="font-size:18px;padding:4px;margin:4px;">
		 <dl class="dl-horizontal">
		
		<dt style="text-align:left;">SCHOOL ID:</dt><dd><input type="text" name="school_id"  style="padding:4px;margin:4px;width:100%;"class="form-control">  </dd>
		<dt style="text-align:left;">NAME:</dt><dd><input type="text" name="school_name"  style="padding:4px;margin:4px;width:100%;"class="form-control">  </dd>
		<dt style="text-align:left;">ADDRESS:</dt><dd><input type="text" name="school_address"  style="padding:4px;margin:4px;width:100%;"class="form-control">  </dd>
		<dt style="text-align:left;">ABBREVIATE:</dt><dd><input type="text" name="abrave"  style="padding:4px;margin:4px;width:100%;"class="form-control">  </dd>
		<dt style="text-align:left;">PRINCIPAL:</dt>
			<dd>
			<select class="form-control" name="principal">
			<option value="">--Select--</option>
			<?php
			$prin=mysqli_query($con,"SELECT * FROM tbl_employee ORDER BY Emp_LName Asc")or die ("Error PRINCIPAL");
			while($row=mysqli_fetch_array($prin))
				{
				echo '<option value="'.$row['Emp_ID'].'">'.$row['Emp_LName'].', '.$row['Emp_FName'].'</option>';
				}
			?>
			</select>
			</dd>
			<dt style="text-align:left;">CATEGORY:</dt>
			<dd>
			<select class="form-control" name="Category">
			<option value="">--Select--</option>
			<option value="Elementary">Elementary</option>
			<option value="Secondary">Secondary</option>
			
			</select>
			</dd>
		<dt style="text-align:left;">DISTRICT:</dt>
			<dd>
			<select class="form-control" name="District">
			<option value="">--Select--</option>
			<?php
			$prin=mysqli_query($con,"SELECT * FROM tbl_district")or die ("Error PRINCIPAL");
			while($row=mysqli_fetch_array($prin))
				{
				echo '<option value="'.$row['District_code'].'">'.$row['District_Name'].'</option>';
				}
			?>
			</select>
			</dd>
        </dl>
		<input type="submit" name="send" value="SAVE" style="cursor:pointer;font-size:18px;width:100%;height:50px;" class="btn btn-info btn-lg">
        </form>
		</div>
            </div>
			  </div></div>