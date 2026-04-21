<?php
// modules/documents/school-transactions.php
?>

<div class="tab-pane fade" id="section-transactions">
    <div class="row my-3">
        <div class="col table-responsive">
            <?php if ($isDmis) { ?>
                <div class="d-sm-flex align-items-center flex-row-reverse mb-2">
                    <div class="d-inline-block">
                        <?php linkButtonSplit(customUri('export', 'section-transactions'), 'Export', 'fa-file-excel', 'Export as Excel file', 'success') ?>
                    </div>
                </div>
            <?php } ?>

            <table class="table table-hover mb-0 text-center" id="data-table-next" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="40%">Section Name / Functional Division</th>
                        <th class="align-middle" width="15%">Incoming</th>
                        <th class="align-middle" width="15%">Pending</th>
                        <th class="align-middle" width="15%">Outgoing</th>
                        <th class="align-middle" width="15%">Ongoing</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $sections = sections();
                    foreach ($sections as $section): ?>
                        <tr class="text-uppercase">
                            <td class="align-middle text-left">
                                <div>
                                    <?php linkItem(customUri($activeApp, 'Section Information', $section['id']), $section['name']) ?>
                                </div>
                                <div class="small"><?= e($section['functional_division']) ?></div>
                            </td>
                            <td class="align-middle"><?= number_format(count(incomingDocuments($section['id']))) ?></td>
                            <td class="align-middle"><?= number_format(count(pendingDocuments($section['id']))) ?></td>
                            <td class="align-middle"><?= number_format(count(outgoingDocuments($section['id']))) ?></td>
                            <td class="align-middle"><?= number_format(count(ongoingDocuments($section['id']))) ?></td>
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
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>