<?php
if (isset($_POST['saverecord']))
	{
		mysqli_query($con,"INSERT INTO tbl_sep_annexa7_card VALUES(NULL,'".$_POST['icsno']."','".$_POST['RCC']."','".$_POST['SEPNo']."','".$_POST['description']."','".$_POST['unit']."','".$_POST['Quantity_issued']."','".$_POST['unit_cost']."','".$_POST['amount']."','".$_GET['code']."')") or die("error");
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
						 <a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=QW5uZXhBNw%3D%3D" class="btn btn-secondary" style="float:right;margin:4px;padding:4px;">Back</a>
					     <h4>REPORT OF SEMI-EXPENDABLE PROPERTY ISSUED<h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						 <a href="#newannex" class="btn btn-primary" style="float:right;margin:4px;padding:4px;" data-toggle="modal">Add Report</a>
						 <?php
						 $_SESSION['CardCode']=$_GET['code'];
						 $result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa7 WHERE CardCode='".$_GET['code']."' LIMIT 1");
						 $rowsep=mysqli_fetch_assoc($result);
						 echo '<label>Fund Cluster: <input type="text" class="form-control" value="'.$rowsep['Fund_cluster'].'" disabled></label>
						 <label>Serial No.: <input type="text" class="form-control"  value="'.$rowsep['SEP_SerialNo'].'" disabled></label>
						 <hr/>';
						 ?>
						 
						 
                            <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="10%">ICS No</th>
                                        <th width="10%">Responsibility Center Code</th>
                                        <th width="10%">Semi-expendable Property No</th>
                                        <th  width="30%" >Item Description</th>
                                         <th rowspan="2">Unit</th>
                                         <th width="15%">Quantity Issued</th>                                      
                                         <th width="15%" >Unit Cost</th>                                      
                                         <th width="15%">Amount</th>                                      
                                         <th width="5%"></th>                                      
                                                                         
                                    </tr>
									
                                </thead>
                                <tbody>
								<?php
								
								$result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa7_card WHERE SEPCode ='".$_GET['code']."' ORDER BY Item_Description Asc");
								while($row=mysqli_fetch_array($result))
								{
									
								 echo '<tr>
											<td>'.$row['ICSNo'].'</td>
											<td>'.$row['RCC'].'</td>
											<td>'.$row['SEPNo'].'</td>
											<td>'.$row['Item_Description'].'</td>
											<td>'.$row['Units'].'</td>
											<td>'.$row['Quantity_issued'].'</td>
											<td>'.number_format($row['Unit_cost'],2).'</td>
											<td>'.number_format($row['Amount'],2).'</td>
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
				   window.location.href="delete_annex7_card.php?code="+id;
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
		<label>ICS No:</label>
		<input type="text"  class="form-control" name="icsno" required>
		<label>Responsibility Center Code:</label>
		<input type="text" name="RCC" class="form-control" required>
		<label>Semi-expendable Property No:</label>
		<input type="text" name="SEPNo" class="form-control" required >
		<label>Item Description:</label>
		<input type="text" name="description" class="form-control" required>
		<label>Unit:</label>
		<input type="text" name="unit" class="form-control" required>
		<label>Quantity Issued:</label>
		<input type="number" name="Quantity_issued" class="form-control" required>
		<label>Unit Cost:</label>
		<input type="number" name="unit_cost" class="form-control" required>
		<label>Amount:</label>
		<input type="number" name="amount" class="form-control" required>
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