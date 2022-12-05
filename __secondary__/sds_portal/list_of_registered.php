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
	
	        
    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>
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
   #header-holder{
	   margin-top: 70px;
	   margin-bottom:10px;
   }
   @media 
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {
			 #header-holder{
						 margin-top: 120px;
						 margin-bottom:10px;
					}
					
		}
   
	td{
		text-transform:uppercase;
	}
	.graph_holder{
		float:left;
		position:relative;
		padding:4px;
		margin:4px;
		font-size:12px;
		
	}
	.graph_holder span{
		text-align:center;
	}
	.graph_fill{
		
		width:35px;
		height:290px;
		border-radius:.3em;
		text-align:center;
		 background: #ebebeb;
	}
	.progress-fill
	{
	  position:absolute;
	  background: #825;
	  width: 35px;
	  bottom:20px;
	}
	.img-holder-male{
		float:left;
		width:50%;
		
	}
	.img-holder-male span{
		position:absolute;
		left:160px;
		bottom:80px;
		font-size:24px;
		width:50px;
		height:50px;
		background:#ebebeb;
		text-align:center;
		border-radius:50%;
		color:red;
	}
	.img-holder-female{
		float:left;
		width:50%;
		
	}
	.img-holder-female span{
		position:absolute;
		right:80px;
		bottom:80px;
		font-size:24px;
		width:50px;
		height:50px;
		background:#ebebeb;
		text-align:center;
		border-radius:50%;
		line-height: normal;
		color:red;
	}
	</style>      
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top">
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

      <div class="media" style="margin-top: 50px;margin-bottom:10px">
        <div class="col-lg-12" style="padding:10px;">
				<img src="../logo/logo.png" width="50" height="50" align="left" style="padding:1px;">
				<?php
					$schooldata=mysqli_query($con,"SELECT * FROM tbl_school WHERE tbl_school.SchoolID='".$_GET['id']."'");
						 $srow=mysqli_fetch_assoc($schooldata);
					echo '<div class="media-body">

								 <label style="padding:0px;margin:0px;font-size:25px;text-transform:uppercase;">'.$srow['SchoolName'].'</label><br/>
						<p>
						  <small style="padding:0px;margin:0px;font-size:14px;">Region IX / '.$srow['Address'].' / Zamboanga Peninsula</small>
						</p>
								</div>';
						?>					
            </div>
			
      </div>
    </div>
 </div>
 
            <!-- /.row -->
            <div class="row">
                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 	<h4> Summary Reports</h4>
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          <div class="row">
                                <div class="col-lg-6">
									<div class="panel panel-default">
										<div class="panel-heading">
											<center>Summary as of Today <br/><i style="font-size:24px;color:red;"><?php echo date("Y-m-d"); ?></i></center>
										</div>
										<!-- /.panel-heading -->
										<div class="panel-body">
										<?php	
										$totalmale=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn=tbl_student.lrn WHERE tbl_student.Gender='Male'  AND tbl_registration.SchoolID='".$_GET['id']."'");
											echo '<div class="img-holder-male">
												<img src="../images/Male.png" width="200" height="250" align="left" title="Total Number Male"  style="border-radius:50%;padding:4px;margin:14px;">
											<span title="Total Male">'.mysqli_num_rows($totalmale).'</span>
											</div>';	
											$totalfemale=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn=tbl_student.lrn WHERE tbl_student.Gender='Female' AND tbl_registration.SchoolID='".$_GET['id']."'");
										
											echo '<div class="img-holder-female">
												<img src="../images/Female.png" width="200" height="250" align="left" title="Total Number Female" style="border-radius:50%;padding:4px;margin:14px;">
											<span title="Total Female">'.mysqli_num_rows($totalfemale).'</span>
											</div>';
											
											?>
										</div>
										<!-- /.panel-body -->
									</div>
									<!-- /.panel -->
								</div>
                                <!-- /.col-lg-4 (nested) -->
                                <div class="col-lg-6">
								<div class="panel panel-default">
									<div class="panel-heading">
										Graph by year Level as of Today <i style="font-size:14px;color:red;"><?php echo date("Y-m-d"); ?></i>
									</div>
									<!-- /.panel-heading -->
									<div class="panel-body">
									<center>
									<?php
									$totreg=$perdatanur=0;
									$tot=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.SchoolID='".$_GET['id']."' ");
									$totreg=mysqli_num_rows($tot);
									
									 if ($_GET['Cat']=='Elementary')
									 {
																			
										$perdatak1=0;
										$grdk1=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade='Kinder 1' AND tbl_registration.SchoolID='".$_GET['id']."'");
										$perk1=mysqli_num_rows($grdk1);	
										if ($totreg<>0)
										{
										$datak1=$perk1/$totreg;
										$perdatak1=number_format($datak1*100,0); 
										}
										echo '<div class="graph_holder">
											  <div class="graph_fill" title="Total Number of Learner in Kinder 1 ('.$perk1.')">
											  <span>'.$perk1.'</span>	
											      <div class="progress-fill" style="height:'.$perdatak1.'%;">
													
												 </div>
											  </div>
											  <small>Kinder 1</small>
										</div>'; 
										
										$perdatak2=0;
										$grdk2=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade='Kinder 2' AND tbl_registration.SchoolID='".$_GET['id']."'");
										$perk2=mysqli_num_rows($grdk2);	
										if ($totreg<>0)
										{
										$datak2=$perk2/$totreg;
										$perdatak2=number_format($datak2*100,0); 
										}
										echo '<div class="graph_holder">
											  <div class="graph_fill" title="Total Number of Learner in Kinder 2 ('.$perk2.')">
											  <span>'.$perk2.'</span>	
											      <div class="progress-fill" style="height:'.$perdatak2.'%;">
													
												 </div>
											  </div>
											  <small>Kinder 2</small>
										</div>'; 
										
										$perdatag1=0;
										$grdg1=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade='1' AND tbl_registration.SchoolID='".$_GET['id']."'");
										$perg1=mysqli_num_rows($grdg1);	
										if ($totreg<>0)
										{
										$datag1=$perg1/$totreg;
										$perdatag1=number_format($datag1*100,0); 
										}
										echo '<div class="graph_holder">
											  <div class="graph_fill" title="Total Number of Learner in Grade 1 ('.$perg1.')">
											  <span>'.$perg1.'</span>	
											      <div class="progress-fill" style="height:'.$perdatag1.'%;">
													
												 </div>
											  </div>
											  <small>Grade 1</small>
										</div>'; 
										
										$perdatag2=0;
										$grdg2=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade='2' AND tbl_registration.SchoolID='".$_GET['id']."'");
										$perg2=mysqli_num_rows($grdg1);	
										if ($totreg<>0)
										{
										$datag2=$perg2/$totreg;
										$perdatag2=number_format($datag2*100,0); 
										}
										echo '<div class="graph_holder">
											  <div class="graph_fill" title="Total Number of Learner in Grade 2 ('.$perg2.')">
											  <span>'.$perg2.'</span>	
											      <div class="progress-fill" style="height:'.$perdatag2.'%;">
													
												 </div>
											  </div>
											  <small>Grade 2</small>
										</div>'; 
										
										$perdatag3=0;
										$grdg3=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade='3' AND tbl_registration.SchoolID='".$_GET['id']."'");
										$perg3=mysqli_num_rows($grdg3);	
										if ($totreg<>0)
										{
										$datag3=$perg3/$totreg;
										$perdatag3=number_format($datag3*100,0); 
										}
										echo '<div class="graph_holder">
											  <div class="graph_fill" title="Total Number of Learner in Grade 3 ('.$perg3.')">
											  <span>'.$perg3.'</span>	
											      <div class="progress-fill" style="height:'.$perdatag3.'%;">
													
												 </div>
											  </div>
											  <small>Grade 3</small>
										</div>'; 
										
										$perdatag4=0;
										$grdg4=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade='4' AND tbl_registration.SchoolID='".$_GET['id']."'");
										$perg4=mysqli_num_rows($grdg4);	
										if ($totreg<>0)
										{
										$datag4=$perg4/$totreg;
										$perdatag4=number_format($datag4*100,0); 
										}
										echo '<div class="graph_holder">
											  <div class="graph_fill" title="Total Number of Learner in Grade 4 ('.$perg4.')">
											  <span>'.$perg4.'</span>	
											      <div class="progress-fill" style="height:'.$perdatag4.'%;">
													
												 </div>
											  </div>
											  <small>Grade 4</small>
										</div>'; 
										
										$perdatag5=0;
										$grdg5=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade='5' AND tbl_registration.SchoolID='".$_GET['id']."'");
										$perg5=mysqli_num_rows($grdg5);	
										if ($totreg<>0)
										{
										$datag5=$perg5/$totreg;
										$perdatag5=number_format($datag5*100,0); 
										}
										echo '<div class="graph_holder">
											  <div class="graph_fill" title="Total Number of Learner in Grade 1 ('.$perg5.')">
											  <span>'.$perg5.'</span>	
											      <div class="progress-fill" style="height:'.$perdatag5.'%;">
													
												 </div>
											  </div>
											  <small>Grade 5</small>
										</div>'; 
										
										$perdatag6=0;
										$grdg6=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade='6' AND tbl_registration.SchoolID='".$_GET['id']."'");
										$perg6=mysqli_num_rows($grdg6);	
										if ($totreg<>0)
										{
										$datag6=$perg6/$totreg;
										$perdatag6=number_format($datag6*100,0); 
										}
										echo '<div class="graph_holder">
											  <div class="graph_fill" title="Total Number of Learner in Grade 1 ('.$perg6.')">
											  <span>'.$perg6.'</span>	
											      <div class="progress-fill" style="height:'.$perdatag6.'%;">
													
												 </div>
											  </div>
											  <small>Grade 6</small>
										</div>'; 
										
									 }else if ($_GET['Cat']=='Secondary')
									 {
										 $perdata7=0;
										$grd7=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade='7' AND tbl_registration.SchoolID='".$_GET['id']."'");
										$per7=mysqli_num_rows($grd7);	
										if ($totreg<>0)
										{
										$data7=$per7/$totreg;
										$perdata7=number_format($data7*100,0);
										}
									 echo '<div class="graph_holder">
											  <div class="graph_fill" title="Total Grade 7 Learners ('.$perdata7.'%)">
												<span>'.$per7.'</span>	
											      <div class="progress-fill" style="height:'.$perdata7.'%;">
												 </div>
											  </div>
												 
											  <small>Grade 7</small>
										</div>';
										$perdata8=0;
										$grd8=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade='8' AND tbl_registration.SchoolID='".$_GET['id']."'");
										$per8=mysqli_num_rows($grd8);
										if ($totreg<>0)
										{
										$data8=$per8/$totreg;
										$perdata8=number_format($data8*100,0);
										}
										echo '<div class="graph_holder">
											  <div class="graph_fill" title="Total Grade 8 Learners ('.$perdata8.'%)">
											  <span>'.$per8.'</span>	
											      <div class="progress-fill" style="height:'.$perdata8.'%;">
													
												 </div>
											  </div>
												 
											  <small>Grade 8</small>
										</div>';
										$perdata9=0;
										$grd9=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade='9' AND tbl_registration.SchoolID='".$_GET['id']."'");
										$per9=mysqli_num_rows($grd9);
										if ($totreg<>0)
										{
										$data9=$per9/$totreg;
										$perdata9=number_format($data9*100,0);
										}
										echo '<div class="graph_holder">
											  <div class="graph_fill" title="Total Grade 9 Learners ('.$perdata9.'%)">
											  <span>'.$per9.'</span>	
											      <div class="progress-fill" style="height:'.$perdata9.'%;">
													
												 </div>
											  </div>
												 
											  <small>Grade 9</small>
										</div>';
										$perdata10=0;
										$grd10=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade='10' AND tbl_registration.SchoolID='".$_GET['id']."'");
										$per10=mysqli_num_rows($grd10);
										if ($totreg<>0)
										{
										$data10=$per10/$totreg;
										$perdata10=number_format($data10*100,0);
										}
										echo '<div class="graph_holder">
											  <div class="graph_fill" title="Total Grade 10 Learners ('.$perdata10.'%)">
											  <span>'.$per10.'</span>	
											      <div class="progress-fill" style="height:'.$perdata10.'%;">
													
												 </div>
											  </div>
												 
											  <small>Grade 10</small>
										</div>';
										$perdata11=0;
										$grd11=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade='11' AND tbl_registration.SchoolID='".$_GET['id']."'");
										$per11=mysqli_num_rows($grd11);
										if ($totreg<>0)
										{
										$data11=$per11/$totreg;
										$perdata11=number_format($data11*100,0);
										}
										echo '<div class="graph_holder">
											  <div class="graph_fill" title="Total Grade 11 Learners ('.$perdata11.'%)">
											  <span>'.$per11.'</span>
											      <div class="progress-fill" style="height:'.$perdata11.'%;">
														
												 </div>
											  </div>
												 
											  <small>Grade 11</small>
										</div>';
										$perdata12=0;
										$grd12=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade='12' AND tbl_registration.SchoolID='".$_GET['id']."'");
										$per12=mysqli_num_rows($grd12);
										if ($totreg<>0)
										{
										$data12=$per12/$totreg;
										$perdata12=number_format($data12*100,0);
										}
										echo '<div class="graph_holder">
											  <div class="graph_fill" title="Total Grade 12 Learners ('.$perdata12.'%)">
											  <span>'.$per12.'</span>	
											      <div class="progress-fill" style="height:'.$perdata12.'%;">
													
												 </div>
											  </div>
												 
											  <small>Grade 12</small>
										</div>';
									 }
									?>	
										
										
										</center>
										
									</div>
									<!-- /.panel-body -->
								</div>
								<!-- /.panel -->
							</div>
                                <!-- /.col-lg-8 (nested) -->
                            </div>
							<div class="row">
								<div class="col-lg-6">
								<div class="panel panel-default">
									<div class="panel-heading">
										List by Date Enroled
									</div>
									<!-- /.panel-heading -->
									<div class="panel-body">
									 <?php
							if ($_GET['Cat']=='Elementary')
							{
								echo '<table class="table table-striped table-bordered table-hover">
										<thead>
										
											<tr>
												<th>#</th>
												<th>Date</th>
												<th>Male</th>
												<th>Female</th>
												<th>Total</th>
												<th></th>
											</tr>	
											
										</thead>
										<tbody>';
										$no=0;
										$datereg=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."' GROUP By Date_enrolled ORDER BY Date_enrolled Asc");
										while($row=mysqli_fetch_array($datereg))
										{
											$no++;
											$tot=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Date_enrolled='".$row['Date_enrolled']."' AND  tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$totm=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Date_enrolled='".$row['Date_enrolled']."' AND  tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."' AND tbl_student.Gender='Male'");
											$totf=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Date_enrolled='".$row['Date_enrolled']."' AND  tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."' AND tbl_student.Gender='Female'");
											echo '<tr>
													<td>'.$no.'</td>
													<td>'.$row['Date_enrolled'].'</td>
													<td>'.mysqli_num_rows($totm).'</td>
													<td>'.mysqli_num_rows($totf).'</td>
													<td>'.mysqli_num_rows($tot).'</td>
													<td style="text-align:center;">
															<a href="" data-toggle="modal" data-target="#list-of-student"><i class="fa  fa-desktop fa-fw" title="View Students"></i></a>
													</td>
											</tr>';
										}	
										
										echo '</tbody>
									</table>';
							}elseif ($_GET['Cat']=='Secondary')
							{
								echo '<table class="table table-striped table-bordered table-hover">
										<thead>
										
											<tr>
												<th>#</th>
												<th>Date</th>
												<th>Male</th>
												<th>Female</th>
												<th>Total</th>
												
											</tr>	
											
										</thead>
										<tbody>';
										$no=$totalAll=0;
										$datereg=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."' GROUP By Date_enrolled ORDER BY Date_enrolled Asc");
										while($row=mysqli_fetch_array($datereg))
										{
											$no++;
											$tot=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Date_enrolled='".$row['Date_enrolled']."' AND  tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$totm=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Date_enrolled='".$row['Date_enrolled']."' AND  tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."' AND tbl_student.Gender='Male'");
											$totf=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Date_enrolled='".$row['Date_enrolled']."' AND  tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."' AND tbl_student.Gender='Female'");
											echo '<tr>
													<td>'.$no.'</td>
													<td>'.$row['Date_enrolled'].'</td>
													<td>'.mysqli_num_rows($totm).'</td>
													<td>'.mysqli_num_rows($totf).'</td>
													<td>'.mysqli_num_rows($tot).'</td>
													
											</tr>';
											$totalAll=$totalAll + mysqli_num_rows($tot);
										}	
										
										echo '</tbody>
									</table>';
									echo "Total Enroled: ".$totalAll;
							}	
							
							?></label>
									</div>
								</div>	
							 </div>	
							 <div class="col-lg-6">
								<div class="panel panel-default">
									<div class="panel-heading">
										List by Grade Level
									</div>
									<!-- /.panel-heading -->
									<div class="panel-body">
										<?php
							if ($_GET['Cat']=='Elementary')
							{
								echo '<table class="table table-striped table-bordered table-hover">
										<thead>
										
											<tr>
												<th>Grade Level</th>
												<th>Male</th>
												<th>Female</th>
												<th>Total</th>
												
											</tr>	
										</thead>
										<tbody>';
										
																				
										$kin1=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='Kinder 1' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
										$kin1m=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='Kinder 1' AND tbl_student.Gender='Male' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
										$kin1f=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='Kinder 1' AND tbl_student.Gender='Female' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
												echo '<tr>
													<td>Kinder 1</td>
													<td>'.mysqli_num_rows($kin1m).'</td>
													<td>'.mysqli_num_rows($kin1f).'</td>
													<td>'.mysqli_num_rows($kin1).'</td>
													
													
											</tr>';
											$kin2=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='Kinder 2' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$kin2m=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='Kinder 2' AND tbl_student.Gender='Male' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$kin2f=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='Kinder 2' AND tbl_student.Gender='Female' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
												echo '<tr>
													<td>Kinder 2</td>
													<td>'.mysqli_num_rows($kin2m).'</td>
													<td>'.mysqli_num_rows($kin2f).'</td>
													<td>'.mysqli_num_rows($kin2).'</td>
													
											</tr>';
											$g1=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='1' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g1m=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='1' AND tbl_student.Gender='Male' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g1f=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='1' AND tbl_student.Gender='Female' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
										
												echo '<tr>	
													<td>Grade 1</td>
													<td>'.mysqli_num_rows($g1m).'</td>
													<td>'.mysqli_num_rows($g1f).'</td>
													<td>'.mysqli_num_rows($g1).'</td>
													
											</tr>';
											$g2=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='2' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g2m=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='2' AND tbl_student.Gender='Male' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g2f=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='2' AND tbl_student.Gender='Female' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											
											echo '<tr>
													<td>Grade 2</td>
													<td>'.mysqli_num_rows($g2m).'</td>
													<td>'.mysqli_num_rows($g2f).'</td>
													<td>'.mysqli_num_rows($g2).'</td>
													
											</tr>';
											$g3=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='3' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g3m=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='3' AND tbl_student.Gender='Male' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g3f=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='3' AND tbl_student.Gender='Female' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
										
											echo '<tr>	
													<td>Grade 3</td>
													<td>'.mysqli_num_rows($g3m).'</td>
													<td>'.mysqli_num_rows($g3f).'</td>
													<td>'.mysqli_num_rows($g3).'</td>
													
											</tr>';
											$g4=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='4' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g4m=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='4' AND tbl_student.Gender='Male' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g4f=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='4' AND tbl_student.Gender='Female' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
										
											echo '<tr>
													<td>Grade 4</td>
													<td>'.mysqli_num_rows($g4m).'</td>
													<td>'.mysqli_num_rows($g4f).'</td>
													<td>'.mysqli_num_rows($g4).'</td>
													
											</tr>';
											$g5=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='5' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g5m=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='5' AND tbl_student.Gender='Male' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g5f=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='5' AND tbl_student.Gender='Female' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
										
											echo '<tr>
													<td>Grade 5</td>
													<td>'.mysqli_num_rows($g5m).'</td>
													<td>'.mysqli_num_rows($g5f).'</td>
													<td>'.mysqli_num_rows($g5).'</td>
													
											</tr>';
											$g6=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='6' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g6m=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='6' AND tbl_student.Gender='Male' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g6f=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='6' AND tbl_student.Gender='Female' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
										
											echo '<tr>
													<td>Grade 6</td>
													<td>'.mysqli_num_rows($g6m).'</td>
													<td>'.mysqli_num_rows($g6f).'</td>
													<td>'.mysqli_num_rows($g6).'</td>
													
											</tr>';
										echo '</tbody>
									</table>';
							}elseif ($_GET['Cat']=='Secondary')
							{
								echo '<table class="table table-striped table-bordered table-hover">
										<thead>
										
											<tr>
												<th>Grade Level</th>
												<th>Male</th>
												<th>Female</th>
												<th>Total</th>
												
											</tr>	
										</thead>
										<tbody>';
										$g7=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='7' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
										$g7m=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='7' AND tbl_student.Gender='Male' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
										$g7f=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='7' AND tbl_student.Gender='Female' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
												echo '<tr>
													<td>Grade 7</td>
													<td>'.mysqli_num_rows($g7m).'</td>
													<td>'.mysqli_num_rows($g7f).'</td>
													<td>'.mysqli_num_rows($g7).'</td>
													
											</tr>';
											$g8=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='8' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g8m=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='8' AND tbl_student.Gender='Male' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g8f=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='8' AND tbl_student.Gender='Female' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
										
												echo '<tr>	
													<td>Grade 8</td>
													<td>'.mysqli_num_rows($g8m).'</td>
													<td>'.mysqli_num_rows($g8f).'</td>
													<td>'.mysqli_num_rows($g8).'</td>
													
											</tr>';
											$g9=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='9' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g9m=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='9' AND tbl_student.Gender='Male' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g9f=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='9' AND tbl_student.Gender='Female' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											
											echo '<tr>
													<td>Grade 9</td>
													<td>'.mysqli_num_rows($g9m).'</td>
													<td>'.mysqli_num_rows($g9f).'</td>
													<td>'.mysqli_num_rows($g9).'</td>
													
											</tr>';
											$g10=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='10' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g10m=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='10' AND tbl_student.Gender='Male' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g10f=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='10' AND tbl_student.Gender='Female' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
										
											echo '<tr>	
													<td>Grade 10</td>
													<td>'.mysqli_num_rows($g10m).'</td>
													<td>'.mysqli_num_rows($g10f).'</td>
													<td>'.mysqli_num_rows($g10).'</td>
													
											</tr>';
											$g11=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='11' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g11m=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='11' AND tbl_student.Gender='Male' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g11f=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='11' AND tbl_student.Gender='Female' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
										
											echo '<tr>
													<td>Grade 11</td>
													<td>'.mysqli_num_rows($g11m).'</td>
													<td>'.mysqli_num_rows($g11f).'</td>
													<td>'.mysqli_num_rows($g11).'</td>
													
											</tr>';
											$g12=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='12' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g12m=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='12' AND tbl_student.Gender='Male' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
											$g12f=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn WHERE tbl_registration.Grade='12' AND tbl_student.Gender='Female' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_GET['id']."'");
										
											echo '<tr>
													<td>Grade 12</td>
													<td>'.mysqli_num_rows($g12m).'</td>
													<td>'.mysqli_num_rows($g12f).'</td>
													<td>'.mysqli_num_rows($g12).'</td>
													
											</tr>
										</tbody>
									</table>';
							}	
							
							?>
							 
									</div>
								</div>
								</div>
							</div>
							 <!-- /.row Ending -->
                            
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
      <div class="modal fade" id="myDTR" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
			  </div></div>
