<?php
// includes/layout/components.php
function displayLogo($width, $height, $marginBottom='3', $url='', $text='') { ?>
  <a href="<?php echo $url; ?>" title="<?php echo $text; ?>" class="d-inline-block mx-auto mb-<?php echo $marginBottom; ?>">
    <img src="<?php echo uri(); ?>/assets/img/division.png" width="<?php echo $width; ?>" height="<?php echo $height; ?>" alt="<?php echo $text; ?>">
  </a>
<?php }

function messageAlert($show, $message, $success=true, $align='left') { 
  if ($show) : ?>
  <div class="alert alert-<?php echo $success ? 'success' : 'danger'; ?> text-<?php echo $align; ?>">
    <?php echo $message; ?>
  </div>
<?php endif;
}

function sidebarMenuItem($link, $title, $icon, $condition=false, $counter=null) { ?>
  <li class="nav-item <?php echo $condition ? ' active' : ''; ?>">
    <a class="nav-link d-flex align-items-center justify-content-between" href="<?php echo $link; ?>">
      <span>
        <i class="fas fa-fw <?php echo $icon; ?>"></i>
        <span><?php echo $title; ?></span>
      </span>
      <?php if ($counter !== null) : ?>
        <span class="bg-dark px-2 rounded-pill font-weight-bold"><?php echo $counter; ?></span>
      <?php endif; ?>
    </a>
  </li>
<?php }

function roundPill($text, $bgColor='primary', $textColor='light') {
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

function sidebarDivider($marginBottom='0', $autoHide = false) { ?>
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

function contentTitle($title) { ?>
  <div class="d-sm-flex">
    <h3 class="h3 mb-0 text-gray-800"><?php echo $title; ?></h3>
  </div>
<?php }

function contentTitleWithLink($title, $link, $text='Back', $icon='fa-arrow-circle-left', $color='primary') { ?>
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h3 mb-0 text-gray-800"><?php echo $title; ?></h3>
    <?php linkButtonSplit($link, $text, $icon, $text, $color); ?>
  </div>
<?php }

function contentTitleWithModal($title, $link, $text, $icon, $color='primary') { ?>
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h3 mb-0 text-gray-800"><?php echo $title; ?></h3>
    <?php modalButtonSplit($link, $text, $icon, $text, $color); ?>
  </div>
<?php }

function card($title, $link, $icon, $color='primary', $counter='&nbsp;') { ?>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-<?php echo $color; ?> shadow h-100">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="font-weight-bold text-<?php echo $color; ?> text-uppercase mb-1"><?php echo $title; ?></div>
            <div class="h3 mb-0 font-weight-bold text-gray-800"><?php echo $counter; ?></div>
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

function linkButtonSplit($link, $text, $icon, $title='', $color='primary', $newTab=false) { ?>
  <a href="<?php echo $link; ?>" class="btn btn-<?php echo $color; ?> btn-icon-split btn-sm my-1" title="<?php echo $title; ?>" target="<?php echo $newTab ? '_blank' : '_self'; ?>">
    <span class="icon text-white-50"><i class="fas <?php echo $icon; ?> fa-fw"></i></span>
    <span class="text"><?php echo $text; ?></span>
  </a>
<?php }

function modalButtonSplit($link, $text, $icon, $title='', $color='primary') { ?>
  <a href='#' data-toggle="modal" data-target="#modal" class="btn btn-<?php echo $color; ?>  btn-icon-split btn-sm my-1" title="<?php echo $title; ?>" onclick="loadData('<?php echo $link; ?>')">
    <span class="icon text-white-50"><i class="fas <?php echo $icon; ?> fa-fw"></i></span>
    <span class="text"><?php echo $text; ?></span>
  </a>
<?php }

function linkDropdownItem($link, $text, $icon, $title='', $newTab=false) { ?>
  <a href="<?php echo $link; ?>" class="dropdown-item" title="<?php echo $title; ?>" target="<?php echo $newTab ? '_blank' : '_self'; ?>">
    <i class="fas <?php echo $icon; ?> fa-sm fa-fw mr-1"></i><?php echo $text; ?>
  </a>
<?php }

function modalDropdownItem($link, $text, $icon, $title='') { ?>
  <a href="#" data-toggle="modal" data-target="#modal" class="dropdown-item" title="<?php echo $title; ?>" onclick="loadData('<?php echo $link; ?>')">
    <i class="fas <?php echo $icon; ?> fa-sm fa-fw mr-1"></i><?php echo $text; ?>
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

function modalConfirmDelete($message, $title='Delete', $buttonName='Delete', $verifier=null, $dataVerifier=null) { ?>
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

function missingAlert($text, $icon='fa-times-circle', $color='text-danger') { ?>
  <div class="error mx-auto text-center <?php echo $color; ?>"><i class="fas <?php echo $icon; ?> fa-fw"></i></div>
  <p class="lead text-center text-gray-800 mt-1 mb-0"><?php echo $text; ?></p>
  <p class="text-center text-gray-500 mb-0">Sorry, we couldn't find what you're looking for...</p>
<?php } 

function requiredLegend($marginBottom=2) { ?>
  <div class="text-danger mb-<?php echo $marginBottom; ?>">* Required field</div>
<?php } ?>