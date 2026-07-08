<?php
// modules/employees/demographics/page.php
if (!$isHrmis && !$isHrtdms && !$isDmis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

// Map the URL path to our configuration
$demographicsConfig = [
    'Workforce Diversity - Gender' => [
        'title' => 'Gender',
        'icon' => 'fa-venus-mars',
        'db_function' => 'demographicsGender',
        'headers' => ['Gender', 'Total'],
        'chart_type' => 'doughnut',
        'export_id' => 'gender',
    ],
    'Workforce Diversity - Category' => [
        'title' => 'Category',
        'icon' => 'fa-tags',
        'db_function' => 'demographicsCategory',
        'headers' => ['Category', 'Total'],
        'chart_type' => 'pie',
        'export_id' => 'category',
    ],
    'Workforce Diversity - Category by Gender' => [
        'title' => 'Category by Gender',
        'icon' => 'fa-user-tag',
        'db_function' => 'demographicsCategoryGender',
        'headers' => ['Category', 'Male', 'Female', 'Total'],
        'chart_type' => 'comparative-bar',
        'export_id' => 'category-gender',
    ],
    'Workforce Diversity - Education' => [
        'title' => 'Education',
        'icon' => 'fa-graduation-cap',
        'db_function' => 'demographicsEducation',
        'headers' => ['Education Level', 'Male', 'Female', 'Total'],
        'chart_type' => 'pie',
        'export_id' => 'education',
    ],
    'Workforce Diversity - Position' => [
        'title' => 'Position',
        'icon' => 'fa-user-tie',
        'db_function' => 'demographicsPosition',
        'headers' => ['Position', 'Male', 'Female', 'Total'],
        'chart_type' => 'bar',
        'export_id' => 'position',
    ],
    'Workforce Diversity - District' => [
        'title' => 'District',
        'icon' => 'fa-map-marked-alt',
        'db_function' => 'demographicsDistrict',
        'headers' => ['District', 'Male', 'Female', 'Total'],
        'chart_type' => 'pie',
        'export_id' => 'districts',
    ],
    'Workforce Diversity - Assignment' => [
        'title' => 'Assignment',
        'icon' => 'fa-school',
        'db_function' => 'demographicsSchool',
        'headers' => ['School / Station', 'Male', 'Female', 'Total'],
        'chart_type' => 'bar',
        'export_id' => 'schools',
    ],
    'Workforce Diversity - Generation' => [
        'title' => 'Generation',
        'icon' => 'fa-hourglass-half',
        'db_function' => 'demographicsGeneration',
        'headers' => ['Generation', 'Male', 'Female', 'Total'],
        'chart_type' => 'pie',
        'export_id' => 'generation',
    ],
    'Workforce Diversity - Religion' => [
        'title' => 'Religion',
        'icon' => 'fa-hands-helping',
        'db_function' => 'demographicsReligion',
        'headers' => ['Religion', 'Male', 'Female', 'Total'],
        'chart_type' => 'pie',
        'export_id' => 'religion',
    ],
    'Workforce Diversity - Ethnic Group' => [
        'title' => 'Ethnic Group',
        'icon' => 'fa-users',
        'db_function' => 'demographicsIndigenous',
        'headers' => ['Indigenous Group', 'Male', 'Female', 'Total'],
        'chart_type' => 'pie',
        'export_id' => 'indigenous',
    ],
    'Workforce Diversity - PWD' => [
        'title' => 'Persons with Disability',
        'icon' => 'fa-wheelchair',
        'db_function' => 'demographicsPwd',
        'headers' => ['Disability / PWD Status', 'Male', 'Female', 'Total'],
        'chart_type' => 'doughnut',
        'export_id' => 'pwd',
    ],
    'Workforce Diversity - Solo Parent' => [
        'title' => 'Solo Parent',
        'icon' => 'fa-user-friends',
        'db_function' => 'demographicsSoloParent',
        'headers' => ['Solo Parent Status', 'Male', 'Female', 'Total'],
        'chart_type' => 'doughnut',
        'export_id' => 'solo-parents',
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

$selectedGroup = isset($_GET['group']) ? sanitize($_GET['group']) : 'all';
$selectedSex = isset($_GET['sex']) ? sanitize($_GET['sex']) : 'all';
$selectedPosition = isset($_GET['position']) ? sanitize($_GET['position']) : 'all';
$selectedSchool = isset($_GET['school']) ? sanitize($_GET['school']) : 'all';
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Workforce Diversity</li>
            <li class="breadcrumb-item active"><?= e($config['title']) ?></li>
        </ol>
    </nav>
</div>

<div class="mb-4">
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

<script src="<?= uri() ?>/assets/vendor/chart.js/Chart.min.js"></script>
<script src="<?= uri() ?>/assets/vendor/chart.js/chartjs-plugin-datalabels.min.js"></script>
<script src="<?= uri() ?>/assets/js/chart-custom.js?v=1.3"></script>

<div class="row">
    <!-- Visual Chart Card -->
    <div class="col-xl-5 col-lg-12 mb-4">
        <div class="card shadow">
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
                    <canvas id="demographics-chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="col-xl-7 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between border-bottom">
                <h6 class="m-0 font-weight-bold text-uppercase text-dark">
                    <?= e($config['title']) ?> Summary
                </h6>
                <div class="dropdown no-arrow">
                    <?php dropdownEllipsis() ?>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <?php linkDropdownItem(customUri('export', 'demographics', $config['export_id']), 'Export', 'fa-file-excel') ?>
                    </div>
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
                                    <td class="align-middle text-left  text-dark"><?= e($name) ?></td>
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
        <div class="card shadow" id="demographics-breakdown">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between border-bottom">
                <h6 class="m-0 font-weight-bold text-dark text-uppercase">
                    <?= e($config['title']) ?> Breakdown
                </h6>
                <div class="d-inline-block">
                    <?php
                    // Generate export url dynamically in PHP based on active parameters
                    $exportUrl = customUri('export', 'demographics', 'list') . '&demo=' . encode($config['export_id']);
                    if ($selectedGroup !== 'all') {
                        $exportUrl .= '&group=' . encode($selectedGroup);
                    }
                    if ($selectedSex !== 'all') {
                        $exportUrl .= '&sex=' . encode($selectedSex);
                    }
                    if ($selectedPosition !== 'all') {
                        $exportUrl .= '&position=' . encode($selectedPosition);
                    }
                    if ($selectedSchool !== 'all') {
                        $exportUrl .= '&school=' . encode($selectedSchool);
                    }
                    ?>
                </div>
            </div>
            <div class="card-body">
                <?php
                $allEmployees = demographicsEmployeeList();
                $groupedEmployees = [];
                foreach ($rows as $r) {
                    $groupName = $r['name'] ?? 'Not Specified';
                    $groupedEmployees[$groupName] = [];
                }
                foreach ($allEmployees as $emp) {
                    $groupName = getEmployeeDemographicGroup($emp, $config['export_id']);
                    if (!isset($groupedEmployees[$groupName])) {
                        $groupedEmployees[$groupName] = [];
                    }
                    $groupedEmployees[$groupName][] = $emp;
                }

                // Gather unique values from full dataset grouped by category and district before filtering
                $positionsByCategory = [];
                $schoolsByDistrict = [];
                foreach ($allEmployees as $emp) {
                    $pos = $emp['position'];
                    $cat = $emp['category'] ?? 'Not Specified';
                    $sg = isset($emp['salary_grade']) ? (int) $emp['salary_grade'] : 0;
                    if (!empty($pos)) {
                        $positionsByCategory[$cat][$pos] = $sg;
                    }

                    $sch = $emp['school'];
                    $dist = $emp['district'] ?? 'Not Specified';
                    if (!empty($sch)) {
                        $schoolsByDistrict[$dist][$sch] = true;
                    }
                }

                ksort($positionsByCategory);
                foreach ($positionsByCategory as $cat => &$poss) {
                    uksort($poss, function ($a, $b) use ($poss) {
                        $sgA = $poss[$a];
                        $sgB = $poss[$b];
                        if ($sgA !== $sgB) {
                            return $sgB <=> $sgA; // Descending order of salary grade
                        }
                        return strcasecmp($a, $b); // Ascending alphabetical order
                    });
                    $poss = array_keys($poss);
                }
                unset($poss);

                ksort($schoolsByDistrict);
                foreach ($schoolsByDistrict as $dist => &$schs) {
                    ksort($schs);
                    $schs = array_keys($schs);
                }
                unset($schs);

                // Filter list in PHP
                $filteredEmployees = [];
                foreach ($allEmployees as $emp) {
                    $groupName = getEmployeeDemographicGroup($emp, $config['export_id']);
                    if ($selectedGroup !== 'all' && strcasecmp($groupName, $selectedGroup) !== 0) {
                        continue;
                    }
                    if ($selectedSex !== 'all' && strcasecmp($emp['sex'] ?? '', $selectedSex) !== 0) {
                        continue;
                    }
                    if ($selectedPosition !== 'all' && strcasecmp($emp['position'] ?? '', $selectedPosition) !== 0) {
                        continue;
                    }
                    if ($selectedSchool !== 'all' && strcasecmp($emp['school'] ?? '', $selectedSchool) !== 0) {
                        continue;
                    }
                    $filteredEmployees[] = $emp;
                }
                $allEmployees = $filteredEmployees;
                ?>

                <!-- Filter Panel Form -->
                <form method="GET" action="">
                    <input type="hidden" name="v" value="<?= e($_GET['v'] ?? '') ?>">
                    <?php
                    $mode = $config['title'];
                    $isDiversityGroup = in_array($mode, ['Position', 'Assignment', 'Category', 'Category by Gender', 'District']);
                    ?>
                    <div class="row">
                        <?php if (!$isDiversityGroup) { ?>
                            <div class="col-md-<?= $mode === 'Gender' ? 12 : 8 ?> mb-2">
                                <label for="filter-group" class="font-weight-bold text-gray-800 small mb-0"><?= $config['title'] ?></label>
                                <select id="filter-group" name="group" class="form-control">
                                    <option value="all" <?= setOptionSelected($selectedGroup, 'all') ?>>All</option>
                                    <?php foreach (array_keys($groupedEmployees) as $gName): ?>
                                        <option value="<?= e($gName) ?>" <?= setOptionSelected($selectedGroup, $gName) ?>>
                                            <?= e($gName) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php }
                        if ($mode !== 'Gender') : ?>
                            <div class="col-md-<?= $isDiversityGroup ? 12 : 4 ?> mb-2">
                                <label for="filter-sex" class="font-weight-bold text-gray-800 small mb-0">Gender</label>
                                <select id="filter-sex" name="sex" class="form-control">
                                    <option value="all" <?= setOptionSelected($selectedSex, 'all') ?>>All</option>
                                    <option value="Male" <?= setOptionSelected($selectedSex, 'Male') ?>>Male</option>
                                    <option value="Female" <?= setOptionSelected($selectedSex, 'Female') ?>>Female</option>
                                </select>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label for="filter-position"
                                class="font-weight-bold text-gray-800 small mb-0">Position</label>
                            <select id="filter-position" name="position" class="form-control">
                                <option value="all" <?= setOptionSelected($selectedPosition, 'all') ?>>All</option>
                                <?php foreach ($positionsByCategory as $catName => $posList): ?>
                                    <optgroup label="<?= e($catName) ?>">
                                        <?php foreach ($posList as $posOpt): ?>
                                            <option value="<?= e($posOpt) ?>" <?= setOptionSelected($selectedPosition, $posOpt) ?>>
                                                <?= e($posOpt) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label for="filter-school" class="font-weight-bold text-gray-800 small mb-0">Assignment</label>
                            <select id="filter-school" name="school" class="form-control">
                                <option value="all" <?= setOptionSelected($selectedSchool, 'all') ?>>All
                                </option>
                                <?php foreach ($schoolsByDistrict as $distName => $schList): ?>
                                    <optgroup label="<?= e($distName) ?>">
                                        <?php foreach ($schList as $schOpt): ?>
                                            <option value="<?= e($schOpt) ?>" <?= setOptionSelected($selectedSchool, $schOpt) ?>>
                                                <?= e($schOpt) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endforeach; ?>
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
                    <table class="table table-hover mb-0 text-center" id="data-table" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th class="align-middle" width="5%">Photo</th>
                                <th class="align-middle" width="40%">Name / Position</th>
                                <th class="align-middle" width="55%">Station / District</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($allEmployees as $empRow):
                                $employeeName = toName($empRow['last_name'], $empRow['first_name'], $empRow['middle_name'], $empRow['name_extension']);
                                $sex = $empRow['sex'] ?? '';
                                $pos = $empRow['position'] ?? '';
                                $school = $empRow['school'] ?? '';
                                $district = $empRow['district'] ?? '';
                                $photo = file_exists(root() . '/' . $empRow['profile_picture']) ? uri() . '/' . $empRow['profile_picture'] : uri() . '/assets/img/user.png';
                                ?>
                                <tr class="text-uppercase row-employee">
                                    <td class="align-middle">
                                        <div class="image-container">
                                            <span
                                                class="d-flex justify-content-center align-middle employee-photo rounded-circle overflow-hidden">
                                                <img height="100%" src="<?= e($photo) ?>" alt="<?= e($employeeName) ?>">
                                            </span>
                                            <div class="sex-sign"><?php sex($empRow['sex']) ?></div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-left text-dark">
                                        <div><?= linkItem(customUri('hrmis', 'Employee Information', $empRow['id']), $employeeName); ?></div>
                                        <div class="small"><?= e($pos) ?></div>
                                    </td>
                                    <td class="align-middle text-left">
                                        <div><?= e($school) ?></div>
                                        <div class="small"><?= e($district) ?></div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="small">
                            <tr>
                                <th class="align-middle" width="5%">Photo</th>
                                <th class="align-middle" width="40%">Name / Position</th>
                                <th class="align-middle" width="55%">Station / District</th>
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
            const breakdownTable = $('#data-table-next');
            if (breakdownTable.length) {
                const table = breakdownTable.DataTable({
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

                table.on('order.dt search.dt', function () {
                    table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                        cell.innerHTML = i + 1;
                    });
                }).draw();
            }
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