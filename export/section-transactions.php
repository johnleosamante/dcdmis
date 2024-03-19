<?php
// export/section-transactions.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once('../includes/function.php');
    redirect(uri() . '/login');
}

require_once(root() . '/includes/database/section.php');
require_once(root() . '/includes/database/document.php');
?>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Section Name</th>
            <th>Functional Division</th>
            <th>Incoming</th>
            <th>Pending</th>
            <th>Outgoing</th>
            <th>Ongoing</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $i = 1;

        $sections = sections();
        while ($section = fetchAssoc($sections)) : ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo strtoupper($section['name']); ?></td>
                <td><?php echo strtoupper($section['division']); ?></td>
                <td><?php echo number_format(numRows(incomingDocuments($section['id']))); ?></td>
                <td><?php echo number_format(numRows(pendingDocuments($section['id']))); ?></td>
                <td><?php echo number_format(numRows(outgoingDocuments($section['id']))); ?></td>
                <td><?php echo number_format(numRows(ongoingDocuments($section['id']))); ?></td>
            </tr>
        <?php endwhile; ?>
        <tr>
            <td colspan="7"><?php echo 'Data as of ' . date("F j, Y, g:i a"); ?></td>
        </tr>
    </tbody>
</table>