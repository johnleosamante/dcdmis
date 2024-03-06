<?php
// dtcf/conducted-trainings.php
?>

<div class="card mt-3 mb-5 mx-auto">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="65%">Title of Division Training</th>
                        <th class="align-middle" width="35%">Conducted on</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $trainings = conductedTrainings();
                    while ($training = fetchAssoc($trainings)) : ?>
                        <tr>
                            <td class="align-middle text-left">
                                <?php linkItem(customUri('dtcf', 'Training Details', $training['no']), $training['title']); ?>
                            </td>
                            <td class="align-middle">
                                <?php echo empty($training['unconsecutive_date']) ? toDateRange($training['from'], $training['to']) : toHandleEncoding($training['unconsecutive_date']); ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>