<?php
// primedx/app.php
$activeApp = $_SESSION["{$prefix}activeApp"] = 'primedx';
$page = $appTitle = 'PRIME-DX';
$showAlert = false;
$message = '';
$success = false;

if (!isset($userId)) {
    redirect("{$baseUri}/login");
}

if (isset($_SESSION["{$prefix}change_password"])) {
    redirect("{$baseUri}/login/change");
}

$canManageCfs = canManageCallForSubmissions($userId, $stationId, $code);
$schoolInfo = schoolByHead($userId, DIVISION_ID);
$isSchoolHead = (bool) $schoolInfo;

if (!$canManageCfs && !$isSchoolHead) {
    redirect("{$baseUri}/" . HOME);
}

// ========== CALL FOR SUBMISSIONS ==========

if (isset($_POST['save-call-for-submission'])) {
    $cfsId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $title = sanitize($_POST['title'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $schoolYear = sanitize($_POST['school_year'] ?? '');
    $dueDate = sanitize($_POST['due_date'] ?? '');
    $showAlert = true;
    $success = false;

    try {
        if (!$canManageCfs) {
            throw new Exception('Unauthorized. Only ASDS section users can manage calls for submission.');
        }

        if (empty($title)) {
            throw new Exception('Title is required.');
        }

        if (mb_strlen($title) > 255) {
            throw new Exception('Title must not exceed 255 characters.');
        }

        if (empty($schoolYear)) {
            throw new Exception('School Year is required.');
        }

        if (mb_strlen($schoolYear) > 30) {
            throw new Exception('School Year must not exceed 30 characters.');
        }

        if ($description !== null && mb_strlen($description) > 255) {
            throw new Exception('Description must not exceed 255 characters.');
        }

        if (!empty($dueDate) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dueDate)) {
            throw new Exception('Invalid due date format.');
        }

        $existing = $cfsId > 0 ? callForSubmission($cfsId) : false;

        if ($existing) {
            $result = updateCallForSubmission($cfsId, $title, $description ?? '', $schoolYear, $dueDate, $userId);
            if ($result === false) {
                throw new Exception('We encountered an error updating the call for submission. Please try again later.');
            }
            $success = true;
            $message = 'Call for submission has been updated successfully.';
            createSystemLog($stationId, $userId, 'Updated call for submission', $cfsId, clientIp());
        } else {
            $newId = createCallForSubmission($title, $description ?? '', $schoolYear, $dueDate, $userId);
            if (!$newId) {
                throw new Exception('We encountered an error creating the call for submission. Please try again later.');
            }
            $success = true;
            $message = 'Call for submission has been created successfully.';
            createSystemLog($stationId, $userId, 'Created call for submission', $newId, clientIp());
        }
    } catch (Exception $e) {
        $success = false;
        $message = $e->getMessage();
    }
}

if (isset($_POST['close-call-for-submission'])) {
    $cfsId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $showAlert = true;
    $success = false;

    try {
        if (!$canManageCfs) {
            throw new Exception('Unauthorized. Only ASDS section users can close calls for submission.');
        }

        $cfs = callForSubmission($cfsId);
        if (!$cfs) {
            throw new Exception('Call for submission not found.');
        }

        $result = closeCallForSubmission($cfsId, $userId);
        if ($result === false) {
            throw new Exception('Failed to close call for submission. Please try again later.');
        }

        $success = true;
        $message = 'Call for submission has been closed successfully.';
        createSystemLog($stationId, $userId, 'Closed call for submission', $cfsId, clientIp());
    } catch (Exception $e) {
        $success = false;
        $message = $e->getMessage();
    }
}

if (isset($_POST['reopen-call-for-submission'])) {
    $cfsId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $showAlert = true;
    $success = false;

    try {
        if (!$canManageCfs) {
            throw new Exception('Unauthorized. Only ASDS section users can reopen calls for submission.');
        }

        $cfs = callForSubmission($cfsId);
        if (!$cfs) {
            throw new Exception('Call for submission not found.');
        }

        $result = reopenCallForSubmission($cfsId, $userId);
        if ($result === false) {
            throw new Exception('Failed to reopen call for submission. Please try again later.');
        }

        $success = true;
        $message = 'Call for submission has been reopened successfully.';
        createSystemLog($stationId, $userId, 'Reopened call for submission', $cfsId, clientIp());
    } catch (Exception $e) {
        $success = false;
        $message = $e->getMessage();
    }
}

if (isset($_POST['delete-call-for-submission'])) {
    $cfsId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $showAlert = true;
    $success = false;

    try {
        if (!$canManageCfs) {
            throw new Exception('Unauthorized. Only ASDS section users can delete calls for submission.');
        }

        $cfs = callForSubmission($cfsId);
        if (!$cfs) {
            throw new Exception('Call for submission not found.');
        }

        $filesToDelete = [];
        $submissions = callSubmissions($cfsId);

        beginTransaction();

        foreach ($submissions as $sub) {
            $subId = (int) $sub['id'];
            $attachments = callSubmissionAttachments($subId);
            foreach ($attachments as $att) {
                if (!empty($att['file_name'])) {
                    $filesToDelete[] = root() . '/' . ltrim($att['file_name'], '/\\');
                }
            }
            deleteAllCallSubmissionAttachments($subId);
            deleteAllCallSubmissionProjects($subId);
            deleteCallSubmission($subId);
        }

        $deleted = deleteCallForSubmission($cfsId);
        if ($deleted === false) {
            throw new Exception('Failed to delete call for submission. Please try again later.');
        }

        commit();

        foreach ($filesToDelete as $filePath) {
            if (file_exists($filePath) && is_file($filePath)) {
                unlink($filePath);
            }
        }

        $success = true;
        $message = 'Call for submission and all associated submissions have been deleted successfully.';
        createSystemLog($stationId, $userId, 'Deleted call for submission', $cfsId, clientIp());
    } catch (Exception $e) {
        rollBack();
        $success = false;
        $message = $e->getMessage();
    }
}

// ========== DOCUMENT ATTACHMENTS ==========

if (isset($_POST['save-document-file'])) {
    $cfsId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $attachmentTypeId = (int) sanitize($_POST['document-type'] ?? 0);
    $description = sanitize($_POST['description'] ?? '');
    $showAlert = true;
    $success = false;
    $committedFilePath = null;

    try {
        if (!$schoolInfo) {
            throw new Exception('Unauthorized. Only designated school heads can upload files.');
        }

        $cfs = callForSubmission($cfsId);
        if (!$cfs) {
            throw new Exception('Call for submission not found.');
        }

        if ((bool) $cfs['is_closed']) {
            throw new Exception('This call for submission is already closed. File uploads are no longer allowed.');
        }

        $attachmentType = submissionAttachmentType($attachmentTypeId);
        if (!$attachmentType) {
            throw new Exception('Please select a valid document type.');
        }

        if ($description !== null && mb_strlen($description) > 255) {
            throw new Exception('Description must not exceed 255 characters.');
        }

        if (!isset($_FILES['submission_file']) || ($_FILES['submission_file']['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            throw new Exception('Please select a file to upload.');
        }

        $allowedMimeMap = [
            'application/pdf' => 'pdf',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
        ];

        $schoolId = $schoolInfo['id'];
        $relativeDir = "uploads/call_submissions/{$cfsId}/{$schoolId}";
        $fullDir = root() . "/{$relativeDir}";

        $staged = stageUploadedFile($_FILES['submission_file'], $allowedMimeMap, $fullDir, "CFS_{$schoolId}");
        $relativePath = "{$relativeDir}/{$staged['secure_name']}";
        $originalName = sanitize(pathinfo($_FILES['submission_file']['name'] ?? 'file', PATHINFO_FILENAME)) ?? $staged['secure_name'];
        $fileDescription = ($description !== null && $description !== '') ? $description : $originalName;

        beginTransaction();

        $submission = callSubmissionBySchool($cfsId, $schoolId);
        if ($submission) {
            $submissionId = (int) $submission['id'];
            touchCallSubmission($submissionId);
        } else {
            $submissionId = (int) createCallSubmission($cfsId, $schoolId);
            if (!$submissionId) {
                throw new Exception('Failed to initialize submission record.');
            }
        }

        $attId = createCallSubmissionAttachment(
            $submissionId,
            $attachmentTypeId,
            $fileDescription,
            $relativePath,
            $staged['extension']
        );

        if (!$attId) {
            throw new Exception("Failed to save record for file: {$originalName}.");
        }

        commitStagedFile($staged);
        $committedFilePath = $staged['full_path'];

        commit();

        $success = true;
        $message = 'File has been uploaded successfully for ' . e($cfs['title']) . '.';
        createSystemLog($stationId, $userId, 'Uploaded call for submission file', $submissionId, clientIp());
    } catch (Exception $e) {
        rollBack();
        if ($committedFilePath && file_exists($committedFilePath) && is_file($committedFilePath)) {
            unlink($committedFilePath);
        }
        $success = false;
        $message = $e->getMessage();
    }
}

if (isset($_POST['delete-submission-attachment'])) {
    $attId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $showAlert = true;
    $success = false;

    try {
        if (!$schoolInfo) {
            throw new Exception('Unauthorized. Only designated school heads can delete uploaded files.');
        }

        $att = callSubmissionAttachment($attId);
        if (!$att) {
            throw new Exception('Attachment record not found.');
        }

        if ((string) $att['school_id'] !== (string) $schoolInfo['id']) {
            throw new Exception('Unauthorized. You can only delete files belonging to your school.');
        }

        if ((bool) $att['call_is_closed']) {
            throw new Exception('This call for submission is closed. Attachments can no longer be deleted.');
        }

        $submissionId = (int) $att['submission_id'];
        $filePath = !empty($att['file_name']) ? root() . '/' . ltrim($att['file_name'], '/\\') : null;

        beginTransaction();

        $deleted = deleteCallSubmissionAttachment($attId);
        if ($deleted === false) {
            throw new Exception('Failed to delete attachment record. Please try again later.');
        }

        if (countCallSubmissionAttachments($submissionId) === 0 && countCallSubmissionProjects($submissionId) === 0) {
            deleteCallSubmission($submissionId);
        } else {
            touchCallSubmission($submissionId);
        }

        commit();

        if ($filePath && file_exists($filePath) && is_file($filePath)) {
            unlink($filePath);
        }

        $success = true;
        $message = 'Attached file has been deleted successfully.';
        createSystemLog($stationId, $userId, 'Deleted call for submission attachment', $attId, clientIp());
    } catch (Exception $e) {
        rollBack();
        $success = false;
        $message = $e->getMessage();
    }
}

// ========== SUBMISSION PROJECTS (`call_submission_projects`) ==========

if (isset($_POST['save-submission-project'])) {
    $cfsId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $projectId = (int) sanitize(decipher($_POST['data-verifier'] ?? null));
    $agendaId = (int) sanitize($_POST['agenda_id'] ?? 0);
    $title = sanitize($_POST['title'] ?? '');
    $startYear = (int) sanitize($_POST['start_year'] ?? 0);
    $endYear = (int) sanitize($_POST['end_year'] ?? 0);
    $showAlert = true;
    $success = false;

    try {
        if (!$schoolInfo) {
            throw new Exception('Unauthorized. Only designated school heads can manage submission projects.');
        }

        $agenda = projectAgenda($agendaId);
        if (!$agenda) {
            throw new Exception('Please select a valid project agenda.');
        }

        if (empty($title)) {
            throw new Exception('Project title is required.');
        }

        if (mb_strlen($title) > 255) {
            throw new Exception('Project title must not exceed 255 characters.');
        }

        if ($startYear < 1901 || $startYear > 2155 || $endYear < 1901 || $endYear > 2155) {
            throw new Exception('Please enter valid 4-digit start and end years.');
        }

        if ($endYear < $startYear) {
            throw new Exception('End year must be greater than or equal to start year.');
        }

        $schoolId = $schoolInfo['id'];

        if ($projectId > 0) {
            $existingProject = callSubmissionProject($projectId);
            if (!$existingProject) {
                throw new Exception('Project record not found.');
            }

            if ((string) $existingProject['school_id'] !== (string) $schoolId) {
                throw new Exception('Unauthorized. You can only edit projects belonging to your school.');
            }

            if ((bool) $existingProject['call_is_closed']) {
                throw new Exception('This call for submission is closed. Projects can no longer be modified.');
            }

            beginTransaction();
            $result = updateCallSubmissionProject($projectId, $agendaId, $title, $startYear, $endYear, $userId);
            if ($result === false) {
                throw new Exception('Failed to update project. Please try again later.');
            }
            touchCallSubmission((int) $existingProject['submission_id']);
            commit();

            $success = true;
            $message = 'Project has been updated successfully.';
            createSystemLog($stationId, $userId, 'Updated submission project', $projectId, clientIp());
        } else {
            $cfs = callForSubmission($cfsId);
            if (!$cfs) {
                throw new Exception('Call for submission not found.');
            }

            if ((bool) $cfs['is_closed']) {
                throw new Exception('This call for submission is already closed. Projects cannot be added.');
            }

            beginTransaction();

            $submission = callSubmissionBySchool($cfsId, $schoolId);
            if ($submission) {
                $submissionId = (int) $submission['id'];
                touchCallSubmission($submissionId);
            } else {
                $submissionId = (int) createCallSubmission($cfsId, $schoolId);
                if (!$submissionId) {
                    throw new Exception('Failed to initialize submission record.');
                }
            }

            $newProjectId = createCallSubmissionProject($submissionId, $agendaId, $title, $startYear, $endYear, $userId);
            if (!$newProjectId) {
                throw new Exception('Failed to save project. Please try again later.');
            }

            commit();

            $success = true;
            $message = 'Project has been added to your submission successfully.';
            createSystemLog($stationId, $userId, 'Added submission project', $newProjectId, clientIp());
        }
    } catch (Exception $e) {
        rollBack();
        $success = false;
        $message = $e->getMessage();
    }
}

if (isset($_POST['delete-submission-project'])) {
    $projectId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $showAlert = true;
    $success = false;

    try {
        if (!$schoolInfo) {
            throw new Exception('Unauthorized. Only designated school heads can delete submission projects.');
        }

        $project = callSubmissionProject($projectId);
        if (!$project) {
            throw new Exception('Project record not found.');
        }

        if ((string) $project['school_id'] !== (string) $schoolInfo['id']) {
            throw new Exception('Unauthorized. You can only delete projects belonging to your school.');
        }

        if ((bool) $project['call_is_closed']) {
            throw new Exception('This call for submission is closed. Projects can no longer be deleted.');
        }

        $submissionId = (int) $project['submission_id'];

        beginTransaction();

        $deleted = deleteCallSubmissionProject($projectId);
        if ($deleted === false) {
            throw new Exception('Failed to delete project. Please try again later.');
        }

        if (countCallSubmissionAttachments($submissionId) === 0 && countCallSubmissionProjects($submissionId) === 0) {
            deleteCallSubmission($submissionId);
        } else {
            touchCallSubmission($submissionId);
        }

        commit();

        $success = true;
        $message = 'Project and all its objectives and outcomes have been deleted successfully.';
        createSystemLog($stationId, $userId, 'Deleted submission project', $projectId, clientIp());
    } catch (Exception $e) {
        rollBack();
        $success = false;
        $message = $e->getMessage();
    }
}

// ========== PROJECT OBJECTIVES (`project_objectives`) ==========

if (isset($_POST['save-project-objective'])) {
    $projectId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $objectiveId = (int) sanitize(decipher($_POST['data-verifier'] ?? null));
    $description = sanitize($_POST['description'] ?? '');
    $showAlert = true;
    $success = false;

    try {
        if (!$schoolInfo) {
            throw new Exception('Unauthorized. Only designated school heads can manage project objectives.');
        }

        if (empty($description)) {
            throw new Exception('Objective description is required.');
        }

        if (mb_strlen($description) > 255) {
            throw new Exception('Objective description must not exceed 255 characters.');
        }

        if ($objectiveId > 0) {
            $existingObj = projectObjective($objectiveId);
            if (!$existingObj) {
                throw new Exception('Project objective record not found.');
            }

            if ((string) $existingObj['school_id'] !== (string) $schoolInfo['id']) {
                throw new Exception('Unauthorized. You can only edit objectives belonging to your school.');
            }

            if ((bool) $existingObj['call_is_closed']) {
                throw new Exception('This call for submission is closed. Objectives can no longer be modified.');
            }

            $result = updateProjectObjective($objectiveId, $description);
            if ($result === false) {
                throw new Exception('Failed to update project objective. Please try again later.');
            }

            touchCallSubmission((int) $existingObj['submission_id']);
            $success = true;
            $message = 'Project objective has been updated successfully.';
            createSystemLog($stationId, $userId, 'Updated project objective', $objectiveId, clientIp());
        } else {
            $project = callSubmissionProject($projectId);
            if (!$project) {
                throw new Exception('Project record not found.');
            }

            if ((string) $project['school_id'] !== (string) $schoolInfo['id']) {
                throw new Exception('Unauthorized. You can only add objectives to projects belonging to your school.');
            }

            if ((bool) $project['call_is_closed']) {
                throw new Exception('This call for submission is closed. Objectives cannot be added.');
            }

            $newObjId = createProjectObjective($projectId, $description);
            if (!$newObjId) {
                throw new Exception('Failed to save project objective. Please try again later.');
            }

            touchCallSubmission((int) $project['submission_id']);
            $success = true;
            $message = 'Project objective has been added successfully.';
            createSystemLog($stationId, $userId, 'Added project objective', $newObjId, clientIp());
        }
    } catch (Exception $e) {
        $success = false;
        $message = $e->getMessage();
    }
}

if (isset($_POST['delete-project-objective'])) {
    $objectiveId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $showAlert = true;
    $success = false;

    try {
        if (!$schoolInfo) {
            throw new Exception('Unauthorized. Only designated school heads can delete project objectives.');
        }

        $objective = projectObjective($objectiveId);
        if (!$objective) {
            throw new Exception('Project objective record not found.');
        }

        if ((string) $objective['school_id'] !== (string) $schoolInfo['id']) {
            throw new Exception('Unauthorized. You can only delete objectives belonging to your school.');
        }

        if ((bool) $objective['call_is_closed']) {
            throw new Exception('This call for submission is closed. Objectives can no longer be deleted.');
        }

        beginTransaction();
        $deleted = deleteProjectObjective($objectiveId);
        if ($deleted === false) {
            throw new Exception('Failed to delete project objective. Please try again later.');
        }
        touchCallSubmission((int) $objective['submission_id']);
        commit();

        $success = true;
        $message = 'Project objective and all its associated outcomes have been deleted successfully.';
        createSystemLog($stationId, $userId, 'Deleted project objective', $objectiveId, clientIp());
    } catch (Exception $e) {
        rollBack();
        $success = false;
        $message = $e->getMessage();
    }
}

// ========== PROJECT OUTCOMES (`project_outcomes`) ==========

if (isset($_POST['save-project-outcome'])) {
    $objectiveId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $outcomeId = (int) sanitize(decipher($_POST['data-verifier'] ?? null));
    $description = sanitize($_POST['description'] ?? '');
    $showAlert = true;
    $success = false;

    try {
        if (!$schoolInfo) {
            throw new Exception('Unauthorized. Only designated school heads can manage project outcomes.');
        }

        if (empty($description)) {
            throw new Exception('Outcome description is required.');
        }

        if (mb_strlen($description) > 255) {
            throw new Exception('Outcome description must not exceed 255 characters.');
        }

        if ($outcomeId > 0) {
            $existingOutcome = projectOutcome($outcomeId);
            if (!$existingOutcome) {
                throw new Exception('Project outcome record not found.');
            }

            if ((string) $existingOutcome['school_id'] !== (string) $schoolInfo['id']) {
                throw new Exception('Unauthorized. You can only edit outcomes belonging to your school.');
            }

            if ((bool) $existingOutcome['call_is_closed']) {
                throw new Exception('This call for submission is closed. Outcomes can no longer be modified.');
            }

            $result = updateProjectOutcome($outcomeId, $description, $userId);
            if ($result === false) {
                throw new Exception('Failed to update project outcome. Please try again later.');
            }

            touchCallSubmission((int) $existingOutcome['submission_id']);
            $success = true;
            $message = 'Project outcome has been updated successfully.';
            createSystemLog($stationId, $userId, 'Updated project outcome', $outcomeId, clientIp());
        } else {
            $objective = projectObjective($objectiveId);
            if (!$objective) {
                throw new Exception('Project objective record not found.');
            }

            if ((string) $objective['school_id'] !== (string) $schoolInfo['id']) {
                throw new Exception('Unauthorized. You can only add outcomes to objectives belonging to your school.');
            }

            if ((bool) $objective['call_is_closed']) {
                throw new Exception('This call for submission is closed. Outcomes cannot be added.');
            }

            $newOutcomeId = createProjectOutcome($objectiveId, $description, $userId);
            if (!$newOutcomeId) {
                throw new Exception('Failed to save project outcome. Please try again later.');
            }

            touchCallSubmission((int) $objective['submission_id']);
            $success = true;
            $message = 'Project outcome has been added successfully.';
            createSystemLog($stationId, $userId, 'Added project outcome', $newOutcomeId, clientIp());
        }
    } catch (Exception $e) {
        $success = false;
        $message = $e->getMessage();
    }
}

if (isset($_POST['delete-project-outcome'])) {
    $outcomeId = (int) sanitize(decipher($_POST['verifier'] ?? null));
    $showAlert = true;
    $success = false;

    try {
        if (!$schoolInfo) {
            throw new Exception('Unauthorized. Only designated school heads can delete project outcomes.');
        }

        $outcome = projectOutcome($outcomeId);
        if (!$outcome) {
            throw new Exception('Project outcome record not found.');
        }

        if ((string) $outcome['school_id'] !== (string) $schoolInfo['id']) {
            throw new Exception('Unauthorized. You can only delete outcomes belonging to your school.');
        }

        if ((bool) $outcome['call_is_closed']) {
            throw new Exception('This call for submission is closed. Outcomes can no longer be deleted.');
        }

        $deleted = deleteProjectOutcome($outcomeId);
        if ($deleted === false) {
            throw new Exception('Failed to delete project outcome. Please try again later.');
        }

        touchCallSubmission((int) $outcome['submission_id']);
        $success = true;
        $message = 'Project outcome has been deleted successfully.';
        createSystemLog($stationId, $userId, 'Deleted project outcome', $outcomeId, clientIp());
    } catch (Exception $e) {
        $success = false;
        $message = $e->getMessage();
    }
}
