<?php
// modules/race/access-check.php
// Shared access guard for RACE AJAX-loaded dialogs
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/account.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/recognition.php');

$prefix = alias() . '_';
$userId = $_SESSION["{$prefix}userId"] ?? null;
$stationId = $_SESSION["{$prefix}stationId"] ?? null;

if (!$userId || raceAccessLevel($userId) === 'none') {
    http_response_code(403);
    echo '<div class="modal-dialog"><div class="modal-content">';
    echo '<div class="modal-header bg-danger text-white"><h5 class="modal-title"><i class="fas fa-ban mr-2"></i>Access Denied</h5>';
    echo '<button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button></div>';
    echo '<div class="modal-body text-center py-5">';
    echo '<div class="text-danger mb-3" style="font-size:3rem;"><i class="fas fa-exclamation-triangle"></i></div>';
    echo '<h5>Your access to Rewards and Recognition has been revoked.</h5>';
    echo '<p class="text-muted small">Please contact the administrator if you believe this is an error.</p>';
    echo '</div>';
    echo '<div class="modal-footer"><button class="btn btn-secondary" data-dismiss="modal" onclick="location.reload()">Close</button></div>';
    echo '</div></div>';
    exit;
}
