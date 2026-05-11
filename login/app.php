<?php
// login/app.php
function setUserSession($user_id, $prefix)
{
    $user = user($user_id);
    if (!$user) {
        return;
    }

    $portal = $user['link'];
    $access = $user['access'];
    $station_id = $user['station_id'];
    $_SESSION["{$prefix}stationId"] = $station_id;
    $_SESSION["{$prefix}code"] = $access;
    $_SESSION["{$prefix}portal"] = $portal;

    if ($portal === 'sch_portal') {
        $school = schoolById($access);
        $stationName = $school['alias'] ?? '';
    } else {
        $stationName = $access;
    }

    $_SESSION["{$prefix}station"] = $stationName;

    createSystemLog($station_id, $user_id, 'Logged in', $user_id, clientIp());
}

$appTitle = $page = 'Login';

if (isset($_POST['login'])) {
    $email = sanitize($_POST['email'] ?? '');
    $password = sanitize($_POST['password'] ?? '');
    $showAlert = true;

    if (empty($email) || empty($password)) {
        $message = 'All fields are required.';
        return;
    }

    if (!isValidEmail($email, 'deped.gov.ph')) {
        $message = 'Please use your DepEd Email Address.';
        return;
    }

    $clientIdentifier = clientIp();

    if (!checkRateLimit($clientIdentifier, 5, 300)) {
        $remainingTime = getRateLimitRemainingTime($clientIdentifier, 300);
        $message = "Too many login attempts. Please try again in {$remainingTime} seconds.";
        return;
    }

    $account = account($email);

    if (!$account) {
        $message = 'Invalid login details! Try again.';
        return;
    }

    $accountPassword = verifyAccountPassword($account['id'], $password);

    if (!$accountPassword) {
        $message = 'Invalid login details! Try again.';
        return;
    }

    $_SESSION["{$prefix}userId"] = $userId = $account['id'];
    $_SESSION["{$prefix}email"] = $account['email_address'];

    if (isset($_POST['remember'])) {
        setcookie("{$prefix}login", $account['email_address'], [
            'expires' => time() + getSeconds(8),
            'path' => '/',
            'domain' => parse_url(uri(), PHP_URL_HOST),
            'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    }

    setUserSession($userId, $prefix);

    if ($accountPassword['status'] === 'Default') {
        $_SESSION["{$prefix}change_password"] = true;
        redirect("{$baseUri}/login/change");
        return;
    }

    redirect("{$baseUri}/{$activeApp}");
}

if (isset($userId)) {
    redirect("{$baseUri}/{$activeApp}");
}