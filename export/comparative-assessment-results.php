<?php
// export/comparative-assessment-results.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once('../includes/function.php');
    redirect("{$baseUri}/login");
}

require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/vacancy.php');

$publicationId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : null;
$positionId = isset($_GET['pos']) ? sanitize(decode($_GET['pos'])) : null;

if (empty($publicationId)) {
    redirect(uri() . '/login');
}

$publication = publication($publicationId);

$pubItems = publicationItems($publicationId);
$positions = [];
foreach ($pubItems as $item) {
    if ($positionId !== null && $item['position_id'] != $positionId) {
        continue;
    }
    $posDetails = find("SELECT `category` FROM `positions` WHERE `id` = ?", [$item['position_id']]);
    $category = $posDetails ? $posDetails['category'] : 'N/A';

    $positions[$item['position_id']] = [
        'id' => $item['position_id'],
        'official_title' => $item['official_title'],
        'salary_grade' => $item['salary_grade'],
        'category' => $category
    ];
}

uasort($positions, function ($a, $b) {
    return strcmp($a['official_title'], $b['official_title']);
});

$results = qualifiedApplicantsAssessmentResults($publicationId);
$resultsByPosition = [];
if ($results) {
    foreach ($results as $res) {
        $resultsByPosition[$res['position_id']][] = $res;
    }
}
?>

<table>
    <tbody>
        <tr>
            <td colspan="12" style="font-weight: bold; font-size: 16px; text-align: center;">COMPARATIVE ASSESSMENT
                RESULTS</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Code:</td>
            <td colspan="11"><?= e($publication['code'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Title:</td>
            <td colspan="11"><?= e($publication['title'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Description:</td>
            <td colspan="11"><?= e($publication['description'] ?? 'N/A') ?>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Export Date:</td>
            <td colspan="11"><?= date('F d, Y g:i A') ?></td>
        </tr>
    </tbody>
</table>

<?php foreach ($positions as $posId => $pos):
    $posResults = $resultsByPosition[$posId] ?? [];
    ?>
    <table>
        <thead>
            <tr>
                <th colspan="12" style="font-weight: bold; background-color: #d0d0d0; font-size: 14px; text-align: left;">
                    POSITION: <?= strtoupper(e($pos['official_title'])) ?> (SG <?= e($pos['salary_grade']) ?>)
                </th>
            </tr>
            <tr>
                <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000000; text-align: center;">
                    Rank</th>
                <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000000; text-align: center;">
                    Applicant Name</th>
                <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000000; text-align: center;">
                    Education</th>
                <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000000; text-align: center;">
                    Training</th>
                <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000000; text-align: center;">
                    Experience</th>
                <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000000; text-align: center;">
                    Performance</th>
                <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000000; text-align: center;">
                    Outstanding Accomplishments</th>
                <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000000; text-align: center;">
                    Application of Education</th>
                <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000000; text-align: center;">
                    Application of L&D</th>
                <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000000; text-align: center;">
                    Potential</th>
                <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000000; text-align: center;">
                    Total Score</th>
                <th style="font-weight: bold; background-color: #f2f2f2; border: 1px solid #000000; text-align: center;">
                    Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($posResults) > 0):
                $ranks = [];
                $currentRank = 1;
                $prevScore = null;
                $itemCount = 0;
                foreach ($posResults as $index => $res) {
                    $itemCount++;
                    $score = $res['total_accumulated_score'];
                    if ($score === null) {
                        $ranks[$index] = '-';
                    } else {
                        if ($prevScore === null || (float) $score !== (float) $prevScore) {
                            $currentRank = $itemCount;
                        }
                        $ranks[$index] = $currentRank;
                        $prevScore = $score;
                    }
                }
                foreach ($posResults as $index => $res):
                    $name = applicantName($res['application_code']);
                    $isAssessed = ($res['total_accumulated_score'] !== null);
                    ?>
                    <tr style="text-transform: uppercase;">
                        <td style="text-align: center; border: 1px solid #000000;"><?= $ranks[$index] ?></td>
                        <td style="border: 1px solid #000000;"><?= strtoupper(e($name)) ?></td>
                        <td style="text-align: center; border: 1px solid #000000;">
                            <?= $isAssessed ? number_format($res['education_score'], 3, '.', '') : '0.000' ?>
                        </td>
                        <td style="text-align: center; border: 1px solid #000000;">
                            <?= $isAssessed ? number_format($res['training_score'], 3, '.', '') : '0.000' ?>
                        </td>
                        <td style="text-align: center; border: 1px solid #000000;">
                            <?= $isAssessed ? number_format($res['experience_score'], 3, '.', '') : '0.000' ?>
                        </td>
                        <td style="text-align: center; border: 1px solid #000000;">
                            <?= $isAssessed ? number_format($res['performance_score'], 3, '.', '') : '0.000' ?>
                        </td>
                        <td style="text-align: center; border: 1px solid #000000;">
                            <?= $isAssessed ? number_format($res['outstanding_accomplishments_score'], 3, '.', '') : '0.000' ?>
                        </td>
                        <td style="text-align: center; border: 1px solid #000000;">
                            <?= $isAssessed ? number_format($res['application_of_education_score'], 3, '.', '') : '0.000' ?>
                        </td>
                        <td style="text-align: center; border: 1px solid #000000;">
                            <?= $isAssessed ? number_format($res['application_of_ld_score'], 3, '.', '') : '0.000' ?>
                        </td>
                        <td style="text-align: center; border: 1px solid #000000;">
                            <?= $isAssessed ? number_format($res['potential_final_score'], 3, '.', '') : '0.000' ?>
                        </td>
                        <td style="text-align: center; font-weight: bold; border: 1px solid #000000;">
                            <?= $isAssessed ? number_format($res['total_accumulated_score'], 3, '.', '') : 'Not Assessed' ?>
                        </td>
                        <td style="border: 1px solid #000000;"><?= e($res['hrmspb_remarks'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="12" style="text-align: center; font-style: italic; color: #777; border: 1px solid #000000;">No
                        qualified applicants have been assessed for this position yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
<?php endforeach; ?>