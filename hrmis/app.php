<?php
// hrmis/app.php
$activeApp = $_SESSION["{$prefix}activeApp"] = 'hrmis';
$page = $appTitle = 'Human Resource Management Information System';

if (!isset($userId)) {
    redirect("{$baseUri}/login");
}

if (!userRole($userId, $activeApp)) {
    redirect("{$baseUri}/" . HOME);
}

if (isset($_POST['primary-search-button'])) {
    redirect(customUri('hrmis', 'Employee Search', sanitize($_POST['primary-search-text'])));
}

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
    $status = sanitize($_POST['status']);
    $crn = sanitize($_POST['gsis_id']);
    $bp = sanitize($_POST['gsis_bp']);
    $pagibig = sanitize($_POST['pagibig']);
    $philhealth = sanitize($_POST['philhealth']);
    $tin = sanitize($_POST['tin']);
    $agencyId = sanitize($_POST['agency_id']);
    $showAlert = true;
    $employee = toName($lname, $fname, $mname, $ext, true);
    $today = date('Y-m-d');

    if (!isValidEmail($email, 'deped.gov.ph')) {
        $message = 'The DepEd Email Address you entered is invalid!';
        return;
    }

    $name = employeeName($lname, $fname, $mname, $ext);

    if ($name) {
        $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $name['id']) . '" title="View ' . $employee . ' employee information">' . strtoupper($employee) . '</a>] already exist!';
        return;
    }

    beginTransaction();

    try {
        if (createEmployee($employeeId, $lname, $fname, $mname, $ext, $sex, $bmonth, $bday, $byear, $email, $mobile, $image, $status, $crn, $bp, $pagibig, $philhealth, $tin, $agencyId) === false) {
            throw new Exception('Failed to save employee information.');
        }

        if (createFamily('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', $employeeId) === false) {
            throw new Exception('Failed to create family background.');
        }

        if (createOtherInformation(0, 0, '', 0, '', 0, '0000-00-00', '', 0, '', 0, '', 0, '', 0, '', 0, '', 0, '', 0, '', 0, '', $employeeId) === false) {
            throw new Exception('Failed to create other information.');
        }

        if (createStation($today, $eStationId, $ePositionId, $employeeId) === false) {
            throw new Exception('Failed to assign employee station.');
        }

        if (createPsipop('', 'Permanent', $today, $today, '', $employeeId) === false) {
            throw new Exception('Failed to create PSIPOP entry.');
        }

        $sg = positions($ePositionId)['salary_grade'];
        if (createStepIncrement($today, '1', $sg, $employeeId) === false) {
            throw new Exception('Failed to create step increment record.');
        }

        if (createIdentification(null, '', '', $today, $employeeId) === false) {
            throw new Exception('Failed to create identification.');
        }

        if (createAccount($employeeId, hashPassword(generateStrongRandomPassword())) === false) {
            throw new Exception('Failed to create user account.');
        }

        commit();

        $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . $employee . ' employee information">' . strtoupper($employee) . '</a>] was saved successfully.';
        $success = true;

        createSystemLog($stationId, $userId, 'Registered employee', $employeeId, clientIp());
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['update-personal-information'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $employeePhoto = isset($_POST['image-verifier']) ? sanitize(decipher($_POST['image-verifier'])) : $defaultImage;
    $ext = null;
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'personal-information';

    if (is_uploaded_file($_FILES['image-upload']['tmp_name'])) {
        $temp = $_FILES['image-upload']['tmp_name'];

        if ($_FILES['image-upload']['size'] > $imageUploadSizeLimit) {
            $message = 'The chosen file exceeds the upload file limit (2.5 MB). No changes have been made to personal information.';
            return;
        }

        $mimeType = mime_content_type($temp);
        $allowedFileTypes = ['image/png', 'image/jpeg'];

        if (!in_array($mimeType, $allowedFileTypes)) {
            $message = 'The chosen file is not an image file. No changes have been made to personal information.';
            return;
        }

        $ext = pathinfo($_FILES['image-upload']['name'], PATHINFO_EXTENSION);

        if (!empty($employeePhoto) && file_exists(root() . '/' . $employeePhoto) && basename(root() . '/' . $employeePhoto) !== 'user.png') {
            unlink(root() . '/' . $employeePhoto);
        }

        $uploadDate = date('YmdHis');
        $employeePhoto = "uploads/images/{$employeeId}/{$employeeId}{$uploadDate}.{$ext}";
        move_uploaded_file($temp, "../{$employeePhoto}");
    }

    $dob = isset($_POST['dob']) ? strtotime($_POST['dob']) : strtotime(date('Y-m-d'));
    $byear = date("Y", $dob);
    $bmonth = date("m", $dob);
    $bday = date("d", $dob);
    $email = sanitize($_POST['email']);

    $affectedEmployee = updateEmployee(sanitize($_POST['lname']), sanitize($_POST['fname']), sanitize($_POST['mname']), sanitize($_POST['ext']), $bmonth, $bday, $byear, sanitize($_POST['pob']), sanitize($_POST['sex']), sanitize($_POST['civil-status']), sanitize($_POST['civil-status-specify']), sanitize($_POST['religion']), sanitize($_POST['citizenship']), sanitize($_POST['dual-citizenship']), sanitize($_POST['dual-citizenship-country']), sanitize($_POST['rlot']), sanitize($_POST['rstreet']), sanitize($_POST['rsubdivision']), sanitize($_POST['rbarangay']), sanitize($_POST['rcity']), sanitize($_POST['rprovince']), sanitize($_POST['rzip']), sanitize($_POST['plot']), sanitize($_POST['pstreet']), sanitize($_POST['psubdivision']), sanitize($_POST['pbarangay']), sanitize($_POST['pcity']), sanitize($_POST['pprovince']), sanitize($_POST['pzip']), sanitize($_POST['height']), sanitize($_POST['weight']), sanitize($_POST['blood-type']), sanitize($_POST['umid']), sanitize($_POST['crn']), sanitize($_POST['bp']), sanitize($_POST['pagibig']), sanitize($_POST['philhealth']), sanitize($_POST['philsys']), sanitize($_POST['sss']), sanitize($_POST['telephone']), sanitize($_POST['mobile']), $email, sanitize($_POST['tin']), sanitize($_POST['agency-id']), sanitize($_POST['prc-id']), $employeePhoto, $employeeId);

    if (!$affectedEmployee) {
        $message = 'No changes have been made to personal information.';
        return;
    }

    $message = 'Personal information has been updated successfully.';
    $success = true;

    createSystemLog($stationId, $userId, 'Updated employee personal information', $employeeId, clientIp());
}

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
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'family-background';

    $affectedFamily = !family($employeeId) ?
        createFamily($slast, $sfirst, $sext, $smiddle, $swork, $sbusiness, $sbusinessAddress, $stelephone, $flast, $ffirst, $fext, $fmiddle, $mlast, $mfirst, $mmiddle, $employeeId) :
        updateFamily($slast, $sfirst, $sext, $smiddle, $swork, $sbusiness, $sbusinessAddress, $stelephone, $flast, $ffirst, $fext, $fmiddle, $mlast, $mfirst, $mmiddle, $employeeId);

    if (!$affectedFamily) {
        $message = 'No changes have been made to family background.';
        return;
    }

    $message = 'Family background has been updated successfully.';
    $success = true;

    createSystemLog($stationId, $userId, 'Updated employee family background', $employeeId, clientIp());
}

if (isset($_POST['save-child'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $childId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $clast = sanitize($_POST['clast']);
    $cfirst = sanitize($_POST['cfirst']);
    $cext = sanitize($_POST['cext']);
    $cmiddle = sanitize($_POST['cmiddle']);
    $cdob = sanitize($_POST['cdob']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'children';

    if (!child($employeeId, $childId)) {
        $affectedChild = createChild($clast, $cfirst, $cext, $cmiddle, $cdob, $employeeId);
        $logMessage = 'Added employee child';
        $message = 'Child has been added successfully.';
    } else {
        $affectedChild = updateChild($clast, $cfirst, $cext, $cmiddle, $cdob, $employeeId, $childId);
        $logMessage = 'Updated employee child';
        $message = 'Child has been updated successfully.';
    }

    if (!$affectedChild) {
        $message = 'No changes have been made to children.';
        return;
    }

    $success = true;

    createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
}

if (isset($_POST['delete-child'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $childId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'children';
    $deletedChild = deleteChild($employeeId, $childId);

    if (!$deletedChild) {
        $message = 'No changes have been made to children.';
        return;
    }

    $message = 'Child has been deleted successfully.';
    $success = true;

    createSystemLog($stationId, $userId, 'Deleted employee child', $employeeId, clientIp());
}

if (isset($_POST['save-education'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $educationId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $level = sanitize($_POST['level']);
    $school = sanitize($_POST['school']);
    $course = sanitize($_POST['course']);
    $from = sanitize($_POST['from']);
    $to = sanitize($_POST['to']);
    $isPresent = isset($_POST['is-present']) ? '1' : '0';
    $highest = sanitize($_POST['highest']);
    $year = $isPresent ? null : sanitize($_POST['year']);
    $scholarship = sanitize($_POST['scholarship']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'educational-background';

    if (empty($educationId)) {
        $affectedEducation = createEducation($level, $school, $course, $from, $to, $isPresent, $highest, $year, $scholarship, $employeeId);

        $logMessage = 'Added employee education';
        $message = 'Educational background has been added successfully.';
    } else {
        $affectedEducation = updateEducation($level, $school, $course, $from, $to, $isPresent, $highest, $year, $scholarship, $employeeId, $educationId);

        $logMessage = 'Updated employee education';
        $message = 'Educational background has been updated successfully.';
    }

    if (!$affectedEducation) {
        $message = 'No changes have been made to educational background.';
        return;
    }

    $success = true;

    createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
}

if (isset($_POST['delete-education'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $educationId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'educational-background';

    $affectedEducation = deleteEducation($employeeId, $educationId);

    if (!$affectedEducation) {
        $message = 'No changes have been made to educational background.';
        return;
    }

    $success = true;

    createSystemLog($stationId, $userId, 'Deleted employee education', $employeeId, clientIp());
}

if (isset($_POST['save-eligibility'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $eligibilityId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $career = sanitize($_POST['career']);
    $rating = sanitize($_POST['rating']);
    $examDate = sanitize($_POST['exam-date']);
    $examPlace = sanitize($_POST['exam-place']);
    $license = sanitize($_POST['license']);
    $isApplicable = isset($_POST['is-applicable']) ? '1' : '0';
    $validity = sanitize($_POST['validity']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'civil-service-eligibility';

    if (empty($eligibilityId)) {
        $affectedEligibility = createEligibility($career, $rating, $examDate, $examPlace, $license, $isApplicable, $validity, $employeeId);
        $logMessage = 'Added employee eligibility';
        $message = 'Civil service eligibility has been added successfully.';
    } else {
        $affectedEligibility = updateEligibility($career, $rating, $examDate, $examPlace, $license, $isApplicable, $validity, $employeeId, $eligibilityId);
        $logMessage = 'Updated employee eligibility';
        $message = 'Civil service eligibility has been updated successfully.';
    }

    if (!$affectedEligibility) {
        $message = 'No changes have been made to civil service eligibility.';
        return;
    }

    $success = true;

    createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
}

if (isset($_POST['delete-eligibility'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $eligibilityId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'civil-service-eligibility';

    $affectedEligibility = deleteEligibility($employeeId, $eligibilityId);

    if (!$affectedEligibility) {
        $message = 'No changes have been made to civil service eligibility.';
        return;
    }

    $message = 'Civil service eligibility has been deleted successfully.';
    $success = true;

    createSystemLog($stationId, $userId, 'Deleted employee eligibility', $employeeId, clientIp());
}

if (isset($_POST['save-voluntary-work'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $voluntaryId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $organization = sanitize($_POST['organization']);
    $from = sanitize($_POST['from']);
    $isPresent = isset($_POST['is-present']) ? '1' : '0';
    $to = sanitize($_POST['to']);
    $hours = $_POST['hours'] ?? 0;
    $position = sanitize($_POST['position']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'voluntary-work';

    if (empty($voluntaryId)) {
        $affectedVoluntaryWork = createVoluntaryWork($organization, $from, $to, $isPresent, $hours, $position, $employeeId);

        $logMessage = 'Added employee voluntary work';
        $message = 'Voluntary work has been added successfully.';
    } else {
        $affectedVoluntaryWork = updateVoluntaryWork($organization, $from, $to, $isPresent, $hours, $position, $employeeId, $voluntaryId);

        $logMessage = 'Updated employee voluntary work';
        $message = 'Voluntary work has been updated successfully.';
    }

    if (!$affectedVoluntaryWork) {
        $message = 'No changes have been made to voluntary work.';
        return;
    }

    $success = true;

    createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
}

if (isset($_POST['delete-voluntary-work'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $voluntaryId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'voluntary-work';

    $affectedVoluntaryWork = deleteVoluntaryWork($employeeId, $voluntaryId);

    if (!$affectedVoluntaryWork) {
        $message = 'No changes have been made to voluntary work.';
        return;
    }

    $message = 'Voluntary work has been deleted successfully.';
    $success = true;

    createSystemLog($stationId, $userId, 'Deleted employee voluntary work', $employeeId, clientIp());
}

if (isset($_POST['save-special-skill'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $skillId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $skill = sanitize($_POST['skill']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'special-skills';

    if (empty($skillId)) {
        $affectedSkill = createSpecialSkill($skill, $employeeId);
        $logMessage = 'Added employee special skill';
        $message = 'Special skill / hobby has been added successfully.';
    } else {
        $affectedSkill = updateSpecialSkill($skill, $employeeId, $skillId);
        $logMessage = 'Updated employee special skill';
        $message = 'Special skill / hobby has been updated successfully.';
    }

    if (!$affectedSkill) {
        $message = 'No changes have been made to special skill / hobby.';
        return;
    }

    $success = true;

    createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
}

if (isset($_POST['delete-special-skill'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $skillId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'special-skills';

    $affectedSkill = deleteSpecialSkill($employeeId, $skillId);

    if (!$affectedSkill) {
        $message = 'No changes have been made to special skill / hobby.';
        return;
    }

    $message = 'Special skill / hobby has been deleted successfully.';
    $success = true;

    createSystemLog($stationId, $userId, 'Deleted employee special skill', $employeeId, clientIp());
}

if (isset($_POST['save-recognition'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $recognitionId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $recognition = sanitize($_POST['recognition']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'recognition';

    if (empty($recognitionId)) {
        $affectedRecognition = createRecognition($recognition, $employeeId);
        $logMessage = 'Added employee recognition';
        $message = 'Non-academic distinction / recognition has been added successfully.';
    } else {
        $affectedRecognition = updateRecognition($recognition, $employeeId, $recognitionId);
        $logMessage = 'Updated employee recognition';
        $message = 'Non-academic distinction / recognition has been updated successfully.';
    }

    if (!$affectedRecognition) {
        $message = 'No changes have been made to non-academic distinction / recognition.';
        return;
    }

    $success = true;

    createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
}

if (isset($_POST['delete-recognition'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $recognitionId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'recognition';

    $affectedRecognition = deleteRecognition($employeeId, $recognitionId);

    if (!$affectedRecognition) {
        $message = 'No changes have been made to non-academic distinction / recognition.';
        return;
    }

    $message = 'Non-academic distinction / recognition has been deleted successfully.';
    $success = true;

    createSystemLog($stationId, $userId, 'Deleted employee recognition', $employeeId, clientIp());
}

if (isset($_POST['save-membership'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $membershipId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $membership = sanitize($_POST['membership']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'membership';

    if (empty($membershipId)) {
        $affectedMembership = createMembership($membership, $employeeId);
        $logMessage = 'Added employee membership';
        $message = 'Membership in Association / Organization has been added successfully.';
    } else {
        $affectedMembership = updateMembership($membership, $employeeId, $membershipId);
        $logMessage = 'Updated employee membership';
        $message = 'Membership in association / organization has been updated successfully.';
    }

    if (!$affectedMembership) {
        $message = 'No changes have been made to membership in association / organization.';
        return;
    }

    $success = true;

    createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
}

if (isset($_POST['delete-membership'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $membershipId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'membership';

    $affectedMembership = deleteMembership($employeeId, $membershipId);

    if (!$affectedMembership) {
        $message = 'No changes have been made to membership in association / organization.';
        return;
    }

    $message = 'Membership in association / organization has been deleted successfully.';
    $success = true;

    createSystemLog($stationId, $userId, 'Deleted employee membership', $employeeId, clientIp());
}

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
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'other-information';

    $affectedOtherInformation = !otherInformation($employeeId) ?
        createOtherInformation($hasThirdDegree, $hasFourthDegree, $relatedDetails, $wasGuilty, $guiltyDetails, $wasCharged, $dateFiled, $caseStatus, $wasConvicted, $convictedDetails, $wasSeparated, $separatedDetails, $wasCandidate, $candidateDetails, $resigned, $resignedDetails, $immigrant, $immigrantCountry, $isIndigenous, $indigenousSpecify, $isDifferentlyAbled, $differentlyAbledSpecify, $isSoloParent, $soloParentSpecify, $employeeId) :
        updateOtherInformation($hasThirdDegree, $hasFourthDegree, $relatedDetails, $wasGuilty, $guiltyDetails, $wasCharged, $dateFiled, $caseStatus, $wasConvicted, $convictedDetails, $wasSeparated, $separatedDetails, $wasCandidate, $candidateDetails, $resigned, $resignedDetails, $immigrant, $immigrantCountry, $isIndigenous, $indigenousSpecify, $isDifferentlyAbled, $differentlyAbledSpecify, $isSoloParent, $soloParentSpecify, $employeeId);

    if (!$affectedOtherInformation) {
        $message = 'No changes have been made to other information.';
        return;
    }

    $message = 'Other information has been updated successfully.';
    $success = true;

    createSystemLog($stationId, $userId, 'Updated employee other information', $employeeId, clientIp());
}

if (isset($_POST['save-reference'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $referenceId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $name = sanitize($_POST['name']);
    $address = sanitize($_POST['address']);
    $contact = sanitize($_POST['telephone']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'reference';

    if (empty($referenceId)) {
        $affectedReference = createReference($name, $address, $contact, $employeeId);
        $logMessage = 'Added employee reference';
        $message = 'Reference has been added successfully.';
    } else {
        $affectedReference = updateReference($name, $address, $contact, $employeeId, $referenceId);
        $logMessage = 'Updated employee reference';
        $message = 'Reference has been updated successfully.';
    }

    if (!$affectedReference) {
        $message = 'No changes have been made to reference.';
        return;
    }

    $success = true;

    createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
}

if (isset($_POST['delete-reference'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $referenceId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'reference';

    $affectedReference = deleteReference($employeeId, $referenceId);

    if (!$affectedReference) {
        $message = 'No changes have been made to reference.';
        return;
    }

    $message = 'Reference has been deleted successfully.';
    $success = true;

    createSystemLog($stationId, $userId, 'Deleted employee reference', $employeeId, clientIp());
}

if (isset($_POST['reassign-employee'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $positions = position($employeeId);

    $positionId = $positions ? $positions['position_id'] : '';
    $eStationId = sanitize($_POST['assignment']);
    $date = sanitize($_POST['assignment-date']);

    if (empty($employeeId) || empty($positionId) || empty($eStationId) || empty($date)) {
        return;
    }

    $showAlert = true;

    if (user($employeeId)) {
        deleteUserRoles($employeeId);
    }

    if (!station($employeeId)) {
        $affectedStation = createStation($date, $eStationId, $positionId, $employeeId);
    } else {
        updateEmployeeStatus('Active', $employeeId);
        $affectedStation = updateStation($date, $eStationId, $positionId, $employeeId);
    }

    if (!$affectedStation) {
        $message = 'No changes to employee [<a href="#" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] assignment has been made.';
        return;
    }

    $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] has been reassigned successfully to [<a href="' . customUri('hrmis', 'School Information', $eStationId) . '" title="View ' . stationName($eStationId) . ' information">' . strtoupper(stationName($eStationId)) . '</a>].';
    $success = true;

    createSystemLog($stationId, $userId, 'Reassigned employee', $employeeId, clientIp());
}

if (isset($_POST['promote-employee'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $positionId = sanitize($_POST['position']);
    $position = strtoupper(positions($positionId)['official_title']);
    $station = station($employeeId);
    $eStationId = '';

    if ($station) {
        $eStationId = $station['station_id'];
    }

    $datePromoted = sanitize($_POST['effectivity-date']);

    if (empty($employeeId) || empty($positionId) || empty($eStationId) || empty($datePromoted)) {
        return;
    }

    $showAlert = true;

    $psipop = psipop($employeeId);
    $status = $doa = $eligibility = null;

    if ($psipop) {
        $status = $psipop['employment_status'];
        $doa = $psipop['original_appointment_date'] ?? date('Y-m-d');
        $eligibility = $psipop['eligibility'];
        updatePsipop('', $status, $doa, $datePromoted, $eligibility, $employeeId);
    }

    if (getEmployeeStepIncrement($employeeId)) {
        $sg = positions($positionId)['salary_grade'];
        updateStepIncrement($datePromoted, '1', $sg, $employeeId);
    }

    if (!station($employeeId)) {
        $affectedStation = createStation($datePromoted, $eStationId, $positionId, $employeeId);
    } else {
        updateEmployeeStatus('Active', $employeeId);
        $affectedStation = updateStation($datePromoted, $eStationId, $positionId, $employeeId);
    }

    if (!$affectedStation) {
        $message = 'No changes to employee [<a href="#" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] information has been made.';
        return;
    }

    $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] has been promoted successfully to [' . $position . '].';
    $success = true;

    createSystemLog($stationId, $userId, 'Promoted employee', $employeeId, clientIp());
}

if (isset($_POST['remove-employee'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $reason = sanitize($_POST['reason']);
    $skipVacancy = isset($_POST['skip_vacancy']);
    $showAlert = true;

    if (empty($employeeId) || empty($reason)) {
        return;
    }

    $positionId = position($employeeId)['position_id'];
    $eStationId = station($employeeId)['station_id'];
    $psipopData = psipop($employeeId);
    $psipopItem = $psipopData ? $psipopData['item_number'] : '';
    $dateVacated = date('Y-m-d');

    if (employee($employeeId)) {
        $affectedEmployeeStatus = updateEmployeeStatus($reason, $employeeId);
    }

    if (!$affectedEmployeeStatus) {
        $message = 'No changes to employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] status has been made.';
        return;
    }

    $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] has been removed successfully.';
    $success = true;

    createSystemLog($stationId, $userId, 'Removed employee', $employeeId, clientIp());

    if ($skipVacancy || strtolower($reason) === 'duplicate') {
        return;
    }

    if (createVacancy('open', $positionId, $eStationId, $psipopItem, $employeeId, $dateVacated, $reason)) {
        $message .= ' A vacant item has been created for this position.';

        createSystemLog($stationId, $userId, 'Created vacant item', $employeeId, clientIp());
    }
}

if (isset($_POST['set-school-head'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $schoolId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;

    if (employee($employeeId)) {
        $affectedSchoolHead = updateSchoolHead($schoolId, $employeeId);
    }

    if (!$affectedSchoolHead) {
        $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] was not set as school head of [<a href="#" title="View ' . stationName($schoolId) . ' school information">' . strtoupper(stationName($schoolId)) . '</a>].';
        return;
    }

    $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] has been successfully set as school head of [<a href="#" title="View ' . stationName($schoolId) . ' school information">' . strtoupper(stationName($schoolId)) . '</a>].';
    $success = true;

    createSystemLog($stationId, $userId, 'Set School Head', $employeeId, clientIp());
}

if (isset($_POST['save-service-record'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $serviceId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $from = sanitize($_POST['from']);
    $isPresent = isset($_POST['is-present']) ? '1' : '0';
    $to = sanitize($_POST['to']);
    $position = sanitize($_POST['position']);
    $status = sanitize($_POST['status']);
    $isGovernment = sanitize($_POST['is-government']) === 'Y' ? '1' : '0';
    $sg = sanitize($_POST['sg-step']);
    $salary = isset($_POST['salary']) ? sanitize($_POST['salary']) : '0';
    $station = sanitize($_POST['station']);
    $leaveDates = sanitize($_POST['leave']);
    $isSeparation = isset($_POST['is-separation']) ? '1' : '0';
    $separationDate = $separationCause = null;
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'work-experience';

    if ($isSeparation === '1') {
        $separationDate = sanitize($_POST['separation-date']);
        $separationCause = sanitize($_POST['separation-cause']);
    }

    if (empty($serviceId)) {
        $affectedExperience = createExperience($from, $to, $isPresent, $position, $status, $isGovernment, $sg, $salary, $station, $leaveDates, $isSeparation, $separationDate, $separationCause, $employeeId);
        $logMessage = 'Added service record';
        $message = 'Service record has been added successfully.';
    } else {
        $affectedExperience = updateExperience($from, $to, $isPresent, $position, $status, $isGovernment, $sg, $salary, $station, $leaveDates, $isSeparation, $separationDate, $separationCause, $employeeId, $serviceId);
        $logMessage = 'Updated service record';
        $message = 'Service record has been updated successfully.';
    }

    if (!$affectedExperience) {
        $message = 'No changes have been made to service record.';
        return;
    }

    $success = true;

    createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
}

if (isset($_POST['delete-service-record'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $serviceId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'work-experience';

    $affectedExperience = deleteExperience($employeeId, $serviceId);

    if (!$affectedExperience) {
        $message = 'No changes have been made to service record.';
        return;
    }

    $message = 'Service record has been deleted successfully.';
    $success = true;

    createSystemLog($stationId, $userId, 'Deleted employee service record', $employeeId, clientIp());
}

if (isset($_POST['save-psipop'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $item = sanitize($_POST['item']);
    $doa = sanitize($_POST['doa']);
    $dlp = sanitize($_POST['dlp']);
    $status = sanitize($_POST['status']);
    $eligibility = sanitize($_POST['eligibility']);
    $showAlert = true;
    $employeePosition = position($employeeId);
    $positionId = $employeePosition['position_id'] ?? null;
    $salaryGrade = positions($positionId)['salary_grade'] ?? null;

    $changesMade = false;

    $employeeStep = getEmployeeStepIncrement($employeeId);

    if (!$employeeStep) {
        $initialStep = '1';
        $changesMade = createStepIncrement($dlp, $initialStep, $salaryGrade, $employeeId);
    } elseif (empty($employeeStep['last_step_date'])) {
        $changesMade = updateStepIncrement($dlp, $employeeStep['step'], $salaryGrade, $employeeId);
    }

    $employeeAward = getEmployeeLoyaltyAward($employeeId);

    if (!$employeeAward) {
        $changesMade = createLoyaltyAward($doa, $employeeId);
    } elseif (empty($employeeAward['last_awarded_on'])) {
        $changesMade = updateLoyaltyAward($doa, $employeeId);
    }

    $changesMade = updatePsipop($item, $status, $doa, $dlp, $eligibility, $employeeId);

    if (!$changesMade) {
        $message = 'No changes have been made to employee PSIPOP information.';
        return;
    }

    $employeeName = userName($employeeId, true);
    $viewLink = customUri('hrmis', 'Employee Information', $employeeId);
    $message = "Employee [<a href='{$viewLink}' title='View {$employeeName} employee information'>{$employeeName}</a>]'s PSIPOP information has been updated successfully.";
    $success = true;

    createSystemLog($stationId, $userId, 'Updated PSIPOP', $employeeId, clientIp());
}

if (isset($_POST['save-201-file'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $fileId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $description = sanitize($_POST['description']);
    $oldFilename = isset($_POST['file-verifier']) ? sanitize(decipher($_POST['file-verifier'])) : null;
    $newFilename = $oldFilename;
    $showAlert = true;

    if (is_uploaded_file($_FILES['file-upload']['tmp_name'])) {
        $temp = $_FILES['file-upload']['tmp_name'];

        if ($_FILES['file-upload']['size'] > FILE_UPLOAD_SIZE_LIMIT) {
            $message = 'The choosen file exceeds the upload file limit (20 MB). No changes have been made to 201 file.';
            return;
        }

        if (mime_content_type($temp) !== 'application/pdf') {
            $message = 'The choosen file is not an acceptable file (pdf). No changes have been made to 201 file.';
            return;
        }

        $ext = pathinfo($_FILES['file-upload']['name'], PATHINFO_EXTENSION);
        $newFilename = "uploads/201_files/{$employeeId}/{$employeeId}-" . date('YmdHis') . ".{$ext}";

        if (!move_uploaded_file($temp, "../{$newFilename}")) {
            $message = 'Failed to upload 201 file.';
            return;
        }

        if (!empty($oldFilename) && file_exists(root() . "/{$oldFilename}")) {
            unlink(root() . "/{$oldFilename}");
        }
    }

    if (empty($newFilename)) {
        $message = 'No changes have been made to 201 file.';
        return;
    }

    $ext = pathinfo($newFilename, PATHINFO_EXTENSION);
    $hasExistingRecord = fileAttachment($employeeId, $fileId);

    if (!$hasExistingRecord) {
        $affectedFileAttachment = createFileAttachment($description, $newFilename, $ext, $employeeId);
        $logMessage = 'Added 201 file';
    } else {
        $affectedFileAttachment = updateFileAttachment($description, $newFilename, $ext, $employeeId, $fileId);
        $logMessage = 'Updated 201 file';
    }

    if (!$affectedFileAttachment) {
        $message = 'No changes have been made to 201 file.';
        return;
    }

    $message = "201 file has been " . ($hasExistingRecord ? "updated" : "added") . " successfully.";
    $success = true;

    createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
}

if (isset($_POST['delete-201-file'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $fileId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $filename = null;
    $file = fileAttachment($employeeId, $fileId);
    $affectedFile = false;

    if ($file) {
        $filename = $file['file_name'];
        $affectedFile = deleteFileAttachment($employeeId, $fileId);
    }

    if (!$affectedFile) {
        $message = 'No changes have been made to 201 file.';
        return;
    }

    $message = '201 file has been deleted successfully.';
    $success = true;

    unlink(root() . '/' . $filename);
    createSystemLog($stationId, $userId, 'Deleted employee 201 file', $employeeId, clientIp());
}

if (isset($_POST['approve-step-increment'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $showAlert = true;

    $positions = position($employeeId);
    $positionId = $positions['position_id'];
    $sg = positions($positionId)['salary_grade'];

    $stepIncrement = getEmployeeStepIncrement($employeeId);
    $affectedStepIncrement = false;

    if ($stepIncrement) {
        $esi = $stepIncrement;
        $lastStep = $esi['last_step_date'];
        $step = (int) $esi['step'];
        $now = new DateTime('now');
        $dls = new DateTime($lastStep);
        $serviceDuration = $now->diff($dls)->y;

        $count = $serviceDuration < 21 ? (int) ($serviceDuration / 3) : 7;
        $increment = $serviceDuration < 21 ? 3 * $count : 21;
        $step = $step < 8 ? $step + $count : 8;

        $affectedStepIncrement = updateStepIncrement(date('Y-m-d', strtotime("+{$increment} years", strtotime($lastStep))), $step, $sg, $employeeId);
    }

    if (!$affectedStepIncrement) {
        $message = 'No changes to employee [<a href="#" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] information has been made.';
        return;
    }

    $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>]' . "'s step increment " . 'has been approved successfully.';
    $success = true;

    createSystemLog($stationId, $userId, 'Approved employee step increment', $employeeId, clientIp());
}

if (isset($_POST['approve-loyalty-award'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $showAlert = true;
    $affectedLoyaltyAward = false;
    $loyaltyAward = getEmployeeLoyaltyAward($employeeId);

    if ($loyaltyAward) {
        $ela = $loyaltyAward;

        $doa = new DateTime($ela['date_last_awarded']);
        $now = new DateTime('now');

        $count = (int) ($now->diff($doa)->y / 5);
        $increment = ($count === 2) ? 10 : 5 * $count;

        $affectedLoyaltyAward = updateLoyaltyAward(date('Y-m-d', strtotime("+{$increment} years", strtotime($ela['date_last_awarded']))), $employeeId);
    }

    if (!$affectedLoyaltyAward) {
        $message = 'No changes to employee [<a href="#" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] information has been made.';
        return;
    }

    $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>]' . "'s loyalty award " . 'has been approved successfully.';
    $success = true;

    createSystemLog($stationId, $userId, 'Approved employee loyalty award', $employeeId, clientIp());
}