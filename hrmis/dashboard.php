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
</div>
<script src="<?php echo uri(); ?>/assets/vendor/chart.js/Chart.min.js"></script>
<script src="<?php echo uri(); ?>/assets/js/chart-custom.js"></script>
<div class="row">
  <div class="col-xl-9 col-md-12 mb-4">
    <div class="card shadow">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-uppercase">Employees by Assignment</h6>
      </div>
      <div class="card-body">
        <div class="chart-bar h-auto">
          <canvas id="bar-chart"></canvas>
          <script>
            <?php
            $employee_stations = employee_station();
            ?>
            generate_pie_chart(<?php echo json_encode(fetch_all_assoc($employee_stations)); ?>, generate_color_pallete(<?php echo num_rows($employee_stations); ?>), 'bar-chart');
          </script>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
    <div class="card shadow">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary text-uppercase">Employees by Gender</h6>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        <div class="chart-pie py-2">
          <canvas id="pie-chart"></canvas>
          <script>
            generate_pie_chart(<?php echo json_encode(fetch_all_assoc(employee_gender())); ?>, <?php echo json_encode(array('#02a3fe', '#ec49a6')); ?>);
          </script>
        </div>
        <div class="mt-4 text-center small">
          <span class="mx-3">
            <i class="fas fa-circle text-mars"></i> <a href="<?php echo custom_uri('hrmis', 'Male Employees'); ?>" title="Male Employees">Male</a>
          </span>
          <span class="mx-3">
            <i class="fas fa-circle text-venus"></i> <a href="<?php echo custom_uri('hrmis', 'Female Employees'); ?>" title="Female Employees">Female</a>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>