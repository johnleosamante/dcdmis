<?php
// hrmpsb/app.php
$activeApp = $_SESSION[alias() . '_activeApp'] = 'hrmpsb';
$page = $appTitle = 'Human Resource Management Personnel Selection Board';

if (!isset($userId)) {
    redirect(uri() . '/login');
}

if (!userRole($userId, $activeApp)) {
    redirect(uri() . '/pis');
}

if (isset($_POST['save-vacancy'])) {
    $vacancyId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $position = null;
    $positionId = $_POST['position'] ?? null;
    $itemNumber = sanitize($_POST['item_number'] ?? '');
    $stationId = $_POST['station'] ?? null;
    $datePosted = $_POST['date_posted'] ?? date('Y-m-d');
    $showAlert = true;
    $status = 'Added vacancy';

    if (empty($positionId)) {
        $message = 'Please select a position.';
        $success = false;
    } elseif (empty($itemNumber)) {
        $message = 'Please enter an item number.';
        $success = false;
    } elseif (empty($vacancyId) && doesItemNumberExist($itemNumber)) {
        $message = "Item number [$itemNumber] already exists.";
        $success = false;
    } else {
        if (empty($vacancyId)) {
            $position = strtoupper(positions($positionId)['position']);
            createVacancy('open', $positionId, $stationId, $itemNumber, null, $datePosted, 'new');
            $message = "Vacancy for [$position] with item number [$itemNumber] has been added successfully.";
        } else {
            $vacancy = vacancy($vacancyId);
            $vacancyStatus = $vacancy['status'] ?? 'open';
            $vacancyPosition = $vacancy['position_id'] ?? null;
            $vacancyReason = $vacancy['reason'] ?? 'new';
            $itemNumber = empty($vacancy['item_number']) ? $itemNumber : $vacancy['item_number'];
            updateVacancy($vacancyId, $vacancyStatus, $vacancyPosition, $stationId, $itemNumber, $datePosted, $vacancyReason);
            $status = 'Updated vacancy';
            $message = "Vacancy with item number [$itemNumber] has been updated successfully.";
        }

        if (affectedRows()) {
            createSystemLog($stationId ?? 'HRMPSB', $userId, $status, $itemNumber, clientIp());
        } else {
            $message = 'Vacancy was not saved successfully.';
            $success = false;
        }
    }
}

if (isset($_POST['delete-vacancy'])) {
    $vacancyId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $showAlert = true;

    if (empty($vacancyId)) {
        $message = 'Invalid vacancy selected.';
        $success = false;
    } else {
        $vacancy = fetchAssoc(vacancy($vacancyId));
        $itemNumber = $vacancy['item_number'] ?? 'N/A';

        $deletedVacancy = deleteVacancy($vacancyId);

        if ($deletedVacancy) {
            $message = "Vacancy with item number [$itemNumber] has been deleted successfully.";
            createSystemLog('HRMPSB', $userId, 'Deleted vacancy', $itemNumber, clientIp());
        } else {
            $message = 'Vacancy was not deleted successfully.';
            $success = false;
        }
    }
}

if (isset($_POST['fill-vacancy'])) {
    $vacancyId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $employeeId = $_POST['employee_id'] ?? null;
    $dateFilled = $_POST['date_filled'] ?? date('Y-m-d');
    $showAlert = true;

    if (empty($vacancyId)) {
        $message = 'Invalid vacancy selected.';
        $success = false;
    } elseif (empty($employeeId)) {
        $message = 'Please select an employee to fill the vacancy.';
        $success = false;
    } else {
        $vacancy = fetchAssoc(vacancy($vacancyId));
        $itemNumber = $vacancy['item_number'] ?? 'N/A';

        $filledVacancy = fillVacancy($vacancyId);

        if ($filledVacancy) {
            $employee = employee($employeeId);
            $employeeName = toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext'], true);
            $message = "Vacancy [$itemNumber] has been filled by $employeeName.";
            createSystemLog('HRMPSB', $userId, 'Filled vacancy', "$itemNumber - $employeeName", clientIp());
        } else {
            $message = 'Vacancy was not filled successfully.';
            $success = false;
        }
    }
}

if (isset($_POST['publish-vacancies'])) {
    $showAlert = true;
    $success = false;

    $title = sanitize($_POST['pub_title'] ?? '');
    $description = sanitize($_POST['pub_description'] ?? '');
    $openDate = sanitize($_POST['open_date'] ?? date('Y-m-d'));
    $closeDate = sanitize($_POST['close_date'] ?? date('Y-m-d', strtotime('+30 days')));
    $pubStatus = sanitize($_POST['pub_status'] ?? 'open');
    $vacancyIds = $_POST['vacancy_ids'] ?? [];

    if (empty($title)) {
        $message = 'Please enter a publication title.';
    } elseif (empty($vacancyIds)) {
        $message = 'Please select at least one vacancy to publish.';
    } elseif (strtotime($closeDate) < strtotime($openDate)) {
        $message = 'Closing date cannot be before opening date.';
    } else {
        $code = generatePublicationCode();
        $publicationId = createPublication($code, $title, $description, $openDate, $closeDate, $pubStatus);

        if ($publicationId) {
            $totalVacanciesLinked = 0;
            foreach ($vacancyIds as $vacancyId) {
                $position_id = $plantilla_item_id = '';
                addPublicationItem($publicationId, sanitize($vacancyId), $position_id, $plantilla_item_id);
                $totalVacanciesLinked++;
            }

            $applicationUrl = uri() . '/hrmpsb/apply?p=' . $code;
            $success = true;
            $message = "Publication created successfully! <br><br>
                <strong>Application URL:</strong><br>
                <a href=\"{$applicationUrl}\" target=\"_blank\" class=\"text-primary\">{$applicationUrl}</a><br><br>
                <small class=\"text-muted\">Share this link to accept applications.</small>";

            createSystemLog('HRMPSB', $userId, 'Published vacancies', $code . ' - ' . $totalVacanciesLinked . ' items linked', clientIp());
        } else {
            $message = 'Failed to create publication.';
        }
    }
}

if (isset($_POST['delete-publication'])) {
    $publicationId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $showAlert = true;

    if (empty($publicationId)) {
        $message = 'Invalid publication selected.';
        $success = false;
    } else {
        $publication = publication($publicationId);
        $code = $publication['code'] ?? 'N/A';

        $deletePublication = deletePublication($publicationId);
        $clearedPublicationItems = clearPublicationItems($publicationId);

        if ($deletePublication || $clearedPublicationItems) {
            $message = "Publication [$code] has been deleted successfully.";
            createSystemLog('HRMPSB', $userId, 'Deleted publication', $code, clientIp());
        } else {
            $message = 'Publication was not deleted successfully.';
            $success = false;
        }
    }
}

if (isset($_POST['update-publication'])) {
    $publicationId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $showAlert = true;
    $success = false;

    $title = sanitize($_POST['pub_title'] ?? '');
    $description = sanitize($_POST['pub_description'] ?? '');
    $openDate = sanitize($_POST['open_date'] ?? date('Y-m-d'));
    $closeDate = sanitize($_POST['close_date'] ?? date('Y-m-d', strtotime('+30 days')));
    $pubStatus = sanitize($_POST['pub_status'] ?? 'open');
    $vacancyIds = $_POST['vacancy_ids'] ?? [];

    if (empty($publicationId)) {
        $message = 'Invalid publication selected.';
    } elseif (empty($title)) {
        $message = 'Please enter a publication title.';
    } elseif (empty($vacancyIds)) {
        $message = 'Please select at least one vacancy.';
    } elseif (strtotime($closeDate) < strtotime($openDate)) {
        $message = 'Closing date cannot be before opening date.';
    } else {
        $publication = fetchAssoc(publication($publicationId));
        $code = $publication['code'];

        updatePublication($publicationId, $title, $description, $openDate, $closeDate, $pubStatus);

        // Re-link items
        clearPublicationItems($publicationId);
        $totalVacanciesLinked = 0;
        foreach ($vacancyIds as $vacancyId) {
            addPublicationItem($publicationId, sanitize($vacancyId));
            $totalVacanciesLinked++;
        }

        $success = true;
        $message = "Publication [$code] has been updated successfully. Linked $totalVacanciesLinked items.";
        createSystemLog('HRMPSB', $userId, 'Updated publication', $code, clientIp());
    }
}
