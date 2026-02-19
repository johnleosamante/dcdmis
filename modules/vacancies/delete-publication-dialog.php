<?php
// modules/vacancies/delete-publication-dialog.php
require_once '../../includes/function.php';
require_once '../../includes/database/database.php';
require_once '../../includes/database/vacancy.php';

if (!isset($_GET['id'])) {
    return;
}

$id = sanitize(decipher($_GET['id']));
$publication = fetchAssoc(publication($id));
?>

<div class="modal-header">
    <h5 class="modal-title text-danger" id="exampleModalLabel">Delete Publication</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>

<div class="modal-body">
    <div class="alert alert-warning text-center">
        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i><br>
        Are you sure you want to delete this publication?
    </div>

    <div class="text-center font-weight-bold mb-3">
        <?= $publication['title'] ?>
    </div>

    <div class="text-center text-muted small">
        Code:
        <?= $publication['code'] ?><br>
        This action cannot be undone. Associated applications may lose their reference.
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
    <form action="<?= uri() . '/hrmpsb/app.php' ?>" method="POST">
        <input type="hidden" name="verifier" value="<?= cipher($id) ?>">
        <button type="submit" name="delete-publication" class="btn btn-danger">Delete</button>
    </form>
</div>