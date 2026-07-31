<div class="card mt-3 mb-4 mx-auto">
    <div class="card-header">
        <?= contentTitle('Call for Applications') ?>
    </div>

    <div class="card-body">
        <p>Please complete the required registration process to
            obtain your official Applicant ID, prior to submission of application.</p>

        <p>Note: Registration is only required once. Your unique Applicant ID will serve and can be
            used
            for current and future call for applications.</p>

        <h5>Application Process</h5>

        <ol class="pl-4">
            <li class="pl-2">Provide the needed
                personal
                information to register and obtain your Applicant ID.</li>
            <li class="pl-2">Select from the available call for applications below.</li>
            <li class="pl-2">Provide your Applicant ID and select the vacant positions you wish to apply for.</li>
            <li class="pl-2">Submit your application to be part of the official roster of applicants of the selected
                call for application.</li>
        </ol>

        <div class="text-center">
            <a href="<?= uri() . '/hrmis/register' ?>"
                class="btn font-weight-bold btn-lg btn-success round">REGISTER</a>
        </div>

        <hr>

        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="50%">Title / Application Deadline</th>
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
                    <tr class="small">
                        <th class="align-middle" width="50%">Title / Description / Application Deadline</th>
                        <th class="align-middle" width="30%">Vacancies</th>
                        <th class="align-middle" width="20%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>