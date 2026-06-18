<?php
// export/demographics.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once('../includes/function.php');
    redirect(uri() . '/login');
}

require_once(root() . '/includes/database/employee.php');

$type = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : '';

$exportConfig = [
    'gender' => [
        'title' => 'Employee Gender Demographics',
        'db_function' => 'demographicsGender',
        'headers' => ['Gender', 'Total'],
    ],
    'category' => [
        'title' => 'Employees by Category Demographics',
        'db_function' => 'demographicsCategory',
        'headers' => ['Category', 'Total'],
    ],
    'category-gender' => [
        'title' => 'Employee Categories by Gender Demographics',
        'db_function' => 'demographicsCategoryGender',
        'headers' => ['Category', 'Male', 'Female', 'Total'],
    ],
    'position' => [
        'title' => 'Employees by Position Demographics',
        'db_function' => 'demographicsPosition',
        'headers' => ['Position', 'Male', 'Female', 'Total'],
    ],
    'generation' => [
        'title' => 'Employee Generations Demographics',
        'db_function' => 'demographicsGeneration',
        'headers' => ['Generation', 'Male', 'Female', 'Total'],
    ],
    'education' => [
        'title' => 'Highest Educational Attainment Demographics',
        'db_function' => 'demographicsEducation',
        'headers' => ['Education Level', 'Male', 'Female', 'Total'],
    ],
    'religion' => [
        'title' => 'Employees by Religion Demographics',
        'db_function' => 'demographicsReligion',
        'headers' => ['Religion', 'Male', 'Female', 'Total'],
    ],
    'indigenous' => [
        'title' => 'Indigenous People Demographics',
        'db_function' => 'demographicsIndigenous',
        'headers' => ['Indigenous Group', 'Male', 'Female', 'Total'],
    ],
    'pwd' => [
        'title' => 'Persons with Disability (PWD) Demographics',
        'db_function' => 'demographicsPwd',
        'headers' => ['Disability / PWD Status', 'Male', 'Female', 'Total'],
    ],
    'solo-parents' => [
        'title' => 'Solo Parent Demographics',
        'db_function' => 'demographicsSoloParent',
        'headers' => ['Solo Parent Status', 'Male', 'Female', 'Total'],
    ],
    'districts' => [
        'title' => 'Employees by District Demographics',
        'db_function' => 'demographicsDistrict',
        'headers' => ['District', 'Male', 'Female', 'Total'],
    ],
    'schools' => [
        'title' => 'Employees by School Assignment Demographics',
        'db_function' => 'demographicsSchool',
        'headers' => ['School/Station', 'Male', 'Female', 'Total'],
    ],
    'category-breakdown' => [
        'title' => 'Employee Name Breakdown per Category with Position',
        'db_function' => 'employeeCategoryBreakdown',
        'headers' => ['Employee Name', 'Sex', 'Position', 'Category'],
    ],
    'list' => [
        'title' => 'Employee List',
        'db_function' => 'demographicsEmployeeList',
        'headers' => ['Employee Name', 'Sex', 'Position', 'School / Station', 'District'],
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
$position = isset($_GET['position']) ? sanitize(decode($_GET['position'])) : '';
$school = isset($_GET['school']) ? sanitize(decode($_GET['school'])) : '';

if ($type === 'list') {
    $config['title'] = "Demographics Breakdown List: " . ($groupName !== '' ? $groupName : 'All');
}

$func = $config['db_function'];
$rows = $func();

if (!is_array($rows)) {
    $rows = [];
}

if ($type === 'list') {
    $filteredRows = [];
    foreach ($rows as $row) {
        if ($demo !== '' && $groupName !== '' && $groupName !== 'all') {
            $rowGroup = getEmployeeDemographicGroup($row, $demo);
            if (strcasecmp($rowGroup, $groupName) !== 0) {
                continue;
            }
        }
        if ($sex !== '' && $sex !== 'all') {
            if (strcasecmp($row['sex'] ?? '', $sex) !== 0) {
                continue;
            }
        }
        if ($position !== '' && $position !== 'all') {
            if (strcasecmp($row['position'] ?? '', $position) !== 0) {
                continue;
            }
        }
        if ($school !== '' && $school !== 'all') {
            if (strcasecmp($row['school'] ?? '', $school) !== 0) {
                continue;
            }
        }
        $filteredRows[] = $row;
    }
    $rows = $filteredRows;
}

$isBreakdown = ($type === 'category-breakdown' || $type === 'list');
$hasGenderBreakdown = ($type !== 'category' && $type !== 'gender' && !$isBreakdown);
$colspan = ($type === 'list') ? 6 : ($isBreakdown ? 5 : ($hasGenderBreakdown ? 5 : 3));
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
                <th>Employee Name</th>
                <th>Sex</th>
                <th>Position</th>
                <th>School / Station</th>
                <th>District</th>
            <?php elseif ($type === 'category-breakdown'): ?>
                <th>Employee Name</th>
                <th>Sex</th>
                <th>Position</th>
                <th>Category</th>
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
                $position = $row['position'] ?? '';
                $school = $row['school'] ?? '';
                $district = $row['district'] ?? '';
                ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= e($fullName) ?></td>
                    <td><?= e($sex) ?></td>
                    <td><?= e($position) ?></td>
                    <td><?= e($school) ?></td>
                    <td><?= e($district) ?></td>
                </tr>
            <?php endforeach; ?>
            
            <tr style="font-weight: bold;">
                <td colspan="5" style="text-align: right;">Total Employees</td>
                <td><?= count($rows) ?></td>
            </tr>
        <?php elseif ($type === 'category-breakdown'):
            foreach ($rows as $row):
                $fullName = toName($row['last_name'], $row['first_name'], $row['middle_name'], $row['name_extension']);
                $sex = $row['sex'] ?? '';
                $position = $row['position'] ?? '';
                $category = $row['category'] ?? '';
                ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= e($fullName) ?></td>
                    <td><?= e($sex) ?></td>
                    <td><?= e($position) ?></td>
                    <td><?= e($category) ?></td>
                </tr>
            <?php endforeach; ?>
            
            <tr style="font-weight: bold;">
                <td colspan="4" style="text-align: right;">Total Employees</td>
                <td><?= count($rows) ?></td>
            </tr>
        <?php else:
            $totalMale = 0;
            $totalFemale = 0;
            $grandTotal = 0;

            foreach ($rows as $row): 
                $name = $row['name'] ?? 'Not Specified';
                $male = isset($row['male']) ? (int)$row['male'] : 0;
                $female = isset($row['female']) ? (int)$row['female'] : 0;
                $total = isset($row['total']) ? (int)$row['total'] : (isset($row['count']) ? (int)$row['count'] : 0);

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
