
<?php
if (!is_dir('../pcdmis/reading_materials/'.$_SESSION['year'].'/'.$_SESSION['Grade'].'/'.$_SESSION['Access'].'/'.$_SESSION['SubCode'].'/'.$_SESSION['Quarter'].'/'.$_GET['ItemNo'])) {
    mkdir('../pcdmis/reading_materials/'.$_SESSION['year'].'/'.$_SESSION['Grade'].'/'.$_SESSION['Access'].'/'.$_SESSION['SubCode'].'/'.$_SESSION['Quarter'].'/'.$_GET['ItemNo'], 0777, true);
}
$_SESSION['pathlocation']='../pcdmis/reading_materials/'.$_SESSION['year'].'/'.$_SESSION['Grade'].'/'.$_SESSION['Access'].'/'.$_SESSION['SubCode'].'/'.$_SESSION['Quarter'].'/'.$_GET['ItemNo'];

$_SESSION['ActivityCode']=$_GET['m'];
$_SESSION['Item']=$_GET['Item'];
$_SESSION['ItemNo']=$_GET['ItemNo'];
$_SESSION['Type']=$_GET['Type'];
$_SESSION['Name']=$_GET['Name'];

if (isset($_POST['set_answer']))
{
 mysqli_query($con,"UPDATE tbl_activity_sheets SET Correct_Answer ='".$_POST['Answer']."' WHERE SubCode='".$_SESSION['SubCode']."' AND Activity_Code='".$_GET['m']."' AND Activity_No='".$_GET['ItemNo']."' LIMIT 1");	
 if(mysqli_affected_rows($con)==1)
		{
		?>
		

		<script type="text/javascript">
		$(document).ready(function(){						
			 $('#access').modal({
				show: 'true'
			}); 				
		});
		</script>
		
 
		<?php
	}
}

//Instruction details
$direction=mysqli_query($con,"SELECT * FROM tbl_activity_sheets_instruction WHERE SubCode='".$_SESSION['SubCode']."' AND Activity_Code='".$_GET['m']."' LIMIT 1");
$rowdirect=mysqli_fetch_assoc($direction);

//Question Data
$myquestion=mysqli_query($con,"SELECT * FROM tbl_activity_sheets WHERE SubCode='".$_SESSION['SubCode']."' AND Activity_Code='".$_GET['m']."' AND Activity_No='".$_GET['ItemNo']."'");
 $rowquestion=mysqli_fetch_assoc($myquestion);	
 
 //Activity Status
 $status=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE QCode='".$_GET['m']."' LIMIT 1");
 $rostate=mysqli_fetch_assoc($status);
 if ( $rostate['Activity_status']<>'Closed')
 {
	 
echo '<div class="col-lg-8">
      
		<div class="alert alert-success" style="color:black;border-radius:.3em;text-align:justify;width:100%;font-size:14px;">';
		 echo '<p style="color:black;"><b>'.$rowdirect['Activity_Instruction'].'</b></p>';
		
	   echo '</div>
		<div class="alert alert-danger" style="color:black;border-radius:.3em;text-align:left;width:100%;font-size:20px;">';
		
		if ($rowquestion['Activity_question']==NULL)
		{
			echo '<b>'.$_GET['ItemNo'].'.</b> <img src="'.$rowquestion['Link_picture'].'" style="width:90%;height:50%;">
			<hr/>';
			
		}else{
			echo '<h4><b>'.$_GET['ItemNo'].'.</b> '.$rowquestion['Activity_question'].'</h4>';
			if ($rowquestion['Link_picture']<>"")
			{
			echo '<img src="'.$rowquestion['Link_picture'].'" style="width:60%;height:auto;">';
			}	
		echo '<hr/>';
		}
		echo '<form action="" method="POST">';
		$queryidentify=mysqli_query($con,"SELECT * FROM tbl_activity_sheets_option WHERE QNumber='".$_GET['ItemNo']."' AND SubCode='".$_SESSION['SubCode']."' AND Activity_code='".$_GET['m']."'");
		if ($_GET['Type']=='MULTIPLE CHOICE')
		{
			while($rowdata=mysqli_fetch_array($queryidentify))
			{
			if ($rowdata['Letter']==$rowquestion['Correct_Answer'])	
			{
				echo '<div class="radio">
				<label>
					<input type="radio" name="Answer" id="optionsRadios1" value="'.$rowdata['Letter'].'" checked>'.$rowdata['Letter'].'.'.$rowdata['QOption'].'
				</label>
			</div>';
			}else{
				echo '<div class="radio">
					<label>
						<input type="radio" name="Answer" id="optionsRadios1" value="'.$rowdata['Letter'].'" required>'.$rowdata['Letter'].'.'.$rowdata['QOption'].'
					</label>
				</div>';
			}
			}
		}else{
			while($rowdata=mysqli_fetch_array($queryidentify))
			{
				if ($rowdata['QOption']==$rowquestion['Correct_Answer'])
				{
					echo '<div class="radio">
					<label>
						<input type="radio" name="Answer" id="optionsRadios1" value="'.$rowdata['QOption'].'" checked >'.$rowdata['QOption'].'
					</label>
				</div>';
					
				}else{
				echo '<div class="radio">
					<label>
						<input type="radio" name="Answer" id="optionsRadios1" value="'.$rowdata['QOption'].'" required>'.$rowdata['QOption'].'
					</label>
				</div>';
				}
			}
		} 
	echo '</div>';
	if (mysqli_num_rows($myquestion)<>0)
	{
	  echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Access='.urlencode(base64_encode($_SESSION['Access'])).'&Item='.urlencode(base64_encode("1")).'&v='.urlencode(base64_encode("view_score")).'" class="btn btn-primary" style="float:right;">VIEW SCORE</a>
	  <input type="submit" name="set_answer" value="SET ANSWER" class="btn btn-success">';
	}
	 echo '</form>
	
</div>

<div class="col-lg-4">
<div class="panel panel-default">
        <div class="panel-heading">
		<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Access='.urlencode(base64_encode($_SESSION['Access'])).'&Item='.urlencode(base64_encode("1")).'&v='.urlencode(base64_encode("written_work_activity")).'" style="float:right;" class="btn btn-secondary">Back</a>
			Quiz Navigation
         </div>
																
			<div class="panel-body" style="overflow-x:auto;">';
			echo '<b style="text-transform:uppercase;">'.$_GET['Name'].' ('.$_GET['Type'].')</b><hr/>';
			$_SESSION['ActType']=$_GET['Type'];
			$_SESSION['Name']=$_GET['Name'];
			$pageNo=1;
			while($pageNo<=$_GET['Item'])
			{
				$myans=mysqli_query($con,"SELECT * FROM tbl_activity_sheets WHERE SubCode='".$_SESSION['SubCode']."' AND Activity_Code='".$_GET['m']."' AND Activity_No='".$pageNo."' LIMIT 1");
				$rowans=mysqli_fetch_assoc($myans);
				if ($rowans['Correct_Answer']<>'')
				{
				echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&m='.urlencode(base64_encode($_GET['m'])).'&ItemNo='.urlencode(base64_encode($pageNo)).'&Item='.urlencode(base64_encode($_GET['Item'])).'&Type='.urlencode(base64_encode($_GET['Type'])).'&Name='.urlencode(base64_encode($_GET['Name'])).'&v='.urlencode(base64_encode("written_work_set_work")).'" class="btn btn-primary" style="height:50px;padding:10px;margin:4px;">'.$pageNo.'</a>';	
				}else{
				echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&m='.urlencode(base64_encode($_GET['m'])).'&ItemNo='.urlencode(base64_encode($pageNo)).'&Item='.urlencode(base64_encode($_GET['Item'])).'&Type='.urlencode(base64_encode($_GET['Type'])).'&Name='.urlencode(base64_encode($_GET['Name'])).'&v='.urlencode(base64_encode("written_work_set_work")).'" class="btn btn-secondary" style="height:50px;padding:10px;margin:4px;">'.$pageNo.'</a>';
				}
				$pageNo++;
			}
	$timelimit=$_GET['Item']*2; 
	$mystatus=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE QCode='".$_GET['m']."' LIMIT 1");
	$rowstatus=mysqli_fetch_assoc($mystatus);
	echo '<hr/>
	<label>Time Limit: '.$timelimit.' Minutes</label>
	
	
	
	</div>
	
</div>
</div>';
 
 }else{
	 echo '<div class="alert alert-success" style="color:black;border-radius:.3em;text-align:justify;width:100%;font-size:14px;"><h4>Uploading actvity....</h4></div>';
 }
?>

	  
