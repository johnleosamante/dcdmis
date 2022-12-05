<?php
if (isset($_POST['saverecord']))
	{
		mysqli_query($con,"INSERT INTO tbl_sep_annexa4_card VALUES(NULL,'".$_POST['date_apply']."','".$_POST['ICSNo']."','".$_POST['SEPNo']."','".$_POST['item_description']."','".$_POST['EUL']."','".$_POST['IQTY']."','".$_POST['IssuedOffice']."','".$_POST['RQTY']."','".$_POST['ReturnOffice']."','".$_POST['RIQTY']."','".$_POST['RIOffice']."','".$_POST['Disposed']."','".$_POST['balance']."','".$_POST['amount']."','".$_POST['remarks']."','".$_GET['code']."')") or die("error");
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
						 <a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=QW5uZXhBNA%3D%3D" class="btn btn-secondary" style="float:right;margin:4px;padding:4px;">Back</a>
					     <h4>REGISTRY OF SEMI-EXPENDABLE PROPERTY ISSUED<h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						 <a href="#newannex" class="btn btn-primary" style="float:right;margin:4px;padding:4px;" data-toggle="modal">Add Report</a>
						 <?php
						 $_SESSION['CardCode']=$_GET['code'];
						 $result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa4 WHERE CardCode='".$_GET['code']."' LIMIT 1");
						 $rowsep=mysqli_fetch_assoc($result);
						 echo '<label>Fund Cluster: <input type="text" class="form-control" value="'.$rowsep['Fund_cluster'].'" disabled></label>
						 <label>Sheet No: <input type="text" class="form-control"  value="'.$rowsep['SheetNo'].'" disabled></label>
						 <label>Semi-expendable Property: <input type="text" class="form-control"  value="'.$rowsep['SEP'].'" disabled></label>
						 <hr/>';
						 ?>
						 
						 
                            <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="10%" rowspan="2">Date</th>
                                        <th width="10%"  colspan="2">Reference</th>
                                         <th rowspan="2">Item Description</th>
                                         <th width="15%"  rowspan="2">Estimated Useful Life</th>                                      
                                         <th width="15%" colspan="2">Issued</th>                                      
                                         <th width="15%" colspan="2">Return</th>                                      
                                         <th width="15%" colspan="2">Re-issued</th>                                      
                                         <th width="10%" >Disposed</th>                                      
                                         <th width="10%">Balance</th>                                      
                                         <th width="10%" rowspan="2">Amount</th>                                      
                                         <th width="10%" rowspan="2">Remarks</th>                                      
                                        
                                    </tr>
									<tr>
										<th>ICS/RRSP No</th>
										<th >Semi-expendable Property No.</th>
										<th >Qty</th>
										<th >Office/ Officer</th>
										<th >Qty</th>
										<th >Office/ Officer</th>
										<th >Qty</th>
										<th >Office/ Officer</th>
										<th >Qty</th>
										<th >Qty</th>
									</tr>
                                </thead>
                                <tbody>
								<?php
								$balance=$subtotal=$remaining=$TotalCost=0;
								$result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa4_card WHERE SEPCode ='".$_GET['code']."' ORDER BY Date_received Desc");
								while($row=mysqli_fetch_array($result))
								{
									 echo '<tr>
											<td>'.$row['Date_received'].'</td>
											<td>'.$row['ICS_RRS_No'].'</td>
											<td>'.$row['SEPNo'].'</td>
											<td>'.$row['Item_Description'].'</td>
											<td>'.$row['Estimated_useful_life'].'</td>
											<td>'.$row['Issued_QTY'].'</td>
											<td>'.$row['Issued_Office'].'</td>
											<td>'.$row['Return_QTY'].'</td>
											<td>'.$row['Return_Office'].'</td>
											<td>'.$row['Re_Issued_QTY'].'</td>
											<td>'.$row['Re_issued_Office'].'</td>
											<td>'.$row['Disposed'].'</td>
											<td>'.$row['Balance'].'</td>
											<td>'.$row['Amount'].'</td>
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
				   alert("Record is successfully deleted." + id);
				   window.location.href="delete_issued_card.php?code="+id;
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
		<label>ICS /RRSP No:</label>
		<input type="text" name="ICSNo" class="form-control" required>
		<label>Semi-expendable Property No.:</label>
		<input type="text" name="SEPNo" class="form-control" required >
		<label>Item Description:</label>
		<textarea name="item_description" class="form-control" required rows="2"></textarea>
		<label>Estimated Useful Life:</label>
		<input type="text" name="EUL" class="form-control" required>
		<label>Issued QTY:</label>
		<input type="text" name="IQTY" class="form-control" required>
		<label>Issued to (Office):</label>
		<input type="text" name="IssuedOffice" class="form-control" required>
		<label>Return QTY:</label>
		<input type="text" name="RQTY" class="form-control" required>
		<label>Return from (Office):</label>
		<input type="text" name="ReturnOffice" class="form-control" required>
		<label>Re-issued QTY:</label>
		<input type="text" name="RIQTY" class="form-control" required>
		<label>Re-issued to (Office):</label>
		<input type="text" name="RIOffice" class="form-control" required>
		<label>Disposed (QTY):</label>
		<input type="text" name="Disposed" class="form-control" required>
		<label>Balance (QTY):</label>
		<input type="text" name="balance" class="form-control" required>
		<label>Amount:</label>
		<input type="text" name="amount" class="form-control" required>
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