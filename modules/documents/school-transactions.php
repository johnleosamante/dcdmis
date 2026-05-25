<?php
// modules/documents/school-transactions.php
?>

<div class="tab-pane fade" id="school-transactions">
    <div class="row my-3">
        <div class="col table-responsive">
            <?php if ($isDmis) { ?>
                <div class="d-sm-flex align-items-center flex-row-reverse mb-2">
                    <div class="d-inline-block">
                        <?php linkButtonSplit(customUri('export', 'school-transactions'), 'Export', 'fa-file-excel', 'Export as Excel file', 'success') ?>
                    </div>
                </div>
            <?php } ?>

            <table class="table table-hover mb-0 text-center" id="data-table-next" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">Logo</th>
                        <th class="align-middle" width="35%">School Name / Alias / ID / District / Address</th>
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
                    $schools = schoolsExcept(divisionID());
                    foreach ($schools as $school):
                        $logo = !empty($school['logo']) ? uri() . '/' . $school['logo'] : uri() . '/uploads/division/division.png';
                        $schoolName = $school['name'];
                        $district = district($school['district_id'])['name'];
                        $counts = getStationTransactionCounts($school['alias']);
                        $intervals = [3, 7, 14, 30, 60];
                        $schoolsData[] = [
                            'incoming' => $counts['incoming'],
                            'pending' => $counts['pending'],
                            'outgoing' => $counts['outgoing'],
                            'ongoing' => $counts['ongoing']
                        ];
                        ?>
                        <tr class="text-uppercase">
                            <td class="align-middle">
                                <div class="image-container">
                                    <span class="d-flex justify-content-center align-middle school-logo overflow-hidden">
                                        <img height="100%" src="<?= e($logo) ?>" alt="<?= e($schoolName) ?>">
                                    </span>
                                </div>
                            </td>
                            <td class="align-middle text-left">
                                <div>
                                    <?= "$schoolName (" . $school['alias'] . ')' ?>
                                </div>
                                <div class="small"><?= $school['id'] . ' | ' . $district . ' | ' . $school['address'] ?>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div><?= number_format($counts['incoming']) ?></div>
                                <div class="small">
                                    <?php
                                    $incoming = [];

                                    foreach ($intervals as $days) {
                                        $count = $counts['incoming_lapsed'][$days] ?? 0;

                                        if ($count > 0) {
                                            $incoming[] = sprintf(
                                                '<span class="cursor-pointer" title="%d days lapsed">%s</span>',
                                                $days,
                                                number_format($count)
                                            );
                                        }
                                    }
                                    echo implode(' | ', $incoming);
                                    ?>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div><?= number_format($counts['pending']) ?></div>
                                <div class="small">
                                    <?php
                                    $pending = [];

                                    foreach ($intervals as $days) {
                                        $count = $counts['pending_lapsed'][$days] ?? 0;

                                        if ($count > 0) {
                                            $pending[] = sprintf(
                                                '<span class="cursor-pointer" title="%d days lapsed">%s</span>',
                                                $days,
                                                number_format($count)
                                            );
                                        }
                                    }
                                    echo implode(' | ', $pending);
                                    ?>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div><?= number_format($counts['outgoing']) ?></div>
                                <div class="small">
                                    <?php
                                    $outgoing = [];

                                    foreach ($intervals as $days) {
                                        $count = $counts['outgoing_lapsed'][$days] ?? 0;

                                        if ($count > 0) {
                                            $outgoing[] = sprintf(
                                                '<span class="cursor-pointer" title="%d days lapsed">%s</span>',
                                                $days,
                                                number_format($count)
                                            );
                                        }
                                    }
                                    echo implode(' | ', $outgoing);
                                    ?>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="text-2x"><?= number_format($counts['ongoing']) ?></div>
                                <div class="small">
                                    <?php
                                    $ongoing = [];

                                    foreach ($intervals as $days) {
                                        $count = $counts['ongoing_lapsed'][$days] ?? 0;

                                        if ($count > 0) {
                                            $ongoing[] = sprintf(
                                                '<span class="cursor-pointer" title="%d days lapsed">%s</span>',
                                                $days,
                                                number_format($count)
                                            );
                                        }
                                    }
                                    echo implode(' | ', $ongoing);
                                    ?>
                                </div>
                            </td>
                            <?php if ($isDmis): ?>
                                <td class="align-middle text-capitalize">
                                    <div class="dropdown no-arrow">
                                        <?php dropdownEllipsis() ?>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                            <?php modalDropdownItem(uri() . '/modules/documents/bulk-process-document-dialog.php?id=' . cipher($school['alias']), 'Bulk Process', 'fa-list', 'Bulk Process Document') ?>
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
                        <th class="align-middle" width="5%">Logo</th>
                        <th class="align-middle" width="35%">School Name / Alias / ID / District / Address</th>
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