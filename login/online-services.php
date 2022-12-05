<?php
# login/online-services.php
?>

<div class="card shadow-lg border-0 rounded-lg my-5">
  <div class="card-header">
    <h3 class="text-center fw-light my-2"><?php echo GetDepartmentAlias() . ' ' . GetDivision() . ' Online Services'; ?></h3>
  </div><!-- .card-header -->

  <div class="card-body pb-0">
    <div class="row">
      <div class="col-xl-6">
        <div class="card mb-4">
          <div class="card-header text-uppercase">
            <i class="fas fa-file-alt text-danger"></i> Document Tracking System
          </div><!-- .card-header -->

          <div class="card-body">
            Online transaction for document processing.
          </div><!-- .card-body -->
        </div><!-- .card -->

        <div class="card mb-4">
          <div class="card-header text-uppercase">
            <i class="fas fa-user text-danger"></i> Personnel Tracking System
          </div><!-- .card-header -->

          <div class="card-body">
            Online personnel information processing. Click <a href="<?php echo GetSiteURL(); ?>/register">here</a> to register.
          </div><!-- .card-body -->
        </div><!-- .card -->

        <div class="card mb-4">
          <div class="card-header text-uppercase">
            <i class="fas fa-book-open text-danger"></i> Project IDEALLS
          </div><!-- .card-header -->

          <div class="card-body">
            Online educational and learning resource. Click <a href="<?php echo GetSiteURL(); ?>/idealls">here</a> to browse.
          </div><!-- .card-body -->
        </div><!-- .card -->
      </div><!-- .col-xl-6" -->

      <div class="col-xl-6">
        <div class="card mb-4">
          <div class="card-header text-uppercase">
            <i class="fas fa-calendar-alt text-danger"></i> Activities for <?php echo date('F Y'); ?>
          </div><!-- .card-header -->

          <div id="calendar" class="card-body">
            <?php
            $calendar = DBQuery("SELECT * FROM tbl_calendar_of_activity WHERE for_the_month='" . date('F Y') . "';");

            if (DBNumRows($calendar) === 0) { ?>
              <div class="text-center">No scheduled activities.</div>
            <?php } else { ?>
              <ul class="fa-ul mb-0 ml-4">
                <?php while ($rowcal = DBFetchArray($calendar)) { ?>
                  <li><span class="fa-li"><i class="fas fa-check"></i></span><?php echo $rowcal['Activity']; ?></li>
                <?php } ?>
              </ul>
            <?php } ?>
          </div><!-- .card-body -->
        </div><!-- .card -->
      </div><!-- .col-xl-6 -->
    </div><!-- .row -->
  </div><!-- .card-body -->
</div><!-- .card -->