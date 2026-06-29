<?php
// login/app.php
if (isset($_SESSION["{$prefix}change_password"])) {
    redirect("{$baseUri}/login/change");
}

if (isset($userId)) {
    redirect("{$baseUri}/{$activeApp}");
}

$appTitle = $page = !MAINTENANCE_MODE ? 'Login' : 'System Maintenance';

function setUserSession($user_id, $prefix)
{
    $user = user($user_id);

    $portal = null;
    $access = null;
    $station_id = null;
    $stationName = '';

    if ($user) {
        $portal = $user['link'];
        $access = $user['access'];
        $station_id = $user['station_id'];

        if ($portal === 'sch_portal') {
            $school = schoolById($access);
            $stationName = $school['alias'] ?? '';
        } else {
            $stationName = $access ?? '';
        }
    } else {
        // Fallback for users with no set permissions: retrieve their station assignment if it exists
        $empStation = station($user_id);
        if ($empStation) {
            $station_id = $empStation['station_id'];
            $school = schoolById($station_id);
            $stationName = $school['alias'] ?? $station_id;
        }
    }

    $_SESSION["{$prefix}userId"] = $user_id;
    $_SESSION["{$prefix}stationId"] = $station_id;
    $_SESSION["{$prefix}code"] = $access;
    $_SESSION["{$prefix}portal"] = $portal;
    $_SESSION["{$prefix}station"] = $stationName;

    foreach (['hrmis', 'dts', 'pis', 'race', 'hrtdms', 'dmis', 'monitoring_tools'] as $area) {
        $_SESSION["{$prefix}data_privacy_agreed_{$area}"] = false;
    }

    createSystemLog($station_id, $user_id, 'Logged in', $user_id, clientIp());
}

if (isset($_POST['login'])) {
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);
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
        recordFailedAttempt($clientIdentifier);
        return;
    }

    $passwordMatches = verifyAccountPassword($account['id'], $password);

    if (!$passwordMatches) {
        $message = 'Invalid login details! Try again.';
        recordFailedAttempt($clientIdentifier);
        return;
    }

    clearRateLimit($clientIdentifier);

    if (isset($_POST['remember'])) {
        $rememberToken = bin2hex(random_bytes(32));
        $tokenHash = hash('sha256', $rememberToken);
        $expiresAt = date('Y-m-d H:i:s', time() + getSeconds(120));

        delete('remember_tokens', '`employee_id` = ?', [$account['id']]);
        insert('remember_tokens', [
            'employee_id' => $account['id'],
            'token_hash' => $tokenHash,
            'expires_at' => $expiresAt
        ]);
        setcookie("{$prefix}remember_token", $account['id'] . '|' . $rememberToken, [
            'expires' => time() + getSeconds(120),
            'path' => '/',
            'domain' => parse_url(uri(), PHP_URL_HOST),
            'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    }

    setUserSession($account['id'], $prefix);

    $_SESSION["{$prefix}email"] = $account['email_address'];

    if ($account['status'] === 'Default') {
        $_SESSION["{$prefix}change_password"] = true;
        redirect("{$baseUri}/login/change");
        return;
    }

    redirect("{$baseUri}/{$activeApp}");
}