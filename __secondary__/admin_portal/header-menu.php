
<?php

//Update Deployment History

$result= mysqli_query($con,"SELECT * FROM tbl_deployment_history WHERE tbl_deployment_history.Emp_ID='".$_SESSION['uid']."' LIMIT 1"); 
if (mysqli_num_rows($result)<>0)
{
$getRow=mysqli_fetch_assoc($result);
$myyear=date('Y')-mb_strimwidth($getRow['Date_assignment'],0,4);
mysqli_query($con,"UPDATE tbl_deployment_history SET tbl_deployment_history.No_of_years ='".$myyear."' WHERE tbl_deployment_history.Emp_ID='".$_SESSION['uid']."' LIMIT 1"); 
if ($myyear>=3){
	$qeduc=mysqli_query($con,"SELECT * FROM educational_background WHERE educational_background.Emp_ID ='".$_SESSION['uid']."' AND educational_background.Level='Masteral'");
	$data=mysqli_fetch_assoc($qeduc);
	if (mysqli_num_rows($qeduc)<>0)
	{
	
	if ($data['Highest_Level']=='GRADUATED')
	  {
		 $res=mysqli_query($con,"SELECT * FROM tbl_messages WHERE Message_to='".$_SESSION['uid']."'");
		$mydate=mysqli_fetch_assoc($res);	
		$myoption=mb_strimwidth($mydate['Message_date'],0,4);
		 if ($myoption<>date("Y"))
		 {
		 mysqli_query($con,"INSERT INTO tbl_messages VALUES(NULL,'HRMO','".$_SESSION['uid']."','".'You are qualified for ERF'."','".date('Y-m-d')."','Unread','ERF')");
		 }
	  }
	}
}
}
//Query Step Increment
$get_step=mysqli_query($con,"SELECT * FROM tbl_step_increment WHERE tbl_step_increment.Emp_ID='".$_SESSION['uid']."'");
if (mysqli_num_rows($get_step)<>0)
{
$get_data=mysqli_fetch_assoc($get_step);
$mystep=$get_data['Step_No'];
$mystep++;
if (mysqli_num_rows($get_step)<>0)
{
$mylenght=date('Y')-$get_data['Date_last_step'];
mysqli_query($con,"UPDATE tbl_step_increment SET tbl_step_increment.No_of_year ='".$mylenght."' WHERE tbl_step_increment.Emp_ID='".$_SESSION['uid']."' LIMIT 1"); 
if ($mylenght>=3)
{
	$dquery=mysqli_query($con,"SELECT * FROM tbl_messages WHERE Message_to='".$_SESSION['uid']."' AND Message_date='".date('Y-m-d')."'");
	$getdata=mysqli_fetch_assoc($dquery);
	$gdata=mb_strimwidth($getdata['Message_date'],0,4);
	if ($gdata<>date('Y'))
	{
	 mysqli_query($con,"INSERT INTO tbl_messages VALUES(NULL,'HRMO','".$_SESSION['uid']."','".'You are qualified for Step '.$mystep."','".date('Y-m-d')."','Unread','Steps')");
	}
}
}
}
$myname=mysqli_query($con,"SELECT * FROM tbl_employee WHERE Emp_ID='".$_SESSION['uid']."' LIMIT 1");
$rowdata=mysqli_fetch_assoc($myname);
?>

                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <?php
						$total=$fam=$educ=$civil=$work=$volun=$learn=$other=$ref=0;
		
							$family_data=mysqli_query($con,"SELECT * FROM family_background WHERE family_background.Emp_ID='".$_SESSION['uid']."'");
							if (mysqli_num_rows($family_data)<>0)
								{
								$fam=10;
							}
							$educ_data=mysqli_query($con,"SELECT * FROM educational_background WHERE educational_background.Emp_ID='".$_SESSION['uid']."'");
							if (mysqli_num_rows($educ_data)<>0)
							{
								$educ=15;
							}
							$civil_data=mysqli_query($con,"SELECT * FROM civil_service WHERE civil_service.Emp_ID='".$_SESSION['uid']."'");
							if (mysqli_num_rows($civil_data)<>0)
							{
								$civil=15;
							}
							$work_data=mysqli_query($con,"SELECT * FROM work_experience WHERE work_experience.Emp_ID='".$_SESSION['uid']."'");
							if (mysqli_num_rows($work_data)<>0)
							{
								$work=5;
							}
							$voluntary_data=mysqli_query($con,"SELECT * FROM voluntary_work WHERE voluntary_work.Emp_ID='".$_SESSION['uid']."'");
							if (mysqli_num_rows($voluntary_data)<>0)
							{
								$volun=5;
							}
							$learning_data=mysqli_query($con,"SELECT * FROM learning_and_development WHERE learning_and_development.Emp_ID='".$_SESSION['uid']."'");
							if (mysqli_num_rows($learning_data)<>0)
							{
								$learn=20;
							}
							$other_data=mysqli_query($con,"SELECT * FROM other_information WHERE other_information.Emp_ID='".$_SESSION['uid']."'");
							if (mysqli_num_rows($other_data)<>0)
							{
								$other=10;
							}
							$reference_data=mysqli_query($con,"SELECT * FROM reference WHERE reference.Emp_ID='".$_SESSION['uid']."'");
							if (mysqli_num_rows($reference_data)<>0)
							{
								$ref=20;
							}	
						$total=$fam+$educ+$civil+$work+$volun+$learn+$other+$ref;
						
						echo '<li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>PDS</strong>
                                        <span class="pull-right text-muted">'.$total.'% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:'.$total.'%;">
                                            <span class="sr-only">'.$total.'% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>';
						  ?>
                        <li class="divider"></li>
                        
                       
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                   
                   	<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					<?php
						$mymemo=mysqli_query($con,"SELECT * FROM tbl_memo_notification WHERE MemoTo='".$_SESSION['station']."' AND MemoStatus='Unread'");
						if(mysqli_num_rows($mymemo)<>0)
						{
						echo '<div style="border-radius:50%;width:20px;height:20px;background:red;text-align:center;color:white;">';
						echo mysqli_num_rows($mymemo);
						echo '</div>';
						}
						?>
                        <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
					<?php 
					 $mynotify=mysqli_query($con,"SELECT * FROM tbl_memo_notification WHERE tbl_memo_notification.MemoTo='".$_SESSION['station']."'");
					 while ($rownot=mysqli_fetch_array($mynotify))
					 {
						if ($rownot['NoteType']=='Locator')
						{	
						$myloc=mysqli_query($con,"SELECT * FROM tbl_memo_notification INNER JOIN tbl_locator_passslip ON tbl_memo_notification.MemoNo = tbl_locator_passslip.LocatorNo WHERE tbl_memo_notification.MemoTo='".$_SESSION['station']."' AND tbl_memo_notification.NoteType='Locator' AND tbl_locator_passslip.LocatorNo='".$rownot['MemoNo']."' LIMIT 1");
					    while ($rowloc=mysqli_fetch_assoc($myloc))
						{
						$time=mb_strimwidth($rowloc['DateSend'],11,5);	
                       echo ' <li>
                            <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&MemoNo='.urlencode(base64_encode($rowloc['MemoNo'])).'&v='.urlencode(base64_encode("locator_details")).'">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> Request has been sent...
                                    <span class="pull-right text-muted small">'.$time.'</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>';
                        }
						}elseif ($rownot['NoteType']=='Transaction')
						{	
						echo '<li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-folder fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>';
						}elseif ($rownot['NoteType']=='VHR')
						{	
                        echo '<li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-car fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>';
						}
                       
					 }
                        ?>
                       
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
					
				 <!-- /.dropdown-alerts -->
                </li>
                
				
					