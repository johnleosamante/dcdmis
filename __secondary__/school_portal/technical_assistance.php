<?php
if (isset($_POST['new_request']))
{
	$query=mysqli_query($con,"SELECT * FROM tbl_technical_assistance WHERE SchoolID='".$_SESSION['school_id']."' AND RequestDate LIKE '".date("Y-m-d")."'%");
	if (mysqli_num_rows($query)==0)
	{
		mysqli_query($con,"INSERT INTO tbl_technical_assistance VALUES('".date("ymdmi")."','".$_POST['datetime']."','".$_POST['myinfo']."','Pending Request....','".$_SESSION['uid']."','".$_SESSION['school_id']."')");
	}
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
 <div class="row">
                <div class="col-lg-12">
                    <h1 ></h1>
                </div>
                <!-- /.col-lg-12 -->
         </div>
            <div class="col-lg-12">
			 
                    <div class="panel panel-default">
					   <p style="text-align:center;font-size:24px;"><b>INFORMATION AND COMMUNICATION TECHNOLOGY SECTION</b></p>
					   <center><small>(ICT work order)</small></center>
                     </div>
			 </div>
			      <div class="col-lg-8">
				      <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
						<tr>
							<th width="10%">No</th>
							<th width="15%">Date Requested</th>
							<th>Reuest information</th>
							<th width="15%">Requested by</th>
							<th width="15%">Status</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no=0;
						$result=mysqli_query($con,"SELECT * FROM tbl_technical_assistance INNER JOIN tbl_employee ON tbl_technical_assistance.Requestedby = tbl_employee.Emp_ID WHERE tbl_technical_assistance.SchoolID='".$_SESSION['school_id']."'");
						while($row=mysqli_fetch_array($result))
						{
							$no++;
						  echo '<tr>
									<td>'.$no.'</td>
									<td>'.$row['RequestDate'].'</td>
									<td>'.$row['Information'].'</td>
									<td>'.$row['Emp_LName'].', '.$row['Emp_FName'].'</td>
									<td>'.$row['RequestStatus'].'</td>
									
								</tr>';
						}
						?>
					</tbody>
				   </table>
				  </div>
						
					<div class="col-lg-4">
					<h4>New Technical Assistance Request</h4>
					<form action="" Method="POST" enctype="multipart/form-data">
				     <label>Date and Time: </label>
					 <input type="text"  class="form-control" value="<?php echo date("Y-m-d h:m:i")?>" disabled>
					 <input type="hidden" name="datetime" class="form-control" value="<?php echo date("Y-m-d h:m:i")?>" >
					 <label>Request Information Details: </label>
					 <textarea class="form-control" name="myinfo" rows="3" required></textarea><hr/>
					 <a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=aWN0cmVwb3J0" style="float:right;" class="btn btn-default">Back</a>
					 <input type="submit" name="new_request" class="btn btn-primary" value="SUBMIT">
				  </div>
						