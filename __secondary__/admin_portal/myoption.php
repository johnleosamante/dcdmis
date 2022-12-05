
<?php
session_start();
include("../vendor/jquery/function.php");
$_SESSION['No']=$_GET['No'];
$myQA=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_questionaires WHERE QNumber='".$_GET['No']."' AND SubCode='".$_SESSION['SubCode']."'");
$myrow=mysqli_fetch_assoc($myQA);

?>
<div class="modal-header">
			<button type="button" class="close" aria-hidden="true" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Questionnairs Option</h4>
			</div>
			 <form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-body">
			<?php
			  if ($myrow['Link_picture']<>NULL)
				{
			 echo  '<img src="'.$myrow['Link_picture'].'" style="width:100%;" align="left">';
			 }else{
				 echo $_GET['No'].'. '.$myrow['Questionnairs'];
			 }
			?><hr/>
			
			<?php
			//Letter A
			$myoptionA=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber = '".$_SESSION['No']."' AND tbl_assessment_rat_option.SubCode='".$_SESSION['SubCode']."' AND tbl_assessment_rat_option.Letter ='A' LIMIT 1");
			$optionA=mysqli_fetch_assoc($myoptionA);
			//Letter B
			$myoptionB=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber = '".$_SESSION['No']."' AND tbl_assessment_rat_option.SubCode='".$_SESSION['SubCode']."' AND tbl_assessment_rat_option.Letter ='B' LIMIT 1");
			$optionB=mysqli_fetch_assoc($myoptionB);
			//Letter C
			$myoptionC=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber = '".$_SESSION['No']."' AND tbl_assessment_rat_option.SubCode='".$_SESSION['SubCode']."' AND tbl_assessment_rat_option.Letter ='C' LIMIT 1");
			$optionC=mysqli_fetch_assoc($myoptionC);
			//Letter D
			$myoptionD=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber = '".$_SESSION['No']."' AND tbl_assessment_rat_option.SubCode='".$_SESSION['SubCode']."' AND tbl_assessment_rat_option.Letter ='D' LIMIT 1");
			$optionD=mysqli_fetch_assoc($myoptionD);
			//Letter E
			$myoptionE=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_option WHERE tbl_assessment_rat_option.QNumber = '".$_SESSION['No']."' AND tbl_assessment_rat_option.SubCode='".$_SESSION['SubCode']."' AND tbl_assessment_rat_option.Letter ='E' LIMIT 1");
			$optionE=mysqli_fetch_assoc($myoptionE);
			
	  echo '<div class="form-group input-group">
			<span class="input-group-addon">A</span>
			<input type="text" name="A" class="form-control" id="AnsA" value="'.$optionA['QOption'].'" placeholder="Enter Option A">
			
			</div>
			<div class="form-group input-group">
			<span class="input-group-addon">B</span>
			<input type="text" name="B" class="form-control" value="'.$optionB['QOption'].'" placeholder="Enter Option B">
			
			</div>
			<div class="form-group input-group">
			<span class="input-group-addon">C</span>
			<input type="text" name="C" class="form-control" value="'.$optionC['QOption'].'" placeholder="Enter Option C">
			
			</div>
			<div class="form-group input-group">
			<span class="input-group-addon">D</span>
			<input type="text" name="D" class="form-control" value="'.$optionD['QOption'].'" placeholder="Enter Option D">
			
			</div>
			<div class="form-group input-group">
			<span class="input-group-addon">E</span>
			<input type="text" name="E" class="form-control" value="'.$optionE['QOption'].'" placeholder="Enter Option E">
			
			</div>
		   	</div>
           <div class="modal-footer">
		   <label style="float:left;width:75%;">
		   <select name="Answer" class="form-control" required>
				<option value="">--Select Answer--</option>
				<option value="A">A</option>
				<option value="B">B</option>
				<option value="C">C</option>
				<option value="D">D</option>
				<option value="E">E</option>
			
		   </select>
		   </label>
		   <button type="submit" class="btn btn-success" name="AddOption">SUBMIT</button>
		 </div>	';
		 ?>
		 </form>