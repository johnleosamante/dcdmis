  <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>LIST OF SCHOOLS</center></h3>
		
        </div>
        <div class="modal-body">
		<form action="submit_participant.php" Method="POST">
		<?php
		session_start();
		include("../vendor/jquery/function.php");
		if($_SESSION['uid']=="")
		{
			header('location:http://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}
		$_SESSION['code']=$_GET['code'];
	    echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
    
                                <thead>
                                    <tr>
                                       	<th style="width:3%;text-align:center;" >#</th>
										<th style="width:25%;">School Name</th>						
										<th style="text-align:center;width:5%;">Select</th>
                                    </tr>
									
										                                </thead>
                                <tbody>';
								
								
									$recstudent=mysqli_query($con,"SELECT * FROM tbl_school  WHERE tbl_school.SchoolID <>'123131' ORDER BY tbl_school.SchoolName Asc")or die ("School Table not found!");
									$no=$m=$f=$t=0;
									while($r = mysqli_fetch_assoc($recstudent)) {
										
										$no++;
										print '<td style="text-align:center;">'.$no.'</td>';
										print '<td>'.$r['SchoolName'].'</td>
																			
											<td class="dropdown">
												<center><input type="radio" name="part-'.$no.'" value="'.$r['SchoolID'].'" title="part-'.$no.'"></center>	
														
											</td>
                                        </tr>';
                                    
									}						
									
                               echo '</tbody>
                            </table>';
					
		?>
		 <input type="submit" class="btn btn-primary" name="save" value="SUBMIT">
		</form> 
</div>
