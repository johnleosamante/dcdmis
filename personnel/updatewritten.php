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
         
          <h3 class="modal-title"><center>WRITTEN WORK</center></h3>
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		<?php
		   echo '<label style="padding:4px;margin:4px;">LRN: </label><label>'.$_GET['code'].'</label><br/>';
		   echo '<label style="padding:4px;margin:4px;text-transform:uppercase;">Learner\'s Name: </label><label>'.$row['Lname'].', '.$row['FName'].'</label><br/>
		   <label style="padding:4px;margin:4px;text-transform:uppercase;">Quarter: </label><label>'.$quart.'</label>
		  ';
		?>
		
			<table width="100%" class="table table-striped table-bordered table-hover">	
              <thead>
				<tr>
					<th style="text-align:center;">1</th>
					<th style="text-align:center;">2</th>
					<th style="text-align:center;">3</th>
					<th style="text-align:center;">4</th>
					<th style="text-align:center;">5</th>
					<th style="text-align:center;">6</th>
					<th style="text-align:center;">7</th>
					<th style="text-align:center;">8</th>
					<th style="text-align:center;">9</th>
					<th style="text-align:center;">10</th>
				</tr>
				     <?php
							$totalItem=$no=$activ=0;
										 
							$mywwitem=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE SubCode='".$_SESSION['SubCode']."' AND Grade_Level='".$_SESSION['Grade']."' AND Quarter = '".$quart."' AND activity_remark='RECORDED'");
							$no=mysqli_num_rows($mywwitem);
							echo '<tr>';
										
								while($rowww=mysqli_fetch_array($mywwitem))	
								{
										 echo '<th style="text-align:center;">'.$rowww['ItemNo'].'</th>';
										 $totalItem= $totalItem + $rowww['ItemNo'];
										 $activ++;
								}
								while($no< 10)
										{
										   $no++;
										   echo '<td style="text-align:center;">0</td>';
												 
										}
							echo '</tr>';
                        ?>
			  </thead>	
			<tbody>
			<tr>
				<?php
				$ans=$myscor=$totalscore=0;	
					$myscore1=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_written_work_set_activity ON tbl_activity_learner_score.Activity_Code=tbl_written_work_set_activity.QCode WHERE tbl_activity_learner_score.lrn='".$_GET['code']."' AND tbl_activity_learner_score.SubCode='".$_SESSION['SubCode']."' AND tbl_written_work_set_activity.Quarter= '".$quart."' AND tbl_written_work_set_activity.activity_remark='RECORDED'");
					$ans=mysqli_num_rows($myscore1);										
					while ($rowscore=mysqli_fetch_assoc($myscore1))
							{
								$myscor++;
													
								echo '<td style="text-align:center;">'.$rowscore['Score'].'</td>';
								$totalscore = $totalscore + $rowscore['Score'];
												 											   
							}
												
								while($ans< 10)
								{
										$ans++;
										//No data record
										$myscore2=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_written_work_set_activity ON tbl_activity_learner_score.Activity_Code=tbl_written_work_set_activity.QCode WHERE tbl_activity_learner_score.lrn='".$_GET['code']."' AND tbl_activity_learner_score.SubCode='".$_SESSION['SubCode']."' AND tbl_written_work_set_activity.Quarter='".$quart."' AND tbl_written_work_set_activity.activity_remark='RECORDED'");
										$rowscore2=mysqli_fetch_assoc($myscore2);
										 echo '<td>';
										
										 echo '</td>';
												 
							}
				?>
				</tr>
			</tbody>
			  
			</table>
			
			<div style="width:70%;">
			 <label style="float:left;">Activity:</label>
			  <div style="float:left;width:100%;">
			   <select name="newactivity" class="form-control" onchange="showActivity(this.value)" required>
				 <option value="">--select--</option>
				 <?php
				 $myactivity=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE SubCode='".$_SESSION['SubCode']."' AND Quarter='".$quart."' AND activity_remark='RECORDED' AND Grade_Level='".$_SESSION['Grade']."'");
				 while($rowdata=mysqli_fetch_array($myactivity))
				 {
					echo '<option value="'.$rowdata['QCode'].'">'.$rowdata['Name_of_activity'].'  [ '.$rowdata['Type_of_activity'].' ]</option>';
				 }
				 ?>
			  </select>
			 </div>
		   <div id="viewscore" style="float:left;width:100%;"></div>
		  </div>
		</div>
		 <div class="modal-footer">
		 <input type="submit" name="addscore" class="btn btn-primary" value="SAVE">
		  <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		 </div>
		 
	 
 </form>
 <script>
 function showActivity(str) {
 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("viewscore").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","newscore.php?id="+str,false);
  xmlhttp.send();
}
 </script>		 
	 
 