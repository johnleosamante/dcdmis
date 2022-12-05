<?php
$_SESSION['SecCode']=$_GET['SecCode'];
$_SESSION['SubCode']=$_GET['SubNo'];	
$_SESSION['Grade']=$_GET['Grade'];	

if ($_GET['Grade']==11 || $_GET['Grade']==12)
	{
	$subject=mysqli_query($con,"SELECT * FROM tbl_senior_sub_strand INNER JOIN class_program ON tbl_senior_sub_strand.StrandsubCode = class_program.SubNo WHERE tbl_senior_sub_strand.StrandsubCode='".$_GET['SubNo']."' AND class_program.SchoolID ='".$_SESSION['SchoolID']."' AND class_program.SecCode ='".$_GET['SecCode']."' LIMIT 1");
	}elseif ($_GET['Grade']>=7 AND $_GET['Grade']<=10){
	$subject=mysqli_query($con,"SELECT * FROM tbl_jhs_subject INNER JOIN class_program ON tbl_jhs_subject.SubNo = class_program.SubNo WHERE tbl_jhs_subject.SubNo='".$_GET['SubNo']."' AND class_program.SchoolID ='".$_SESSION['SchoolID']."' AND class_program.SecCode ='".$_GET['SecCode']."'LIMIT 1");
	}else{
											 
		$subject=mysqli_query($con,"SELECT * FROM tbl_element_subject INNER JOIN class_program ON tbl_element_subject.SubNo = class_program.SubNo WHERE tbl_element_subject.SubNo='".$_GET['SubNo']."' AND class_program.SchoolID ='".$_SESSION['SchoolID']."' AND class_program.SecCode ='".$_GET['SecCode']."' LIMIT 1");
	}


	$rowdata=mysqli_fetch_assoc($subject);	
//Get the time and day
$load=mysqli_query($con,"SELECT * FROM tbl_subject_load INNER JOIN tbl_section ON tbl_subject_load.SecCode=tbl_section.SecCode WHERE tbl_subject_load.Emp_ID='".$_SESSION['EmpID']."' AND tbl_subject_load.School_Year='".$_SESSION['year']."'  AND tbl_subject_load.GradeLevel='".$_SESSION['Grade']."' AND tbl_subject_load.SubCode='".$_GET['SubNo']."' AND tbl_subject_load.SecCode ='".$_GET['SecCode']."'LIMIT 1");
								
//$load=mysqli_query($con,"SELECT * FROM tbl_subject_load INNER JOIN class_program ON tbl_subject_load.SubCode =class_program.SubNo INNER JOIN tbl_section ON class_program.SecCode=tbl_section.SecCode WHERE tbl_subject_load.Emp_ID='".$_SESSION['EmpID']."' AND class_program.SchoolID='".$_SESSION['SchoolID']."' AND tbl_subject_load.SubCode='".$_GET['SubNo']."' LIMIT 1");
$rowsubject=mysqli_fetch_assoc($load);	
if ($_GET['Grade']=='Kinder')
{
	$grade=	$_GET['Grade'];
}else{
	$grade=	'GRADE '.$_GET['Grade'];
}
$_SESSION['LearningAreas']=$rowdata['LearningAreas'];
$_SESSION['Sectiondata']=$rowsubject['SecDesc'];

		if(isset($_POST['addmodule']))
			{
				$mytitle=$_POST['filename'];
				$mytitle=str_replace("'","\'",$mytitle);
				mysqli_query($con,"INSERT INTO tbl_list_of_module_activity VALUES(NULL,'".$mytitle."','".$_SESSION['Grade']."','".$_SESSION['Quarter']."','".$_POST['NoOfPages']."','".$_SESSION['SubCode']."','')");
				if (mysqli_affected_rows($con)==1)
					{
					$Err = "Module Successfully Saved";
					echo '<script type="text/javascript">
							$(document).ready(function(){						
											$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
											
											});</script>
											';	
					echo '<div class="alert alert-success">'.$Err.'</div>';
				}
			}



echo '<div class="col-lg-8">
				
	<div class="panel panel-default">
        <div class="panel-heading">
		<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&SubCode='.urlencode(base64_encode($_GET['SubNo'])).'&v='.urlencode(base64_encode("summary_report")).'" class="btn btn-info" style="float:right;margin:4px;padding:4px;">CLASS RECORD</a>
		<!--<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("gradesheet")).'" style="float:right;margin:4px;padding:4px;" class="btn btn-info">Class Records</a>-->	
			<label style="width:150px;text-transform:uppercase;">Learning Area:</label><label>'.$rowdata['LearningAreas'].' '.$_GET['Grade'].'</label><br/>
			<label style="width:150px;text-transform:uppercase;">Time & Day :</label><label>'.$rowdata['SecTime'].' '.$rowdata['SecDay'].'</label><br/>
			<label style="width:150px;text-transform:uppercase;">Grade & Section:</label><label>'.$grade.' - '.$rowsubject['SecDesc'].'</label>
			                </div>
																
					<div class="panel-body" style="overflow-x:auto;">
						<table width="100%" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th width="5%" style="text-align:center;">#</th>
									<th>Learning Areas Module Details</th>
									<th width="20%" style="text-align:center;"># of Activities Available</th>
									<th width="20%" style="text-align:center;"># of Item Available</th>
									<th width="5%"></th>
								</tr>
						    </thead>
							<tbody>';
								$no=0;
								
								  $module=mysqli_query($con,"SELECT * FROM tbl_module_information INNER JOIN tbl_list_of_module_activity ON tbl_module_information.ModuleTitle = tbl_list_of_module_activity.ModuleCode WHERE tbl_module_information.ModuleQuarter='".$_SESSION['Quarter']."' AND tbl_module_information.ModuleSubCode='".$_SESSION['SubCode']."' AND tbl_module_information.ModuleSecCode='".$_SESSION['SecCode']."' AND tbl_module_information.ModuleSY='".$_SESSION['year']."' ORDER BY Filename Asc");
								 while($rowmodule=mysqli_fetch_array($module))
								 {
									 $no++;
									 $totalitem=0;
									 $activity=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE ModuleCode='".$rowmodule['ModuleCode']."' AND Grade_Level='".$_SESSION['Grade']."' AND SYCode='".$_SESSION['year']."' AND Quarter='".$_SESSION['Quarter']."' AND SubCode='".$_SESSION['SubCode']."'");
									 while ($rowactive=mysqli_fetch_assoc($activity))
									 {
									  $totalitem=$totalitem+$rowactive['ItemNo'];
									 }
									echo '<tr>
											<td>'.$no.'</td>
											<td>'.$rowmodule['Filename'].'</td>
											<td style="text-align:center;" >'.mysqli_num_rows($activity).'</td>
											<td style="text-align:center;" >'.$totalitem.'</td>
											
											<td style="text-align:center;">
											<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Access='.urlencode(base64_encode($rowmodule['ModuleCode'])).'&Item='.urlencode(base64_encode("1")).'&v='.urlencode(base64_encode("written_work_activity")).'">VIEW</a>
											
											</td>
											</tr>'; 
											 
								}
									
							echo '</tbody>
						</table>									
			</div>           
    </div>
</div>
<div class="col-lg-4">
 <div class="panel panel-default">
 <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("class_record")).'" style="float:right;margin:4px;padding:4px;" class="btn btn-primary">Back</a>	
		
        <div class="panel-heading">
		
		Available Modules
		</div>														
		<div class="panel-body">
		<p><i class="fa fa-check fa-fw"></i>'.$_SESSION['Quarter'].' Quarter </p>';
		if ($_SESSION['Grade']==11 || $_SESSION['Grade']==12)
		{
			echo '<form action="" Method="POST" enctype="multipart/form-data">
						<label>Filename:</label>
                        <textarea rows="3" name="filename" class="form-control"></textarea>
						<label># of Pages:</label>
                        <input type="text" name="NoOfPages" class="form-control"><hr/>
						<input type="submit" name="addmodule" class="btn btn-primary" style="float:right;">
						</form>';
		}else{
		$mymodule=mysqli_query($con,"SELECT * FROM tbl_list_of_module_activity WHERE tbl_list_of_module_activity.Quarter='".$_SESSION['Quarter']."' AND tbl_list_of_module_activity.SubCode='".$_SESSION['SubCode']."'  AND tbl_list_of_module_activity.Grade_Level='".$_GET['Grade']."'");
		if (mysqli_num_rows($mymodule))
		{
		while ($rowfirst=mysqli_fetch_array($mymodule))
		{
			echo ' <div class="alert alert-success"><a href="addmodule.php?code='.urlencode(base64_encode($rowfirst['ModuleCode'])).'" title="Click to Activate Module">'.$rowfirst['Filename'].'</a></div>';
		}
		}else{
			echo '<h4>Module is not available!</h4>';
		}
		}
	    echo '</div>	
	  </div>	
</div>';
 ?>           
          