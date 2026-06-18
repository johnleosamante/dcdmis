<?php
// modules/employees/demographics/page.php
if (!$isHrmis && !$isHrtdms && !$isDmis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

// Map the URL path to our configuration
$demographicsConfig = [
    'Demographics - Gender' => [
        'title' => 'Employee Gender',
        'icon' => 'fa-venus-mars',
        'db_function' => 'demographicsGender',
        'headers' => ['Gender', 'Total'],
        'chart_type' => 'pie',
        'export_id' => 'gender',
    ],
    'Demographics - Category' => [
        'title' => 'Employees by Category',
        'icon' => 'fa-tags',
        'db_function' => 'demographicsCategory',
        'headers' => ['Category', 'Total'],
        'chart_type' => 'doughnut',
        'export_id' => 'category',
    ],
    'Demographics - Category by Gender' => [
        'title' => 'Employee Categories by Gender',
        'icon' => 'fa-user-tag',
        'db_function' => 'demographicsCategoryGender',
        'headers' => ['Category', 'Male', 'Female', 'Total'],
        'chart_type' => 'comparative-bar',
        'export_id' => 'category-gender',
    ],
    'Demographics - Position' => [
        'title' => 'Employees by Position',
        'icon' => 'fa-user-tie',
        'db_function' => 'demographicsPosition',
        'headers' => ['Position', 'Male', 'Female', 'Total'],
        'chart_type' => 'bar',
        'export_id' => 'position',
    ],
    'Demographics - Generation' => [
        'title' => 'Employee Generations',
        'icon' => 'fa-hourglass-half',
        'db_function' => 'demographicsGeneration',
        'headers' => ['Generation', 'Male', 'Female', 'Total'],
        'chart_type' => 'bar',
        'export_id' => 'generation',
    ],
    'Demographics - Education' => [
        'title' => 'Highest Educational Attainment',
        'icon' => 'fa-graduation-cap',
        'db_function' => 'demographicsEducation',
        'headers' => ['Education Level', 'Male', 'Female', 'Total'],
        'chart_type' => 'bar',
        'export_id' => 'education',
    ],
    'Demographics - Religion' => [
        'title' => 'Employees by Religion',
        'icon' => 'fa-hands-helping',
        'db_function' => 'demographicsReligion',
        'headers' => ['Religion', 'Male', 'Female', 'Total'],
        'chart_type' => 'bar',
        'export_id' => 'religion',
    ],
    'Demographics - Indigenous People' => [
        'title' => 'Indigenous People Demographics',
        'icon' => 'fa-users',
        'db_function' => 'demographicsIndigenous',
        'headers' => ['Indigenous Group', 'Male', 'Female', 'Total'],
        'chart_type' => 'doughnut',
        'export_id' => 'indigenous',
    ],
    'Demographics - PWD' => [
        'title' => 'Persons with Disability (PWD)',
        'icon' => 'fa-wheelchair',
        'db_function' => 'demographicsPwd',
        'headers' => ['Disability / PWD Status', 'Male', 'Female', 'Total'],
        'chart_type' => 'doughnut',
        'export_id' => 'pwd',
    ],
    'Demographics - Solo Parents' => [
        'title' => 'Solo Parent Demographics',
        'icon' => 'fa-user-friends',
        'db_function' => 'demographicsSoloParent',
        'headers' => ['Solo Parent Status', 'Male', 'Female', 'Total'],
        'chart_type' => 'pie',
        'export_id' => 'solo-parents',
    ],
    'Demographics - Districts' => [
        'title' => 'Employees by District',
        'icon' => 'fa-map-marked-alt',
        'db_function' => 'demographicsDistrict',
        'headers' => ['District', 'Male', 'Female', 'Total'],
        'chart_type' => 'polarArea',
        'export_id' => 'districts',
    ],
    'Demographics - School Assignments' => [
        'title' => 'Employees by School Assignment',
        'icon' => 'fa-school',
        'db_function' => 'demographicsSchool',
        'headers' => ['School/Station', 'Male', 'Female', 'Total'],
        'chart_type' => 'bar',
        'export_id' => 'schools',
    ],
];

if (!isset($demographicsConfig[$url])) {
    require_once(root() . '/modules/error/404.php');
    return;
}

$config = $demographicsConfig[$url];
$func = $config['db_function'];
$rows = $func(); // Fetch demographics data

if (!is_array($rows)) {
    $rows = [];
}
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Demographics</li>
            <li class="breadcrumb-item active"><?= e($config['title']) ?></li>
        </ol>
    </nav>
</div>

<!-- Sub-navigation links bar -->
<div class="card shadow mb-4 border-left-primary">
    <div class="card-body p-2 bg-light">
        <div class="d-flex flex-wrap align-items-center justify-content-start" style="gap: 6px;">
            <?php foreach ($demographicsConfig as $viewName => $info): ?>
                <a href="<?= customUri('hrmis', $viewName) ?>"
                    class="btn btn-sm <?= $url === $viewName ? 'btn-primary' : 'btn-light border text-secondary' ?> d-flex align-items-center"
                    style="gap: 5px; font-weight: 500; border-radius: 20px; padding: 6px 14px; transition: all 0.2s;">
                    <i class="fas <?= $info['icon'] ?>"></i>
                    <span><?= e(str_replace(['Demographics', 'Employee ', 'Employees by ', 'Demographics'], '', $info['title'])) ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script src="<?= uri() ?>/assets/vendor/chart.js/Chart.min.js"></script>
<script src="<?= uri() ?>/assets/vendor/chart.js/chartjs-plugin-datalabels.min.js"></script>
<script src="<?= uri() ?>/assets/js/chart-custom.js?v=1.3"></script>

<div class="row">
    <!-- Visual Chart Card -->
    <div class="col-xl-5 col-lg-12 mb-4">
        <div class="card shadow h-100">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom">
                <h6 class="m-0 font-weight-bold text-uppercase">
                    <?= e($config['title']) ?> Chart
                </h6>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center bg-light">
                <div class="chart-container w-100" style="position: relative; min-height: 320px;">
                    <canvas id="demographics-chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="col-xl-7 col-lg-12 mb-4">
        <div class="card shadow h-100">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom">
                <h6 class="m-0 font-weight-bold text-uppercase">
                    <?= e($config['title']) ?> Breakdown
                </h6>
                <div class="d-inline-block">
                    <?php linkButtonSplit(customUri('export', 'demographics', $config['export_id']), 'Export', 'fa-file-excel', 'Export to Excel', 'success') ?>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive font-weight-normal">
                    <table class="table table-hover mb-0 text-center table-bordered" id="data-table" width="100%"
                        cellspacing="0">
                        <thead class="thead-light">
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
                            $hasGenderBreakdown = ($config['export_id'] !== 'category' && $config['export_id'] !== 'gender');

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
                                    <td class="align-middle text-left font-weight-bold text-dark"><?= e($name) ?></td>
                                    <?php if ($hasGenderBreakdown): ?>
                                        <td class="align-middle text-info"><?= number_format($male) ?></td>
                                        <td class="align-middle text-danger"><?= number_format($female) ?></td>
                                    <?php endif; ?>
                                    <td class="align-middle text-primary font-weight-bold"><?= number_format($total) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-light font-weight-bold text-dark text-uppercase">
                                <td colspan="2" class="text-right align-middle">Grand Total</td>
                                <?php if ($hasGenderBreakdown): ?>
                                    <td class="align-middle text-info"><?= number_format($totalMale) ?></td>
                                    <td class="align-middle text-danger"><?= number_format($totalFemale) ?></td>
                                <?php endif; ?>
                                <td class="align-middle text-primary font-weight-bold"><?= number_format($grandTotal) ?>
                                </td>
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
        const rawData = <?= json_encode($rows) ?>;
        const chartType = '<?= $config['chart_type'] ?>';

        // Convert data to chart formats
        const colors = generateColorPallete(rawData.length);
        const genderColors = ['#02a3fe', '#ec49a6']; // Male: Blue, Female: Pink

        if (chartType === 'comparative-bar') {
            generateComparativeBarChart(rawData, genderColors, 'demographics-chart', false);
        } else if (chartType === 'pie') {
            const chartData = rawData.map(item => ({
                name: item.name || 'Not Specified',
                count: parseInt(item.total || item.count || 0)
            }));
            generatePieChart(chartData, colors, 'demographics-chart', false);
        } else if (chartType === 'doughnut') {
            const chartData = rawData.map(item => ({
                name: item.name || 'Not Specified',
                count: parseInt(item.total || item.count || 0)
            }));
            generateDoughnutChart(chartData, colors, 'demographics-chart', false);
        } else if (chartType === 'polarArea') {
            const chartData = rawData.map(item => ({
                name: item.name || 'Not Specified',
                count: parseInt(item.total || item.count || 0)
            }));
            generatePolarAreaChart(chartData, colors, 'demographics-chart', false);
        } else {
            // bar chart
            const chartData = rawData.map(item => ({
                name: item.name || 'Not Specified',
                count: parseInt(item.total || item.count || 0)
            }));
            generateBarChart(chartData, colors, 'demographics-chart', false);
        }
    });
</script>