<?php
// export/qualified-applicants.php
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
?>

<table>
    <tbody>
        <tr>
            <td colspan="4" style="font-weight: bold; font-size: 14px;">QUALIFIED APPLICANTS REPORT</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Call for Application Code:</td>
            <td colspan="3">
                <?= e($publication['code'] ?? 'N/A') ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Call for Application Title:</td>
            <td colspan="3">
                <?= e($publication['title'] ?? 'N/A') ?>
            </td>
        </tr>
        <?php if (!empty($publication['description'])): ?>
            <tr>
                <td style="font-weight: bold;">Call for Application Description:</td>
                <td colspan="3">
                    <?= e($publication['description']) ?>
                </td>
            </tr>
        <?php endif ?>
        <tr>
            <td style="font-weight: bold;">Export Date:</td>
            <td colspan="3">
                <?= date('F d, Y g:i A') ?>
            </td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th>No.</th>
            <th colspan="2">Applicant Name</th>
            <th>Applied On</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $apps = applicantsByPublication($publicationId);
        $qualifiedApps = array_filter($apps, function ($app) {
            return $app['status'] === 'Qualified';
        });

        // Group applicants by position group (category), then by position title
        $groupedByCategory = [];
        foreach ($qualifiedApps as $app) {
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
                <td colspan="4" style="font-weight: bold; background-color: #d0d0d0; font-size: 13px;">
                    <?= e($group) ?> &mdash; <?= $groupTotal ?> qualified applicant<?= $groupTotal !== 1 ? 's' : '' ?>
                </td>
            </tr>
            <?php foreach ($positions as $positionTitle => $entries):
                $posCount = count($entries);
                ?>
                <tr>
                    <td colspan="4" style="font-weight: bold; background-color: #f0f0f0; padding-left: 16px;">
                        <?= e($positionTitle) ?> &mdash; <?= $posCount ?> applicant<?= $posCount !== 1 ? 's' : '' ?>
                    </td>
                </tr>
                <?php
                $counter = 1;
                foreach ($entries as $entry):
                    $applicantName = $entry['name'];
                    $app = $entry['app'];
                    ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td colspan="2"><?= strtoupper(e($applicantName)) ?></td>
                        <td><?= toDatetime($app['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>