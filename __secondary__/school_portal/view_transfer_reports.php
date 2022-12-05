<?php
if (isset($_POST['saverecord']))
	{
		mysqli_query($con,"INSERT INTO tbl_sep_annexa5_card VALUES(NULL,'".$_POST['date_apply']."','".$_POST['ItemNo']."','".$_POST['icsno']."','".$_POST['Description']."','".$_POST['Amount']."','".$_POST['Condition_of_inventory']."','".$_GET['code']."')") or die("error");
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
						 <a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=QW5uZXhBNQ%3D%3D" class="btn btn-secondary" style="float:right;margin:4px;padding:4px;">Back</a>
					     <h4>INVENTORY CUSTODIAN SLIP<h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						 <a href="#newannex" class="btn btn-primary" style="float:right;margin:4px;padding:4px;" data-toggle="modal">Add Report</a>
						 <?php
						 $_SESSION['CardCode']=$_GET['code'];
						 $result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa5 WHERE CardCode='".$_GET['code']."' LIMIT 1");
						 $rowsep=mysqli_fetch_assoc($result);
						 echo '<label>Fund Cluster: <input type="text" class="form-control" value="'.$rowsep['Fund_cluster'].'" disabled></label>
						 <label>From Accountable Officer/ Agency /Fund Cluster: <input type="text" class="form-control"  value="'.$rowsep['FAOAF'].'" disabled></label>
						 <label>To Accountable Officer/ Agency /Fund Cluster: <input type="text" class="form-control"  value="'.$rowsep['TAOAF'].'" disabled></label>
						 <label>ITR No: <input type="text" class="form-control"  value="'.$rowsep['ITRNo'].'" disabled></label>
						 <label>Transfer Type: <input type="text" class="form-control"  value="'.$rowsep['Transfer_type'].'" disabled></label>
						 <hr/>';
						 ?>
						 
						 
                            <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="10%">Date Aquired</th>
                                        <th width="10%">Item No.</th>
                                        <th width="10%">ICS No. /Date</th>
                                          <th>Description</th>
                                         <th width="15%">Amount.</th>                                      
                                         <th width="15%">Condition of Inventory</th>                                      
                                         <th width="5%"></th>                                      
                                                                         
                                    </tr>
									
                                </thead>
                                <tbody>
								<?php
								
								$result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa5_card WHERE SEPCode ='".$_GET['code']."' ORDER BY Date_received Desc");
								while($row=mysqli_fetch_array($result))
								{
									
								 echo '<tr>
											<td>'.$row['Date_received'].'</td>
											<td>'.$row['ItemNo'].'</td>
											<td>'.$row['ICSNo'].'</td>
											<td>'.$row['Item_Description'].'</td>
											<td>'.number_format($row['Amount'],2).'</td>
											<td>'.$row['Condition_of_inventory'].'</td>
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
				   window.location.href="delete_annex5_card.php?code="+id;
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
		<label>Date Aquired:</label>
		<input type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" name="date_apply">
		<label>Item No:</label>
		<input type="text" name="ItemNo" class="form-control" required>
		<label>ICS No. /Date:</label>
		<input type="text" name="icsno" class="form-control" required >
		<label>Description:</label>
		<input type="text" name="Description" class="form-control" required>
		<label>Amount:</label>
		<input type="text" name="Amount" class="form-control" required>
		<label>Condition of Inventory:</label>
		<input type="text" name="Condition_of_inventory" class="form-control" required>
		
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