<?php
// modules/race/nominee-action-dialog.php
require_once('access-check.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$nomineeId = isset($_GET['id']) ? $_GET['id'] : null;
$action = isset($_GET['action']) ? sanitize($_GET['action']) : null;
$nominee = $nomineeId ? nomineeDetails(sanitize(decipher($nomineeId))) : null;

$config = [
    'declare_winner' => [
        'title'   => 'Declare Winner',
        'icon'    => 'fa-trophy',
        'iconColor' => 'text-warning',
        'message' => 'Are you sure you want to declare this nominee as the <strong class="text-success">winner</strong>?',
        'btnClass' => 'btn-success',
        'btnName' => 'declare-winner',
        'btnText' => 'Yes, Declare Winner',
    ],
    'revert_winner' => [
        'title'   => 'Revert Winner',
        'icon'    => 'fa-undo',
        'iconColor' => 'text-warning',
        'message' => 'Are you sure you want to <strong class="text-warning">revert</strong> this winner back to a standard nominee?',
        'btnClass' => 'btn-warning',
        'btnName' => 'revert-winner',
        'btnText' => 'Yes, Revert Winner',
    ],
    'disqualify' => [
        'title'   => 'Disqualify Nominee',
        'icon'    => 'fa-ban',
        'iconColor' => 'text-danger',
        'message' => 'Are you sure you want to <strong class="text-danger">disqualify</strong> this nominee?',
        'btnClass' => 'btn-danger',
        'btnName' => 'disqualify-nominee',
        'btnText' => 'Yes, Disqualify',
    ],
];

$c = $config[$action] ?? null;
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader($c ? $c['title'] : 'Action'); ?>

        <div class="modal-body">
            <?php if ($nominee && $c): ?>
                <div class="text-center mb-3">
                    <div class="<?= $c['iconColor'] ?> mb-2" style="font-size: 2.5rem;">
                        <i class="fas <?= $c['icon'] ?>"></i>
                    </div>
                </div>
                <p class="text-center"><?= $c['message'] ?></p>
                <div class="bg-light rounded p-3 text-center">
                    <?php if (isset($nominee['nominee_type']) && $nominee['nominee_type'] === 'School'): ?>
                        <div class="font-weight-bold text-dark text-uppercase"><?= e($nominee['school_name'] ?: 'Unknown School') ?></div>
                    <?php elseif ($nominee['last_name'] !== null): ?>
                        <div class="font-weight-bold text-dark text-uppercase"><?= toName($nominee['last_name'], $nominee['first_name'], $nominee['middle_name'], $nominee['name_extension']) ?></div>
                        <div class="text-muted small"><?= e($nominee['position']) ?></div>
                    <?php else: ?>
                        <div class="font-weight-bold text-dark">Nominee ID: <?= e($nominee['nominee_id']) ?></div>
                    <?php endif; ?>
                    <hr class="my-2">
                    <div class="small text-muted"><?= e($nominee['award_name']) ?> &bull; <?= e($nominee['category_name']) ?></div>
                </div>
            <?php else: ?>
                <p class="text-danger text-center">Nominee not found or invalid action.</p>
            <?php endif; ?>
        </div>

        <div class="modal-footer">
            <?php if ($nominee && $c): ?>
                <form action="" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="verifier" value="<?= e($nomineeId) ?>">
                    <input type="submit" class="btn <?= $c['btnClass'] ?>" name="<?= e($c['btnName']) ?>" value="<?= e($c['btnText']) ?>">
                    <?php cancelModalButton() ?>
                </form>
            <?php else: ?>
                <?php cancelModalButton() ?>
            <?php endif; ?>
        </div>
    </div>
</div>
