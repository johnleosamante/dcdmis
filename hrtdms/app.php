<?php
// hrtdms/app.php
$activeApp = $_SESSION[alias() . '_activeApp'] = 'hrtdms';
$page = $appTitle = 'Human Resource Training &amp; Development Management System';

if (!isset($userId)) {
    redirect("{$baseUri}/login");
}

if (!userRole($userId, $activeApp)) {
    redirect("{$baseUri}/" . HOME);
}

if (isset($_SESSION["{$prefix}change_password"])) {
    redirect("{$baseUri}/login/change");
}

if (isset($_POST['primary-search-button'])) {
    redirect(customUri('hrtdms', 'Training Details', sanitize($_POST['primary-search-text'])));
}

if (isset($_POST['save-training'])) {
    $showAlert = true;
    $rawId = isset($_POST['verifier']) ? decipher($_POST['verifier']) : null;
    $trainingId = sanitize($rawId);
    $data = [
        'title' => sanitize($_POST['title']),
        'from' => sanitize($_POST['from']),
        'to' => sanitize($_POST['to']),
        'hours' => (int) $_POST['hours'],
        'type' => sanitize($_POST['type']),
        'level' => sanitize($_POST['level']),
        'sponsor' => sanitize($_POST['sponsor']),
        'division' => sanitize($_POST['functional-division']),
        'venue' => sanitize($_POST['venue']),
        'dates' => sanitize($_POST['unconsecutive-dates']),
        'hasCert' => isset($_POST['has-certificate']) ? '1' : '0',
    ];
    $sdsSection = section('SDS');
    $signatory = ($data['hasCert'] === '1' && $sdsSection) ? $sdsSection['head_id'] : null;

    if (!training($trainingId)) {
        $logMessage = 'Added training';
        $status = 'saved';
        $year = toDate($data['from'], 'y', date('y'));
        $trainingId = "HRTD-$year-" . sprintf("%04d", countTrainings($year) + 1);
        $affectedTraining = createTraining($trainingId, $data['title'], $data['from'], $data['to'], $data['hours'], $data['type'], $data['level'], $data['sponsor'], $data['venue'], $data['dates'], $signatory, $data['hasCert'], $data['division']);
    } else {
        $logMessage = 'Updated training';
        $status = 'updated';
        $affectedTraining = updateTraining($trainingId, $data['title'], $data['from'], $data['to'], $data['hours'], $data['type'], $data['level'], $data['sponsor'], $data['venue'], $data['dates'], $signatory, $data['hasCert'], $data['division']);
    }

    if ($affectedTraining === false) {
        $message = $status === 'saved' ? 'No new training has been created.' : 'No training has been updated';
        return;
    }

    $message = 'Training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details">' . strtoupper($trainingId) . '</a>] has been ' . $status . ' successfully.';
    $success = true;

    createSystemLog($stationId, $userId, $logMessage, $trainingId, clientIp());
}

if (isset($_POST['add-participants'])) {
    $showAlert = true;
    $trainingId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;

    if (!isset($_POST['participants'])) {
        $message = 'No training participant was added to training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details">' . strtoupper($trainingId) . '</a>].';
        $success = false;
        return;
    }

    $training = training($trainingId);
    $title = strtoupper(toHandleEncoding($training['title']));
    $division = $training['functional_division_id'];
    $trainingDate = strtotime($training['end_date']);
    $month = date('m', $trainingDate);
    $year = date('Y', $trainingDate);
    $participants = $_POST['participants'];
    $no = 0;
    $count = count(trainingParticipants($trainingId));

    foreach ($participants as $participant) {
        $id = sanitize(decipher($participant));

        if (!isTrainingParticipant($trainingId, $id)) {
            ++$no;
            $ctrlNo = "$division-$month-" . sprintf("%03d", $count + $no) . "-$year";
            $affectedParticipants = createTrainingParticipant($trainingId, $id, $ctrlNo);

            if ($affectedParticipants) {
                $employeeList = trainingParticipants($trainingId, $id);
                $employee = !empty($employeeList) ? $employeeList[0] : null;
                if ($employee) {
                    $employeeEmail = PRODUCTION_MODE ? $employee['email_address'] : DEVELOPER_EMAIL;
                    $employeeName = strtoupper(toHandleEncoding(toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension'], true)));
                    $certificate = customUri('print', 'Certificate of Participation', $trainingId, DOMAIN) . '&p=' . encode($id);
                    $appearance = customUri('print', 'Certificate of Appearance', $trainingId, DOMAIN) . '&p=' . encode($id);
                    $repositoryUrl = uri(DOMAIN) . '/hrtdms/repository';
                    $emailMessage = <<<EOT
Hello, {$employeeName}
    
Congratulations you have successfully completed {$title}

Get your certificates by clicking the links below.

Certificate of Appearance: {$appearance}
Certificate of Participation: {$certificate}
                        
If nothing happens when you click the link, copy the links above and paste to your web browser search bar instead.

You can also go to the DepEd Dipolog City Division Training Repository ($repositoryUrl) to view your trainings. 

Thank you.

***** THIS IS A SYSTEM GENERATED EMAIL. PLEASE DO NOT REPLY. *****"
EOT;

                    sendMail($employeeEmail, $title, $emailMessage);
                }
            }
        }
    }

    if ($no === 0) {
        $message = 'No training participant was added to training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details">' . strtoupper($trainingId) . '</a>].';
        return;
    }

    if ($no > 1) {
        $message = $no . ' training participants were added successfully to training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details">' . strtoupper($trainingId) . '</a>].';
    } else {
        $participantId = sanitize(decipher($participants[0]));
        $message = 'Employee [<a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData(\'' . uri() . '/modules/users/user-info-dialog.php?id=' . cipher($participantId) . '\')" title="View ' . userName($participantId) . ' employee information">' . userName($participantId, true) . '</a>] has been added successfully as participant to training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details">' . strtoupper($trainingId) . '</a>].';
    }

    $success = true;

    createSystemLog($stationId, $userId, 'Added ' . $no . ' training participants', $trainingId, clientIp());
}

if (isset($_POST['remove-participant'])) {
    $participantId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $trainingId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;

    $affectedParticipants = deleteTrainingParticipant($trainingId, $participantId);

    if (!$affectedParticipants) {
        $message = 'Employee [<a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData(\'' . uri() . '/modules/users/user-info-dialog.php?id=' . cipher($participantId) . '\')" title="View ' . userName($participantId) . ' employee information">' . userName($participantId, true) . '</a>] was not removed as participant from training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details">' . strtoupper($trainingId) . '</a>].';
        return;
    }

    $message = 'Employee [<a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData(\'' . uri() . '/modules/users/user-info-dialog.php?id=' . cipher($participantId) . '\')" title="View ' . userName($participantId) . ' employee information">' . userName($participantId, true) . '</a>] has been successfully removed as participant from training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details">' . strtoupper($trainingId) . '</a>].';
    $success = true;

    createSystemLog($stationId, $userId, 'Removed training participant', $trainingId, clientIp());
}

if (isset($_POST['email-participants'])) {
    $trainingId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $participantId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $training = training($trainingId);

    if (!$training) {
        $message = 'No training has been found.';
        return;
    }

    $title = strtoupper(toHandleEncoding($training['title']));
    $trainingParticipants = trainingParticipants($trainingId, $participantId);
    $participants = 0;

    foreach ($trainingParticipants as $participant) {
        $userEmail = PRODUCTION_MODE ? $participant['email_address'] : DEVELOPER_EMAIL;
        $certificate = customUri('print', 'Certificate of Participation', $trainingId, DOMAIN) . '&p=' . encode($participant['id']);
        $appearance = customUri('print', 'Certificate of Appearance', $trainingId, DOMAIN) . '&p=' . encode($participant['id']);
        $name = strtoupper(toHandleEncoding(toName($participant['last_name'], $participant['first_name'], $participant['middle_name'], $participant['name_extension'], true)));
        $repositoryUrl = uri(DOMAIN) . '/hrtdms/repository';
        $emailMessage = <<<EOT
Hello, {$name}
    
Congratulations you have successfully completed {$title}

Get your certificates by clicking the links below.

Certificate of Appearance: {$appearance}
Certificate of Participation: {$certificate}
                        
If nothing happens when you click the link, copy the links above and paste to your web browser search bar instead.

You can also go to the DepEd Dipolog City Division Training Repository ($repositoryUrl) to view your trainings. 

Thank you.

***** THIS IS A SYSTEM GENERATED EMAIL. PLEASE DO NOT REPLY. *****"
EOT;

        if (sendMail($userEmail, $title, $emailMessage)) {
            $participants++;
        }
    }

    if ($participants === 0) {
        $message = "No email has been sent successfully.";
        return;
    } elseif ($participants === 1) {
        $message = 'Email has been sent successfully to selected training participant: [<a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData(\'' . uri() . '/modules/users/user-info-dialog.php?id=' . cipher($participantId) . '\')" title="View ' . userName($participantId) . ' employee information">' . userName($participantId, true) . '</a>]';
    } else {
        $message = "Email has been sent successfully to all {$participants} training participants.";
    }

    $success = true;
}

$from = isset($_GET['from']) ? sanitize($_GET['from']) : date('Y') . '-01-01';
$to = isset($_GET['to']) ? sanitize($_GET['to']) : date('Y-m-d');

if (isset($_POST['transactions-summary-filter'])) {
    $from = date('Y-m-d', strtotime($_POST['date-from']));
    $to = date('Y-m-d', strtotime($_POST['date-to']));
    redirect(customUri('hrtdms', sanitize(decipher($_GET['v']))) . '&from=' . $from . '&to=' . $to);
}