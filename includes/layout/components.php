<?php
// includes/layout/components.php

function display_logo($width = '0', $height = '0', $margin_bottom = '3', $url = '', $text = '')
{
?>
  <a href="<?php echo $url; ?>" title="<?php echo $text; ?>" class="d-inline-block mx-auto mb-<?php echo $margin_bottom; ?>">
    <img src="<?php echo uri(); ?>/assets/img/division.png" width="<?php echo $width; ?>" height="<?php echo $height; ?>" alt="<?php echo $text; ?>">
  </a>
<?php
}

function message_prompt($message, $type = 'danger', $align = 'left')
{
?>
  <div class="alert alert-<?php echo $type; ?> text-<?php echo $align; ?>"><?php echo $message; ?></div>
<?php
}

function sidebar_menu_item($condition, $link, $title, $icon = '', $counter = null)
{
  $class = $condition ? ' active' : '';
?>
  <li class="nav-item <?php echo $class; ?>">
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
<?php
}

function round_pill($text, $bg_color = 'primary', $text_color = 'light')
{
?>
  <span class="py-1 px-3 small bg-<?php echo $bg_color; ?> rounded-pill text-<?php echo $text_color; ?>"><?php echo $text; ?></span>
<?php
}

function content_title($title)
{
?>
  <div class="d-sm-flex">
    <h3 class="h3 mb-0 text-gray-800"><?php echo $title; ?></h3>
  </div>
<?php
}

function content_title_with_link($title, $link, $text = 'Back', $icon = 'fa-arrow-circle-left')
{
?>
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h3 mb-0 text-gray-800"><?php echo $title; ?></h3>
    <?php link_button_split($link, $text, $icon, 'primary', $text); ?>
  </div>
<?php
}

function content_title_with_modal($title, $target, $id, $text, $icon, $color = 'primary')
{
?>
  <div class="d-sm-flex align-items-center justify-content-between">
    <h3 class="h3 mb-0 text-gray-800"><?php echo $title; ?></h3>
    <?php modal_button_split($target, $id, $text, $icon, $color, $text) ?>
  </div>
<?php
}

function card($title, $link, $icon, $color = 'primary', $counter = '&nbsp;')
{
?>
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
<?php
}

function scroll_to($id)
{
?>
  <a class="scroll-to-top rounded" href="<?php echo $id; ?>"><i class="fas fa-angle-up"></i></a>
<?php
}

function modal($id)
{
?>
  <div class="modal fade" id="<?php echo $id; ?>" tabindex="-1" role="dialog" aria-hidden="true" aria-modal="true" data-backdrop="static" data-keyboard="false"></div>
<?php
}

/* Button component styles */

function link_button_icon($link, $icon, $color = 'primary', $title = '', $new_tab = false)
{ ?>
  <a class="text-xs btn btn-<?php echo $color; ?> my-1" href="<?php echo $link; ?>" title="<?php echo $title; ?>" target="<?php echo $new_tab ? '_blank' : '_self'; ?>"><i class="fas <?php echo $icon; ?> fa-fw"></i></a>
<?php
}

function modal_button_split($target, $id, $text, $icon, $color = 'primary', $title = '')
{
?>
  <a data-toggle="modal" data-target="#<?php echo $target; ?>" class="btn btn-<?php echo $color; ?> btn-icon-split btn-sm my-1" href='#' id='<?php echo $id; ?>' title='<?php echo $title; ?>'>
    <span class="icon text-white-50"><i class="fas <?php echo $icon; ?> fa-fw"></i></span>
    <span class="text"><?php echo $text; ?></span>
  </a>
<?php
}

function link_button_split($link, $text, $icon, $color = 'primary', $title = '', $new_tab = false)
{
?>
  <a href="<?php echo $link; ?>" class="btn btn-<?php echo $color; ?> btn-icon-split btn-sm my-1" title="<?php echo $title; ?>" target="<?php echo $new_tab ? '_blank' : '_self'; ?>">
    <span class="icon text-white-50">
      <i class="fas <?php echo $icon; ?> fa-fw"></i>
    </span>
    <span class="text"><?php echo $text; ?></span>
  </a>
<?php
}

function link_dropdown_item($link, $text, $icon, $title ='', $new_tab =false, $color = 'text-gray-400')
{ ?>
  <a class="dropdown-item" href="<?php echo $link; ?>" title="<?php echo $title; ?>" target="<?php echo $new_tab ? '_blank' : '_self'; ?>">
    <i class="fas <?php echo $icon; ?> fa-sm fa-fw mr-1 <?php echo $color; ?>"></i><?php echo $text; ?>
  </a>
<?php
}

function modal_dropdown_item($id, $text, $icon, $title = '', $new_tab = false, $color = 'text-gray-500')
{
?>
  <a class="dropdown-item" href="#" id="<?php echo $id; ?>" data-toggle="modal" data-target="#Modal" title="<?php echo $title; ?>" target="<?php echo $new_tab ? '_blank' : '_self'; ?>">
    <i class="fas <?php echo $icon; ?> fa-sm fa-fw mr-1 <?php echo $color; ?>"></i><?php echo $text; ?>
  </a>
<?php
}

function dropdown_ellipsis()
{
?>
  <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
  </a>
<?php
}
?>