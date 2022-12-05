	<style>
	th{
		text-align:center;
	}
	</style>
	<script>
		function viewdata(str){
					
		  if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		  } else { // code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			  document.getElementById("txtdata").innerHTML=xmlhttp.responseText;
			}
		  }
		  xmlhttp.open("GET","view_query.php?id="+str,false);
		  xmlhttp.send();
		}
	</script>
	
				   <a href="#myschedule" class="btn btn-primary" style="float:right;padding:4px;margin:4px;" data-toggle="modal">Set Schedule</a>
				  <a href="print-module-data.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c" target="_blank" style="padding:4px;margin:4px;float:right;" class="btn btn-success">Print Copy</a>				
						
				  
			 <?php
			 if (isset($_POST['setData']))
			 {
				 mysqli_query($con,"UPDATE tbl_distribution_schedule SET WeekNo='".$_POST['week']."',QuarterNo='".$_POST['quarter']."'");
				if(mysqli_affected_rows($con)==1)
				{
									
					$Err = "Week distribution Successfully updated";
						echo '<script type="text/javascript">
								$(document).ready(function(){						
								$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
															
								});</script>';	
								echo '<div class="alert alert-success">'.$Err.'</div>';
								
									}
			 }
			 ?>
                <div class="col-lg-12">
                    <div class="panel panel-default">

					 <div class="panel-heading">
                    <form action="" Method="POST">
									<label style="float:right;padding:2px;margin:2px;">
									<input type="submit" name="search"  class="btn btn-success" value="Search">
									 </label >
									 <label style="float:right;padding:2px;margin:2px;">
										<select name="week" class="form-control" required>
											<option value="">--Select Week--</option>
											<option value="Week 1">Week 1</option>
											<option value="Week 2">Week 2</option>
											<option value="Week 3">Week 3</option>
											<option value="Week 4">Week 4</option>
											<option value="Week 5">Week 5</option>
											<option value="Week 6">Week 6</option>
											<option value="Week 7">Week 7</option>
											<option value="Week 8">Week 8</option>
											<option value="Week 9">Week 9</option>
											<option value="Week 10">Week 10</option>
											
										</select>
									 </label>
									<label style="float:right;padding:2px;margin:2px;">
										<select name="quarter" class="form-control" required>
											<option value="">--Select Quarter--</option>
											<option value="First">First Quarter</option>
											<option value="Second">Second Quarter</option>
											<option value="Third">Third Quarter</option>
											<option value="Fourth">Fourth Quarter</option>
											
										</select>
									 </label>	
									</form>				
				  <h4>LEARNING RESOURCES READINESS SUMMARY: <br/><?php echo '<i style="color:blue;">('.$_SESSION['quarter'].' Quarter - '.$_SESSION['week'].')</i>'; ?></h4>
				 	   
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<div id="txtdata">
                          
						<?php
							require("elementary_school.php");
							require("junior_high_school.php");
							require("senior_high_school.php");
						?>	
							
                        </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
	
	   <!-- Modal -->
							 <div class="panel-body">
                            
                 <!-- Modal -->
							 <div class="modal fade" id="myschedule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							 <div class="modal-dialog">
    
                                    <div class="modal-content">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.reload()">&times;</button>
									<h4 class="modal-title" id="myModalLabel">Set new schedule for this week</h4>
									</div>
									<div style="margin:15px;">

									</div><form action="" method="POST">
											<div class="modal-body">
											<label>Set week number:</label>
											<select name="week" class="form-control" required>
												<option value="">--Select Week #--</option>
												<option value="Week 1">Week 1</option>
												<option value="Week 2">Week 2</option>
												<option value="Week 3">Week 3</option>
												<option value="Week 4">Week 4</option>
												<option value="Week 5">Week 5</option>
												<option value="Week 6">Week 6</option>
												<option value="Week 7">Week 7</option>
												<option value="Week 8">Week 8</option>
												<option value="Week 9">Week 9</option>
												<option value="Week 10">Week 10</option>
												
											</select>
											<label>Set Quarter:</label>
											<select name="quarter" class="form-control" required>
												<option value="">--Select Quarter--</option>
												<option value="First">First</option>
												<option value="Second">Second</option>
												<option value="Third">Third</option>
												<option value="Fourth">Fourth</option>
											</select>
											</div>
											<div class="modal-footer">
											<input type="submit" name="setData" value="SET" class="btn btn-success">
											</div>
											</form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        </div>
                        </div>
                        <!-- .panel-body -->
						
						
						
						  <!-- Modal -->
							 <div class="panel-body">
                            
                 <!-- Modal -->
							 <div class="modal fade" id="lrhelpdisk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							 <div class="modal-dialog">
    
                                    <div class="modal-content">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.reload()">&times;</button>
									<h4 class="modal-title" id="myModalLabel">LRMS Query</h4>
									</div>
									<form action="" method="POST" id="sendmessage">
										<div class="modal-body">
										<iframe src="messages.php" class="form-control" style="height:350px;" frameborder="0"></iframe>	
											
										</div>
										<div class="modal-footer">
											
												<div class="input-group custom-search-form">
													<input type="text" name="chat" class="form-control" placeholder="Enter your messages..." autofocus>
													<span class="input-group-btn">
													<button class="btn btn-default" type="button" onclick="SendMessages">
														Send</button>
													</span>
												</div>
											
											</div>
									</form>	
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        </div>
                        </div>
                        <!-- .panel-body -->