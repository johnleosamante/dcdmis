<?php
// login/app.php
restrictPublicAccess(hasHoliday());

function setUserSession($userid) {
  $users = user($userid);

  if (numRows($users) === 1) {
    $user = fetchAssoc($users);
    $_SESSION[alias() . '_stationId'] = $user['station_id'];
    $_SESSION[alias() . '_code'] = $user['code'];
    $_SESSION[alias() . '_portal'] = $user['portal'];

    if ($user['portal'] !== 'sch_portal') {
      $_SESSION[alias() . '_station'] = $user['code'];
    } else {
      $school = schoolById($user['code']);
      $_SESSION[alias() . '_station'] = numRows($school) ? fetchAssoc($school)['alias'] : '';
    }
  }
}

if (isset($_COOKIE[alias() . '_login'])) {
  $account = account(sanitize($_COOKIE[alias() . '_login']));

  if (numRows($account === 1)) {
    $userId = $_SESSION[alias() . '_userId'] = fetchAssoc($account)['id'];
    setUserSession($userId);
    createSystemLog($stationId, $userId, 'Resumed login', $userId, clientIp());
  }
}

$page = 'Login';

if (isset($userId)) {
  redirect(uri() . '/' . $activeApp);
}

if (!isset($_POST['login'])) {
  return;
}

$email = sanitize($_POST['email']);
$password = hashPassword(sanitize($_POST['password']));
$showAlert = true;
$success = false;

if (empty($email) || empty($password)) {
  $message = 'All fields are required.';
  return;
}

if (!isValidEmail($email, 'deped.gov.ph')) {
  $message = 'Please use your DepEd Email Address.';
  return;
}

$accounts = account($email, $password);

if (numRows($accounts) === 0) {
  $message = 'Invalid login details! Try again.';
  return;
}

$account = fetchAssoc($accounts);
$userId = $_SESSION[alias() . '_userId'] = $account['id'];
$email = $_SESSION[alias() . '_email'] = $account['email'];

if (isset($_POST['remember']) && $_POST['remember'] === true) {
  setcookie(alias() . '_login', $account['email'], time() + getSeconds(8), '/', uri(), false, true);
}

setUserSession($userId);
createSystemLog($stationId, $userId, 'Logged in', $userId, clientIp());

redirect(uri() . '/' . $activeApp);
?>