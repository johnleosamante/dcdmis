<?php
// pis/app.php
$activeApp = $_SESSION["{$prefix}activeApp"] = HOME;
$page = $appTitle = 'Personnel Information System';

if (!isset($userId)) {
    redirect("{$baseUri}/login");
}

if (isset($_SESSION["{$prefix}change_password"])) {
    redirect("{$baseUri}/login/change");
}

if (isset($_POST['primary-search-button'])) {
    redirect(customUri('pis', 'Search', sanitize($_POST['primary-search-text'])));
}

if (isset($_POST['update-identification'])) {
    $card = sanitize($_POST['card-type']);
    $number = sanitize($_POST['card-number']);
    $place = sanitize($_POST['card-place']);
    $date = sanitize($_POST['card-date']);
    $showAlert = true;
    $result = !employeeIdentification($userId) ?
        createIdentification($card, $number, $place, $date, $userId) :
        updateIdentification($card, $number, $place, $date, $userId);

    if ($result === false) {
        $success = false;
        $message = 'We encountered an error on our end. Please try again later.';
        return;
    }


    if ($result === 0) {
        $message = 'No changes have been made to government issued ID.';
    } else {
        $message = 'Government issued ID has been updated successfully.';
        $success = true;

        createSystemLog($stationId, $userId, 'Updated identification details', $userId, clientIp());
    }
}

if (isset($_POST['save-payslip'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $payslipId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $description = sanitize($_POST['description']);
    $oldFilename = sanitize(decipher($_POST['file-verifier'] ?? null));
    $showAlert = true;
    $stagedFile = null;

    try {
        if (empty($employeeId)) {
            throw new Exception('Invalid or expired transaction.');
        }

        if (!empty($_FILES['file-upload']['tmp_name']) && is_uploaded_file($_FILES['file-upload']['tmp_name'])) {
            $stagedFile = stageUploadedFile(
                $_FILES['file-upload'],
                ['application/pdf' => 'pdf'],
                root() . "/uploads/201_files/{$employeeId}",
                "PAYSLIP"
            );
        }

        beginTransaction();

        $newFilename = $stagedFile ? "uploads/201_files/{$employeeId}/{$stagedFile['secure_name']}" : $oldFilename;

        if (empty($newFilename)) {
            throw new Exception('No changes have been made to payslips.');
        }

        $ext = pathinfo($newFilename, PATHINFO_EXTENSION);
        $hasExistingRecord = fileAttachment($employeeId, $payslipId);

        if (!$hasExistingRecord) {
            $result = createFileAttachment(20, $description, $newFilename, $ext, $employeeId);
            $logMessage = 'Added payslip.';
        } else {
            $result = updateFileAttachment(20, $description, $newFilename, $ext, $employeeId, $payslipId);
            $logMessage = 'Updated payslip.';
        }

        if ($result === false) {
            throw new Exception('We encountered an error on our end. Please try again later.');
        }

        if ($stagedFile) {
            commitStagedFile($stagedFile);
        }

        commit();

        $success = true;
        $actionText = $hasExistingRecord ? 'updated' : 'added';
        $message = "Payslip has been {$actionText} successfully.";

        createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());

        if ($stagedFile && !empty($oldFilename) && file_exists(root() . "/{$oldFilename}")) {
            unlink(root() . "/{$oldFilename}");
        }
    } catch (Exception $e) {
        rollBack();

        if ($stagedFile && file_exists($stagedFile['full_path'])) {
            unlink($stagedFile['full_path']);
        }

        $success = false;
        $message = $e->getMessage();
    }
}

if (isset($_POST['delete-payslip'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $payslipId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $showAlert = true;
    $success = false;
    $file = fileAttachment($employeeId, $payslipId);

    if (!$file) {
        $message = 'The requested payslip file does not exist.';
        return;
    }

    $filename = $file['file_name'];
    $filePath = root() . "/{$filename}";

    if (file_exists($filePath)) {
        if (!unlink($filePath)) {
            $message = 'We encountered an error deleting the physical file. Please try again.';
            return;
        }
    }

    $result = deleteFileAttachment($employeeId, $payslipId);

    if ($result === false) {
        $message = 'We encountered an error updating the database. Please try again later.';
        return;
    }

    if ($result === 0) {
        $message = 'No changes have been made to the payslip database record.';
        return;
    }

    $success = true;
    $message = 'Payslip has been deleted successfully.';

    createSystemLog($stationId, $userId, 'Deleted employee payslip', $employeeId, clientIp());
}

if (isset($_POST['submit-transfer-request'])) {
    $targetStationId = sanitize($_POST['target-station']);
    $reason = sanitize($_POST['reason']);
    $showAlert = true;
    $success = false;
    $stagedFile = null;

    try {
        if (empty($targetStationId)) {
            throw new Exception('Please select a preferred station assignment.');
        }
        if (empty($reason)) {
            throw new Exception('Please state your reason for the transfer request.');
        }
        if (empty($_FILES['attachment']['tmp_name']) || !is_uploaded_file($_FILES['attachment']['tmp_name'])) {
            throw new Exception('Please upload a supporting document.');
        }

        $currStation = station($userId);
        $currentStationId = $currStation ? $currStation['station_id'] : '';

        if (empty($currentStationId)) {
            throw new Exception('Your current station assignment could not be resolved. Please contact HR.');
        }

        if ($currentStationId === $targetStationId) {
            throw new Exception('Your target station must be different from your current station.');
        }

        $isTeaching = false;
        if ($currStation) {
            $pos = positions($currStation['position_id']);
            if ($pos && $pos['category'] === 'Teaching') {
                $isTeaching = true;
            }
        }

        $specialization = null;
        if ($isTeaching) {
            $specialization = sanitize($_POST['specialization'] ?? '');
            if (empty($specialization)) {
                throw new Exception('Please fill up your major subject / area of specialization.');
            }
        }

        // Stage the uploaded file
        $stagedFile = stageUploadedFile(
            $_FILES['attachment'],
            [
                'application/pdf' => 'pdf',
            ],
            root() . "/uploads/transfer_requests/{$userId}",
            "TRANSFER"
        );

        beginTransaction();

        $attachmentPath = "uploads/transfer_requests/{$userId}/" . $stagedFile['secure_name'];
        $result = createTransferRequest($userId, $currentStationId, $targetStationId, $reason, $attachmentPath, $specialization);

        if ($result === false) {
            throw new Exception('We encountered an error saving your request. Please try again later.');
        }

        commitStagedFile($stagedFile);
        commit();

        $success = true;
        $message = 'Your transfer request has been submitted successfully.';
        createSystemLog($stationId, $userId, 'Submitted transfer request', $userId, clientIp());

    } catch (Exception $e) {
        rollBack();
        if ($stagedFile && file_exists($stagedFile['full_path'])) {
            unlink($stagedFile['full_path']);
        }
        $success = false;
        $message = $e->getMessage();
    }
}

if (isset($_POST['cancel-transfer-request'])) {
    $requestId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $showAlert = true;
    $success = false;

    try {
        if (empty($requestId)) {
            throw new Exception('Invalid transfer request selected.');
        }

        $request = getTransferRequest($requestId);
        if (!$request || $request['employee_id'] != $userId) {
            throw new Exception('The requested transfer request could not be found.');
        }

        if ($request['status'] !== 'Pending') {
            throw new Exception('Only pending transfer requests can be canceled.');
        }

        beginTransaction();

        $result = deleteTransferRequest($requestId, $userId);

        if ($result === false) {
            throw new Exception('We encountered an error canceling your request. Please try again later.');
        }

        commit();

        // Unlink attachment
        if (!empty($request['attachment_path']) && file_exists(root() . "/" . $request['attachment_path'])) {
            unlink(root() . "/" . $request['attachment_path']);
        }

        $success = true;
        $message = 'Your transfer request has been canceled successfully.';
        createSystemLog($stationId, $userId, 'Canceled transfer request', $userId, clientIp());

    } catch (Exception $e) {
        rollBack();
        $success = false;
        $message = $e->getMessage();
    }
}

// ========== IPCRF (Individual Performance Commitment and Review Form) ==========

// Create Rating Period (for ratee when no active cycle)
if (isset($_POST['create-rating-period'])) {
    $cycleTitle = sanitize($_POST['cycle_title'] ?? '');
    $cycleSchoolYear = sanitize($_POST['cycle_school_year'] ?? '');
    $showAlert = true;
    $success = false;

    try {
        if (empty($cycleTitle) || empty($cycleSchoolYear)) {
            throw new Exception('Title and School Year are required.');
        }

        // Derive start and end dates from school year (e.g. 2025-2026)
        $cycleDateStart = date('Y') . '-06-01';
        $cycleDateEnd = ((int) date('Y') + 1) . '-03-31';

        $years = explode('-', $cycleSchoolYear);
        if (count($years) === 2 && is_numeric($years[0]) && is_numeric($years[1])) {
            $startYear = (int) $years[0];
            $endYear = (int) $years[1];
            if ($endYear === $startYear + 1) {
                $cycleDateStart = $startYear . '-06-01';
                $cycleDateEnd = $endYear . '-03-31';
            }
        }

        createPmCycle($cycleTitle, $cycleSchoolYear, $cycleDateStart, $cycleDateEnd, $userId);

        $success = true;
        $message = 'Rating period has been created successfully.';
        createSystemLog($stationId, $userId, 'Created IPCRF rating period', null, clientIp());

    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}

// Create IPCRF with KRAs and Objectives
if (isset($_POST['create-ipcrf'])) {
    $employeeId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $cycleId = (int) sanitize(decipher($_POST['cycle-verifier'] ?? null));
    $validatorId = !empty($_POST['validator_id']) ? (int) sanitize($_POST['validator_id']) : null;
    $approvingOfficerId = !empty($_POST['approving_officer_id']) ? (int) sanitize($_POST['approving_officer_id']) : null;
    $positionTitle = sanitize($_POST['position_title'] ?? '');
    $reviewPeriod = sanitize($_POST['review_period'] ?? '');
    $kraIds = $_POST['kra_id'] ?? [];
    $kraTitles = $_POST['kra_title'] ?? [];
    $showAlert = true;
    $success = false;

    try {
        if (empty($employeeId) || empty($cycleId)) {
            throw new Exception('Invalid request parameters.');
        }

        if (empty($reviewPeriod)) {
            throw new Exception('Review Period is required.');
        }

        if (empty($kraTitles) || empty(array_filter($kraTitles))) {
            throw new Exception('Please define at least one Key Result Area.');
        }

        if (pmIpcrfByEmployee($employeeId, $cycleId)) {
            throw new Exception('You already have an IPCRF for this cycle.');
        }

        beginTransaction();

        $ipcrfId = createPmIpcrf($cycleId, $employeeId, $validatorId, $positionTitle, $reviewPeriod);
        if (!$ipcrfId) {
            throw new Exception('Failed to create IPCRF record.');
        }

        // Set approving officer if selected
        if ($approvingOfficerId) {
            updatePmIpcrfApprovingOfficer($ipcrfId, $approvingOfficerId);
        }

        // Process each KRA and its objectives
        // KRA indices in form are 1-based (kraCount starts at 1)
        $kraIndex = 0;
        foreach ($kraIds as $i => $kraId) {
            $kraIndex++;
            $kraId = (int) sanitize($kraId);
            $kraTitle = sanitize($kraTitles[$i] ?? '');
            
            // Allow custom KRAs (kra_id = 0) as long as title is provided
            if (empty($kraTitle)) continue;

            // Get objectives for this KRA - form uses 1-based kraCount
            $objectives = $_POST["objective_{$kraIndex}"] ?? [];
            $timelines = $_POST["timeline_{$kraIndex}"] ?? [];
            $objWeights = $_POST["obj_weight_{$kraIndex}"] ?? [];
            $performanceIndicators = $_POST["performance_indicator_{$kraIndex}"] ?? [];

            foreach ($objectives as $j => $objective) {
                $objective = sanitize($objective);
                $timeline = sanitize($timelines[$j] ?? '');
                $objWeight = (int) sanitize($objWeights[$j] ?? 0);
                $performanceIndicator = sanitize($performanceIndicators[$j] ?? '');

                if (empty($objective)) continue;

                $result = createPmObjective($ipcrfId, $kraId, $kraTitle, 0, $objective, $timeline, $objWeight, $performanceIndicator, '', '', '', '', $j + 1);
                if (!$result) {
                    throw new Exception('Failed to create objective.');
                }
            }
        }

        // Assign validator if provided
        if ($validatorId) {
            $existingAssignment = pmValidator($validatorId, $employeeId, $cycleId);
            if (!$existingAssignment) {
                assignPmValidator($validatorId, $employeeId, $cycleId);
            }
        }

        commit();

        $success = true;
        $message = 'IPCRF has been created successfully.';
        createSystemLog($stationId, $userId, 'Created IPCRF', $employeeId, clientIp());

        redirect(customUri('pis', 'IPCRF Details', $ipcrfId));

    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

// Save single objective
if (isset($_POST['save-objective'])) {
    $ipcrfId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $kraId = (int) sanitize($_POST['kra_id'] ?? 0);
    $kraTitle = sanitize($_POST['kra_title'] ?? '');
    $objective = sanitize($_POST['objective'] ?? '');
    $timeline = sanitize($_POST['timeline'] ?? '');
    $weight = (int) sanitize($_POST['weight'] ?? 0);
    $performanceIndicator = sanitize($_POST['performance_indicator'] ?? '');
    $showAlert = true;
    $success = false;

    try {
        if (empty($ipcrfId) || empty($kraTitle) || empty($objective)) {
            throw new Exception('Required fields are missing.');
        }

        $ipcrf = pmIpcrf($ipcrfId);
        if (!$ipcrf || (int) $ipcrf['employee_id'] !== $userId) {
            throw new Exception('Invalid request.');
        }

        if ($ipcrf['status'] !== 'Draft' && $ipcrf['status'] !== 'Returned') {
            throw new Exception('Cannot add objectives to a submitted IPCRF.');
        }

        $existingCount = count(pmObjectives($ipcrfId));
        $result = createPmObjective($ipcrfId, $kraId, $kraTitle, 0, $objective, $timeline, $weight, $performanceIndicator, '', '', '', '', $existingCount + 1);

        if (!$result) {
            throw new Exception('Failed to save objective.');
        }

        $success = true;
        $message = 'Objective has been added successfully.';
        createSystemLog($stationId, $userId, 'Added IPCRF objective', $userId, clientIp());

    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}

// Edit objective
if (isset($_POST['edit-objective'])) {
    $objectiveId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $kraId = (int) sanitize($_POST['kra_id'] ?? 0);
    $kraTitle = sanitize($_POST['kra_title'] ?? '');
    $objective = sanitize($_POST['objective'] ?? '');
    $timeline = sanitize($_POST['timeline'] ?? '');
    $weight = (int) sanitize($_POST['weight'] ?? 0);
    $performanceIndicator = sanitize($_POST['performance_indicator'] ?? '');
    $showAlert = true;
    $success = false;

    try {
        if (empty($objectiveId) || empty($kraTitle) || empty($objective)) {
            throw new Exception('Required fields are missing.');
        }

        $obj = pmObjective($objectiveId);
        if (!$obj) {
            throw new Exception('Objective not found.');
        }

        $ipcrf = pmIpcrf((int) $obj['ipcrf_id']);
        if (!$ipcrf || (int) $ipcrf['employee_id'] !== $userId) {
            throw new Exception('Unauthorized.');
        }

        if ($ipcrf['status'] !== 'Draft' && $ipcrf['status'] !== 'Returned') {
            throw new Exception('Cannot edit objectives from a submitted IPCRF.');
        }

        $result = updatePmObjective($objectiveId, $kraId, $kraTitle, $objective, $timeline, $weight, $performanceIndicator);
        if (!$result) {
            throw new Exception('Failed to update objective.');
        }

        $success = true;
        $message = 'Objective has been updated successfully.';
        createSystemLog($stationId, $userId, 'Edited IPCRF objective', $userId, clientIp());

    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}

// Delete objective
if (isset($_POST['delete-objective'])) {
    $ipcrfId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $objectiveId = (int) sanitize(decipher($_POST['objective-verifier'] ?? null));
    $showAlert = true;
    $success = false;

    try {
        if (empty($ipcrfId) || empty($objectiveId)) {
            throw new Exception('Invalid request.');
        }

        $obj = pmObjective($objectiveId);
        if (!$obj || (int) $obj['ipcrf_id'] !== $ipcrfId) {
            throw new Exception('Objective not found.');
        }

        $ipcrf = pmIpcrf($ipcrfId);
        if (!$ipcrf || (int) $ipcrf['employee_id'] !== $userId) {
            throw new Exception('Unauthorized.');
        }

        if ($ipcrf['status'] !== 'Draft' && $ipcrf['status'] !== 'Returned') {
            throw new Exception('Cannot delete objectives from a submitted IPCRF.');
        }

        $result = deletePmObjective($objectiveId);
        if (!$result) {
            throw new Exception('Failed to delete objective.');
        }

        $success = true;
        $message = 'Objective has been deleted.';
        createSystemLog($stationId, $userId, 'Deleted IPCRF objective', $userId, clientIp());

    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}

// Submit IPCRF for validation
if (isset($_POST['submit-ipcrf'])) {
    $ipcrfId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $remarks = sanitize($_POST['ratee_remarks'] ?? '');
    $showAlert = true;
    $success = false;

    try {
        $ipcrf = pmIpcrf($ipcrfId);
        if (!$ipcrf || (int) $ipcrf['employee_id'] !== $userId) {
            throw new Exception('Invalid request.');
        }

        if ($ipcrf['status'] !== 'Draft' && $ipcrf['status'] !== 'Returned') {
            throw new Exception('This IPCRF cannot be submitted.');
        }

        $objectives = pmObjectives($ipcrfId);
        if (empty($objectives)) {
            throw new Exception('Cannot submit an IPCRF without objectives.');
        }

        $result = updatePmIpcrfStatus($ipcrfId, 'Submitted', $remarks, 'ratee_remarks');
        if ($result === false) {
            throw new Exception('Failed to submit IPCRF.');
        }

        $success = true;
        $message = 'IPCRF has been submitted for validation.';
        createSystemLog($stationId, $userId, 'Submitted IPCRF for validation', $userId, clientIp());

    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}

// Update Approving Officer
if (isset($_POST['update-approving-officer'])) {
    $ipcrfId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $approvingOfficerId = (int) sanitize(decipher($_POST['approving_officer_id'] ?? null));
    $showAlert = true;
    $success = false;

    try {
        $ipcrf = pmIpcrf($ipcrfId);
        if (!$ipcrf || (int) $ipcrf['employee_id'] !== $userId) {
            throw new Exception('Invalid request.');
        }

        $allowedStatuses = ['Draft', 'Returned', 'Submitted', 'Approved'];
        if (!in_array($ipcrf['status'], $allowedStatuses)) {
            throw new Exception('Approving authority can only be changed before validation.');
        }

        if (!$approvingOfficerId) {
            throw new Exception('Please select an approving authority.');
        }

        updatePmIpcrfApprovingOfficer($ipcrfId, $approvingOfficerId);

        $success = true;
        $message = 'Approving authority has been updated.';
        createSystemLog($stationId, $userId, 'Updated IPCRF approving authority', $userId, clientIp());

    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}

// Save actual results and ratings (Phase 2)
if (isset($_POST['save-actual-results'])) {
    $ipcrfId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $objIds = $_POST['obj_id'] ?? [];
    $actualResults = $_POST['actual_result'] ?? [];
    $ratingQs = $_POST['rating_q'] ?? [];
    $ratingEs = $_POST['rating_e'] ?? [];
    $ratingTs = $_POST['rating_t'] ?? [];
    $averageRatings = $_POST['average_rating'] ?? [];
    $scores = $_POST['score'] ?? [];
    $showAlert = true;
    $success = false;

    try {
        $ipcrf = pmIpcrf($ipcrfId);
        if (!$ipcrf || (int) $ipcrf['employee_id'] !== $userId) {
            throw new Exception('Unauthorized.');
        }

        beginTransaction();

        foreach ($objIds as $i => $encId) {
            $objId = (int) sanitize(decipher($encId));
            $obj = pmObjective($objId);
            if (!$obj || (int) $obj['ipcrf_id'] !== $ipcrfId) {
                throw new Exception('Invalid objective.');
            }

            $result = sanitize($actualResults[$i] ?? '');
            $q = sanitize($ratingQs[$i] ?? '');
            $e2 = sanitize($ratingEs[$i] ?? '');
            $t = sanitize($ratingTs[$i] ?? '');
            $avg = sanitize($averageRatings[$i] ?? '');
            $score = sanitize($scores[$i] ?? '');

            $qVal = $q !== '' ? (float) $q : null;
            $eVal = $e2 !== '' ? (float) $e2 : null;
            $tVal = $t !== '' ? (float) $t : null;

            if ($avg !== '') {
                $avgVal = (float) $avg;
            } elseif ($qVal !== null && $eVal !== null && $tVal !== null) {
                $avgVal = round(($qVal + $eVal + $tVal) / 3, 2);
            } else {
                $avgVal = null;
            }

            if ($score !== '') {
                $scoreVal = (float) $score;
            } elseif ($avgVal !== null && $obj['weight']) {
                $scoreVal = round($avgVal * ((float) $obj['weight'] / 100), 2);
            } else {
                $scoreVal = null;
            }

            updatePmObjectivePhase2($objId, $result, $qVal, $eVal, $tVal, $avgVal, $scoreVal);
        }

        commit();

        $success = true;
        $message = 'Phase 2 updates have been saved successfully.';
        createSystemLog($stationId, $userId, 'Updated IPCRF Phase 2 results', $userId, clientIp());

    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

// Save ratings (Validator)
if (isset($_POST['save-ratings'])) {
    $ipcrfId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $validatorRemarks = sanitize($_POST['validator_remarks'] ?? '');
    $objIds = $_POST['obj_id'] ?? [];
    $ratingsQ = $_POST['rating_q'] ?? [];
    $ratingsE = $_POST['rating_e'] ?? [];
    $ratingsT = $_POST['rating_t'] ?? [];
    $objRemarks = $_POST['obj_remarks'] ?? [];
    $showAlert = true;
    $success = false;

    try {
        $ipcrf = pmIpcrf($ipcrfId);
        if (!$ipcrf || (int) $ipcrf['validator_id'] !== $userId) {
            throw new Exception('Unauthorized.');
        }

        beginTransaction();

        foreach ($objIds as $i => $encId) {
            $objId = (int) sanitize(decipher($encId));
            $q = !empty($ratingsQ[$i]) ? (float) $ratingsQ[$i] : null;
            $e2 = !empty($ratingsE[$i]) ? (float) $ratingsE[$i] : null;
            $t = !empty($ratingsT[$i]) ? (float) $ratingsT[$i] : null;
            $rem = sanitize($objRemarks[$i] ?? '');

            if ($q !== null && $e2 !== null && $t !== null) {
                updatePmObjectiveRating($objId, $q, $e2, $t, $rem);
            }
        }

        if (!empty($validatorRemarks)) {
            update('pm_ipcrf', ['validator_remarks' => $validatorRemarks], '`id` = ?', [$ipcrfId]);
        }

        commit();

        $success = true;
        $message = 'Ratings have been saved successfully.';
        createSystemLog($stationId, $userId, 'Saved IPCRF ratings', $ipcrf['employee_id'], clientIp());

    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

// Validate IPCRF
if (isset($_POST['validate-ipcrf'])) {
    $ipcrfId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $validatorRemarks = sanitize($_POST['validator_remarks'] ?? '');
    $objIds = $_POST['obj_id'] ?? [];
    $ratingsQ = $_POST['rating_q'] ?? [];
    $ratingsE = $_POST['rating_e'] ?? [];
    $ratingsT = $_POST['rating_t'] ?? [];
    $objRemarks = $_POST['obj_remarks'] ?? [];
    $showAlert = true;
    $success = false;

    try {
        $ipcrf = pmIpcrf($ipcrfId);
        if (!$ipcrf || (int) $ipcrf['validator_id'] !== $userId) {
            throw new Exception('Unauthorized.');
        }

        if ($ipcrf['status'] !== 'Approved' && $ipcrf['status'] !== 'Submitted' && $ipcrf['status'] !== 'Validated') {
            throw new Exception('This IPCRF cannot be validated.');
        }

        beginTransaction();

        foreach ($objIds as $i => $encId) {
            $objId = (int) sanitize(decipher($encId));
            $q = !empty($ratingsQ[$i]) ? (float) $ratingsQ[$i] : null;
            $e2 = !empty($ratingsE[$i]) ? (float) $ratingsE[$i] : null;
            $t = !empty($ratingsT[$i]) ? (float) $ratingsT[$i] : null;
            $rem = sanitize($objRemarks[$i] ?? '');

            if ($q === null || $e2 === null || $t === null) {
                throw new Exception('All objectives must be rated (Q, E, T) before validation.');
            }

            updatePmObjectiveRating($objId, $q, $e2, $t, $rem);
        }

        $finalRating = pmComputeFinalRating($ipcrfId);
        $adjectival = pmAdjectivalRating($finalRating);

        updatePmIpcrfFinalRating($ipcrfId, $finalRating, $adjectival);
        updatePmIpcrfStatus($ipcrfId, 'Validated', $validatorRemarks, 'validator_remarks');
        updatePmIpcrfPhase($ipcrfId, 4);

        commit();

        $success = true;
        $message = "IPCRF has been validated and is now in Phase 4. Final Rating: {$finalRating} ({$adjectival}).";
        createSystemLog($stationId, $userId, 'Validated IPCRF', $ipcrf['employee_id'], clientIp());

    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

// Return IPCRF to ratee
if (isset($_POST['return-ipcrf'])) {
    $ipcrfId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $validatorRemarks = sanitize($_POST['validator_remarks'] ?? '');
    $showAlert = true;
    $success = false;

    try {
        $ipcrf = pmIpcrf($ipcrfId);
        if (!$ipcrf || (int) $ipcrf['validator_id'] !== $userId) {
            throw new Exception('Unauthorized.');
        }

        if (empty($validatorRemarks)) {
            throw new Exception('Please enter your remarks before returning this IPCRF.');
        }

        $result = updatePmIpcrfStatus($ipcrfId, 'Returned', $validatorRemarks, 'validator_remarks');
        if ($result === false) {
            throw new Exception('Failed to return IPCRF.');
        }

        $success = true;
        $message = 'IPCRF has been returned to the ratee for revision.';
        createSystemLog($stationId, $userId, 'Returned IPCRF to ratee', $ipcrf['employee_id'], clientIp());

    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}

// Approve IPCRF (Rater approves commitment or rating)
if (isset($_POST['approve-ipcrf'])) {
    $ipcrfId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $validatorRemarks = sanitize($_POST['validator_remarks'] ?? '');
    $showAlert = true;
    $success = false;

    try {
        $ipcrf = pmIpcrf($ipcrfId);
        if (!$ipcrf || (int) $ipcrf['validator_id'] !== $userId) {
            throw new Exception('Unauthorized.');
        }

        $currentPhase = (int) $ipcrf['phase'];

        // Phase 1: Approve commitment -> Phase 2
        if ($currentPhase === 1) {
            if ($ipcrf['status'] !== 'Submitted') {
                throw new Exception('This IPCRF cannot be approved.');
            }

            beginTransaction();
            updatePmIpcrfStatus($ipcrfId, 'Approved', $validatorRemarks, 'validator_remarks');
            updatePmIpcrfPhase($ipcrfId, 2);
            commit();

            $success = true;
            $message = 'IPCRF commitment has been approved and moved to Phase 2 (Monitoring).';
            createSystemLog($stationId, $userId, 'Approved IPCRF commitment', $ipcrf['employee_id'], clientIp());
        }
        // Phase 3: Approve rating -> Phase 4
        elseif ($currentPhase === 3) {
            if ($ipcrf['status'] !== 'Validated' && $ipcrf['status'] !== 'Submitted') {
                throw new Exception('This IPCRF rating cannot be approved.');
            }

            beginTransaction();
            updatePmIpcrfStatus($ipcrfId, 'Completed', $validatorRemarks, 'validator_remarks');
            updatePmIpcrfPhase($ipcrfId, 4);
            commit();

            $success = true;
            $message = 'IPCRF rating has been approved and moved to Phase 4 (Rewarding and Development Planning).';
            createSystemLog($stationId, $userId, 'Approved IPCRF rating', $ipcrf['employee_id'], clientIp());
        }
        else {
            throw new Exception('This IPCRF cannot be approved at this phase.');
        }

    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

// Upload MOV
if (isset($_POST['upload-mov'])) {
    $ipcrfId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $objectiveId = (int) sanitize(decipher($_POST['objective_id'] ?? null));
    $description = sanitize($_POST['description'] ?? '');
    $showAlert = true;
    $success = false;

    try {
        $ipcrf = pmIpcrf($ipcrfId);
        if (!$ipcrf || (int) $ipcrf['employee_id'] !== $userId) {
            throw new Exception('Unauthorized.');
        }

        if (!isset($_FILES['mov_file']) || $_FILES['mov_file']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Please select a file to upload.');
        }

        $file = $_FILES['mov_file'];
        $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'image/jpeg', 'image/png'];
        $maxSize = FILE_UPLOAD_SIZE_LIMIT;

        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception('Invalid file type. Allowed: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG.');
        }

        if ($file['size'] > $maxSize) {
            throw new Exception('File size exceeds ' . UPLOAD_MAX_FILESIZE . 'B limit.');
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newFileName = 'mov_' . $ipcrfId . '_' . $objectiveId . '_' . time() . '.' . $ext;
        $uploadDir = root() . '/uploads/mov/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (!move_uploaded_file($file['tmp_name'], $uploadDir . $newFileName)) {
            throw new Exception('Failed to upload file.');
        }

        $result = createPmMov($objectiveId, $ipcrfId, $newFileName, $file['name'], $file['type'], $file['size'], $description, $userId);
        if (!$result) {
            unlink($uploadDir . $newFileName);
            throw new Exception('Failed to save MOV record.');
        }

        $success = true;
        $message = 'Means of Verification uploaded successfully.';
        createSystemLog($stationId, $userId, 'Uploaded IPCRF MOV', $userId, clientIp());

    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}

// Delete MOV
if (isset($_POST['delete-mov'])) {
    $ipcrfId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $movId = (int) sanitize(decipher($_POST['mov-verifier'] ?? null));
    $showAlert = true;
    $success = false;

    try {
        $ipcrf = pmIpcrf($ipcrfId);
        if (!$ipcrf || (int) $ipcrf['employee_id'] !== $userId) {
            throw new Exception('Unauthorized.');
        }

        $mov = pmMov($movId);
        if (!$mov || (int) $mov['ipcrf_id'] !== $ipcrfId) {
            throw new Exception('MOV not found.');
        }

        $filePath = root() . '/uploads/mov/' . $mov['file_name'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        deletePmMov($movId);

        $success = true;
        $message = 'MOV has been deleted.';
        createSystemLog($stationId, $userId, 'Deleted IPCRF MOV', $userId, clientIp());

    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}

// Add Coaching Entry
if (isset($_POST['add-coaching'])) {
    $ipcrfId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $objectiveId = (int) sanitize(decipher($_POST['objective_id'] ?? null));
    $coachingDate = sanitize($_POST['coaching_date'] ?? '');
    $incident = sanitize($_POST['incident'] ?? '');
    $feedback = sanitize($_POST['feedback'] ?? '');
    $actionAgreed = sanitize($_POST['action_agreed'] ?? '');
    $showAlert = true;
    $success = false;

    try {
        $ipcrf = pmIpcrf($ipcrfId);
        if (!$ipcrf) {
            throw new Exception('IPCRF not found.');
        }

        $isValidator = ($userId === (int) $ipcrf['validator_id']);

        if (!$isValidator) {
            throw new Exception('Unauthorized. Only the rater can add coaching entries.');
        }

        if ($ipcrf['phase'] < 2) {
            throw new Exception('Coaching entries can only be added starting Phase 2.');
        }

        $obj = pmObjective($objectiveId);
        if (!$obj || (int) $obj['ipcrf_id'] !== $ipcrfId) {
            throw new Exception('Invalid objective selected.');
        }

        if (empty($coachingDate) || empty($incident) || empty($feedback) || empty($actionAgreed)) {
            throw new Exception('All fields are required.');
        }

        createPmCoaching($ipcrfId, $objectiveId, $coachingDate, $incident, $feedback, $actionAgreed, null, null, $userId);

        $success = true;
        $message = 'Coaching entry has been added successfully.';
        createSystemLog($stationId, $userId, 'Added IPCRF coaching entry', $ipcrf['employee_id'], clientIp());

    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}

// Edit Coaching Entry
if (isset($_POST['edit-coaching'])) {
    $ipcrfId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $coachingId = (int) sanitize(decipher($_POST['coaching_id'] ?? null));
    $coachingDate = sanitize($_POST['coaching_date'] ?? '');
    $incident = sanitize($_POST['incident'] ?? '');
    $feedback = sanitize($_POST['feedback'] ?? '');
    $actionAgreed = sanitize($_POST['action_agreed'] ?? '');
    $showAlert = true;
    $success = false;

    try {
        $ipcrf = pmIpcrf($ipcrfId);
        if (!$ipcrf) {
            throw new Exception('IPCRF not found.');
        }

        $isOwner = ($userId === (int) $ipcrf['employee_id']);
        $isValidator = ($userId === (int) $ipcrf['validator_id']);

        if (!$isOwner && !$isValidator) {
            throw new Exception('Unauthorized.');
        }

        $coaching = pmCoachingEntry($coachingId);
        if (!$coaching || (int) $coaching['ipcrf_id'] !== $ipcrfId) {
            throw new Exception('Coaching entry not found.');
        }

        if (empty($coachingDate) || empty($incident) || empty($feedback) || empty($actionAgreed)) {
            throw new Exception('All fields are required.');
        }

        updatePmCoaching($coachingId, $coachingDate, $incident, $feedback, $actionAgreed);

        $success = true;
        $message = 'Coaching entry has been updated successfully.';
        createSystemLog($stationId, $userId, 'Updated IPCRF coaching entry', $ipcrf['employee_id'], clientIp());

    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}

// Delete Coaching Entry
if (isset($_POST['delete-coaching'])) {
    $ipcrfId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $coachingId = (int) sanitize(decipher($_POST['coaching_id'] ?? null));
    $showAlert = true;
    $success = false;

    try {
        $ipcrf = pmIpcrf($ipcrfId);
        if (!$ipcrf) {
            throw new Exception('IPCRF not found.');
        }

        $isOwner = ($userId === (int) $ipcrf['employee_id']);
        $isValidator = ($userId === (int) $ipcrf['validator_id']);

        if (!$isOwner && !$isValidator) {
            throw new Exception('Unauthorized.');
        }

        $coaching = pmCoachingEntry($coachingId);
        if (!$coaching || (int) $coaching['ipcrf_id'] !== $ipcrfId) {
            throw new Exception('Coaching entry not found.');
        }

        deletePmCoaching($coachingId);

        $success = true;
        $message = 'Coaching entry has been deleted.';
        createSystemLog($stationId, $userId, 'Deleted IPCRF coaching entry', $ipcrf['employee_id'], clientIp());

    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}

// Save Competency Ratings (Phase 4)
if (isset($_POST['save-competencies'])) {
    $ipcrfId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $competencies = $_POST['competency'] ?? [];
    $showAlert = true;
    $success = false;

    try {
        $ipcrf = pmIpcrf($ipcrfId);
        if (!$ipcrf) {
            throw new Exception('IPCRF not found.');
        }

        $isOwner = ($userId === (int) $ipcrf['employee_id']);
        $isValidator = ($userId === (int) $ipcrf['validator_id']);

        if (!$isOwner && !$isValidator) {
            throw new Exception('Unauthorized.');
        }

        if ($ipcrf['phase'] < 4) {
            throw new Exception('Competency ratings can only be saved during Phase 4.');
        }

        beginTransaction();

        foreach ($competencies as $category => $subcategories) {
            foreach ($subcategories as $subKey => $items) {
                foreach ($items as $num => $rating) {
                    if (!empty($rating)) {
                        $rating = (int) $rating;
                        if ($rating < 1 || $rating > 5) {
                            throw new Exception('Rating must be between 1 and 5.');
                        }
                        $competencyNumber = $subKey . '_' . $num;
                        upsertPmCompetencyRating($ipcrfId, $category, $competencyNumber, $rating);
                    }
                }
            }
        }

        commit();

        $success = true;
        $message = 'Competency ratings have been saved successfully.';
        createSystemLog($stationId, $userId, 'Saved IPCRF competency ratings', $ipcrf['employee_id'], clientIp());

    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

// Add Development Plan (Phase 4)
if (isset($_POST['add-plan'])) {
    $ipcrfId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $strengths = sanitize($_POST['strengths'] ?? '');
    $developmentNeeds = sanitize($_POST['development_needs'] ?? '');
    $actionPlan = sanitize($_POST['action_plan'] ?? '');
    $timeline = sanitize($_POST['timeline'] ?? '');
    $resources = sanitize($_POST['resources'] ?? '');
    $showAlert = true;
    $success = false;

    try {
        $ipcrf = pmIpcrf($ipcrfId);
        if (!$ipcrf) {
            throw new Exception('IPCRF not found.');
        }

        $isOwner = ($userId === (int) $ipcrf['employee_id']);
        $isValidator = ($userId === (int) $ipcrf['validator_id']);

        if (!$isOwner && !$isValidator) {
            throw new Exception('Unauthorized.');
        }

        if ($ipcrf['phase'] < 4) {
            throw new Exception('Development plans can only be added during Phase 4.');
        }

        if (empty($strengths) || empty($developmentNeeds) || empty($actionPlan) || empty($timeline) || empty($resources)) {
            throw new Exception('All fields are required.');
        }

        createPmDevelopmentPlan($ipcrfId, $strengths, $developmentNeeds, $actionPlan, $timeline, $resources);

        $success = true;
        $message = 'Development plan has been added successfully.';
        createSystemLog($stationId, $userId, 'Added IPCRF development plan', $ipcrf['employee_id'], clientIp());

    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}

// Edit Development Plan (Phase 4)
if (isset($_POST['edit-plan'])) {
    $ipcrfId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $planId = (int) sanitize(decipher($_POST['plan_id'] ?? null));
    $strengths = sanitize($_POST['strengths'] ?? '');
    $developmentNeeds = sanitize($_POST['development_needs'] ?? '');
    $actionPlan = sanitize($_POST['action_plan'] ?? '');
    $timeline = sanitize($_POST['timeline'] ?? '');
    $resources = sanitize($_POST['resources'] ?? '');
    $showAlert = true;
    $success = false;

    try {
        $ipcrf = pmIpcrf($ipcrfId);
        if (!$ipcrf) {
            throw new Exception('IPCRF not found.');
        }

        $isOwner = ($userId === (int) $ipcrf['employee_id']);
        $isValidator = ($userId === (int) $ipcrf['validator_id']);

        if (!$isOwner && !$isValidator) {
            throw new Exception('Unauthorized.');
        }

        $plan = pmDevelopmentPlan($planId);
        if (!$plan || (int) $plan['ipcrf_id'] !== $ipcrfId) {
            throw new Exception('Development plan not found.');
        }

        if (empty($strengths) || empty($developmentNeeds) || empty($actionPlan) || empty($timeline) || empty($resources)) {
            throw new Exception('All fields are required.');
        }

        updatePmDevelopmentPlan($planId, $strengths, $developmentNeeds, $actionPlan, $timeline, $resources);

        $success = true;
        $message = 'Development plan has been updated successfully.';
        createSystemLog($stationId, $userId, 'Updated IPCRF development plan', $ipcrf['employee_id'], clientIp());

    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}

// Delete Development Plan (Phase 4)
if (isset($_POST['delete-plan'])) {
    $ipcrfId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $planId = (int) sanitize(decipher($_POST['plan_id'] ?? null));
    $showAlert = true;
    $success = false;

    try {
        $ipcrf = pmIpcrf($ipcrfId);
        if (!$ipcrf) {
            throw new Exception('IPCRF not found.');
        }

        $isOwner = ($userId === (int) $ipcrf['employee_id']);
        $isValidator = ($userId === (int) $ipcrf['validator_id']);

        if (!$isOwner && !$isValidator) {
            throw new Exception('Unauthorized.');
        }

        $plan = pmDevelopmentPlan($planId);
        if (!$plan || (int) $plan['ipcrf_id'] !== $ipcrfId) {
            throw new Exception('Development plan not found.');
        }

        deletePmDevelopmentPlan($planId);

        $success = true;
        $message = 'Development plan has been deleted.';
        createSystemLog($stationId, $userId, 'Deleted IPCRF development plan', $ipcrf['employee_id'], clientIp());

    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}

// Add Recalibration Entry (Phases 2 & 3)
if (isset($_POST['add-recalibration'])) {
    $ipcrfId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $ipcrfContent = sanitize($_POST['ipcrf_content'] ?? '');
    $proposedAmendment = sanitize($_POST['proposed_amendment'] ?? '');
    $justification = sanitize($_POST['justification'] ?? '');
    $showAlert = true;
    $success = false;

    try {
        $ipcrf = pmIpcrf($ipcrfId);
        if (!$ipcrf) {
            throw new Exception('IPCRF not found.');
        }

        $isOwner = ($userId === (int) $ipcrf['employee_id']);

        if (!$isOwner) {
            throw new Exception('Unauthorized.');
        }

        if ($ipcrf['phase'] < 2 || $ipcrf['phase'] > 3) {
            throw new Exception('Recalibration is only allowed in Phase 2 and Phase 3.');
        }

        if (empty($ipcrfContent) || empty($proposedAmendment) || empty($justification)) {
            throw new Exception('All fields are required.');
        }

        createPmRecalibration($ipcrfId, $ipcrfContent, $proposedAmendment, $justification, $userId);

        $success = true;
        $message = 'Recalibration entry has been added.';
        createSystemLog($stationId, $userId, 'Added IPCRF recalibration entry', $ipcrf['employee_id'], clientIp());

    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}

// Update Rater Remarks on Recalibration Entry
if (isset($_POST['update-recalibration-rater'])) {
    $ipcrfId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $recalibrationId = (int) sanitize(decipher($_POST['recalibration_id'] ?? null));
    $raterStatus = sanitize($_POST['rater_status'] ?? 'Pending');
    $raterRemarks = sanitize($_POST['rater_remarks'] ?? '');
    $showAlert = true;
    $success = false;

    try {
        $ipcrf = pmIpcrf($ipcrfId);
        if (!$ipcrf) {
            throw new Exception('IPCRF not found.');
        }

        $isValidator = ($userId === (int) $ipcrf['validator_id']);

        if (!$isValidator) {
            throw new Exception('Unauthorized.');
        }

        if ($ipcrf['phase'] < 2 || $ipcrf['phase'] > 3) {
            throw new Exception('Recalibration is only allowed in Phase 2 and Phase 3.');
        }

        $entry = pmRecalibration($recalibrationId);
        if (!$entry || (int) $entry['ipcrf_id'] !== $ipcrfId) {
            throw new Exception('Recalibration entry not found.');
        }

        if (!in_array($raterStatus, ['Pending', 'Approved', 'Disapproved'])) {
            throw new Exception('Invalid rater status.');
        }

        updatePmRecalibrationRater($recalibrationId, $raterStatus, $raterRemarks);

        $success = true;
        $message = 'Rater remarks have been updated.';
        createSystemLog($stationId, $userId, 'Updated IPCRF recalibration rater remarks', $ipcrf['employee_id'], clientIp());

    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}