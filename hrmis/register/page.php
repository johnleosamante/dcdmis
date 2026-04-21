<?php
$code = sanitize($_GET['p'] ?? '');
?>

<div class="col-12">
    <div class="mt-5 mb-4 text-center">
        <?php displayLogo(120, 120, '0', uri(), title()) ?>
        <h1 class="my-2"><?= e($appTitle) ?></h1>
    </div>

    <div class="text-center py-0">
        <div class="error mx-auto"><i class="fas fa-user-tie fa-fw"></i></div>
        <p class="lead text-gray-800 mt-1 mb-0">Applicant Information</p>
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12">
                <p class="px-2 mb-2">We are excited that you are interested in becoming a part of
                    our workforce. Please use this form to share your personal information, eligibilities, educational
                    background, and experience with us.
                </p>

                <p class="px-2 mb-2">Ensure all contact information is current so we can reach you easily. Fields mark
                    with an asterisk (*) are required to move forward in the selection
                    process.</p>

                <p class="px-2 mb-0">Privacy Note: Your data is handled with the utmost confidentiality and will only be
                    used for
                    recruitment purposes.</p>
            </div>
        </div>
    </div>

    <div class="card mt-3 mb-4 mx-auto">
        <div class="card-body">
            <form action="" method="POST">
                <?= csrf_field(); ?>
                <h3 class="h4">Personal Information</h3>
                <div class="row">
                    <div class="form-group col-xl-12">
                        <label for="last-name" class="small font-weight-bold mb-0">Last Name
                            <?= showAsterisk() ?>
                        </label>
                        <input type="text" class="form-control" id="last-name" name="last_name" placeholder="Last Name"
                            required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-lg-9">
                        <label for="first-name" class="small font-weight-bold mb-0">First Name
                            <?= showAsterisk() ?></label>
                        <input type="text" class="form-control" id="first-name" name="first_name"
                            placeholder="First Name" required>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="name-extension" class="small font-weight-bold mb-0">Name Extension
                            <?= showAsterisk() ?>
                        </label>
                        <input type="text" class="form-control" id="name-extension" name="name_extension"
                            placeholder="Name Extension" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xl-12">
                        <label for="middle-name" class="small font-weight-bold mb-0">Middle Name
                            <?= showAsterisk() ?>
                        </label>
                        <input type="text" class="form-control" id="middle-name" name="middle_name"
                            placeholder="Middle Name" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xl-12">
                        <label for="address" class="small font-weight-bold mb-0">Complete Address
                            <?= showAsterisk() ?></label>
                        <textarea class="form-control" id="address" name="address" rows="2"
                            placeholder="House No., Street, Barangay, City/Municipality, Province" required></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="birth-date" class="small font-weight-bold mb-0">Birth Date<?= showAsterisk() ?>
                        </label>
                        <input type="date" class="form-control" id="birth-date" name="birth_date" required
                            value="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="sex" class="small font-weight-bold mb-0">Sex at birth <?= showAsterisk() ?></label>
                        <select type="date" class="form-control" id="sex" name="sex" required>
                            <option value="" disabled selected>Select sex at birth...</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="civil-status" class="small font-weight-bold mb-0">Civil Status
                            <?= showAsterisk() ?></label>
                        <select type="date" class="form-control" id="sex" name="sex" required>
                            <option value="" disabled selected>Select civil status...</option>
                            <option value="single">Single</option>
                            <option value="married">Married</option>
                            <option value="widowed">Widowed</option>
                            <option value="separated">Separated</option>
                            <option value="annulled">Annulled</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="religion" class="small font-weight-bold mb-0">Religion <?= showAsterisk() ?></label>
                        <input type="text" class="form-control" id="religion" name="religion" placeholder="Religion">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="ethnic-group" class="small font-weight-bold mb-0">Indigenous/Ethnic
                            Group</label>
                        <input type="text" class="form-control" id="ethnic-group" name="ethnic_group"
                            placeholder="If applicable">
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="is_pwd" name="is_pwd" value="1">
                        <label class="pt-1 custom-control-label small font-weight-bold" for="is_pwd">I am a Person with
                            Disability (PWD)</label>
                    </div>
                </div>

                <hr>

                <h3 class="h4">Contact Information</h3>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email" class="small font-weight-bold mb-0">Email Address
                            <?= showAsterisk() ?></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address"
                            required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="mobile" class="small font-weight-bold mb-0">Mobile Number
                            <?= showAsterisk() ?>
                        </label>
                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number"
                            required>
                    </div>
                </div>

                <hr class="mt-0">

                <h3 class="h4">Educational Information</h3>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="education" class="small font-weight-bold mb-0">Education
                            <?= showAsterisk() ?></label>
                        <input type="text" class="form-control" id="education" name="education"
                            placeholder="For College Level, indicate specialization if applicable. Ex. BSED major in GenSci..."
                            required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="graduate-studies" class="small font-weight-bold mb-0">Graduate Studies
                            <?= showAsterisk() ?>
                        </label>
                        <input type="text" class="form-control" id="graduate-studies" name="graduate_studies"
                            placeholder="Masteral/Doctoral..." required>
                    </div>
                </div>

                <hr class="mt-0">

                <h3 class="h4">Relevant Experience</h3>

                <hr class="mt-0">

                <h3 class="h4">Eligibilities</h3>
            </form>
        </div>
    </div>

    <?php if (isset($userId)): ?>
        <a class="d-block text-center mx-2 mb-5" href="<?= uri() . '/' . $activeApp ?>" title="Go to dashboard">Go to
            Dashboard</a>
    <?php else: ?>
        <a class="d-block text-center mx-2 mb-5" href="<?= uri() . '/login' ?>" title="Go to login page">Already have an
            account? Login instead</a>
    <?php endif ?>
</div>