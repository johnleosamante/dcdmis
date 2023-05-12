<?php
// login/app.php
if (!isset($_SESSION[alias() . '_active_app'])) {
  $_SESSION[alias() . '_active_app'] = 'pis';
}

function set_user_session($userid) {
  $users = user($userid);

  if (num_rows($users) === 1) {
    $user = fetch_assoc($users);
    $_SESSION[alias() . '_portal'] = $user['portal'];
    $_SESSION[alias() . '_code'] = $user['station'];
    $_SESSION[alias() . '_station_code'] = $user['station_code'];

    if ($user['portal'] !== 'school_portal') {
      $_SESSION[alias() . '_station'] = $user['station'];
    } else {
      $school = school_by_id($user['station']);
      $_SESSION[alias() . '_station'] = fetch_assoc($school)['alias'];
    }
  } else {
    $_SESSION[alias() . '_active_app'] = 'pis';
  }
}

if (isset($_COOKIE[alias() . '_login'])) {
  $account = account(real_escape_string($_COOKIE[alias() . '_login']));

  if (num_rows($account === 1)) {
    $_SESSION[alias() . '_user_id'] = fetch_assoc($account)['id'];
    set_user_session($_SESSION[alias() . '_user_id']);
  }
}

if (isset($_SESSION[alias() . '_user_id'])) {
  redirect(uri() . '/' . $_SESSION[alias() . '_active_app']);
}

$page = 'Login';
$has_error = false;
$error_message = null;

if (!isset($_POST['login'])) {
  return;
}

$email = real_escape_string($_POST['email']);
$password = hash_password(real_escape_string($_POST['password']));
$has_error = true;

if (strlen($email) === 0 || strlen($password) === 0) {
  $error_message = 'All fields are required!';
  return;
}

if (!is_valid_email($email, 'deped.gov.ph')) {
  $error_message = 'Please use your DepEd Email Address.';
  return;
}

$accounts = account($email, $password);

if (num_rows($accounts) === 0) {
  $error_message = 'Invalid login details! Try again.';
  return;
}

$account = fetch_assoc($accounts);

if ($account['status'] === 'Registered') {
  $error_message = 'Your account still needs to be verified! Please wait for the system administrator to accept your registration.';
  return;
}

if ($account['status'] === 'Default') {
  $_SESSION[alias() . '_inactive_id'] = $account['id'];
  $_SESSION[alias() . '_inactive_email'] = $account['email'];
  redirect(uri() . '/activate');
}

$_SESSION[alias() . '_user_id'] = $account['id'];

if (isset($_POST['remember']) && $_POST['remember'] === true) {
  setcookie(alias() . '_login', $account['email'], time() + get_seconds(8), '/', uri(), false, true);
}

set_user_session($_SESSION[alias() . '_user_id']);

redirect(uri() . '/' . $_SESSION[alias() . '_active_app']);
?>