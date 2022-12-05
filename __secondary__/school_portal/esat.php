<?php
$year=$_SESSION['sy']-1;
if (!is_dir('../../pcdmis/ipcrf_files/'.$year)) {
    mkdir('../../pcdmis/ipcrf_files/'.$year, 0777, true);
}
//$_SESSION['IPLocation']='../../pcdmis/ipcrf_files/'.$year;
$_SESSION['IPLocation']='../ipcrf_files/';
?>
<script>
      window.addEventListener("load", function () 
      {
        var path = "../js/";
        var uploader = new plupload.Uploader(
        {
          runtimes: 'html5,flash,silverlight,html4',
          flash_swf_url: path + 'Moxie.swf',
          silverlight_xap_url: path + '/Moxie.xap',
          browse_button: 'pickfiles',
          container: document.getElementById('container'),
          url: 'uploadfile.php',
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
			    if (file.percent==100)
				{
				document.getElementById("btnEnable").disabled  =false;	
				}
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
	<div class="col-lg-12">
	  <h1></h1>
	</div>
<div class="col-lg-12">
                    <div class="panel panel-default">
					
                        <div class="panel-heading">
						<a href="#myPersonnel" class="btn btn-primary" data-toggle="modal" style="float:right;margin:4px;padding:4px;">ADD FILE</a>
					<h3>IPCRF CONSOLIDATED REPORT</h3>
					<?php
					if (isset ($_POST['submit']))
						{
							date_default_timezone_set("Asia/Manila");
							$dateposted = date("Y-m-d H:i:s");
							$myfile=$_SESSION['IPLocation']."/".$_POST['filename'];
							mysqli_query($con,"INSERT INTO tbl_ipcrf_upload VALUES(NULL,'".$dateposted."','".$_POST['FName']."','".$myfile."','".$_SESSION['school_id']."','".$_SESSION['uid']."','".$_SESSION['year']."')");

							if (mysqli_affected_rows($con)==1)
							{
							$Err = "IPCRF Successfully uploaded!";
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
                        <div class="panel-body">
						
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%" style="text-align:center;">#</th>
                                        <th width="15%">DATE</th>
                                        <th>FILENAME</th>
                                        <th width="10%" style="text-align:center;">YEAR</th>
                                        <th width="7%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								$result=mysqli_query($con,"SELECT * FROM tbl_ipcrf_upload WHERE tbl_ipcrf_upload.SchoolID='".$_SESSION['school_id']."'");
								while($row=mysqli_fetch_array($result))
								{
									$no++;
								echo '<tr>
                                        <td style="text-align:center;">'.$no.'</th>
                                        <td>'.$row['DateUpload'].'</th>
                                        <td>'.$row['FileName'].'</td>
                                        <td style="text-align:center;">'.$row['Year'].'</td>
                                        <td style="text-align:center;">
											<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&No='.urlencode(base64_encode($row['No'])).'&v='.urlencode(base64_encode("view_esst_consol")).'">VIEW</a><br/><a style="cursor:pointer;" id="'.$row['No'].'" onclick="delete_me(this.id)">DELETE</a>
										</td>
                                    </tr>';
								}
								?>
                                </tbody>
                            </table>
                            
                        </div>
                        </div>
                        </div>
                    
					<script>
					function delete_me(id)
					{
						if (confirm("Are you sure you want to delete this information?"))
						{
							alert("Successfully Deleted.");
							window.location.href="delete_essat.php?id="+id;
						}
					}
					</script>
					
					
					
  <div class="panel-body">

    <!-- Modal -->
      <div class="modal fade" id="myPersonnel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
           <div class="modal-dialog">
     <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        
		  <h4 class="modal-title"><center>UPLOAD FILES</center></h4>
        </div>
         <form enctype="multipart/form-data" method="post" role="form" action="">
		  <div class="modal-body">
		<input type="hidden" id="filedata" name="filename" required>
		<div id="container">
		<label>Filename (SchoolName_ConsoladatedIPCRF_SAT_2021)</label><br/>
		<input type="text" name="FName" class="form-control" placeholder="Enter Filename">
		 <label>School Year:</label>
		 <select name="year" class="form-control">
		 <option value="">--Select--</option>
		 <?php
		 $myyear=mysqli_query($con,"SELECT * FROM tbl_school_year ORDER BY SYCode Desc");
		 while($rowyear=mysqli_fetch_array($myyear))
		 {
			 echo '<option value="'.$rowyear['SYCode'].'">'.$rowyear['SchoolYear'].'</option>';
		 }
		 ?>
		 </select>
		 </div>
		  <div class="modal-footer">
		 <input type="submit" name="submit" class="btn btn-primary" value="SAVE" id="btnEnable">
		   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		 </div>
		 </form>
		
		
	   </div>
		 </div>
	 	  </div>
			 </div>					