<?php
// export/filled-vacancies.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once('../includes/function.php');
    redirect(uri() . '/login');
}

require_once(root() . '/includes/database/vacancy.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/database/employee.php');
?>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Position</th>
            <th>Salary Grade</th>
            <th>Item Number</th>
            <th>Station</th>
            <th>Filled By</th>
            <th>Date Filled</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $i = 1;
        $rows = vacanciesByStatus('filled');
        $rows = is_array($rows) ? $rows : [];

        foreach ($rows as $row):
            $school = !empty($row['station_id']) ? schoolById($row['station_id']) : null;
            $filledBy = !empty($row['filled_by']) ? employee($row['filled_by']) : null;
            $filledByName = $filledBy
                ? toName($filledBy['last_name'], $filledBy['first_name'], $filledBy['middle_name'], $filledBy['name_extension'], true)
                : 'N/A';
        ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= e(strtoupper($row['position'] ?? '')) ?></td>
                <td><?= e($row['salary_grade'] ?? '') ?></td>
                <td><?= e(toHandleNull($row['item_number'], 'N/A')) ?></td>
                <td><?= e(strtoupper($school['name'] ?? 'N/A')) ?></td>
                <td><?= e(strtoupper($filledByName)) ?></td>
                <td><?= !empty($row['date_filled']) ? toLongDate($row['date_filled']) : 'N/A' ?></td>
            </tr>
        <?php endforeach ?>

        <tr>
            <td colspan="7"><?= 'Data as of ' . date("F j, Y, g:i a") ?></td>
        </tr>
    </tbody>
</table>
