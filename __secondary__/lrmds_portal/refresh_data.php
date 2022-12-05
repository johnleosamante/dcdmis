<head>
<!--<link rel="stylesheet" href="../shs/chat.css">-->
</head>
<?php
session_start();
include("../vendor/jquery/function.php");

echo '<!-- /.panel-heading -->
                       
                            <ul class="chat">';
							$str=sha1('learners information system');
							$mychat=mysqli_query($con,"SELECT * FROM tbl_chat INNER JOIN tbl_employee ON  tbl_chat.Emp_ID = tbl_employee.Emp_ID ")or die ("Error chat");
							while($myrow=mysqli_fetch_array($mychat))
							{
                               echo  '<li style="padding:4px;cursor:pointer;" title="'.$myrow['Emp_LName'].'">
                                    <span class="chat-img pull-left">
                                        <img src="'.$myrow['Picture'].'" width="30" height="30" class="img-circle" />
                                    </span>
                                        <p style="padding:4px;margin:1px;">&nbsp;'.$myrow['Messages'].'</p>
                                    </div>
                                </li>';
								
							}	
                               
                          echo '</ul>
                        
                        <!-- /.panel-body -->	';			
?> 

			