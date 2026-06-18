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
];

if (!isset($exportConfig[$type])) {
    echo "Invalid export parameters.";
    exit;
}

$config = $exportConfig[$type];
$func = $config['db_function'];
$rows = $func();

if (!is_array($rows)) {
    $rows = [];
}

$hasGenderBreakdown = ($type !== 'category' && $type !== 'gender');
?>

<table>
    <thead>
        <tr>
            <th colspan="<?= $hasGenderBreakdown ? 5 : 3 ?>" style="font-weight: bold; font-size: 14pt; text-align: center;">
                <?= e($config['title']) ?>
            </th>
        </tr>
        <tr>
            <th>#</th>
            <th><?= e($config['headers'][0]) ?></th>
            <?php if ($hasGenderBreakdown): ?>
                <th>Male</th>
                <th>Female</th>
            <?php endif; ?>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $i = 1;
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
        
        <tr>
            <td colspan="<?= $hasGenderBreakdown ? 5 : 3 ?>" style="font-style: italic;">
                <?= 'Data as of ' . date("F j, Y, g:i a") ?>
            </td>
        </tr>
    </tbody>
</table>
