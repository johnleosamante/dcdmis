<?php
// modules/employees/delete/delete-reference.php
include_once('../../../includes/function.php');
include_once(root() . '/includes/layout/components.php');

foreach ($_GET as $key => $data) {
  $id = $_GET[$key] = decode($data);
}

$_SESSION[alias() . '_current_reference_id'] = $id;

modalConfirmDelete('Are you sure you want to continue and delete this entry?', 'Delete Reference?', 'delete-reference');
?>