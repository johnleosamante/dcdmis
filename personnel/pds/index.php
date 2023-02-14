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
	Picture='$myimage' WHERE Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1;");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Personal Information has been updated successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'personal-information';
}

/* FAMILY BACKGROUND */
if (isset($_POST['UpdateFamilyBackground'])) {
	$family_background = mysqli_query($con, "SELECT * FROM tbl_family_background WHERE Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1;");

	if (mysqli_num_rows($family_background) === 0) {
		mysqli_query($con, "INSERT INTO tbl_family_background VALUES (
			'" . $_SESSION['EmpID'] . "', 
			'" . str_replace("'", "\'", $_POST['SLastName']) . "',
			'" . str_replace("'", "\'", $_POST['SFirstName']) . "',
			'" . str_replace("'", "\'", $_POST['SNameExtension']) . "',
			'" . str_replace("'", "\'", $_POST['SMiddleName']) . "',
			'" . str_replace("'", "\'", $_POST['SOccupation']) . "',
			'" . str_replace("'", "\'", $_POST['SBusiness']) . "',
			'" . str_replace("'", "\'", $_POST['SBusinessAddress']) . "',
			'" . str_replace("'", "\'", $_POST['STelephone']) . "',
			'" . str_replace("'", "\'", $_POST['FLastName']) . "',
			'" . str_replace("'", "\'", $_POST['FFirstName']) . "',
			'" . str_replace("'", "\'", $_POST['FNameExtension']) . "',
			'" . str_replace("'", "\'", $_POST['FMiddleName']) . "',
			'" . str_replace("'", "\'", $_POST['MLastName']) . "',
			'" . str_replace("'", "\'", $_POST['MFirstName']) . "',
			'" . str_replace("'", "\'", $_POST['MMiddleName']) . "');");
	} else {
		mysqli_query($con, "UPDATE tbl_family_background SET 
		SpouseLast='" . str_replace("'", "\'", $_POST['SLastName']) . "',
		SpouseFirst='" . str_replace("'", "\'", $_POST['SFirstName']) . "', 
		SpouseExtension='" . str_replace("'", "\'", $_POST['SNameExtension']) . "',
		SpouseMiddle='" . str_replace("'", "\'", $_POST['SMiddleName']) . "',
		SpouseOccupation='" . str_replace("'", "\'", $_POST['SOccupation']) . "',
		SpouseBusiness='" . str_replace("'", "\'", $_POST['SBusiness']) . "',
		SpouseBusinessAddress='" . str_replace("'", "\'", $_POST['SBusinessAddress']) . "',
		SpouseTelephone='" . str_replace("'", "\'", $_POST['STelephone']) . "',
		FatherLast='" . str_replace("'", "\'", $_POST['FLastName']) . "',
		FatherFirst='" . str_replace("'", "\'", $_POST['FFirstName']) . "',
		FatherExtension='" . str_replace("'", "\'", $_POST['FNameExtension']) . "',
		FatherMiddle='" . str_replace("'", "\'", $_POST['FMiddleName']) . "',
		MotherLast='" . str_replace("'", "\'", $_POST['MLastName']) . "',
		MotherFirst='" . str_replace("'", "\'", $_POST['MFirstName']) . "',
		MotherMiddle='" . str_replace("'", "\'", $_POST['MMiddleName']) . "'
		WHERE Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1;");
	}

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Family Background has been updated successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'family-background';
}

/* CHILDREN */
if (isset($_POST['SaveChild'])) {
	if (strlen($_SESSION['No']) === 0) {
		mysqli_query($con, "INSERT INTO family_background VALUES (NULL, 
		'" . str_replace("'", "\'", $_POST['CLastName']) . "',
		'" . str_replace("'", "\'", $_POST['CFirstName']) . "',
		'" . str_replace("'", "\'", $_POST['CNameExtension']) . "', 
		'" . str_replace("'", "\'", $_POST['CMiddleName']) . "',
		'" . str_replace("'", "\'", $_POST['CDateOfBirth']) . "', '',
		'" . $_SESSION['EmpID'] . "'
	);");

		$message = 'Child Name has been added successfully!';
	} else {
		mysqli_query($con, "UPDATE family_background SET 
		Family_Name='" . str_replace("'", "\'", $_POST['CLastName']) . "',
		First_Name='" . str_replace("'", "\'", $_POST['CFirstName']) . "',
		Name_Extension='" . str_replace("'", "\'", $_POST['CNameExtension']) . "', Middle_Name='" . str_replace("'", "\'", $_POST['CMiddleName']) . "',
		Birthdate='" . str_replace("'", "\'", $_POST['CDateOfBirth']) . "'
		WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND `No`='" . $_SESSION['No'] . "';");

		$message = 'Child Name has been updated successfully!';
	}


	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'family-background';
}

if (isset($_POST['RemoveChild'])) {
	mysqli_query($con, "DELETE FROM family_background WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND No='" . $_SESSION['No'] . "' LIMIT 1;");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Child Name has been removed successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'family-background';
}

/* EDUCATIONAL BACKGROUND */
if (isset($_POST['SaveEducation'])) {
	if (strlen($_SESSION['No']) === 0) {
		mysqli_query($con, "INSERT INTO educational_background VALUES (NULL,
		'" . str_replace("'", "\'", $_POST['ELevel']) . "',
		'" . str_replace("'", "\'", $_POST['ESchool']) . "',
		'" . str_replace("'", "\'", $_POST['ECourse']) . "',
		'" . str_replace("'", "\'", $_POST['EFrom']) . "',
		'" . str_replace("'", "\'", $_POST['ETo']) . "',
		'" . str_replace("'", "\'", $_POST['EHighest']) . "',
		'" . str_replace("'", "\'", $_POST['EGraduated']) . "',
		'" . str_replace("'", "\'", $_POST['EHonor']) . "',
		'" . $_SESSION['EmpID'] . "');");

		$message = 'Educational Background has been added successfully!';
	} else {
		mysqli_query($con, "UPDATE educational_background SET 
		`Level`='" . str_replace("'", "\'", $_POST['ELevel']) . "',
		Name_of_School='" . str_replace("'", "\'", $_POST['ESchool']) . "',
		Course='" . str_replace("'", "\'", $_POST['ECourse']) . "',
		`From`='" . str_replace("'", "\'", $_POST['EFrom']) . "',
		`To`='" . str_replace("'", "\'", $_POST['ETo']) . "',
		Highest_Level='" . str_replace("'", "\'", $_POST['EHighest']) . "',
		Year_Graduated='" . str_replace("'", "\'", $_POST['EGraduated']) . "',
		Honor_Recieved='" . str_replace("'", "\'", $_POST['EHonor']) . "' 
		WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND `No`='" . $_SESSION['No'] . "';");

		$message = 'Educational Background has been updated successfully!';
	}

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'educational-background';
}

if (isset($_POST['RemoveEducation'])) {
	mysqli_query($con, "DELETE FROM educational_background WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND No='" . $_SESSION['No'] . "' LIMIT 1;");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Educational Background has been removed successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'educational-background';
}

/* CIVIL SERVICE ELIGIBILITY */
if (isset($_POST['SaveEligibility'])) {
	if (strlen($_SESSION['No']) === 0) {
		mysqli_query($con, "INSERT INTO civil_service VALUES (NULL,
		'" . str_replace("'", "\'", $_POST['WCareer']) . "',
		'" . str_replace("'", "\'", $_POST['WRating']) . "',
		'" . str_replace("'", "\'", $_POST['WDate']) . "',
		'" . str_replace("'", "\'", $_POST['WPlace']) . "',
		'" . str_replace("'", "\'", $_POST['WLicense']) . "',
		'" . str_replace("'", "\'", $_POST['WValidity']) . "',
		'" . $_SESSION['EmpID'] . "');");

		$message = 'Civil Service Eligibility has been added successfully!';
	} else {
		mysqli_query($con, "UPDATE civil_service SET 
		Carrer_Service='" . str_replace("'", "\'", $_POST['WCareer']) . "',
		Rating='" . str_replace("'", "\'", $_POST['WRating']) . "',
		Date_of_Examination='" . str_replace("'", "\'", $_POST['WDate']) . "',
		Place_of_Examination='" . str_replace("'", "\'", $_POST['WPlace']) . "',
		Number_of_Hour='" . str_replace("'", "\'", $_POST['WLicense']) . "',
		Date_of_Validity='" . str_replace("'", "\'", $_POST['WValidity']) . "' 
		WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND No='" . $_SESSION['No'] . "' LIMIT 1;");

		$message = 'Civil Service Eligibility has been updated successfully!';
	}

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'eligibility';
}

if (isset($_POST['RemoveEligibility'])) {
	mysqli_query($con, "DELETE FROM civil_service WHERE civil_service.Emp_ID='" . $_SESSION['EmpID'] . "' AND `No`='" . $_SESSION['No'] . "' LIMIT 1;");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Civil Service Eligibility has been removed successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'eligibility';
}

/* WORK EXPERIENCE */
if (isset($_POST['SaveExperience'])) {
	if (strlen($_SESSION['No']) === 0) {
		mysqli_query($con, "INSERT INTO work_experience VALUES (NULL,
		'" . str_replace("'", "\'", $_POST['EFrom']) . "',
		'" . str_replace("'", "\'", $_POST['ETo']) . "',
		'" . str_replace("'", "\'", $_POST['EPosition']) . "',
		'" . str_replace("'", "\'", $_POST['EOrganization']) . "',
		'" . str_replace("'", "\'", $_POST['ESalary']) . "',
		'" . str_replace("'", "\'", $_POST['ESGrade']) . "',
		'" . str_replace("'", "\'", $_POST['EStatus']) . "',
		'" . str_replace("'", "\'", $_POST['EGovernment']) . "',
		'" . $_SESSION['EmpID'] . "');");

		$message = 'Work Experience has been added successfully!';
	} else {
		mysqli_query($con, "UPDATE work_experience SET 
		`From`='" . str_replace("'", "\'", $_POST['EFrom']) . "',
		`To`='" . str_replace("'", "\'", $_POST['ETo']) . "',
		Position_Title='" . str_replace("'", "\'", $_POST['EPosition']) . "',
		Organization='" . str_replace("'", "\'", $_POST['EOrganization']) . "',
		Monthly_Salary='" . str_replace("'", "\'", $_POST['ESalary']) . "',
		Salary_Grade='" . str_replace("'", "\'", $_POST['ESGrade']) . "',
		Job_Status='" . str_replace("'", "\'", $_POST['EStatus']) . "',
		Goverment='" . str_replace("'", "\'", $_POST['EGovernment']) . "' 
		WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND No='" . $_SESSION['No'] . "';");

		$message = 'Work Experience has been updated successfully!';
	}

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'work-experience';
}

if (isset($_POST['RemoveExperience'])) {
	mysqli_query($con, "DELETE FROM work_experience WHERE work_experience.Emp_ID='" . $_SESSION['EmpID'] . "' AND `No`='" . $_SESSION['No'] . "' LIMIT 1;");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Work Experience has been removed successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'work-experience';
}

/* VOLUNTARY WORK */
if (isset($_POST['SaveVoluntaryWork'])) {
	if (strlen($_SESSION['No']) === 0) {
		mysqli_query($con, "INSERT INTO voluntary_work VALUES (NULL,
		'" . str_replace("'", "\'", $_POST['NOrganization']) . "',
		'" . str_replace("'", "\'", $_POST['NFrom']) . "',
		'" . str_replace("'", "\'", $_POST['NTo']) . "',
		'" . str_replace("'", "\'", $_POST['NHour']) . "',
		'" . str_replace("'", "\'", $_POST['NPosition']) . "',
		'" . $_SESSION['EmpID'] . "');");

		$message = 'Voluntary Work has been added successfully!';
	} else {
		mysqli_query($con, "UPDATE voluntary_work SET 
		Name_of_Organization='" . str_replace("'", "\'", $_POST['NOrganization']) . "',
		`From`='" . str_replace("'", "\'", $_POST['NFrom']) . "',
		`To`='" . str_replace("'", "\'", $_POST['NTo']) . "',
		Number_of_Hour='" . str_replace("'", "\'", $_POST['NHour']) . "',
		Position='" . str_replace("'", "\'", $_POST['NPosition']) . "' 
		WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND `No`='" . $_SESSION['No'] . "';");

		$message = 'Voluntary Work has been updated successfully!';
	}

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'voluntary-work';
}

if (isset($_POST['RemoveVoluntaryWork'])) {
	mysqli_query($con, "DELETE FROM voluntary_work WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND `No`='" . $_SESSION['No'] . "' LIMIT 1;");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Voluntary Work has been removed successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'voluntary-work';
}

/* LEARNING & DEVELOPMENT */
if (isset($_POST['SaveLearningDevelopment'])) {
	if (strlen($_SESSION['No']) === 0) {
		mysqli_query($con, "INSERT INTO learning_and_development VALUES (NULL,
		'" . str_replace("'", "\'", $_POST['TTraining']) . "',
		'" . str_replace("'", "\'", $_POST['TFrom']) . "',
		'" . str_replace("'", "\'", $_POST['TTo']) . "',
		'" . str_replace("'", "\'", $_POST['THour']) . "',
		'" . str_replace("'", "\'", $_POST['TManage']) . "',
		'" . str_replace("'", "\'", $_POST['TConduct']) . "',
		'" . $_SESSION['EmpID'] . "');");

		$message = 'Learning &amp; Development (L&amp;D) Intervention has been added successfully!';
	} else {
		mysqli_query($con, "UPDATE learning_and_development SET 
		Title_of_Training='" . str_replace("'", "\'", $_POST['TTraining']) . "',
		`From`='" . str_replace("'", "\'", $_POST['TFrom']) . "',
		`To`='" . str_replace("'", "\'", $_POST['TTo']) . "',
		Number_of_Hours='" . str_replace("'", "\'", $_POST['THour']) . "',
		Managerial='" . str_replace("'", "\'", $_POST['TManage']) . "',
		Conducted='" . str_replace("'", "\'", $_POST['TConduct']) . "' 
		WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND `No`='" . $_SESSION['No'] . "';");

		$message = 'Learning &amp; Development (L&amp;D) Intervention has been updated successfully!';
	}

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'learning-development';
}

if (isset($_POST['RemoveLearningDevelopment'])) {
	mysqli_query($con, "DELETE FROM learning_and_development WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND `No`='" . $_SESSION['No'] . "' LIMIT 1;");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Learning &amp; Development (L&amp;D) Intervention has been removed successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'learning-development';
}

/* SPECIAL SKILL */
if (isset($_POST['SaveSpecialSkill'])) {
	if (strlen($_SESSION['No']) === 0) {
		mysqli_query($con, "INSERT INTO tbl_special_skills VALUES (NULL,
		'" . str_replace("'", "\'", $_POST['Skill']) . "',
		'" . $_SESSION['EmpID'] . "');");

		$message = 'Special Skill / Hobby has been added successfully!';
	} else {
		mysqli_query($con, "UPDATE tbl_special_skills SET 
		Special_Skills='" . str_replace("'", "\'", $_POST['Skill']) . "'
		WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND `No`='" . $_SESSION['No'] . "';");

		$message = 'Special Skill / Hobby has been added successfully!';
	}

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'special-skills';
}

if (isset($_POST['RemoveSpecialSkill'])) {
	mysqli_query($con, "DELETE FROM tbl_special_skills WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND `No`='" . $_SESSION['No'] . "' LIMIT 1;");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Special Skill / Hobby has been removed successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'special-skills';
}

/* RECOGNITION */
if (isset($_POST['SaveRecognition'])) {
	if (strlen($_SESSION['No']) === 0) {
		mysqli_query($con, "INSERT INTO tbl_recognition VALUES (NULL,
		'" . str_replace("'", "\'", $_POST['Recognition']) . "',
		'" . $_SESSION['EmpID'] . "');");

		$message = 'Non-Academic Distinction / Recognition has been added successfully!';
	} else {
		mysqli_query($con, "UPDATE tbl_recognition SET 
		Recognition='" . str_replace("'", "\'", $_POST['Recognition']) . "'
		WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND `No`='" . $_SESSION['No'] . "';");

		$message = 'Non-Academic Distinction / Recognition has been added successfully!';
	}

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'recognition';
}

if (isset($_POST['RemoveRecognition'])) {
	mysqli_query($con, "DELETE FROM tbl_recognition WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND `No`='" . $_SESSION['No'] . "' LIMIT 1;");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Non-Academic Distinction / Recognition has been removed successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'recognition';
}

/* Membership */
if (isset($_POST['SaveMembership'])) {
	if (strlen($_SESSION['No']) === 0) {
		mysqli_query($con, "INSERT INTO tbl_membership VALUES (NULL,
		'" . str_replace("'", "\'", $_POST['Organization']) . "',
		'" . $_SESSION['EmpID'] . "');");

		$message = 'Membership in Association / Organization has been added successfully!';
	} else {
		mysqli_query($con, "UPDATE tbl_membership SET 
		Organization='" . str_replace("'", "\'", $_POST['Organization']) . "'
		WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND `No`='" . $_SESSION['No'] . "';");

		$message = 'Membership in Association / Organization has been added successfully!';
	}

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'membership';
}

if (isset($_POST['RemoveMembership'])) {
	mysqli_query($con, "DELETE FROM tbl_membership WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND `No`='" . $_SESSION['No'] . "' LIMIT 1;");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Membership in Association / Organization has been removed successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'membership';
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
if (isset($_POST['SaveReference'])) {
	if (strlen($_SESSION['No']) === 0) {
		mysqli_query($con, "INSERT INTO reference VALUES (NULL,
		'" . str_replace("'", "\'", $_POST['RefName']) . "',
		'" . str_replace("'", "\'", $_POST['RefAddress']) . "',
		'" . str_replace("'", "\'", $_POST['RefContact']) . "',
		'" . $_SESSION['EmpID'] . "');");

		$message = 'Reference has been added successfully!';
	} else {
		mysqli_query($con, "UPDATE reference SET 
		`Name`='" . str_replace("'", "\'", $_POST['RefName']) . "',
		Address='" . str_replace("'", "\'", $_POST['RefAddress']) . "',
		Tel_No='" . str_replace("'", "\'", $_POST['RefContact']) . "' 
		WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND `No`='" . $_SESSION['No'] . "' LIMIT 1;");

		$message = 'Reference has been updated successfully!';
	}

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'reference';
}

if (isset($_POST['RemoveReference'])) {
	mysqli_query($con, "DELETE FROM reference WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND `No`='" . $_SESSION['No'] . "' LIMIT 1;");

	if (mysqli_affected_rows($con) === 1) {
		$success = true;
		$message = 'Reference has been removed successfully!';
		$showPrompt = true;
	}

	$_SESSION['pdstab'] = 'reference';
}

// PERSONAL DATA SHEET PROGRESS BAR
$total = 0;

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_employee WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
	$total += 15;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_family_background WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
	$total += 5;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM family_background WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
	$total += 5;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM educational_background WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
	$total += 10;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM civil_service WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
	$total += 10;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM work_experience WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
	$total += 10;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM voluntary_work WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
	$total += 5;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM learning_and_development WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
	$total += 10;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_special_skills WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
	$total += 5;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_recognition WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
	$total += 5;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_membership WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
	$total += 5;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbl_questioner WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
	$total += 10;
}

if (mysqli_num_rows(mysqli_query($con, "SELECT * FROM reference WHERE Emp_ID='" . $_SESSION['EmpID'] . "'")) > 0) {
	$total += 5;
}

include_once('pds.php');
?>