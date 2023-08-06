<?php
require_once('../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/string.php');

$fileName = $dataType . '-' . date('Y-m-d') . '.xls';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; Filename=" . $fileName);
?>

<style>
  table, th, td {
    border: 1px solid;
  }
  table {
    border-collapse: collapse;
  }
</style>

<?php require_once($dataType . '.php'); ?>