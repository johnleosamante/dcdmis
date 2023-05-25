<?php
// modules/employees/delete/delete-special-skills.php
include_once('../../../includes/function.php');
include_once(root() . '/includes/layout/components.php');

foreach ($_GET as $key => $data) {
  $id = $_GET[$key] = decode($data);
}

$_SESSION[alias() . '_current_special_skill_id'] = $id;

modal_confirm_delete('Are you sure you want to continue and delete this entry?', 'Delete Special Skill / Hobby?', 'DeleteSpecialSkill');
?>