<?php
if (isset($_POST['saverecord']))
	{
		mysqli_query($con,"INSERT INTO tbl_sep_annexa3_card VALUES(NULL,'".$_POST['date_apply']."','".$_POST['QTY']."','".$_POST['unit']."','".$_POST['unitcost']."','".$_POST['Description']."','".$_POST['ItemNo']."','".$_POST['EUL']."','".$_GET['code']."')") or die("error");
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
						 <a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=QW5uZXhBMw%3D%3D" class="btn btn-secondary" style="float:right;margin:4px;padding:4px;">Back</a>
					     <h4>INVENTORY CUSTODIAN SLIP<h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						 <a href="#newannex" class="btn btn-primary" style="float:right;margin:4px;padding:4px;" data-toggle="modal">Add Report</a>
						 <?php
						 $_SESSION['CardCode']=$_GET['code'];
						 $result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa3 WHERE CardCode='".$_GET['code']."' LIMIT 1");
						 $rowsep=mysqli_fetch_assoc($result);
						 echo '<label>Fund Cluster: <input type="text" class="form-control" value="'.$rowsep['Fund_cluster'].'" disabled></label>
						 <label>ICS No.: <input type="text" class="form-control"  value="'.$rowsep['SEP_ICSNo'].'" disabled></label>
						 <hr/>';
						 ?>
						 
						 
                            <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="10%" rowspan="2">Date</th>
                                        <th width="10%" rowspan="2">Qty</th>
                                        <th width="10%"  rowspan="2">Unit</th>
                                        <th  width="30%" colspan="2">Amount</th>
                                         <th rowspan="2">Description</th>
                                         <th width="15%"  rowspan="2">Item No.</th>                                      
                                         <th width="15%" rowspan="2">Estimated Useful Life</th>                                      
                                         <th width="5%" rowspan="2"></th>                                      
                                                                         
                                    </tr>
									<tr>
										<th>Unit Cost</th>
										<th >Total Cost</th>
										
									</tr>
                                </thead>
                                <tbody>
								<?php
								$balance=$subtotal=$remaining=$TotalCost=0;
								$result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa3_card WHERE SEPCode ='".$_GET['code']."' ORDER BY Date_received Desc");
								while($row=mysqli_fetch_array($result))
								{
									$TotalCost=$row['Qty']*$row['Unit_cost'];
								 echo '<tr>
											<td>'.$row['Date_received'].'</td>
											<td>'.$row['Qty'].'</td>
											<td>'.$row['Unit'].'</td>
											<td>'.number_format($row['Unit_cost'],2).'</td>
											<td>'.number_format($TotalCost,2).'</td>
											<td>'.$row['Description'].'</td>
											<td>'.$row['ItemNo'].'</td>
											<td>'.$row['Estimated_useful_life'].'</td>
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
				   window.location.href="delete_ics_card.php?code="+id;
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
		<label>Quantity:</label>
		<input type="text" name="QTY" class="form-control" required>
		<label>Unit:</label>
		<input type="text" name="unit" class="form-control" required >
		<label>Unit Cost:</label>
		<input type="text" name="unitcost" class="form-control" required>
		<label>Description:</label>
		<input type="text" name="Description" class="form-control" required>
		<label>Item No:</label>
		<input type="text" name="ItemNo" class="form-control" required>
		<label>Estimated Useful Life:</label>
		<input type="text" name="EUL" class="form-control" required>
		
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