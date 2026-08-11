<?php
// modules/applicants/edit-applicant.php
if (!$isHrmis || (!$isPersonnel && !$isICT)) {
    require_once(root() . '/modules/error/403.php');
    return;
}

messageAlert($showAlert, $message, $success);

$applicantCipher = $_GET['id'] ?? null;
$applicantId = $applicantCipher ? sanitize(decode($applicantCipher)) : null;
$applicant = $applicantId ? applicant($applicantId) : null;

if (!$applicant) {
    echo '<div class="alert alert-danger shadow"><i class="fas fa-exclamation-triangle mr-2"></i> External applicant record not found.</div>';
    return;
}

$fullName = toName($applicant['last_name'], $applicant['first_name'], $applicant['middle_name'], $applicant['name_extension'], true);
$lastName = $applicant['last_name'] ?? '';
$firstName = $applicant['first_name'] ?? '';
$middleName = $applicant['middle_name'] ?? '';
$nameExt = strtolower($applicant['name_extension'] ?? '');

$birthDate = $applicant['birthdate'] ?? '';
$sex = $applicant['sex'] ?? '';
$civilStatus = strtolower($applicant['civil_status'] ?? '');

$religion_list = religions();
$current_religion_id = $applicant['religion_id'] ?? null;
$specify_religion_value = $applicant['specify_other_religion'] ?? '';
$is_religion_others = (string) $current_religion_id === 'Others' || !empty($specify_religion_value);

$ethnic_list = ethnic_groups();
$ethnic_by_category = [];
foreach ($ethnic_list as $eg) {
    $cat_name = !empty($eg['category_name']) ? $eg['category_name'] : 'Others';
    $ethnic_by_category[$cat_name][] = $eg;
}
$current_ethnic = $applicant['ethnic_group_id'] ?? '';
$specify_ethnic_value = $applicant['specify_other_ethnic_group'] ?? '';
$selected_ethnic_value = '';
if ($current_ethnic !== '' && $current_ethnic !== null) {
    if (is_numeric($current_ethnic)) {
        $selected_ethnic_value = (string) $current_ethnic;
    } elseif ($current_ethnic === 'Not Applicable') {
        $selected_ethnic_value = 'Not Applicable';
    } elseif ($current_ethnic === 'Others') {
        $selected_ethnic_value = 'Others';
    } else {
        $ethnic_names_map = array_column($ethnic_list, 'id', 'name');
        if (isset($ethnic_names_map[$current_ethnic])) {
            $selected_ethnic_value = (string) $ethnic_names_map[$current_ethnic];
        } else {
            $selected_ethnic_value = 'Others';
            $specify_ethnic_value = $current_ethnic;
        }
    }
} elseif (!empty($specify_ethnic_value)) {
    if ($specify_ethnic_value === 'Not Applicable') {
        $selected_ethnic_value = 'Not Applicable';
    } else {
        $selected_ethnic_value = 'Others';
    }
}

$lot = $applicant['lot'] ?? '';
$street = $applicant['street'] ?? '';
$subdivision = $applicant['subdivision'] ?? '';
$barangay = $applicant['barangay'] ?? '';
$city = $applicant['city'] ?? '';
$province = $applicant['province'] ?? '';
$zip = $applicant['zip'] ?? '';

$isPwd = !empty($applicant['with_disability']);
$email = $applicant['email_address'] ?? '';
$mobile = $applicant['mobile_number'] ?? '';
$education = $applicant['undergraduate'] ?? '';
$graduateStudies = $applicant['graduate_studies'] ?? '';

$rawEligibilities = !empty($applicant['eligibilities']) ? json_decode($applicant['eligibilities'], true) : [];
if (!is_array($rawEligibilities)) {
    $rawEligibilities = [];
}

$hasCscProf = in_array('CSC Professional', $rawEligibilities);
$hasCscSubProf = in_array('CSC Sub-Professional', $rawEligibilities);
$hasLet = in_array('LET/PBET/LEPT', $rawEligibilities);
$hasHonor = in_array('Honor Graduate Eligibility', $rawEligibilities);
$hasBarangay = in_array('Barangay Official Eligibility', $rawEligibilities);

$standardEligibilities = ['CSC Professional', 'CSC Sub-Professional', 'LET/PBET/LEPT', 'Honor Graduate Eligibility', 'Barangay Official Eligibility'];
$otherEligibilities = array_diff($rawEligibilities, $standardEligibilities);
$otherEligText = !empty($otherEligibilities) ? implode(', ', $otherEligibilities) : '';
$hasOtherElig = !empty($otherEligText);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('hrmis', 'Applicants') ?>">Applicants</a></li>
            <li class="breadcrumb-item"><a
                    href="<?= customUri('hrmis', 'External Applicant Information', $applicantId) ?>"><?= e($fullName) ?></a>
            </li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="card shadow mb-4 border-left-primary">
    <div class="card-header py-3">
        <?php contentTitleWithLink(e($fullName) . ' (' . e($applicantId) . ')', customUri('hrmis', 'External Applicant Information', $applicantId)); ?>
    </div>

    <div class="card-body p-4">
        <form action="" method="POST" id="edit-applicant-form">
            <?= csrf_field(); ?>
            <h3 class="h4">Personal Information</h3>
            <h4 class="h5">Applicant Name</h4>
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="last-name" class="small font-weight-bold mb-0">Last Name
                        <?= showAsterisk() ?>
                    </label>
                    <input type="text" class="form-control" id="last-name" name="last_name" placeholder="Last Name"
                        value="<?= e($lastName) ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-lg-9 col-md-9 col-sm-8 col-xs-12">
                    <label for="first-name" class="small font-weight-bold mb-0">First Name
                        <?= showAsterisk() ?>
                    </label>
                    <input type="text" class="form-control" id="first-name" name="first_name" placeholder="First Name"
                        value="<?= e($firstName) ?>" required>
                </div>

                <div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <label for="name-extension" class="small font-weight-bold mb-0">Name Extension</label>
                    <select class="form-control" id="name-extension" name="name_extension">
                        <option value="" <?= empty($nameExt) ? 'selected' : ''; ?>>Not Applicable</option>
                        <option value="jr." <?= ($nameExt === 'jr.') ? 'selected' : ''; ?>>JR.</option>
                        <option value="sr." <?= ($nameExt === 'sr.') ? 'selected' : ''; ?>>SR.</option>
                        <option value="ii" <?= ($nameExt === 'ii') ? 'selected' : ''; ?>>II</option>
                        <option value="iii" <?= ($nameExt === 'iii') ? 'selected' : ''; ?>>III</option>
                        <option value="iv" <?= ($nameExt === 'iv') ? 'selected' : ''; ?>>IV</option>
                        <option value="v" <?= ($nameExt === 'v') ? 'selected' : ''; ?>>V</option>
                        <option value="vi" <?= ($nameExt === 'vi') ? 'selected' : ''; ?>>VI</option>
                        <option value="vii" <?= ($nameExt === 'vii') ? 'selected' : ''; ?>>VII</option>
                        <option value="viii" <?= ($nameExt === 'viii') ? 'selected' : ''; ?>>VIII</option>
                        <option value="ix" <?= ($nameExt === 'ix') ? 'selected' : ''; ?>>IX</option>
                        <option value="x" <?= ($nameExt === 'x') ? 'selected' : ''; ?>>X</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="middle-name" class="small font-weight-bold mb-0">Middle Name</label>
                    <input type="text" class="form-control" id="middle-name" name="middle_name"
                        placeholder="Middle Name" value="<?= e($middleName) ?>">
                </div>
            </div>

            <h4 class="h5">Applicant Address</h4>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="lot" class="small font-weight-bold mb-0">Lot/House No.</label>
                    <input type="text" class="form-control" id="lot" name="lot" placeholder="Lot/House No."
                        value="<?= e($lot) ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="street" class="small font-weight-bold mb-0">Street</label>
                    <input type="text" class="form-control" id="street" name="street" placeholder="Street"
                        value="<?= e($street) ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="subdivision" class="small font-weight-bold mb-0">Subdivision/Village</label>
                    <input type="text" class="form-control" id="subdivision" name="subdivision"
                        placeholder="Subdivision/Village" value="<?= e($subdivision) ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="barangay" class="small font-weight-bold mb-0">Barangay
                        <?= showAsterisk() ?>
                    </label>
                    <input type="text" class="form-control" id="barangay" name="barangay" placeholder="Barangay"
                        value="<?= e($barangay) ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="city" class="small font-weight-bold mb-0">City/Municipality
                        <?= showAsterisk() ?>
                    </label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="City/Municipality"
                        value="<?= e($city) ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-9">
                    <label for="province" class="small font-weight-bold mb-0">Province
                        <?= showAsterisk() ?>
                    </label>
                    <input type="text" class="form-control" id="province" name="province" placeholder="Province"
                        value="<?= e($province) ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="zip" class="small font-weight-bold mb-0">Zip Code
                        <?= showAsterisk() ?>
                    </label>
                    <input type="text" class="form-control" id="zip" name="zip" placeholder="Zip Code"
                        value="<?= e($zip) ?>" required>
                </div>
            </div>

            <h4 class="h5">Applicant Details</h4>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="birth-date" class="small font-weight-bold mb-0">Birth Date
                        <?= showAsterisk() ?>
                    </label>
                    <input type="date" class="form-control" id="birth-date" name="birth_date"
                        value="<?= e($birthDate) ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="sex" class="small font-weight-bold mb-0">Sex at birth
                        <?= showAsterisk() ?>
                    </label>
                    <select class="form-control" id="sex" name="sex" required>
                        <option value="" disabled <?= empty($sex) ? 'selected' : ''; ?>>Select sex at birth...</option>
                        <option value="Male" <?= (strtolower($sex) === 'male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?= (strtolower($sex) === 'female') ? 'selected' : ''; ?>>Female</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="civil-status" class="small font-weight-bold mb-0">Civil Status
                        <?= showAsterisk() ?>
                    </label>
                    <select class="form-control" id="civil-status" name="civil_status" required>
                        <option value="" disabled <?= empty($civilStatus) ? 'selected' : ''; ?>>Select civil status...
                        </option>
                        <option value="single" <?= ($civilStatus === 'single') ? 'selected' : ''; ?>>Single</option>
                        <option value="married" <?= ($civilStatus === 'married') ? 'selected' : ''; ?>>Married</option>
                        <option value="widowed" <?= ($civilStatus === 'widowed') ? 'selected' : ''; ?>>Widowed</option>
                        <option value="separated" <?= ($civilStatus === 'separated') ? 'selected' : ''; ?>>Separated
                        </option>
                        <option value="annulled" <?= ($civilStatus === 'annulled') ? 'selected' : ''; ?>>Annulled</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="religion" class="small font-weight-bold mb-0">Religion
                        <?= showAsterisk() ?>
                    </label>
                    <select class="form-control" id="religion" name="religion_id"
                        onchange="toggleReligionSpecify(this, 'religion-specify-group')">
                        <option value="">Select religion...</option>
                        <?php foreach ($religion_list as $r): ?>
                            <option value="<?= $r['id'] ?>" <?= (string) $current_religion_id === (string) $r['id'] ? 'selected' : '' ?>>
                                <?= e($r['name']) ?>
                            </option>
                        <?php endforeach ?>
                        <option value="Others" <?= $is_religion_others ? 'selected' : '' ?>>Others</option>
                    </select>
                    <div id="religion-specify-group" class="mt-2"
                        style="display: <?= $is_religion_others ? 'block' : 'none' ?>;">
                        <label for="religion-specify" class="small font-weight-bold mb-0">Specify Religion
                            <?= showAsterisk() ?></label>
                        <input type="text" class="form-control" id="religion-specify" name="specify_other_religion"
                            placeholder="Specify Religion" value="<?= e($specify_religion_value) ?>"
                            <?= $is_religion_others ? 'required' : '' ?>>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="ethnic-group" class="small font-weight-bold mb-0">Ethnic Group</label>
                    <select class="form-control" id="ethnic-group" name="ethnic_group"
                        onchange="toggleEthnicGroupSpecify(this, 'ethnic-group-specify-group')">
                        <option value="">Select ethnic group...</option>
                        <option value="Not Applicable" <?= $selected_ethnic_value === 'Not Applicable' ? 'selected' : '' ?>>Not Applicable</option>
                        <?php foreach ($ethnic_by_category as $category_name => $groups): ?>
                            <optgroup label="<?= e($category_name) ?>">
                                <?php foreach ($groups as $eg): ?>
                                    <option value="<?= $eg['id'] ?>" <?= $selected_ethnic_value === (string) $eg['id'] ? 'selected' : '' ?>><?= e($eg['name']) ?></option>
                                <?php endforeach ?>
                            </optgroup>
                        <?php endforeach ?>
                        <option value="Others" <?= $selected_ethnic_value === 'Others' ? 'selected' : '' ?>>Others
                        </option>
                    </select>
                    <div id="ethnic-group-specify-group" class="mt-2"
                        style="display: <?= $selected_ethnic_value === 'Others' ? 'block' : 'none' ?>;">
                        <label for="ethnic-group-specify" class="small font-weight-bold mb-0">Specify Ethnic Group
                            <?= showAsterisk() ?></label>
                        <input type="text" class="form-control" id="ethnic-group-specify" name="ethnic_group_specify"
                            placeholder="Specify Ethnic Group" value="<?= e($specify_ethnic_value) ?>"
                            <?= $selected_ethnic_value === 'Others' ? 'required' : '' ?>>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="is_pwd" name="is_pwd" value="1" <?= $isPwd ? 'checked' : ''; ?>>
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
                        value="<?= e($email) ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="mobile" class="small font-weight-bold mb-0">Mobile Number
                        <?= showAsterisk() ?>
                    </label>
                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number"
                        value="<?= e($mobile) ?>" required>
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
                        value="<?= e($education) ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <label for="graduate-studies" class="small font-weight-bold mb-0">Graduate Studies</label>
                    <input type="text" class="form-control" id="graduate-studies" name="graduate_studies"
                        placeholder="Masteral/Doctoral..." value="<?= e($graduateStudies) ?>">
                </div>
            </div>

            <hr class="mt-0">

            <h3 class="h4">Eligibility</h3>

            <div class="form-group mb-2">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="csc_professional" name="csc_professional"
                        value="1" <?= $hasCscProf ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="csc_professional">CSC
                        Professional</label>
                </div>
            </div>

            <div class="form-group mb-2">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="csc_sub_professional"
                        name="csc_sub_professional" value="1" <?= $hasCscSubProf ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="csc_sub_professional">CSC
                        Sub-Professional</label>
                </div>
            </div>

            <div class="form-group mb-2">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="let_pbet_lept" name="let_pbet_lept"
                        value="1" <?= $hasLet ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="let_pbet_lept">LET/PBET/LEPT</label>
                </div>
            </div>

            <div class="form-group mb-2">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="honor_graduate" name="honor_graduate"
                        value="1" <?= $hasHonor ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="honor_graduate">Honor
                        Graduate Eligibility</label>
                </div>
            </div>

            <div class="form-group mb-2">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="barangay_official" name="barangay_official"
                        value="1" <?= $hasBarangay ? 'checked' : ''; ?>>
                    <label class="custom-control-label" for="barangay_official">Barangay
                        Official Eligibility</label>
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="other_eligibility" name="other_eligibility"
                        value="1" <?= $hasOtherElig ? 'checked' : ''; ?> onchange="toggleOtherEligibility(this)">
                    <label class="custom-control-label" for="other_eligibility">Others</label>
                </div>
                <div id="other-eligibility-specify-group" class="mt-2"
                    style="display: <?= $hasOtherElig ? 'block' : 'none'; ?>;">
                    <label for="other-eligibility-specify" class="small font-weight-bold mb-0">Specify Other
                        Eligibility
                        <?= showAsterisk() ?></label>
                    <input type="text" class="form-control" id="other-eligibility-specify"
                        name="other_eligibility_specify" placeholder="Specify Eligibility"
                        value="<?= e($otherEligText) ?>" <?= $hasOtherElig ? 'required' : ''; ?>>
                </div>
            </div>

            <hr>

            <div class="d-flex align-items-center justify-content-end">
                <input type="hidden" name="verifier" value="<?= e(cipher($applicantId)) ?>">
                <a href="<?= customUri('hrmis', 'External Applicant Information', $applicantId) ?>"
                    class="btn btn-secondary mr-2">
                    <i class="fas fa-times mr-1"></i> Cancel
                </a>
                <button class="btn btn-primary" name="update-applicant" type="submit">
                    <i class="fas fa-save mr-1"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleReligionSpecify(selectElement, targetId) {
        const targetGroup = document.getElementById(targetId);
        const specifyInput = document.getElementById('religion-specify');
        if (selectElement.value === 'Others') {
            targetGroup.style.display = 'block';
            specifyInput.setAttribute('required', 'required');
        } else {
            targetGroup.style.display = 'none';
            specifyInput.removeAttribute('required');
            specifyInput.value = '';
        }
    }

    function toggleEthnicGroupSpecify(selectElement, targetId) {
        const targetGroup = document.getElementById(targetId);
        const specifyInput = document.getElementById('ethnic-group-specify');
        if (selectElement.value === 'Others') {
            targetGroup.style.display = 'block';
            specifyInput.setAttribute('required', 'required');
        } else {
            targetGroup.style.display = 'none';
            specifyInput.removeAttribute('required');
            specifyInput.value = '';
        }
    }

    function toggleOtherEligibility(checkboxElement) {
        const targetGroup = document.getElementById('other-eligibility-specify-group');
        const specifyInput = document.getElementById('other-eligibility-specify');
        if (checkboxElement.checked) {
            targetGroup.style.display = 'block';
            specifyInput.setAttribute('required', 'required');
        } else {
            targetGroup.style.display = 'none';
            specifyInput.removeAttribute('required');
            specifyInput.value = '';
        }
    }
</script>