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
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $schools = schoolsExcept(divisionID());
                    foreach ($schools as $school):
                        $logo = !empty($school['logo']) ? uri() . '/' . $school['logo'] : uri() . '/uploads/division/division.png';
                        $schoolName = $school['name'];
                        $district = district($school['district_id'])['name'];
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
                            <td class="align-middle"><?= number_format(countIncomingDocuments($school['alias'])) ?></td>
                            <td class="align-middle"><?= number_format(countPendingDocuments($school['alias'])) ?></td>
                            <td class="align-middle"><?= number_format(countOutgoingDocuments($school['alias'])) ?></td>
                            <td class="align-middle"><?= number_format(countOngoingDocuments($school['alias'])) ?></td>
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
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>