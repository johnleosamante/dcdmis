<?php
include_once('../../../_includes_/function.php');
include_once('../../../_includes_/database/database.php');
include_once('../../../_includes_/layout/components.php');

foreach ($_GET as $key => $data) {
  $id = $_GET[$key] = $data;
}

$_SESSION['No'] = $id;

ModalConfirmDelete('Are you sure you want to continue and remove this entry?', 'Remove Work Experience?', 'RemoveExperience');
?>