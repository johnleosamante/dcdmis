<?php
session_start();
include("../vendor/jquery/function.php");
if ($_SESSION['EmpID']=="")
{
	header('location:https://'.$_SERVER['HTTP_HOST'].'/pcdmis');
}
$data=mysqli_query($con,"SELECT * FROM tbl_student WHERE lrn='".$_SESSION['search_LRN']."' LIMIT 1");
$search=mysqli_fetch_assoc($data);
$_SESSION['stud_name']=$search['Lname'].', '.$search['FName'].' '.$search['MName'];

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

    <title>PCDMIS-date-enrolled</title>
	<link rel="shortcut icon" href="../shs/h1.png">
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
    <![endif]-->
	
	<script>
{
   document.addEventListener('contextmenu', event => event.preventDefault());
}
   </script> 
  <style type="text/css">

        .wizard {
            margin: 20px auto;
            background: #fff;
        }

        .wizard .nav-tabs {
            position: relative;
            margin: 40px auto;
            margin-bottom: 0;
            border-bottom-color: #e0e0e0;
        }

        .wizard > div.wizard-inner {
            position: relative;
        }

        .connecting-line {
            height: 2px;
            background: #e0e0e0;
            position: absolute;
            width: 80%;
            margin: 0 auto;
            left: 0;
            right: 0;
            top: 50%;
            z-index: 1;
        }

        .wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
            color: #555555;
            cursor: default;
            border: 0;
            border-bottom-color: transparent;
        }

        span.round-tab {
            width: 70px;
            height: 70px;
            line-height: 70px;
            display: inline-block;
            border-radius: 100px;
            background: #fff;
            border: 2px solid #e0e0e0;
            z-index: 2;
            position: absolute;
            left: 0;
            text-align: center;
            font-size: 25px;
        }
        span.round-tab i{
            color:#555555;
        }
        .wizard li.active span.round-tab {
            background: #fff;
            border: 2px solid #337ab7;

        }
        .wizard li.active span.round-tab i{
            color: #337ab7;
        }

        span.round-tab:hover {
            color: #333;
            border: 2px solid #333;
        }

        .wizard .nav-tabs > li {
            width: 25%;
        }

        .wizard li:after {
            content: " ";
            position: absolute;
            left: 46%;
            opacity: 0;
            margin: 0 auto;
            bottom: 0px;
            border: 5px solid transparent;
            border-bottom-color: #337ab7;
            transition: 0.1s ease-in-out;
        }

        .wizard li.active:after {
            content: " ";
            position: absolute;
            left: 46%;
            opacity: 1;
            margin: 0 auto;
            bottom: 0px;
            border: 10px solid transparent;
            border-bottom-color: #337ab7;
        }

        .wizard .nav-tabs > li a {
            width: 70px;
            height: 70px;
            margin: 20px auto;
            border-radius: 100%;
            padding: 0;
        }

        .wizard .nav-tabs > li a:hover {
            background: transparent;
        }

        .wizard .tab-pane {
            position: relative;
            padding-top: 50px;
        }

        .wizard h3 {
            margin-top: 0;
        }

        @media( max-width : 585px ) {

            .wizard {
                width: 90%;
                height: auto !important;
            }

            span.round-tab {
                font-size: 16px;
                width: 50px;
                height: 50px;
                line-height: 50px;
            }

            .wizard .nav-tabs > li a {
                width: 50px;
                height: 50px;
                line-height: 50px;
            }

            .wizard li.active:after {
                content: " ";
                position: absolute;
                left: 35%;
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
		 <div class="wizard" style="margin-bottom: 50px;">
        <div class="wizard-inner">
            <div class="connecting-line"></div>
            <ul class="nav nav-tabs" role="tablist">

                <li role="presentation" >
                    <a aria-controls="step1" role="tab" title="Select type" href="my_subject.php?link=<?php echo sha1("deped pagadian city data management information system.");?>">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-list-alt"></i>
                            </span>
                    </a>
                </li>

                <li role="presentation" class="">
                    <a aria-controls="step2" role="tab" title="Search"  href="search-data.php?link=<?php echo sha1("deped pagadian city data management information system.");?>"
                       onclick="event.preventDefault(); el = document.getElementById('clicked_button_full_name'); el.remove(); document.getElementsByTagName('form')[0].submit() "  >
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-search"></i>
                            </span>
                    </a>
                </li>
                <li role="presentation" class="active">
                    <a   aria-controls="step3" role="tab" title="Date of Enrollment" href="#"
                                                 >
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                    </a>
                </li>

                <li role="presentation" class="disabled">
                    <a   aria-controls="step3" role="tab" title="Complete">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-user"></i>
                            </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
	        <?php
			if (isset($_POST['submit']))
				{
				$confirm=mysqli_query($con,"SELECT * FROM first_semester WHERE lrn='".$_SESSION['search_LRN']."' AND school_year = '".$_SESSION['year']."'LIMIT 1");	
				$num=mysqli_num_rows($confirm);
				
						echo '<script type="text/javascript">
						{
							alert("Learner is already enrolled!");
							window.location.href="search-lrn.php?link=504ff5437e8ddee701081fcb6dd849cf24a3a657";
						}	
						</script>
							';	
					
					
				}
			?>
             <form  action="date-enrolled.php?link=<?php echo sha1("Deped Pagadian Data management information system.");?>" method="POST" enctype="multipart/form-data">
    
				<div class="row">
					<div class="col-lg-12">
						<ul class="list-unstyled">
							<li>
								<b> Step 1: <?php
									echo 'Grade - '.$_SESSION['grade'].' '. $_SESSION['SecName'].' <br/> ';
									echo $_SESSION['Per_Name'].'<br/>';
								?></b>
							</li>
							<li>
								<b>Step 2: <?php echo $_SESSION['stud_name'];?></b>
							</li>
								<b>Step 3: Date of Enrollment <br/><label style="width:20%;"><input type="date" name="date_enroll" value="<?php echo date("Y-m-d"); ?>" class="form-control"></label></b>
							</li>
						</ul>
					</div>
				</div>
			<div style="margin-bottom: 100px">
						<input type="submit" class="btn btn-primary" name="submit" value="Continue"></button>
					   
					</div>				
				 </form>
        </div>
		</div>

        
   
	</div>
</div>

							
            
   
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
