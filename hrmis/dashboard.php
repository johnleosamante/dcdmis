<?php
// dts/dashboard.php
content_title('Dashboard');
?>

<div class="row mt-4">
  <?php
  card('Active Employees', custom_uri('hrmis', 'Active Employees'), 'fa-user-check', 'primary', number_format(num_rows(active_employees())));

  card('Retirable Employees', custom_uri('hrmis', 'Retirable Employees'), 'fa-user-clock', 'success', number_format(num_rows(retirable_employees())));

  card('Celebrant Employees', custom_uri('hrmis', 'Celebrant Employees'), 'fa-birthday-cake', 'warning');

  card('Archived Employees', custom_uri('hrmis', 'Archived Employees'), 'fa-user-lock', 'danger');
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
            generate_doughnut_chart(<?php echo json_encode(fetch_all_assoc(employee_gender())); ?>, <?php echo json_encode(array('#02a3fe', '#ec49a6')); ?>, 'gender-pie-chart');
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
            generate_comparative_bar_chart(<?php echo json_encode(fetch_all_assoc(employee_gender_category())); ?>, <?php echo json_encode(array('#02a3fe', '#ec49a6')); ?>, 'gender-comparative-bar-chart');
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
            $employee_category = employee_category();
            ?>
            generate_pie_chart(<?php echo json_encode(fetch_all_assoc($employee_category)); ?>, generate_color_pallete(<?php echo num_rows($employee_category); ?>), 'category-doughnut-chart');
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
            $employee_positions = employee_position();
            ?>
            generate_bar_chart(<?php echo json_encode(fetch_all_assoc($employee_positions)); ?>, generate_color_pallete(<?php echo num_rows($employee_positions); ?>), 'position-bar-chart');
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
            $district_employees = district_employee();
            ?>
            generate_polar_area_chart(<?php echo json_encode(fetch_all_assoc($district_employees)); ?>, generate_color_pallete(<?php echo num_rows($district_employees); ?>), 'district-polar-area-chart');
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
            $employee_stations = employee_station();
            ?>
            generate_bar_chart(<?php echo json_encode(fetch_all_assoc($employee_stations)); ?>, generate_color_pallete(<?php echo num_rows($employee_stations); ?>), 'station-bar-chart');
          </script>
        </div>
      </div>
    </div>
  </div><!-- .col-xl-9 -->
</div><!-- .row -->