<?php
// modules/documents/school-transactions.php
?>

<div class="tab-pane fade show active" id="section-transactions">
    <div class="row my-3">
        <div class="col table-responsive">
            <?php if ($isDmis) { ?>
                <div class="d-sm-flex align-items-center flex-row-reverse mb-2">
                    <div class="d-inline-block">
                        <?php linkButtonSplit(customUri('export', 'section-transactions'), 'Export', 'fa-file-excel', 'Export as Excel file', 'success') ?>
                    </div>
                </div>
            <?php } ?>

            <table class="table table-hover mb-0 text-center" id="data-table-previous" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="40%">Section Name / Functional Division</th>
                        <th class="align-middle" width="15%">Incoming</th>
                        <th class="align-middle" width="15%">Pending</th>
                        <th class="align-middle" width="15%">Outgoing</th>
                        <th class="align-middle" width="15%">Ongoing</th>
                        <?php if ($isDmis): ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $sections = sections();
                    foreach ($sections as $section):
                        $counts = getStationTransactionCounts($section['id']);

                        $sectionsData[] = [
                            'incoming' => $counts['incoming'],
                            'pending' => $counts['pending'],
                            'outgoing' => $counts['outgoing'],
                            'ongoing' => $counts['ongoing']
                        ] ?>
                        <tr class="text-uppercase">
                            <td class="align-middle text-left">
                                <div><?= $section['name'] ?></div>
                                <div class="small"><?= e($section['functional_division']) ?></div>
                            </td>
                            <td class="align-middle"><?= number_format($counts['incoming']) ?></td>
                            <td class="align-middle"><?= number_format($counts['pending']) ?></td>
                            <td class="align-middle"><?= number_format($counts['outgoing']) ?></td>
                            <td class="align-middle"><?= number_format($counts['ongoing']) ?></td>
                            <?php if ($isDmis): ?>
                                <td class="align-middle text-capitalize">
                                    <div class="dropdown no-arrow">
                                        <?php dropdownEllipsis() ?>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                            <?php modalDropdownItem(uri() . '/modules/documents/bulk-process-document-dialog.php?id=' . cipher($section['id']), 'Bulk Process', 'fa-list', 'Bulk Process Document') ?>
                                        </div>
                                    </div>
                                </td>
                            <?php endif;
                            continue; ?>
                        </tr>
                    <?php endforeach ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="40%">Section Name / Functional Division</th>
                        <th class="align-middle" width="15%">Incoming</th>
                        <th class="align-middle" width="15%">Pending</th>
                        <th class="align-middle" width="15%">Outgoing</th>
                        <th class="align-middle" width="15%">Ongoing</th>
                        <?php if ($isDmis): ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>