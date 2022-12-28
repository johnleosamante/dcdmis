<?php
# _includes_/layout/components.php

function AlertBox($message, $type = 'danger', $align = 'center')
{
?>
  <script>
    $(document).ready(function() {
      $("div.alert").fadeIn(300).delay(30000).fadeOut(300);
    });
  </script>

  <div class="alert alert-<?php echo $type; ?> text-<?php echo $align; ?> small"><?php echo $message; ?></div>
<?php
}

function SiteLogo($width = '0', $height = '0')
{
?>
  <img src="<?php echo GetSiteURL(); ?>/assets/img/logo.png" width="<?php echo $width; ?>" height="<?php echo $height; ?>" class="d-block mx-auto mb-3">
<?php
}

function SuccessLogo($width = '0', $height = '0')
{
?>
  <img src="<?php echo GetSiteURL(); ?>/assets/img/check.png" width="<?php echo $width; ?>" height="<?php echo $height; ?>" class="d-block m-auto pb-3">
<?php
}

function ShowPassword($checkbox, $password, $confirmpassword = '')
{
?>
  <script>
    document.getElementById('<?php echo $checkbox; ?>').addEventListener('click', () => {
      var x = document.getElementById('<?php echo $password; ?>');
      var y = document.getElementById('<?php echo $confirmpassword; ?>');
      x.type = x.type === 'password' ? 'text' : 'password';

      <?php if (strlen($confirmpassword) > 0) : ?>
        y.type = y.type === 'password' ? 'text' : 'password';
      <?php endif; ?>
    });
  </script>
<?php
}

function ModalOK($message, $title = '', $id = 'modal', $label = 'ModalLabel')
{
?>
  <div class="modal fade" id="<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $label; ?>" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="<?php echo $label; ?>"><?php echo $title; ?></h5>

          <button type="button" class="close" aria-hidden="true" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>

        <div class="modal-body">
          <?php SuccessLogo(); ?>

          <div class="text-center"><?php echo $message; ?></div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-primary" data-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>
<?php
}

function ModalConfirm($message, $title = '', $id = 'modal', $label = 'ModalLabel', $okbtnlabel = 'OK', $oklink = '')
{
?>
  <div class="modal fade" id="<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $label; ?>" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="<?php echo $label; ?>"><?php echo $title; ?></h5>

          <button type="button" class="close" aria-hidden="true" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>

        <div class="modal-body">
          <?php echo $message; ?>
        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="<?php echo $oklink; ?>"><?php echo $okbtnlabel; ?></a>
        </div>
      </div>
    </div>
  </div>
<?php
}

function ModalAttachment($title = '', $id = 'AttachmentModal', $label = 'ModalLabel')
{
?>
  <div class="modal fade" id="<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $label; ?>" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-header">
        <h5 class="modal-title" id="<?php echo $label; ?>"><?php echo $title; ?></h5>

        <button type="button" class="close" aria-hidden="true" data-dismiss="modal" aria-label="Close">&times;</button>
      </div>

      <div class="modal-content"></div>

      <div class="modal-footer">
        <button class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
<?php
}

function ScrollToTop()
{
?>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
<?php
}

function ContentTitle($title, $withbutton = false, $link = '', $text = 'Back', $icon = 'fa-arrow-circle-left')
{
?>
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h4 mb-0"><?php echo $title; ?></h3>
    <?php if ($withbutton) { ?>
      <a href="<?php echo $link; ?>" class="btn btn-primary btn-icon-split btn-sm">';
        <span class="icon text-white-50">'
          <i class="fas <?php echo $icon; ?> fa-fw"></i>
        </span>
        <span class="text"><?php echo $text; ?></span>
      </a>
    <?php } ?>
  </div>
<?php
}

function Card($title, $link, $icon, $color = 'primary', $counter = false, $number = 0)
{
?>
  <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
    <div class="card border-left-<?php echo $color; ?> shadow h-100">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="font-weight-bold text-<?php echo $color; ?> text-uppercase mb-1"><?php echo $title; ?></div>

            <?php if ($counter) { ?>
              <div class="h3 mb-0 font-weight-bold text-gray-800"><?php echo $number; ?></div>
            <?php } ?>
          </div>

          <div class="col-auto">
            <i class="fas <?php echo $icon; ?> fa-3x text-<?php echo $color; ?>" aria="hidden"></i>
          </div>
        </div>
      </div>

      <div class="card-footer py-1 text-right">
        <a class="small" href="<?php echo $link; ?>">View Details</a>
      </div>
    </div>
  </div>
<?php
}
?>