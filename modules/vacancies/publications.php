<?php
// modules/vacancies/publications.php
if (!$isHrmis && !$isHrmpsb) {
    require_once root() . '/modules/error/403.php';
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Publications</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php
        if ($isHrmpsb) {
            contentTitleWithLink('Publications', customUri('hrmpsb', 'Publish Vacancies'), 'Create Publication', 'fa-plus');
        } else {
            contentTitle('Publications');
        }
        ?>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">#</th>
                        <th class="align-middle" width="10%">Code</th>
                        <th class="align-middle" width="30%">Title</th>
                        <th class="align-middle" width="10%">Vacancies</th>
                        <th class="align-middle" width="15%">Open Date</th>
                        <th class="align-middle" width="15%">Close Date</th>
                        <th class="align-middle" width="10%">Status</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $count = 0;
                    $query = allPublications();
                    while ($row = fetchArray($query)):
                        $vacancyCount = countPublicationItems($row['id']);
                        $appsCount = countApplicationsByPublication($row['id']);
                        ?>
                        <tr>
                            <td class="align-middle"><?= ++$count ?></td>
                            <td class="align-middle font-weight-bold"><?= $row['code'] ?></td>
                            <td class="align-middle text-left"><?= $row['title'] ?></td>
                            <td class="align-middle">
                                <span class="badge badge-secondary"><?= $vacancyCount ?> Items</span>
                            </td>
                            <td class="align-middle"><?= toLongDate($row['open_date']) ?></td>
                            <td class="align-middle"><?= toLongDate($row['close_date']) ?></td>
                            <td class="align-middle">
                                <?php if ($row['status'] == 'open'): ?>
                                    <span class="badge badge-success">Open</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary"><?= ucfirst($row['status']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="align-middle text-capitalize">
                                <div class="dropdown no-arrow">
                                    <?php dropdownEllipsis() ?>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                        <?php
                                        linkDropdownItem(customUri('hrmpsb', 'Publication Details', $row['id']), 'View', 'fa-eye', 'View Publication Details');

                                        linkDropdownItem(customUri('hrmpsb', 'Publish Vacancies', $row['id']), 'Edit', 'fa-edit', 'Edit Publication');

                                        modalDropdownItem(uri() . '/modules/vacancies/delete-publication-dialog.php?id=' . cipher($row['id']), 'Delete', 'fa-trash-alt', 'Delete Publication');
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
        </div>
    </div>
</div>