<?php
// modules/race/check-access.php
// Lightweight endpoint for JS polling to verify access is still valid
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/account.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/recognition.php');

header('Content-Type: application/json');

$prefix = alias() . '_';
$userId = $_SESSION["{$prefix}userId"] ?? null;

if (!$userId || raceAccessLevel($userId) === 'none') {
    echo json_encode(['access' => false]);
} else {
    echo json_encode(['access' => true]);
}
