<?php
if (isset($_POST['saveannex']))
	{
		mysqli_query($con,"INSERT INTO tbl_sep_annexa2 VALUES('".date("yhmis")."','".$_POST['fund_cluster']."','".$_POST['description']."','".$_POST['semi_expendable_property']."','".$_POST['semi_expendable_property_no']."','".$_POST['UACSCode']."','".$_POST['History']."','".$_SESSION['school_id']."')");
		if(mysqli_affected_rows($con)==1)
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
	<style>
	td{
		text-transform:uppercase;
		text-align:center;
	}
	</style>
             
            <!-- /.row -->
				
                <div class="col-lg-12">
                    <h1></h1>
                </div>
                <!-- /.col-lg-12 -->
          <div class="col-lg-12">
                    <h1></h1>
                </div>
            <div class="row">
                <div class="col-lg-9">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=YXNkc19yZXBvcnQ%3D" class="btn btn-secondary" style="float:right;margin:4px;padding:4px;">Back</a>
						 <a href="#newannex" class="btn btn-primary" style="float:right;margin:4px;padding:4px;" data-toggle="modal">Add Report</a>
					     <h4>SEMI-EXPENDABLE LEDGER CARD<h4>
					
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th  width="15%" style="text-align:center;">Fund Cluster</th>
                                        <th>Description</th>
                                        <th width="15%" style="text-align:center;">Semi-expendable Property</th>
                                        <th width="15%" style="text-align:center;">Semi-expendable Property-Number</th>
                                        <th width="15%" style="text-align:center;">UACS Object Code</th>
                                        <th width="15%" style="text-align:center;">Repair History</th>
                                         <th width="7%" style="text-align:center;"></th>                                      
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								$result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa2");
								while($row=mysqli_fetch_array($result))
									{
										$no++;
										echo '<tr>
												<td>'.$no.'</td>
												<td>'.$row['Fund_cluster'].'</td>
												<td>'.$row['SEP_Description'].'</td>
												<td>'.$row['SEP'].'</td>
												<td>'.$row['SEPNo'].'</td>
												<td>'.$row['UACSCode'].'</td>
												<td>'.$row['Repair_history'].'</td>
												<td style="text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code='.urlencode(base64_encode($row['CardCode'])).'&v='.urlencode(base64_encode("view_report_ledger")).'">VIEW</a> <br/><a style="cursor:pointer;" id="'.$row['CardCode'].'" onclick="delete_me(this.id)">DEL</a></td>
											
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
				 <div class="col-lg-3">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <h4><center><i>INSTRUCTIONS</i></center><h4>
						 <small><center>Please read carefully.</center></small>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" style="text-align:right;overflow-x:auto;height:560px;">
						 <a href="instruction/Annex2.jpg" target="_blank"><img src="instruction/Annex2.jpg" style="width:100%;height:500px;"></a>
						 </div>
					</div>
				  </div>
                </div>
                <!-- /.col-lg-12 -->



<script>
function delete_me(id)
{
	if (confirm("Are you sure you want to remove entire row?"))
	{
		alert("Information is successfully deleted|! ");
		window.location.href='remove_annexA2.php?id='+id;
	}
}
</script>



  <!-- Modal for Re-assign-->
   <div class="panel-body">
      <div class="modal fade" id="newannex" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
             <h3 class="modal-title"><center>New Semi-expendable Property Card</center></h3>
			</div>
		 <form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		<label>Entity Name:</label>
		<input type="text" value="<?php echo $_SESSION['SchoolName']; ?>" class="form-control" disabled >
		<label>Fund Cluster:</label>
		<input type="text" name="fund_cluster" class="form-control" required>
		<label>Description:</label>
		<textarea name="description" class="form-control" required rows="3"></textarea>
		<label>Semi-expendable Property:</label>
		<input type="text" name="semi_expendable_property" class="form-control" required>
		<label>Semi-expendable Property Number:</label>
		<input type="number" name="semi_expendable_property_no" class="form-control" required>
		<label>UACS Object Code:</label>
		<input type="text" name="UACSCode" class="form-control" required>
		<label>Repair History: </label>
		<input type="text" name="History" class="form-control" required>
		</div>
		<div class="modal-footer">
		    <input type="submit" name="saveannex" id="myBtn" value="SUBMIT" class="btn btn-primary">
			 <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		</div>
		</form>
		</div>
	</div>
	</div>
</div>