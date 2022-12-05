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
					 date_default_timezone_set("Asia/Manila");
					 $dateposted = date("Y-m-d H:i:s");				 
					mysqli_query($con,"INSERT INTO wp_news VALUES(NULL,'".$_POST['file_description']."','".$_POST['department']."','".$_SESSION['uid']."','".$dateposted."','".$_SESSION['school_id']."')");
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
							   <h4>SCHOOL NEWS</h4>
						   </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
								   <th style="width:7%;text-align:center;">#</th>
								   <th width="15%">Date posted</th>
								   <th>News Script</th>
								   <th width="25%">Posted by</th>
								   <th width="5%"></th>
								 </tr>  
							</thead>
							<tbody>	
							 <?php
							 $no=0;
								$mymessage=mysqli_query($con,"SELECT * FROM wp_news INNER JOIN tbl_employee ON wp_news.PostedBy = tbl_employee.Emp_ID WHERE wp_news.SchoolID='".$_SESSION['school_id']."'");
								while ($row=mysqli_fetch_assoc($mymessage))
								{
								$no++;
								 echo '<tr>
											<td>'.$no.'</td>
											<td>'.$row['DatePosted'].'</td>
											<td>'.$row['News_details'].'</td>
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
		 		<label>Department</label>
				<select name="department" class="form-control" required>
				 <option value="">--select--</option>
				 <option value="English">English</option>
				 <option value="Science">Science</option>
				 <option value="Mathematics">Mathematics</option>
				 
				</select>
		 		<label>File Description</label>
				<textarea name="file_description" class="form-control" rows="4" required></textarea><br/>
							
		</div>
            <div class="modal-footer">                           
			<input type="submit" name="submit_file" value="SUBMIT" style="cursor:pointer;" class="btn btn-primary">
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
 	
 