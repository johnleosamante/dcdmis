<?php
# about/privacy/update/index.php
$page = 'Data Privacy Policy';

include_once('../../_includes_/function.php');
include_once('../../_includes_/layout/header.php');
include_once('../../_includes_/layout/components.php');
?>

<body class="background-cover">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content" class="container">
      <div class="card border-0 shadow-lg my-5">
        <div class="card-header">
          <?php SiteLogo(120, 120); ?>
          <h1 class="fw-light text-center text-uppercase m-0"><?php echo GetDepartment(); ?></h1>
          <h2 class="fw-light text-center text-uppercase m-0"><?php echo GetDivision(); ?></h2>
        </div><!-- .card-header -->

        <div class="card-body">
          <h3 class="text-uppercase mt-0 mb-3">Privacy Notice and Consent for Guests and Visitors</h3>

          <p>In accordance with the <a href="https://www.deped.gov.ph/" target="_blank">Department of Education</a>'s mandate to protect and promote the right to and access to quality basic education, DepEd collects various data and information, including personal information, from various subjects using different systems. In the processing of these data and information, <a href="https://sdodipolog.zdnorte.net/" target="_blank">DepEd Dipolog City Schools Division</a> is committed to ensure the free flow of information as required under the <a href="https://www.officialgazette.gov.ph/2016/07/23/executive-order-no-02-s-2016/" target="_blank">Freedom of Information Act (Executive Order No. 2, s. 2016)</a> and to protect and respect the confidentiality and privacy of these data and information as required under the <a href="https://www.privacy.gov.ph/data-privacy-act/" target="_blank">Data Privacy Act of 2012 (Republic Act No. 10173)</a>.</p>

          <h3 class="text-uppercase my-3">What we Collect</h3>

          <p>We collect basic information about you by asking you to sign our official log book and requiring you to deposit a proof of identity (ID) for verification purposes. For those with vehicles, we take note of your vehicle plate number and ask you to deposit your driver’s license or any other valid ID. Video footage is also being recorded via a CCTV system installed in all campus entry and exit points.</p>

          <h3 class="text-uppercase my-3">Why We Collect Them</h3>

          <p>While we collect the data primarily as a security measure, they also help us investigate reported violations of Division and school policies and other applicable laws, and generate statistics useful for planning and service improvement purposes.</p>

          <h3 class="text-uppercase my-3">How We Use, Store and Retain Them</h3>

          <p>Your data are kept in a place inside the Division or school where at least one security personnel is on-duty 24/7. Only authorized Division, school and security personnel have access to them. We dispose of the log books two (2) years from the date of collection, unless required by law to retain them for a longer period. CCTV footages, on the other hand, are stored for thirty (30) days before being automatically deleted. We do NOT transfer or share your personal data with other persons or organizations, unless required or permitted by law.</p>

          <h3 class="text-uppercase my-3">Rights of the Data Subject</h3>

          <p class="mb-0">The Division Data Privacy Manual and Republic Act No. 10173 or the Data Privacy Act of 2012 recognize and enumerates your rights as the Data Subject. If you wish to exercise any of Page 51 of 60 your rights, or should you have any concern or question regarding them and this Notice/Consent, you may contact the Division Data Protection Officer (DPO).</p>
        </div><!-- .card-body -->

        <div class="card-footer text-center small">
          <a href="<?php echo GetSiteURL(); ?>">Go to homepage</a>
        </div><!-- .card-footer -->
      </div><!-- .card -->
    </div><!-- #layoutAuthentication_content -->

    <div id="layoutAuthentication_footer">
      <?php include_once('../../_includes_/layout/footer.php'); ?>
    </div><!-- #layoutAuthentication_footer -->
  </div><!-- #layoutAuthentication -->
</body>

</html>