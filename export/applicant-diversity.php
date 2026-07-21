<?php
// export/applicant-diversity.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once('../includes/function.php');
    redirect(uri() . '/login');
}

require_once(root() . '/includes/database/vacancy.php');

$type = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : '';

$exportConfig = [
    'gender' => [
        'title' => 'Talent Pool Diversity - Gender',
        'db_function' => 'applicantDiversityGender',
        'headers' => ['Gender', 'Total'],
    ],
    'generation' => [
        'title' => 'Talent Pool Diversity - Generation',
        'db_function' => 'applicantDiversityGeneration',
        'headers' => ['Generation', 'Male', 'Female', 'Total'],
    ],
    'religion' => [
        'title' => 'Applicants by Religion Demographics',
        'db_function' => 'applicantDiversityReligion',
        'headers' => ['Religion', 'Male', 'Female', 'Total'],
    ],
    'ethnic' => [
        'title' => 'Applicant Ethnic Group Demographics',
        'db_function' => 'applicantDiversityEthnic',
        'headers' => ['Ethnic Group', 'Male', 'Female', 'Total'],
    ],
    'pwd' => [
        'title' => 'Applicant Persons with Disability (PWD) Demographics',
        'db_function' => 'applicantDiversityPwd',
        'headers' => ['Disability / PWD Status', 'Male', 'Female', 'Total'],
    ],
    'undergraduate' => [
        'title' => 'Applicant Undergraduate Course Demographics',
        'db_function' => 'applicantDiversityUndergraduate',
        'headers' => ['Undergraduate Course', 'Male', 'Female', 'Total'],
    ],
    'postgraduate' => [
        'title' => 'Applicant Post Graduate Course Demographics',
        'db_function' => 'applicantDiversityPostGraduate',
        'headers' => ['Post Graduate Course', 'Male', 'Female', 'Total'],
    ],
    'registration' => [
        'title' => 'Applicant Registration Status Demographics',
        'db_function' => 'applicantDiversityRegistration',
        'headers' => ['Registration Status', 'Male', 'Female', 'Total'],
    ],
    'list' => [
        'title' => 'Applicant List',
        'db_function' => 'applicantDiversityList',
        'headers' => ['Applicant Name', 'Sex', 'Birthdate', 'Religion', 'Undergraduate Course', 'Post Graduate Course', 'Email Address', 'Mobile Number'],
    ],
];

if (!isset($exportConfig[$type])) {
    echo "Invalid export parameters.";
    exit;
}

$config = $exportConfig[$type];
$demo = isset($_GET['demo']) ? sanitize(decode($_GET['demo'])) : '';
$groupName = isset($_GET['group']) ? sanitize(decode($_GET['group'])) : '';
$sex = isset($_GET['sex']) ? sanitize(decode($_GET['sex'])) : '';

if ($type === 'list') {
    $config['title'] = "Applicant Diversity Breakdown List: " . ($groupName !== '' ? $groupName : 'All');
}

$func = $config['db_function'];
if ($type === 'list') {
    $onlyApplied = ($demo !== '' && $demo !== 'registration');
    $rows = applicantDiversityList($onlyApplied);
} else {
    $rows = $func();
}

if (!is_array($rows)) {
    $rows = [];
}

if ($type === 'list') {
    $filteredRows = [];
    foreach ($rows as $row) {
        if ($demo !== '' && $groupName !== '' && $groupName !== 'all') {
            $rowGroup = getApplicantDemographicGroup($row, $demo);
            if (strcasecmp($rowGroup, $groupName) !== 0) {
                continue;
            }
        }
        if ($sex !== '' && $sex !== 'all') {
            if (strcasecmp($row['sex'] ?? '', $sex) !== 0) {
                continue;
            }
        }
        $filteredRows[] = $row;
    }
    $rows = $filteredRows;
}

$isBreakdown = ($type === 'list');
$hasGenderBreakdown = ($type !== 'gender' && !$isBreakdown);
$colspan = ($type === 'list') ? 9 : ($hasGenderBreakdown ? 5 : 3);
?>

<table>
    <thead>
        <tr>
            <th colspan="<?= $colspan ?>" style="font-weight: bold; font-size: 14pt; text-align: center;">
                <?= e($config['title']) ?>
            </th>
        </tr>
        <tr>
            <th>#</th>
            <?php if ($type === 'list'): ?>
                <th>Applicant Name</th>
                <th>Sex</th>
                <th>Birthdate</th>
                <th>Religion</th>
                <th>Undergraduate Course</th>
                <th>Post Graduate Course</th>
                <th>Email Address</th>
                <th>Mobile Number</th>
            <?php else: ?>
                <th><?= e($config['headers'][0]) ?></th>
                <?php if ($hasGenderBreakdown): ?>
                    <th>Male</th>
                    <th>Female</th>
                <?php endif; ?>
                <th>Total</th>
            <?php endif; ?>
        </tr>
    </thead>

    <tbody>
        <?php
        $i = 1;
        if ($type === 'list'):
            foreach ($rows as $row):
                $fullName = toName($row['last_name'], $row['first_name'], $row['middle_name'], $row['name_extension']);
                $sex = $row['sex'] ?? '';
                $birthdate = !empty($row['birthdate']) ? date('M d, Y', strtotime($row['birthdate'])) : 'Not Specified';
                $religion = !empty($row['religion']) ? $row['religion'] : 'Not Specified';
                $undergrad = !empty($row['undergraduate']) ? $row['undergraduate'] : 'Not Specified';
                $postgrad = !empty($row['graduate_studies']) ? $row['graduate_studies'] : 'Not Specified';
                $email = $row['email_address'] ?? '';
                $mobile = $row['mobile_number'] ?? '';
                ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= e($fullName) ?></td>
                    <td><?= e($sex) ?></td>
                    <td><?= e($birthdate) ?></td>
                    <td><?= e($religion) ?></td>
                    <td><?= e($undergrad) ?></td>
                    <td><?= e($postgrad) ?></td>
                    <td><?= e($email) ?></td>
                    <td><?= e($mobile) ?></td>
                </tr>
            <?php endforeach; ?>

            <tr style="font-weight: bold;">
                <td colspan="8" style="text-align: right;">Total Applicants</td>
                <td><?= count($rows) ?></td>
            </tr>
        <?php else:
            $totalMale = 0;
            $totalFemale = 0;
            $grandTotal = 0;

            foreach ($rows as $row):
                $name = $row['name'] ?? 'Not Specified';
                $male = isset($row['male']) ? (int) $row['male'] : 0;
                $female = isset($row['female']) ? (int) $row['female'] : 0;
                $total = isset($row['total']) ? (int) $row['total'] : (isset($row['count']) ? (int) $row['count'] : 0);

                $totalMale += $male;
                $totalFemale += $female;
                $grandTotal += $total;
                ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= e($name) ?></td>
                    <?php if ($hasGenderBreakdown): ?>
                        <td><?= $male ?></td>
                        <td><?= $female ?></td>
                    <?php endif; ?>
                    <td><?= $total ?></td>
                </tr>
            <?php endforeach; ?>

            <tr style="font-weight: bold;">
                <td colspan="2" style="text-align: right;">Grand Total</td>
                <?php if ($hasGenderBreakdown): ?>
                    <td><?= $totalMale ?></td>
                    <td><?= $totalFemale ?></td>
                <?php endif; ?>
                <td><?= $grandTotal ?></td>
            </tr>
        <?php endif; ?>

        <tr>
            <td colspan="<?= $colspan ?>" style="font-style: italic;">
                <?= 'Data as of ' . date("F j, Y, g:i a") ?>
            </td>
        </tr>
    </tbody>
</table>