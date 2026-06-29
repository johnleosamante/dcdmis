<?php
// modules/transfer-request/cancel-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/layout/components.php');

$requestId = $_GET['id'] ?? null;

modalConfirmDelete('Are you sure you want to cancel and delete this pending transfer request? This will permanently delete the uploaded document as well.', 'Cancel Transfer Request?', 'cancel-transfer-request', null, $requestId);
