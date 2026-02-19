<?php
// login/app.php
function setUserSession($userId)
{
    $user = user($userId);

    if ($user) {
        $stationId = $_SESSION[alias() . '_stationId'] = $user['station_id'];
        $_SESSION[alias() . '_code'] = $user['access'];
        $_SESSION[alias() . '_portal'] = $user['link'];

        if ($user['link'] !== 'sch_portal') {
            $_SESSION[alias() . '_station'] = $user['access'];
        } else {
            $school = schoolById($user['access']);
            $_SESSION[alias() . '_station'] = $school ? $school['alias'] : '';
        }

        createSystemLog($stationId, $userId, 'Logged in', $userId, clientIp());
    }
}

$appTitle = $page = 'Login';

if (isset($_POST['login'])) {
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

    $account = account($email);

    if (!$account) {
        $message = 'Invalid login details! Try again.';
        return;
    }

    $password = accountPassword($account['id'], $password);

    if (!$password) {
        $message = 'Invalid login details! Try again.' . var_dump($password);
        return;
    }

    $userId = $_SESSION[alias() . '_userId'] = $account['id'];
    $email = $_SESSION[alias() . '_email'] = $account['email_address'];

    if (isset($_POST['remember'])) {
        setcookie(alias() . '_login', $account['email'], time() + getSeconds(8), '/', uri(), false, true);
    }

    setUserSession($userId);

    if ($password['status'] === 'Default') {
        $_SESSION[alias() . '_change_password'] = true;
        redirect(uri() . '/login/change');
        return;
    }

    redirect(uri() . '/' . $activeApp);
}

if (isset($userId)) {
    redirect(uri() . '/' . $activeApp);
}