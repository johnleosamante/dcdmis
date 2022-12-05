	  <script type="text/javascript">
		$(document).ready(function(){						
			setInterval(function(){
				$("#reply").load("division_news.php")
							
				},100);
							
		});</script>
		
	<script type="text/javascript">
				function formSubmit(){
					$.ajax({
						type:'POST',
						url:'send-reply.php',
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
	 
 <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()">&times;</button>
			 <h4 class="modal-title">Division News </h4>
		</div>
	<div class="modal-body">
	<?php
	session_start();
 include("../pcdmis/vendor/jquery/function.php");
   foreach ($_GET as $key => $data)
	{
	$code=$_GET[$key]=base64_decode(urldecode($data));	
	}
	$posted=mysqli_query($con,"SELECT * FROM post INNER JOIN tbl_employee ON post.posted_by=tbl_employee.Emp_ID  WHERE post.chatID = '".$code."' ORDER BY post.date_posted Desc");
	$row=mysqli_fetch_assoc($posted);
	$_SESSION['chatid']=$code;
	
				echo '<span class="chat-img pull-left">
					<img src="/../pcdmis/images/'.$row['Picture'].'" alt="User" class="img-circle" width="50" height="50"/>
				</span>
						<div class="chat-body clearfix">
							<div class="header">
								<strong class="primary-font">'.$row['Emp_LName'].', '.$row['Emp_FName'].' ('.$row['post_office'].' office)</strong>
									<small class="pull-right text-muted">
									';
											$remarks="";
											$now = time(); // or your date as well
											$your_date = strtotime($row['date_posted']);
											$datediff = $now - $your_date;
											$current=round($datediff / (60 * 60 * 24));	
											if ($current > 30)
											{
												$remarks = $current/30;
												echo number_format($remarks,0) ." Month(s)";
												
											}else{
												$remarks = number_format($current,0)." days";
												echo $remarks;
											}
								echo '</small>
						</div>
					<p>'.$row['post_Title'].'</p><br/>';
					
					
	
		 echo '<div class="col-lg-7" style="overflow-x:auto;">';
		     if ($row['Ext']=='jpg' || $row['Ext']=='JPG' || $row['Ext']=='png' || $row['Ext']=='PNG')
					{
						echo '<img src="'.$row['Attach_file'].'" style="width:100%;">';
					}elseif ($row['Ext']=='mp4' || $row['Ext']=='mov' || $row['Ext']=='mpeg' || $row['Ext']=='avi' || $row['Ext']=='MP4')
					{
						echo '<video src="'.$row['Attach_file'].'" style="width:100%;height:auto;" controls autoplay></video>';
					}elseif ($row['Ext']=='pdf')
					{
						echo '<iframe src="'.$row['Attach_file'].'" style="width:100%;height:600px;" frameborder="0"></iframe>';
					}elseif ($row['Ext']=='Youtube')
					{
						echo '<iframe width="100%" height="480" src="https://www.youtube.com/embed/'.$row['Attach_file'].'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						
						';
					}
		
		echo '</div>
		        <div class="col-lg-5"> 
				 <form action="send-reply.php" id="frmBox" method="POST" onsubmit="return formSubmit();">
				  <table width="100%">
				  <tr>
					<td style="width:90%;padding:4px;margin:4px;">
						<textarea class="form-control" rows="1" name="message" id="message" placeholder="Comment" required></textarea>
				     </td><td>
					 <input class="btn btn-primary" type="submit" value="Send">
					</td></tr>
					</table>					
				   <input type="hidden" id="success">
				  </form><hr/>
		          <div id="reply" style="height:450px;overflow-x:auto;">';
				  
				  
				  echo '</div>
				 
		       </div>';
		?>
	</div>