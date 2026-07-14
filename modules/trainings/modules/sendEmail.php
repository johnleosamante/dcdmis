<?php

session_start();
require_once('../../../includes/config.php');

header('Content-Type: application/json');

$mysqli = new mysqli(HOSTNAME, USER, '', DATABASE);

if ($mysqli->connect_error) {
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed"
    ]);
    exit;
}

// PHPMailer
require_once __DIR__ . '/../../../assets/vendor/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../../../assets/vendor/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../../../assets/vendor/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// GET DATA
$attendance_id = $_POST['attendance_id'] ?? null;
$email = $_POST['email'] ?? null;
$employeeID = $_POST['employeeID'] ?? null;
$trainingID = $_POST['trainingID'] ?? null;
$repositoryUrl = 'https://depeddipolog.com/hrtdms/repository';

// VALIDATION
if (!$attendance_id || !$email) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing required data"
    ]);
    exit;
}

$stmt = $mysqli->prepare("
    SELECT first_name, middle_name, last_name
    FROM employees
    WHERE id = ?
");

$stmt->bind_param("i", $employeeID);
$stmt->execute();
$emp = $stmt->get_result()->fetch_assoc();

$employeeName = strtoupper(trim(
                $emp['first_name'] . ' ' .
                ($emp['middle_name'] ? substr($emp['middle_name'], 0, 1) . '. ' : '') .
                $emp['last_name']
        ));

$stmt = $mysqli->prepare("
    SELECT title
    FROM trainings
    WHERE id = ?
");

$stmt->bind_param("i", $trainingID);
$stmt->execute();
$training = $stmt->get_result()->fetch_assoc();

$title = $training['title'] ?? 'Training';


$certificate =  'https://depeddipolog.com/print/?&v='. urlencode(base64_encode("Certificate of Participation")).'&id='.urlencode(base64_encode($trainingID)).'&p='.urlencode(base64_encode($employeeID));

$appearance = 'https://depeddipolog.com/print/?&v='. urlencode(base64_encode("Certificate of Appearance")).'&id='.urlencode(base64_encode($trainingID)).'&p='.urlencode(base64_encode($employeeID));

$stmt = $mysqli->prepare("
    SELECT title
    FROM trainings
    WHERE id = ?
");

$stmt->bind_param("i", $trainingID);
$stmt->execute();
$training = $stmt->get_result()->fetch_assoc();

$title = $training['title'] ?? 'Training';

// SEND EMAIL
$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'yvicronil@gmail.com';
    $mail->Password = 'rfpwumtoiwmkbzis';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('yvicronill@gmail.com', 'DepEd System');
    $mail->addAddress($email);

    $mail->isHTML(false);
    $mail->Subject = 'Training Attendance Report';

    $mail->Body = "Good day $employeeName!\n\n
Congratulations you have successfully completed $title\n
Get your certificates by clicking the links below.\n\n
Certificate of Appearance: $appearance\n\n
Certificate of Participation: $certificate\n\n
If nothing happens when you click the link, copy the links above and paste to your web browser instead.\n\n
You can also go to the DepEd Dipolog City Division Training Repository ($repositoryUrl) to view your trainings. Thank you.\n\n\n
***** THIS IS A SYSTEM GENERATED EMAIL. PLEASE DO NOT REPLY. *****";

    $mail->send();

    // UPDATE DATABASE (IMPORTANT FIX)
    $stmt = $mysqli->prepare("
        UPDATE training_attendees
        SET is_mail = 1
        WHERE id = ?
    ");

    $stmt->bind_param("i", $attendance_id);
    $stmt->execute();

    echo json_encode([
        "status" => "success",
        "message" => "Email sent successfully"
    ]);
} catch (Exception $e) {

    echo json_encode([
        "status" => "error",
        "message" => $mail->ErrorInfo
    ]);
}