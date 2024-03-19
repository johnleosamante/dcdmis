<?php
// export/districts.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once('../includes/function.php');
    redirect(uri() . '/login');
}

require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/utility.php');
?>

<table>
    <thead>
        <tr>
            <th rowspan="2">#</th>
            <th rowspan="2">District</th>
            <th rowspan="2">Supervisor</th>
            <th colspan="4">School Categories</th>
        </tr>
        <tr>
            <th>ES</th>
            <th>HS</th>
            <th>IS</th>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $i = 1;
        $query = districts();

        while ($row = fetchArray($query)) : ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo strtoupper($row['name']); ?></td>
                <td><?php echo userName($row['psds'], true); ?></td>
                <?php
                $schoolCount = districtSchoolCount($row['id']);
                $es = $hs = $is = $total = 0;

                if (numRows($schoolCount) > 0) {
                    $count = fetchAssoc($schoolCount);
                    $es = $count['es'];
                    $hs = $count['hs'];
                    $is = $count['is'];
                    $total = $count['total'];
                }
                ?>
                <td><?php echo toHandleNull($es, '0'); ?></td>
                <td><?php echo toHandleNull($hs, '0'); ?></td>
                <td><?php echo toHandleNull($is, '0'); ?></td>
                <td><?php echo $total; ?></td>
            </tr>
        <?php endwhile; ?>
        <tr>
            <td colspan="7"><?php echo 'Data as of ' . date("F j, Y, g:i a"); ?></td>
        </tr>
    </tbody>
</table>