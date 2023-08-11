<?php // login/services.php 
?>

<div id="services-panel" class="col-xl-8 col-lg-8 col-md-6 col-sm-12">
  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-header">
      <h3 class="text-center my-2"><?php echo title(); ?> Online Services</h3>
    </div>

    <div class="card-body">
      <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
          <div class="card mb-4">
            <div class="card-header text-uppercase text-center font-weight-bold">
              Document Tracking System
            </div><!-- .card-header -->

            <div class="card-body">
              Track paper trail of documents created by schools, sections and offices within the schools division.
            </div><!-- .card-body -->
          </div><!-- .card -->

          <div class="card mb-4">
            <div class="card-header text-uppercase text-center font-weight-bold">
              Personnel Information System
            </div><!-- .card-header -->

            <div class="card-body">
              Monitor individual details of teaching, teaching-related and non-teaching employees of the schools division.
            </div><!-- .card-body -->
          </div><!-- .card -->

          <div class="card">
            <div class="card-header text-uppercase text-center font-weight-bold">
              Learning Resource Materials
            </div><!-- .card-header -->

            <div class="card-body">
              Quality assured educational and learning materials accessible to a dedicated learning resource <a href="https://sites.google.com/deped.gov.ph/sdodipologlrms/home" title="SDO Dipolog Learning Resource Portal">portal</a>.
            </div><!-- .card-body -->
          </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
          <?php require_once(root() . '/modules/calendar/page.php'); ?>
        </div>
      </div>
    </div>
  </div>
</div>