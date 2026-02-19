<?php
// hrmpsb/apply/index.php
require_once '../../includes/function.php';
require_once root() . '/includes/string.php';
require_once root() . '/includes/database/database.php';
require_once root() . '/includes/database/vacancy.php';
require_once root() . '/includes/layout/components.php';

$code = isset($_GET['p']) ? sanitize($_GET['p']) : null;
$error = null;
$publication = null;
$vacancies = null;

if ($code) {
    $result = publicationByCode($code);
    if (numRows($result) > 0) {
        $publication = fetchAssoc($result);
        if ($publication['status'] !== 'open') {
            $error = 'This publication is currently closed.';
        } elseif (strtotime($publication['close_date']) < strtotime(date('Y-m-d'))) {
            $error = 'The application period for this publication has ended.';
        } elseif (strtotime($publication['open_date']) > strtotime(date('Y-m-d'))) {
            $error = 'The application period for this publication has not started yet.';
        } else {
            $vacancies = publicationItems($publication['id']);
        }
    } else {
        $error = 'Publication not found.';
    }
} else {
    $error = 'Invalid publication link.';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= SITE_DESCRIPTION ?>">
    <meta name="author" content="<?= SITE_AUTHOR ?>">
    <title>Apply Online - <?= SITE_TITLE ?></title>
    <link href="<?= uri() ?>/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="<?= uri() ?>/assets/css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .bg-login-image {
            background: url('<?= uri() ?>/assets/img/deped-bg.jpg');
            background-position: center;
            background-size: cover;
        }
    </style>
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Online Application Form</h1>
                                        <?php if ($publication): ?>
                                            <h2 class="h5 text-primary mb-2"><?= $publication['title'] ?></h2>
                                            <p class="mb-4"><?= $publication['description'] ?></p>
                                            <p class="small text-muted mb-4">
                                                Application Period:
                                                <span
                                                    class="font-weight-bold text-dark"><?= toLongDate($publication['open_date']) ?></span>
                                                to
                                                <span
                                                    class="font-weight-bold text-dark"><?= toLongDate($publication['close_date']) ?></span>
                                            </p>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ($error): ?>
                                        <div class="alert alert-danger text-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            <?= $error ?>
                                        </div>
                                        <div class="text-center mt-4">
                                            <a href="<?= uri() ?>" class="btn btn-secondary">Go to Homepage</a>
                                        </div>
                                    <?php else: ?>
                                        <form class="user" action="submit.php" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="publication_id"
                                                value="<?= cipher($publication['id']) ?>">

                                            <div class="vacancies-container mb-4">
                                                <div class="alert alert-info py-2 small">
                                                    <i class="fas fa-info-circle mr-1"></i>
                                                    Check the box for each position you wish to apply for.
                                                </div>
                                                <div class="table-responsive border rounded">
                                                    <table class="table table-sm table-hover mb-0">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th width="5%" class="text-center">#</th>
                                                                <th width="60%">Position</th>
                                                                <th width="35%">Availability</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if ($vacancies && numRows($vacancies) > 0) {
                                                                $groups = [];
                                                                $vacancies->data_seek(0);
                                                                while ($row = fetchAssoc($vacancies)) {
                                                                    $pid = $row['position_id'];
                                                                    if (!isset($groups[$pid])) {
                                                                        $groups[$pid] = [
                                                                            'position' => $row['position'],
                                                                            'salary_grade' => $row['salary_grade'],
                                                                            'count' => 0
                                                                        ];
                                                                    }
                                                                    $groups[$pid]['count']++;
                                                                }

                                                                foreach ($groups as $pid => $group) {
                                                                    ?>
                                                                    <tr>
                                                                        <td class="text-center align-middle">
                                                                            <input type="checkbox" name="position_ids[]"
                                                                                value="<?= cipher($pid) ?>" id="pos_<?= $pid ?>"
                                                                                style="transform: scale(1.2);">
                                                                        </td>
                                                                        <td class="align-middle">
                                                                            <label for="pos_<?= $pid ?>"
                                                                                class="mb-0 font-weight-bold"
                                                                                style="cursor: pointer;">
                                                                                <?= $group['position'] ?>
                                                                            </label>
                                                                            <div class="small text-muted">Salary Grade
                                                                                <?= $group['salary_grade'] ?></div>
                                                                        </td>
                                                                        <td class="align-middle">
                                                                            <span class="badge badge-success badge-pill px-3 py-2">
                                                                                <?= $group['count'] ?>
                                                                                Item<?= $group['count'] > 1 ? 's' : '' ?> Available
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            } else {
                                                                echo '<tr><td colspan="3" class="text-center text-muted">No vacancies found.</td></tr>';
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox ml-2">
                                                    <input type="checkbox" class="custom-control-input" id="is_employee"
                                                        name="is_employee" value="1">
                                                    <label class="custom-control-label font-weight-bold text-primary"
                                                        for="is_employee">I am a DepEd Dipolog Employee</label>
                                                </div>
                                            </div>

                                            <div class="form-group" id="employee-id-group" style="display: none;">
                                                <label for="employee_id"
                                                    class="small font-weight-bold text-dark ml-2">Employee ID <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-user" id="employee_id"
                                                    name="employee_id" placeholder="Enter your 7-digit Employee ID">
                                            </div>

                                            <div id="applicant-details">
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <label for="last_name"
                                                            class="small font-weight-bold text-dark ml-2">Last Name <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-user"
                                                            id="last_name" name="last_name" placeholder="Last Name"
                                                            required>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="first_name"
                                                            class="small font-weight-bold text-dark ml-2">First Name <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-user"
                                                            id="first_name" name="first_name" placeholder="First Name"
                                                            required>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="middle_name"
                                                            class="small font-weight-bold text-dark ml-2">Middle
                                                            Name</label>
                                                        <input type="text" class="form-control form-control-user"
                                                            id="middle_name" name="middle_name" placeholder="Middle Name">
                                                    </div>
                                                    <div class="form-group col-md-1">
                                                        <label for="ext_name"
                                                            class="small font-weight-bold text-dark ml-2">Ext.</label>
                                                        <input type="text" class="form-control form-control-user"
                                                            id="ext_name" name="ext_name" placeholder="Jr.">
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <label for="sex" class="small font-weight-bold text-dark ml-2">Sex
                                                            <span class="text-danger">*</span></label>
                                                        <select class="form-control form-control-user" id="sex" name="sex"
                                                            required
                                                            style="height: 50px; padding: 10px 20px; border-radius: 10rem;">
                                                            <option value="" disabled selected>Select Sex</option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="birth_date"
                                                            class="small font-weight-bold text-dark ml-2">Birth Date <span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" class="form-control form-control-user"
                                                            id="birth_date" name="birth_date" required>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="civil_status"
                                                            class="small font-weight-bold text-dark ml-2">Civil Status <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-control form-control-user" id="civil_status"
                                                            name="civil_status" required
                                                            style="height: 50px; padding: 10px 20px; border-radius: 10rem;">
                                                            <option value="" disabled selected>Select Status</option>
                                                            <option value="Single">Single</option>
                                                            <option value="Married">Married</option>
                                                            <option value="Widowed">Widowed</option>
                                                            <option value="Separated">Separated</option>
                                                            <option value="Annulled">Annulled</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="address"
                                                        class="small font-weight-bold text-dark ml-2">Current Address <span
                                                            class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="address" name="address" rows="2"
                                                        placeholder="House No., Street, Barangay, City/Municipality, Province"
                                                        required style="border-radius: 1rem; padding: 15px;"></textarea>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="religion"
                                                            class="small font-weight-bold text-dark ml-2">Religion</label>
                                                        <input type="text" class="form-control form-control-user"
                                                            id="religion" name="religion" placeholder="Religion">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="ethnic_group"
                                                            class="small font-weight-bold text-dark ml-2">Indigenous/Ethnic
                                                            Group</label>
                                                        <input type="text" class="form-control form-control-user"
                                                            id="ethnic_group" name="ethnic_group"
                                                            placeholder="If applicable">
                                                    </div>
                                                </div>

                                                <div class="form-group ml-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="is_pwd"
                                                            name="is_pwd" value="1">
                                                        <label class="custom-control-label text-dark font-weight-bold"
                                                            for="is_pwd">I am a Person with Disability (PWD)</label>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="education"
                                                        class="small font-weight-bold text-dark ml-2">Highest Educational
                                                        Attainment/Course <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-user" id="education"
                                                        name="education"
                                                        placeholder="e.g. Bachelor of Science in Information Technology"
                                                        required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="eligibility"
                                                        class="small font-weight-bold text-dark ml-2">Eligibility (Civil
                                                        Service/PRC/etc) <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-user"
                                                        id="eligibility" name="eligibility"
                                                        placeholder="e.g. RA 1080 (Teacher), CS Professional" required>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                                        <label for="email"
                                                            class="small font-weight-bold text-dark ml-2">Email Address
                                                            <span class="text-danger">*</span></label>
                                                        <input type="email" class="form-control form-control-user"
                                                            id="email" name="email" placeholder="Email Address" required>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="mobile"
                                                            class="small font-weight-bold text-dark ml-2">Mobile Number
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-user"
                                                            id="mobile" name="mobile" placeholder="Mobile Number" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="resume" class="small font-weight-bold text-dark ml-2">Pertinent Documents (PDF only) <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control-file ml-3" id="resume" name="resume"
                                                    accept=".pdf" required>
                                                <small class="form-text text-muted ml-3">Max file size: 5MB</small>
                                            </div>

                                            <button type="submit" class="btn btn-primary btn-user btn-block mt-4">
                                                Submit Application
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <hr>
                                    <div class="text-center">
                                        <span class="small text-muted">&copy; <?= date('Y') ?> <?= SITE_TITLE ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= uri() ?>/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= uri() ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= uri() ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?= uri() ?>/assets/js/sb-admin-2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#is_employee').change(function () {
                const applicantFields = '#last_name, #first_name, #email, #mobile, #sex, #birth_date, #civil_status, #address, #education, #eligibility';
                if (this.checked) {
                    $('#employee-id-group').show();
                    $('#applicant-details').hide();
                    $('#deped_email').prop('required', true);
                    $(applicantFields).prop('required', false);
                } else {
                    $('#employee-id-group').hide();
                    $('#applicant-details').show();
                    $('#deped_email').prop('required', false);
                    $(applicantFields).prop('required', true);
                }
            });
        });
    </script>

</body>

</html>