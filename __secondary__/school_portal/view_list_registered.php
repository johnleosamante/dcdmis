 <?php
 session_start();
include("../vendor/jquery/function.php");

 foreach ($_GET as $key => $data)
{
$date=$_GET[$key]=base64_decode(urldecode($data));
	
}
 ?>
 <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>List of Learner Registered by Date<br/>(<?php echo $date;?>)</center></h3>
		 
        </div>
        <div class="modal-body">
		   <table class="table table-striped table-bordered table-hover">
					<thead>
										
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Sex</th>
							<th>Grade</th>
						</tr>	
					</thead>
					<tbody>
					<?php
					$no=0;
					$result=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn =tbl_student.lrn WHERE Date_enrolled='".$date."' ");
					while($row=mysqli_fetch_array($result))
					{
						$no++;
						echo '<tr>
								<td>'.$no.'</td>
								<td style="text-align:left;">'.$row['Lname'].', '.$row['FName'].' '.$row['MName'].'</td>
								<td>'.$row['Gender'].'</td>
								<td>'.$row['Grade'].'</td>
							</tr>	';
					}
					?>
					</tbody>
					</table>
			
		</div>