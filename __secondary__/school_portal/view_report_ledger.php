<?php
if (isset($_POST['saverecord']))
	{
		mysqli_query($con,"INSERT INTO tbl_sep_annexa2_card VALUES(NULL,'".$_POST['date_apply']."','".$_POST['sepseference']."','".$_POST['QTY']."','".$_POST['unitcost']."','".$_POST['ITA']."','".$_POST['AIL']."','".$_POST['Adjusted_cost']."','".$_POST['Nature_of_repair']."','".$_POST['amount']."','".$_GET['code']."')") or die("error");
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
						 <a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=QW5uZXhBMg%3D%3D" class="btn btn-secondary" style="float:right;margin:4px;padding:4px;">Back</a>
					     <h4>SEMI-EXPENDABLE LEDGER CARD<h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						 <a href="#newannex" class="btn btn-primary" style="float:right;margin:4px;padding:4px;" data-toggle="modal">Add Report</a>
						 <?php
						 $_SESSION['CardCode']=$_GET['code'];
						 $result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa2 WHERE CardCode='".$_GET['code']."' LIMIT 1");
						 $rowsep=mysqli_fetch_assoc($result);
						 echo '<label>Fund Cluster: <input type="text" class="form-control" value="'.$rowsep['Fund_cluster'].'" disabled></label>
						 <label>Semi-expendable Property: <input type="text" class="form-control"  value="'.$rowsep['SEP'].'" disabled></label>
						 <label>Semi-expendable Property No.: <input type="text" class="form-control" disabled  value="'.$rowsep['SEPNo'].'" ></label>
						 <label>UACS Object Code: <input type="text" class="form-control" disabled  value="'.$rowsep['UACSCode'].'" ></label>
						 <label>Repair History: <input type="text" class="form-control" disabled  value="'.$rowsep['Repair_history'].'" ></label>
						 <label style="width:35%;">Description: <input type="text" class="form-control" disabled  value="'.$rowsep['SEP_Description'].'"></label><hr/>';
						 ?>
						 
						 
                            <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="10%" rowspan="2">Date</th>
                                        <th width="15%"  rowspan="2">Reference</th>
                                        <th  colspan="3">Receipt</th>
                                         <th width="10%"  rowspan="2">Issues /Transfers /Adjustment's</th>
                                         <th width="10%"  rowspan="2">Accumulated Impairment Losses</th>                                      
                                         <th width="10%" rowspan="2">Adjusted Cost</th>                                      
                                         <th width="10%" rowspan="2">Nature of rapair</th>                                      
                                         <th width="10%" rowspan="2">Amount</th>                                      
                                    </tr>
									<tr>
										<th >Qty</th>
										<th>Unit Cost</th>
										<th >Total Cost</th>
										
									</tr>
                                </thead>
                                <tbody>
								<?php
								$balance=$subtotal=$remaining=$TotalCost=0;
								$result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa2_card WHERE SEPCode ='".$_GET['code']."' ORDER BY Date_received Desc");
								while($row=mysqli_fetch_array($result))
								{
									$TotalCost=$row['Received_QTY']*$row['Received_unit_cost'];
								 echo '<tr>
											<td>'.$row['Date_received'].'</td>
											<td>'.$row['Reference'].'</td>
											<td>'.$row['Received_QTY'].'</td>
											<td>'.number_format($row['Received_unit_cost'],2).'</td>
											<td>'.number_format($TotalCost,2).'</td>
											<td>'.$row['ITA'].'</td>
											<td>'.$row['AIL'].'</td>
											<td>'.$row['Adjusted_cost'].'</td>
											<td>'.$row['Nature_of_repair'].'</td>
											<td>'.$row['Amount'].'</td>
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
				   alert("Record is successfully deleted." + id);
				   window.location.href="delete_ledger_card.php?code="+id;
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
		<label>Date:</label>
		<input type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" name="date_apply">
		<label>Reference:</label>
		<input type="text" name="sepseference" class="form-control" required>
		<label>Quantity:</label>
		<input type="text" name="QTY" class="form-control" required >
		<label>Unit Cost:</label>
		<input type="text" name="unitcost" class="form-control" required>
		<label>Issues /Transfer /Adjustment's:</label>
		<input type="text" name="ITA" class="form-control" required>
		<label>Accumulated Impairment Losses:</label>
		<input type="text" name="AIL" class="form-control" required>
		<label>Adjusted Cost:</label>
		<input type="text" name="Adjusted_cost" class="form-control" required>
		<label>Nature of Repair:</label>
		<input type="text" name="Nature_of_repair" class="form-control" required>
		<label>Amount:</label>
		<input type="text" name="amount" class="form-control" required>
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