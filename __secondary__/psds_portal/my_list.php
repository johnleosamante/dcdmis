 
  <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>LIST OF SCHOOLS PARTICIPANTS</center></h3>
		  	
        </div>
        <div class="modal-body">
		
		<?php
		session_start();
		include("../vendor/jquery/function.php");
		if($_SESSION['uid']=="")
		{
			header('location:http://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}
	    echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                             <thead>
                                    <tr>
                                       	<th style="width:3%;" >#</th>
                                       	<th style="width:5%;" >School ID</th>
										<th>School Name</th>
										
										<th style="text-align:center;width:10%;"></th>
                                    </tr>
									
										
									
                                </thead>
                                <tbody>';
								$no=0;
								$result=mysqli_query($con,"SELECT * FROM tbl_school_participant INNER JOIN tbl_school ON tbl_school_participant.SchoolID=tbl_school.SchoolID WHERE tbl_school_participant.Training_Code='".$_GET['code']."'")or die("Error School Paticipants");
								while($row=mysqli_fetch_array($result))
								{
									$no++;
									echo '<tr>
												<td>'.$no.'</td>
												<td>'.$row['SchoolID'].'</td>
												<td>'.$row['SchoolName'].'</td>
												<td style="text-align:center;">
													<a href="removed.php?code='.$row['No'].'" title="Remove participant"><i class="fa  fa-trash-o fa-fw"></i></a>
																
															
														
													</td>
										   </tr>';
								}
									
									
                               echo '</tbody>
                            </table>';
					
		?>
		
</div>
 <div class="modal-footer">
<?php
$mytrain=mysqli_query($con,"SELECT * FROM tbl_seminar WHERE Training_Code='".$_GET['code']."'");
		  $data=mysqli_fetch_assoc($mytrain);
		  echo '<label>Title of Training / Activities: </label><br/>';
		  echo  $data['Title_of_training'];
?>
</div>