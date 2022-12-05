<?php
session_start();
   include("../vendor/jquery/function.php");
	$result=mysqli_query($con,"SELECT * FROM tbl_query_reply INNER JOIN tbl_employee ON tbl_query_reply.ReplyBy = tbl_employee.Emp_ID  WHERE tbl_query_reply.TicketNo ='".$_SESSION['TNo']."' ORDER BY tbl_query_reply.Date_reply Desc");
	while ($row=mysqli_fetch_array($result))
		{
		echo ' <ul class="chat">
						 <li class="left clearfix">
                                    <span class="chat-img pull-left">
                                        <img src="'.$row['Picture'].'" alt="User Avatar" class="img-circle" width="50" height="50"/>
                                    </span>
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <strong class="primary-font">'.$row['Emp_LName'].', '.$row['Emp_FName'].'</strong>
                                            <small class="pull-right text-muted">
                                                <i class="fa fa-clock-o fa-fw"></i>'.$row['Date_reply'].'
                                            </small>
                                        </div>
                                        <p>'.$row['RequestMessage'].'</p>
                                    </div>
                                </li>
		
		</ul>';
		}
?>													