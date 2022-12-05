  <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>SET LEARNER'S ACCOUNT</center></h3>
		
        </div>
        <div class="modal-body">
		
		<?php
		session_start();
		include("../vendor/jquery/function.php");
		foreach ($_GET as $key => $data)
			{
			$code=$_GET[$key]=base64_decode(urldecode($data));
				
			}
	    $_SESSION['learner_id']=$code;
		$emp_info=mysqli_query($con,"SELECT * FROM tbl_assessment_rat INNER JOIN tbl_student ON tbl_assessment_rat.LRN =tbl_student.lrn INNER JOIN tbl_school ON tbl_assessment_rat.SchoolID = tbl_school.SchoolID WHERE tbl_student.lrn='".$code."' LIMIT 1");
		 $data=mysqli_fetch_assoc($emp_info);
		
					echo '<b>';
					echo '<img src="/../dbea/image/'.$data['Picture'].'" style="width:200px;height:200px;border-radius:5em;" align="right">';
					echo '<p>LRN: '.$code.'</p>';
					echo '<p>Employee Name: '.$data['Lname'].', '.$data['FName'].' '.$data['MName'].'</p>';
					echo '<p>Current School: '.$data['SchoolName'].'</p>';
					echo  '<p>Birthdate: '.$data['Birthdate'].'</p>';
					echo  '<p>Contact No.: '.$data['ContactNo'].'</p>';
					if ($data['YLevel']=='Kinder')
					{
					echo  '<p>YLevel: '.$data['YLevel'].'</p>';
						
					}else{
					echo  '<p>YLevel: Grade '.$data['YLevel'].'</p>';
					}
					$glrn=mb_strimwidth($data['lrn'],6,6);
					echo  '<hr/>
					<form action="" Method="POST">
					<p>Username: <label><input type="text" class="form-control" value="'.$data['DepedEmail'].'"></label></p>';
					echo  '<p>Password:<label><input type="password" name="password" id="password" class="form-control" value="'.$glrn.'"></label>
					<div class="checkbox">
					  <label style="margin-left:80px;">
							<input title="Show/Hide Password" type="checkbox" onclick="PassUser()"> Show password
					  </label>
					</div>
					<input type="submit" name="Setpassword" value="SET" class="btn btn-success"></p>
					</form>
					';
					
					?>
		</div>
		
	<script>
  function PassUser(){
    var x = document.getElementById('password');
    if (x.type === 'password') {
    x.type = 'text';
    } else {
    x.type = 'password';
    }}
</script> 