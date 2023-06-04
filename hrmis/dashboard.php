<?php
// dts/dashboard.php
messageAlert($showPrompt, $message, $success);

contentTitle('Dashboard');
?>

<div class="row mt-4">
  <?php
  card('Active Employees', customUri('hrmis', 'Active Employees'), 'fa-user-check', 'primary', number_format(numRows(activeEmployees())));

  card('Retirable Employees', customUri('hrmis', 'Retirable Employees'), 'fa-user-clock', 'success', number_format(numRows(retirableEmployees())));

  card('Celebrant Employees', customUri('hrmis', 'Celebrant Employees'), 'fa-birthday-cake', 'warning');

  card('Archived Employees', customUri('hrmis', 'Archived Employees'), 'fa-user-lock', 'danger');
  ?>
</div><!-- .row -->

<script src="<?php echo uri(); ?>/assets/vendor/chart.js/Chart.min.js"></script>
<script src="<?php echo uri(); ?>/assets/vendor/chart.js/chartjs-plugin-datalabels.min.js"></script>
<script src="<?php echo uri(); ?>/assets/js/chart-custom.js"></script>

<div class="row">
  <div class="col-xl-3 col-lg-12 mb-4">
    <div class="card shadow">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary text-uppercase">Employees by Gender</h6>
      </div>
      <div class="card-body">
        <div class="chart-pie py-2">
          <canvas id="gender-pie-chart"></canvas>
          <script>
            generateDoughnutChart(<?php echo json_encode(fetchAllAssoc(employeeGender())); ?>, <?php echo json_encode(array('#02a3fe', '#ec49a6')); ?>, 'gender-pie-chart');
          </script>
        </div>
      </div>
    </div>
  </div><!-- .col-xl-3 -->

  <div class="col-xl-9 col-lg-12 mb-4">
    <div class="card shadow">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-uppercase">Employee Gender by Category</h6>
      </div>
      <div class="card-body">
        <div class="chart-bar h-auto">
          <canvas id="gender-comparative-bar-chart"></canvas>
          <script>
            generateComparativeBarChart(<?php echo json_encode(fetchAllAssoc(employeeGenderCategory())); ?>, <?php echo json_encode(array('#02a3fe', '#ec49a6')); ?>, 'gender-comparative-bar-chart');
          </script>
        </div>
      </div>
    </div>
  </div><!-- .col-xl-9 -->
</div><!-- .row -->

<div class="row">
  <div class="col-xl-3 col-lg-12 mb-4">
    <div class="card shadow">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary text-uppercase">Employees by Category</h6>
      </div>
      <div class="card-body">
        <div class="chart-pie py-2">
          <canvas id="category-doughnut-chart"></canvas>
          <script>
            <?php
            $employeeCategory = employeeCategory();
            ?>
            generatePieChart(<?php echo json_encode(fetchAllAssoc($employeeCategory)); ?>, generateColorPallete(<?php echo numRows($employeeCategory); ?>), 'category-doughnut-chart');
          </script>
        </div>
      </div>
    </div>
  </div><!-- .col-xl-3 -->

  <div class="col-xl-9 col-lg-12 mb-4">
    <div class="card shadow">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-uppercase">Employees by Position</h6>
      </div>
      <div class="card-body">
        <div class="chart-bar h-auto">
          <canvas id="position-bar-chart"></canvas>
          <script>
            <?php
            $employeePositions = employeePosition();
            ?>
            generateBarChart(<?php echo json_encode(fetchAllAssoc($employeePositions)); ?>, generateColorPallete(<?php echo numRows($employeePositions); ?>), 'position-bar-chart');
          </script>
        </div>
      </div>
    </div>
  </div><!-- .col-xl-9 -->
</div><!-- .row -->

<div class="row">
  <div class="col-xl-3 col-lg-12 mb-4">
    <div class="card shadow">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary text-uppercase">Employees by District</h6>
      </div>
      <div class="card-body">
        <div class="chart-pie py-2">
          <canvas id="district-polar-area-chart"></canvas>
          <script>
            <?php
            $districtEmployees = districtEmployee();
            ?>
            generatePolarAreaChart(<?php echo json_encode(fetchAllAssoc($districtEmployees)); ?>, generateColorPallete(<?php echo numRows($districtEmployees); ?>), 'district-polar-area-chart');
          </script>
        </div>
      </div>
    </div>
  </div><!-- .col-xl-3 -->

  <div class="col-xl-9 col-lg-12">
    <div class="card shadow">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-uppercase">Employees by Assignment</h6>
      </div>
      <div class="card-body">
        <div class="chart-bar h-auto">
          <canvas id="station-bar-chart"></canvas>
          <script>
            <?php
            $employeeStations = employeeStation();
            ?>
            generateBarChart(<?php echo json_encode(fetchAllAssoc($employeeStations)); ?>, generateColorPallete(<?php echo numRows($employeeStations); ?>), 'station-bar-chart');
          </script>
        </div>
      </div>
    </div>
  </div><!-- .col-xl-9 -->
</div><!-- .row -->