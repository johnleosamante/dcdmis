<?php
// modules/employees/save-non-regular-employee-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/string.php');
require_once(root() . '/includes/layout/components.php');
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader('Add Non-Regular Employee') ?>

        <form action="" method="POST">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="employment_type" class="mb-0">Employment Type <?php showAsterisk() ?></label>
                    <select id="employment_type" name="employment_type" class="form-control"
                        title="Select employment type..." required>
                        <option value="">Select category...</option>
                        <option value="Contract of Service">Contract of Service (COS)</option>
                        <option value="Job Order">Job Order (JO)</option>
                        <option value="Casual">Casual</option>
                        <option value="Substitute Teacher">Substitute Teacher</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="lname" class="mb-0">Last Name <?php showAsterisk() ?></label>
                    <input id="lname" name="lname" class="form-control" type="text" placeholder="ex. DELA CRUZ"
                        title="ex. DELA CRUZ" required>
                </div>

                <div class="form-group">
                    <label for="fname" class="mb-0">First Name <?php showAsterisk() ?></label>
                    <input id="fname" name="fname" class="form-control" type="text" placeholder="ex. JUAN"
                        title="ex. JUAN" required>
                </div>

                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            <label for="mname" class="mb-0">Middle Name</label>
                            <input id="mname" name="mname" class="form-control" placeholder="ex. BAUTISTA"
                                title="ex. BAUTISTA, Leave blank if not applicable" type="text">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="ext" class="mb-0">Extension</label>
                            <select class="form-control" id="ext" name="ext">
                                <option value="">N/A</option>
                                <option value="jr.">JR.</option>
                                <option value="sr.">SR.</option>
                                <option value="ii">II</option>
                                <option value="iii">III</option>
                                <option value="iv">IV</option>
                                <option value="v">V</option>
                                <option value="vi">VI</option>
                                <option value="vii">VII</option>
                                <option value="viii">VIII</option>
                                <option value="ix">IX</option>
                                <option value="x">X</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <label for="sex" class="mb-0">Sex <?php showAsterisk() ?></label>
                            <select name="sex" class="form-control" id="sex" title="Select sex..." required>
                                <option value="">Select sex...</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-7">
                        <div class="form-group">
                            <label for="bdate" class="mb-0">Date of Birth <?php showAsterisk() ?></label>
                            <input type="date" id="bdate" name="bdate" value="<?= date('Y-m-d') ?>" class="form-control"
                                title="Set date of birth..." required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="mb-0">Email Address <?php showAsterisk() ?></label>
                    <input id="email" name="email" class="form-control" type="email" title="ex. juan.delacruz@gmail.com"
                        placeholder="ex. juan.delacruz@gmail.com" required>
                    <small class="form-text text-muted">Non-regular employees can use any valid email address (e.g.
                        Gmail, Yahoo).</small>
                </div>

                <div class="form-group">
                    <label for="mobile" class="mb-0">Mobile Number <?php showAsterisk() ?></label>
                    <input id="mobile" name="mobile" class="form-control" type="text" placeholder="ex. 09XX-XXX-XXXX"
                        title="ex. 09XX-XXX-XXXX" pattern="\d{4}[\-]\d{3}[\-]\d{4}" required>
                </div>

                <div class="form-group">
                    <label for="position" class="mb-0">Position <?php showAsterisk() ?></label>
                    <select id="position" name="position" class="form-control" title="Select position..." required>
                        <option value="">Select position...</option>
                        <?php
                        $categories = positionCategories();
                        foreach ($categories as $category): ?>
                            <optgroup label="<?= e($category['category']) ?>">
                                <?php $jobPositions = positionsByCategory($category['category']);
                                foreach ($jobPositions as $jobPosition): ?>
                                    <option value="<?= e($jobPosition['id']) ?>"><?= e($jobPosition['official_title']) ?>
                                    </option>
                                <?php endforeach ?>
                            </optgroup>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="station" class="mb-0">Station <?php showAsterisk() ?></label>
                    <select id="station" name="station" class="form-control" title="Select station..." required>
                        <option value="">Select station...</option>
                        <?php
                        $currentStation = '';
                        if (!empty($_GET['s'])) {
                            $decodedS = sanitize(decode($_GET['s']));
                            $currentStation = !empty($decodedS) ? $decodedS : sanitize(decipher($_GET['s']));
                        } elseif (!empty($_GET['station'])) {
                            $currentStation = sanitize($_GET['station']);
                        } elseif (!empty($_GET['school_id'])) {
                            $currentStation = sanitize($_GET['school_id']);
                        }

                        $districts = districts();
                        foreach ($districts as $district): ?>
                            <optgroup label="<?= e($district['name']) ?>">
                                <?php
                                $schools = schoolsByDistrict($district['id']);
                                foreach ($schools as $school): ?>
                                    <option value="<?= e($school['id']) ?>" <?= setOptionSelected($school['id'], $currentStation) ?>><?= e($school['name']) ?></option>
                                <?php endforeach ?>
                            </optgroup>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="fund_source" class="mb-0">Fund Source <?php showAsterisk() ?></label>
                    <select id="fund_source" name="fund_source" class="form-control" title="Select fund source..."
                        required>
                        <option value="">Select fund source...</option>
                        <option value="Division Funds">Division Funds</option>
                        <option value="School MOOE">School MOOE</option>
                        <option value="LGU / SEF Funds">Local Government Unit (LGU / SEF)</option>
                        <option value="National / Central Office Funds">National / Central Office Funds</option>
                        <option value="PTA / Donated Funds">PTA / Donated Funds</option>
                        <option value="Others">Others</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status" class="mb-0">Status <?php showAsterisk() ?></label>
                    <select id="status" name="status" class="form-control" title="Select status..." required>
                        <option value="">Select status...</option>
                        <option value="Active" selected>Active</option>
                        <option value="Inactive">Inactive</option>
                        <option value="Terminated">Terminated</option>
                        <option value="Resigned">Resigned</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="start_date" class="mb-0">Start Date of Service</label>
                            <input type="date" id="start_date" name="start_date" class="form-control"
                                title="Set start date of contract/service...">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="end_date" class="mb-0">End Date of Service</label>
                            <input type="date" id="end_date" name="end_date" class="form-control"
                                title="Set end date of contract/service...">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="gsis_id" class="mb-0">GSIS ID</label>
                            <input id="gsis_id" name="gsis_id" class="form-control" placeholder="XXX-XXXX-XXXX-X"
                                title="Leave blank if not applicable" type="text">
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="gsis_bp" class="mb-0">GSIS BP</label>
                            <input id="gsis_bp" name="gsis_bp" class="form-control" placeholder="XXX-XXXX-XXX"
                                title="Leave blank if not applicable" type="text">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="pagibig" class="mb-0">PAGIBIG</label>
                            <input id="pagibig" name="pagibig" class="form-control" placeholder="XXXX-XXXX-XXXX"
                                title="Leave blank if not applicable" type="text">
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="philhealth" class="mb-0">PhilHealth</label>
                            <input id="philhealth" name="philhealth" class="form-control" placeholder="XX-XXXXXXXXX-X"
                                title="Leave blank if not applicable" type="text">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="tin" class="mb-0">TIN</label>
                            <input id="tin" name="tin" class="form-control" placeholder="XXX-XXX-XXX"
                                title="Leave blank if not applicable" type="text">
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="agency_id" class="mb-0">ID / Control No.</label>
                            <input id="agency_id" name="agency_id" class="form-control" placeholder="XXXXXXX"
                                title="Leave blank if not applicable" type="text">
                        </div>
                    </div>
                </div>

                <?php requiredLegend(0) ?>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary" name="add-non-regular-employee" type="submit">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>