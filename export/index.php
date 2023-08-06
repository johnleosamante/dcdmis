<?php
if (!isset($_GET['v'])) {
  return;
}

require_once('../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/string.php');

$request = sanitize(decode($_GET['v']));
$identifier = isset($_GET['id']) ? sanitize(decode($_GET['id'])) . '-' : '';

$fileName = $request . '-' . $identifier . date('Y-m-d') . '.xls';
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

<?php require_once($request . '.php'); ?>