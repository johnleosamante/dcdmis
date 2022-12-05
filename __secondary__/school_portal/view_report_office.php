<?php
$_SESSION['CardNo']=$_GET['code'];
if (isset($_POST['saverecord']))
	{
		mysqli_query($con,"INSERT INTO tbl_sep_annexa1_card_records VALUES(NULL,'".$_POST['date_apply']."','".$_POST['itemno']."','".$_POST['QTY']."','".$_POST['office']."','".$_SESSION['CardCode']."','".$_GET['code']."')");
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
                <div class="col-lg-8">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <h4>SEMI-EXPENDABLE PROPERTY CARD INDIVIDUAL REPORTS<h4>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						 <?php
						 $result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa1 WHERE CardCode='".$_SESSION['CardCode']."' LIMIT 1");
						 $rowsep=mysqli_fetch_assoc($result);
						 echo '<label style="width:30%;">Fund Cluster: <input type="text" class="form-control" value="'.$rowsep['Fund_cluster'].'" disabled></label>
						 <label style="width:30%;">Semi-expendable Property: <input type="text" class="form-control"  value="'.$rowsep['SEP'].'" disabled></label>
						 <label style="width:30%;">Semi-expendable Property No.: <input type="text" class="form-control" disabled  value="'.$rowsep['SEPNo'].'" ></label>
						 <label style="width:35%;">Description: </label><input type="text" class="form-control" disabled  value="'.$rowsep['SEP_Description'].'"><hr/>';
						 ?>
						 
						 
                            <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="7%" rowspan="2">#</th>
                                        <th width="20%" rowspan="2">Date</th>
                                        <th  colspan="3">Issue/Transfer/Disposal</th>
                                        <th width="10%" rowspan="2"></th>
                                                                           
                                    </tr>
									<tr>
										<th >Item No</th>
										<th>Quantity</th>
										<th >Office/Officer</th>
										
									</tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								$balance=$subtotal=$remaining=$TotalCost=0;
								$result=mysqli_query($con,"SELECT * FROM tbl_sep_annexa1_card_records WHERE SEPCode ='".$_SESSION['CardCode']."' AND CardNo='".$_GET['code']."' ORDER BY Date_received Desc");
								while($row=mysqli_fetch_array($result))
								{
									
									$no++;
								 echo '<tr>
											<td>'.$no.'</td>
											<td>'.$row['Date_received'].'</td>
											<td>'.$row['Trans_Item_no'].'</td>
											<td>'.$row['Trans_QTY'].'</td>
											<td>'.$row['Trans_Office'].'</td>
											<td><a href="update_record.php?code='.$row['No'].'" data-toogle="modal" data-target="#update">EDIT</a><br/><a style="cursor:pointer;" id="'.$row['No'].'" onclick="delete_me(id)">DEL</a></td>
																						
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
				
				 <div class="col-lg-4">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <?php
						 echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code='.urlencode(base64_encode($_SESSION['CardCode'])).'&v='.urlencode(base64_encode("view_report_card")).'" class="btn btn-secondary" style="float:right;margin:4px;padding:4px;">Back</a>';
						?>
						  <h4>NEW RECORD<h4>
                        </div>
                         <?php   
						 $total=0;
						 //Quantity query received number
						$query=mysqli_query($con,"SELECT * FROM tbl_sep_annexa1_card WHERE CardNo='".$_GET['code']."'");
						$rowque=mysqli_fetch_assoc($query);
						 //Quantity query issued number
						$queryto=mysqli_query($con,"SELECT * FROM tbl_sep_annexa1_card_records WHERE SEPCode ='".$_SESSION['CardCode']."' AND CardNo='".$_GET['code']."'");
						 while($rowto=mysqli_fetch_array($queryto))
							{
							 $total= $total+$rowto['Trans_QTY'];
							}
						
						if ($total>= $rowque['Received_QTY'])
						{
							echo '<h2 style="text-align:center;">No available item.</h2>';
						}else{
						 echo '<form action="" Method="POST" enctype="multipart/form-data">
						<div class="modal-body">
						<label>Date:</label>
						<input type="date" value="'.date("Y-m-d").'" class="form-control" name="date_apply">
						<label>Item Number:</label>
						<input type="text" name="itemno" class="form-control" required>
						<label>Quantity:</label>
						<input type="text" name="QTY" class="form-control" required >
						<label>Office/Officer:</label>
						<input type="text" name="office" class="form-control" required>
						</div>
						<div class="modal-footer">
							<input type="submit" name="saverecord" id="myBtn" value="SUBMIT" class="btn btn-primary">
							  </div>
						</form>';
						}
						?>
						</div>
					</div>
				 </div>
				
                </div>
               <script>
				function delete_me(id)
				{
					if (confirm("Are you sure you want to delete entire row?"))
					{
						alert("Information is successfully deleted");
						window.location.href='remove_office.php?code='+id;
					}
				}
			   </script>