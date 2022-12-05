<div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>               
			  <div class="col-lg-12">
				 <?php
				 if (isset($_POST['submit_file']))
				 {
					 ini_set('mysql.connect_timeout',300);
					 ini_set('default_socket_timeout',300);
					 date_default_timezone_set("Asia/Manila");
					 $dateposted = date("Y-m-d H:i:s");
					 
					 $uploaddir= '../../files/downloads/';
					 $mylocation = $uploaddir . basename($_FILES['myfile']['name']);
					
					move_uploaded_file($_FILES['myfile']['tmp_name'], $mylocation);
					 
					mysqli_query($con,"INSERT INTO wp_download VALUES(NULL,'".$dateposted."','".$_POST['filename']."','".$mylocation."','".$_SESSION['uid']."','".$_SESSION['school_id']."')");
					if (mysqli_affected_rows($con)==1)
					 {
						 $Err = "School Organizational chart Successfully Saved";
									echo '<script type="text/javascript">
										$(document).ready(function(){						
										$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
										});</script>
										';	
								echo '<div class="alert alert-success">'.$Err.'</div>';
						 
					 }
				 }
				 ?>
                    <div class="panel panel-default">
					
                         <div class="panel-heading">
						 <?php
						  echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("website")).'" style="float:right;" class="btn btn-secondary">Back</a>';
						 	?>
							<a style="float:right;cursor:pointer;" class="btn btn-primary" onclick="addfile()">Add</a>
							   <h4>DOWNLOADABLE FILES</h4>
						   </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
								   <th style="width:7%;text-align:center;">#</th>
								   <th width="15%">Date posted</th>
								   <th>File Description</th>
								   <th width="25%">Posted by</th>
								   <th width="5%"></th>
								 </tr>  
							</thead>
							<tbody>	
							 <?php
							 $no=0;
								$mymessage=mysqli_query($con,"SELECT * FROM wp_download INNER JOIN tbl_employee ON wp_download.PostedBy = tbl_employee.Emp_ID WHERE wp_download.SchoolID='".$_SESSION['school_id']."'");
								while ($row=mysqli_fetch_assoc($mymessage))
								{
								$no++;
								 echo '<tr>
											<td>'.$no.'</td>
											<td>'.$row['Date_posted'].'</td>
											<td>'.$row['Filename'].'</td>
											<td>'.$row['Emp_LName'].', '.$row['Emp_FName'].'</td>
											<td style="text-align:center;"><a href="" data-toggle="modal" data-target="#updates_file">EDIT</a></td>
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
			function addfile()
			{
			  $('#add_file').modal({
				show: 'true'
			}); 	
			}			
		</script>
		
    <!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="add_file" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Add New Downloadable files</h4>
			</div>
			<form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-body">
		 		<label>File Description</label>
				<input type="text" name="filename" class="form-control"><br/>
				<input type="file" name="myfile"  style="cursor:pointer;" onchange="loadFile(event)" required>
				
		</div>
            <div class="modal-footer">                           
			<input type="submit" name="submit_file" value="Save" style="cursor:pointer;" class="btn btn-primary">
			</div>
			</form>	
                                       

	</div></div>
	</div>
  </div>
 	
 
    <!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="updates_file" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Update Downloadable files</h4>
			</div>
			<form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-body">
		 		
				<input type="file" name="picture"  style="cursor:pointer;" onchange="loadFile(event)" required>
				
		</div>
            <div class="modal-footer">                           
			<input type="submit" name="computer_laboratory" value="Save" style="cursor:pointer;" class="btn btn-primary">
			</div>
			</form>	
                                       

	</div></div>
	</div>
  </div>
 	
 