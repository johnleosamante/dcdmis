<div class="text-center py-0">
    <div class="error mx-auto"><i class="fas fa-user-tie fa-fw"></i></div>
    <p class="lead text-gray-800 mt-1 mb-0">Applicant Information</p>
    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-8 col-md-10 col-sm-12">
            <p class="px-2 mb-2">We are excited that you are interested in becoming a part of
                our workforce. Please use this form to share your personal information, educational background and
                eligibilities with us.
            </p>

            <p class="px-2 mb-2">Ensure all contact information is current so we can reach you easily. Fields mark
                with an asterisk (*) are required to move forward in the registration
                process.</p>

            <p class="px-2 mb-0">Privacy Note: Your data is handled with the utmost confidentiality and will only be
                used for
                recruitment purposes.</p>
        </div>
    </div>
</div>

<div class="card mt-3 mb-4 mx-auto">
    <div class="card-body">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger small">
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    <?php foreach ($errors as $error): ?>
                        <li>
                            <?= e($error) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <?= csrf_field(); ?>
            <div class="form-group mb-3">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="is_current_employee"
                        name="is_current_employee" value="1" <?php echo (isset($form_data['is_current_employee']) && $form_data['is_current_employee']) ? 'checked' : ''; ?> onchange="toggleEmployeeFields()">
                    <label class="custom-control-label font-weight-bold" for="is_current_employee">I am a current
                        employee of the division</label>
                </div>
                <small class="form-text text-muted">Check this if you're already employed with us to simplify
                    registration</small>
            </div>

            <div id="employee-fields"
                style="display: <?php echo (isset($form_data['is_current_employee']) && $form_data['is_current_employee']) ? 'none' : 'block'; ?>">
                <h3 class="h4">Personal Information</h3>
                <h4 class="h5">Applicant Name</h4>
                <div class="form-row">
                    <div class="form-group col-md-12 col-lg-9">
                        <label for="last-name" class="small font-weight-bold mb-0">Last Name
                            <?= showAsterisk() ?>
                        </label>
                        <input type="text" class="form-control" id="last-name" name="last_name" placeholder="Last Name"
                            value="<?= isset($form_data['last_name']) ? e($form_data['last_name']) : '' ?>" required>
                    </div>

                    <div class="form-group col-md-12 col-lg-3">
                        <label for="name-extension" class="small font-weight-bold mb-0">Name Extension</label>
                        <input type="text" class="form-control" id="name-extension" name="name_extension"
                            placeholder="Name Extension"
                            value="<?= isset($form_data['name_extension']) ? e($form_data['name_extension']) : '' ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12 col-lg-6">
                        <label for="first-name" class="small font-weight-bold mb-0">First Name
                            <?= showAsterisk() ?>
                        </label>
                        <input type="text" class="form-control" id="first-name" name="first_name"
                            placeholder="First Name"
                            value="<?= isset($form_data['first_name']) ? e($form_data['first_name']) : '' ?>" required>
                    </div>

                    <div class="form-group col-md-12 col-lg-6">
                        <label for="middle-name" class="small font-weight-bold mb-0">Middle Name</label>
                        <input type="text" class="form-control" id="middle-name" name="middle_name"
                            placeholder="Middle Name"
                            value="<?= isset($form_data['middle_name']) ? e($form_data['middle_name']) : '' ?>">
                    </div>
                </div>
                <h4 class="h5">Applicant Address</h4>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="lot" class="small font-weight-bold mb-0">Lot/House No.</label>
                        <input type="text" class="form-control" id="lot" name="lot" placeholder="Lot/House No."
                            value="<?= isset($form_data['lot']) ? e($form_data['lot']) : '' ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="street" class="small font-weight-bold mb-0">Street</label>
                        <input type="text" class="form-control" id="street" name="street" placeholder="Street"
                            value="<?= isset($form_data['street']) ? e($form_data['street']) : '' ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="subdivision" class="small font-weight-bold mb-0">Subdivision/Village</label>
                        <input type="text" class="form-control" id="subdivision" name="subdivision"
                            placeholder="Subdivision/Village"
                            value="<?= isset($form_data['subdivision']) ? e($form_data['subdivision']) : '' ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="barangay" class="small font-weight-bold mb-0">Barangay
                            <?= showAsterisk() ?>
                        </label>
                        <input type="text" class="form-control" id="barangay" name="barangay" placeholder="Barangay"
                            value="<?= isset($form_data['barangay']) ? e($form_data['barangay']) : '' ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="city" class="small font-weight-bold mb-0">City/Municipality
                            <?= showAsterisk() ?>
                        </label>
                        <input type="text" class="form-control" id="city" name="city" placeholder="City/Municipality"
                            value="<?= isset($form_data['city']) ? e($form_data['city']) : '' ?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-9">
                        <label for="province" class="small font-weight-bold mb-0">Province
                            <?= showAsterisk() ?>
                        </label>
                        <input type="text" class="form-control" id="province" name="province" placeholder="Province"
                            value="<?= isset($form_data['province']) ? e($form_data['province']) : '' ?>" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="zip" class="small font-weight-bold mb-0">Zip Code
                            <?= showAsterisk() ?>
                        </label>
                        <input type="text" class="form-control" id="zip" name="zip" placeholder="Zip Code"
                            value="<?= isset($form_data['zip']) ? e($form_data['zip']) : '' ?>" required>
                    </div>
                </div>
                <h4 class="h5">Applicant Details</h4>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="birth-date" class="small font-weight-bold mb-0">Birth Date
                            <?= showAsterisk() ?>
                        </label>
                        <input type="date" class="form-control" id="birth-date" name="birth_date"
                            value="<?= isset($form_data['birth_date']) ? e($form_data['birth_date']) : '' ?>" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="sex" class="small font-weight-bold mb-0">Sex at birth
                            <?= showAsterisk() ?>
                        </label>
                        <select class="form-control" id="sex" name="sex" required>
                            <option value="" disabled <?php echo !isset($form_data['sex']) ? 'selected' : ''; ?>>Select
                                sex at birth...</option>
                            <option value="male" <?php echo (isset($form_data['sex']) && $form_data['sex'] === 'male') ? 'selected' : ''; ?>>Male</option>
                            <option value="female" <?php echo (isset($form_data['sex']) && $form_data['sex'] === 'female') ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="civil-status" class="small font-weight-bold mb-0">Civil Status
                            <?= showAsterisk() ?>
                        </label>
                        <select class="form-control" id="civil-status" name="civil_status" required>
                            <option value="" disabled <?php echo !isset($form_data['civil_status']) ? 'selected' : ''; ?>>
                                Select civil status...</option>
                            <option value="single" <?php echo (isset($form_data['civil_status']) && $form_data['civil_status'] === 'single') ? 'selected' : ''; ?>>Single</option>
                            <option value="married" <?php echo (isset($form_data['civil_status']) && $form_data['civil_status'] === 'married') ? 'selected' : ''; ?>>Married</option>
                            <option value="widowed" <?php echo (isset($form_data['civil_status']) && $form_data['civil_status'] === 'widowed') ? 'selected' : ''; ?>>Widowed</option>
                            <option value="separated" <?php echo (isset($form_data['civil_status']) && $form_data['civil_status'] === 'separated') ? 'selected' : ''; ?>>Separated</option>
                            <option value="annulled" <?php echo (isset($form_data['civil_status']) && $form_data['civil_status'] === 'annulled') ? 'selected' : ''; ?>>Annulled</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="religion" class="small font-weight-bold mb-0">Religion
                            <?= showAsterisk() ?>
                        </label>
                        <input type="text" class="form-control" id="religion" name="religion" placeholder="Religion"
                            value="<?= isset($form_data['religion']) ? e($form_data['religion']) : '' ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="ethnic-group" class="small font-weight-bold mb-0">Indigenous/Ethnic
                            Group</label>
                        <input type="text" class="form-control" id="ethnic-group" name="ethnic_group"
                            placeholder="If applicable"
                            value="<?= isset($form_data['ethnic_group']) ? e($form_data['ethnic_group']) : '' ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="is_pwd" name="is_pwd" value="1" <?php echo (isset($form_data['is_pwd']) && $form_data['is_pwd']) ? 'checked' : ''; ?>>
                        <label class="pt-1 custom-control-label small font-weight-bold" for="is_pwd">I am a Person with
                            Disability (PWD)</label>
                    </div>
                </div>

                <hr>

                <h3 class="h4">Contact Information</h3>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email" class="small font-weight-bold mb-0">Email Address
                            <?= showAsterisk() ?>
                        </label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address"
                            value="<?= isset($form_data['email']) ? e($form_data['email']) : '' ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="mobile" class="small font-weight-bold mb-0">Mobile Number
                            <?= showAsterisk() ?>
                        </label>
                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number"
                            value="<?= isset($form_data['mobile']) ? e($form_data['mobile']) : '' ?>" required>
                    </div>
                </div>

                <hr class="mt-0">

                <h3 class="h4">Educational Information</h3>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="education" class="small font-weight-bold mb-0">Education
                            <?= showAsterisk() ?>
                        </label>
                        <input type="text" class="form-control" id="education" name="education"
                            placeholder="For College Level, indicate specialization if applicable..."
                            value="<?= isset($form_data['education']) ? e($form_data['education']) : '' ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="graduate-studies" class="small font-weight-bold mb-0">Graduate Studies</label>
                        <input type="text" class="form-control" id="graduate-studies" name="graduate_studies"
                            placeholder="Masteral/Doctoral..."
                            value="<?= isset($form_data['graduate_studies']) ? e($form_data['graduate_studies']) : '' ?>">
                    </div>
                </div>

                <hr class="mt-0">

                <h3 class="h4">Eligibility</h3>

                <div class="form-group mb-2">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="csc_professional"
                            name="csc_professional" value="1" <?php echo (isset($form_data['csc_professional']) && $form_data['csc_professional']) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="csc_professional">CSC
                            Professional</label>
                    </div>
                </div>

                <div class="form-group mb-2">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="csc_sub_professional"
                            name="csc_sub_professional" value="1" <?php echo (isset($form_data['csc_sub_professional']) && $form_data['csc_sub_professional']) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="csc_sub_professional">CSC
                            Sub-Professional</label>
                    </div>
                </div>

                <div class="form-group mb-2">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="let_pbet_lept" name="let_pbet_lept"
                            value="1" <?php echo (isset($form_data['let_pbet_lept']) && $form_data['let_pbet_lept']) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="let_pbet_lept">LET/PBET/LEPT</label>
                    </div>
                </div>

                <div class="form-group mb-2">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="honor_graduate" name="honor_graduate"
                            value="1" <?php echo (isset($form_data['honor_graduate']) && $form_data['honor_graduate']) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="honor_graduate">Honor
                            Graduate Eligibility</label>
                    </div>
                </div>

                <div class="form-group mb-2">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="barangay_official"
                            name="barangay_official" value="1" <?php echo (isset($form_data['barangay_official']) && $form_data['barangay_official']) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="barangay_official">Barangay
                            Official Eligibility</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="other_eligibility"
                            name="other_eligibility" value="1" <?php echo (isset($form_data['other_eligibility']) && $form_data['other_eligibility']) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="other_eligibility">Others</label>
                    </div>
                </div>
            </div>

            <hr id="employee-email-separator" class="mt-0"
                style="display: <?php echo (isset($form_data['is_current_employee']) && $form_data['is_current_employee']) ? 'block' : 'none'; ?>">

            <div id="employee-email-section"
                style="display: <?php echo (isset($form_data['is_current_employee']) && $form_data['is_current_employee']) ? 'block' : 'none'; ?>">
                <h3 class="h4">Employee Verification</h3>
                <p class="text-muted small">Please provide your email address registered with the division</p>
                <div class="form-group">
                    <label for="email-employee" class="small font-weight-bold mb-0">Email Address
                        <?= showAsterisk() ?>
                    </label>
                    <input type="email" class="form-control" id="email-employee" name="employee_email"
                        placeholder="Email Address"
                        value="<?= isset($form_data['employee_email']) ? e($form_data['employee_email']) : '' ?>">
                </div>
            </div>

            <button name="register-applicant" type="submit" class="btn btn-primary btn-block mt-4">
                Register as Applicant
            </button>

            <div class="small text-center mt-3">
                <a href=" <?= uri() . '/hrmis/apply' ?>" target="_blank">Already have an applicant ID?</a>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleEmployeeFields() {
        const isEmployee = document.getElementById('is_current_employee').checked;
        const employeeFields = document.getElementById('employee-fields');
        const employeeEmailSection = document.getElementById('employee-email-section');
        const employeeEmailSeparator = document.getElementById('employee-email-separator');
        const emailEmployeeInput = document.getElementById('email-employee');
        const emailInput = document.getElementById('email');

        if (isEmployee) {
            employeeFields.style.display = 'none';
            employeeEmailSection.style.display = 'block';
            employeeEmailSeparator.style.display = 'block';

            // Remove required attribute from all form fields except email
            document.querySelectorAll('#employee-fields input[required], #employee-fields select[required]').forEach(field => {
                field.removeAttribute('required');
            });

            // Add required to employee email
            emailEmployeeInput.setAttribute('required', 'required');

            // Remove required from contact email if exists
            if (emailInput) {
                emailInput.removeAttribute('required');
            }
        } else {
            employeeFields.style.display = 'block';
            employeeEmailSection.style.display = 'none';
            employeeEmailSeparator.style.display = 'none';

            // Add required attribute back to all form fields
            document.querySelectorAll('#employee-fields input[type="text"], #employee-fields input[type="date"], #employee-fields input[type="email"], #employee-fields select').forEach(field => {
                const fieldName = field.name;
                const requiredFields = ['last_name', 'first_name', 'barangay', 'city', 'province', 'zip', 'birth_date', 'sex', 'civil_status', 'religion', 'email', 'mobile', 'education'];
                if (requiredFields.includes(fieldName)) {
                    field.setAttribute('required', 'required');
                }
            });

            // Remove required from employee email
            emailEmployeeInput.removeAttribute('required');

            // Restore required to contact email
            if (emailInput) {
                emailInput.setAttribute('required', 'required');
            }
        }
    }
</script>