<?php
session_start();
include("../vendor/jquery/function.php");
if($_SESSION['uid']=="")
		{
				header('location:https://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}
$mycat=mysqli_query($con,"SELECT * FROM tbl_school WHERE SchoolID ='".$_SESSION['school_id']."' LIMIT 1");
$rowca=mysqli_fetch_assoc($mycat);		
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
    <title>LRMDS REPORT</title>
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
   </style>
 
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
				include("tagline.php");
				?>
           
            </div>
            <!-- /.navbar-header -->
			
            <ul class="nav navbar-top-links navbar-right" >
			
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
					 echo '

								<label style="padding:0px;margin:0px;font-size:25px;text-transform:uppercase;">'.$_SESSION['SchoolName'].'</label><br/>
								<small style="padding:0px;margin:0px;font-size:14px;">Region IX / '.$_SESSION['Address'].' / Zamboanga Peninsula</small>
						
								';
						?>					
            </div>
			
				  </div>
				</div>
			<?php
			 if (isset($_POST['submit']))
			 {
				 
					mysqli_query($con,"INSERT INTO tbl_senior_sub_strand VALUES('".$_POST['SubNo']."','".$_POST['Subdescription']."','".$_POST['SubStrand']."','".$_POST['Subtype']."')"); 
					
				if(mysqli_affected_rows($con)==1)
					{
					 $Err="Subject successfully submitted";	
					 echo '<script type="text/javascript">
					$(document).ready(function(){						
					$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
							
					});</script>';	
					echo '<div class="alert alert-success">'.$Err.'</div>';
					}
			 }
			?>
            
				<h3>ADD SUBJECT</h3>
            </div>
			
			
            <div class="row">
			<div class="col-lg-12">
			<form action="" Method="POST">
            <label>Subject No:</label>
			<input type="text" name="SubNo" value="<?php echo date('ymds');?>"class="form-control">
			<label>Subject Description:</label>
			<input type="text" name="Subdescription" class="form-control">
			<label>Subject Strand:</label>
			<select name="SubStrand" class="form-control">
			<option value="">--select--</option>
			<?php
			$strand=mysqli_query($con,"SELECt * FROM tbl_senior_strand");
			while ($rowstrand=mysqli_fetch_array($strand))
			{
				echo '<option value="'.$rowstrand['StrandCode'].'">'.$rowstrand['StrandDescription'].'</option>';
			}
			?>
			</select>
			<label>Subject Type:</label>
			<select name="Subtype" class="form-control">
			<option value="">--select--</option>
			<?php
			$strandtype=mysqli_query($con,"SELECt * FROM tbl_senior_strand_type");
			while ($rowtype=mysqli_fetch_array($strandtype))
			{
				echo '<option value="'.$rowtype['StrandCode'].'">'.$rowtype['StrandDescription'].'</option>';
			}
			?>
			</select><hr/>
			<input type="submit" name="submit" value="SAVE" class="btn btn-primary">
			</form>		
            </div>
         </div>
         </div>
        </div>
           
            
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

</body>
</html>