<?php
# register/agreement.php
?>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card shadow-lg border-0 rounded-lg my-5">
      <div class="card-header">
        <?php SiteLogo(120, 120) ?>

        <h3 class="text-center fw-light my-2">Data Privacy Policy Agreement</h3>
      </div><!-- .card-header -->

      <div class="card-body">
        <p>I certify that the said information is true and correct to the best of my knowledge and I hereby authorized <?php echo GetDepartmentAlias() . ' ' . GetDivision() . ' - ' . GetSiteAlias(); ?> to use my personnal information.</p>

        <p>The information herein is and shall be treated as confidential and in accordance with the <a href="https://www.privacy.gov.ph/data-privacy-act/" target="_blank">Data Privacy Act of 2012</a>.</p>

        <div class="d-flex align-items-center justify-content-between">
          <div class="form-group form-check p-0 m-0">
            <input type="checkbox" name="agree" id="click"> <label class="m-0" for="click">I agree to the Data Privacy Policy</label>
          </div><!-- .form-group -->

          <input id="agree" type="button" name="submit" class="btn btn-primary" value="Continue">
        </div><!-- .d-flex -->
      </div><!-- .card-body -->

      <div class="card-footer text-center small">
        <a href="<?php echo GetSiteURL(); ?>/login">Have an existing account? Go to login</a>
      </div><!-- .card-footer -->
    </div><!-- .card -->
  </div><!-- .col-lg-8 -->
</div><!-- .row -->

<script>
  var button = document.getElementById('agree');
  var clickBtn = document.getElementById('click');
  button.disabled = true;
  clickBtn.checked = false;

  clickBtn.addEventListener('click', () => {
    if (clickBtn.checked === true) {
      button.disabled = false;
    } else {
      button.disabled = true;
    }
  });

  button.addEventListener('click', () => {
    window.location.href = '<?php echo GetHashURL('register', 'Register Account'); ?>';
  });
</script>