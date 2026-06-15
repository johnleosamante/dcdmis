<div class="card mt-3 mb-4 mx-auto">
    <div class="card-header">
        <?= contentTitle('Call for Applications') ?>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="50%">Title</th>
                        <th class="align-middle" width="30%">Vacancies</th>
                        <th class="align-middle" width="20%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $publications = activePublications();
                    if ($publications) {
                        foreach ($publications as $row) {
                            $vacancyCount = countPublicationItems($row['id']); ?>
                            <tr class="text-uppercase">
                                <td class="align-middle text-left">
                                    <div>
                                        <span class="font-weight-bold">
                                            <?= e($row['title']) ?>
                                        </span>
                                    </div>
                                    <?php if ($row['description']): ?>
                                        <div>
                                            <span class="small">
                                                <?= e($row['description']) ?>
                                            </span>
                                        </div>
                                    <?php endif ?>
                                    <div>
                                        <span class="badge badge-danger badge-pill">
                                            <?= "Deadline of Submission: " . toLongDate($row['close_date']) ?>
                                        </span>
                                    </div>
                                </td>
                                <td class="align-middle"><span
                                        class="badge badge-secondary badge-pill"><?= "$vacancyCount Items" ?></span>
                                </td>
                                <td class="align-middle"><span class="badge badge-success badge-pill px-4 py-2 text-lg"><a
                                            href="<?= uri() . '/hrmis/apply?p=' . $row['code'] ?>"
                                            class="text-white">Apply</a></span></td>
                            </tr>
                        <?php }
                    } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="50%">Title</th>
                        <th class="align-middle" width="30%">Vacancies</th>
                        <th class="align-middle" width="20%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>