<?php
if (isset($_POST['saverecord']))
	{
		mysqli_query($con,"INSERT INTO tbl_sep_annexa6_card VALUES(NULL,'".$_POST['Description']."','".$_POST['qty']."','".$_POST['icsno']."','".$_POST['enduser']."','".$_POST['remarks']."','".$_GET['code']."')") or die("error");
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
						 <a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=QW5uZXhBNg%3D%3D" class="btn btn-secondary" style="float:right;margin:4px;padding:4px;">Back</a>
					     <h4>RECEIPT OF RETURNED SEMI-EXPENDABLE PROPERTY<h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						 <a href="#newannex" class="btn btn-primary" style="float:right;margin:4px;padding:4px;" data-toggle="modal">Add Report</a>
						 <?php
						 $_SESSION['CardCode']=$_GET['code'];
						 $result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa6 WHERE CardCode='".$_GET['code']."' LIMIT 1");
						 $rowsep=mysqli_fetch_assoc($result);
						 echo '<label>Date: <input type="text" class="form-control" value="'.$rowsep['Date_Received'].'" disabled></label>
						 <label>RRSP No.: <input type="text" class="form-control"  value="'.$rowsep['RRSPNo'].'" disabled></label>
						 <hr/>';
						 ?>
						 
						 
                            <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="7%" >#</th>
                                        <th>Item Description</th>
                                        <th width="10%" >Quantity</th>
                                        <th width="20%" >ICS No</th>
                                        <th width="20%">End-user</th>
                                         <th width="15%">Remarks</th>
                                         <th width="7%" ></th>
                                                                       
                                    </tr>
									
                                </thead>
                                <tbody>
								<?php
								$no=0;
								$result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa6_card WHERE SEPCode ='".$_GET['code']."' ORDER BY Item_Description Asc");
								while($row=mysqli_fetch_array($result))
								{
								$no++;
								 echo '<tr>
											<td>'.$no.'</td>
											<td>'.$row['Item_Description'].'</td>
											<td>'.$row['QTY'].'</td>
											<td>'.$row['ICSNo'].'</td>
											<td>'.$row['End_user'].'</td>
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
				   window.location.href="delete_annexa6_card.php?code="+id;
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
		<label>Item Description:</label>
		<input type="text" name="Description" class="form-control" required>
		<label>Quantity:</label>
		<input type="text" name="qty" class="form-control" required >
		<label>ICS No:</label>
		<input type="text" name="icsno" class="form-control" required>
		<label>End-user:</label>
		<input type="text" name="enduser" class="form-control" required>
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