<?php
// hrtdms/app.php
$activeApp = $_SESSION[alias() . '_activeApp'] = 'hrtdms';
$page = $appTitle = 'Human Resource Training &amp; Development Management System';

if (!isset($userId)) {
    redirect(uri() . '/login');
}

if (numRows(userRole($userId, $activeApp)) === 0) {
    redirect(uri() . '/pis');
}

if (isset($_POST['primary-search-button'])) {
    redirect(customUri('hrtdms', 'Training Details', sanitize($_POST['primary-search-text'])));
}

if (isset($_POST['save-training'])) {
    $trainingId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $title = sanitize($_POST['title']);
    $from = sanitize($_POST['from']);
    $to = sanitize($_POST['to']);
    $hours = sanitize($_POST['hours']);
    $type = sanitize($_POST['type']);
    $level = sanitize($_POST['level']);
    $sponsor = sanitize($_POST['sponsor']);
    $division = sanitize($_POST['functional-division']);
    $venue = sanitize($_POST['venue']);
    $logMessage = '';
    $unconsecutiveDates = sanitize($_POST['unconsecutive-dates']);
    $hasCertificate = strtolower($level) === '3' ? '1' : '0';
    $signatory = isset($_POST['has-certificate']) ? fetchAssoc(section('SDS'))['head'] : null;
    $showAlert = true;

    if (numRows(training($trainingId)) === 0) {
        $logMessage = 'Added training';
        $status = 'saved';
        $year = toDate($from, 'y', date('y'));
        $trainingId = 'HRTD-' . $year . '-' . sprintf("%04d", countTrainings($year) + 1);

        createTraining($trainingId, $title, $from, $to, $hours, $type, $level, $sponsor, $venue, $unconsecutiveDates, $signatory, $hasCertificate, $division);
    } else {
        $logMessage = 'Updated training';
        $status = 'updated';

        updateTraining($trainingId, $title, $from, $to, $hours, $type, $level, $sponsor, $venue, $unconsecutiveDates, $signatory, $hasCertificate, $division);
    }

    if (affectedRows()) {
        $message = 'Training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details">' . strtoupper($trainingId) . '</a>] has been ' . $status . ' successfully.';

        createSystemLog($stationId, $userId, $logMessage, $trainingId, clientIp());
    } else {
        $message = $status === 'saved' ? 'No new training has been created.' : 'No training has been updated';
        $success = false;
    }
}

if (isset($_POST['add-participants'])) {
    $showAlert = true;

    if (!isset($_POST['participants'])) {
        $message = 'No training participant was added to training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details">' . strtoupper($trainingId) . '</a>].';
        $success = false;
        return;
    }

    $trainingId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;

    $trainings = training($trainingId);
    $training = fetchAssoc($trainings);
    $division = $training['functional_division'];
    $trainingDate = strtotime($training['to']);
    $month = date('m', $trainingDate);
    $year = date('Y', $trainingDate);

    $participants = $_POST['participants'];
    $no = 0;

    $count = numRows(trainingParticipants($trainingId));

    foreach ($participants as $participant) {
        $id = sanitize(decipher($participant));

        if (!isTrainingParticipant($trainingId, $id)) {
            ++$no;
            $ctrlNo = $division . '-' . $month . '-' . sprintf("%03d", $count + $no) . '-' . $year;
            createTrainingParticipant($trainingId, $id, $ctrlNo);
        }
    }

    if (affectedRows()) {
        if ($no > 1) {
            $message = $no . ' training participants were added successfully to training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details">' . strtoupper($trainingId) . '</a>].';
        } else {
            $participantId = sanitize(decipher($participants[0]));
            $message = 'Employee [<a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData(\'' . uri() . '/modules/users/user-info-dialog.php?id=' . cipher($participantId) . '\')" title="View ' . userName($participantId) . ' employee information">' . userName($participantId, true) . '</a>] has been added successfully as participant to training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details">' . strtoupper($trainingId) . '</a>].';
        }

        createSystemLog($stationId, $userId, 'Added ' . $no . ' training participants', $trainingId, clientIp());
    } else {
        $message = 'No training participant was added to training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details">' . strtoupper($trainingId) . '</a>].';
        $success = false;
    }
}

if (isset($_POST['remove-participant'])) {
    $participantId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $trainingId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;

    deleteTrainingParticipant($trainingId, $participantId);

    if (affectedRows()) {
        $message = 'Employee [<a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData(\'' . uri() . '/modules/users/user-info-dialog.php?id=' . cipher($participantId) . '\')" title="View ' . userName($participantId) . ' employee information">' . userName($participantId, true) . '</a>] has been successfully removed as participant from training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details">' . strtoupper($trainingId) . '</a>].';

        createSystemLog($stationId, $userId, 'Removed training participant', $trainingId, clientIp());
    } else {
        $message = 'Employee [<a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData(\'' . uri() . '/modules/users/user-info-dialog.php?id=' . cipher($participantId) . '\')" title="View ' . userName($participantId) . ' employee information">' . userName($participantId, true) . '</a>] was not removed as participant from training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details">' . strtoupper($trainingId) . '</a>].';
        $success = false;
    }
}

if (isset($_POST['email-participants'])) {
    $trainingId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $participantId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $trainings = training($trainingId);

    if (numRows($trainings) === 0) {
        $message = 'No training has been found.';
        return;
    }

    $title = strtoupper(toHandleEncoding(fetchAssoc($trainings)['title']));

    $trainingParticipants = trainingParticipants($trainingId, $participantId);

    $name = '';
    $participants = 0;

    while ($participant = fetchAssoc($trainingParticipants)) {
        $userEmail = $participant['email'];
        $certificate = customUri('print', 'Certificate of Participation', $trainingId, DOMAIN) . '&p=' . encode($participant['id']);
        $appearance = customUri('print', 'Certificate of Appearance', $trainingId, DOMAIN) . '&p=' . encode($participant['id']);
        $name = strtoupper(toHandleEncoding(toName($participant['lname'], $participant['fname'], $participant['mname'], $participant['ext'], true)));

        $emailMessage = 'Good day ' . $name . '!' . PHP_EOL . PHP_EOL .
            'Congratulations you have successfully completed "' . $title . '".' . PHP_EOL .
            'Get your certificates by clicking the links below.' . PHP_EOL . PHP_EOL .
            'Certificate of Appearance: ' . $appearance . PHP_EOL . PHP_EOL .
            'Certificate of Participation: ' . $certificate . PHP_EOL . PHP_EOL .
            'If nothing happens when you click the link, copy the links above and paste to your web browser instead. Thank you.' . PHP_EOL . PHP_EOL . PHP_EOL .
            '***** THIS IS A SYSTEM GENERATED EMAIL. PLEASE DO NOT REPLY. *****';

        if (sendMail($userEmail, $title, $emailMessage)) {
            $participants++;
        }
    }

    if ($participants === 0) {
        $message = "No email has been sent successfully.";
        return;
    } else if ($participants === 1) {
        $message = 'Email has been sent successfully to selected training participant: [<a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData(\'' . uri() . '/modules/users/user-info-dialog.php?id=' . cipher($participantId) . '\')" title="View ' . userName($participantId) . ' employee information">' . userName($participantId, true) . '</a>]';
    } else {
        $message = "Email has been sent successfully to all {$participants} training participants.";
    }

    $success = true;
}
