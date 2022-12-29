<?php
# personnel/pds.php
$success = true;
$message = '';
$showPrompt = false;

if (!is_dir('../uploads/images/' . $_SESSION[GetSiteAlias() . '_EmpID'])) {
	mkdir('../uploads/images/' . $_SESSION[GetSiteAlias() . '_EmpID'], 0777, true);
}

/* PERSONAL INFORMATION */
if (isset($_POST['UpdatePersonalInformation'])) {
	$age = date("Y") - $_POST['Year'];

	mysqli_query($con, "UPDATE tbl_employee SET Emp_LName='" . $_POST['LName'] . "',Emp_FName='" . $_POST['FName'] . "',Emp_MName='" . $_POST['MName'] . "', Emp_Extension='" . $_POST['Extension'] . "', Emp_Month='" . $_POST['Month'] . "',Emp_Day='" . $_POST['Day'] . "',Emp_Year='" . $_POST['Year'] . "',Emp_Sex='" . $_POST['gender'] . "',Emp_CS='" . $_POST['CS'] . "',Emp_place_of_birth='" . $_POST['PLB'] . "',Emp_Citizen='" . $_POST['citizen'] . "',Emp_Address='" . $_POST['address'] . "',Emp_Height='" . $_POST['height'] . "',Emp_Weight='" . $_POST['weight'] . "',Emp_Blood_type='" . $_POST['blood'] . "' WHERE Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' LIMIT 1");
	mysqli_query($con, "UPDATE tbl_station SET Emp_age='$age' WHERE Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' LIMIT 1");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Personal Information has been updated successfully!';
		$showPrompt = true;
	}

	$_SESSION[GetSiteAlias() . '_pdstab'] = 'personal-information';
}

if (isset($_POST['ChangeProfilePicture'])) {
	$myfile = $_FILES['image']['name'];
	$temp = $_FILES['image']['tmp_name'];
	$type = $_FILES['image']['type'];
	$ext = pathinfo($myfile, PATHINFO_EXTENSION);
	$myimage = 'uploads/images/' . $_SESSION[GetSiteAlias() . '_EmpID'] . '/' . $_SESSION[GetSiteAlias() . '_EmpID'] . '.' . $ext;
	
	move_uploaded_file($temp, '../' . $myimage);
	mysqli_query($con, "UPDATE tbl_employee SET Picture='" . $myimage . "' WHERE Emp_ID = '" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' LIMIT 1");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Profile picture has been updated successfully!';
		$showPrompt = true;
	}

	$_SESSION[GetSiteAlias() . '_pdstab'] = 'personal-information';
}

if (isset($_POST['UpdateContactNo'])) {
	mysqli_query($con, "UPDATE tbl_employee SET Emp_Cell_No='" . $_POST['Cell'] . "'WHERE Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Contact number has been updated successfully!';
		$showPrompt = true;
	}

	$_SESSION[GetSiteAlias() . '_pdstab'] = 'personal-information';
}

/* FAMILY BACKGROUND */
if (isset($_POST['AddFamilyMember'])) {
	mysqli_query($con, "INSERT INTO family_background VALUES (NULL,'" . $_POST['Lname'] . "','" . $_POST['Fname'] . "','" . $_POST['Mname'] . "','" . $_POST['Birthdate'] . "','" . $_POST['Relation'] . "','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Family member has been added successfully!';
		$showPrompt = true;
	}

	$_SESSION[GetSiteAlias() . '_pdstab'] = 'family-background';
}

/* EDUCATIONAL BACKGROUND */
if (isset($_POST['AddEducation'])) {
	mysqli_query($con, "INSERT INTO educational_background VALUES (NULL,'" . $_POST['level'] . "','" . $_POST['school'] . "','" . $_POST['education'] . "','" . $_POST['from'] . "','" . $_POST['to'] . "','" . $_POST['unit'] . "','" . $_POST['year'] . "','" . $_POST['honor'] . "','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Education has been added successfully!';
		$showPrompt = true;
	}

	$_SESSION[GetSiteAlias() . '_pdstab'] = 'educational-background';
}

/* CIVIL SERVICE ELIGIBILITY */
if (isset($_POST['AddEligibility'])) {
	mysqli_query($con, "INSERT INTO civil_service VALUES (NULL,'" . $_POST['Carrer'] . "','" . $_POST['rating'] . "','" . $_POST['date_exam'] . "','" . $_POST['Place'] . "','" . $_POST['license_number'] . "','" . $_POST['year'] . "','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Civil Service Eligibility has been added successfully!';
		$showPrompt = true;
	}

	$_SESSION[GetSiteAlias() . '_pdstab'] = 'eligibility';
}

/* WORK EXPERIENCE */
if (isset($_POST['AddExperience'])) {
	mysqli_query($con, "INSERT INTO work_experience VALUES (NULL,'" . $_POST['from'] . "','" . $_POST['to'] . "','" . $_POST['position'] . "','" . $_POST['organization'] . "','" . $_POST['monthly'] . "','" . $_POST['step'] . "','" . $_POST['status'] . "','" . $_POST['government'] . "','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Work Experience has been added successfully!';
		$showPrompt = true;
	}

	$_SESSION[GetSiteAlias() . '_pdstab'] = 'work-experience';
}

/* VOLUNTARY WORK */
if (isset($_POST['AddVoluntaryWork'])) {
	mysqli_query($con, "INSERT INTO voluntary_work VALUES (NULL,'" . $_POST['Organization'] . "','" . $_POST['From'] . "','" . $_POST['To'] . "','" . $_POST['Hours'] . "','" . $_POST['Position'] . "','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Voluntary work has been added successfully!';
		$showPrompt = true;
	}

	$_SESSION[GetSiteAlias() . '_pdstab'] = 'voluntary-work';
}

/* LEARNING & DEVELOPMENT */
if (isset($_POST['AddTraining'])) {
	mysqli_query($con, "INSERT INTO learning_and_development VALUES (NULL,'" . $_POST['Title_learning'] . "','" . $_POST['From'] . "','" . $_POST['To'] . "','" . $_POST['No_of_hours'] . "','" . $_POST['TrainingType'] . "','" . $_POST['Conducted'] . "','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Learning &amp; Development (L&amp;D) Intervention has been added successfully!';
		$showPrompt = true;
	}

	$_SESSION[GetSiteAlias() . '_pdstab'] = 'learning-development';
}

/* OTHER INFORMATION TO CHANGE */
if (isset($_POST['AddOtherInformation'])) {
	mysqli_query($con, "INSERT INTO other_information VALUES(NULL,'" . $_POST['skills'] . "','" . $_POST['awards'] . "','" . $_POST['member'] . "','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Other Information has been added successfully!';
		$showPrompt = true;
	}

	$_SESSION[GetSiteAlias() . '_pdstab'] = 'other-information';
}

/* QUESTIONNAIRES TO CHANGE */ 
if (isset($_POST['SaveAnswers'])) {
	//first data entry
	$result_one = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='one' AND Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");
	if (mysqli_num_rows($result_one) == 1) {
		mysqli_query($con, "UPDATE tbl_questioner SET Answer='" . $_POST['one'] . "', Details='" . $_POST['one_details'] . "' WHERE Question='one' AND Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' LIMIT 1");
	} else {
		if ($_POST['one'] == 'Yes') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'one','" . $_POST['one'] . "','" . $_POST['one_details'] . "','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");
		} elseif ($_POST['one'] == 'No') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'one','" . $_POST['one'] . "','-','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");
		}
	}

	//second data entry
	$result_two = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='two' AND Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");
	if (mysqli_num_rows($result_two) == 1) {
		mysqli_query($con, "UPDATE tbl_questioner SET Answer='" . $_POST['two'] . "', Details='" . $_POST['two_details'] . "' WHERE Question='two' AND Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' LIMIT 1");
	} else {
		if ($_POST['two'] == 'Yes') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'two','" . $_POST['two'] . "','" . $_POST['two_details'] . "','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");
		} elseif ($_POST['two'] == 'No') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'two','" . $_POST['two'] . "','-','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");
		}
	}

	//third data entry
	$result_three = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='three' AND Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");
	if (mysqli_num_rows($result_three) == 1) {
		mysqli_query($con, "UPDATE tbl_questioner SET Answer='" . $_POST['three'] . "', Details='" . $_POST['three_details'] . "' WHERE Question='three' AND Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' LIMIT 1");
	} else {
		if ($_POST['three'] == 'Yes') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'three','" . $_POST['three'] . "','" . $_POST['three_details'] . "','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");
		} elseif ($_POST['three'] == 'No') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'three','" . $_POST['three'] . "','-','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");
		}
	}

	//fourth data entry
	$result_four = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='four' AND Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");
	if (mysqli_num_rows($result_four) == 1) {
		mysqli_query($con, "UPDATE tbl_questioner SET Answer='" . $_POST['four'] . "', Details='" . $_POST['four_details'] . "' WHERE Question='four' AND Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' LIMIT 1");
	} else {
		if ($_POST['four'] == 'Yes') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'four','" . $_POST['four'] . "','" . $_POST['four_details'] . "','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");
		} elseif ($_POST['four'] == 'No') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'four','" . $_POST['four'] . "','-','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");
		}
	}

	//five data entry
	$result_five = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='five' AND Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");
	if (mysqli_num_rows($result_five) == 1) {
		mysqli_query($con, "UPDATE tbl_questioner SET Answer='" . $_POST['five'] . "', Details='" . $_POST['five_details'] . "' WHERE Question='five' AND Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' LIMIT 1");
	} else {
		if ($_POST['five'] == 'Yes') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'five','" . $_POST['five'] . "','" . $_POST['five_details'] . "','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");
		} elseif ($_POST['five'] == 'No') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'five','" . $_POST['five'] . "','-','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");
		}
	}

	//six data entry
	$result_six = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='six' AND Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");
	if (mysqli_num_rows($result_six) == 1) {
		mysqli_query($con, "UPDATE tbl_questioner SET Answer='" . $_POST['six'] . "', Details='" . $_POST['six_details'] . "' WHERE Question='six' AND Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' LIMIT 1");
	} else {
		if ($_POST['six'] == 'Yes') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'six','" . $_POST['six'] . "','" . $_POST['six_details'] . "','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");
		} elseif ($_POST['six'] == 'No') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'six','" . $_POST['six'] . "','-','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");
		}
	}

	//seven data entry
	$result_seven = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='seven' AND Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");
	if (mysqli_num_rows($result_seven) == 1) {
		mysqli_query($con, "UPDATE tbl_questioner SET Answer='" . $_POST['seven'] . "', Details='" . $_POST['seven_details'] . "' WHERE Question='seven' AND Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' LIMIT 1");
	} else {
		if ($_POST['seven'] == 'Yes') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'seven','" . $_POST['seven'] . "','" . $_POST['seven_details'] . "','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");
		} elseif ($_POST['seven'] == 'No') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'seven','" . $_POST['seven'] . "','-','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");
		}
	}

	//eight data entry
	$result_eight = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='eight' AND Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");
	if (mysqli_num_rows($result_eight) == 1) {
		mysqli_query($con, "UPDATE tbl_questioner SET Answer='" . $_POST['eight'] . "', Details='" . $_POST['eight_details'] . "' WHERE Question='eight' AND Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' LIMIT 1");
	} else {
		if ($_POST['eight'] == 'Yes') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'eight','" . $_POST['eight'] . "','" . $_POST['eight_details'] . "','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");
		} elseif ($_POST['eight'] == 'No') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'eight','" . $_POST['eight'] . "','-','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");
		}
	}

	//nine data entry
	$result_nine = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='nine' AND Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");
	if (mysqli_num_rows($result_nine) == 1) {
		mysqli_query($con, "UPDATE tbl_questioner SET Answer='" . $_POST['eight'] . "', Details='" . $_POST['nine_details'] . "' WHERE Question='nine' AND Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' LIMIT 1");
	} else {
		if ($_POST['nine'] == 'Yes') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'nine','" . $_POST['nine'] . "','" . $_POST['nine_details'] . "','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");
		} elseif ($_POST['nine'] == 'No') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'nine','" . $_POST['nine'] . "','-','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");
		}
	}

	//ten data entry
	$result_ten = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='ten' AND Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");

	if (mysqli_num_rows($result_ten) == 1) {
		mysqli_query($con, "UPDATE tbl_questioner SET Answer='" . $_POST['ten'] . "', Details='" . $_POST['ten_details'] . "' WHERE Question='ten' AND Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' LIMIT 1");
	} else {
		if ($_POST['ten'] == 'Yes') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'ten','" . $_POST['ten'] . "','" . $_POST['ten_details'] . "','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");
		} elseif ($_POST['ten'] == 'No') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'ten','" . $_POST['ten'] . "','-','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");
		}
	}

	$success = true;
	$message = 'Changes have been saved successfully!';
	$showPrompt = true;

	$_SESSION[GetSiteAlias() . '_pdstab'] = 'questionnaires';
}

/* REFERENCE */
if (isset($_POST['AddReference'])) {
	mysqli_query($con, "INSERT INTO reference VALUES (NULL,'" . $_POST['Ref_Name'] . "','" . $_POST['Address'] . "','" . $_POST['Cell'] . "','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Reference has been added successfully!';
		$showPrompt = true;
	}

	$_SESSION[GetSiteAlias() . '_pdstab'] = 'reference';
}


if (isset($_POST['update_family'])) {
	mysqli_query($con, "UPDATE family_background SET family_background.Family_Name='" . $_POST['Lname'] . "',family_background.First_Name='" . $_POST['Fname'] . "',family_background.Middle_Name='" . $_POST['Mname'] . "',family_background.Birthdate='" . $_POST['Bdate'] . "',family_background.Relation='" . $_POST['Relate'] . "' WHERE family_background.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' AND family_background.No='" . $_SESSION[GetSiteAlias() . '_No'] . "'");

	if (mysqli_affected_rows($con) == 1) {
	?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#access').modal({
					show: 'true'
				});
			});
		</script>
	<?php
	}
}
//Update Education Records
elseif (isset($_POST['update_education'])) {
	mysqli_query($con, "UPDATE educational_background SET educational_background.Level='" . $_POST['ELevel'] . "',educational_background.Name_of_School='" . $_POST['ESchool'] . "',educational_background.Course='" . $_POST['ECourse'] . "',educational_background.From='" . $_POST['EFrom'] . "',educational_background.To='" . $_POST['ETo'] . "',educational_background.Highest_Level='" . $_POST['EHighest'] . "',educational_background.Year_Graduated='" . $_POST['EGraduated'] . "',educational_background.Honor_Recieved='" . $_POST['EHonor'] . "' WHERE educational_background.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' AND educational_background.No='" . $_SESSION[GetSiteAlias() . '_No'] . "'");

	if (mysqli_affected_rows($con) == 1) {
	?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#access').modal({
					show: 'true'
				});
			});
		</script>
	<?php
	}
}
//Update License Records
elseif (isset($_POST['update_licence'])) {
	mysqli_query($con, "UPDATE civil_service SET civil_service.Carrer_Service='" . $_POST['WCareer'] . "',civil_service.Rating='" . $_POST['WRating'] . "',civil_service.Date_of_Examination='" . $_POST['WDate'] . "',civil_service.Place_of_Examination='" . $_POST['WPlace'] . "',civil_service.Number_of_Hour='" . $_POST['WNHour'] . "',civil_service.Date_of_Validity='" . $_POST['WValidity'] . "' WHERE civil_service.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' AND civil_service.No='" . $_SESSION[GetSiteAlias() . '_No'] . "' LIMIT 1");

	if (mysqli_affected_rows($con) == 1) {
	?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#access').modal({
					show: 'true'
				});
			});
		</script>
	<?php
	}
}
//Remove Education Records
elseif (isset($_GET['Licenserow'])) {
	mysqli_query($con, "DELETE FROM civil_service WHERE civil_service.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' AND civil_service.No ='" . $_GET['Licenserow'] . "' LIMIT 1");

	if (mysqli_affected_rows($con) == 1) {
	?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#access').modal({
					show: 'true'
				});
			});
		</script>
	<?php
	}
}
//Update Work Experience Records
elseif (isset($_POST['update_work_experience'])) {
	mysqli_query($con, "UPDATE work_experience SET work_experience.From='" . $_POST['EFrom'] . "',work_experience.To='" . $_POST['ETo'] . "',work_experience.Position_Title='" . $_POST['EPost'] . "',work_experience.Organization='" . $_POST['EOrg'] . "',work_experience.Monthly_Salary='" . $_POST['ESal'] . "',work_experience.Salary_Grade='" . $_POST['EGarde'] . "',work_experience.Job_Status='" . $_POST['EStatus'] . "',work_experience.Goverment='" . $_POST['EGov'] . "' WHERE work_experience.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' AND work_experience.No='" . $_SESSION[GetSiteAlias() . '_No'] . "'");

	if (mysqli_affected_rows($con) == 1) {
	?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#access').modal({
					show: 'true'
				});
			});
		</script>
	<?php
	}
}
//Remove Work Experience Records
elseif (isset($_GET['Workexperiencerow'])) {
	mysqli_query($con, "DELETE FROM work_experience WHERE work_experience.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' AND work_experience.No ='" . $_GET['Workexperiencerow'] . "' LIMIT 1") or die("Work Experience Error");

	if (mysqli_affected_rows($con) == 1) {
	?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#access').modal({
					show: 'true'
				});
			});
		</script>
	<?php
	}
}
//Update Work Volunatry Records
elseif (isset($_POST['update_voluntary'])) {
	mysqli_query($con, "UPDATE voluntary_work SET voluntary_work.Name_of_Organization='" . $_POST['NOrg'] . "',voluntary_work.From='" . $_POST['NFrom'] . "',voluntary_work.To='" . $_POST['NTo'] . "',voluntary_work.Number_of_Hour='" . $_POST['NHour'] . "',voluntary_work.Position='" . $_POST['NPos'] . "' WHERE voluntary_work.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' AND voluntary_work.No='" . $_SESSION[GetSiteAlias() . '_No'] . "'");

	if (mysqli_affected_rows($con) == 1) {
	?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#access').modal({
					show: 'true'
				});
			});
		</script>
	<?php
	}
}
//Remove Work Voluntary Records
elseif (isset($_GET['remove_voluntary'])) {
	mysqli_query($con, "DELETE FROM voluntary_work WHERE voluntary_work.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' AND voluntary_work.No ='" . $_GET['remove_voluntary'] . "' LIMIT 1");

	if (mysqli_affected_rows($con) == 1) {
	?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#access').modal({
					show: 'true'
				});
			});
		</script>
	<?php
	}
}
//Update Learning and Development Records
elseif (isset($_POST['update_LAD'])) {
	mysqli_query($con, "UPDATE learning_and_development SET learning_and_development.Title_of_Training='" . $_POST['TTraining'] . "',learning_and_development.From='" . $_POST['TFrom'] . "',learning_and_development.To='" . $_POST['TTo'] . "',learning_and_development.Number_of_Hours='" . $_POST['THour'] . "',learning_and_development.Managerial='" . $_POST['TManage'] . "',learning_and_development.Conducted='" . $_POST['TConduct'] . "' WHERE learning_and_development.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' AND learning_and_development.No='" . $_SESSION[GetSiteAlias() . '_No'] . "'");

	if (mysqli_affected_rows($con) == 1) {
	?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#access').modal({
					show: 'true'
				});
			});
		</script>
	<?php
	}
}
//Remove Learning and Development Records
elseif (isset($_GET['remove_LAD'])) {
	mysqli_query($con, "DELETE FROM learning_and_development WHERE learning_and_development.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' AND learning_and_development.No ='" . $_GET['remove_LAD'] . "' LIMIT 1");

	if (mysqli_affected_rows($con) == 1) {
	?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#access').modal({
					show: 'true'
				});
			});
		</script>
	<?php
	}
}
//Update Other Information Records
elseif (isset($_POST['update_other'])) {
	mysqli_query($con, "UPDATE other_information SET Special_Skills='" . $_POST['myspecial'] . "',Recognation='" . $_POST['myrecog'] . "',Organization='" . $_POST['myorg'] . "' WHERE other_information.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' AND other_information.No='" . $_SESSION[GetSiteAlias() . '_No'] . "'");

	if (mysqli_affected_rows($con) == 1) {
	?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#access').modal({
					show: 'true'
				});
			});
		</script>
	<?php
	}
}
//Remove Other Information Records
elseif (isset($_GET['Remove_other'])) {
	mysqli_query($con, "DELETE FROM other_information WHERE other_information.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' AND other_information.No ='" . $_GET['Remove_other'] . "' LIMIT 1");

	if (mysqli_affected_rows($con) == 1) {
	?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#access').modal({
					show: 'true'
				});
			});
		</script>
	<?php
	}
}
//Update Reference Records
elseif (isset($_POST['update_reference'])) {
	mysqli_query($con, "UPDATE reference SET Name='" . $_POST['RefName'] . "',Address='" . $_POST['RefAddress'] . "',Tel_No='" . $_POST['RefContact'] . "' WHERE Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' AND No='" . $_SESSION[GetSiteAlias() . '_No'] . "' LIMIT 1");

	if (mysqli_affected_rows($con) == 1) {
	?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#access').modal({
					show: 'true'
				});
			});
		</script>
	<?php
	}
}

/* REFERENCES */
if (isset($_GET['Remove_reference'])) {
	mysqli_query($con, "DELETE FROM reference WHERE reference.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' AND reference.No ='" . $_GET['Remove_reference'] . "' LIMIT 1");

	if (mysqli_affected_rows($con) == 1) {
	?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#access').modal({
					show: 'true'
				});
			});
		</script>
	<?php
	}
}

/* PSIPOP */
if (isset($_POST['save_psipop'])) {
	$query = mysqli_query($con, "SELECT * FROM psipop WHERE Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");

	if (mysqli_num_rows($query) == 0) {
		mysqli_query($con, "UPDATE tbl_station SET Emp_Position ='" . $_POST['position'] . "'  WHERE Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' LIMIT 1");
		mysqli_query($con, "INSERT INTO psipop VALUES(NULL,'" . $_POST['item_number'] . "','" . $_POST['SN'] . "','" . $_POST['jobstatus'] . "','" . $_POST['DOA'] . "','" . $_POST['elegibility'] . "','" . $_SESSION[GetSiteAlias() . '_EmpID'] . "')");
	}

	if (mysqli_affected_rows($con) == 1) {
	?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#access').modal({
					show: 'true'
				});
			});
		</script>
<?php
	}
}
?>

<div class="row mt-4 mb-4">
	<div class="col">
		<div class="card">
			<div class="card-header">
				<?php
				$total = $fam = $educ = $civil = $work = $volun = $learn = $other = $ref = 0;

				$family_data = mysqli_query($con, "SELECT * FROM family_background WHERE family_background.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");
				
				if (mysqli_num_rows($family_data) <> 0) {
					$fam = 10;
				}

				$educ_data = mysqli_query($con, "SELECT * FROM educational_background WHERE educational_background.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");
				
				if (mysqli_num_rows($educ_data) <> 0) {
					$educ = 15;
				}

				$civil_data = mysqli_query($con, "SELECT * FROM civil_service WHERE civil_service.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");
				
				if (mysqli_num_rows($civil_data) <> 0) {
					$civil = 15;
				}

				$work_data = mysqli_query($con, "SELECT * FROM work_experience WHERE work_experience.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");
				
				if (mysqli_num_rows($work_data) <> 0) {
					$work = 5;
				}

				$voluntary_data = mysqli_query($con, "SELECT * FROM voluntary_work WHERE voluntary_work.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");
				
				if (mysqli_num_rows($voluntary_data) <> 0) {
					$volun = 5;
				}

				$learning_data = mysqli_query($con, "SELECT * FROM learning_and_development WHERE learning_and_development.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");
				
				if (mysqli_num_rows($learning_data) <> 0) {
					$learn = 20;
				}

				$other_data = mysqli_query($con, "SELECT * FROM other_information WHERE other_information.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");
				
				if (mysqli_num_rows($other_data) <> 0) {
					$other = 10;
				}

				$reference_data = mysqli_query($con, "SELECT * FROM reference WHERE reference.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");
				
				if (mysqli_num_rows($reference_data) <> 0) {
					$ref = 20;
				}

				$total = $fam + $educ + $civil + $work + $volun + $learn + $other + $ref;
				?>

				<h3 class="h4 mb-2">Personal Data Sheet (<?php echo $total; ?>% Complete)</h3>
				<div class="progress">
					<div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?php echo $total; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $total; ?>%"></div>
				</div><!-- .progress -->
			</div><!-- .card-header -->

			<div class="card-body">
				<ul class="nav nav-tabs mb-3">
					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(!isset($_SESSION[GetSiteAlias() . '_pdstab']) || $_SESSION[GetSiteAlias() . '_pdstab'] === 'personal-information'); ?>" href="#personal-information" data-toggle="tab">Personal Information</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION[GetSiteAlias() . '_pdstab']) && $_SESSION[GetSiteAlias() . '_pdstab'] === 'family-background'); ?>" href="#family-background" data-toggle="tab">Family Background</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION[GetSiteAlias() . '_pdstab']) && $_SESSION[GetSiteAlias() . '_pdstab'] === 'educational-background'); ?>" href="#educational-background" data-toggle="tab">Educational Background</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION[GetSiteAlias() . '_pdstab']) && $_SESSION[GetSiteAlias() . '_pdstab'] === 'eligibility'); ?>" href="#eligibility" data-toggle="tab">Civil Service Eligibility</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION[GetSiteAlias() . '_pdstab']) && $_SESSION[GetSiteAlias() . '_pdstab'] === 'work-experience'); ?>" href="#work-experience" data-toggle="tab">Work Experience</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION[GetSiteAlias() . '_pdstab']) && $_SESSION[GetSiteAlias() . '_pdstab'] === 'voluntary-work'); ?>" href="#voluntary-work" data-toggle="tab">Voluntary Work</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION[GetSiteAlias() . '_pdstab']) && $_SESSION[GetSiteAlias() . '_pdstab'] === 'learning-development'); ?>" href="#learning-development" data-toggle="tab">Learning and Development</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION[GetSiteAlias() . '_pdstab']) && $_SESSION[GetSiteAlias() . '_pdstab'] === 'other-information'); ?>" href="#other-information" data-toggle="tab">Other Information</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION[GetSiteAlias() . '_pdstab']) && $_SESSION[GetSiteAlias() . '_pdstab'] === 'questionnaires'); ?>" href="#questionnaires" data-toggle="tab">Questionnaires</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION[GetSiteAlias() . '_pdstab']) && $_SESSION[GetSiteAlias() . '_pdstab'] === 'references'); ?>" href="#references" data-toggle="tab">References</a>
					</li>
				</ul>

				<?php
				if ($showPrompt) {
					AlertBox($message, $success ? 'success' : 'danger', 'left');
				}
				?>

				<div class="tab-content mt-2">
					<?php
					include_once('pds/personal-information.php');
					include_once('pds/family-background.php');
					include_once('pds/educational-background.php');
					include_once('pds/civil-service-eligibility.php');
					include_once('pds/work-experience.php');
					include_once('pds/voluntary-work.php');
					include_once('pds/learning-development.php');
					include_once('pds/other-information.php');
					include_once('pds/questionnaire.php');
					include_once('pds/reference.php');
					?>
				</div>
			</div><!-- .card-body -->
		</div><!-- .card -->
	</div><!-- .col -->
</div><!-- .row -->
































<!-- Modal for REFERENCES Work-->
<div class="modal fade" id="Myreference" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="loginbox">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">41. REFERENCES (Person not related by consanguinity or afinity to applicant / appointee)
			</div>
			<div class="modal-body">
				<form enctype="multipart/form-data" method="post" role="form" action="">
					<div class="form-group" style="overflow-x:auto;">
						<table width="100%" class="table table-bordered">
							<tr>
								<th style="text-align:center;">Name</th>
								<th style="text-align:center;">Address</th>
								<th style="text-align:center;">Contact Number</th>
							</tr>

							<tr>
								<th><input type="text" name="Ref_Name" class="form-control" required></th>
								<th><input type="text" name="Address" class="form-control" required></th>
								<th><input type="text" name="Cell" class="form-control" required></th>
							</tr>

						</table>
					</div>
					<button type="submit" class="btn btn-primary" name="save_reference" value="SAVE">ADD</button>
				</form>

			</div>
		</div>
	</div>
</div>

<!-- Modal for update EmpID-->
<div class="modal fade" id="MyEmpID" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="deploy">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Update Employee ID</h4>
			</div>
			<div class="modal-body">
				<form enctype="multipart/form-data" method="post" role="form" action="">
					<div class="form-group">
						<table>
							<tr>
								<th>Employee ID:</th>
								<th style="padding:4px;"><input type="text" name="empid" class="form-control" value="<?php echo $_SESSION[GetSiteAlias() . '_EmpID']; ?>"></th>
							</tr>
						</table>
					</div>
					<button type="submit" name="upEmpID" class="btn btn-primary" value="SAVE">UPDATE</button>
				</form>

			</div>
		</div>
	</div>
</div>
<!--Update Cell No-->