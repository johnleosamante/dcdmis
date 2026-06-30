<?php
// export/applicants.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once('../includes/function.php');
    redirect("{$baseUri}/login");
}

require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/vacancy.php');

$publicationId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;

if (empty($publicationId)) {
    redirect(uri() . '/login');
}

$publication = publication($publicationId);

// Handle filter inputs from query string
$selectedPositionId = isset($_GET['position_id']) ? sanitize($_GET['position_id']) : 'all';
$selectedStatus = isset($_GET['status']) ? sanitize($_GET['status']) : 'all';

$positionIdParam = ($selectedPositionId !== 'all' && $selectedPositionId !== '') ? sanitize(decipher($selectedPositionId)) : null;
$statusParam = ($selectedStatus !== 'all' && $selectedStatus !== '') ? $selectedStatus : null;

$apps = applicantsListByPublication($publicationId, $positionIdParam, $statusParam);
?>

<table>
    <tbody>
        <tr>
            <td colspan="5" style="font-weight: bold; font-size: 14px;">APPLICANTS REPORT</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Call for Application Code:</td>
            <td colspan="4">
                <?= e($publication['code'] ?? 'N/A') ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Call for Application Title:</td>
            <td colspan="4">
                <?= e($publication['title'] ?? 'N/A') ?>
            </td>
        </tr>
        <?php if (!empty($publication['description'])): ?>
            <tr>
                <td style="font-weight: bold;">Call for Application Description:</td>
                <td colspan="4">
                    <?= e($publication['description']) ?>
                </td>
            </tr>
        <?php endif ?>
        <tr>
            <td style="font-weight: bold;">Export Date:</td>
            <td colspan="4">
                <?= date('F d, Y g:i A') ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Applied Filters:</td>
            <td colspan="4">
                Position: <?= ($selectedPositionId === 'all') ? 'All' : 'Filtered' ?> |
                Employment Status:
                <?= ($selectedStatus === 'all') ? 'All' : (($selectedStatus === 'employed') ? 'Currently Employed' : 'Not Employed') ?>
            </td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th>No.</th>
            <th colspan="2">Applicant Name</th>
            <th>Employment Status</th>
            <th>Applied On</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $groupedByCategory = [];
        foreach ($apps as $app) {
            $group = $app['position_group'] ?? 'Uncategorized';
            $position = $app['official_title'] ?? 'Unknown Position';
            $applicantName = applicantName($app['application_code']);
            $groupedByCategory[$group][$position][] = [
                'name' => $applicantName,
                'app' => $app,
            ];
        }

        // Output grouped data
        foreach ($groupedByCategory as $group => $positions):
            $groupTotal = array_sum(array_map('count', $positions));
            ?>
            <tr>
                <td colspan="5" style="font-weight: bold; background-color: #d0d0d0; font-size: 13px;">
                    <?= e($group) ?> &mdash; <?= $groupTotal ?> applicant<?= $groupTotal !== 1 ? 's' : '' ?>
                </td>
            </tr>
            <?php foreach ($positions as $positionTitle => $entries):
                $posCount = count($entries);
                ?>
                <tr>
                    <td colspan="5" style="font-weight: bold; background-color: #f0f0f0; padding-left: 16px;">
                        <?= e($positionTitle) ?> &mdash; <?= $posCount ?> applicant<?= $posCount !== 1 ? 's' : '' ?>
                    </td>
                </tr>
                <?php
                $i = 1;
                foreach ($entries as $entry):
                    $appRow = $entry['app'];
                    $empStatusText = $appRow['is_employed'] ? 'Currently Employed' : 'Not Employed';
                    ?>
                    <tr style="text-transform: uppercase;">
                        <td><?= $i++ ?></td>
                        <td colspan="2"><?= e($entry['name']) ?></td>
                        <td><?= $empStatusText ?></td>
                        <td><?= toDatetime($appRow['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>

        <?php if (count($apps) === 0): ?>
            <tr>
                <td colspan="5" style="text-align: center;">No applicants found matching the filter criteria.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>