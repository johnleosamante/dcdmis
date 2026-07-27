<?php
// modules/race/delete-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/layout/components.php');

$id = $_GET['id'] ?? null;
$type = $_GET['type'] ?? '';

switch ($type) {
    case 'award':
        modalConfirmDelete('This operation cannot be undone. Are you sure you want to continue and delete this award?', 'Delete Award?', 'delete-recognition-award', $id);
        break;
    case 'nominee':
        modalConfirmDelete('This operation cannot be undone. Are you sure you want to continue and delete this nominee?', 'Delete Nominee?', 'delete-nominee', $id);
        break;
    case 'schedule':
        modalConfirmDelete('This operation cannot be undone. Are you sure you want to continue and delete this schedule?', 'Delete Schedule?', 'delete-schedule', $id);
        break;
    default:
        echo '<div class="modal-dialog"><div class="modal-content">';
        modalHeader('Error');
        echo '<div class="modal-body"><p>Invalid delete type.</p></div>';
        cancelModalButton();
        echo '</div></div>';
}
