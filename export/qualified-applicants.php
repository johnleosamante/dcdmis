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
            <td colspan="3" style="font-weight: bold; font-size: 14px;">QUALIFIED APPLICANTS REPORT</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Publication Code:</td>
            <td colspan="2">
                <?= e($publication['code'] ?? 'N/A') ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Publication Title:</td>
            <td colspan="2">
                <?= e($publication['title'] ?? 'N/A') ?>
            </td>
        </tr>
        <?php if (!empty($publication['description'])): ?>
            <tr>
                <td style="font-weight: bold;">Description:</td>
                <td colspan="2">
                    <?= e($publication['description']) ?>
                </td>
            </tr>
        <?php endif ?>
        <tr>
            <td style="font-weight: bold;">Export Date:</td>
            <td colspan="2">
                <?= date('F d, Y g:i A') ?>
            </td>
        </tr>
        <tr>
            <td colspan="3"></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th>Applicant Name</th>
            <th>Position Applied</th>
            <th>Applied On</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $apps = applicantsByPublication($publicationId);
        $qualifiedApps = array_filter($apps, function ($app) {
            return $app['status'] === 'Qualified';
        });

        // Group applicants by name
        $groupedByApplicant = [];
        foreach ($qualifiedApps as $app) {
            $applicantName = applicantName($app['application_code']);
            if (!isset($groupedByApplicant[$applicantName])) {
                $groupedByApplicant[$applicantName] = [];
            }
            $groupedByApplicant[$applicantName][] = $app;
        }

        // Output grouped data
        foreach ($groupedByApplicant as $applicantName => $positions) {
            $isFirstRow = true;
            foreach ($positions as $app):
                ?>
                <tr>
                    <?php if ($isFirstRow): ?>
                        <td><?= e($applicantName) ?></td>
                        <?php $isFirstRow = false; ?>
                    <?php else: ?>
                        <td></td>
                    <?php endif ?>
                    <td><?= e($app['official_title']) ?></td>
                    <td><?= toDatetime($app['created_at']) ?></td>
                </tr>
            <?php endforeach;
        }
        ?>
    </tbody>
</table>