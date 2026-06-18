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
                <h6 class="m-0 font-weight-bold text-primary text-uppercase">Employees by Gender</h6>
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
                        generateDoughnutChart(<?= json_encode(employeeGender()) ?>, <?= json_encode(array('#02a3fe', '#ec49a6')) ?>, 'gender-pie-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-9 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary text-uppercase">Employee Categories By Gender</h6>
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
                        generateComparativeBarChart(<?= json_encode(employeeGenderCategory()) ?>, <?= json_encode(array('#02a3fe', '#ec49a6')) ?>, 'gender-comparative-bar-chart');
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
                <h6 class="m-0 font-weight-bold text-primary text-uppercase">Employees by Category</h6>
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
                        <?php $employeeCategory = employeeCategory() ?>
                        generatePieChart(<?= json_encode($employeeCategory) ?>, generateColorPallete(<?= count($employeeCategory) ?>), 'category-doughnut-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-9 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary text-uppercase">Employees by Position</h6>
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
                        <?php $employeePositions = employeePosition() ?>
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
                <h6 class="m-0 font-weight-bold text-primary text-uppercase">Employees by District</h6>
                <div class="dropdown no-arrow">
                    <?php dropdownEllipsis() ?>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <?php linkDropdownItem(customUri('hrmis', 'Demographics - Districts'), 'View', 'fa-eye');
                        linkDropdownItem(customUri('export', 'demographics', 'districts'), 'Export', 'fa-file-excel') ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-pie py-2">
                    <canvas id="district-polar-area-chart"></canvas>
                    <script>
                        <?php $districtEmployees = districtEmployee() ?>
                        generatePolarAreaChart(<?= json_encode($districtEmployees) ?>, generateColorPallete(<?= count($districtEmployees) ?>), 'district-polar-area-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-9 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary text-uppercase">Employees by Assignment</h6>
                <div class="dropdown no-arrow">
                    <?php dropdownEllipsis() ?>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <?php linkDropdownItem(customUri('hrmis', 'Demographics - School Assignments'), 'View', 'fa-eye');
                        linkDropdownItem(customUri('export', 'demographics', 'schools'), 'Export', 'fa-file-excel') ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-bar h-auto">
                    <canvas id="station-bar-chart"></canvas>
                    <script>
                        <?php $employeeStations = employeeStation() ?>
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
                <h6 class="m-0 font-weight-bold text-primary text-uppercase">Indigenous People</h6>
                <div class="dropdown no-arrow">
                    <?php dropdownEllipsis() ?>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <?php linkDropdownItem(customUri('hrmis', 'Demographics - Indigenous People'), 'View', 'fa-eye');
                        linkDropdownItem(customUri('export', 'demographics', 'indigenous'), 'Export', 'fa-file-excel') ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-pie py-2">
                    <canvas id="ip-polar-area-chart"></canvas>
                    <script>
                        <?php $indigenousEmployees = indigenousEmployeeCount() ?>
                        generateDoughnutChart(<?= json_encode($indigenousEmployees) ?>, generateColorPallete(<?= count($indigenousEmployees) ?>), 'ip-polar-area-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary text-uppercase">Persons With Disability</h6>
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
                        <?php $pwdEmployees = pwdEmployeeCount() ?>
                        generateDoughnutChart(<?= json_encode($pwdEmployees) ?>, generateColorPallete(<?= count($pwdEmployees) ?>), 'pwd-polar-area-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-12">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary text-uppercase">Solo Parents</h6>
                <div class="dropdown no-arrow">
                    <?php dropdownEllipsis() ?>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                        <?php linkDropdownItem(customUri('hrmis', 'Demographics - Solo Parents'), 'View', 'fa-eye');
                        linkDropdownItem(customUri('export', 'demographics', 'solo-parents'), 'Export', 'fa-file-excel') ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-pie py-2">
                    <canvas id="solo-parent-polar-area-chart"></canvas>
                    <script>
                        <?php $soloParentEmployees = soloParentEmployeeCount() ?>
                        generateDoughnutChart(<?= json_encode($soloParentEmployees) ?>, generateColorPallete(<?= count($soloParentEmployees) ?>), 'solo-parent-polar-area-chart');
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>