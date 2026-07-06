<?php
// modules/applicants/diversity/page.php
if (!$isHrmis && !$isHrtdms && !$isDmis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$diversityConfig = [
    'Talent Pool Diversity - Gender' => [
        'title' => 'Gender',
        'icon' => 'fa-venus-mars',
        'db_function' => 'applicantDiversityGender',
        'headers' => ['Gender', 'Total'],
        'chart_type' => 'doughnut',
        'export_id' => 'gender',
    ],
    'Talent Pool Diversity - Generation' => [
        'title' => 'Generation',
        'icon' => 'fa-hourglass-half',
        'db_function' => 'applicantDiversityGeneration',
        'headers' => ['Generation', 'Male', 'Female', 'Total'],
        'chart_type' => 'bar',
        'export_id' => 'generation',
    ],
    'Talent Pool Diversity - Religion' => [
        'title' => 'Religion',
        'icon' => 'fa-hands-helping',
        'db_function' => 'applicantDiversityReligion',
        'headers' => ['Religion', 'Male', 'Female', 'Total'],
        'chart_type' => 'doughnut',
        'export_id' => 'religion',
    ],
    'Talent Pool Diversity - Ethnic Group' => [
        'title' => 'Ethnic Group',
        'icon' => 'fa-users',
        'db_function' => 'applicantDiversityIndigenous',
        'headers' => ['Indigenous Group', 'Male', 'Female', 'Total'],
        'chart_type' => 'doughnut',
        'export_id' => 'indigenous',
    ],
    'Talent Pool Diversity - PWD' => [
        'title' => 'Persons with Disability',
        'icon' => 'fa-wheelchair',
        'db_function' => 'applicantDiversityPwd',
        'headers' => ['Disability / PWD Status', 'Male', 'Female', 'Total'],
        'chart_type' => 'doughnut',
        'export_id' => 'pwd',
    ],
    'Talent Pool Diversity - Undergraduate' => [
        'title' => 'Undergraduate Courses',
        'icon' => 'fa-graduation-cap',
        'db_function' => 'applicantDiversityUndergraduate',
        'headers' => ['Undergraduate Course', 'Male', 'Female', 'Total'],
        'chart_type' => 'bar',
        'export_id' => 'undergraduate',
    ],
    'Talent Pool Diversity - Post Graduate' => [
        'title' => 'Post Graduate Courses',
        'icon' => 'fa-graduation-cap',
        'db_function' => 'applicantDiversityPostGraduate',
        'headers' => ['Post Graduate Course', 'Male', 'Female', 'Total'],
        'chart_type' => 'bar',
        'export_id' => 'postgraduate',
    ],
    'Talent Pool Diversity - Registration' => [
        'title' => 'Registration Status',
        'icon' => 'fa-clipboard-list',
        'db_function' => 'applicantDiversityRegistration',
        'headers' => ['Registration Status', 'Male', 'Female', 'Total'],
        'chart_type' => 'doughnut',
        'export_id' => 'registration',
    ],
];

if (!isset($diversityConfig[$url])) {
    require_once(root() . '/modules/error/404.php');
    return;
}

$config = $diversityConfig[$url];
$func = $config['db_function'];
$rows = $func(); // Fetch demographics data

if (!is_array($rows)) {
    $rows = [];
}

$selectedGroup = isset($_GET['group']) ? sanitize($_GET['group']) : 'all';
$selectedSex = isset($_GET['sex']) ? sanitize($_GET['sex']) : 'all';
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Talent Pool Diversity</li>
            <li class="breadcrumb-item active"><?= e($config['title']) ?></li>
        </ol>
    </nav>
</div>

<div class="mb-4">
    <div class="d-flex flex-wrap align-items-center justify-content-start" style="gap: 6px;">
        <?php foreach ($diversityConfig as $viewName => $info): ?>
            <a href="<?= customUri('hrmis', $viewName) ?>"
                class="btn btn-sm <?= $url === $viewName ? 'btn-primary' : 'btn-light border text-secondary' ?> d-flex align-items-center"
                style="gap: 5px; font-weight: 500; border-radius: 20px; padding: 6px 14px; transition: all 0.2s;">
                <i class="fas <?= $info['icon'] ?>"></i>
                <span><?= e(str_replace(['Applicant ', 'Diversity', 'Demographics'], '', $info['title'])) ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<script src="<?= uri() ?>/assets/vendor/chart.js/Chart.min.js"></script>
<script src="<?= uri() ?>/assets/vendor/chart.js/chartjs-plugin-datalabels.min.js"></script>
<script src="<?= uri() ?>/assets/js/chart-custom.js?v=1.3"></script>

<div class="row">
    <!-- Visual Chart Card -->
    <div class="col-xl-5 col-lg-12 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark text-uppercase">
                    <?= e($config['title']) ?> Chart
                </h6>
            </div>
            <div class="card-body">
                <?php
                $isPieLike = in_array($config['chart_type'], ['pie', 'doughnut', 'polarArea']);
                $chartClass = $isPieLike ? 'chart-pie py-2' : 'chart-bar h-auto';
                ?>
                <div class="<?= $chartClass ?>">
                    <canvas id="diversity-chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="col-xl-7 col-lg-12 mb-4">
        <div class="card shadow h-100">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom">
                <h6 class="m-0 font-weight-bold text-uppercase text-dark">
                    <?= e($config['title']) ?> Summary
                </h6>
                <div class="d-inline-block">
                    <?php linkButtonSplit(customUri('export', 'applicant-diversity', $config['export_id']), 'Export', 'fa-file-excel', 'Export to Excel', 'success') ?>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive font-weight-normal">
                    <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="align-middle" width="5%">#</th>
                                <?php foreach ($config['headers'] as $header): ?>
                                    <th class="align-middle"><?= e($header) ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $totalMale = 0;
                            $totalFemale = 0;
                            $grandTotal = 0;
                            $hasGenderBreakdown = ($config['export_id'] !== 'gender');

                            foreach ($rows as $row):
                                $name = $row['name'] ?? 'Not Specified';
                                $male = isset($row['male']) ? (int) $row['male'] : 0;
                                $female = isset($row['female']) ? (int) $row['female'] : 0;
                                $total = isset($row['total']) ? (int) $row['total'] : (isset($row['count']) ? (int) $row['count'] : 0);

                                $totalMale += $male;
                                $totalFemale += $female;
                                $grandTotal += $total;
                                ?>
                                <tr class="text-uppercase">
                                    <td class="align-middle"><?= $i++ ?></td>
                                    <td class="align-middle text-left text-dark"><?= e($name) ?></td>
                                    <?php if ($hasGenderBreakdown): ?>
                                        <td class="align-middle text-mars"><?= number_format($male) ?></td>
                                        <td class="align-middle text-venus"><?= number_format($female) ?></td>
                                    <?php endif; ?>
                                    <td class="align-middle text-dark font-weight-bold"><?= number_format($total) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold text-dark text-uppercase">
                                <td colspan="2" class="text-right align-middle">Grand Total</td>
                                <?php if ($hasGenderBreakdown): ?>
                                    <td class="align-middle text-mars"><?= number_format($totalMale) ?></td>
                                    <td class="align-middle text-venus"><?= number_format($totalFemale) ?></td>
                                <?php endif; ?>
                                <td class="align-middle text-dark font-weight-bold"><?= number_format($grandTotal) ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-0">
    <div class="col-12">
        <div class="card shadow" id="diversity-breakdown">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom">
                <h6 class="m-0 font-weight-bold text-dark text-uppercase">
                    <?= e($config['title']) ?> Breakdown
                </h6>
                <div class="d-inline-block">
                    <?php
                    $exportUrl = customUri('export', 'applicant-diversity', 'list') . '&demo=' . encode($config['export_id']);
                    if ($selectedGroup !== 'all') {
                        $exportUrl .= '&group=' . encode($selectedGroup);
                    }
                    if ($selectedSex !== 'all') {
                        $exportUrl .= '&sex=' . encode($selectedSex);
                    }
                    ?>
                </div>
            </div>
            <div class="card-body">
                <?php
                $onlyApplied = ($config['export_id'] !== 'registration');
                $allApplicants = applicantDiversityList($onlyApplied);
                $groupedApplicants = [];
                foreach ($rows as $r) {
                    $groupName = $r['name'] ?? 'Not Specified';
                    $groupedApplicants[$groupName] = [];
                }
                foreach ($allApplicants as $app) {
                    $groupName = getApplicantDemographicGroup($app, $config['export_id']);
                    if (!isset($groupedApplicants[$groupName])) {
                        $groupedApplicants[$groupName] = [];
                    }
                    $groupedApplicants[$groupName][] = $app;
                }

                // Filter list in PHP
                $filteredApplicants = [];
                foreach ($allApplicants as $app) {
                    $groupName = getApplicantDemographicGroup($app, $config['export_id']);
                    if ($selectedGroup !== 'all' && strcasecmp($groupName, $selectedGroup) !== 0) {
                        continue;
                    }
                    if ($selectedSex !== 'all' && strcasecmp($app['sex'] ?? '', $selectedSex) !== 0) {
                        continue;
                    }
                    $filteredApplicants[] = $app;
                }
                $allApplicants = $filteredApplicants;
                ?>

                <!-- Filter Panel Form -->
                <form method="GET" action="">
                    <input type="hidden" name="v" value="<?= e($_GET['v'] ?? '') ?>">
                    <?php $isGender = $config['title'] === 'Gender'; ?>
                    <div class="row">
                        <?php if (!$isGender) { ?>
                            <div class="col-md-8 mb-2">
                                <label for="filter-group"
                                    class="font-weight-bold text-gray-800 small mb-0"><?= $config['title'] ?></label>
                                <select id="filter-group" name="group" class="form-control">
                                    <option value="all" <?= setOptionSelected($selectedGroup, 'all') ?>>All</option>
                                    <?php foreach (array_keys($groupedApplicants) as $gName): ?>
                                        <option value="<?= e($gName) ?>" <?= setOptionSelected($selectedGroup, $gName) ?>>
                                            <?= e($gName) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php } ?>
                        <div class="col-md-<?= $isGender ? 12 : 4 ?> mb-2">
                            <label for="filter-sex" class="font-weight-bold text-gray-800 small mb-0">Gender</label>
                            <select id="filter-sex" name="sex" class="form-control">
                                <option value="all" <?= setOptionSelected($selectedSex, 'all') ?>>All</option>
                                <option value="Male" <?= setOptionSelected($selectedSex, 'Male') ?>>Male</option>
                                <option value="Female" <?= setOptionSelected($selectedSex, 'Female') ?>>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3 mb-4">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-filter mr-1"></i> Filter Result
                            </button>
                            <a href="<?= $exportUrl ?>" class="btn btn-success btn-icon-split shadow-sm">
                                <span class="icon text-white-50">
                                    <i class="fas fa-file-excel"></i>
                                </span>
                                <span class="text">Export Result</span>
                            </a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive font-weight-normal">
                    <table class="table table-hover mb-0 text-center" id="data-table-next" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="align-middle" width="5%">Photo</th>
                                <th class="align-middle" width="30%">Name / Date of Birth</th>
                                <th class="align-middle" width="45%">Education</th>
                                <th class="align-middle" width="20%">Contact Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($allApplicants as $appRow):
                                $employeeName = toName($appRow['last_name'], $appRow['first_name'], $appRow['middle_name'], $appRow['name_extension']);
                                $sex = $appRow['sex'];
                                $birthdate = toLongDate($appRow['birthdate']);
                                $undergrad = $appRow['undergraduate'] ?? '';
                                $postgrad = $appRow['graduate_studies'] ?? '';
                                $photo = uri() . '/assets/img/user.png';
                                $email = $appRow['email_address'] ?? '';
                                $mobile = $appRow['mobile_number'] ?? '';
                                ?>
                                <tr class="text-uppercase row-employee">
                                    <td class="align-middle">
                                        <div class="image-container">
                                            <span
                                                class="d-flex justify-content-center align-middle employee-photo rounded-circle overflow-hidden">
                                                <img height="100%" src="<?= e($photo) ?>" alt="<?= e($employeeName) ?>">
                                            </span>
                                            <div class="sex-sign">
                                                <?php sex($sex) ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-left">
                                        <div><?= e($employeeName) ?></div>
                                        <div class="small"><?= e($birthdate) ?>
                                        </div>
                                    </td>
                                    <td class="align-middle text-left">
                                        <?php if ($postgrad): ?>
                                            <div>
                                                <div class="small">Graduate Studies</div>
                                                <div><?= e($postgrad) ?></div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($undergrad): ?>
                                            <div class="mt-2">
                                                <div class="small">Undergraduate Degree</div>
                                                <div><?= e($undergrad) ?></div>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="align-middle text-lowercase text-center">
                                        <div><?= e($email) ?></div>
                                        <div><?= e($mobile) ?></div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="small">
                                <th class="align-middle" width="5%">Photo</th>
                                <th class="align-middle" width="30%">Name / Date of Birth</th>
                                <th class="align-middle" width="45%">Education</th>
                                <th class="align-middle" width="20%">Contact Details</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        $(document).ready(function () {
            // Initialize DataTable
            const table = $('#diversity-breakdown-table').DataTable({
                responsive: true,
                pagingType: "simple",
                lengthMenu: [
                    [10, 25, 50, 75, 100, -1],
                    [10, 25, 50, 75, 100, "All"],
                ],
                paging: true,
                order: [],
                autoWidth: false,
                info: true,
            });

            // Dynamic column indexing for visible rows
            table.on('order.dt search.dt', function () {
                table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });

        const rawData = <?= json_encode($rows) ?>;
        const chartType = '<?= $config['chart_type'] ?>';

        // Convert data to chart formats
        let colors = generateColorPallete(rawData.length);
        const genderColors = ['#02a3fe', '#ec49a6']; // Male: Blue, Female: Pink

        if ('<?= $config['export_id'] ?>' === 'gender') {
            colors = rawData.map(item => {
                const name = (item.name || '').toLowerCase();
                if (name === 'male') return '#02a3fe';
                if (name === 'female') return '#ec49a6';
                return '#858796'; // default gray
            });
        }

        if (chartType === 'comparative-bar') {
            generateComparativeBarChart(rawData, genderColors, 'diversity-chart', false);
        } else if (chartType === 'pie') {
            const chartData = rawData.map(item => ({
                name: item.name || 'Not Specified',
                count: parseInt(item.total || item.count || 0)
            }));
            generatePieChart(chartData, colors, 'diversity-chart', false);
        } else if (chartType === 'doughnut') {
            const chartData = rawData.map(item => ({
                name: item.name || 'Not Specified',
                count: parseInt(item.total || item.count || 0)
            }));
            generateDoughnutChart(chartData, colors, 'diversity-chart', false);
        } else if (chartType === 'polarArea') {
            const chartData = rawData.map(item => ({
                name: item.name || 'Not Specified',
                count: parseInt(item.total || item.count || 0)
            }));
            generatePolarAreaChart(chartData, colors, 'diversity-chart', false);
        } else {
            // bar chart
            const chartData = rawData.map(item => ({
                name: item.name || 'Not Specified',
                count: parseInt(item.total || item.count || 0)
            }));
            generateBarChart(chartData, colors, 'diversity-chart', false);
        }
    });
</script>