<?php
// export/publication-applicants-details.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once('../includes/function.php');
    redirect("{$baseUri}/login");
}

require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/vacancy.php');
require_once(root() . '/includes/database/education.php');
require_once(root() . '/includes/database/eligibility.php');
require_once(root() . '/includes/database/other-information.php');

$publicationId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;

if (empty($publicationId)) {
    redirect(uri() . '/login');
}

$publication = publication($publicationId);

// Handle optional filters (just in case)
$selectedPositionId = isset($_GET['position_id']) ? sanitize($_GET['position_id']) : 'all';
$selectedStatus = isset($_GET['status']) ? sanitize($_GET['status']) : 'all';

$positionIdParam = ($selectedPositionId !== 'all' && $selectedPositionId !== '') ? sanitize(decipher($selectedPositionId)) : null;
$statusParam = ($selectedStatus !== 'all' && $selectedStatus !== '') ? $selectedStatus : null;

$apps = applicantsListByPublication($publicationId, $positionIdParam, $statusParam);
?>

<table>
    <tbody>
        <tr>
            <td colspan="25" style="font-weight: bold; font-size: 14px;">CALL FOR APPLICATION - APPLICANTS COMPLETE
                DETAILS</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Call Code:</td>
            <td colspan="24"><?= e($publication['code'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Title:</td>
            <td colspan="24"><?= e($publication['title'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Export Date:</td>
            <td colspan="24"><?= date('F d, Y g:i A') ?></td>
        </tr>
        <tr>
            <td colspan="25"></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr style="background-color: #4e73df; color: #ffffff; font-weight: bold;">
            <th>#</th>
            <th>Application Code</th>
            <th>Applicant Type</th>
            <th>Position Applied</th>
            <th>Application Status</th>
            <th>Applied On</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Ext Name</th>
            <th>Sex</th>
            <th>Birthdate</th>
            <th>Age</th>
            <th>Civil Status</th>
            <th>Religion</th>
            <th>Email Address</th>
            <th>Mobile Number</th>
            <th>Residence Address</th>
            <th>PWD?</th>
            <th>Disability Details</th>
            <th>Ethnic Group</th>
            <th>Undergraduate Studies</th>
            <th>Graduate Studies</th>
            <th>Eligibilities</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($apps as $app):
            $isEmployed = (int) $app['is_employed'];
            $applicantId = $app['application_code_id'];
            $lastName = '';
            $firstName = '';
            $middleName = '';
            $nameExt = '';
            $sex = '';
            $birthdate = '';
            $civilStatus = '';
            $religion = '';
            $email = '';
            $mobile = '';
            $address = '';
            $withDisability = 'No';
            $disabilityDetails = '';
            $isIndigenous = 'No';
            $ethnicGroup = '';
            $undergraduate = '';
            $graduateStudies = '';
            $eligibilities = '';
            $applicantType = 'External Applicant';

            if ($isEmployed === 1) {
                $p = employee($applicantId);
                if ($p) {
                    $lastName = $p['last_name'] ?? '';
                    $firstName = $p['first_name'] ?? '';
                    $middleName = $p['middle_name'] ?? '';
                    $nameExt = $p['name_extension'] ?? '';
                    $sex = $p['sex'] ?? '';
                    $birthdate = $p['birthdate'] ?? '';
                    $civilStatus = $p['civil_status'] ?? '';
                    $religion = $p['religion'] ?? '';
                    $email = $p['email_address'] ?? '';
                    $mobile = $p['mobile_number'] ?? '';
                    $ethnicGroup = $p['ethnic_group'] ?? '';
                    $lot = $p['residence_lot'] ?? '';
                    $street = $p['residence_street'] ?? '';
                    $subdiv = $p['residence_subdivision'] ?? '';
                    $barangay = $p['residence_barangay'] ?? '';
                    $city = $p['residence_city'] ?? '';
                    $province = $p['residence_province'] ?? '';
                    $zip = $p['residence_zip'] ?? '';
                    $address = toAddress($lot, $street, $subdiv, $barangay, $city, $province);
                    if (!empty($zip)) {
                        $address = trim($address) . " " . $zip;
                    }
                }

                $other = otherInformation($applicantId);
                if ($other) {
                    $withDisability = (isset($other['with_disability']) && $other['with_disability'] == 1) ? 'Yes' : 'No';
                    $disabilityDetails = $other['disability'] ?? '';
                    $isIndigenous = (isset($other['is_indigenous']) && $other['is_indigenous'] == 1) ? 'Yes' : 'No';
                    $indigenousGroup = $other['indigenous_group'] ?? '';
                }

                $edbs = educationalBackgrounds($applicantId);
                $undergradList = [];
                $gradList = [];
                foreach ($edbs as $ed) {
                    $lvl = strtolower($ed['level'] ?? '');
                    $eduStr = ($ed['course'] ? $ed['course'] . ' ' : '') . 'at ' . $ed['school'];
                    if ($ed['year_graduated']) {
                        $eduStr .= ' (' . $ed['year_graduated'] . ')';
                    }
                    if (strpos($lvl, 'college') !== false || strpos($lvl, 'vocational') !== false) {
                        $undergradList[] = $eduStr;
                    } elseif (strpos($lvl, 'graduate') !== false) {
                        $gradList[] = $eduStr;
                    }
                }
                $undergraduate = implode('; ', $undergradList);
                $graduateStudies = implode('; ', $gradList);

                $eligs = eligibilities($applicantId);
                $eligList = [];
                foreach ($eligs as $el) {
                    $eligList[] = $el['title'];
                }
                $eligibilities = implode(', ', $eligList);
                $applicantType = 'Internal Employee';
            } else {
                $p = applicant($applicantId);
                if ($p) {
                    $lastName = $p['last_name'] ?? '';
                    $firstName = $p['first_name'] ?? '';
                    $middleName = $p['middle_name'] ?? '';
                    $nameExt = $p['name_extension'] ?? '';
                    $sex = $p['sex'] ?? '';
                    $birthdate = $p['birthdate'] ?? '';
                    $civilStatus = $p['civil_status'] ?? '';
                    $religion = $p['religion'] ?? '';
                    $email = $p['email_address'] ?? '';
                    $mobile = $p['mobile_number'] ?? '';
                    $ethnicGroup = $p['ethnic_group'] ?? '';
                    if ($ethnicGroup === 'Others' && !empty($p['ethnic_group_specify'])) {
                        $ethnicGroup = $p['ethnic_group_specify'];
                    }

                    $lot = $p['lot'] ?? '';
                    $street = $p['street'] ?? '';
                    $subdiv = $p['subdivision'] ?? '';
                    $barangay = $p['barangay'] ?? '';
                    $city = $p['city'] ?? '';
                    $province = $p['province'] ?? '';
                    $zip = $p['zip'] ?? '';
                    $address = toAddress($lot, $street, $subdiv, $barangay, $city, $province);
                    if (!empty($zip)) {
                        $address = trim($address) . " " . $zip;
                    }

                    $withDisability = (isset($p['with_disability']) && $p['with_disability'] == 1) ? 'Yes' : 'No';
                    $isIndigenous = 'No';
                    $indigenousGroup = '';

                    $undergraduate = $p['undergraduate'] ?? '';
                    $graduateStudies = $p['graduate_studies'] ?? '';

                    if (!empty($p['eligibilities'])) {
                        $eligsDecoded = json_decode($p['eligibilities'], true);
                        if (is_array($eligsDecoded)) {
                            $eligibilities = implode(', ', $eligsDecoded);
                        } else {
                            $eligibilities = $p['eligibilities'];
                        }
                    }
                }
            }

            // Calculate age
            $age = '';
            if (!empty($birthdate) && $birthdate !== '0000-00-00') {
                $birthDateObj = new DateTime($birthdate);
                $today = new DateTime();
                $age = $today->diff($birthDateObj)->y;
            }
            ?>
            <tr style="text-transform: uppercase;">
                <td><?= $i++ ?></td>
                <td style="mso-number-format:'\@';"><?= e($app['application_code']) ?></td>
                <td style="text-transform: none;"><?= e($applicantType) ?></td>
                <td><?= e($app['official_title']) ?></td>
                <td style="text-transform: none;"><?= e($app['status']) ?></td>
                <td><?= toDatetime($app['created_at']) ?></td>
                <td><?= e($lastName) ?></td>
                <td><?= e($firstName) ?></td>
                <td><?= e($middleName) ?></td>
                <td><?= e($nameExt) ?></td>
                <td><?= e($sex) ?></td>
                <td><?= e($birthdate) ?></td>
                <td><?= e($age) ?></td>
                <td><?= e($civilStatus) ?></td>
                <td><?= e($religion) ?></td>
                <td style="text-transform: none;"><?= e($email) ?></td>
                <td><?= e($mobile) ?></td>
                <td><?= e($address) ?></td>
                <td><?= e($withDisability) ?></td>
                <td><?= e($disabilityDetails) ?></td>
                <td><?= e($isIndigenous) ?></td>
                <td><?= e($indigenousGroup) ?></td>
                <td><?= e($ethnicGroup) ?></td>
                <td style="text-transform: none;"><?= e($undergraduate) ?></td>
                <td style="text-transform: none;"><?= e($graduateStudies) ?></td>
                <td style="text-transform: none;"><?= e($eligibilities) ?></td>
            </tr>
        <?php endforeach; ?>
        <?php if (count($apps) === 0): ?>
            <tr>
                <td colspan="25" style="text-align: center;">No applicants found for this call for application.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>