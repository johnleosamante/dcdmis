<?php
$mysched=mysqli_query($con,"SELECT * FROM tbl_distribution_schedule");
$rowdata=mysqli_fetch_assoc($mysched);
$_SESSION['quarter']=$rowdata['QuarterNo'];					 		
$_SESSION['week']=$rowdata['WeekNo'];		
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

	<style>
	th,td{
		text-transform:uppercase;
	}
	</style>
                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 	<a href="#viewmodule" data-toggle="modal" class="btn btn-primary" style="float:right;">Upload</a>
                     
						<h4>Module's Masterlist</h4>
						<?php
						if (isset ($_POST['Import']))
						{
							date_default_timezone_set("Asia/Manila");
							$dateposted = date("Y-m-d H:i:s");
							$myfile="../lrms_files/".$_POST['filename'];
							mysqli_query($con,"INSERT INTO tbl_list_of_modules VALUES(NULL,'".$dateposted."','".$_POST['QuarterNo']."','".$_POST['GLevel']."','".$_POST['subjectname']."','".$myfile."','".$_SESSION['uid']."','0')");

							if (mysqli_affected_rows($con)==1)
							{
							$Err = "Modules Successfully uploaded!";
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
                         <table class="table table-striped table-bordered table-hover" id="dataTables-example">
						  <thead>	
								<tr>
									<th style="width:5%;">#</th>
									<th style="width:15%;">Date Posted</th>
									
									<th style="width:15%;">Grade Level</th>
									<th>Learning Areas</th>
									<th style="width:10%;"># of Downloaded</th>
									<th style="width:7%;"></th>
									
								</tr>
						  </thead>
						  <tbody>
						   <?php
							$no=0;
							$result=mysqli_query($con,"SELECT * FROM tbl_list_of_modules INNER JOIN tbl_employee ON tbl_list_of_modules.postedBy = tbl_employee.Emp_ID ORDER BY tbl_list_of_modules.Date_Posted Desc");
							while ($row=mysqli_fetch_array($result))
							{
								$no++;
							 echo '<tr>
									<td>'.$no.'</td>
									<td>'.$row['Date_Posted'].'</td>
									';
									if ($row['Grade_Level']=='Kinder')
									{
										echo '<td>'.$row['Grade_Level'].'</td>';
									}else{
										echo '<td>Grade '.$row['Grade_Level'].'</td>';
									}
									echo '<td>'.$row['Filename'].'</td>
									
									<td style="text-align:center;">'.$row['No_of_download'].'</td>
									<td>
									<a href="list_of_school_downloaded.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4cb65d14a30bd76c1c7355c4dde7773181724cda4c&id='.$row['No'].'" target="_blank">List</a> <br/>
									<a href="'.$row['filelocation'].'" target="_blank">View</a><br/>
									<a onclick="delete_record(this.id);" id="'.$row['No'].'" style="cursor:pointer;">Delete</a>
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
				

 <script>
	
		function delete_record(id)
		{
			if(confirm("Are you sure you want to deleted?"))
			{
				window.location.href='delete_modules.php?id='+id;
			}
		}
	
	
	</script>   	
  

  
						 <div class="panel-body">
                            
                            <!-- Modal -->
                            <div class="modal fade" id="viewmodule" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog">
                                    <div class="modal-content">
																		
												  <div class="modal-header">
												 
												  <h3 class="modal-title"><center>Upload Module</center></h3>
												 
												</div>
												<div class="modal-body">
												
												<form enctype="multipart/form-data" method="post" role="form" action="">
											<div class="form-group">
																				
											<label>Date Posted:</label><span class="error">* </span>
											<input type="date" name="Dposted" class="form-control" value="<?php echo date("Y-m-d");?>" disabled>
											
											<label>Learning Areas: <span class="error">* </span></label>
											<input type="text" name="subjectname" class="form-control" placeholder="Enter subject" required>
											<label>Quarter: <span class="error">* </span></label>
											<select name="QuarterNo" class="form-control">
											 <option value="Quarter 2">Quarter 2</option>
											 <option value="Quarter 1">Quarter 1</option>
											 <option value="Quarter 3">Quarter 3</option>
											 <option value="Quarter 4">Quarter 4</option>
											</select>
											<label>Grade Level: <span class="error">* </span></label>
											<select name="GLevel" class="form-control">
											 <option value="">--select--</option>
											 <option value="Kinder">Kinder</option>
											 <option value="01">Grade 1</option>
											 <option value="02">Grade 2</option>
											 <option value="03">Grade 3</option>
											 <option value="04">Grade 4</option>
											 <option value="05">Grade 5</option>
											 <option value="06">Grade 6</option>
											 <option value="07">Grade 7</option>
											 <option value="08">Grade 8</option>
											 <option value="09">Grade 9</option>
											 <option value="10">Grade 10</option>
											 <option value="11">Grade 11</option>
											 <option value="12">Grade 12</option>
											</select>
											<input type="hidden" id="filedata" name="filename" required>
												<div id="container">
												<label>Attachment</label><br/>
												<span id="pickfiles" style="cursor:pointer;"><button class="btn btn-secondary">Choose File</button></span>				
												</div>
												 <div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>	
											</div>
											<div class="modal-footer">
											<button type="submit" class="btn btn-primary" name="Import" value="Import">Upload</button>
											 <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
											</div>
										</form>	
													
												
												
		
											</div>
                                       
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        </div>
                        <!-- .panel-body -->