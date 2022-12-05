  <?php
  session_start();
  include("../pcdmis/vendor/jquery/function.php");
  foreach ($_GET as $key => $data)
	{
		$quart=$_GET[$key]=base64_decode(urldecode($data));	
	}
	$result=mysqli_query($con,"SELECT * FROM tbl_student WHERE lrn='".$_GET['code']."' LIMIT 1");
	$row=mysqli_fetch_assoc($result);
	$_SESSION['Current_LRN']=$_GET['code'];
	$_SESSION['Current_Quarter']=$quart;
	
  ?>
  <div class="modal-header">
         
          <h3 class="modal-title"><center>FIRST QUARTER EXAM</center></h3>
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		<?php
		   echo '<label style="padding:4px;margin:4px;">LRN: </label><label>'.$_GET['code'].'</label><br/>';
		   echo '<label style="padding:4px;margin:4px;text-transform:uppercase;">Learner\'s Name: </label><label>'.$row['Lname'].', '.$row['FName'].'</label><br/>
		   <label style="padding:4px;margin:4px;text-transform:uppercase;">Quarter: </label><label>'.$quart.'</label>
		  ';
		?><br/>
		 <?php
				  $myQEitemNo=mysqli_query($con,"SELECT * FROM tbl_major_exam WHERE SubCode='".$_SESSION['SubCode']."' AND Quarter ='".$quart."' AND SecCode='".$_SESSION['SecCode']."' AND SYCode='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' AND Grade ='".$_SESSION['Grade']."' ORDER BY Date_created Asc LIMIT 1");
				  $rowdata=mysqli_fetch_array($myQEitemNo);
				  echo '<input type="hidden" name="newactivity" class="form-control" value="'.$rowdata['QCode'].'">';
				  echo '<input type="hidden" name="itemNo" class="form-control" value="'.$rowdata['ItemNo'].'">';
				 
				 ?>
		<label style="padding:4px;margin:4px;">QUARTER EXAM SCORE:</label>
		<input type="text" name="newscore" class="form-control">
			
		</div>
		 <div class="modal-footer">
		 <input type="submit" name="addscore" class="btn btn-primary" value="SAVE">
		  <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		 </div>
		 
	 
 </form>
