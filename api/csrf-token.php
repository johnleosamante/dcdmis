<?php
// public/api/csrf-token.php
require_once __DIR__ . '/../includes/function.php';

header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');

echo json_encode([
    'success' => true,
    'csrf_token' => csrf_token()
]);
exit();