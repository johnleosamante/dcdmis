  <?php
 	
 $myschool=mysqli_query($con,"SELECT * FROM tbl_school INNER JOIN tbl_employee ON tbl_school.Incharg_ID = tbl_employee.Emp_ID INNER JOIN tbl_station  ON tbl_employee.Emp_ID=tbl_station.Emp_ID WHERE tbl_school.SchoolID ='".$_SESSION['school_id']."'");
 $row=mysqli_fetch_assoc($myschool);
 
 //$mydistrict=mysqli_query($con,"SELECT * FROM tbl_district WHERE District_code='".$row['District_code']."' LIMIT 1");
 //$rowdistrict=mysqli_fetch_assoc($mydistrict);
 
  //Position Data
 //$mypost=mysqli_query($con,"SELECT * FROM tbl_job WHERE tbl_job.Job_code= '".$row['Emp_Position']."' LIMIT 1");
 //$rowdata=mysqli_fetch_assoc($mypost);
 
 //$_SESSION['DName']=$rowdistrict['District_Name'];
 //$_SESSION['Category']=$row['School_Category'];
 //$_SESSION['SchoolName']=$row['SchoolName'];
 //$_SESSION['Address']=$row['Address'];
// $gdata=mb_strimwidth($row['Emp_MName'],0,1);
 //$_SESSION['Principal']=$row['Emp_FName'].' '.$gdata.'. '.$row['Emp_LName'];
 //$_SESSION['PrinCat']=$row['Emp_Category'];
 //$_SESSION['Job']='School Principal';	
 //$_SESSION['SchoolType']=$row['SchoolType'];
 //$_SESSION['SchoolABR']=$row['Abraviate'];
 //$_SESSION['Job']=$rowdata['Job_description'];
 
//  if ($row['SchoolLogo']==NULL)
//  {
// 	$logo='../pcdmis/logo/logo.png'; 
//  }else{
//  $logo='../'.$row['SchoolLogo'];
//  }
//  echo '<div class="col-lg-12" style="padding:10px;">
// 		<img src="'.$logo.'" width="50" height="50" align="left" style="padding:1px;">
//          <label style="padding:0px;margin:0px;font-size:25px;text-transform:uppercase;">'.$_SESSION['SchoolName'].' ('.$rowdistrict['District_Name'].')</label><br/>
// 		<small style="padding:0px;margin:0px;font-size:14px;">Region IX / '.$_SESSION['Address'].' / Zamboanga Peninsula</small>
	    
// 		 </div>';

//  ?>
