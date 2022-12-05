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
    <meta name="description" content="DepEd Messages">

    <title>DepEd-Messages</title>

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
                <a class="navbar-brand" href="index.php">Teacher Portal</a>
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
				
					   <h1 class="page-header"> Messages</h1>
					
                </div>
                <!-- /.col-lg-12 -->
				<ul >
				  <?php
				  //For steps details
					$query_messages=mysqli_query($con,"SELECT * FROM tbl_messages WHERE Message_to='".$_SESSION['EmpID']."' ORDER BY Message_date Desc");
					while($rmessages=mysqli_fetch_array($query_messages))
						{
							if ($rmessages['Message_for']=='Steps')
							{
							echo '<div><a href="my_messages.php?id='.$rmessages['No'].'" data-target="#message" data-toggle="modal"><div>';
							}elseif ($rmessages['Message_for']=='ERF'){
								echo '<div><a href="my_application.php?id='.$rmessages['No'].'" data-toggle="modal" data-target="#myapp">
                                <div>';
							}elseif ($rmessages['Message_for']=='Training'){
							echo '<div><a href="view_training.php?id='.$rmessages['No'].'&&Code='.$rmessages['Message_details'].'" data-target="#message" data-toggle="modal">
                                <div>';	
							}
                                   echo '<strong>'.$rmessages['Message_from'].'</strong>
                                    <span class="pull-right text-muted">
                                        <em>'.$rmessages['Message_date'].'</em>
                                    </span>
                                </div>
                                <div>'.$rmessages['Message_details'].'</div>
                            </a></div><div class="page-header"></div>';
							
							
						}
						
					?>
					</ul>
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
   .box{
	   width:50%;height:auto;margin-top:10px;margin-left:auto;margin-right:auto;
   }
   .tranbox{
	   width:30%;height:auto;margin-top:10px;margin-left:auto;margin-right:auto;
   }
		@media 
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {
			 .box{
						width:100%;height:auto;margin-top:100px;margin-left:auto;margin-right:auto;
					}
					.tranbox{
						width:100%;height:auto;margin-top:10px;margin-left:auto;margin-right:auto;
					}
		}
		th{
			text-align:center;
		}
   </style>


 <!-- Modal for Re-assign-->
    <div class="modal fade" id="message" role="dialog" data-backdrop="static" data-keyboard="false">
     <div class="box">
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
			  </div></div>  

 <!-- Modal for Re-assign-->
    <div class="modal fade" id="myapp" role="dialog" data-backdrop="static" data-keyboard="false">
     <div class="tranbox">
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
			  </div></div>  
