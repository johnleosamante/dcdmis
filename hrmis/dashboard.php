<?php
// dts/dashboard.php
messageAlert($showAlert, $message, $success);
contentTitleWithModal('Dashboard', uri() . '/modules/employees/save-employee-dialog.php', 'Add Employee', 'fa-plus');
?>

<div class="row mt-4">
    <?php
    card('Active Employees', customUri('hrmis', 'Active Employees'), 'fa-user-check', 'primary', $countActive);
    card('Retirable Employees', customUri('hrmis', 'Retirable Employees'), 'fa-user-clock', 'success', $countRetirable);
    card('Celebrant Employees', customUri('hrmis', 'Celebrant Employees'), 'fa-birthday-cake', 'info');
    card('Archived Employees', customUri('hrmis', 'Archived Employees'), 'fa-archive', 'warning');
    card('Districts', customUri('hrmis', 'Districts'), 'fa-map-marked-alt', 'danger', $districtCount);
    card('Schools', customUri('hrmis', 'Schools'), 'fa-school', 'secondary', $schoolCount);
    card('Sections', customUri('hrmis', 'Sections'), 'fa-map-signs', 'primary', $sectionCount);
    ?>
</div>

<script src="<?= uri() ?>/assets/vendor/chart.js/Chart.min.js"></script>
<script src="<?= uri() ?>/assets/vendor/chart.js/chartjs-plugin-datalabels.min.js"></script>
<script src="<?= uri() ?>/assets/js/chart-custom.js?v=1.3"></script>

<div class="row">
    <div class="col-xl-3 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark text-uppercase">Gender</h6>
                <div class="dropdown no-arrow">
                    <?php dropdownEllipsis() ?>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <?php linkDropdownItem(customUri('hrmis', 'Demographics - Gender'), 'View', 'fa-eye');
                        linkDropdownItem(customUri('export', 'demographics', 'gender'), 'Export', 'fa-file-excel') ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-pie py-2">
                    <canvas id="gender-pie-chart"></canvas>
                    <script>
                        <?php
                        $genderData = employeeGender();
                        foreach ($genderData as &$item) {
                            $item['link'] = customUri('hrmis', 'Demographics - Gender') . '&group=' . urlencode($item['name'] ?? '') . '&sex=' . urlencode($item['name'] ?? '') . '#demographics-breakdown';
                        }
                        unset($item);
                        ?>
                        generateDoughnutChart(<?= json_encode($genderData) ?>, <?= json_encode(array('#02a3fe', '#ec49a6')) ?>, 'gender-pie-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark text-uppercase">Category</h6>
                <div class="dropdown no-arrow">
                    <?php dropdownEllipsis() ?>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <?php linkDropdownItem(customUri('hrmis', 'Demographics - Category'), 'View', 'fa-eye');
                        linkDropdownItem(customUri('export', 'demographics', 'category'), 'Export', 'fa-file-excel') ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-pie py-2">
                    <canvas id="category-doughnut-chart"></canvas>
                    <script>
                        <?php
                        $employeeCategory = employeeCategory();
                        foreach ($employeeCategory as &$item) {
                            $item['link'] = customUri('hrmis', 'Demographics - Category') . '&group=' . urlencode($item['name'] ?? '') . '#demographics-breakdown';
                        }
                        unset($item);
                        ?>
                        generateDoughnutChart(<?= json_encode($employeeCategory) ?>, generateColorPallete(<?= count($employeeCategory) ?>), 'category-doughnut-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark text-uppercase">Category by Gender</h6>
                <div class="dropdown no-arrow">
                    <?php dropdownEllipsis() ?>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <?php linkDropdownItem(customUri('hrmis', 'Demographics - Category by Gender'), 'View', 'fa-eye');
                        linkDropdownItem(customUri('export', 'demographics', 'category-gender'), 'Export', 'fa-file-excel') ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-bar h-auto">
                    <canvas id="gender-comparative-bar-chart"></canvas>
                    <script>
                        <?php
                        $genderCategoryData = employeeGenderCategory();
                        foreach ($genderCategoryData as &$item) {
                            $item['linkMale'] = customUri('hrmis', 'Demographics - Category by Gender') . '&group=' . urlencode($item['name'] ?? '') . '&sex=Male#demographics-breakdown';
                            $item['linkFemale'] = customUri('hrmis', 'Demographics - Category by Gender') . '&group=' . urlencode($item['name'] ?? '') . '&sex=Female#demographics-breakdown';
                        }
                        unset($item);
                        ?>
                        generateComparativeBarChart(<?= json_encode($genderCategoryData) ?>, <?= json_encode(array('#02a3fe', '#ec49a6')) ?>, 'gender-comparative-bar-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-uppercase">Education</h6>
                <div class="dropdown no-arrow">
                    <?php dropdownEllipsis() ?>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <?php linkDropdownItem(customUri('hrmis', 'Demographics - Education'), 'View', 'fa-eye');
                        linkDropdownItem(customUri('export', 'demographics', 'education'), 'Export', 'fa-file-excel') ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-bar h-auto">
                    <canvas id="education-bar-chart"></canvas>
                    <script>
                        <?php
                        $educationEmployees = demographicsEducation();
                        foreach ($educationEmployees as &$item) {
                            $item['link'] = customUri('hrmis', 'Demographics - Education') . '&group=' . urlencode($item['name'] ?? '') . '#demographics-breakdown';
                        }
                        unset($item);
                        ?>
                        generatePieChart(<?= json_encode($educationEmployees) ?>, generateColorPallete(<?= count($educationEmployees) ?>), 'education-bar-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-9 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark text-uppercase">Position</h6>
                <div class="dropdown no-arrow">
                    <?php dropdownEllipsis() ?>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <?php linkDropdownItem(customUri('hrmis', 'Demographics - Position'), 'View', 'fa-eye');
                        linkDropdownItem(customUri('export', 'demographics', 'position'), 'Export', 'fa-file-excel') ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-bar h-auto">
                    <canvas id="position-bar-chart"></canvas>
                    <script>
                        <?php
                        $employeePositions = employeePosition();
                        foreach ($employeePositions as &$item) {
                            $item['link'] = customUri('hrmis', 'Demographics - Position') . '&group=' . urlencode($item['name'] ?? '') . '&position=' . urlencode($item['name'] ?? '') . '#demographics-breakdown';
                        }
                        unset($item);
                        ?>
                        generateBarChart(<?= json_encode($employeePositions) ?>, generateColorPallete(<?= count($employeePositions) ?>), 'position-bar-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark text-uppercase">District</h6>
                <div class="dropdown no-arrow">
                    <?php dropdownEllipsis() ?>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <?php linkDropdownItem(customUri('hrmis', 'Demographics - District'), 'View', 'fa-eye');
                        linkDropdownItem(customUri('export', 'demographics', 'districts'), 'Export', 'fa-file-excel') ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-pie py-2">
                    <canvas id="district-polar-area-chart"></canvas>
                    <script>
                        <?php
                        $districtEmployees = districtEmployee();
                        foreach ($districtEmployees as &$item) {
                            $item['link'] = customUri('hrmis', 'Demographics - District') . '&group=' . urlencode($item['name'] ?? '') . '#demographics-breakdown';
                        }
                        unset($item);
                        ?>
                        generatePolarAreaChart(<?= json_encode($districtEmployees) ?>, generateColorPallete(<?= count($districtEmployees) ?>), 'district-polar-area-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-9 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark text-uppercase">Assignment</h6>
                <div class="dropdown no-arrow">
                    <?php dropdownEllipsis() ?>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <?php linkDropdownItem(customUri('hrmis', 'Demographics - Assignment'), 'View', 'fa-eye');
                        linkDropdownItem(customUri('export', 'demographics', 'schools'), 'Export', 'fa-file-excel') ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-bar h-auto">
                    <canvas id="station-bar-chart"></canvas>
                    <script>
                        <?php
                        $employeeStations = employeeStation();
                        foreach ($employeeStations as &$item) {
                            $item['link'] = customUri('hrmis', 'Demographics - Assignment') . '&group=' . urlencode($item['name'] ?? '') . '&school=' . urlencode($item['name'] ?? '') . '#demographics-breakdown';
                        }
                        unset($item);
                        ?>
                        generateBarChart(<?= json_encode($employeeStations) ?>, generateColorPallete(<?= count($employeeStations) ?>), 'station-bar-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark text-uppercase">Generation</h6>
                <div class="dropdown no-arrow">
                    <?php dropdownEllipsis() ?>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <?php linkDropdownItem(customUri('hrmis', 'Demographics - Generation'), 'View', 'fa-eye');
                        linkDropdownItem(customUri('export', 'demographics', 'generation'), 'Export', 'fa-file-excel') ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-bar h-auto">
                    <canvas id="generation-bar-chart"></canvas>
                    <script>
                        <?php
                        $generationEmployees = demographicsGeneration();
                        foreach ($generationEmployees as &$item) {
                            $item['link'] = customUri('hrmis', 'Demographics - Generation') . '&group=' . urlencode($item['name'] ?? '') . '#demographics-breakdown';
                        }
                        unset($item);
                        ?>
                        generateBarChart(<?= json_encode($generationEmployees) ?>, generateColorPallete(<?= count($generationEmployees) ?>), 'generation-bar-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark text-uppercase">Religion</h6>
                <div class="dropdown no-arrow">
                    <?php dropdownEllipsis() ?>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <?php linkDropdownItem(customUri('hrmis', 'Demographics - Religion'), 'View', 'fa-eye');
                        linkDropdownItem(customUri('export', 'demographics', 'religion'), 'Export', 'fa-file-excel') ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-bar h-auto">
                    <canvas id="religion-bar-chart"></canvas>
                    <script>
                        <?php
                        $religionEmployees = demographicsReligion();
                        foreach ($religionEmployees as &$item) {
                            $item['link'] = customUri('hrmis', 'Demographics - Religion') . '&group=' . urlencode($item['name'] ?? '') . '#demographics-breakdown';
                        }
                        unset($item);
                        ?>
                        generateDoughnutChart(<?= json_encode($religionEmployees) ?>, generateColorPallete(<?= count($religionEmployees) ?>), 'religion-bar-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark text-uppercase">Ethnic Group</h6>
                <div class="dropdown no-arrow">
                    <?php dropdownEllipsis() ?>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <?php linkDropdownItem(customUri('hrmis', 'Demographics - Ethnic Group'), 'View', 'fa-eye');
                        linkDropdownItem(customUri('export', 'demographics', 'indigenous'), 'Export', 'fa-file-excel') ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-pie py-2">
                    <canvas id="ip-polar-area-chart"></canvas>
                    <script>
                        <?php
                        $indigenousEmployees = indigenousEmployeeCount();
                        foreach ($indigenousEmployees as &$item) {
                            $groupName = ($item['name'] === 'No') ? 'Non-Indigenous' : ($item['name'] ?? '');
                            $item['link'] = customUri('hrmis', 'Demographics - Ethnic Group') . '&group=' . urlencode($groupName) . '#demographics-breakdown';
                        }
                        unset($item);
                        ?>
                        generateDoughnutChart(<?= json_encode($indigenousEmployees) ?>, generateColorPallete(<?= count($indigenousEmployees) ?>), 'ip-polar-area-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark text-uppercase">Persons with Disability</h6>
                <div class="dropdown no-arrow">
                    <?php dropdownEllipsis() ?>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <?php linkDropdownItem(customUri('hrmis', 'Demographics - PWD'), 'View', 'fa-eye');
                        linkDropdownItem(customUri('export', 'demographics', 'pwd'), 'Export', 'fa-file-excel') ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-pie py-2">
                    <canvas id="pwd-polar-area-chart"></canvas>
                    <script>
                        <?php
                        $pwdEmployees = pwdEmployeeCount();
                        foreach ($pwdEmployees as &$item) {
                            $groupName = ($item['name'] === 'No') ? 'Non-PWD' : ($item['name'] ?? '');
                            $item['link'] = customUri('hrmis', 'Demographics - PWD') . '&group=' . urlencode($groupName) . '#demographics-breakdown';
                        }
                        unset($item);
                        ?>
                        generateDoughnutChart(<?= json_encode($pwdEmployees) ?>, generateColorPallete(<?= count($pwdEmployees) ?>), 'pwd-polar-area-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark text-uppercase">Solo Parent</h6>
                <div class="dropdown no-arrow">
                    <?php dropdownEllipsis() ?>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <?php linkDropdownItem(customUri('hrmis', 'Demographics - Solo Parent'), 'View', 'fa-eye');
                        linkDropdownItem(customUri('export', 'demographics', 'solo-parents'), 'Export', 'fa-file-excel') ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-pie py-2">
                    <canvas id="solo-parent-polar-area-chart"></canvas>
                    <script>
                        <?php
                        $soloParentEmployees = soloParentEmployeeCount();
                        foreach ($soloParentEmployees as &$item) {
                            $groupName = ($item['name'] === 'Yes') ? 'Solo Parent' : (($item['name'] === 'No') ? 'Not Solo Parent' : ($item['name'] ?? ''));
                            $item['link'] = customUri('hrmis', 'Demographics - Solo Parent') . '&group=' . urlencode($groupName) . '#demographics-breakdown';
                        }
                        unset($item);
                        ?>
                        generateDoughnutChart(<?= json_encode($soloParentEmployees) ?>, generateColorPallete(<?= count($soloParentEmployees) ?>), 'solo-parent-polar-area-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>