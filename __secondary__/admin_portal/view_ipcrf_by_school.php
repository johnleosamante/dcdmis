	<?php
		if (isset($_POST['AddScore']))
		{
			$query=mysqli_query($con,"SELECT * FROM tbl_ipcrf_consolidated WHERE Emp_ID='".$_POST['PName']."' AND SchoolYear='".$_POST['sy']."'");
			if(mysqli_num_rows($query)==0)
			{
				mysqli_query($con,"UPDATE tbl_station SET Emp_Position='".$_POST['position']."' WHERE Emp_ID='".$_POST['PName']."' LIMIT 1");
				mysqli_query($con,"INSERT INTO tbl_ipcrf_consolidated (Emp_ID,RatingScore,RatingAdjective,Position,SchoolID,SchoolYear)VALUES('".$_POST['PName']."','".$_POST['rating']."','".$_POST['remarks']."','".$_POST['position']."','".$_POST['school']."','".$_POST['sy']."')") or die ("Hello");
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
		}
	?>	
	<div class="col-lg-12">
					      <div class="panel panel-default">
                                    <div class="panel-heading">
									<a href="./?13b714fad9eca2a00fe69ce8ce03cba1c7e085277e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=aXBjcmY%3D" class="btn btn-secondary" style="float:right;">Back</a>
									<h4>Personnel</h4>				 
                                     </div>
								<div class="panel-body" style="overflow-x:auto;">							
																
								
									<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th width="10%" style="text-align:center;"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								   $myname=mysqli_query($con,"SELECT * FROM tbl_employee ORDER BY Emp_LName Asc");
								   while($rowName=mysqli_fetch_array($myname))
								   {
									   echo '<tr><td>'.$rowName['Emp_LName'].', '.$rowName['Emp_FName'].'</td>
									          <td><a href="newipcrf.php?code='.$rowName['Emp_ID'].'" data-target="#newipcrf" data-toggle="modal">VIEW</a></td></tr>';
								   }
								 ?>
								</tbody>
								</table>
					</div>
				</div>
				</div>
				               
				 	
          <!-- Modal for Re-assign-->
   <div class="panel-body">
                            
                 <!-- Modal -->
     <div class="modal fade" id="newipcrf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog">
        <!-- Modal content-->
      <div class="modal-content">
         </div></div></div></div>