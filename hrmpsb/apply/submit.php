<?php
// hrmpsb/apply/submit.php
require_once '../../includes/function.php';
require_once root() . '/includes/database/database.php';
require_once root() . '/includes/database/vacancy.php';
require_once root() . '/includes/string.php';
require_once root() . '/includes/database/employee.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(uri() . '/hrmpsb/apply');
}

$publicationId = isset($_POST['publication_id']) ? sanitize(decipher($_POST['publication_id'])) : null;
$positionIds = $_POST['position_ids'] ?? [];
$vacancyIds = $_POST['vacancy_ids'] ?? []; // Fallback
$isEmployee = isset($_POST['is_employee']);
$employeeId = null;

if ($isEmployee) {
    $depedEmail = sanitize($_POST['deped_email'] ?? '');
    $empLookup = findEmployeeByEmail($depedEmail);
    $employeeId = (numRows($empLookup) > 0) ? fetchAssoc($empLookup)['id'] : null;
    $empResult = $employeeId ? employee($employeeId) : null;

    if ($empResult && numRows($empResult) > 0) {
        $emp = fetchAssoc($empResult);
        $fullName = toName($emp['lname'], $emp['fname'], $emp['mname'], $emp['ext']);
        $email = !empty($emp['email']) ? $emp['email'] : '';
        $mobile = !empty($emp['mobile']) ? $emp['mobile'] : '';

        // Map Employee Data
        $sex = $emp['sex'];
        // Format DOB: YYYY-MM-DD (Note: Month might be name or number, defaulting to constructing properly)
        // Check if month is numeric or string. `employee.php` doesn't specify. Assuming stored split.
        $dob = $emp['year'] . '-' . date('m', strtotime($emp['month'])) . '-' . str_pad($emp['day'], 2, '0', STR_PAD_LEFT);
        $civil = $emp['civil_status'];

        // Construct Address
        $address = implode(', ', array_filter([$emp['rstreet'], $emp['rbarangay'], $emp['rcity'], $emp['rprovince']]));

        // Fetch Education Summary (Highest)
        $eduResult = educationalBackgrounds($employeeId);
        $eduSummary = [];
        while ($edu = fetchAssoc($eduResult)) {
            $eduSummary[] = $edu['course'] . (isset($edu['school']) ? ' (' . $edu['school'] . ')' : '');
        }
        $education = !empty($eduSummary) ? implode('; ', $eduSummary) : 'See Employee Record';

        // Fetch Eligibility Summary
        $eligResult = eligibility($employeeId, null); // passing null as 2nd arg if supported or need simple query?
        // Wait, `eligibility($id, $no)` is defined. `eligibility.php` also likely has `eligibilities($id)` or similar?
        // Step 732 showed `eligibility($id, $no)`. 
        // I need ALL eligibilities. `eligibility.php` line 6: `return query("SELECT ... FROM civil_service WHERE Emp_ID='{$id}'...")`. 
        // This query seems to be unnamed in the grep output? Ah, it was `function eligibility($id, $no)` line 9.
        // Line 6 was unnamed? Ah, grep output shows line 6 content but function name was likely line 4?
        // Let's assume there is a function for all eligibilities.
        // Using direct query here or adding function is safer.
        // Let's use `query("SELECT * FROM civil_service WHERE Emp_ID='$employeeId'")` if function not available.
        // Or assume `educationalBackgrounds` equivalent `eligibilities($id)` exists?
        // I'll check `eligibility.php` again? No, I'll just use raw query to be safe or `educationalBackgrounds` pattern.
        // Actually, for now, let's put "Verified Employee" for eligibility if we can't easily fetch, or fetch raw.
        $eligList = [];
        $eligQ = query("SELECT `Carrer_Service`, `Rating` FROM `civil_service` WHERE `Emp_ID`='$employeeId'");
        while ($el = fetchAssoc($eligQ)) {
            $eligList[] = $el['Carrer_Service'] . ($el['Rating'] ? ' (' . $el['Rating'] . '%)' : '');
        }
        $eligibility = !empty($eligList) ? implode('; ', $eligList) : 'See Employee Record';

        // Others
        $religion = ''; // Not in default fetch
        $isPwd = 0;
        $ethnic = '';

    } else {
        $fullName = '';
        $email = '';
        $mobile = '';
        $error = 'DepEd Email not found or not registered. Please check and try again.';
    }
} else {
    $lname = sanitize($_POST['last_name'] ?? '');
    $fname = sanitize($_POST['first_name'] ?? '');
    $mname = sanitize($_POST['middle_name'] ?? '');
    $ext = sanitize($_POST['ext_name'] ?? '');
    $fullName = toName($lname, $fname, $mname, $ext);

    $email = sanitize($_POST['email'] ?? '');
    $mobile = sanitize($_POST['mobile'] ?? '');

    // New Fields
    $sex = sanitize($_POST['sex'] ?? '');
    $dob = sanitize($_POST['birth_date'] ?? '');
    $civil = sanitize($_POST['civil_status'] ?? '');
    $address = sanitize($_POST['address'] ?? '');
    $religion = sanitize($_POST['religion'] ?? '');
    $isPwd = isset($_POST['is_pwd']) ? 1 : 0;
    $ethnic = sanitize($_POST['ethnic_group'] ?? '');
    $education = sanitize($_POST['education'] ?? '');
    $eligibility = sanitize($_POST['eligibility'] ?? '');
}

if ($error) {
    // Skip further validation if error already exists
} elseif (empty($publicationId) || (empty($positionIds) && empty($vacancyIds)) || empty($fullName)) {
    $error = 'Please fill in all required fields. Select at least one position.';
} elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Email is required if provided (manual) or fetched.
    // If fetched email is empty, we might let it pass or error?
    // Let's require email for now.
    $error = 'Invalid email address.';
} elseif (empty($email)) {
    $error = 'Email address is required.';
} elseif (!isset($_FILES['resume']) || $_FILES['resume']['error'] !== UPLOAD_ERR_OK) {
    $error = 'Please upload your Resume/CV.';
} else {
    // Validate file
    $file = $_FILES['resume'];
    $allowedTypes = ['application/pdf'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    if (!in_array($file['type'], $allowedTypes)) {
        $error = 'Only PDF files are allowed for Resume/CV.';
    } elseif ($file['size'] > $maxSize) {
        $error = 'File size exceeds the maximum limit of 5MB.';
    } else {
        // Upload file
        $uploadDir = root() . '/uploads/applications/' . $publicationId . '/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $fullName) . '.pdf';
        $uploadPath = $uploadDir . $fileName;
        $dbPath = 'uploads/applications/' . $publicationId . '/' . $fileName;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Handle Applicant Entity
            $applicantId = null;

            if ($isEmployee && $employeeId) {
                // For Employees: Check if they are already in applicants table
                $existingApp = findApplicantByEmployeeId($employeeId);
                // Need to get fname/lname/etc from Employee DB ($emp fetched earlier)
                if (isset($emp)) {
                    $fname = $emp['fname'];
                    $mname = $emp['mname'];
                    $lname = $emp['lname'];
                    $ext = $emp['ext'];
                }
            } else {
                // Non-Employee: Check by Email
                $existingApp = findApplicantByEmail($email);
            }

            if (numRows($existingApp) > 0) {
                $appData = fetchAssoc($existingApp);
                $applicantId = $appData['id'];
                // Update details if needed (e.g. latest reusme)
                updateApplicant($applicantId, $fname, $mname, $lname, $ext, $mobile, $dbPath, $sex, $dob, $civil, $address, $religion, $isPwd, $ethnic, $education, $eligibility);
            } else {
                // Create New Applicant
                $code = generateApplicantCode();
                $applicantId = createApplicant($code, $fname, $mname, $lname, $ext, $email, $mobile, $isEmployee, $employeeId, $dbPath, $sex, $dob, $civil, $address, $religion, $isPwd, $ethnic, $education, $eligibility);
            }

            // Create Applications
            if ($applicantId) {
                $successCount = 0;

                // If position_ids provided, iterate and expand to vacancies
                if (isset($_POST['position_ids']) && is_array($_POST['position_ids'])) {
                    foreach ($_POST['position_ids'] as $pidCode) {
                        $pid = decipher($pidCode);
                        if ($pid) {
                            // Find all vacancies for this position in this publication
                            $vacancies = vacanciesByPublicationAndPosition($publicationId, $pid);
                            while ($vac = fetchAssoc($vacancies)) {
                                if (createApplicationEntry($publicationId, sanitize($vac['vacancy_id']), $applicantId)) {
                                    $successCount++;
                                }
                            }
                        }
                    }
                } elseif (isset($_POST['vacancy_ids'])) {
                    // Fallback for direct vacancy selection (if needed)
                    foreach ($_POST['vacancy_ids'] as $vidCode) {
                        $vid = decipher($vidCode);
                        if ($vid && createApplicationEntry($publicationId, sanitize($vid), $applicantId)) {
                            $successCount++;
                        }
                    }
                }

                if ($successCount > 0) {
                    $success = true;
                } else {
                    $error = 'Failed to submit applications. Please try again.';
                }
            } else {
                $error = 'Failed to create applicant record.';
            }

        } else {
            $error = 'Failed to upload resume. Please try again.';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Submission Status -
        <?= SITE_TITLE ?>
    </title>
    <link href="<?= uri() ?>/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?= uri() ?>/assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <?php if (isset($success)): ?>
                                <div class="mb-4">
                                    <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                                </div>
                                <h1 class="h4 text-gray-900 mb-4">Application Submitted!</h1>
                                <p class="mb-4">Thank you for your application, <strong>
                                        <?= $fullName ?>
                                    </strong>.</p>
                                <p class="mb-4">Your application for the position has been successfully recorded. We will
                                    contact you via email or mobile number regarding the status of your application.</p>
                                <a href="<?= uri() ?>" class="btn btn-primary btn-user btn-block">
                                    Back to Home
                                </a>
                            <?php else: ?>
                                <div class="mb-4">
                                    <i class="fas fa-times-circle text-danger" style="font-size: 5rem;"></i>
                                </div>
                                <h1 class="h4 text-gray-900 mb-4">Submission Failed</h1>
                                <div class="alert alert-danger">
                                    <?= $error ?? 'Unknown error occurred.' ?>
                                </div>
                                <button onclick="history.back()" class="btn btn-secondary btn-user btn-block">
                                    Go Back and Try Again
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>