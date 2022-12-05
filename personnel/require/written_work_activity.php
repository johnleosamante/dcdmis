<?php
$_SESSION['Access']=$_GET['Access'];
$_SESSION['Item']=$_GET['Item'];
$record=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE SubCode='".$_SESSION['SubCode']."' AND SYCode='".$_SESSION['year']."' AND Quarter='".$_SESSION['Quarter']."' AND PageNo='".$_GET['Item']."' AND Grade_Level='".$_SESSION['Grade']."' AND ModuleCode='".$_GET['Access']."'");
$row=mysqli_fetch_assoc($record);
$_SESSION['Activity_Code']=$row['QCode'];

						
if ($_SESSION['Grade']==11 || $_SESSION['Grade']==12)
	{
	$subject=mysqli_query($con,"SELECT * FROM tbl_senior_sub_strand INNER JOIN class_program ON tbl_senior_sub_strand.StrandsubCode = class_program.SubNo WHERE tbl_senior_sub_strand.StrandsubCode='".$_SESSION['SubCode']."' AND class_program.SchoolID ='".$_SESSION['SchoolID']."' AND class_program.SecCode='".$_SESSION['SecCode']."' LIMIT 1");
	}elseif ($_SESSION['Grade']>=7 AND $_SESSION['Grade']<=10){
	$subject=mysqli_query($con,"SELECT * FROM tbl_jhs_subject INNER JOIN class_program ON tbl_jhs_subject.SubNo = class_program.SubNo WHERE tbl_jhs_subject.SubNo='".$_SESSION['SubCode']."' AND class_program.SchoolID ='".$_SESSION['SchoolID']."' AND class_program.SecCode='".$_SESSION['SecCode']."' LIMIT 1");
	}else{
											 
		$subject=mysqli_query($con,"SELECT * FROM tbl_element_subject INNER JOIN class_program ON tbl_element_subject.SubNo = class_program.SubNo WHERE tbl_element_subject.SubNo='".$_SESSION['SubCode']."' AND class_program.SchoolID ='".$_SESSION['SchoolID']."' AND class_program.SecCode='".$_SESSION['SecCode']."' AND class_program.SecCode='".$_SESSION['SecCode']."'LIMIT 1");
	}
	$rowdata=mysqli_fetch_assoc($subject);	
//Get the time and day
$load=mysqli_query($con,"SELECT * FROM tbl_subject_load INNER JOIN tbl_section ON tbl_subject_load.SecCode=tbl_section.SecCode WHERE tbl_subject_load.Emp_ID='".$_SESSION['EmpID']."' AND tbl_subject_load.School_Year='".$_SESSION['year']."'  AND tbl_subject_load.GradeLevel='".$_SESSION['Grade']."' AND tbl_subject_load.SubCode='".$_SESSION['SubCode']."' AND tbl_subject_load.SecCode ='".$_SESSION['SecCode']."'LIMIT 1");

$rowsubject=mysqli_fetch_assoc($load);	
if ($_SESSION['Grade']=='Kinder')
{
	$grade=	$_SESSION['Grade'];
}else{
	$grade=	'GRADE '.$_SESSION['Grade'];
}

$download=mysqli_query($con,"SELECT * FROM tbl_list_of_module_activity WHERE Quarter='".$_SESSION['Quarter']."' AND SubCode='".$_SESSION['SubCode']."' AND  Grade_Level = '".$_SESSION['Grade']."' AND ModuleCode='".$_GET['Access']."' LIMIT 1");
	$rowdown=mysqli_fetch_assoc( $download);							

echo '<div class="col-lg-8">
   <!--<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode($_SESSION['Grade'])).'&SubNo='.urlencode(base64_encode($_SESSION['SubCode'])).'&SecCode='.urlencode(base64_encode($_SESSION['SecCode'])).'&v='.urlencode(base64_encode("video_materials")).'" class="btn btn-info">Video Materials</a>--><hr/>';
		 $myimage=mysqli_query($con,"SELECT * FROM tbl_list_of_module_activity WHERE tbl_list_of_module_activity.SubCode='".$_SESSION['SubCode']."' AND tbl_list_of_module_activity.ModuleCode ='".$_GET['Access']."' AND Grade_Level='".$_SESSION['Grade']."'  AND Quarter='".$_SESSION['Quarter']."' LIMIT 1");
			$rowimage=mysqli_fetch_assoc($myimage);
			
			  echo '<iframe src="../../pcdmis/reading_materials/'.$rowimage['Module_location'].'" frameborder="0" style="width:100%;height:700px;"></iframe>';
			
$subjectstatus=mysqli_query($con,"SELECT * FROM tbl_module_information WHERE ModuleSubCode ='".$_SESSION['SubCode']."' AND ModuleQuarter='".$_SESSION['Quarter']."' AND ModuleSY ='".$_SESSION['year']."' AND ModuleTitle='".$_GET['Access']."' AND ModuleSecCode='".$_SESSION['SecCode']."' LIMIT 1");										
$rowstatus=mysqli_fetch_assoc($subjectstatus);
	
echo '</div>

<div class="col-lg-4">
<div class="panel panel-default">
<a href="set_module.php?id='.urlencode(base64_encode($rowstatus['Module_status'])).'" class="btn btn-info">Module is '.$rowstatus['Module_status'].' <br/>Click to Change</a>
<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode($_SESSION['Grade'])).'&SubNo='.urlencode(base64_encode($_SESSION['SubCode'])).'&SecCode='.urlencode(base64_encode($_SESSION['SecCode'])).'&v='.urlencode(base64_encode("class_list")).'" style="float:right;" class="btn btn-secondary">Back</a>
		
        <div class="panel-heading">
		
			Module Activity 
         </div>
																
			<div class="panel-body" style="overflow-x:auto;">
			  <table width="100%" class="table table-striped table-bordered table-hover">
					 <thead>
						 <tr>
							
							<th>Type of Activity</th>
							<th>Total Item</th>
							<th>Answer Key</th>
							<th></th>
						</tr>
					 </thead>
					  <tbody>';
									  
						  $no=0;
							 $Activity=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE SubCode='".$_SESSION['SubCode']."' AND SYCode='".$_SESSION['year']."' AND Quarter='".$_SESSION['Quarter']."' AND Grade_Level='".$_SESSION['Grade']."' AND ModuleCode='".$_GET['Access']."'");
							  while ($rowactivity=mysqli_fetch_array($Activity))
							  {
							   $no++;
							   $answer=0;
							   $answerkey=mysqli_query($con,"SELECT * FROM tbl_activity_sheets WHERE SubCode ='".$_SESSION['SubCode']."' AND Activity_Code='".$rowactivity['QCode']."'");
								while($rowans=mysqli_fetch_array($answerkey))
								{
									if ($rowans['Correct_Answer']<>"")
									{
										$answer=$answer+1;
									}
								}
								echo '<tr>
									
									<td>'.$rowactivity['Type_of_activity'].' ('.$rowactivity['Name_of_activity'].')</td>
									<td style="text-align:center;">'.$rowactivity['ItemNo'].'</td>
									<td style="text-align:center;">'.$answer.'</td>
									<td><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&m='.urlencode(base64_encode($rowactivity['QCode'])).'&ItemNo='.urlencode(base64_encode($_GET['Item'])).'&Item='.urlencode(base64_encode($rowactivity['ItemNo'])).'&Type='.urlencode(base64_encode($rowactivity['Name_of_activity'])).'&Name='.urlencode(base64_encode($rowactivity['Type_of_activity'])).'&v='.urlencode(base64_encode("written_work_set_work")).'">VIEW</a></td>
									</tr>';
							  }
									 
				  echo '</tbody>
		 </table>	
	';
	
					$video=mysqli_query($con,"SELECT * FROM tbl_video_materials WHERE SubCode='".$_SESSION['SubCode']."' AND ModuleCode='".$_SESSION['Access']."' AND Quarter='".$_SESSION['Quarter']."' AND School_Year='".$_SESSION['year']."' AND Grade_Level='".$_SESSION['Grade']."'");
					$rowvid=mysqli_fetch_assoc($video);
					echo '<iframe width="100%" height="280" src="https://www.youtube.com/embed/'.$rowvid['video_link'].'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

	</div>				
</div>
</div>';
?>
