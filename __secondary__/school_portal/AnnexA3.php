<?php
if (isset($_POST['saveannex']))
	{
		mysqli_query($con,"INSERT INTO tbl_sep_annexa3 VALUES('".date("yhmis")."','".date("Y-m-d")."','".$_POST['fund_cluster']."','".$_POST['icsno']."','".$_SESSION['school_id']."')");
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
					     <h4>INVENTORY CUSTODIAN SLIP<h4>
					
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th  width="15%" style="text-align:center;">Date</th>
                                        <th  width="50%" style="text-align:center;">Fund Cluster</th>
                                        <th width="50%">ICS No.</th>
                                         <th width="7%" style="text-align:center;"></th>                                      
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								$result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa3 WHERE SEP_SchoolID ='".$_SESSION['school_id']."' ORDER BY CardCode Desc");
								while($row=mysqli_fetch_array($result))
								{
									$no++;
								
								 echo '<tr>
											<td style="text-align:center;">'.$no.'</td>
											<td style="text-align:center;">'.$row['Date_created'].'</td>
											<td style="text-align:center;">'.$row['Fund_cluster'].'</td>
											<td>'.$row['SEP_ICSNo'].'</td>
											<td style="text-align:center;">
											<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code='.urlencode(base64_encode($row['CardCode'])).'&v='.urlencode(base64_encode("view_ics_reports")).'">VIEW</a>
											 <br/><a style="cursor:pointer;" id="'.$row['CardCode'].'" onclick="delete_me(this.id)">DEL</a>
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
				 <div class="col-lg-3">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <h4><center><i>INSTRUCTIONS</i></center><h4>
						 <small><center>Please read carefully.</center></small>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" style="text-align:right;overflow-x:auto;height:560px;">
						  <a href="instruction/Annex3.png" target="_blank"><img src="instruction/Annex3.png" style="width:100%;height:500px;"></a>
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
		window.location.href='remove_annexA3.php?id='+id;
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
		<label>ICS No:</label>
		<input type="text" name="icsno" class="form-control" required>
		
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