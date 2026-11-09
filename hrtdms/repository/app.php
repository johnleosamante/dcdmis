<?php
// hrtdms/repository/app.php
$appTitle = $page = !MAINTENANCE_MODE ? 'Division Training Certificate Finder' : 'System Maintenance';
$enableScripts = true;

$from = isset($_GET['from']) ? sanitize($_GET['from']) : date('Y') . '-01-01';
$to = isset($_GET['to']) ? sanitize($_GET['to']) : date('Y-m-d');

if (isset($_POST['transactions-summary-filter'])) {
    $from = date('Y-m-d', strtotime($_POST['date-from']));
    $to = date('Y-m-d', strtotime($_POST['date-to']));
    redirect(customUri('hrtdms/repository', '') . '&from=' . $from . '&to=' . $to);
}

if (isset($_POST['confirm-email-participant'])) {
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
        $message = 'Email has been sent successfully to selected training participant.';
    } else {
        $message = "Email has been sent successfully to selected training participant.";
    }

    $success = true;
}