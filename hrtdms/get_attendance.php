<?php

header('Content-Type: application/json');
require_once('../includes/config.php');

$training_id = isset($_GET['training_id']) ? base64_decode($_GET['training_id']) : '';
$date = isset($_GET['date']) ? base64_decode($_GET['date']) : '';

if (!$training_id || !$date) {

    echo json_encode([]);
    exit;
}
$mysqli = new mysqli(HOSTNAME, USER, '', DATABASE);

if ($mysqli->connect_error) {
    echo json_encode([]);
    exit;
}
$query = "
    SELECT 
        CONCAT(
            e.first_name, ' ',
            IF(
                e.middle_name IS NOT NULL 
                AND e.middle_name != '',
                CONCAT(LEFT(e.middle_name,1), '. '),
                ''
            ),
            e.last_name
        ) AS name,
        e.sex AS gender,
        p.official_title AS position,
        ta.img_url,
        ta.time_in
    FROM training_attendees ta
    JOIN employees e 
        ON ta.employee_id = e.id
    LEFT JOIN station_assignments sa 
        ON sa.employee_id = e.id
    LEFT JOIN positions p 
        ON p.id = sa.position_id
    WHERE ta.training_id = ?
      AND ta.date_in = ?
    ORDER BY e.last_name ASC

";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("ss", $training_id, $date);
$stmt->execute();
$result = $stmt->get_result();
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);
?>
