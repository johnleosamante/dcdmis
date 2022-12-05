<style>
th,td{
	text-transform:uppercase;
}
</style>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                       <div class="panel-heading">
					    <a href="#mytraining" class="btn btn-primary" style="float:right;" data-toggle="modal">New Training</a>
							<h2>List of Training</h2>
							<?php
							if (isset($_POST['training-data']))
							{
							mysqli_query($con,"INSERT INTO tbl_seminar VALUES('".$_POST['Tcode']."','".$_POST['TTitle']."','".$_POST['TFrom']."','".$_POST['TTo']."','".$_POST['TConduct']."','".$_POST['TVenue']."','-','".$_POST['TOffice']."','-','Certificate','-')");
	
							if (mysqli_affected_rows($con)==1)
							{
							?>
							<script type="text/javascript">
									$(document).ready(function(){						
										 $('#access').modal({
											show: 'true'
										}); 				
									});
									</script>
							<?php
							}
							}elseif (isset($_POST['update-data']))
							{
								mysqli_query($con,"UPDATE tbl_seminar SET Title_of_training='".$_POST['TTitle']."',covered_from='".$_POST['TFrom']."',covered_to='".$_POST['TTo']."',TVenue='".$_POST['TVenue']."' WHERE Training_Code='".$_SESSION['code']."' LIMIT 1");	
								if (mysqli_affected_rows($con)==1)
							{
								?>
							<script type="text/javascript">
									$(document).ready(function(){						
										 $('#access').modal({
											show: 'true'
										}); 				
									});
									</script>
							<?php
							}
							}
							?>
							
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%" rowspan="2">#</th>
												<th width="35%" rowspan="2">TITLE OF TRAININGS / ACTIVITIES</th>
												<th width="20%" colspan="2" >DATE COVERED</th>
												
												<th width="20%" rowspan="2">VENUE</th>
												<th width="7%" rowspan="2"></th>
											</tr>
										<tr>
											<th>FROM</th>
											<th>TO</th>
										</tr>										
									</thead>
									<tbody>
									
									<?php
									$no=0;
									$seminar=mysqli_query($con,"SELECT * FROM tbl_seminar WHERE Office='".$_SESSION['station']."'") or die ("error training data");
										while($row=mysqli_fetch_array($seminar))
										{
											$no++;
										echo '<tr><td style="text-align:center;">'.$no.'</td>
												<td>'.$row['Title_of_training'].'</td>
												<td>'.$row['covered_from'].'</td>
												<td>'.$row['covered_to'].'</td>
												
												<td>'.$row['TVenue'].'</td>
												
												<td class="dropdown">
												    <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code='.urlencode(base64_encode($row['Training_Code'])).'&v='.urlencode(base64_encode("view_list")).'"> View</a><br/>										 
													 <a href="edit-training.php?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code='.urlencode(base64_encode($row['Training_Code'])).'" data-toggle="modal" data-target="#editfile"> Edit</a><br/>
													  <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code='.urlencode(base64_encode($row['Training_Code'])).'&v='.urlencode(base64_encode("other_list")).'"> Speaker</a><br/>
													
													 <a style="cursor:pointer;" onclick="delete_me(this.id)" id="'.$row['Training_Code'].'"> Delete</a>										 
													 </td></tr>
												';
										}
													?>
									</tr>
									</tbody>
									</table>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
              
<script>
	function delete_me(id)
	{
		if(confirm("Are you sure you want to delete Entire row?"))
		{
			window.location.href="delete_seminar.php?id="+id;
		}
	}
</script>


<!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="editfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
   
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
			  </div></div>
		

			  
<!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="mytraining" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          
          <h3 class="modal-title"><center>ADD NEW TRAINING</center></h3>
		  	
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		<label>TRAININGS CODE:</label>
		<input type="text" class="form-control" value="<?php  echo $_SESSION['station'].'-'.date('Ydms'); ?>" disabled>
		<input type="hidden" name="Tcode" class="form-control" value="<?php  echo $_SESSION['station'].'-'.date('Ydms'); ?>" >
		<label>TITLE OF TRAININGS / ACTIVITIES:</label>
		<textarea name="TTitle" class="form-control" rows="3" required autofocus></textarea>
		
		<label>FROM:</label>
		<input type="date" name="TFrom" class="form-control" required>
		<label>TO:</label>
		<input type="date" name="TTo" class="form-control" required>
		<label>CONDUCTED BY:</label>
		<select name="TConduct" class="form-control">
		<option value="">--Select--</option>
		<option value="DepEd-City">DepEd City </option>
		<option value="DepEd-Region">DepEd Region</option>
		<option value="DepEd-Region">DepEd Central</option>
		</select>
		<label>VENUE:</label>
		<input type="text" name="TVenue" class="form-control" required>
		<input type="hidden" name="TOffice" class="form-control" value="<?php echo $_SESSION['station']; ?>">
		</div>
		 <div class="modal-footer">
		 
		<input type="submit" name="training-data" Value="SUBMIT" class="btn btn-primary">
		<button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		</div>
		</form>
		
		      </div>
		      </div>
			  </div></div>
		
