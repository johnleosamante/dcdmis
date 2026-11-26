<?php

require_once __DIR__ . '/../includes/function.php';
require_once(root() . '/includes/database/database.php');

header('Content-Type: application/json');

$training_id = isset($_GET['training_id']) ? base64_decode($_GET['training_id']) : '';
$date = isset($_GET['date']) ? base64_decode($_GET['date']) : '';

if (!$training_id || !$date) {
    echo json_encode([]);
    exit;
}

$sql = "
    SELECT
        CONCAT(
            UPPER(e.last_name), ', ',
            e.first_name,
            IF(
                e.name_extension IS NOT NULL AND e.name_extension != '',
                CONCAT(' ', e.name_extension),
                ''
            ),
            IF(
                e.middle_name IS NOT NULL AND e.middle_name != '',
                CONCAT(' ', LEFT(e.middle_name, 1), '.'),
                ''
            )
        ) AS name,
        e.sex AS gender,
        e.profile_picture,
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

$data = query($sql, [$training_id, $date]);
echo json_encode(is_array($data) ? $data : []);
