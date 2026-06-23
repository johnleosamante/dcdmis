<?php
// rr/app.php
$activeApp = $_SESSION[alias() . '_activeApp'] = 'race';
$page = $appTitle = 'Rewards and Recognitions';

$showAlert = false;
$message = '';
$success = false;

if (isset($_SESSION['race_flash_message'])) {
    $showAlert = true;
    $message = $_SESSION['race_flash_message'];
    $success = $_SESSION['race_flash_success'] ?? false;
    unset($_SESSION['race_flash_message']);
    unset($_SESSION['race_flash_success']);
}

if (!isset($userId)) {
    redirect(uri() . '/login');
}

$raceAccess = raceAccessLevel($userId);

if ($raceAccess === 'none') {
    redirect(uri());
}

$nominatorOnly = ($raceAccess === 'nominator');

if (isset($_POST['save-award'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $awardId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $status = sanitize($_POST['status']);
    $awardName = sanitize($_POST['award-name']);
    $level = sanitize($_POST['level']);
    $nominee = sanitize($_POST['nominee']);
    $position = sanitize($_POST['position']);
    $schoolOffice = sanitize($_POST['school-office']);
    $awardYear = sanitize($_POST['award-year']);
    $description = sanitize($_POST['description']);
    $filename = isset($_POST['file-verifier']) ? sanitize(decipher($_POST['file-verifier'])) : null;
    $ext = $logMessage = '';
    $message = 'No changes have been made to award.';
    $showAlert = true;
    $success = false;

    if (is_uploaded_file($_FILES['file-upload']['tmp_name'])) {
        $temp = $_FILES['file-upload']['tmp_name'];

        if ($_FILES['file-upload']['size'] > $fileUploadSizeLimit) {
            $message = 'The choosen file exceeds the upload file limit (20 MB). No changes have been made to award.';
            return;
        }

        $mimeType = mime_content_type($temp);
        $allowedFileTypes = ['application/pdf', 'image/png', 'image/jpeg'];

        if (!in_array($mimeType, $allowedFileTypes)) {
            $message = 'The choosen file is not an acceptable file (pdf, png, jpeg). No changes have been made to award.';
            return;
        }

        $ext = pathinfo($_FILES['file-upload']['name'], PATHINFO_EXTENSION);

        if (!empty($filename) && file_exists(root() . '/' . $filename)) {
            unlink(root() . '/' . $filename);
        }

        $filename = 'uploads/awards/' . $employeeId . '/' . $employeeId . '-' . date('YmdHis') . '.' . $ext;

        move_uploaded_file($temp, '../' . $filename);
    }

    if (empty($filename)) {
        $message = 'No changes have been made to award.';
        $success = false;
        return;
    } else {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
    }

    if (award($employeeId, $awardId) === 0) {
        $affectedAward = createAward($status, $awardName, $level, $nominee, $position, $schoolOffice, $awardYear, $description, $filename, $ext, $employeeId);

        $logMessage = 'Added award';
        $message = 'Award has been added successfully.';
    } else {
        $affectedAward = updateAward($status, $awardName, $level, $nominee, $position, $schoolOffice, $awardYear, $description, $filename, $ext, $employeeId, $awardId);

        $logMessage = 'Updated award';
        $message = 'Award has been updated successfully.';
    }

    if (!$affectedAward) {
        $message = 'No changes have been made to award.';
        return;
    }

    createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
    $success = true;
}

if (isset($_POST['delete-award'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $awardId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $filename = null;
    $file = award($employeeId, $awardId);
    $deletedAward = false;

    if ($file > 0) {
        $filename = $file['filename'];
        $deletedAward = deleteAward($employeeId, $awardId);
    }

    if ($deletedAward) {
        createSystemLog($stationId, $userId, 'Deleted employee award', $employeeId, clientIp());
        unlink(root() . '/' . $filename);
        $message = 'Award has been deleted successfully.';
    } else {
        $message = 'No changes have been made to award.';
        $success = false;
    }
}

if (isset($_POST['save-schedule'])) {
    $id = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $title = sanitize($_POST['title']);
    $date = sanitize($_POST['date']);
    $venue = sanitize($_POST['venue']);
    $nominationStart = !empty($_POST['nomination_start']) ? sanitize($_POST['nomination_start']) : null;
    $nominationDeadline = !empty($_POST['nomination_deadline']) ? sanitize($_POST['nomination_deadline']) : null;

    $showAlert = true;
    $success = false;

    if (empty($id)) {
        $affected = createAwardSchedule($title, $date, $venue, $nominationStart, $nominationDeadline);
        if ($affected) {
            $message = 'Award schedule has been added successfully.';
            $success = true;
            createSystemLog($stationId, $userId, 'Added award schedule', $affected, clientIp());
        } else {
            $message = 'Failed to add award schedule.';
        }
    } else {
        $affected = updateAwardSchedule($title, $date, $venue, $id, $nominationStart, $nominationDeadline);
        if ($affected) {
            $message = 'Award schedule has been updated successfully.';
            $success = true;
            createSystemLog($stationId, $userId, 'Updated award schedule', $id, clientIp());
        } else {
            $message = 'No changes have been made to schedule.';
        }
    }
}

if (isset($_POST['delete-schedule'])) {
    $id = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $showAlert = true;
    $success = false;

    if ($id) {
        $affected = deleteAwardSchedule($id);
        if ($affected) {
            $message = 'Award schedule has been deleted successfully.';
            $success = true;
            createSystemLog($stationId, $userId, 'Deleted award schedule', $id, clientIp());
        } else {
            $message = 'Failed to delete award schedule.';
        }
    } else {
        $message = 'Invalid schedule verifier.';
    }
}

if (isset($_POST['save-nominee'])) {
    $schedule_id = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $employee_id = sanitize($_POST['employee-id']);

    // Support fallback to GET params if category/award are not posted (simplified modal layout)
    $award_id = isset($_POST['award']) && !empty($_POST['award']) ? sanitize($_POST['award']) : (isset($_GET['award_id']) ? sanitize(decipher($_GET['award_id'])) : null);

    $showAlert = true;
    $success = false;

    if ($schedule_id && $employee_id && $award_id) {
        $scheduleData = awardSchedule($schedule_id);
        if ($scheduleData && !isNominationOpen($scheduleData)) {
            $message = 'Nomination period for this schedule has ended.';
            return;
        }

        $nominee_type = 'Employee';
        $award = recognitionAward($award_id);
        if ($award) {
            $lowerAwardName = strtolower($award['name']);
            if (
                strpos($lowerAwardName, 'medium school') !== false ||
                strpos($lowerAwardName, 'small school') !== false ||
                strpos($lowerAwardName, 'large school') !== false
            ) {
                $nominee_type = 'School';
            }
        }

        if (isPrincipal($userId)) {
            if ($nominee_type === 'Employee') {
                $nomineeStation = position($employee_id);
                if (!$nomineeStation || $nomineeStation['station_id'] !== $stationId) {
                    $message = 'You can only nominate personnel under your school.';
                    return;
                }
            } elseif ($nominee_type === 'School' && $employee_id !== $stationId) {
                $message = 'You can only nominate your own school.';
                return;
            }
        }

        $level = isset($_POST['level']) && !empty($_POST['level']) ? sanitize($_POST['level']) : null;
        $affected = createNominee($schedule_id, $employee_id, $award_id, $nominee_type, $level);
        if ($affected) {
            $message = 'Nominee has been added successfully.';
            $success = true;
            createSystemLog($stationId, $userId, 'Added nominee', $affected, clientIp());
        } else {
            $message = 'Failed to add nominee.';
        }
    } else {
        $message = 'All fields are required to add a nominee.';
    }
}

if (isset($_POST['delete-nominee'])) {
    $id = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $showAlert = true;
    $success = false;

    if ($id) {
        $affected = deleteNominee($id);
        if ($affected) {
            $message = 'Nominee has been deleted successfully.';
            $success = true;
            createSystemLog($stationId, $userId, 'Deleted nominee', $id, clientIp());
        } else {
            $message = 'Failed to delete nominee.';
        }
    } else {
        $message = 'Invalid nominee verifier.';
    }
}

if (isset($_POST['declare-winner'])) {
    $showAlert = true;
    $success = false;

    if ($nominatorOnly) {
        $message = 'You do not have permission to declare winners.';
    } else {
        $schedule_id = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
        $award_id = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
        $winner_nominee_id = isset($_POST['winner_nominee_id']) ? sanitize(decipher($_POST['winner_nominee_id'])) : null;

        if ($schedule_id && $award_id && $winner_nominee_id) {
            $affected = setAwardWinner($schedule_id, $award_id, $winner_nominee_id);
            if ($affected) {
                $message = 'Winner has been declared successfully.';
                $success = true;
                createSystemLog($stationId, $userId, 'Declared award winner', $winner_nominee_id, clientIp());
            } else {
                $message = 'Failed to declare winner.';
            }
        } else {
            $message = 'Winner selection is required.';
        }
    }
}

if (isset($_POST['save-recognition-award'])) {
    $category_id = sanitize($_POST['category_id']);
    $award_name = sanitize($_POST['award_name']);

    $showAlert = true;
    $success = false;

    if ($category_id && $award_name) {
        $affected = createRecognitionAward($category_id, $award_name);
        if ($affected) {
            $message = 'Award has been added successfully.';
            $success = true;
            createSystemLog($stationId, $userId, 'Added recognition award', $affected, clientIp());
        } else {
            $message = 'Failed to add award.';
        }
    } else {
        $message = 'All fields are required to add an award.';
    }
}

if (isset($_POST['declare-winner']) || isset($_POST['revert-winner']) || isset($_POST['disqualify-nominee'])) {
    $nominee_id = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $showAlert = true;
    $success = false;

    if ($nominatorOnly) {
        $message = 'You do not have permission to perform this action.';
    } elseif ($nominee_id) {
        $nom = nominee($nominee_id);
        if ($nom) {
            if (isset($_POST['declare-winner'])) {
                $affected = setAwardWinner($nom['schedule_id'], $nom['award_id'], $nominee_id);
                if ($affected) {
                    $message = 'Winner has been declared successfully.';
                    $success = true;
                    createSystemLog($stationId, $userId, 'Declared award winner', $nominee_id, clientIp());
                } else {
                    $message = 'Failed to declare winner.';
                }
            } elseif (isset($_POST['revert-winner'])) {
                $affected = query("UPDATE `awards_categories_nominees` SET `status` = 'Nominated' WHERE `id` = ?", [$nominee_id]);
                if ($affected) {
                    $message = 'Winner has been reverted back to nominee successfully.';
                    $success = true;
                    createSystemLog($stationId, $userId, 'Reverted award winner', $nominee_id, clientIp());
                } else {
                    $message = 'Failed to revert winner.';
                }
            } elseif (isset($_POST['disqualify-nominee'])) {
                $affected = disqualifyNominee($nominee_id);
                if ($affected) {
                    $message = 'Nominee has been disqualified successfully.';
                    $success = true;
                    createSystemLog($stationId, $userId, 'Disqualified nominee', $nominee_id, clientIp());
                } else {
                    $message = 'Failed to disqualify nominee.';
                }
            }
        }
    }
}

?>