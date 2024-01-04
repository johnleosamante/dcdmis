<?php
// modules/activity/system-log.php
if (!$isDmis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitle('System Log'); ?>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">#</th>
                        <th class="align-middle" width="20%">Date/Time</th>
                        <th class="align-middle" width="50%">Activity</th>
                        <th class="align-middle" width="25%">User</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = systemLogs();
                    $no = 0;
                    while ($row = fetchAssoc($query)) : ?>
                        <tr class="text-uppercase">
                            <td class="align-middle"><?php echo ++$no; ?></td>
                            <td class="align-middle"><?php echo toDatetime($row['datetime']); ?></td>
                            <td class="text-left align-middle"><?php echo $row['activity']; ?></td>
                            <td class="text-center align-middle">
                                <?php $userLabel = $userId === $row['target'] ? 'YOU' : userName($row['target']);
                                modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($row['target']), $userLabel);

                                if ($isDmis || $isHrmis) : ?>
                                    <br><small><?php echo '(' . $row['ip'] . ')'; ?></small>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>