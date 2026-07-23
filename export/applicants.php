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
            <td colspan="8" style="font-weight: bold; font-size: 14px;">APPLICANTS REPORT</td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight: bold;">Call for Application Code:</td>
            <td colspan="6">
                <?= e($publication['code'] ?? 'N/A') ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight: bold;">Call for Application Title:</td>
            <td colspan="6">
                <?= e($publication['title'] ?? 'N/A') ?>
            </td>
        </tr>
        <?php if (!empty($publication['description'])): ?>
            <tr>
                <td colspan="2" style="font-weight: bold;">Call for Application Description:</td>
                <td colspan="6">
                    <?= e($publication['description']) ?>
                </td>
            </tr>
        <?php endif ?>
        <tr>
            <td colspan="2" style="font-weight: bold;">Export Date:</td>
            <td colspan="6">
                <?= date('F d, Y g:i A') ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight: bold;">Applied Filters:</td>
            <td colspan="6">
                Position: <?= ($selectedPositionId === 'all') ? 'All' : 'Filtered' ?> |
                Applicant Type:
                <?= ($selectedStatus === 'all') ? 'All' : (($selectedStatus === 'internal') ? 'Internal' : 'External') ?>
            </td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Application Code</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Name Extension</th>
            <th>Middle Name</th>
            <th>Applicant Type</th>
            <th>Applied On</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $groupedByCategory = [];
        foreach ($apps as $app) {
            $group = $app['position_group'] ?? 'Uncategorized';
            $position = $app['official_title'] ?? 'Unknown Position';

            $applicantId = $app['application_code_id'] ?? null;
            $data = null;
            if ($applicantId) {
                $data = employee($applicantId);
                if (!$data) {
                    $data = applicant($applicantId);
                }
            }

            $groupedByCategory[$group][$position][] = [
                'last_name' => $data['last_name'] ?? '',
                'first_name' => $data['first_name'] ?? '',
                'name_extension' => $data['name_extension'] ?? '',
                'middle_name' => $data['middle_name'] ?? '',
                'app' => $app,
            ];
        }

        foreach ($groupedByCategory as $group => $positions):
            $groupTotal = array_sum(array_map('count', $positions));
            ?>
            <tr>
                <td colspan="8" style="font-weight: bold; background-color: #d0d0d0; font-size: 13px;">
                    <?= e($group) ?> &mdash; <?= $groupTotal ?> applicant<?= $groupTotal !== 1 ? 's' : '' ?>
                </td>
            </tr>
            <?php foreach ($positions as $positionTitle => $entries):
                $posCount = count($entries);
                ?>
                <tr>
                    <td colspan="8" style="font-weight: bold; background-color: #f0f0f0; padding-left: 16px;">
                        <?= e($positionTitle) ?> &mdash; <?= $posCount ?> applicant<?= $posCount !== 1 ? 's' : '' ?>
                    </td>
                </tr>
                <?php
                $i = 1;
                foreach ($entries as $entry):
                    $appRow = $entry['app'];
                    $empStatusText = $appRow['is_employed'] ? 'Internal' : 'External';
                    ?>
                    <tr style="text-transform: uppercase;">
                        <td><?= $i++ ?></td>
                        <td style="mso-number-format:'\@';"><?= e($appRow['application_code']) ?></td>
                        <td><?= e($entry['last_name']) ?></td>
                        <td><?= e($entry['first_name']) ?></td>
                        <td><?= e($entry['name_extension']) ?></td>
                        <td><?= e($entry['middle_name']) ?></td>
                        <td><?= $empStatusText ?></td>
                        <td><?= toDatetime($appRow['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>

        <?php if (count($apps) === 0): ?>
            <tr>
                <td colspan="8" style="text-align: center;">No applicants found matching the filter criteria.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>