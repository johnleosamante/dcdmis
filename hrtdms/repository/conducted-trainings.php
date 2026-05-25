<?php
// hrtdms/repository/conducted-trainings.php
?>

<div class="card-header">
    <?= contentTitle('Conducted Trainings') ?>
</div>

<div class="card-body">
    <?= dateFilterForm($fromDate, $toDate) ?>

    <div class="table-responsive">
        <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th class="align-middle" width="65%">Title of Division Training</th>
                    <th class="align-middle" width="35%">Conducted on</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $trainings = conductedTrainings($fromDate, $toDate);
                foreach ($trainings as $training) { ?>
                    <tr class="text-uppercase">
                        <td class="align-middle text-left">
                            <?php linkItem(customUri('hrtdms/repository', 'Training Details', $training['id']), toTruncate($training['title'])) ?>
                        </td>
                        <td class="align-middle">
                            <?= empty($training['unconsecutive_date']) ? toDateRange($training['start_date'], $training['end_date']) : toHandleEncoding($training['unconsecutive_date']) ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>

            <tfoot>
                <tr>
                    <th class="align-middle" width="65%">Title of Division Training</th>
                    <th class="align-middle" width="35%">Conducted on</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>