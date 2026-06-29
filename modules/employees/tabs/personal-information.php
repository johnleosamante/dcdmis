<?php
// modules/employees/tabs/personal-information.php
?>

<div class="tab-pane fade<?= setActiveNavigation(!isset($activeTab) || $activeTab === 'personal-information', 'show active') ?>"
    id="personal-information">
    <?php if ($editMode): ?>
        <form action="" method="POST" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <?php endif ?>
        <div class="row mt-3">
            <div class="col-sm-12 col-md-4 col-lg-3 col-xl-2 mb-4">
                <?php $photo = file_exists(root() . '/' . $employee['profile_picture']) ? uri() . '/' . $employee['profile_picture'] : uri() . '/assets/img/user.png' ?>
                <img src="<?= e($photo) ?>" width="100%" class="border rounded" id="employee-photo">

                <?php if ($editMode): ?>
                    <div class="mt-3 mb-2 custom-file">
                        <input id="image-upload" type="file" name="image-upload" class="custom-file-input" accept="image/png, image/jpeg">
                        <label id="image-upload-label" class="custom-file-label" for="image-upload">Choose file</label>
                    </div>

                    <span class="small text-secondary">The recommended picture size is 1:1 ratio and minimum of 400 pixels
                        width and height.</span>

                    <?php profilePhotoUpload('image-upload', 'employee-photo', 'image-upload-label', uri(), '/assets/img/nopreview.png') ?>
                <?php endif ?>
            </div>

            <div class="col-sm-12 col-md-8 col-lg-9 col-xl-10">
                <div class=" form-group">
                    <label for="lname" class="mb-0">Last Name <?php showAsterisk($editMode) ?></label>
                    <input id="lname" name="lname" type="text" class="form-control" <?= setActiveNavigation($editMode, 'title="Required field"') ?> value="<?= e($employee['last_name']) ?>"
                        <?= setActiveNavigation(!$editMode, 'readonly') ?> required>
                </div>

                <div class="row">
                    <div class="col-lg-9">
                        <div class="form-group">
                            <label for="fname" class="mb-0">First Name <?php showAsterisk($editMode) ?></label>
                            <input id="fname" name="fname" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Required field"') ?>
                                value="<?= e($employee['first_name']) ?>" autocomplete="false"
                                <?= setActiveNavigation(!$editMode, 'readonly') ?> required>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="ext" class="mb-0">Name Extension</label>
                            <input id="ext" name="ext" type="text" class="form-control" maxlength="5"
                                <?= setActiveNavigation($editMode, 'title="Example: Jr., Sr., III (Leave blank if not applicable)"') ?> value="<?= e($employee['name_extension']) ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="mname" class="mb-0">Middle Name</label>
                    <input id="mname" name="mname" type="text" class="form-control" <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?> value="<?= e($employee['middle_name']) ?>"
                        <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="dob" class="mb-0">Date of Birth <?php showAsterisk($editMode) ?></label>
                            <?php if (!$editMode): ?>
                                <input id="dob" type="text" class="form-control"
                                    value="<?= $employee['birthdate'] ?>"
                                    readonly>
                            <?php else: ?>
                                <input id="dob" name="dob" type="date" class="form-control" title="Required field"
                                    value="<?= $employee['birthdate'] ?>"
                                    required>
                            <?php endif ?>
                        </div>
                    </div>

                    <div class="col-lg-9">
                        <div class="form-group">
                            <label for="pob" class="mb-0">Place of Birth <?php showAsterisk($editMode) ?></label>
                            <input id="pob" name="pob" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Required field"') ?>
                                value="<?= e($employee['place_of_birth']) ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>
                                required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="sex" class="mb-0">Sex <?php showAsterisk($editMode) ?></label>
                            <?php if (!$editMode): ?>
                                <input id="sex" type="text" class="form-control" value="<?= e($employee['sex']) ?>" readonly>
                            <?php else: ?>
                                <select id="sex" name="sex" class="form-control" <?= setActiveNavigation($editMode, 'title="Required field"') ?> required>
                                    <option value="Male" <?= setOptionSelected('Male', $employee['sex']) ?>>Male</option>
                                    <option value="Female" <?= setOptionSelected('Female', $employee['sex']) ?>>Female
                                    </option>
                                </select>
                            <?php endif ?>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="civil-status" class="mb-0">Civil Status <?php showAsterisk($editMode) ?></label>
                            <?php if (!$editMode): ?>
                                <input id="civil-status" type="text" class="form-control"
                                    value="<?= e($employee['civil_status']) ?>" readonly>
                            <?php else: ?>
                                <select id="civil-status" name="civil-status" <?= setActiveNavigation($editMode, 'title="Required field"') ?> class="form-control" required>
                                    <option value="Single" <?= setOptionSelected('Single', $employee['civil_status']) ?>>
                                        Single</option>
                                    <option value="Married" <?= setOptionSelected('Married', $employee['civil_status']) ?>>
                                        Married</option>
                                    <option value="Widowed" <?= setOptionSelected('Widowed', $employee['civil_status']) ?>>
                                        Widowed</option>
                                    <option value="Separated" <?= setOptionSelected('Separated', $employee['civil_status']) ?>>Separated</option>
                                    <option value="Others" <?= setOptionSelected('Others', $employee['civil_status']) ?>>
                                        Others</option>
                                </select>
                            <?php endif ?>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="civil-status-specify" class="mb-0">Specify, if Others</label>
                            <input id="civil-status-specify" name="civil-status-specify"
                                <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?>
                                type="text" class="form-control" value="<?= e($employee['specify_other_civil_status']) ?>"
                                <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="religion" class="mb-0">Religion</label>
                            <input id="religion" name="religion"
                                <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?>
                                type="text" class="form-control" value="<?= e($employee['religion']) ?>"
                                <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="height" class="mb-0">Height (m) <?php showAsterisk($editMode) ?></label>
                            <?php if (!$editMode): ?>
                                <input id="height" type="text" class="form-control" value="<?= e($employee['height']) ?>"
                                    readonly>
                            <?php else: ?>
                                <input id="height" name="height" type="number" min="0" step="0.01" class="form-control"
                                    <?= setActiveNavigation($editMode, 'title="Required field"') ?>
                                    value="<?= e($employee['height']) ?>" required>
                            <?php endif ?>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="weight" class="mb-0">Weight (kg) <?php showAsterisk($editMode) ?></label>
                            <?php if (!$editMode): ?>
                                <input id="weight" type="text" class="form-control" value="<?= e($employee['weight']) ?>"
                                    readonly>
                            <?php else: ?>
                                <input id="weight" name="weight" type="number" min="0" step="0.01" class="form-control"
                                    <?= setActiveNavigation($editMode, 'title="Required field"') ?>
                                    value="<?= e($employee['weight']) ?>" required>
                            <?php endif ?>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="blood-type" class="mb-0">Blood Type <?php showAsterisk($editMode) ?></label>
                            <?php if (!$editMode): ?>
                                <input id="blood-type" type="text" class="form-control"
                                    value="<?= e($employee['blood_type']) ?>" readonly>
                            <?php else: ?>
                                <select name="blood-type" id="blood-type" class="form-control"
                                    <?= setActiveNavigation($editMode, 'title="Required field"') ?> required>
                                    <option value="A+" <?= setOptionSelected('A+', $employee['blood_type']) ?>>A+</option>
                                    <option value="A-" <?= setOptionSelected('A-', $employee['blood_type']) ?>>A-</option>
                                    <option value="B+" <?= setOptionSelected('B+', $employee['blood_type']) ?>>B+</option>
                                    <option value="B-" <?= setOptionSelected('B-', $employee['blood_type']) ?>>B-</option>
                                    <option value="AB+" <?= setOptionSelected('AB+', $employee['blood_type']) ?>>AB+</option>
                                    <option value="AB-" <?= setOptionSelected('AB-', $employee['blood_type']) ?>>AB-</option>
                                    <option value="O+" <?= setOptionSelected('O+', $employee['blood_type']) ?>>O+</option>
                                    <option value="O-" <?= setOptionSelected('O-', $employee['blood_type']) ?>>O-</option>
                                </select>
                            <?php endif ?>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="umid" class="mb-0">UMID ID No.</label>
                            <input id="umid" name="umid" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Format: XXXX-XXXXXXX-X (Leave blank if not applicable)" placeholder="XXXX-XXXXXXX-X"') ?> value="<?= e($employee['umid_id']) ?>"
                            <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="crn" class="mb-0">GSIS CRN No.</label>
                            <input id="crn" name="crn" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Format: XXX-XXXX-XXXX-X (Leave blank if not applicable)" placeholder="XXX-XXXX-XXXX-X"') ?> value="<?= e($employee['gsis_crn']) ?>"
                            <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>
                    
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="bp" class="mb-0">GSIS BP No.</label>
                            <input id="bp" name="bp" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Format: XXX-XXXX-XXX (Leave blank if not applicable)" placeholder="XXX-XXXX-XXX"') ?> value="<?= e($employee['gsis_bp']) ?>"
                            <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="pagibig" class="mb-0">PAGIBIG ID No.</label>
                            <input id="pagibig" name="pagibig" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Format: XXXX-XXXX-XXXX (Leave blank if not applicable)" placeholder="XXXX-XXXX-XXXX"') ?> value="<?= e($employee['pagibig']) ?>"
                                <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="philhealth" class="mb-0">PHILHEALTH No.</label>
                            <input id="philhealth" name="philhealth" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Format: XX-XXXXXXXXX-X (Leave blank if not applicable)" placeholder="XX-XXXXXXXXX-X"') ?> value="<?= e($employee['philhealth']) ?>"
                                <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="philsys" class="mb-0">PhilSys No.</label>
                            <input id="philsys" name="philsys" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Format: XXXX-XXXX-XXXX-XXXX (Leave blank if not applicable)" placeholder="XXXX-XXXX-XXXX-XXXX"') ?> value="<?= e($employee['philsys']) ?>"
                            <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="sss" class="mb-0">SSS No.</label>
                            <input id="sss" name="sss" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Format: XX-XXXXXXX-X (Leave blank if not applicable)" placeholder="XX-XXXXXXX-X"') ?> value="<?= e($employee['sss']) ?>"
                            <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>
                    
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="tin" class="mb-0">TIN No.</label>
                            <input id="tin" name="tin" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Format: XXX-XXX-XXX (Leave blank if not applicable)" placeholder="XXX-XXX-XXX"') ?> value="<?= e($employee['tin']) ?>"
                            <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="agency-id" class="mb-0">Agency Employee No.</label>
                            <input id="agency-id" name="agency-id" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Format: XXXXXXX (Leave blank if not applicable)" placeholder="XXXXXXX"') ?> value="<?= e($employee['agency_id']) ?>"
                                <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="prc-id" class="mb-0">PRC ID No.</label>
                            <input id="prc-id" name="prc-id" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Format: XXXXXXX (Leave blank if not applicable)" placeholder="XXXXXXX"') ?> value="<?= e($employee['prc']) ?>"
                                <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="citizenship" class="mb-0">Citizenship <?php showAsterisk($editMode) ?></label>
                            <?php
                            $citizenship = '1';
                            $nationalityName = 'Filipino';
                            $nationality = citizenship($employee['citizenship_id']);
                            if ($nationality) {
                                $nationalityName = $nationality['name'];
                                $citizenship = $nationality['id'];
                            }
                            if (!$editMode): ?>
                                <input id="citizenship" name="citizenship" type="text" class="form-control"
                                    value="<?= e($nationalityName) ?>" readonly>
                            <?php else: ?>
                                <select class="form-control" id="citizenship" name="citizenship"
                                    <?= setActiveNavigation($editMode, 'title="Required field"') ?> required>
                                    <?php $nationalities = citizenships();
                                    foreach ($nationalities as $nationality): ?>
                                        <option value="<?= e($nationality['id']) ?>" <?= setOptionSelected($nationality['id'], $citizenship) ?>><?= e($nationality['name']) ?></option>
                                    <?php endforeach ?>
                                </select>
                            <?php endif ?>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="dual-citizenship" class="mb-0">Dual Citizenship
                                <?php showAsterisk($editMode) ?></label>
                            <?php if (!$editMode): ?>
                                <input id="dual-citizenship" name="dual-citizenship" type="text" class="form-control"
                                    value="<?= e($employee['dual_citizenship_type']) ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?> required>
                            <?php else: ?>
                                <select id="dual-citizenship" name="dual-citizenship" class="form-control"
                                    <?= setActiveNavigation($editMode, 'title="Leave N/A if not applicable"') ?> required>
                                    <option value="N/A" <?= setOptionSelected('N/A', $employee['dual_citizenship_type']) ?>>N/A
                                    </option>
                                    <option value="By Birth" <?= setOptionSelected('By Birth', $employee['dual_citizenship_type']) ?>>By Birth</option>
                                    <option value="By Naturalization" <?= setOptionSelected('By Naturalization', $employee['dual_citizenship_type']) ?>>By Naturalization</option>
                                </select>
                            <?php endif ?>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="dual-citizenship-country" class="mb-0">Please Indicate Country if Dual
                                Citizen</label>
                            <?php if (!$editMode): ?>
                                <?php
                                $countryName = 'N/A';
                                $country = country($employee['dual_citizenship_country_id']);
                                if ($country) {
                                    $countryName = $country['name'];
                                }
                                ?>
                                <input id="dual-citizenship-country" name="dual-citizenship-country" type="text"
                                    class="form-control" value="<?= e($countryName) ?>" readonly>
                            <?php else: ?>
                                <select class="form-control" id="dual-citizenship-country" name="dual-citizenship-country"
                                    <?= setActiveNavigation($editMode, 'title="Leave N/A if not applicable"') ?>>
                                    <option value="N/A">N/A</option>
                                    <?php $countries = countries();
                                    foreach ($countries as $country): ?>
                                        <option value="<?= e($country['id']) ?>" <?= setOptionSelected($country['id'], $employee['dual_citizenship_country_id']) ?>><?= e($country['name']) ?></option>
                                    <?php endforeach ?>
                                </select>
                            <?php endif ?>
                        </div>
                    </div>
                </div>

                <div>Residential Address</div>

                <hr class="mt-2">

                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="rlot" class="mb-0 small">House/Block/Lot No.</label>
                            <input id="rlot" name="rlot" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?>
                                value="<?= e($employee['residence_lot']) ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="rstreet" class="mb-0 small">Street</label>
                            <input id="rstreet" name="rstreet" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?>
                                value="<?= e($employee['residence_street']) ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="rsubdivision" class="mb-0 small">Subdivision/Village</label>
                            <input id="rsubdivision" name="rsubdivision" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?>
                                value="<?= e($employee['residence_subdivision']) ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="rbarangay" class="mb-0 small">Barangay <?php showAsterisk($editMode) ?></label>
                            <input id="rbarangay" name="rbarangay" type=" text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Required field"') ?>
                                value="<?= e($employee['residence_barangay']) ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>
                                required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="rcity" class="mb-0 small">City/Municipality
                                <?php showAsterisk($editMode) ?></label>
                            <input id="rcity" name="rcity" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Required field"') ?>
                                value="<?= e($employee['residence_city']) ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>
                                required>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="rprovince" class="mb-0 small">Province <?php showAsterisk($editMode) ?></label>
                            <input id="rprovince" name="rprovince" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Required field"') ?>
                                value="<?= e($employee['residence_province']) ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>
                                required>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="rzip" class="mb-0 small">ZIP Code <?php showAsterisk($editMode) ?></label>
                            <input id="rzip" name="rzip" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Required field"') ?>
                                value="<?= e($employee['residence_zip']) ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>
                                required>
                        </div>
                    </div>
                </div>

                <div>Permanent Address</div>

                <hr class="mt-2">

                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="plot" class="mb-0 small">House/Block/Lot No.</label>
                            <input id="plot" name="plot" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?>
                                value="<?= e($employee['permanent_lot']) ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="pstreet" class="mb-0 small">Street</label>
                            <input id="pstreet" name="pstreet" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?>
                                value="<?= e($employee['permanent_street']) ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="psubdivision" class="mb-0 small">Subdivision/Village</label>
                            <input id="psubdivision" name="psubdivision" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable"') ?>
                                value="<?= e($employee['permanent_subdivision']) ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="pbarangay" class="mb-0 small">Barangay <?php showAsterisk($editMode) ?></label>
                            <input id="pbarangay" name="pbarangay" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Required field"') ?>
                                value="<?= e($employee['permanent_barangay']) ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>
                                required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="pcity" class="mb-0 small">City/Municipality
                                <?php showAsterisk($editMode) ?></label>
                            <input id="pcity" name="pcity" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Required field"') ?>
                                value="<?= e($employee['permanent_city']) ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>
                                required>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="pprovince" class="mb-0 small">Province <?php showAsterisk($editMode) ?></label>
                            <input id="pprovince" name="pprovince" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Required field"') ?>
                                value="<?= e($employee['permanent_province']) ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>
                                required>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="pzip" class="mb-0 small">ZIP Code <?php showAsterisk($editMode) ?></label>
                            <input id="pzip" name="pzip" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Required field"') ?>
                                value="<?= e($employee['permanent_zip']) ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>
                                required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="telephone" class="mb-0">Telephone Number</label>
                            <input id="telephone" name="telephone" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Leave blank if not applicable" placeholder="XXXX-XXX-XXXX"') ?> value="<?= e($employee['telephone']) ?>"
                                <?= setActiveNavigation(!$editMode, 'readonly') ?>>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="mobile" class="mb-0">Mobile Number <?php showAsterisk($editMode) ?></label>
                            <input id="mobile" name="mobile" type="text" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Required field ex. 09XX-XXX-XXXX" pattern="\d{4}[\-]\d{3}[\-]\d{4}" placeholder="XXXX-XXX-XXXX"') ?>
                                value="<?= e($employee['mobile_number']) ?>" <?= setActiveNavigation(!$editMode, 'readonly') ?>
                                required>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email" class="mb-0">Email Address <?php showAsterisk($editMode) ?></label>
                            <input id="email" name="email" type="email" class="form-control"
                                <?= setActiveNavigation($editMode, 'title="Required field ex. juan.delacruz@deped.gov.ph" pattern="[a-z0-9._%+\-]+@deped.gov.ph" placeholder="juan.delacruz@deped.gov.ph"') ?>
                                value="<?= e($employee['email_address']) ?>" autocomplete="false"
                                <?= setActiveNavigation(!$editMode, 'readonly') ?> required>
                        </div>
                    </div>
                </div>

                <?php if ($editMode): ?>
                    <?php requiredLegend() ?>

                    <div class="form-group mb-3">
                        <input type="hidden" name="image-verifier" value="<?= cipher($employee['profile_picture']) ?>">
                        <input type="hidden" name="verifier" value="<?= cipher($employeeId) ?>">
                        <button class="btn btn-primary btn-block" name="update-personal-information"><i
                                class="fas fa-save fa-fw"></i>Update Personal Information</button>
                    </div>
                <?php endif ?>
            </div>
        </div>
        <?php if ($editMode): ?>
        </form>
    <?php endif ?>
</div>