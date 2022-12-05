<?php
if (isset($_POST['addnew']))
{
	$query=mysqli_query($con,"SELECT * FROM tbl_school_obligation WHERE Description_info='".$_POST['obligation']."' AND SchoolID='".$_SESSION['school_id']."'");
	if (mysqli_num_rows($query)==0)
	{
		mysqli_query($con,"INSERT INTO tbl_school_obligation VALUES(NULL,'".$_POST['obligation']."','".$_POST['amount']."','".$_POST['duedate']."','".$_SESSION['school_id']."')");	
	}else{
		mysqli_query($con,"UPDATE tbl_school_obligation SET Amount_to_be_collect='".$_POST['amount']."',Due_date='".$_POST['duedate']."' WHERE Description_info='".$_POST['obligation']."' AND SchoolID='".$_SESSION['school_id']."'");
	}
 if (mysqli_affected_rows($con)==1)
 {
	 
 }
}
?>  
 <div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>	
 <div class="col-lg-12">
                    <div class="panel panel-default">
					
                        <div class="panel-heading">
						<a href="#myobligation" class="btn btn-primary" data-toggle="modal" style="float:right;margin:4px;padding:4px;">Add Obligation</a>
						
					<h3>SCHOOL OBLIGATIONS</h3>
						
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Description</th>
                                        <th width="14%">Amount</th>
                                        <th width="14%">Due Date</th>
                                        <th width="7%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								$obligate=mysqli_query($con,"SELECT * FROM tbl_school_obligation WHERE SchoolID='".$_SESSION['school_id']."'");
								while($row=mysqli_fetch_array($obligate))
								{
									$no++;
									echo '<tr>
											<td>'.$no.'</td>
											<td>'.$row['Description_info'].'</td>
											<td>₱ '.number_format($row['Amount_to_be_collect'],2).'</td>
											<td>'.$row['Due_date'].'</td>
											<td><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&account='.urlencode(base64_encode($row['AccountNo'])).'&v='.urlencode(base64_encode("view_obligation_list")).'">VIEW</a></td>
										</tr>';
								}
								?>
                                </tbody>
                            </table>
                            
                        </div>
						
						
                        <!-- /.panel-body 
						-->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
				
				
			<!-- Modal for Re-assign-->
    <div class="panel-body">
                            
                <!-- Modal -->
         <div class="modal fade" id="myobligation" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">-->
            <div class="modal-dialog">
  			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
						
						<h3 class="modal-title"><center>Add new school obligation</center></h3>
					</div>
					<form action="" Method="POST" enctype="multipart/form-data">
				<div class="modal-body">
		         
				 <label>Description (Name of obligation):</label>
				 <label style="width:100%;"><input type="text" name="obligation" class="form-control" placeholder="Description (Name of obligation)" required></label>
				 <label>Amount:</label>
				 <label style="width:100%;"><input type="number" name="amount" class="form-control" placeholder="Amount to pay" required></label>
				  <label>Due Date:</label>
				 <label style="width:100%;"><input type="date" name="duedate" class="form-control" placeholder="Due Date to pay" required></label>
				 
				</div>
				<div class="modal-footer">
					<input type="submit" name="addnew" value="SAVE OBLIGATION" class="btn btn-primary">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				 </form>
		    </div>
		</div>
	  </div>
	</div>
			  	
	