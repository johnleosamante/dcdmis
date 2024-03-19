<?php
// export/sections.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once('../includes/function.php');
    redirect(uri() . '/login');
}

require_once(root() . '/includes/database/section.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/utility.php');
?>

<table>
    <thead>
        <tr>
            <th rowspan="2">#</th>
            <th rowspan="2">Section</th>
            <th rowspan="2">Functional Division</th>
            <th rowspan="2">Section Head</th>
            <th rowspan="2">Position</th>
            <th colspan="3">Personnel</th>
        </tr>

        <tr>
            <th>Male</th>
            <th>Female</th>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $i = 1;
        $query = sections();
        while ($row = fetchAssoc($query)) : ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo strtoupper($row['name']); ?></td>
                <td><?php echo strtoupper($row['division']); ?></td>
                <td><?php echo userName($row['head'], true); ?></td>
                <td><?php echo strtoupper(fetchAssoc(position($row['head']))['position']); ?></td>
                <?php
                $sectionCount = sectionEmployeeCount($row['id']);
                $male = $female = $total = 0;

                if (numRows($sectionCount) > 0) {
                    $count = fetchAssoc($sectionCount);
                    $male = $count['male'];
                    $female = $count['female'];
                    $total = $count['total'];
                }
                ?>
                <td><?php echo $male; ?></td>
                <td><?php echo $female; ?></td>
                <td><?php echo $total; ?></td>
            </tr>
        <?php endwhile; ?>
        <tr>
            <td colspan="8"><?php echo 'Data as of ' . date("F j, Y, g:i a"); ?></td>
        </tr>
    </tbody>
</table>