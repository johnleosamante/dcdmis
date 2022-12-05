<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
	$posted=mysqli_query($con,"SELECT * FROM reply INNER JOIN tbl_employee ON reply.posted_by=tbl_employee.Emp_ID WHERE reply.chat_id ='".$_SESSION['chatid']."' ORDER BY reply.date_posted Desc");
	if (mysqli_num_rows($posted)<>0)
	{
	while ($row=mysqli_fetch_array($posted))
		{
		echo ' <ul class="chat">
						 <li class="left clearfix">
                                    <span class="chat-img pull-left">
                                        <img src="/../pcdmis/images/'.$row['Picture'].'" alt="User Avatar" class="img-circle" width="50" height="50"/>
                                    </span>
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <strong class="primary-font">'.$row['Emp_LName'].', '.$row['Emp_FName'].'</strong>
                                            <small class="pull-right text-muted">
                                                <i class="fa fa-clock-o fa-fw"></i>'.$row['date_posted'].'
                                            </small>
                                        </div>
                                        <p>'.$row['post_Title'].'</p>
                                    </div>
                                </li>
		
		</ul>';
		}
	}
?>													