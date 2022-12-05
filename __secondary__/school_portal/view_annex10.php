<?php
if (isset($_POST['saverecord']))
	{
		mysqli_query($con,"INSERT INTO tbl_sep_annexa10_card VALUES(NULL,'".$_POST['Date_aquired']."','".$_POST['Particular']."','".$_POST['SEPNo']."','".$_POST['qty']."','".$_POST['unit_cost']."','".$_POST['AIL']."','".$_POST['amount']."','".$_POST['remarks']."','".$_GET['code']."')") or die("error");
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
	td,th{
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
                <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=QW5uZXhBMTA%3D" class="btn btn-secondary" style="float:right;margin:4px;padding:4px;">Back</a>
					     <h4>INVENTORY AND INSPECTION REPORT OF UNSERVICEABLE SEMI-EXPENDABLE PROPERTY<h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						 <a href="#newannex" class="btn btn-primary" style="float:right;margin:4px;padding:4px;" data-toggle="modal">Add Report</a>
						 <?php
						 $_SESSION['CardCode']=$_GET['code'];
						 $result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa10 WHERE CardCode='".$_GET['code']."' LIMIT 1");
						 $rowsep=mysqli_fetch_assoc($result);
						 echo '<label>Fund Cluster: <input type="text" class="form-control" value="'.$rowsep['Fund_cluster'].'" disabled></label>
						 <label>Accountable Officer: <input type="text" class="form-control"  value="'.$rowsep['Accountable_Officer'].'" disabled></label>
						 <label>Designation: <input type="text" class="form-control"  value="'.$rowsep['Designation'].'" disabled></label>
						 <hr/>';
						 ?>
						 
						 
                            <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="10%">Date Aquired</th>
                                        <th>Particular</th>
                                        <th width="10%">Semi-expendable Property No</th>
                                        <th  width="10%" >Quantity</th>                          
                                         <th width="10%">Unit Cost</th>                                      
                                         <th width="10%">Total Cost</th>                                      
                                         <th width="10%">Accumulated Impairment Losses</th>                                      
                                         <th width="10%">Carrying Amount</th>                                      
                                         <th width="10%">Remarks</th>                                      
                                         <th width="5%"></th>                                      
                                                                         
                                    </tr>
									
                                </thead>
                                <tbody>
								<?php
								$total=0;
								$result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa10_card WHERE SEPCode ='".$_GET['code']."' ORDER BY Particular Asc");
								while($row=mysqli_fetch_array($result))
								{
									$total=$row['Quantity']*$row['Unit_cost'];
								 echo '<tr>
											<td>'.$row['Date_aquired'].'</td>
											<td>'.$row['Particular'].'</td>
											<td>'.$row['SEPNo'].'</td>
											<td>'.$row['Quantity'].'</td>
											<td>'.number_format($row['Unit_cost'],2).'</td>
											<td>'.number_format($total,2).'</td>
											<td>'.$row['AIL'].'</td>
											<td>'.$row['CarryingAmount'].'</td>
											<td>'.$row['Remarks'].'</td>
											<td><a style="cursor:pointer;" id="'.$row['CardNo'].'" onclick="delete_me(this.id)">Del</a></td>
											
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
				
                </div>
          
		  
		  <script>
		   function delete_me(id)
		   {
			   if(confirm("Are you sure you want to delete entire row?"))
			   {
				   alert("Record is successfully deleted.");
				   window.location.href="delete_annex10_card.php?code="+id;
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
             <h3 class="modal-title"><center>New Records</center></h3>
			</div>
		 <form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		<label>Date Acquired:</label>
		<input type="date"  class="form-control" name="Date_aquired" required>
		<label>Particular:</label>
		<input type="text" name="Particular" class="form-control" required>
		<label>Semi-expendable Property No:</label>
		<input type="text" name="SEPNo" class="form-control" required >
		<label>QTY:</label>
		<input type="text" name="qty" class="form-control" required>
		<label>Unit Cost:</label>
		<input type="text" name="unit_cost" class="form-control" required>
		<label>Accumulated Impairment Losses:</label>
		<input type="text" name="AIL" class="form-control" required>
		<label>Carrying Amount:</label>
		<input type="number" name="amount" class="form-control" required>
		<label>Remarks:</label>
		<input type="text" name="remarks" class="form-control" required>
		</div>
		<div class="modal-footer">
		    <input type="submit" name="saverecord" id="myBtn" value="SUBMIT" class="btn btn-primary">
			 <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		</div>
		</form>
		</div>
	</div>
	</div>
</div>