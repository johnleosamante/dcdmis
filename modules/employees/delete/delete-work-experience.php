<?php
// modules/employees/delete/delete-work-experience.php
include_once('../../../includes/function.php');
include_once(root() . '/includes/layout/components.php');

foreach ($_GET as $key => $data) {
  $id = $_GET[$key] = decode($data);
}

$_SESSION[alias() . '_current_work_experience_id'] = $id;

modal_confirm_delete('Are you sure you want to continue and delete this entry?', 'Delete Work Experience?', 'DeleteWorkExperience');
?>