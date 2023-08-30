<?php
// hrmis/app.php
if (isPublicDomain()) {
  redirect(uri() . '/oops?e=403');
}

restrictPublicAccess(hasHoliday());

$activeApp = $_SESSION[alias() . '_activeApp'] = 'hrmis';
$page = $appTitle = 'Human Resource Management Information System';

if (!isset($userId)) {
  redirect(uri() . '/login');
}

if (numRows(userRole($userId, $activeApp)) === 0) {
  redirect(uri() . '/pis');  
}

if (isset($_POST['primary-search-button'])) {
  redirect(customUri('hrmis', 'Employee Search', sanitize($_POST['primary-search-text'])));
}

/* ADD EMPLOYEE */
if (isset($_POST['add-employee'])) {
  $employeeId = getDatetimeAsId();
  $lname = sanitize($_POST['lname']);
  $fname = sanitize($_POST['fname']);
  $mname = sanitize($_POST['mname']);
  $ext = sanitize($_POST['ext']);
  $sex = sanitize($_POST['sex']);
  $bdate = strtotime(sanitize($_POST['bdate']));
  $bmonth = date('m', $bdate);
  $bday = date('d', $bdate);
  $byear = date('Y', $bdate);
  $ePositionId = sanitize($_POST['position']);
  $eStationId = sanitize($_POST['station']);
  $email = sanitize($_POST['email']);
  $mobile = sanitize($_POST['mobile']);
  $image = 'assets/img/user.png';
  $showAlert = true;
  $employee = toName($lname, $fname, $mname, $ext, true);

  if (!isValidEmail($email, 'deped.gov.ph')) {
    $success = false;
    $message = 'The DepEd Email Address you entered is invalid! Operation has been cancelled.';
    return;
  }

  $names = employeeName($lname, $fname, $mname, $ext);

  if (numRows($names) > 0) {
    $name = fetchAssoc($names);
    $success = false;
    $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $name['id']) . '" title="View ' . $employee . ' employee information">' . strtoupper($employee) . '</a>] already exist!  Operation has been cancelled.';
    return;
  }

  createEmployee($employeeId, $lname, $fname, $mname, $ext, $sex, $bmonth, $bday, $byear, $email, $mobile, $image);
  createFamily('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', $employeeId);
  createOtherInformation(0, 0, '', 0, '', 0, '0000-00-00', '', 0, '', 0, '', 0, '', 0, '', 0, '', 0, '', 0, '', 0, '', $employeeId);
  createStation('-', $eStationId, $ePositionId, $employeeId);
  createPsipop('', '1', 'Permanent', '0000-00-00', '', $employeeId);
  createStepIncrement('0000-00-00', '1', '0', $employeeId);
  createDeployment('0000-00-00', $eStationId, $ePositionId, '0', '1', '', $employeeId);
  createAccount($email, hashPassword(generateStrongRandomPassword()));

  if (affectedRows()) {
    $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . $employee . ' employee information">' . strtoupper($employee) . '</a>] was saved successfully.';
    createSystemLog($stationId, $userId, 'Registered employee', $employeeId, clientIp());
  }
}

/* PERSONAL INFORMATION */
if (isset($_POST['update-personal-information'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $oldEmail = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
  $employeePhoto = isset($_POST['image-verifier']) ? sanitize(decipher($_POST['image-verifier'])) : $defaultImage;

  if ($_FILES['image-upload']['size'] > 0 && $_FILES['image-upload']['error'] == 0) {
    $fileUpload = $_FILES['image-upload']['name'];
    $temp = $_FILES['image-upload']['tmp_name'];
    $type = $_FILES['image-upload']['type'];
    $ext = pathinfo($fileUpload, PATHINFO_EXTENSION);
    $employeePhoto = 'uploads/images/' . $employeeId . '/' . $employeeId . '.' . $ext;

    move_uploaded_file($temp, '../' . $employeePhoto);
  }

  $dob = isset($_POST['dob']) ? strtotime($_POST['dob']) : strtotime(date('Y-m-d'));
  $byear = date("Y", $dob);
  $bmonth = date("m", $dob);
  $bday = date("d", $dob);
  $email = sanitize($_POST['email']);

  updateAccountEmail($email, $oldEmail);

  updateUserRoleEmail($email, $employeeId);

  updateEmployee(sanitize($_POST['lname']), sanitize($_POST['fname']), sanitize($_POST['mname']), sanitize($_POST['ext']), $bmonth, $bday, $byear, sanitize($_POST['pob']), sanitize($_POST['sex']), sanitize($_POST['civil-status']), sanitize($_POST['civil-status-specify']), sanitize($_POST['citizenship']), sanitize($_POST['dual-citizenship']), sanitize($_POST['dual-citizenship-country']), sanitize($_POST['rlot']), sanitize($_POST['rstreet']), sanitize($_POST['rsubdivision']), sanitize($_POST['rbarangay']), sanitize($_POST['rcity']), sanitize($_POST['rprovince']), sanitize($_POST['rzip']), sanitize($_POST['plot']), sanitize($_POST['pstreet']), sanitize($_POST['psubdivision']), sanitize($_POST['pbarangay']), sanitize($_POST['pcity']), sanitize($_POST['pprovince']), sanitize($_POST['pzip']), sanitize($_POST['height']), sanitize($_POST['weight']), sanitize($_POST['blood-type']), sanitize($_POST['crn']), sanitize($_POST['bp']), sanitize($_POST['pagibig']), sanitize($_POST['philhealth']), sanitize($_POST['sss']), sanitize($_POST['telephone']), sanitize($_POST['mobile']), $email, sanitize($_POST['tin']), sanitize($_POST['agency-id']), $employeePhoto, $employeeId);

  if (affectedRows()) {
    $showAlert = true;
    $message = 'Personal Information has been updated successfully.';
    createSystemLog($stationId, $userId, 'Updated employee personal information', $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'personal-information';
}

/* FAMILY BACKGROUND */
if (isset($_POST['update-family-background'])) {
  $employeeId = sanitize(decipher($_POST['verifier']));
  $slast = sanitize($_POST['slast']);
  $sfirst = sanitize($_POST['sfirst']);
  $sext = sanitize($_POST['sext']);
  $smiddle = sanitize($_POST['smiddle']);
  $swork = sanitize($_POST['swork']);
  $sbusiness = sanitize($_POST['sbusiness']);
  $sbusinessAddress = sanitize($_POST['sbusiness-address']);
  $stelephone = sanitize($_POST['stelephone']);
  $flast = sanitize($_POST['flast']);
  $ffirst = sanitize($_POST['ffirst']);
  $fext = sanitize($_POST['fext']);
  $fmiddle = sanitize($_POST['fmiddle']);
  $mlast = sanitize($_POST['mlast']);
  $mfirst = sanitize($_POST['mfirst']);
  $mmiddle = sanitize($_POST['mmiddle']);

  if (numRows(family($employeeId)) === 0) {
    createFamily($slast, $sfirst, $sext, $smiddle, $swork, $sbusiness, $sbusinessAddress, $stelephone, $flast, $ffirst, $fext, $fmiddle, $mlast, $mfirst, $mmiddle, $employeeId);
  } else {
    updateFamily($slast, $sfirst, $sext, $smiddle, $swork, $sbusiness, $sbusinessAddress, $stelephone, $flast, $ffirst, $fext, $fmiddle, $mlast, $mfirst, $mmiddle, $employeeId);
  }

  if (affectedRows()) {
    $showAlert = true;
    $message = 'Family Background has been updated successfully.';
    createSystemLog($stationId, $userId, 'Updated employee family background', $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'family-background';
}

/* CHILDREN */
if (isset($_POST['save-child'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $childId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
  $clast = sanitize($_POST['clast']);
  $cfirst = sanitize($_POST['cfirst']);
  $cext = sanitize($_POST['cext']);
  $cmiddle = sanitize($_POST['cmiddle']);
  $cdob = sanitize($_POST['cdob']);
  $logMessage = '';

  if (numRows(child($employeeId, $childId)) === 0) {
    createChild($clast, $cfirst, $cext, $cmiddle, $cdob, $employeeId);
    $logMessage = 'Added employee child';
    $message = 'Child has been added successfully.';
  } else {
    updateChild($clast, $cfirst, $cext, $cmiddle, $cdob, $employeeId, $childId);
    $logMessage = 'Updated employee child';
    $message = 'Child has been updated successfully.';
  }

  if (affectedRows()) {
    $success = true;
    $showAlert = true;
    createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'children';
}

if (isset($_POST['delete-child'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $childId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  deleteChild($employeeId, $childId);

  if (affectedRows()) {
    $success = true;
    $message = 'Child has been deleted successfully.';
    $showAlert = true;
    createSystemLog($stationId, $userId, 'Deleted employee child', $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'children';
}

/* EDUCATIONAL BACKGROUND */
if (isset($_POST['save-education'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $educationId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
  $level = sanitize($_POST['level']);
  $school = sanitize($_POST['school']);
  $course = sanitize($_POST['course']);
  $from = sanitize($_POST['from']);
  $to = sanitize($_POST['to']);
  $isPresent = isset($_POST['is-present']);
  $highest = sanitize($_POST['highest']);
  $year = $isPresent ? null : sanitize($_POST['year']);
  $scholarship = sanitize($_POST['scholarship']);
  $logMessage = '';

  if (empty($educationId)) {
    // createEducation($level, $school, $course, $from, $to, $isPresent, $highest, $year, $scholarship, $employeeId);
    $logMessage = 'Added employee education';
    $message = 'Educational Background has been added successfully.';
  } else {
    // updateEducation($level, $school, $course, $from, $to, $isPresent, $highest, $year, $scholarship, $employeeId, $educationId);
    $logMessage = 'Updated employee education';
    $message = 'Educational Background has been updated successfully.';
  }

  if (affectedRows()) {
    $success = true;
    $showAlert = true;
    // createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'educational-background';
}

if (isset($_POST['delete-education'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $educationId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  deleteEducation($employeeId, $educationId);

  if (affectedRows()) {
    $success = true;
    $message = 'Educational Background has been deleted successfully.';
    $showAlert = true;
    createSystemLog($stationId, $userId, 'Deleted employee education', $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'educational-background';
}

/* CIVIL SERVICE ELIGIBILITY */
if (isset($_POST['save-eligibility'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $eligibilityId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
  $career = sanitize($_POST['career']);
  $rating = sanitize($_POST['rating']);
  $examDate = sanitize($_POST['exam-date']);
  $examPlace = sanitize($_POST['exam-place']);
  $license = sanitize($_POST['license']);
  $isApplicable = isset($_POST['is-applicable']);
  $validity = sanitize($_POST['validity']);
  $logMessage = '';

  if (empty($eligibilityId)) {
    createEligibility($career, $rating, $examDate, $examPlace, $license, $isApplicable, $validity, $employeeId);
    $logMessage = 'Added employee eligibility';
    $message = 'Civil Service Eligibility has been added successfully.';
  } else {
    updateEligibility($career, $rating, $examDate, $examPlace, $license, $isApplicable, $validity, $employeeId, $eligibilityId);
    $logMessage = 'Updated employee eligibility';
    $message = 'Civil Service Eligibility has been updated successfully.';
  }

  if (affectedRows()) {
    $success = true;
    $showAlert = true;
    createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'civil-service-eligibility';
}

if (isset($_POST['delete-eligibility'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $eligibilityId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  deleteEligibility($employeeId, $eligibilityId);

  if (affectedRows()) {
    $success = true;
    $message = 'Civil Service Eligibility has been deleted successfully.';
    $showAlert = true;
    createSystemLog($stationId, $userId, 'Deleted employee eligibility', $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'civil-service-eligibility';
}

/* WORK EXPERIENCE */
if (isset($_POST['save-experience'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $experienceId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
  $from = sanitize($_POST['from']);
  $isPresent = isset($_POST['is-present']);
  $to = $isPresent ? date('m/d/Y') : sanitize($_POST['to']);
  $position = sanitize($_POST['position']);
  $organization = sanitize($_POST['organization']);
  $salary = isset($_POST['salary']) ? $_POST['salary'] : 0;
  $sg = sanitize($_POST['sg']);
  $status = sanitize($_POST['status']);
  $isGovernment = sanitize($_POST['is-government']);
  $logMessage = '';

  if (empty($experienceId)) {
    // createExperience($from, $to, $isPresent, $position, $organization, $salary, $sg, $status, $isGovernment, $employeeId);
    $logMessage = 'Added employee experience';
    $message = 'Work Experience has been added successfully.';
  } else {
    // updateExperience($from, $to, $isPresent, $position, $organization, $salary, $sg, $status, $isGovernment, $employeeId, $experienceId);
    $logMessage = 'Updated employee experience';
    $message = 'Work Experience has been updated successfully.';
  }

  if (affectedRows()) {
    $success = true;
    $showAlert = true;
    // createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'work-experience';
}

if (isset($_POST['delete-work-experience'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $experienceId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  deleteExperience($employeeId, $experienceId);

  if (affectedRows()) {
    $success = true;
    $message = 'Work Experience has been deleted successfully.';
    $showAlert = true;
    createSystemLog($stationId, $userId, 'Deleted employee experience', $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'work-experience';
}

/* VOLUNTARY WORK */
if (isset($_POST['save-voluntary-work'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $voluntaryId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
  $organization = sanitize($_POST['organization']);
  $from = sanitize($_POST['from']);
  $isPresent = isset($_POST['is-present']);
  $to = $isPresent ? date('m/d/Y') : sanitize($_POST['to']);
  $hours = isset($_POST['hours']) ? $_POST['hours'] : 0;
  $position = sanitize($_POST['position']);
  $logMessage = '';

  if (empty($voluntaryId)) {
    // createVoluntaryWork($organization, $from, $to, $isPresent, $hours, $position, $employeeId);
    $logMessage = 'Added employee voluntary work';
    $message = 'Voluntary Work has been added successfully.';
  } else {
    // updateVoluntaryWork($organization, $from, $to, $isPresent, $hours, $position, $employeeId, $voluntaryId);
    $logMessage = 'Updated employee voluntary work';
    $message = 'Voluntary Work has been updated successfully.';
  }

  if (affectedRows()) {
    $success = true;
    $showAlert = true;
    // createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'voluntary-work';
}

if (isset($_POST['delete-voluntary-work'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $voluntaryId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  deleteVoluntaryWork($employeeId, $voluntaryId);

  if (affectedRows()) {
    $success = true;
    $message = 'Voluntary Work has been deleted successfully.';
    $showAlert = true;
    createSystemLog($stationId, $userId, 'Deleted employee voluntary work', $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'voluntary-work';
}

/* LEARNING AND DEVELOPMENT INTERVENTION */
if (isset($_POST['save-learning-development'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $learningId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
  $title = sanitize($_POST['title']);
  $from = sanitize($_POST['from']);
  $to = sanitize($_POST['to']);
  $hours = isset($_POST['hours']) ? sanitize($_POST['hours']) : 0;
  $type = sanitize($_POST['type']);
  $sponsor = sanitize($_POST['sponsor']);
  $logMessage = '';

  if (empty($learningId)) {
    createlearningAndDevelopment($title, $from, $to, $hours, $type, $sponsor, $employeeId);
    $logMessage = 'Added employee learning development';
    $message = 'Learning &amp; Development Intervention has been added successfully.';
  } else {
    updateLearningAndDevelopment($title, $from, $to, $hours, $type, $sponsor, $employeeId, $learningId);
    $logMessage = 'Updated employee learning development';
    $message = 'Learning &amp; Development Intervention has been updated successfully.';
  }

  if (affectedRows()) {
    $success = true;
    $showAlert = true;
    createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'learning-development';
}

if (isset($_POST['delete-learning-development'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $learningId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  deleteLearningAndDevelopment($employeeId, $learningId);

  if (affectedRows()) {
    $success = true;
    $message = 'Learning &amp; Development Intervention has been deleted successfully.';
    $showAlert = true;
    createSystemLog($stationId, $userId, 'Deleted employee learning development', $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'learning-development';
}

/* SPECIAL SKILLS AND HOBBIES */
if (isset($_POST['save-special-skill'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $skillId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
  $skill = sanitize($_POST['skill']);
  $logMessage = '';

  if (empty($skillId)) {
    createSpecialSkill($skill, $employeeId);
    $logMessage = 'Added employee special skill';
    $message = 'Special Skill / Hobby has been added successfully.';
  } else {
    updateSpecialSkill($skill, $employeeId, $skillId);
    $logMessage = 'Updated employee special skill';
    $message = 'Special Skill / Hobby has been updated successfully.';
  }

  if (affectedRows()) {
    $success = true;
    $showAlert = true;
    createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'special-skills';
}

if (isset($_POST['delete-special-skill'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $skillId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  deleteSpecialSkill($employeeId, $skillId);

  if (affectedRows()) {
    $success = true;
    $message = 'Special Skill / Hobby has been deleted successfully.';
    $showAlert = true;
    createSystemLog($stationId, $userId, 'Deleted employee special skill', $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'special-skills';
}

/* RECOGNITION */
if (isset($_POST['save-recognition'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $recognitionId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
  $recognition = sanitize($_POST['recognition']);
  $logMessage = '';

  if (empty($recognitionId)) {
    createRecognition($recognition, $employeeId);
    $logMessage = 'Added employee recognition';
    $message = 'Non-Academic Distinction / Recognition has been added successfully.';
  } else {
    updateRecognition($recognition, $employeeId, $recognitionId);
    $logMessage = 'Updated employee recognition';
    $message = 'Non-Academic Distinction / Recognition has been updated successfully.';
  }

  if (affectedRows()) {
    $success = true;
    $showAlert = true;
    createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'recognition';
}

if (isset($_POST['delete-recognition'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $recognitionId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  deleteRecognition($employeeId, $recognitionId);

  if (affectedRows()) {
    $success = true;
    $message = 'Non-Academic Distinction / Recognition has been deleted successfully.';
    $showAlert = true;
    createSystemLog($stationId, $userId, 'Deleted employee recognition', $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'recognition';
}

/* MEMBERSHIP */
if (isset($_POST['save-membership'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $membershipId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
  $membership = sanitize($_POST['membership']);
  $logMessage = '';

  if (empty($membershipId)) {
    createMembership($membership, $employeeId);
    $logMessage = 'Added employee membership';
    $message = 'Membership in Association / Organization has been added successfully.';
  } else {
    updateMembership($membership, $employeeId, $membershipId);
    $logMessage = 'Updated employee membership';
    $message = 'Membership in Association / Organization has been updated successfully.';
  }

  if (affectedRows()) {
    $success = true;
    $showAlert = true;
    createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'membership';
}

if (isset($_POST['delete-membership'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $membershipId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  deleteMembership($employeeId, $membershipId);

  if (affectedRows()) {
    $success = true;
    $message = 'Membership in Association / Organization has been deleted successfully.';
    $showAlert = true;
    createSystemLog($stationId, $userId, 'Deleted employee membership', $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'membership';
}

/* OTHER INFORMATION */
if (isset($_POST['update-other-information'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $hasThirdDegree = sanitize($_POST['has-third-degree']);
  $hasFourthDegree = sanitize($_POST['has-fourth-degree']);
  $relatedDetails = $hasFourthDegree ? sanitize($_POST['related-details']) : 'N/A';
  $wasGuilty = sanitize($_POST['was-guilty']);
  $guiltyDetails = $wasGuilty ? sanitize($_POST['guilty-details']) : 'N/A';
  $wasCharged = sanitize($_POST['was-charged']);
  $dateFiled = sanitize($_POST['date-filed']);
  $caseStatus = $wasCharged ? sanitize($_POST['case-status']) : 'N/A';
  $wasConvicted = sanitize($_POST['was-convicted']);
  $convictedDetails = $wasConvicted ? sanitize($_POST['convicted-details']) : 'N/A';
  $wasSeparated = sanitize($_POST['was-separated']);
  $separatedDetails = $wasSeparated ? sanitize($_POST['separated-details']) : 'N/A';
  $wasCandidate = sanitize($_POST['was-candidate']);
  $candidateDetails = $wasCandidate ? sanitize($_POST['candidate-details']) : 'N/A';
  $resigned = sanitize($_POST['resigned']);
  $resignedDetails = $resigned ? sanitize($_POST['resigned-details']) : 'N/A';
  $immigrant = sanitize($_POST['immigrant']);
  $immigrantCountry = $immigrant ? sanitize($_POST['immigrant-country']) : 'N/A';
  $isIndigenous = sanitize($_POST['is-indigenous']);
  $indigenousSpecify = $isIndigenous ? sanitize($_POST['indigenous-specify']) : 'N/A';
  $isDifferentlyAbled = sanitize($_POST['is-differently-abled']);
  $differentlyAbledSpecify = $isDifferentlyAbled ? sanitize($_POST['differently-abled-specify']) : 'N/A';
  $isSoloParent = sanitize($_POST['is-solo-parent']);
  $soloParentSpecify = $isSoloParent ? sanitize($_POST['solo-parent-specify']) : 'N/A';

  if (numRows(otherInformation($employeeId)) === 0) {
    createOtherInformation($hasThirdDegree, $hasFourthDegree, $relatedDetails, $wasGuilty, $guiltyDetails, $wasCharged, $dateFiled, $caseStatus, $wasConvicted, $convictedDetails, $wasSeparated, $separatedDetails, $wasCandidate, $candidateDetails, $resigned, $resignedDetails, $immigrant, $immigrantCountry, $isIndigenous, $indigenousSpecify, $isDifferentlyAbled, $differentlyAbledSpecify, $isSoloParent, $soloParentSpecify, $employeeId);
  } else {
    updateOtherInformation($hasThirdDegree, $hasFourthDegree, $relatedDetails, $wasGuilty, $guiltyDetails, $wasCharged, $dateFiled, $caseStatus, $wasConvicted, $convictedDetails, $wasSeparated, $separatedDetails, $wasCandidate, $candidateDetails, $resigned, $resignedDetails, $immigrant, $immigrantCountry, $isIndigenous, $indigenousSpecify, $isDifferentlyAbled, $differentlyAbledSpecify, $isSoloParent, $soloParentSpecify, $employeeId);
  }

  if (affectedRows()) {
    $success = true;
    $message = 'Other Information has been updated successfully.';
    $showAlert = true;
    createSystemLog($stationId, $userId, 'Updated employee other information', $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'other-information';
}

/* REFERENCE */
if (isset($_POST['save-reference'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $referenceId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
  $name = sanitize($_POST['name']);
  $address = sanitize($_POST['address']);
  $contact = sanitize($_POST['telephone']);
  $logMessage = '';

  if (empty($referenceId)) {
    createReference($name, $address, $contact, $employeeId);
    $logMessage = 'Added employee reference';
    $message = 'Reference has been added successfully.';
  } else {
    updateReference($name, $address, $contact, $employeeId, $referenceId);
    $logMessage = 'Updated employee reference';
    $message = 'Reference has been updated successfully.';
  }

  if (affectedRows()) {
    $success = true;
    $showAlert = true;
    createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'reference';
}

if (isset($_POST['delete-reference'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $referenceId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  deleteReference($employeeId, $referenceId);

  if (affectedRows()) {
    $success = true;
    $message = 'Reference has been deleted successfully.';
    $showAlert = true;
    createSystemLog($stationId, $userId, 'Deleted employee reference', $employeeId, clientIp());
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'reference';
}

/* REASSIGN EMPLOYEE */
if (isset($_POST['reassign-employee'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $positionId = sanitize($_POST['position']);
  $eStationId = sanitize($_POST['assignment']);
  $date = sanitize($_POST['assignment-date']);

  if (empty($employeeId) || empty($positionId) || empty($eStationId) || empty($date)) {
    return;
  }

  if (numRows(user($employeeId)) > 0) {
    $link = $eStationId !== '143' ? 'sch_portal' : '';
    updateUserRole($employeeId, $eStationId, $link);
  }

  if (numRows(station($employeeId)) === 0) {
    createStation($date, $eStationId, $positionId, $employeeId);
  } else {
    updateStation($date, $eStationId, $positionId, $employeeId);
  }

  if (affectedRows()) {
    $success = true;
    $message = 'Employee has been reassigned successfully.';
    $showAlert = true;
    createSystemLog($stationId, $userId, 'Reassigned employee', $employeeId, clientIp());
  }
}

/* REMOVE EMPLOYEE */
if (isset($_POST['remove-employee'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $reason = sanitize($_POST['reason']);

  if (empty($employeeId) || empty($reason)) {
    return;
  }

  if (numRows(employee($employeeId)) > 0) {
    updateEmployeeStatus($reason, $employeeId);
  }

  if (affectedRows()) {
    $success = true;
    $message = 'Employee has been removed successfully.';
    $showAlert = true;
    createSystemLog($stationId, $userId, 'Removed employee', $employeeId, clientIp());
  }
}

if (isset($_POST['set-school-head'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $schoolId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  if (numRows(employee($employeeId)) > 0) {
    updateSchoolHead($schoolId, $employeeId);
  }

  if (affectedRows()) {
    $success = true;
    $message = 'Employee has been set as school head successfully.';
    $showAlert = true;
    createSystemLog($stationId, $userId, 'Set School Head', $employeeId, clientIp());
  }
}
?>