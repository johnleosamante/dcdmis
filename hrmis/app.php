<?php
// hrmis/app.php
restrictPublicAccess();

$activeApp = $_SESSION[alias() . '_activeApp'] = 'hrmis';
$page = $appTitle = "Human Resource Management Information System";

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
  $bmonth = sanitize($_POST['bmonth']);
  $bday = sanitize($_POST['bday']);
  $byear = sanitize($_POST['byear']);
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
    $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $name['id']) . '" title="View ' . $employee . ' employee information" target="_blank">' . strtoupper($employee) . '</a>] already exist!  Operation has been cancelled.';
    return;
  }

  createEmployee($employeeId, $lname, $fname, $mname, $ext, $sex, $bmonth, $bday, $byear, $email, $mobile, $image);
  createStation('-', $eStationId, $ePositionId, $employeeId);

  if (affectedRows() === 1) {
    $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . $employee . ' employee information" target="_blank">' . strtoupper($employee) . '</a>] was saved successfully!';
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

  updateEmployee(sanitize($_POST['lname']), sanitize($_POST['fname']), sanitize($_POST['mname']), sanitize($_POST['ext']), $bmonth, $bday, $byear, sanitize($_POST['pob']), sanitize($_POST['sex']), sanitize($_POST['civil-status']), sanitize($_POST['civil-status-specify']), sanitize($_POST['citizenship']), sanitize($_POST['dual-citizenship']), sanitize($_POST['dual-citizenship-country']), sanitize($_POST['rlot']), sanitize($_POST['rstreet']), sanitize($_POST['rsubdivision']), sanitize($_POST['rbarangay']), sanitize($_POST['rcity']), sanitize($_POST['rprovince']), sanitize($_POST['rzip']), sanitize($_POST['plot']), sanitize($_POST['pstreet']), sanitize($_POST['psubdivision']), sanitize($_POST['pbarangay']), sanitize($_POST['pcity']), sanitize($_POST['pprovince']), sanitize($_POST['pzip']), sanitize($_POST['height']), sanitize($_POST['weight']), sanitize($_POST['blood-type']), sanitize($_POST['gsis']), sanitize($_POST['pagibig']), sanitize($_POST['philhealth']), sanitize($_POST['sss']), sanitize($_POST['telephone']), sanitize($_POST['mobile']), $email, sanitize($_POST['tin']), sanitize($_POST['agency-id']), $employeePhoto, $employeeId);

  updateAccountEmail($email, $oldEmail);

  updateUserRoleEmail($email, $employeeId);

  if (affectedRows() === 1) {
    $showAlert = true;
    $message = 'Personal Information has been updated successfully!';
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

  if (affectedRows() === 1) {
    $showAlert = true;
    $message = 'Family Background has been updated successfully!';
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

  if (numRows(child($employeeId, $childId)) === 0) {
    createChild($clast, $cfirst, $cext, $cmiddle, $cdob, $employeeId);

    $message = 'Child has been added successfully!';
  } else {
    updateChild($clast, $cfirst, $cext, $cmiddle, $cdob, $employeeId, $childId);

    $message = 'Child has been updated successfully!';
  }

  if (affectedRows() === 1) {
    $success = true;
    $showAlert = true;
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'children';
}

if (isset($_POST['delete-child'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $childId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  deleteChild($employeeId, $childId);

  if (affectedRows() === 1) {
    $success = true;
    $message = 'Child has been deleted successfully!';
    $showAlert = true;
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

  if (empty($educationId)) {
    createEducation($level, $school, $course, $from, $to, $isPresent, $highest, $year, $scholarship, $employeeId);

    $message = 'Educational Background has been added successfully!';
  } else {
    updateEducation($level, $school, $course, $from, $to, $isPresent, $highest, $year, $scholarship, $employeeId, $educationId);

    $message = 'Educational Background has been updated successfully!';
  }

  if (affectedRows() === 1) {
    $success = true;
    $showAlert = true;
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'educational-background';
}

if (isset($_POST['delete-education'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $educationId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  deleteEducation($employeeId, $educationId);

  if (affectedRows() === 1) {
    $success = true;
    $message = 'Educational Background has been deleted successfully!';
    $showAlert = true;
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

  if (empty($eligibilityId)) {
    createEligibility($career, $rating, $examDate, $examPlace, $license, $isApplicable, $validity, $employeeId);

    $message = 'Civil Service Eligibility has been added successfully!';
  } else {
    updateEligibility($career, $rating, $examDate, $examPlace, $license, $isApplicable, $validity, $employeeId, $eligibilityId);

    $message = 'Civil Service Eligibility has been updated successfully!';
  }

  if (affectedRows() === 1) {
    $success = true;
    $showAlert = true;
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'civil-service-eligibility';
}

if (isset($_POST['delete-eligibility'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $eligibilityId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  deleteEligibility($employeeId, $eligibilityId);

  if (affectedRows() === 1) {
    $success = true;
    $message = 'Civil Service Eligibility has been deleted successfully!';
    $showAlert = true;
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

  if (empty($experienceId)) {
    createExperience($from, $to, $isPresent, $position, $organization, $salary, $sg, $status, $isGovernment, $employeeId);

    $message = 'Work Experience has been added successfully!';
  } else {
    updateExperience($from, $to, $isPresent, $position, $organization, $salary, $sg, $status, $isGovernment, $employeeId, $experienceId);

    $message = 'Work Experience has been updated successfully!';
  }

  if (affectedRows() === 1) {
    $success = true;
    $showAlert = true;
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'work-experience';
}

if (isset($_POST['delete-work-experience'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $experienceId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  deleteExperience($employeeId, $experienceId);

  if (affectedRows() === 1) {
    $success = true;
    $message = 'Work Experience has been deleted successfully!';
    $showAlert = true;
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

  if (empty($voluntaryId)) {
    createVoluntaryWork($organization, $from, $to, $isPresent, $hours, $position, $employeeId);

    $message = 'Voluntary Work has been added successfully!';
  } else {
    updateVoluntaryWork($organization, $from, $to, $isPresent, $hours, $position, $employeeId, $voluntaryId);

    $message = 'Voluntary Work has been updated successfully!';
  }

  if (affectedRows() === 1) {
    $success = true;
    $showAlert = true;
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'voluntary-work';
}

if (isset($_POST['delete-voluntary-work'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $voluntaryId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  deleteVoluntaryWork($employeeId, $voluntaryId);

  if (affectedRows() === 1) {
    $success = true;
    $message = 'Voluntary Work has been deleted successfully';
    $showAlert = true;
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

  if (empty($learningId)) {
    createlearningAndDevelopment($title, $from, $to, $hours, $type, $sponsor, $employeeId);

    $message = 'Learning &amp; Development Intervention has been added successfully!';
  } else {
    updateLearningAndDevelopment($title, $from, $to, $hours, $type, $sponsor, $employeeId, $learningId);

    $message = 'Learning &amp; Development Intervention has been updated successfully!';
  }

  if (affectedRows() === 1) {
    $success = true;
    $showAlert = true;
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'learning-development';
}

if (isset($_POST['delete-learning-development'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $learningId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  deleteLearningAndDevelopment($employeeId, $learningId);

  if (affectedRows() === 1) {
    $success = true;
    $message = 'Learning &amp; Development Intervention has been deleted successfully!';
    $showAlert = true;
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'learning-development';
}

/* SPECIAL SKILLS AND HOBBIES */
if (isset($_POST['save-special-skill'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $skillId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
  $skill = sanitize($_POST['skill']);

  if (empty($skillId)) {
    createSpecialSkill($skill, $employeeId);

    $message = 'Special Skill / Hobby has been added successfully!';
  } else {
    updateSpecialSkill($skill, $employeeId, $skillId);

    $message = 'Special Skill / Hobby has been updated successfully!';
  }

  if (affectedRows() === 1) {
    $success = true;
    $showAlert = true;
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'special-skills';
}

if (isset($_POST['delete-special-skill'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $skillId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  deleteSpecialSkill($employeeId, $skillId);

  if (affectedRows() === 1) {
    $success = true;
    $message = 'Special Skill / Hobby has been deleted successfully!';
    $showAlert = true;
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'special-skills';
}

/* RECOGNITION */
if (isset($_POST['save-recognition'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $recognitionId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
  $recognition = sanitize($_POST['recognition']);

  if (empty($recognitionId)) {
    createRecognition($recognition, $employeeId);

    $message = 'Non-Academic Distinction / Recognition has been added successfully!';
  } else {
    updateRecognition($recognition, $employeeId, $recognitionId);

    $message = 'Non-Academic Distinction / Recognition has been updated successfully!';
  }

  if (affectedRows() === 1) {
    $success = true;
    $showAlert = true;
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'recognition';
}

if (isset($_POST['delete-recognition'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $recognitionId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  deleteRecognition($employeeId, $recognitionId);

  if (affectedRows() === 1) {
    $success = true;
    $message = 'Non-Academic Distinction / Recognition has been deleted successfully!';
    $showAlert = true;
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'recognition';
}

/* MEMBERSHIP */
if (isset($_POST['save-membership'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $membershipId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
  $membership = sanitize($_POST['membership']);

  if (empty($membershipId)) {
    createMembership($membership, $employeeId);

    $message = 'Membership in Association / Organization has been added successfully!';
  } else {
    updateMembership($membership, $employeeId, $membershipId);

    $message = 'Membership in Association / Organization has been updated successfully!';
  }

  if (affectedRows() === 1) {
    $success = true;
    $showAlert = true;
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'membership';
}

if (isset($_POST['delete-membership'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $membershipId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  deleteMembership($employeeId, $membershipId);

  if (affectedRows() === 1) {
    $success = true;
    $message = 'Membership in Association / Organization has been deleted successfully!';
    $showAlert = true;
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'membership';
}

/* OTHER INFORMATION */
if (isset($_POST['update-other-information'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $hasThirdDegree = sanitize($_POST['has-third-degree']);
  $hasFourthDegree = sanitize($_POST['has-fourth-degree']);
  $relatedDetails = sanitize($_POST['related-details']);
  $wasGuilty = sanitize($_POST['was-guilty']);
  $guiltyDetails = sanitize($_POST['guilty-details']);
  $wasCharged = sanitize($_POST['was-charged']);
  $dateFiled = sanitize($_POST['date-filed']);
  $caseStatus = sanitize($_POST['case-status']);
  $wasConvicted = sanitize($_POST['was-convicted']);
  $convictedDetails = sanitize($_POST['convicted-details']);
  $wasSeparated = sanitize($_POST['was-separated']);
  $separatedDetails = sanitize($_POST['separated-details']);
  $wasCandidate = sanitize($_POST['was-candidate']);
  $candidateDetails = sanitize($_POST['candidate-details']);
  $resigned = sanitize($_POST['resigned']);
  $resignedDetails = sanitize($_POST['resigned-details']);
  $immigrant = sanitize($_POST['immigrant']);
  $immigrantCountry = sanitize($_POST['immigrant-country']);
  $isIndigenous = sanitize($_POST['is-indigenous']);
  $indigenousSpecify = sanitize($_POST['indigenous-specify']);
  $isDifferentlyAbled = sanitize($_POST['is-differently-abled']);
  $differentlyAbledSpecify = sanitize($_POST['differently-abled-specify']);
  $isSoloParent = sanitize($_POST['is-solo-parent']);
  $soloParentSpecify = sanitize($_POST['solo-parent-specify']);

  if (numRows(otherInformation($employeeId)) === 0) {
    createOtherInformation($hasThirdDegree, $hasFourthDegree, $relatedDetails, $wasGuilty, $guiltyDetails, $wasCharged, $dateFiled, $caseStatus, $wasConvicted, $convictedDetails, $wasSeparated, $separatedDetails, $wasCandidate, $candidateDetails, $resigned, $resignedDetails, $immigrant, $immigrantCountry, $isIndigenous, $indigenousSpecify, $isDifferentlyAbled, $differentlyAbledSpecify, $isSoloParent, $soloParentSpecify, $employeeId);
  } else {
    updateOtherInformation($hasThirdDegree, $hasFourthDegree, $relatedDetails, $wasGuilty, $guiltyDetails, $wasCharged, $dateFiled, $caseStatus, $wasConvicted, $convictedDetails, $wasSeparated, $separatedDetails, $wasCandidate, $candidateDetails, $resigned, $resignedDetails, $immigrant, $immigrantCountry, $isIndigenous, $indigenousSpecify, $isDifferentlyAbled, $differentlyAbledSpecify, $isSoloParent, $soloParentSpecify, $employeeId);
  }

  if (mysqli_affected_rows($con) === 1) {
    $success = true;
    $message = 'Other Information has been updated successfully!';
    $showAlert = true;
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

  if (empty($referenceId)) {
    createReference($name, $address, $contact, $employeeId);

    $message = 'Reference has been added successfully!';
  } else {
    updateReference($name, $address, $contact, $employeeId, $referenceId);

    $message = 'Reference has been updated successfully!';
  }

  if (affectedRows() === 1) {
    $success = true;
    $showAlert = true;
  }

  $activeTab = $_SESSION[alias() . '_activeTab'] = 'reference';
}

if (isset($_POST['delete-reference'])) {
  $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $referenceId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;

  deleteReference($employeeId, $referenceId);

  if (affectedRows() === 1) {
    $success = true;
    $message = 'Reference has been deleted successfully!';
    $showAlert = true;
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

  if (numRows(station($employeeId)) === 0) {
    createStation($date, $eStationId, $positionId, $employeeId);
  } else {
    updateStation($date, $eStationId, $positionId, $employeeId);
  }

  if (affectedRows() === 1) {
    $success = true;
    $message = 'Employee has been reassigned successfully!';
    $showAlert = true;
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
    $success = true;
    $message = 'Employee has been removed successfully!';
    $showAlert = true;
  }
}
?>