<script type="text/javascript">
		$(document).ready(function(){						
			setInterval(function(){
				$("#replydata").load("view_data.php")
							
				},1000);
							
		});</script>
		
		
		
                <div class="col-lg-12">
                    <div class="panel panel-default">
                       <div class="panel-heading">
					   <?php
					   echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("HelpDesk")).'" class="btn btn-secondary" style="float:right;">Back</a>
					    	<h4>CHAT ROOM</h4>';
							
							if (isset($_POST['sendSMS']))
							{
								date_default_timezone_set("Asia/Manila");
								$dateposted = date("Y-m-d H:i:s");															  
								mysqli_query($con,"INSERT INTO tbl_query_reply VALUES(NULL,'".$_POST['replyMSG']."','".$dateposted."','".$_SESSION['uid']."','".$_GET['id']."')"); 
								if (mysqli_affected_rows($con)==1)
								{
								$Err = "Successfully Sent!";
										echo '<script type="text/javascript">
											$(document).ready(function(){						
											$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
											
											});</script>
											';	
									echo '<div class="alert alert-success">'.$Err.'</div>';
								}
							}
							?>	
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          <?php
						  $_SESSION['TNo']=$_GET['id'];
							$result=mysqli_query($con,"SELECT * FROM tbl_school_query INNER JOIN tbl_employee ON tbl_school_query.PostedBy = tbl_employee.Emp_ID INNER JOIN tbl_school ON tbl_school_query.SchoolID = tbl_school.SchoolID WHERE tbl_school_query.TicketNo ='".$_GET['id']."' ORDER BY tbl_school_query.date_posted Asc") or die ("error training data");
							$row=mysqli_fetch_assoc($result);
							echo ' <ul class="chat">
										 <li class="left clearfix">
											<span class="chat-img pull-left">
												<img src="'.$row['Picture'].'" alt="User Avatar" class="img-circle" width="50" height="50"/>
													</span>
													<div class="chat-body clearfix">
														<div class="header">
															<strong class="primary-font">'.$row['Emp_LName'].', '.$row['Emp_FName'].'</strong>
															<small class="pull-right text-muted">
																<i class="fa fa-clock-o fa-fw"></i>'.$row['date_posted'].'
														</small>
													</div>
												<p>'.$row['Messages'].'</p>
											</div>
										</li>
								
								</ul>';
							
							
							
							
							
							?><hr/>
							<div id="replydata" style="height:250px;padding:4px;margin:4px;overflow-x:auto;">
							<?php
							$result1=mysqli_query($con,"SELECT * FROM tbl_query_reply INNER JOIN tbl_employee ON tbl_query_reply.ReplyBy = tbl_employee.Emp_ID  WHERE tbl_query_reply.TicketNo ='".$_SESSION['TNo']."' ORDER BY tbl_query_reply.Date_reply Desc");
							while ($row1=mysqli_fetch_array($result1))
								{
								echo ' <ul class="chat">
												 <li class="left clearfix">
															<span class="chat-img pull-left">
																<img src="'.$row1['Picture'].'" alt="User Avatar" class="img-circle" width="50" height="50"/>
															</span>
															<div class="chat-body clearfix">
																<div class="header">
																	<strong class="primary-font">'.$row1['Emp_LName'].', '.$row1['Emp_FName'].'</strong>
																	<small class="pull-right text-muted">
																		<i class="fa fa-clock-o fa-fw"></i>'.$row1['Date_reply'].'
																	</small>
																</div>
																<p>'.$row1['RequestMessage'].'</p>
															</div>
														</li>
								
								</ul>';
								}
							?>
							</div>
								<form action="" method="POST" id="frmBox" enctype="multipart/form-data">
					
                            <div class="input-group custom-search-form">
                                <input type="text" name="replyMSG" id="message" class="form-control" placeholder="Reply...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" name="sendSMS" type="submit" >
								 SEND
								</button>
                            </span>
                            </div>
                            <input type="hidden" id="success">
						</form>
					
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
      
	  <script type="text/javascript">
				function formSubmit(){
					$.ajax({
						type:'POST',
						url:'send_response.php',
						data:$('#frmBox').serialize(),
						success:function(response){
							$('#success').html(response);
						}
						
					});

				var form=document.getElementById('frmBox').reset();
				document.getElementById('message').setFucos;
				return false;
				}
				</script>	
	