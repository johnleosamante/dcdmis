<?php
if (isset($_POST['saverecord']))
	{
		mysqli_query($con,"INSERT INTO tbl_sep_annexa1_card VALUES(NULL,'".$_POST['date_apply']."','".$_POST['sepseference']."','".$_POST['QTY']."','".$_POST['unitcost']."','".$_POST['remarks']."','".$_GET['code']."')") or die("error");
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
						 <a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=QW5uZXhBMQ%3D%3D" class="btn btn-secondary" style="float:right;margin:4px;padding:4px;">Back</a>
					     <h4>SEMI-EXPENDABLE PROPERTY CARD<h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						 <a href="#newannex" class="btn btn-primary" style="float:right;margin:4px;padding:4px;" data-toggle="modal">Add Report</a>
						 <?php
						 $_SESSION['CardCode']=$_GET['code'];
						 $result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa1 WHERE CardCode='".$_GET['code']."' LIMIT 1");
						 $rowsep=mysqli_fetch_assoc($result);
						 echo '<label>Fund Cluster: <input type="text" class="form-control" value="'.$rowsep['Fund_cluster'].'" disabled></label>
						 <label>Semi-expendable Property: <input type="text" class="form-control"  value="'.$rowsep['SEP'].'" disabled></label>
						 <label>Semi-expendable Property No.: <input type="text" class="form-control" disabled  value="'.$rowsep['SEPNo'].'" ></label>
						 <label style="width:35%;">Description: <input type="text" class="form-control" disabled  value="'.$rowsep['SEP_Description'].'"></label><hr/>';
						 ?>
						 
						 
                            <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="10%" rowspan="2">Date</th>
                                        <th width="15%"  rowspan="2">Reference</th>
                                        <th  colspan="3">Receipt</th>
                                         <th width="10%"  rowspan="2">Balance</th>
                                         <th width="10%"  rowspan="2">Amount</th>                                      
                                         <th width="10%" rowspan="2">Remarks</th>                                      
                                         <th width="7%" rowspan="2"></th>                                      
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
								$result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa1_card WHERE SEPCode ='".$_GET['code']."' ORDER BY Date_received Desc");
								while($row=mysqli_fetch_array($result))
								{
									$mybalance=mysqli_query($con,"SELECT * FROM tbl_sep_annexa1_card_records WHERE SEPCode='".$_GET['code']."' AND CardNo='".$row['CardNo']."'");
									while($rowbal=mysqli_fetch_array($mybalance))
									{
									  $balance=$balance + $rowbal['Trans_QTY'];
									}
									$remaining=$row['Received_QTY']-$balance;
									$subtotal= $remaining * $row['Received_unit_cost'];
									$TotalCost=$row['Received_QTY']*$row['Received_unit_cost'];
								 echo '<tr>
											<td>'.$row['Date_received'].'</td>
											<td>'.$row['Reference'].'</td>
											<td>'.$row['Received_QTY'].'</td>
											<td>'.number_format($row['Received_unit_cost'],2).'</td>
											<td>'.number_format($TotalCost,2).'</td>
											<td>'.$remaining.'</td>
											<td>'.number_format($subtotal,2).'</td>
											<td>'.$row['Remarks'].'</td>
											<td><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code='.urlencode(base64_encode($row['CardNo'])).'&v='.urlencode(base64_encode("view_report_office")).'">VIEW</a><br/><a id="'.$row['CardNo'].'" style="cursor:pointer;" onclick="delete_me(this.id)">DEL</a></td>
											
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
				   window.location.href="delete_report_card.php?code="+id;
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