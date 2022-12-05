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
	
	
	
	<?php
	session_start();
   include("../vendor/jquery/function.php");
   
		foreach ($_GET as $key => $data)
		{
			$data2=$_GET[$key]=base64_decode(urldecode($data));
			$encript_2=((($data2*956783)/5678)/123456789);
		}
	$posted=mysqli_query($con,"SELECT * FROM post INNER JOIN tbl_employee ON post.posted_by=tbl_employee.Emp_ID  WHERE post.id = '".$encript_2."' ORDER BY post.date_posted Desc");
	$row=mysqli_fetch_assoc($posted);
	$_SESSION['chat-id']=$encript_2;
	echo ' <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>Division New</center></h3>
		 
        </div>
        <div class="modal-body">
			<ul class="chat">
			  <li class="left clearfix">
				<span class="chat-img pull-left">
					<img src="'.$row['Picture'].'" alt="User" class="img-circle" width="50" height="50"/>
				</span>
						<div class="chat-body clearfix">
							<div class="header">
								<strong class="primary-font">'.$row['Emp_LName'].', '.$row['Emp_FName'].' ('.$row['post_office'].' office)</strong>
									<small class="pull-right text-muted">
									<i class="fa fa-clock-o fa-fw"></i> '.$row['date_posted'].'
								</small>
						</div>
					<p>'.$row['post_Title'].'</p>
					
					
																
			 </div>';
				if ($row['Ext']=='jpg' || $row['Ext']=='JPG' || $row['Ext']=='png' || $row['Ext']=='PNG')
					{
						echo '<img src="'.$row['Attach_file'].'" style="width:100%;height:300px;">';
					}elseif ($row['Ext']=='mp4' || $row['Ext']=='mov' || $row['Ext']=='mpeg' || $row['Ext']=='avi')
					{
						echo '<video src="'.$row['Attach_file'].'" style="width:100%;height:300px;" controls></video>';
					}elseif ($row['Ext']=='pdf')
					{
						echo '<iframe src="'.$row['Attach_file'].'" style="width:100%;height:300px;" frameborder="0"></iframe>';
					}elseif ($row['Ext']=='Youtube')
					{
						echo '<iframe width="100%" height="300" src="https://www.youtube.com/embed/'.$row['Attach_file'].'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						
						';
					}
					
			  echo '<hr/><div id="reply" style="height:300px;overflow-x:auto;"></div>
			  <form action="send-reply.php" id="frmBox" method="POST" onsubmit="return formSubmit();">
						<li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" name="message" id="message" class="form-control" placeholder="Enter message...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="submit" onlick="formSubmit()">
								<i class="fa fa-send"></i> 
								</button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li></li></ul>
						<input type="hidden" id="success">
						</form>
					
		
		</div>
		';
	?>	