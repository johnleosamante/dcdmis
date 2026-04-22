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
    $employeeId = generateID();
    $lname = sanitize($_POST['lname']);
    $fname = sanitize($_POST['fname']);
    $mname = sanitize($_POST['mname']);
    $ext = sanitize($_POST['ext']);
    $sex = sanitize($_POST['sex']);
    $bdate = sanitize($_POST['bdate']);
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
        if (createEmployee($employeeId, $lname, $fname, $mname, $ext, $sex, $bdate, $email, $mobile, $image, $status, $crn, $bp, $pagibig, $philhealth, $tin, $agencyId) === false) {
            throw new Exception('Failed to save employee information.');
        }

        if (createFamily('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', $employeeId) === false) {
            throw new Exception('Failed to create family background.');
        }

        if (createOtherInformation(0, 0, null, 0, null, 0, null, null, 0, null, 0, null, 0, null, 0, null, 0, null, 0, null, 0, null, 0, null, $employeeId) === false) {
            throw new Exception('Failed to create other information.');
        }

        if (createStation($today, $eStationId, $ePositionId, $employeeId) === false) {
            throw new Exception('Failed to assign employee station.');
        }

        if (createPsipop('', 'Permanent', $today, $today, '', $employeeId) === false) {
            throw new Exception('Failed to create PSIPOP entry.');
        }

        if (createStepIncrement($today, 1, $ePositionId, $employeeId) === false) {
            throw new Exception('Failed to create step increment record.');
        }

        if (createIdentification(null, '', '', $today, $employeeId) === false) {
            throw new Exception('Failed to create identification.');
        }

        if (createAccount($employeeId, hashPassword(generateStrongRandomPassword())) === false) {
            throw new Exception('Failed to create user account.');
        }

        createSystemLog($stationId, $userId, 'Registered employee', $employeeId, clientIp());
        commit();

        $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . $employee . ' employee information">' . strtoupper($employee) . '</a>] was saved successfully.';
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['update-personal-information'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $employeePhoto = sanitize(decipher($_POST['image-verifier'] ?? $defaultImage));
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'personal-information';
    $dualCitizenshipCountry = country(sanitize($_POST['dual-citizenship-country']))['id'] ?? null;

    beginTransaction();

    try {
        $affectedEmployee = updateEmployee(sanitize($_POST['lname']), sanitize($_POST['fname']), sanitize($_POST['mname']), sanitize($_POST['ext']), sanitize($_POST['dob']), sanitize($_POST['pob']), sanitize($_POST['sex']), sanitize($_POST['civil-status']), sanitize($_POST['civil-status-specify']), sanitize($_POST['religion']), sanitize($_POST['citizenship']), sanitize($_POST['dual-citizenship']), $dualCitizenshipCountry, sanitize($_POST['rlot']), sanitize($_POST['rstreet']), sanitize($_POST['rsubdivision']), sanitize($_POST['rbarangay']), sanitize($_POST['rcity']), sanitize($_POST['rprovince']), sanitize($_POST['rzip']), sanitize($_POST['plot']), sanitize($_POST['pstreet']), sanitize($_POST['psubdivision']), sanitize($_POST['pbarangay']), sanitize($_POST['pcity']), sanitize($_POST['pprovince']), sanitize($_POST['pzip']), sanitize($_POST['height']), sanitize($_POST['weight']), sanitize($_POST['blood-type']), sanitize($_POST['umid']), sanitize($_POST['crn']), sanitize($_POST['bp']), sanitize($_POST['pagibig']), sanitize($_POST['philhealth']), sanitize($_POST['philsys']), sanitize($_POST['sss']), sanitize($_POST['telephone']), sanitize($_POST['mobile']), sanitize($_POST['email']), sanitize($_POST['tin']), sanitize($_POST['agency-id']), sanitize($_POST['prc-id']), $employeePhoto, $employeeId);

        if ($affectedEmployee == false) {
            $message = 'No changes have been made to personal information.';
            return;
        }

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

        createSystemLog($stationId, $userId, 'Updated employee personal information', $employeeId, clientIp());
        commit();

        $message = 'Personal information has been updated successfully.';
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
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

    beginTransaction();

    try {
        $affectedFamily = !family($employeeId) ?
            createFamily($slast, $sfirst, $sext, $smiddle, $swork, $sbusiness, $sbusinessAddress, $stelephone, $flast, $ffirst, $fext, $fmiddle, $mlast, $mfirst, $mmiddle, $employeeId) :
            updateFamily($slast, $sfirst, $sext, $smiddle, $swork, $sbusiness, $sbusinessAddress, $stelephone, $flast, $ffirst, $fext, $fmiddle, $mlast, $mfirst, $mmiddle, $employeeId);

        if ($affectedFamily === false) {
            $message = 'No changes have been made to family background.';
            return;
        }

        createSystemLog($stationId, $userId, 'Updated employee family background', $employeeId, clientIp());
        commit();

        $message = 'Family background has been updated successfully.';
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['save-child'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $childId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $clast = sanitize($_POST['clast']);
    $cfirst = sanitize($_POST['cfirst']);
    $cext = sanitize($_POST['cext']);
    $cmiddle = sanitize($_POST['cmiddle']);
    $cdob = sanitize($_POST['cdob']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'children';

    beginTransaction();

    try {
        if (!child($employeeId, $childId)) {
            $affectedChild = createChild($clast, $cfirst, $cext, $cmiddle, $cdob, $employeeId);
            $logMessage = 'Added employee child';
            $message = 'Child has been added successfully.';
        } else {
            $affectedChild = updateChild($clast, $cfirst, $cext, $cmiddle, $cdob, $employeeId, $childId);
            $logMessage = 'Updated employee child';
            $message = 'Child has been updated successfully.';
        }

        if ($affectedChild === false) {
            $message = 'No changes have been made to children.';
            return;
        }

        createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
        commit();

        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['delete-child'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $childId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'children';

    beginTransaction();

    try {
        $deletedChild = deleteChild($employeeId, $childId);

        if ($deletedChild === false) {
            $message = 'No changes have been made to children.';
            return;
        }

        createSystemLog($stationId, $userId, 'Deleted employee child', $employeeId, clientIp());
        commit();

        $message = 'Child has been deleted successfully.';
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['save-education'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $educationId = sanitize(decipher($_POST['data-verifier'] ?? null));
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

    beginTransaction();

    try {
        if (empty($educationId)) {
            $affectedEducation = createEducation($level, $school, $course, $from, $to, $isPresent, $highest, $year, $scholarship, $employeeId);
            $logMessage = 'Added employee education';
            $message = 'Educational background has been added successfully.';
        } else {
            $affectedEducation = updateEducation($level, $school, $course, $from, $to, $isPresent, $highest, $year, $scholarship, $employeeId, $educationId);
            $logMessage = 'Updated employee education';
            $message = 'Educational background has been updated successfully.';
        }

        if ($affectedEducation === false) {
            $message = 'No changes have been made to educational background.';
            return;
        }

        createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
        commit();

        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['delete-education'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $educationId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'educational-background';

    beginTransaction();

    try {
        $affectedEducation = deleteEducation($employeeId, $educationId);

        if ($affectedEducation === false) {
            $message = 'No changes have been made to educational background.';
            return;
        }

        createSystemLog($stationId, $userId, 'Deleted employee education', $employeeId, clientIp());
        commit();

        $message = 'Educational background has been deleted successfully.';
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }

}

if (isset($_POST['save-eligibility'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $eligibilityId = sanitize(decipher($_POST['data-verifier'] ?? null));
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

    beginTransaction();

    try {
        if (empty($eligibilityId)) {
            $affectedEligibility = createEligibility($career, $rating, $examDate, $examPlace, $license, $isApplicable, $validity, $employeeId);
            $logMessage = 'Added employee eligibility';
            $message = 'Civil service eligibility has been added successfully.';
        } else {
            $affectedEligibility = updateEligibility($career, $rating, $examDate, $examPlace, $license, $isApplicable, $validity, $employeeId, $eligibilityId);
            $logMessage = 'Updated employee eligibility';
            $message = 'Civil service eligibility has been updated successfully.';
        }

        if ($affectedEligibility === false) {
            $message = 'No changes have been made to civil service eligibility.';
            return;
        }

        createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
        commit();

        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['delete-eligibility'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $eligibilityId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'civil-service-eligibility';

    beginTransaction();

    try {
        $affectedEligibility = deleteEligibility($employeeId, $eligibilityId);

        if ($affectedEligibility === false) {
            $message = 'No changes have been made to civil service eligibility.';
            return;
        }

        createSystemLog($stationId, $userId, 'Deleted employee eligibility', $employeeId, clientIp());
        commit();

        $message = 'Civil service eligibility has been deleted successfully.';
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['save-voluntary-work'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $voluntaryId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $organization = sanitize($_POST['organization']);
    $from = sanitize($_POST['from']);
    $isPresent = isset($_POST['is-present']) ? '1' : '0';
    $to = sanitize($_POST['to']);
    $hours = $_POST['hours'] ?? 0;
    $position = sanitize($_POST['position']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'voluntary-work';

    beginTransaction();

    try {
        if (empty($voluntaryId)) {
            $affectedVoluntaryWork = createVoluntaryWork($organization, $from, $to, $isPresent, $hours, $position, $employeeId);
            $logMessage = 'Added employee voluntary work';
            $message = 'Voluntary work has been added successfully.';
        } else {
            $affectedVoluntaryWork = updateVoluntaryWork($organization, $from, $to, $isPresent, $hours, $position, $employeeId, $voluntaryId);
            $logMessage = 'Updated employee voluntary work';
            $message = 'Voluntary work has been updated successfully.';
        }

        if ($affectedVoluntaryWork === false) {
            $message = 'No changes have been made to voluntary work.';
            return;
        }

        createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
        commit();

        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['delete-voluntary-work'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $voluntaryId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'voluntary-work';

    beginTransaction();

    try {
        $affectedVoluntaryWork = deleteVoluntaryWork($employeeId, $voluntaryId);

        if ($affectedVoluntaryWork === false) {
            $message = 'No changes have been made to voluntary work.';
            return;
        }

        createSystemLog($stationId, $userId, 'Deleted employee voluntary work', $employeeId, clientIp());
        commit();

        $message = 'Voluntary work has been deleted successfully.';
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['save-special-skill'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $skillId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $skill = sanitize($_POST['skill']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'special-skills';

    beginTransaction();

    try {
        if (empty($skillId)) {
            $affectedSkill = createSpecialSkill($skill, $employeeId);
            $logMessage = 'Added employee special skill';
            $message = 'Special skill / hobby has been added successfully.';
        } else {
            $affectedSkill = updateSpecialSkill($skill, $employeeId, $skillId);
            $logMessage = 'Updated employee special skill';
            $message = 'Special skill / hobby has been updated successfully.';
        }

        if ($affectedSkill === false) {
            $message = 'No changes have been made to special skill / hobby.';
            return;
        }

        createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
        commit();

        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['delete-special-skill'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $skillId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'special-skills';

    beginTransaction();

    try {
        $affectedSkill = deleteSpecialSkill($employeeId, $skillId);

        if ($affectedSkill === false) {
            $message = 'No changes have been made to special skill / hobby.';
            return;
        }

        createSystemLog($stationId, $userId, 'Deleted employee special skill', $employeeId, clientIp());
        commit();

        $message = 'Special skill / hobby has been deleted successfully.';
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['save-recognition'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $recognitionId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $recognition = sanitize($_POST['recognition']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'recognition';

    beginTransaction();

    try {
        if (empty($recognitionId)) {
            $affectedRecognition = createRecognition($recognition, $employeeId);
            $logMessage = 'Added employee recognition';
            $message = 'Non-academic distinction / recognition has been added successfully.';
        } else {
            $affectedRecognition = updateRecognition($recognition, $employeeId, $recognitionId);
            $logMessage = 'Updated employee recognition';
            $message = 'Non-academic distinction / recognition has been updated successfully.';
        }

        if ($affectedRecognition === false) {
            $message = 'No changes have been made to non-academic distinction / recognition.';
            return;
        }

        createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
        commit();

        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['delete-recognition'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $recognitionId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'recognition';

    beginTransaction();

    try {
        $affectedRecognition = deleteRecognition($employeeId, $recognitionId);

        if ($affectedRecognition === false) {
            $message = 'No changes have been made to non-academic distinction / recognition.';
            return;
        }

        createSystemLog($stationId, $userId, 'Deleted employee recognition', $employeeId, clientIp());
        commit();

        $message = 'Non-academic distinction / recognition has been deleted successfully.';
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }

}

if (isset($_POST['save-membership'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $membershipId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $membership = sanitize($_POST['membership']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'membership';

    beginTransaction();

    try {
        if (empty($membershipId)) {
            $affectedMembership = createMembership($membership, $employeeId);
            $logMessage = 'Added employee membership';
            $message = 'Membership in Association / Organization has been added successfully.';
        } else {
            $affectedMembership = updateMembership($membership, $employeeId, $membershipId);
            $logMessage = 'Updated employee membership';
            $message = 'Membership in association / organization has been updated successfully.';
        }

        if ($affectedMembership === false) {
            $message = 'No changes have been made to membership in association / organization.';
            return;
        }

        createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
        commit();

        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['delete-membership'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $membershipId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'membership';

    beginTransaction();

    try {
        $affectedMembership = deleteMembership($employeeId, $membershipId);

        if ($affectedMembership === false) {
            $message = 'No changes have been made to membership in association / organization.';
            return;
        }

        createSystemLog($stationId, $userId, 'Deleted employee membership', $employeeId, clientIp());
        commit();

        $message = 'Membership in association / organization has been deleted successfully.';
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['update-other-information'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
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

    beginTransaction();

    try {
        $affectedOtherInformation = !otherInformation($employeeId) ?
            createOtherInformation($hasThirdDegree, $hasFourthDegree, $relatedDetails, $wasGuilty, $guiltyDetails, $wasCharged, $dateFiled, $caseStatus, $wasConvicted, $convictedDetails, $wasSeparated, $separatedDetails, $wasCandidate, $candidateDetails, $resigned, $resignedDetails, $immigrant, $immigrantCountry, $isIndigenous, $indigenousSpecify, $isDifferentlyAbled, $differentlyAbledSpecify, $isSoloParent, $soloParentSpecify, $employeeId) :
            updateOtherInformation($hasThirdDegree, $hasFourthDegree, $relatedDetails, $wasGuilty, $guiltyDetails, $wasCharged, $dateFiled, $caseStatus, $wasConvicted, $convictedDetails, $wasSeparated, $separatedDetails, $wasCandidate, $candidateDetails, $resigned, $resignedDetails, $immigrant, $immigrantCountry, $isIndigenous, $indigenousSpecify, $isDifferentlyAbled, $differentlyAbledSpecify, $isSoloParent, $soloParentSpecify, $employeeId);

        if ($affectedOtherInformation === false) {
            $message = 'No changes have been made to other information.';
            return;
        }

        createSystemLog($stationId, $userId, 'Updated employee other information', $employeeId, clientIp());
        commit();

        $message = 'Other information has been updated successfully.';
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['save-reference'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $referenceId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $name = sanitize($_POST['name']);
    $address = sanitize($_POST['address']);
    $contact = sanitize($_POST['telephone']);
    $logMessage = '';
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'reference';

    beginTransaction();

    try {
        if (empty($referenceId)) {
            $affectedReference = createReference($name, $address, $contact, $employeeId);
            $logMessage = 'Added employee reference';
            $message = 'Reference has been added successfully.';
        } else {
            $affectedReference = updateReference($name, $address, $contact, $employeeId, $referenceId);
            $logMessage = 'Updated employee reference';
            $message = 'Reference has been updated successfully.';
        }

        if ($affectedReference === false) {
            $message = 'No changes have been made to reference.';
            return;
        }

        createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
        commit();

        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['delete-reference'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $referenceId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'reference';

    beginTransaction();

    try {
        $affectedReference = deleteReference($employeeId, $referenceId);

        if ($affectedReference === false) {
            $message = 'No changes have been made to reference.';
            return;
        }

        createSystemLog($stationId, $userId, 'Deleted employee reference', $employeeId, clientIp());
        commit();

        $message = 'Reference has been deleted successfully.';
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['reassign-employee'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $positions = position($employeeId);
    $positionId = $positions ? $positions['position_id'] : '';
    $eStationId = sanitize($_POST['assignment']);
    $date = sanitize($_POST['assignment-date']);
    $showAlert = true;

    if (empty($employeeId) || empty($positionId) || empty($eStationId) || empty($date)) {
        return;
    }

    beginTransaction();

    try {
        if (user($employeeId)) {
            deleteUserRoles($employeeId);
        }

        if (!station($employeeId)) {
            $affectedStation = createStation($date, $eStationId, $positionId, $employeeId);
        } else {
            updateEmployeeStatus('Active', $employeeId);
            $affectedStation = updateStation($date, $eStationId, $positionId, $employeeId);
        }

        if ($affectedStation === false) {
            $message = 'No changes to employee [<a href="#" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] assignment has been made.';
            return;
        }

        createSystemLog($stationId, $userId, 'Reassigned employee', $employeeId, clientIp());
        commit();

        $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] has been reassigned successfully to [<a href="' . customUri('hrmis', 'School Information', $eStationId) . '" title="View ' . stationName($eStationId) . ' information">' . strtoupper(stationName($eStationId)) . '</a>].';
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['promote-employee'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $positionId = sanitize($_POST['position']);
    $position = strtoupper(positions($positionId)['official_title']);
    $station = station($employeeId);
    $skipVacancy = isset($_POST['skip_vacancy']);
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

    beginTransaction();

    try {
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

        if ($affectedStation === false) {
            $message = 'No changes to employee [<a href="#" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] information has been made.';
            return;
        }

        createSystemLog($stationId, $userId, 'Promoted employee', $employeeId, clientIp());

        $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] has been promoted successfully to [' . $position . '].';
        $success = true;

        if ($skipVacancy) {
            return;
        }

        $plantillaItemId = employeeItemNumber($employeeId);

        if ($plantillaItemId) {
            return;
        }

        if (createVacancy($plantillaItem, 'open', $employeeId, $dateVacated, 'promoted')) {
            $message .= ' A vacant item has been created for this position.';

            createSystemLog($stationId, $userId, 'Created vacant item', $employeeId, clientIp());
        }

        commit();
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['remove-employee'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
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

    beginTransaction();

    try {
        if (employee($employeeId)) {
            $affectedEmployeeStatus = updateEmployeeStatus($reason, $employeeId);
        }

        if ($affectedEmployeeStatus === false) {
            $message = 'No changes to employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] status has been made.';
            return;
        }

        $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] has been removed successfully.';
        $success = true;

        createSystemLog($stationId, $userId, 'Removed employee', $employeeId, clientIp());

        if ($skipVacancy || strtolower($reason) === 'duplicate') {
            return;
        }

        $plantillaItemId = employeeItemNumber($employeeId);

        if (!$plantillaItemId) {
            return;
        }

        $plantillaItem = $plantillaItemId['id'];

        if (createVacancy($plantillaItem, 'open', $employeeId, $dateVacated, $reason)) {
            $message .= ' A vacant item has been created for this position.';

            createSystemLog($stationId, $userId, 'Created vacant item', $employeeId, clientIp());
        }

        commit();
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['set-school-head'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $schoolId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $showAlert = true;

    beginTransaction();

    try {
        if (employee($employeeId)) {
            $affectedSchoolHead = updateSchoolHead($schoolId, $employeeId);
        }

        if ($affectedSchoolHead === false) {
            $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] was not set as school head of [<a href="#" title="View ' . stationName($schoolId) . ' school information">' . strtoupper(stationName($schoolId)) . '</a>].';
            return;
        }

        createSystemLog($stationId, $userId, 'Set School Head', $employeeId, clientIp());
        commit();

        $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] has been successfully set as school head of [<a href="#" title="View ' . stationName($schoolId) . ' school information">' . strtoupper(stationName($schoolId)) . '</a>].';
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['save-service-record'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $serviceId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $from = sanitize($_POST['from']);
    $isPresent = isset($_POST['is-present']) ? '1' : '0';
    $to = sanitize($_POST['to']);
    $position = sanitize($_POST['position']);
    $status = sanitize($_POST['status']);
    $isGovernment = sanitize($_POST['is-government']) === 'Y' ? '1' : '0';
    $sg = sanitize($_POST['sg-step']);
    $salary = sanitize($_POST['salary'] ?? '0');
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

    beginTransaction();

    try {
        if (empty($serviceId)) {
            $affectedExperience = createExperience($from, $to, $isPresent, $position, $status, $isGovernment, $sg, $salary, $station, $leaveDates, $isSeparation, $separationDate, $separationCause, $employeeId);
            $logMessage = 'Added service record';
            $message = 'Service record has been added successfully.';
        } else {
            $affectedExperience = updateExperience($from, $to, $isPresent, $position, $status, $isGovernment, $sg, $salary, $station, $leaveDates, $isSeparation, $separationDate, $separationCause, $employeeId, $serviceId);
            $logMessage = 'Updated service record';
            $message = 'Service record has been updated successfully.';
        }

        if ($affectedExperience === false) {
            $message = 'No changes have been made to service record.';
            return;
        }

        createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
        commit();

        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['delete-service-record'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $serviceId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $showAlert = true;
    $activeTab = $_SESSION[alias() . '_activeTab'] = 'work-experience';

    beginTransaction();

    try {
        $affectedExperience = deleteExperience($employeeId, $serviceId);

        if ($affectedExperience === false) {
            $message = 'No changes have been made to service record.';
            return;
        }

        createSystemLog($stationId, $userId, 'Deleted employee service record', $employeeId, clientIp());
        commit();

        $message = 'Service record has been deleted successfully.';
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['save-psipop'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $item = sanitize($_POST['item']);
    $doa = sanitize($_POST['doa']);
    $dlp = sanitize($_POST['dlp']);
    $status = sanitize($_POST['status']);
    $eligibility = sanitize($_POST['eligibility']);
    $showAlert = true;
    $employeePosition = position($employeeId);
    $positionId = $employeePosition['position_id'] ?? null;
    $changesMade = false;

    $employeeStep = getEmployeeStepIncrement($employeeId);

    beginTransaction();

    try {
        if (!$employeeStep) {
            $initialStep = '1';
            $changesMade = createStepIncrement($dlp, $initialStep, $positionId, $employeeId);
        } elseif (empty($employeeStep['last_step_date'])) {
            $changesMade = updateStepIncrement($dlp, $employeeStep['step'], $positionId, $employeeId);
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

        createSystemLog($stationId, $userId, 'Updated PSIPOP', $employeeId, clientIp());
        commit();

        $employeeName = userName($employeeId, true);
        $viewLink = customUri('hrmis', 'Employee Information', $employeeId);
        $message = "Employee [<a href='{$viewLink}' title='View {$employeeName} employee information'>{$employeeName}</a>]'s PSIPOP information has been updated successfully.";
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }

}

if (isset($_POST['save-201-file'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $fileId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $fileTypeId = sanitize($_POST['type']);
    $description = sanitize($_POST['description']);
    $oldFilename = sanitize(decipher($_POST['file-verifier'] ?? null));
    $newFilename = $oldFilename;
    $showAlert = true;

    beginTransaction();

    try {
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
            $affectedFileAttachment = createFileAttachment($fileTypeId, $description, $newFilename, $ext, $employeeId);
            $logMessage = 'Added 201 file';
        } else {
            $affectedFileAttachment = updateFileAttachment($fileTypeId, $description, $newFilename, $ext, $employeeId, $fileId);
            $logMessage = 'Updated 201 file';
        }

        if ($affectedFileAttachment === false) {
            $message = 'No changes have been made to 201 file.';
            return;
        }

        createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
        commit();

        $message = "201 file has been " . ($hasExistingRecord ? "updated" : "added") . " successfully.";
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['delete-201-file'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $fileId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $showAlert = true;
    $filename = null;
    $file = fileAttachment($employeeId, $fileId);
    $affectedFile = false;

    beginTransaction();

    try {
        if ($file) {
            $filename = $file['file_name'];
            $affectedFile = deleteFileAttachment($employeeId, $fileId);
        }

        if ($affectedFile === false) {
            $message = 'No changes have been made to 201 file.';
            return;
        }

        unlink(root() . '/' . $filename);
        createSystemLog($stationId, $userId, 'Deleted employee 201 file', $employeeId, clientIp());
        commit();

        $message = '201 file has been deleted successfully.';
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['approve-step-increment'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $showAlert = true;

    $positions = position($employeeId);
    $positionId = $positions['position_id'];
    $sg = positions($positionId)['salary_grade'];

    $stepIncrement = getEmployeeStepIncrement($employeeId);
    $affectedStepIncrement = false;

    beginTransaction();

    try {
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

        if ($affectedStepIncrement === false) {
            $message = 'No changes to employee [<a href="#" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] information has been made.';
            return;
        }

        createSystemLog($stationId, $userId, 'Approved employee step increment', $employeeId, clientIp());
        commit();

        $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>]' . "'s step increment " . 'has been approved successfully.';
        $success = true;
    } catch (Exception) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['approve-loyalty-award'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $showAlert = true;
    $affectedLoyaltyAward = false;
    $loyaltyAward = getEmployeeLoyaltyAward($employeeId);

    beginTransaction();

    try {
        if ($loyaltyAward) {
            $ela = $loyaltyAward;

            $doa = new DateTime($ela['date_last_awarded']);
            $now = new DateTime('now');

            $count = (int) ($now->diff($doa)->y / 5);
            $increment = ($count === 2) ? 10 : 5 * $count;

            $affectedLoyaltyAward = updateLoyaltyAward(date('Y-m-d', strtotime("+{$increment} years", strtotime($ela['date_last_awarded']))), $employeeId);
        }

        if ($affectedLoyaltyAward === false) {
            $message = 'No changes to employee [<a href="#" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>] information has been made.';
            return;
        }

        createSystemLog($stationId, $userId, 'Approved employee loyalty award', $employeeId, clientIp());
        commit();

        $message = 'Employee [<a href="' . customUri('hrmis', 'Employee Information', $employeeId) . '" title="View ' . userName($employeeId) . ' employee information">' . userName($employeeId, true) . '</a>]' . "'s loyalty award " . 'has been approved successfully.';
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['save-position'])) {
    $referencePositionId = sanitize(decipher($_POST['verifier'] ?? null));
    $positionId = sanitize($_POST['position-id']);
    $official_title = sanitize($_POST['official-title']);
    $salary_grade = sanitize($_POST['salary-grade']);
    $category = sanitize($_POST['category']);
    $showAlert = true;

    if (empty($official_title)) {
        $message = 'Please enter the official title.';
        return;
    }

    if (empty($salary_grade)) {
        $message = 'Please enter the salary grade.';
        return;
    }

    if (empty($category)) {
        $message = 'Please select a category.';
        return;
    }

    beginTransaction();

    try {
        $existingPosition = $referencePositionId ? positions($referencePositionId) : null;

        if (!$existingPosition) {
            $affectedPosition = createPosition($positionId, $official_title, $salary_grade, $category);
            $status = 'saved';
            $logMessage = 'Saved position';
        } else {
            $affectedPosition = updatePosition($positionId, $official_title, $salary_grade, $category, $referencePositionId);
            $status = 'updated';
            $logMessage = 'Updated position';
        }

        if ($affectedPosition === false) {
            $message = 'No changes have been made to positions.';
            return;
        }

        createSystemLog($stationId, $userId, 'Updated position', $positionId, clientIp());
        commit();

        $official_title = strtoupper($official_title);
        $message = "Position [$official_title] (SG $salary_grade) has been updated successfully.";
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['delete-position'])) {
    $positionId = sanitize(decipher($_POST['verifier'] ?? null));
    $showAlert = true;
    $message = 'Position was not deleted successfully.';

    if (empty($positionId)) {
        $message = 'Invalid position selected.';
        return;
    }

    beginTransaction();

    try {
        $position = positions($positionId);

        if (!$position) {
            $message = 'Position not found.';
            return;
        }

        $positionTitle = strtoupper($position['official_title']);
        $affectedPosition = deletePosition($positionId);

        if ($affectedPosition === false) {
            $message = 'Position was not deleted successfully.';
            return;
        }

        createSystemLog($stationId, $userId, 'Deleted position', $positionId, clientIp());
        commit();

        $message = "Position [$positionTitle] has been deleted successfully.";
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['save-vacancy'])) {
    $vacancyId = sanitize(decipher($_POST['verifier'] ?? null));
    $plantillaItemId = sanitize($_POST['item_number'] ?? null);
    $datePosted = $_POST['date_posted'] ?? date('Y-m-d');
    $positionTitle = $item_number = null;
    $showAlert = true;
    $status = 'Added vacancy';

    if (empty($plantillaItemId)) {
        $message = 'Please select a plantilla item number.';
        return;
    }

    beginTransaction();

    try {
        if (vacancy($vacancyId)) {
            $result = createVacancy($plantillaItemId, 'open', null, $datePosted, $reason);
        }

        if (empty($vacancyId)) {
            $affectedVacancy = createVacancy($plantillaItemId, 'open', null, $datePosted, 'new');

            $position = itemPosition($plantillaItemId);
            $positionTitle = strtoupper($position['official_title']);
            $itemNumber = $position['item_number'];

            $message = "Vacancy for [$positionTitle] with item number [$itemNumber] has been added successfully.";
        }

        if ($affectedVacancy === false) {
            $message = 'Vacancy was not saved successfully.';
            return;
        }

        createSystemLog($stationId, $userId, $status, $itemNumber, clientIp());
        commit();

        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['delete-vacancy'])) {
    $vacancyId = sanitize(decipher($_POST['verifier'] ?? null));
    $showAlert = true;

    if (empty($vacancyId)) {
        $message = 'Invalid vacancy selected.';
        return;
    }

    beginTransaction();

    try {
        $vacancy = vacancy($vacancyId);
        $position = strtoupper($vacancy['official_title']);
        $itemNumber = $vacancy['item_number'];
        $deletedVacancy = deleteVacancy($vacancyId);

        if ($deletedVacancy === false) {
            $message = 'Vacancy was not deleted successfully.';
            return;
        }

        createSystemLog($stationId, $userId, 'Deleted vacancy', $itemNumber, clientIp());
        commit();

        $message = "Vacancy for [$position] with item number [$itemNumber] has been deleted successfully.";
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['save-plantilla-item'])) {
    $plantillaItemId = sanitize(decipher($_POST['verifier'] ?? null));
    $item_number = sanitize($_POST['item-number'] ?? null);
    $position_id = sanitize($_POST['position'] ?? null);
    $station_id = sanitize($_POST['station'] ?? null);
    $employment_status = sanitize($_POST['employment-status'] ?? null);
    $is_dissolve = isset($_POST['is-dissolve']) ? 1 : 0;
    $showAlert = true;

    beginTransaction();

    try {
        if (!plantillaItem($plantillaItemId)) {
            $affectedPlantillaItem = createPlantillaItem($position_id, $item_number, $employment_status, $station_id, $is_dissolve);
            $message = "Plantilla item [$item_number] created successfully.";
        } else {
            $affectedPlantillaItem = updatePlantillaItem($plantillaItemId, $position_id, $item_number, $employment_status, $station_id, $is_dissolve);
            $message = "Plantilla item [$item_number] updated successfully.";
        }

        if ($affectedPlantillaItem === false) {
            $message = doesItemNumberExist($item_number) ? 'Item number already exists.' : 'No changes have been made to plantilla items.';
            return;
        }

        createSystemLog($stationId, $userId, 'Added Plantilla Item', $item_number, clientIp());
        commit();

        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['delete-plantilla-item'])) {
    $plantillaItemId = sanitize(decipher($_POST['verifier'] ?? null));
    $showAlert = true;
    $message = 'No changes have been made to plantilla items.';

    beginTransaction();

    try {
        $plantillaItemNumber = plantillaItem($plantillaItemId)['item_number'] ?? null;
        $affectedPlantillaItem = deletePlantillaItem($plantillaItemId);

        if ($affectedPlantillaItem === false) {
            return;
        }

        createSystemLog($stationId, $userId, 'Deleted plantilla items', $plantillaItemNumber, clientIp());
        commit();

        $message = 'Plantilla Item has been deleted successfully.';
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['publish-vacancies'])) {
    $showAlert = true;
    $title = sanitize($_POST['pub_title'] ?? null);
    $description = sanitize($_POST['pub_description'] ?? null);
    $openDate = sanitize($_POST['open_date'] ?? date('Y-m-d'));
    $closeDate = sanitize($_POST['close_date'] ?? date('Y-m-d', strtotime('+30 days')));
    $pubStatus = sanitize($_POST['pub_status'] ?? 'open');
    $vacancyIds = $_POST['vacancy_ids'] ?? [];
    $message = 'Failed to create publication.';

    if (empty($title)) {
        $message = 'Please enter a publication title.';
        return;
    }

    if (empty($vacancyIds)) {
        $message = 'Please select at least one vacancy to publish.';
        return;
    }

    if (strtotime($closeDate) < strtotime($openDate)) {
        $message = 'Closing date cannot be before opening date.';
        return;
    }

    $code = generatePublicationCode();

    beginTransaction();

    try {
        $publicationId = createPublication($code, $title, $description, $openDate, $closeDate, $pubStatus);

        if ($publicationId) {
            $totalVacanciesLinked = 0;

            foreach ($vacancyIds as $vacancyId) {
                addPublicationItem($publicationId, $vacancyId);
                $totalVacanciesLinked++;
            }

            createSystemLog($stationId, $userId, 'Published vacancies', "$code - $totalVacanciesLinked items linked", clientIp());
            commit();

            $applicationUrl = uri() . '/hrmis/apply?p=' . $code;
            $success = true;
            $message = "Publication created successfully!<br><br>
                <strong>Application URL:</strong><br>
                <a href=\"{$applicationUrl}\" target=\"_blank\" class=\"text-primary\">{$applicationUrl}</a><br><br>
                <small class=\"text-muted\">Share this link to accept applications.</small>";
        }
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }

}

if (isset($_POST['delete-publication'])) {
    $publicationId = sanitize(decipher($_POST['verifier'] ?? null));
    $showAlert = true;

    if (empty($publicationId)) {
        $message = 'Invalid publication selected.';
        return;
    }

    $publication = publication($publicationId);
    $code = $publication['code'] ?? 'N/A';

    try {
        if (clearPublicationItems($publicationId) === false) {
            $message = 'Failed to delete vacancy publication items.';
            return;
        }

        if (deletePublication($publicationId) === false) {
            $message = 'Failed to delete vacancy publication.';
            return;
        }

        createSystemLog($stationId, $userId, 'Deleted publication', $code, clientIp());
        commit();

        $message = "Publication [$code] has been deleted successfully.";
        $success = true;
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

if (isset($_POST['save-publication'])) {
    $publicationId = sanitize(decipher($_POST['verifier'] ?? null));
    $code = $statusMessage = null;
    $showAlert = true;
    $title = sanitize($_POST['pub_title'] ?? null);
    $description = sanitize($_POST['pub_description'] ?? null);
    $openDate = sanitize($_POST['open_date'] ?? date('Y-m-d'));
    $closeDate = sanitize($_POST['close_date'] ?? date('Y-m-d', strtotime('+30 days')));
    $pubStatus = sanitize($_POST['pub_status'] ?? 'open');
    $vacancyIds = $_POST['vacancy_ids'] ?? [];

    if (empty($title)) {
        $message = 'Please enter a publication title.';
        return;
    }

    if (empty($vacancyIds)) {
        $message = 'Please select at least one vacancy to publish.';
        return;
    }

    if (strtotime($closeDate) < strtotime($openDate)) {
        $message = 'Closing date cannot be before opening date.';
        return;
    }

    beginTransaction();

    try {
        if (!empty($publicationId)) {
            clearPublicationItems($publicationId);
        }

        if (empty($publicationId)) {
            $code = generatePublicationCode();
            $publicationId = createPublication($code, $title, $description, $openDate, $closeDate, $pubStatus);
            $statusMessage = 'create';
        } else {
            $code = publication($publicationId)['code'];
            updatePublication($publicationId, $title, $description, $openDate, $closeDate, $pubStatus);
            $statusMessage = 'update';
        }

        $totalVacanciesLinked = 0;
        foreach ($vacancyIds as $vacancyId) {
            addPublicationItem($publicationId, $vacancyId);
            $totalVacanciesLinked++;
        }

        createSystemLog($stationId, $userId, "{$statusMessage}d vacancy publication", "$code - $totalVacanciesLinked items linked", clientIp());
        commit();

        $applicationUrl = uri() . '/hrmis/apply?p=' . $code;
        $success = true;
        $message = "Publication has been successfully {$statusMessage}d!<br><br>
                <strong>Application URL:</strong><br>
                <a href=\"{$applicationUrl}\" target=\"_blank\" class=\"text-primary\">{$applicationUrl}</a><br><br>
                <small class=\"text-muted\">Share this link to accept applications.</small>";
    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

// if (isset($_POST['fill-vacancy'])) {
//     $vacancyId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
//     $employeeId = $_POST['employee_id'] ?? null;
//     $dateFilled = $_POST['date_filled'] ?? date('Y-m-d');
//     $showAlert = true;

//     if (empty($vacancyId)) {
//         $message = 'Invalid vacancy selected.';
//         $success = false;
//     } elseif (empty($employeeId)) {
//         $message = 'Please select an employee to fill the vacancy.';
//         $success = false;
//     } else {
//         $vacancy = fetchAssoc(vacancy($vacancyId));
//         $itemNumber = $vacancy['item_number'] ?? 'N/A';

//         $filledVacancy = fillVacancy($vacancyId);

//         if ($filledVacancy) {
//             $employee = employee($employeeId);
//             $employeeName = toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'], true);
//             $message = "Vacancy [$itemNumber] has been filled by $employeeName.";
//             createSystemLog('HRMPSB', $userId, 'Filled vacancy', "$itemNumber - $employeeName", clientIp());
//         } else {
//             $message = 'Vacancy was not filled successfully.';
//             $success = false;
//         }
//     }
// }