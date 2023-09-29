<?php
// includes/layout/components.php
function displayLogo($width, $height, $marginBottom = '3', $url = '', $text = '') { ?>
  <a href="<?php echo $url; ?>" title="<?php echo $text; ?>" class="d-inline-block mx-auto mb-<?php echo $marginBottom; ?>">
    <img src="<?php echo uri(); ?>/uploads/division/division.png" width="<?php echo $width; ?>" height="<?php echo $height; ?>" alt="<?php echo $text; ?>">
  </a>
<?php }

function messageAlert($show, $message, $success = true, $align = 'left') {
  if ($show) : ?>
    <div class="alert alert-<?php echo $success ? 'success' : 'danger'; ?> text-<?php echo $align; ?>">
      <?php echo $message; ?>
    </div>
  <?php endif;
}

function roundPill($text) {
  $bgColor = 'primary';
  $textColor = 'light';
  switch (strtolower($text)) {
    case 'active':
      $bgColor = 'success';
      break;
    case 'transferred':
      $bgColor = 'info';
      break;
    case 'suspended':
      $bgColor = 'warning';
      $textColor = 'secondary';
      break;
    case 'resigned':
    case 'retired':
    case 'dismissed':
      $bgColor = 'danger';
      break;
    case 'deceased':
      $bgColor = 'dark';
      break;
    default:
      $bgColor = 'secondary';
      break;
  } ?>
  <span class="py-1 px-3 small bg-<?php echo $bgColor; ?> rounded-pill text-<?php echo $textColor; ?>"><?php echo $text; ?></span>
<?php }

function newFeatureMark() { ?>
  <span class="new-feature bg-danger px-2 small ml-1 text-light font-weight-light text-capitalize rounded-pill">New</span>
<?php }

function sidebarDivider($marginBottom = '0', $autoHide = false) { ?>
  <hr class="sidebar-divider mb-<?php echo $marginBottom; ?> <?php echo $autoHide ? 'd-none d-md-block' : ''; ?>">
<?php }

function sidebarHeading($text) { ?>
  <div class="sidebar-heading mt-3"><?php echo $text; ?></div>
<?php }

function sidebarToggle() { ?>
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
<?php }

function sex($sex) {
  $sign = strtolower($sex) === 'male' ? 'mars' : 'venus'; ?>
  <i class="<?php echo "fas fa-{$sign} text-{$sign} fa-2x"; ?>"></i>
<?php }

function card($title, $link, $icon, $color = 'primary', $counter = null, $newFeature = false) { ?>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-<?php echo $color; ?> shadow h-100">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="font-weight-bold text-<?php echo $color; ?> text-uppercase mb-1">
              <?php echo $title; 
              if ($newFeature) {
                newFeatureMark();
              } ?>
            </div>
            <div class="h3 mb-0 font-weight-bold text-gray-800"><?php echo $counter !== null ? $counter : '&nbsp;'; ?></div>
          </div>

          <div class="col-auto">
            <i class="fas <?php echo $icon; ?> fa-3x text-<?php echo $color; ?>" aria="hidden"></i>
          </div>
        </div>
      </div>

      <div class="card-footer py-1 text-right">
        <a class="small text-<?php echo $color; ?>" href="<?php echo $link; ?>">View Details</a>
      </div>
    </div>
  </div>
<?php }

function cardMini($title, $link, $icon, $color = 'primary') { ?>
  <div class="col-xl-2 col-md-4 mb-4">
    <div class="card border-left-<?php echo $color; ?> shadow h-100">
      <div class="card-body">
        <div class="row">
          <div class="col-auto">
            <i class="fas <?php echo $icon; ?> fa-3x text-<?php echo $color; ?>" aria="hidden"></i>
          </div>

          <div class="col">
            <div class="font-weight-bold text-uppercase mb-1">
              <a class="text-<?php echo $color; ?>" href="<?php echo $link; ?>">
                <?php echo $title; ?>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php }

function cardMiniModal($title, $link, $icon, $color = 'primary') { ?>
  <div class="col-xl-2 col-md-4 mb-4">
    <div class="card border-left-<?php echo $color; ?> shadow h-100">
      <div class="card-body">
        <div class="row">
          <div class="col-auto">
            <i class="fas <?php echo $icon; ?> fa-3x text-<?php echo $color; ?>" aria="hidden"></i>
          </div>

          <div class="col">
            <div class="font-weight-bold text-uppercase mb-1">
              <a class="text-<?php echo $color; ?>" href="#" data-toggle="modal" data-target="#modal" onclick="loadData('<?php echo $link; ?>')">
                <?php echo $title; ?>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php }

function scrollToTop() { ?>
  <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>
<?php }

function showAsterisk($show = true) {
  if ($show) : ?>
    <span class="text-danger"> *</span>
  <?php endif;
}

function modal() { ?>
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true" aria-modal="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog d-none">
      <div class="modal-content">
        <?php modalHeader(''); ?>

        <div class="modal-body"></div>

        <div class="modal-footer">
          <form action="" method="POST" role="form">
            <?php cancelModalButton(); ?>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php }

function contentTitle($title) { ?>
  <div class="d-sm-flex">
    <h3 class="h3 mb-0 text-gray-800"><?php echo $title; ?></h3>
  </div>
<?php }

function contentTitleWithLink($title, $link, $text = 'Back', $icon = 'fa-arrow-circle-left', $color = 'primary') { ?>
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h3 mb-0 text-gray-800"><?php echo $title; ?></h3>
    <?php linkButtonSplit($link, $text, $icon, $text, $color); ?>
  </div>
<?php }

function contentTitleWithModal($title, $link, $text, $icon, $color = 'primary') { ?>
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h3 mb-0 text-gray-800"><?php echo $title; ?></h3>
    <?php modalButtonSplit($link, $text, $icon, $text, $color); ?>
  </div>
<?php }

function sidebarMenuItem($link, $title, $icon, $condition = false, $counter = null, $newFeature = false) { ?>
  <li class="nav-item <?php echo $condition ? ' active' : ''; ?>">
    <a class="nav-link d-flex align-items-center justify-content-between" href="<?php echo $link; ?>">
      <div class="menu-item">
        <i class="fas fa-fw <?php echo $icon; ?>"></i>
        <span>
          <?php echo $title; 
          if ($newFeature) {
            newFeatureMark();
          } ?>
        </span>
      </div>
      <?php if ($counter !== null) : ?>
        <span class="bg-dark px-2 rounded-pill font-weight-bold"><?php echo $counter; ?></span>
      <?php endif; ?>
    </a>
  </li>
<?php }

function sidebarModalItem($link, $title, $icon, $counter = null, $newFeature = false) { ?>
  <li class="nav-item">
    <a class="nav-link d-flex align-items-center justify-content-between" href="#" data-toggle="modal" data-target="#modal" onclick="loadData('<?php echo $link; ?>')">
      <div class="menu-item">
        <i class="fas fa-fw <?php echo $icon; ?>"></i>
        <span>
          <?php echo $title; 
          if ($newFeature) {
            newFeatureMark();
          } ?>
        </span>
      </div>
      <?php if ($counter !== null) : ?>
        <span class="bg-dark px-2 rounded-pill font-weight-bold"><?php echo $counter; ?></span>
      <?php endif; ?>
    </a>
  </li>
<?php }

function linkItem($link, $text, $newTab=false) { ?>
  <a href="<?php echo $link; ?>" class="text-uppercase" target="<?php echo $newTab ? '_blank' : '_self'; ?>"><?php echo $text; ?></a>
<?php }
  
function modalItem($link, $text) { ?>
  <a href="#" data-toggle="modal" data-target="#modal" class="text-uppercase" onclick="loadData('<?php echo $link; ?>')"><?php echo $text; ?></a>
<?php }

function linkButtonSplit($link, $text, $icon, $title = '', $color = 'primary', $newTab = false) { ?>
  <a href="<?php echo $link; ?>" class="btn btn-<?php echo $color; ?> btn-icon-split btn-sm my-1" title="<?php echo $title; ?>" target="<?php echo $newTab ? '_blank' : '_self'; ?>">
    <span class="icon text-white-50"><i class="fas <?php echo $icon; ?> fa-fw"></i></span>
    <span class="text"><?php echo $text; ?></span>
  </a>
<?php }

function modalButtonSplit($link, $text, $icon, $title = '', $color = 'primary') { ?>
  <a href="#" data-toggle="modal" data-target="#modal" class="btn btn-<?php echo $color; ?>  btn-icon-split btn-sm my-1" title="<?php echo $title; ?>" onclick="loadData('<?php echo $link; ?>')">
    <span class="icon text-white-50"><i class="fas <?php echo $icon; ?> fa-fw"></i></span>
    <span class="text"><?php echo $text; ?></span>
  </a>
<?php }

function linkDropdownItem($link, $text, $icon, $title = '', $newTab = false, $newFeature = false) { ?>
  <a href="<?php echo $link; ?>" class="dropdown-item" title="<?php echo $title; ?>" target="<?php echo $newTab ? '_blank' : '_self'; ?>">
    <i class="fas <?php echo $icon; ?> fa-sm fa-fw mr-1"></i>
    <?php echo $text; 
      if ($newFeature) {
        newFeatureMark();
    } ?>
  </a>
<?php }

function modalDropdownItem($link, $text, $icon, $title = '', $newFeature = false) { ?>
  <a href="#" data-toggle="modal" data-target="#modal" class="dropdown-item" title="<?php echo $title; ?>" onclick="loadData('<?php echo $link; ?>')">
    <i class="fas <?php echo $icon; ?> fa-sm fa-fw mr-1"></i>
    <?php echo $text; 
      if ($newFeature) {
        newFeatureMark();
    } ?>
  </a>
<?php }

function dropdownEllipsis() { ?>
  <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-600"></i>
  </a>
<?php }

function modalHeader($title) { ?>
  <div class="modal-header">
    <h5 class="modal-title"><?php echo $title; ?></h5>
    <button id="close-modal-button" type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
  </div>
<?php }

function modalConfirmDelete($message, $title = 'Delete', $buttonName = 'Delete', $verifier = null, $dataVerifier = null) { ?>
  <div class="modal-dialog">
    <div class="modal-content">
      <?php modalHeader($title); ?>

      <div class="modal-body">
        <?php echo $message; ?>
      </div>

      <div class="modal-footer">
        <form action="" method="POST" role="form">
          <input type="hidden" name="verifier" value="<?php echo $verifier; ?>">
          <input type="hidden" name="data-verifier" value="<?php echo $dataVerifier; ?>">
          <input type="submit" class="btn btn-danger" name="<?php echo $buttonName; ?>" value="Yes, Continue">
          <?php cancelModalButton(); ?>
        </form>
      </div>
    </div>
  </div>
<?php }

function cancelModalButton() { ?>
  <button id="cancel-modal-button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
<?php }

function missingAlert($text, $icon = 'fa-times-circle', $color = 'text-danger') { ?>
  <div class="error mx-auto text-center <?php echo $color; ?>"><i class="fas <?php echo $icon; ?> fa-fw"></i></div>
  <p class="lead text-center text-gray-800 mt-1 mb-0"><?php echo $text; ?></p>
  <p class="text-center text-gray-500 mb-0">Sorry, we couldn't find what you're looking for...</p>
<?php }

function requiredLegend($marginBottom = 2) { ?>
  <div class="text-danger mb-<?php echo $marginBottom; ?>">* Required field</div>
<?php } 

function progressBar($value, $min=50) { ?>
  <div class="progress mt-1" title="<?php echo $value; ?>% Complete">
    <div class="progress-bar bg-<?php echo $value > $min ? 'success' : 'danger'; ?>" role="progressbar" aria-valuenow="<?php echo $value; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $value; ?>%"></div>
  </div>
<?php }

function employeeProfile($picture, $name, $sex, $email, $position, $station, $status) { ?>
  <div class="image-container">
    <span class="d-flex justify-content-center align-middle employee-photo photo-4x rounded-circle overflow-hidden">
      <img height="100%" src="<?php echo $picture; ?>" alt="<?php echo $name; ?>">
    </span>
    <div class="sex-sign"><?php sex($sex); ?></div>
  </div>

  <div class="text-center text-uppercase h4 mt-3 mb-0"><?php echo $name; ?></div>
  <div class="text-center text-lowercase m-0 small"><?php echo $email; ?></div>
  <div class="text-center text-uppercase my-1"><?php roundPill($status); ?></div>
  <div class="text-center text-uppercase h5 mt-3 mb-1"><?php echo $position; ?></div>
  <div class="text-center text-uppercase h6 my-1"><?php echo $station; ?></div>
<?php } ?>