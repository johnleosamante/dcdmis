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
	th{
		text-transform:uppercase;
	}
	</style>
	
	<script src="js/plupload.full.min.js"></script>
   
	 
     <script>
      window.addEventListener("load", function () 
      {
        var path = "js/";
        var uploader = new plupload.Uploader(
        {
          runtimes: 'html5,flash,silverlight,html4',
          flash_swf_url: path + 'Moxie.swf',
          silverlight_xap_url: path + '/Moxie.xap',
          browse_button: 'pickfiles',
          container: document.getElementById('container'),
          url: 'uploadvideo.php',
          chunk_size: '200kb',
          max_retries: 2,
          filters: 
          {
            //max_file_size: '200mb',
            //mime_types: [{title: "Image files", extensions: "jpg,gif,png"}]
          },
         // resize://WE CAN REMOVE THIS IF WE WANT TO UPLOAD ORIGINA FILE
          //{
            //width: 500,
            //height: 500,
            //quality: 90,
          //},
          init: 
          {
            PostInit: function () 
            {
              document.getElementById('filelist').innerHTML = '';
            },
            FilesAdded: function (up, files) 
            {
              plupload.each(files, function (file) 
              {
                document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
              });
              uploader.start();
            },
            UploadProgress: function (up, file) 
            {
              document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
			  document.getElementById("filedata").value =file.name;
			             },
            Error: function (up, err) 
            {
              // DO YOUR ERROR HANDLING!
              console.log(err);
            }
          }
        });
        uploader.init();
      });
    </script>
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
				<label style="padding:0px;margin:0px;font-size:25px;">DEPARTMENT OF EDUCATION</label><br/>
				<small style="padding:0px;margin:0px;font-size:14px;">PAGADIAN CITY DIVISION </small>
								
            </div>
			
      </div>
    </div>
 </div>
 
            <!-- /.row -->
            <div class="row">
                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <a href="#new-files" data-toggle="modal" style="float:right;padding:4px;margin:4px;" class="btn btn-primary">Add New File</a>
               			 	<h4> List of files downloadable</h4>
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          
				<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
						<tr>
							<th width="5%" style="text-align:center;">#</th>
							<th width="40%">Filename</th>
							<th width="15%">Date Posted</th>
							<th width="15%">Posted by</th>
							<th width="7%"></th>
						</tr>
					</thead>
					<tbody>
					<?php
					$no=0;
					$result=mysqli_query($con,"SELECT * FROM tbl_downloads INNER JOIN tbl_user ON tbl_downloads.Emp_ID = tbl_user.usercode");
					while($row=mysqli_fetch_array($result))
					{
					$no++;	
					echo '<tr>
							<td style="text-align:center;">'.$no.'</td>
							<td>'.$row['Filename'].'</td>
							<td>'.$row['Date_uploaded'].'</td>
							<td>'.$row['Station'].' - '.$row['position'].'</td>
							<td class="dropdown" style="text-align:center;">
													
										<a class="dropdown-toggle" data-toggle="dropdown" href="#">
											<i class="fa fa-gear fa-fw"></i> <i class="fa fa-caret-down"></i>
										</a>
											<ul class="dropdown-menu dropdown-user">
																
												<li><a href="edit-files.php?id='.$row['FileCode'].'" data-target="#mypost" data-toggle="modal"><i class="fa fa-edit fa-fw"></i> Edit</a>
													</li>
												<li><a href="removed-downloadable.php?id='.$row['FileCode'].'"><i class="fa fa-trash-o fa-fw"></i> Trash</a>
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
	<style>
		.error{
			color:red;
			font-size:20px;
		}
	</style>
	
</body>
</html>


<style>
   
   .modal-footer{
	   background-color:#f9f9f9;
   }
   .loginbox{
	   width:60%;height:auto;margin-top:10px;margin-left:auto;margin-right:auto;
   }
   .file-upload{
	   width:35%;height:auto;margin-top:50px;margin-left:auto;margin-right:auto;
   }
   
		@media 
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {
			 .loginbox{
						width:100%;height:auto;margin-top:50px;margin-left:auto;margin-right:auto;
					}
					.file-upload{
						   width:100%;height:auto;margin-top:50px;margin-left:auto;margin-right:auto;
					   }
					 
		}
		
		.error{
			color:red;
			font-size:20px;
		}
   </style>
   
  <!-- Modal for Re-assign-->
<div class="panel-body">
 <!-- Modal for new video-->
  <div class="modal fade" id="new-files" role="dialog" data-backdrop="static" data-keyboard="false">
   <div class="file-upload">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>Add New Downloadable files </h4>
        </div>
		<form ENCTYPE="multipart/form-data" action="save-upload-file.php" Method="POST">
        <div class="modal-body">
		
		<label>Date Posted:</label><span class="error">* </span>
		<input type="date" name="Dposted" class="form-control" value="<?php echo date("Y-m-d");?>" disabled><br/>
		<label>Filename: <span class="error">* </span></label>
		<input type="text" name="File_name" class="form-control" placeholder="Enter file name" required><br/>
		<label>Attach File: <span class="error">* </span></label>
		<input type="file" name="upload" required>
        </div>
        <div class="modal-footer">
		<input type="submit" name="upload-down" value="Upload" class="btn btn-success" style="float:left;">
		<span class="error">* </span>Required fields
		</div>
		</form>
      </div>
	 
    </div>
  </div>
  </div>
 
 
<div class="panel-body">
  <!-- Modal for view data-->
  <div class="modal fade" id="mypost" role="dialog" data-backdrop="static" data-keyboard="false">
   <div class="file-upload">
      <!-- Modal content-->
      <div class="modal-content">
        
    </div>
  </div>
  </div>
  