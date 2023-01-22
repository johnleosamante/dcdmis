<?php
# personnel/pds.php
$success = true;
$message = '';
$showPrompt = false;

if (!is_dir('../uploads/images/' . $_SESSION['EmpID'])) {
	mkdir('../uploads/images/' . $_SESSION['EmpID'], 0777, true);
}

/* PERSONAL INFORMATION */
if (isset($_POST['UpdatePersonalInformation'])) {
	$myimage = '';

	if ($_FILES['imageUpload']['size'] > 0 && $_FILES['imageUpload']['error'] == 0) {
		$myfile = $_FILES['imageUpload']['name'];
		$temp = $_FILES['imageUpload']['tmp_name'];
		$type = $_FILES['imageUpload']['type'];
		$ext = pathinfo($myfile, PATHINFO_EXTENSION);
		$myimage = 'uploads/images/' . $_SESSION['EmpID'] . '/' . $_SESSION['EmpID'] . '.' . $ext;

		move_uploaded_file($temp, '../' . $myimage);
	} else {
		$myimage = $_SESSION['Picture'];
	}

	$dob = strtotime($_POST['DateofBirth']);
	$byear = date("Y", $dob);
	$bmonth = date("m", $dob);
	$bday = date("d", $dob);
	$age = date("Y") - $byear;
	$age = date("m") >= $bmonth ? $age : $age--;
	$age = date("d") >= $bday ? $age : $age--;

	mysqli_query($con, "UPDATE tbl_station SET Emp_age='$age' WHERE Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");

	mysqli_query($con, "UPDATE tbl_employee SET 
	Emp_LName='" . str_replace("'", "\'", $_POST['LastName']) . "', 
	Emp_FName='" . str_replace("'", "\'", $_POST['FirstName']) . "', 
	Emp_MName='" . str_replace("'", "\'", $_POST['MiddleName']) . "', 
	Emp_Extension='" . str_replace("'", "\'", $_POST['NameExtension']) . "', 
	Emp_Month='$bmonth', Emp_Day='$bday', Emp_Year='$byear', 
	Emp_place_of_birth='" . str_replace("'", "\'", $_POST['PlaceofBirth']) . "', 
	Emp_Sex='" . str_replace("'", "\'", $_POST['Sex']) . "', 
	Emp_CS='" . str_replace("'", "\'", $_POST['CivilStatus']) . "', 
	Emp_CS_Others='" . str_replace("'", "\'", $_POST['SpecifyOthers']) . "', 
	Emp_Citizen='" . str_replace("'", "\'", $_POST['Citizenship']) . "', 
	Emp_Dual_Citizenship='" . str_replace("'", "\'", $_POST['DualCitizenship']) . "', 
	Emp_Country='" . str_replace("'", "\'", $_POST['Country']) . "', 
	Emp_Res_Lot='" . str_replace("'", "\'", $_POST['ResLot']) . "', 
	Emp_Res_Street='" . str_replace("'", "\'", $_POST['ResStreet']) . "', 
	Emp_Res_Subdivision='" . str_replace("'", "\'", $_POST['ResSubdivision']) . "', 
	Emp_Res_Barangay='" . str_replace("'", "\'", $_POST['ResBarangay']) . "', 
	Emp_Res_City='" . str_replace("'", "\'", $_POST['ResCity']) . "', 
	Emp_Address='" . str_replace("'", "\'", $_POST['ResProvince']) . "', 
	Emp_Res_ZIP='" . str_replace("'", "\'", $_POST['ResZIP']) . "', 
	Emp_Per_Lot='" . str_replace("'", "\'", $_POST['PerLot']) . "', 
	Emp_Per_Street='" . str_replace("'", "\'", $_POST['PerStreet']) . "', 
	Emp_Per_Subdivision='" . str_replace("'", "\'", $_POST['PerSubdivision']) . "', 
	Emp_Per_Barangay='" . str_replace("'", "\'", $_POST['PerBarangay']) . "', 
	Emp_Per_City='" . str_replace("'", "\'", $_POST['PerCity']) . "', 
	Emp_Per_Province='" . str_replace("'", "\'", $_POST['PerProvince']) . "', 
	Emp_Per_ZIP='" . str_replace("'", "\'", $_POST['PerZIP']) . "', 
	Emp_Height='" . str_replace("'", "\'", $_POST['Height']) . "', 
	Emp_Weight='" . str_replace("'", "\'", $_POST['Weight']) . "', 
	Emp_Blood_type='" . str_replace("'", "\'", $_POST['BloodType']) . "', 
	Emp_GSIS='" . str_replace("'", "\'", $_POST['GSIS']) . "', 
	Emp_PAGIBIG='" . str_replace("'", "\'", $_POST['PAGIBIG']) . "', 
	Emp_PHILHEALTH='" . str_replace("'", "\'", $_POST['PHILHEALTH']) . "', 
	Emp_SSS='" . str_replace("'", "\'", $_POST['SSS']) . "', 
	Emp_Telephone='" . str_replace("'", "\'", $_POST['Telephone']) . "', 
	Emp_Cell_No='" . str_replace("'", "\'", $_POST['Mobile']) . "', 
	Emp_Email='" . str_replace("'", "\'", $_POST['Email']) . "',
	Emp_TIN='" . str_replace("'", "\'", $_POST['TIN']) . "', 
	EmpNo='" . str_replace("'", "\'", $_POST['EmployeeNumber']) . "', 
	Picture='$myimage' WHERE Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Personal Information has been updated successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'personal-information';
}

/* FAMILY BACKGROUND */
if (isset($_POST['AddFamilyMember'])) {
	mysqli_query($con, "INSERT INTO family_background VALUES (NULL,'" . $_POST['Lname'] . "','" . $_POST['Fname'] . "','" . $_POST['Mname'] . "','" . $_POST['Birthdate'] . "','" . $_POST['Relation'] . "','" . $_SESSION['EmpID'] . "')");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Family member has been added successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'family-background';
}

if (isset($_POST['UpdateFamilyMember'])) {
	mysqli_query($con, "UPDATE family_background SET family_background.Family_Name='" . $_POST['Lname'] . "',family_background.First_Name='" . $_POST['Fname'] . "',family_background.Middle_Name='" . $_POST['Mname'] . "',family_background.Birthdate='" . $_POST['Bdate'] . "',family_background.Relation='" . $_POST['Relate'] . "' WHERE family_background.Emp_ID='" . $_SESSION['EmpID'] . "' AND family_background.No='" . $_SESSION['No'] . "'");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Family member has been updated successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'family-background';
}

/* EDUCATIONAL BACKGROUND */
if (isset($_POST['AddEducation'])) {
	mysqli_query($con, "INSERT INTO educational_background VALUES (NULL,'" . $_POST['level'] . "','" . $_POST['school'] . "','" . $_POST['education'] . "','" . $_POST['from'] . "','" . $_POST['to'] . "','" . $_POST['unit'] . "','" . $_POST['year'] . "','" . $_POST['honor'] . "','" . $_SESSION['EmpID'] . "')");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Education has been added successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'educational-background';
}

if (isset($_POST['UpdateEducation'])) {
	mysqli_query($con, "UPDATE educational_background SET educational_background.Level='" . $_POST['ELevel'] . "',educational_background.Name_of_School='" . $_POST['ESchool'] . "',educational_background.Course='" . $_POST['ECourse'] . "',educational_background.From='" . $_POST['EFrom'] . "',educational_background.To='" . $_POST['ETo'] . "',educational_background.Highest_Level='" . $_POST['EHighest'] . "',educational_background.Year_Graduated='" . $_POST['EGraduated'] . "',educational_background.Honor_Recieved='" . $_POST['EHonor'] . "' WHERE educational_background.Emp_ID='" . $_SESSION['EmpID'] . "' AND educational_background.No='" . $_SESSION['No'] . "'");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Education has been updated successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'educational-background';
}

/* CIVIL SERVICE ELIGIBILITY */
if (isset($_POST['AddEligibility'])) {
	mysqli_query($con, "INSERT INTO civil_service VALUES (NULL,'" . $_POST['Carrer'] . "','" . $_POST['rating'] . "','" . $_POST['date_exam'] . "','" . $_POST['Place'] . "','" . $_POST['license_number'] . "','" . $_POST['year'] . "','" . $_SESSION['EmpID'] . "')");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Civil Service Eligibility has been added successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'eligibility';
}

if (isset($_POST['UpdateEligibility'])) {
	mysqli_query($con, "UPDATE civil_service SET civil_service.Carrer_Service='" . $_POST['WCareer'] . "',civil_service.Rating='" . $_POST['WRating'] . "',civil_service.Date_of_Examination='" . $_POST['WDate'] . "',civil_service.Place_of_Examination='" . $_POST['WPlace'] . "',civil_service.Number_of_Hour='" . $_POST['WNHour'] . "',civil_service.Date_of_Validity='" . $_POST['WValidity'] . "' WHERE civil_service.Emp_ID='" . $_SESSION['EmpID'] . "' AND civil_service.No='" . $_SESSION['No'] . "' LIMIT 1");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Civil Service Eligibility has been updated successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'eligibility';
}

/* WORK EXPERIENCE */
if (isset($_POST['AddExperience'])) {
	mysqli_query($con, "INSERT INTO work_experience VALUES (NULL,'" . $_POST['from'] . "','" . $_POST['to'] . "','" . $_POST['position'] . "','" . $_POST['organization'] . "','" . $_POST['monthly'] . "','" . $_POST['step'] . "','" . $_POST['status'] . "','" . $_POST['government'] . "','" . $_SESSION['EmpID'] . "')");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Work Experience has been added successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'work-experience';
}

if (isset($_POST['UpdateExperience'])) {
	mysqli_query($con, "UPDATE work_experience SET work_experience.From='" . $_POST['EFrom'] . "',work_experience.To='" . $_POST['ETo'] . "',work_experience.Position_Title='" . $_POST['EPost'] . "',work_experience.Organization='" . $_POST['EOrg'] . "',work_experience.Monthly_Salary='" . $_POST['ESal'] . "',work_experience.Salary_Grade='" . $_POST['EGarde'] . "',work_experience.Job_Status='" . $_POST['EStatus'] . "',work_experience.Goverment='" . $_POST['EGov'] . "' WHERE work_experience.Emp_ID='" . $_SESSION['EmpID'] . "' AND work_experience.No='" . $_SESSION['No'] . "'");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Work Experience has been updated successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'work-experience';
}

/* VOLUNTARY WORK */
if (isset($_POST['AddVoluntaryWork'])) {
	mysqli_query($con, "INSERT INTO voluntary_work VALUES (NULL,'" . $_POST['Organization'] . "','" . $_POST['From'] . "','" . $_POST['To'] . "','" . $_POST['Hours'] . "','" . $_POST['Position'] . "','" . $_SESSION['EmpID'] . "')");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Voluntary work has been added successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'voluntary-work';
}

if (isset($_POST['UpdateVoluntaryWork'])) {
	mysqli_query($con, "UPDATE voluntary_work SET voluntary_work.Name_of_Organization='" . $_POST['NOrg'] . "',voluntary_work.From='" . $_POST['NFrom'] . "',voluntary_work.To='" . $_POST['NTo'] . "',voluntary_work.Number_of_Hour='" . $_POST['NHour'] . "',voluntary_work.Position='" . $_POST['NPos'] . "' WHERE voluntary_work.Emp_ID='" . $_SESSION['EmpID'] . "' AND voluntary_work.No='" . $_SESSION['No'] . "'");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Voluntary work has been updated successfully!';
		$showPrompt = true;
	}


	$_SESSION['pdstab'] = 'voluntary-work';
}

/* LEARNING & DEVELOPMENT */
if (isset($_POST['AddTraining'])) {
	mysqli_query($con, "INSERT INTO learning_and_development VALUES (NULL,'" . $_POST['Title_learning'] . "','" . $_POST['From'] . "','" . $_POST['To'] . "','" . $_POST['No_of_hours'] . "','" . $_POST['TrainingType'] . "','" . $_POST['Conducted'] . "','" . $_SESSION['EmpID'] . "')");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Learning &amp; Development (L&amp;D) Intervention has been added successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'learning-development';
}

if (isset($_POST['UpdateTraining'])) {
	mysqli_query($con, "UPDATE learning_and_development SET learning_and_development.Title_of_Training='" . $_POST['TTraining'] . "',learning_and_development.From='" . $_POST['TFrom'] . "',learning_and_development.To='" . $_POST['TTo'] . "',learning_and_development.Number_of_Hours='" . $_POST['THour'] . "',learning_and_development.Managerial='" . $_POST['TManage'] . "',learning_and_development.Conducted='" . $_POST['TConduct'] . "' WHERE learning_and_development.Emp_ID='" . $_SESSION['EmpID'] . "' AND learning_and_development.No='" . $_SESSION['No'] . "'");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Learning &amp; Development (L&amp;D) Intervention has been updated successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'learning-development';
}

/* OTHER INFORMATION TO CHANGE */
if (isset($_POST['AddOtherInformation'])) {
	mysqli_query($con, "INSERT INTO other_information VALUES(NULL,'" . $_POST['skills'] . "','" . $_POST['awards'] . "','" . $_POST['member'] . "','" . $_SESSION['EmpID'] . "')");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Other Information has been added successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'other-information';
}

if (isset($_POST['UpdateOtherInformation'])) {
	mysqli_query($con, "UPDATE other_information SET Special_Skills='" . $_POST['myspecial'] . "',Recognation='" . $_POST['myrecog'] . "',Organization='" . $_POST['myorg'] . "' WHERE other_information.Emp_ID='" . $_SESSION['EmpID'] . "' AND other_information.No='" . $_SESSION['No'] . "'");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Other Information has been updated successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'other-information';
}

/* QUESTIONNAIRES TO CHANGE */
if (isset($_POST['SaveAnswers'])) {
	//first data entry
	$result_one = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='one' AND Emp_ID='" . $_SESSION['EmpID'] . "'");
	if (mysqli_num_rows($result_one) == 1) {
		mysqli_query($con, "UPDATE tbl_questioner SET Answer='" . $_POST['one'] . "', Details='" . $_POST['one_details'] . "' WHERE Question='one' AND Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");
	} else {
		if ($_POST['one'] == 'Yes') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'one','" . $_POST['one'] . "','" . $_POST['one_details'] . "','" . $_SESSION['EmpID'] . "')");
		} elseif ($_POST['one'] == 'No') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'one','" . $_POST['one'] . "','-','" . $_SESSION['EmpID'] . "')");
		}
	}

	//second data entry
	$result_two = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='two' AND Emp_ID='" . $_SESSION['EmpID'] . "'");
	if (mysqli_num_rows($result_two) == 1) {
		mysqli_query($con, "UPDATE tbl_questioner SET Answer='" . $_POST['two'] . "', Details='" . $_POST['two_details'] . "' WHERE Question='two' AND Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");
	} else {
		if ($_POST['two'] == 'Yes') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'two','" . $_POST['two'] . "','" . $_POST['two_details'] . "','" . $_SESSION['EmpID'] . "')");
		} elseif ($_POST['two'] == 'No') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'two','" . $_POST['two'] . "','-','" . $_SESSION['EmpID'] . "')");
		}
	}

	//third data entry
	$result_three = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='three' AND Emp_ID='" . $_SESSION['EmpID'] . "'");
	if (mysqli_num_rows($result_three) == 1) {
		mysqli_query($con, "UPDATE tbl_questioner SET Answer='" . $_POST['three'] . "', Details='" . $_POST['three_details'] . "' WHERE Question='three' AND Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");
	} else {
		if ($_POST['three'] == 'Yes') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'three','" . $_POST['three'] . "','" . $_POST['three_details'] . "','" . $_SESSION['EmpID'] . "')");
		} elseif ($_POST['three'] == 'No') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'three','" . $_POST['three'] . "','-','" . $_SESSION['EmpID'] . "')");
		}
	}

	//fourth data entry
	$result_four = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='four' AND Emp_ID='" . $_SESSION['EmpID'] . "'");
	if (mysqli_num_rows($result_four) == 1) {
		mysqli_query($con, "UPDATE tbl_questioner SET Answer='" . $_POST['four'] . "', Details='" . $_POST['four_details'] . "' WHERE Question='four' AND Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");
	} else {
		if ($_POST['four'] == 'Yes') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'four','" . $_POST['four'] . "','" . $_POST['four_details'] . "','" . $_SESSION['EmpID'] . "')");
		} elseif ($_POST['four'] == 'No') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'four','" . $_POST['four'] . "','-','" . $_SESSION['EmpID'] . "')");
		}
	}

	//five data entry
	$result_five = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='five' AND Emp_ID='" . $_SESSION['EmpID'] . "'");
	if (mysqli_num_rows($result_five) == 1) {
		mysqli_query($con, "UPDATE tbl_questioner SET Answer='" . $_POST['five'] . "', Details='" . $_POST['five_details'] . "' WHERE Question='five' AND Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");
	} else {
		if ($_POST['five'] == 'Yes') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'five','" . $_POST['five'] . "','" . $_POST['five_details'] . "','" . $_SESSION['EmpID'] . "')");
		} elseif ($_POST['five'] == 'No') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'five','" . $_POST['five'] . "','-','" . $_SESSION['EmpID'] . "')");
		}
	}

	//six data entry
	$result_six = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='six' AND Emp_ID='" . $_SESSION['EmpID'] . "'");
	if (mysqli_num_rows($result_six) == 1) {
		mysqli_query($con, "UPDATE tbl_questioner SET Answer='" . $_POST['six'] . "', Details='" . $_POST['six_details'] . "' WHERE Question='six' AND Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");
	} else {
		if ($_POST['six'] == 'Yes') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'six','" . $_POST['six'] . "','" . $_POST['six_details'] . "','" . $_SESSION['EmpID'] . "')");
		} elseif ($_POST['six'] == 'No') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'six','" . $_POST['six'] . "','-','" . $_SESSION['EmpID'] . "')");
		}
	}

	//seven data entry
	$result_seven = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='seven' AND Emp_ID='" . $_SESSION['EmpID'] . "'");
	if (mysqli_num_rows($result_seven) == 1) {
		mysqli_query($con, "UPDATE tbl_questioner SET Answer='" . $_POST['seven'] . "', Details='" . $_POST['seven_details'] . "' WHERE Question='seven' AND Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");
	} else {
		if ($_POST['seven'] == 'Yes') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'seven','" . $_POST['seven'] . "','" . $_POST['seven_details'] . "','" . $_SESSION['EmpID'] . "')");
		} elseif ($_POST['seven'] == 'No') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'seven','" . $_POST['seven'] . "','-','" . $_SESSION['EmpID'] . "')");
		}
	}

	//eight data entry
	$result_eight = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='eight' AND Emp_ID='" . $_SESSION['EmpID'] . "'");
	if (mysqli_num_rows($result_eight) == 1) {
		mysqli_query($con, "UPDATE tbl_questioner SET Answer='" . $_POST['eight'] . "', Details='" . $_POST['eight_details'] . "' WHERE Question='eight' AND Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");
	} else {
		if ($_POST['eight'] == 'Yes') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'eight','" . $_POST['eight'] . "','" . $_POST['eight_details'] . "','" . $_SESSION['EmpID'] . "')");
		} elseif ($_POST['eight'] == 'No') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'eight','" . $_POST['eight'] . "','-','" . $_SESSION['EmpID'] . "')");
		}
	}

	//nine data entry
	$result_nine = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='nine' AND Emp_ID='" . $_SESSION['EmpID'] . "'");
	if (mysqli_num_rows($result_nine) == 1) {
		mysqli_query($con, "UPDATE tbl_questioner SET Answer='" . $_POST['eight'] . "', Details='" . $_POST['nine_details'] . "' WHERE Question='nine' AND Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");
	} else {
		if ($_POST['nine'] == 'Yes') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'nine','" . $_POST['nine'] . "','" . $_POST['nine_details'] . "','" . $_SESSION['EmpID'] . "')");
		} elseif ($_POST['nine'] == 'No') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'nine','" . $_POST['nine'] . "','-','" . $_SESSION['EmpID'] . "')");
		}
	}

	//ten data entry
	$result_ten = mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Question='ten' AND Emp_ID='" . $_SESSION['EmpID'] . "'");

	if (mysqli_num_rows($result_ten) == 1) {
		mysqli_query($con, "UPDATE tbl_questioner SET Answer='" . $_POST['ten'] . "', Details='" . $_POST['ten_details'] . "' WHERE Question='ten' AND Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");
	} else {
		if ($_POST['ten'] == 'Yes') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'ten','" . $_POST['ten'] . "','" . $_POST['ten_details'] . "','" . $_SESSION['EmpID'] . "')");
		} elseif ($_POST['ten'] == 'No') {
			mysqli_query($con, "INSERT INTO tbl_questioner VALUES(NULL,'ten','" . $_POST['ten'] . "','-','" . $_SESSION['EmpID'] . "')");
		}
	}

	$success = true;
	$message = 'Changes have been saved successfully!';
	$showPrompt = true;

	$_SESSION['pdstab'] = 'questionnaires';
}

/* REFERENCE */
if (isset($_POST['AddReference'])) {
	mysqli_query($con, "INSERT INTO reference VALUES (NULL,'" . $_POST['Ref_Name'] . "','" . $_POST['Address'] . "','" . $_POST['Cell'] . "','" . $_SESSION['EmpID'] . "')");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Reference has been added successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'reference';
}

if (isset($_POST['UpdateReference'])) {
	mysqli_query($con, "UPDATE reference SET Name='" . $_POST['RefName'] . "',Address='" . $_POST['RefAddress'] . "',Tel_No='" . $_POST['RefContact'] . "' WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND No='" . $_SESSION['No'] . "' LIMIT 1");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Reference has been updated successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'reference';
}
?>

<div class="row mt-4 mb-4">
	<div class="col">
		<div class="card">
			<div class="card-header">
				<?php
				$total = $fam = $educ = $civil = $work = $volun = $learn = $other = $ref = 0;
				$family_data = mysqli_query($con, "SELECT * FROM family_background WHERE family_background.Emp_ID='" . $_SESSION['EmpID'] . "'");

				if (mysqli_num_rows($family_data) <> 0) {
					$fam = 10;
				}

				$educ_data = mysqli_query($con, "SELECT * FROM educational_background WHERE educational_background.Emp_ID='" . $_SESSION['EmpID'] . "'");

				if (mysqli_num_rows($educ_data) <> 0) {
					$educ = 15;
				}

				$civil_data = mysqli_query($con, "SELECT * FROM civil_service WHERE civil_service.Emp_ID='" . $_SESSION['EmpID'] . "'");

				if (mysqli_num_rows($civil_data) <> 0) {
					$civil = 15;
				}

				$work_data = mysqli_query($con, "SELECT * FROM work_experience WHERE work_experience.Emp_ID='" . $_SESSION['EmpID'] . "'");

				if (mysqli_num_rows($work_data) <> 0) {
					$work = 5;
				}

				$voluntary_data = mysqli_query($con, "SELECT * FROM voluntary_work WHERE voluntary_work.Emp_ID='" . $_SESSION['EmpID'] . "'");

				if (mysqli_num_rows($voluntary_data) <> 0) {
					$volun = 5;
				}

				$learning_data = mysqli_query($con, "SELECT * FROM learning_and_development WHERE learning_and_development.Emp_ID='" . $_SESSION['EmpID'] . "'");

				if (mysqli_num_rows($learning_data) <> 0) {
					$learn = 20;
				}

				$other_data = mysqli_query($con, "SELECT * FROM other_information WHERE other_information.Emp_ID='" . $_SESSION['EmpID'] . "'");

				if (mysqli_num_rows($other_data) <> 0) {
					$other = 10;
				}

				$reference_data = mysqli_query($con, "SELECT * FROM reference WHERE reference.Emp_ID='" . $_SESSION['EmpID'] . "'");

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
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(!isset($_SESSION['pdstab']) || $_SESSION['pdstab'] === 'personal-information'); ?>" href="#personal-information" data-toggle="tab">Personal Information</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'family-background'); ?>" href="#family-background" data-toggle="tab">Family Background</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'educational-background'); ?>" href="#educational-background" data-toggle="tab">Educational Background</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'eligibility'); ?>" href="#eligibility" data-toggle="tab">Civil Service Eligibility</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'work-experience'); ?>" href="#work-experience" data-toggle="tab">Work Experience</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'voluntary-work'); ?>" href="#voluntary-work" data-toggle="tab">Voluntary Work</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'learning-development'); ?>" href="#learning-development" data-toggle="tab">Learning and Development</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'other-information'); ?>" href="#other-information" data-toggle="tab">Other Information</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'questionnaires'); ?>" href="#questionnaires" data-toggle="tab">Questionnaires</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'reference'); ?>" href="#reference" data-toggle="tab">References</a>
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

<div class="modal fade" id="UpdateModal" role="dialog" data-backdrop="static" data-keyboard="false"></div><!-- .modal -->