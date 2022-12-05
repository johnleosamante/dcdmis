
                <div class="col-lg-12">
                    <div class="panel panel-default">
                       <div class="panel-heading">
					    <a href="#mytraining" class="btn btn-primary" style="float:right;" data-toggle="modal">New activity</a>
							<h2>List of activity</h2>
							<?php
							if (isset($_POST['training-data']))
							{
							mysqli_query($con,"INSERT INTO tbl_seminar VALUES('".$_POST['Tcode']."','".$_POST['TTitle']."','".$_POST['TFrom']."','".$_POST['TTo']."','".$_POST['TConduct']."','".$_POST['TVenue']."','-','".$_POST['TOffice']."')");
	
							if (mysqli_affected_rows($con)==1)
							{
							$Err = "Activity Successfully saved";
									echo '<script type="text/javascript">
										$(document).ready(function(){						
										$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
										});</script>
										';	
								echo '<div class="alert alert-success">'.$Err.'</div>';
							}
							}elseif (isset($_POST['update_training']))
							{
								mysqli_query($con,"UPDATE tbl_seminar SET Title_of_training='".$_POST['TTitle']."',covered_from='".$_POST['TFrom']."',covered_to='".$_POST['TTo']."',TVenue='".$_POST['TVenue']."' WHERE Training_Code='".$_SESSION['code']."' LIMIT 1");	
								if (mysqli_affected_rows($con)==1)
							{
								$Err = "Activity Successfully updated!";
									echo '<script type="text/javascript">
										$(document).ready(function(){						
										$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
										});</script>
										';	
								echo '<div class="alert alert-success">'.$Err.'</div>';
								$_SESSION['code']="";
							}
							}
							?>
							
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%" rowspan="2">#</th>
												<th width="35%" rowspan="2">TITLE OF TRAININGS / ACTIVITIES</th>
												<th width="20%" colspan="2" >DATE COVERED</th>
												
												<th width="20%" rowspan="2">VENUE</th>
												<th width="7%" rowspan="2"></th>
											</tr>
										<tr>
											<th>FROM</th>
											<th>TO</th>
										</tr>										
									</thead>
									<tbody>
									
									<?php
									$no=0;
									$seminar=mysqli_query($con,"SELECT * FROM tbl_seminar WHERE Office='".$_SESSION['station']."'") or die ("error training data");
										while($row=mysqli_fetch_array($seminar))
										{
											$no++;
										echo '<tr><td style="text-align:center;">'.$no.'</td>
												<td>'.$row['Title_of_training'].'</td>
												<td>'.$row['covered_from'].'</td>
												<td>'.$row['covered_to'].'</td>
												
												<td>'.$row['TVenue'].'</td>
												
												<td class="dropdown">
															
															<a class="dropdown-toggle" data-toggle="dropdown" href="#">
																<i class="fa fa-gear fa-fw"></i> <i class="fa fa-caret-down"></i>
															</a>
															<ul class="dropdown-menu dropdown-user">
																<li><a href="edit_activity.php?code='.$row['Training_Code'].'" data-toggle="modal" data-target="#myparti"><i class="fa  fa-eraser  fa-fw"></i> Edit</a>
																</li>
																<li><a href="my_participant.php?code='.$row['Training_Code'].'" data-toggle="modal" data-target="#myparti"><i class="fa  fa-user  fa-fw"></i> Add</a>
																</li>
																<li><a href="my_list.php?code='.$row['Training_Code'].'" data-toggle="modal" data-target="#myparti"><i class="fa  fa-users  fa-fw"></i> List</a>
																</li>
																	<li><a href="my_memo.php?code='.$row['Training_Code'].'" data-toggle="modal" data-target="#mymemo"><i class="fa  fa-envelope-o   fa-fw"></i> Memo</a>
																</li>
															</ul>
															
														
													</td></tr>
												';
										}
													?>
									</tr>
									</tbody>
									</table>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
             
<style>
   .modal-header,h4, .close{
	   background-color:#f9f9f9;
	   color:black !important;
	   text-align:center;
	   font-size:30px;
   }
   .modal-footer{
	   background-color:#f9f9f9;
	   text-align:left;
   }
   
   .loginbox{
	   width:50%;height:auto;margin-top:10px;margin-left:auto;margin-right:auto;
   }
   .memobox{
	   width:70%;height:auto;margin-top:10px;margin-left:auto;margin-right:auto;
   }
		@media 
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {
			 .loginbox{
						width:100%;height:auto;margin-top:100px;margin-left:auto;margin-right:auto;
					}
					.memobox{
						   width:100%;height:auto;margin-top:10px;margin-left:auto;margin-right:auto;
					   }
					
			}
		
   </style>


<!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="myparti" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
   
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
			  </div></div>
		

<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="mymemo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
			  </div></div>
			  
			  
<!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="mytraining" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>ADD NEW TRAINING</center></h3>
		  	
        </div>
		<form action="list_of_activity.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c" Method="POST">
        <div class="modal-body">
		<label>TRAININGS CODE:</label>
		<input type="text" class="form-control" value="<?php  echo $_SESSION['station'].'-'.date('Ydms'); ?>" disabled>
		<input type="hidden" name="Tcode" class="form-control" value="<?php  echo $_SESSION['station'].'-'.date('Ydms'); ?>" >
		<label>TITLE OF TRAININGS / ACTIVITIES:</label>
		<textarea name="TTitle" class="form-control" rows="3" required autofocus></textarea>
		
		<label>FROM:</label>
		<input type="date" name="TFrom" class="form-control" required>
		<label>TO:</label>
		<input type="date" name="TTo" class="form-control" required>
		<label>CONDUCTED BY:</label>
		<select name="TConduct" class="form-control">
		<option value="">--Select--</option>
		<option value="DepEd-City">DepEd City </option>
		<option value="DepEd-Region">DepEd Region</option>
		</select>
		<label>VENUE:</label>
		<input type="text" name="TVenue" class="form-control" required>
		<label>OFFICE:</label>
		<input type="text" class="form-control" value="<?php echo $_SESSION['station']; ?>" disabled>
		<input type="hidden" name="TOffice" class="form-control" value="<?php echo $_SESSION['station']; ?>">
		</div>
		 <div class="modal-footer">
		<input type="submit" name="training-data" Value="SUBMIT" class="btn btn-success">
		</div>
		</form>
		
		      </div>
		      </div>
			  </div></div>
		
