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
$activeApp = $_SESSION["{$prefix}activeApp"] ?? 'pis';

$userPositionId = null;
if (!function_exists('position')) {
    require_once(root() . '/includes/database/position.php');
}
$userPosition = position($userId);
$userPositionId = $userPosition['position_id'] ?? null;
$isAllowedHigherPosition = ($activeApp === 'pis') && (in_array($userPositionId, $allowedMonitoringPositions, true) || $isICT);

if (!$userId || (raceAccessLevel($userId) === 'none' && !$isAllowedHigherPosition)) {
    echo json_encode(['access' => false]);
} else {
    echo json_encode(['access' => true]);
}
