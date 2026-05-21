<?php
// include/function.php
require_once('config.php');

function dd($value)
{
    echo '<pre>';
    ob_start();
    var_dump($value);
    $output = ob_get_clean();
    echo htmlspecialchars($output);
    echo '</pre>';
    die();
}

function hashPassword(string $password): string
{
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

function cipher($string)
{
    return base64_encode($string);
}

function decipher($string)
{
    return base64_decode($string);
}

function encode($string)
{
    return urlencode(cipher($string));
}

function decode($string)
{
    return urldecode(decipher($string));
}

function root()
{
    return $_SERVER['DOCUMENT_ROOT'];
}

function uri($domain = null)
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $root = $domain !== null ? $domain : $_SERVER['HTTP_HOST'];
    return "{$protocol}{$root}";
}

function customUri($page, $view, $id = null, $domain = null)
{
    $value = ($id !== null) ? '&id=' . encode($id) : '';

    return uri($domain) . "/{$page}?&v=" . encode($view) . $value;
}

function title($page = null)
{
    return $page === null ? SITE_TITLE : $page . ' | ' . SITE_TITLE;
}

function alias()
{
    return SITE_ALIAS;
}

function description()
{
    return SITE_DESCRIPTION;
}

function author()
{
    return SITE_AUTHOR;
}

function division()
{
    return DIVISION;
}

function divisionId()
{
    return DIVISION_ID;
}

function region()
{
    return REGION;
}

function clientIp()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

function redirect($url = null)
{
    if ($url !== null) {
        header("Location: $url");
        exit;
    }
}

function generateID()
{
    $timestamp = date('YmdHis');
    $random = str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
    return "{$timestamp}{$random}";
}

function getSeconds($hours = 1)
{
    return $hours * 60 * 60;
}

function setActiveItem($reference, $value, $class = 'active')
{
    return strtolower($reference) === strtolower($value) ? " {$class}" : '';
}

function setActiveNavigation($condition, $class = 'active')
{
    return $condition ? " {$class}" : '';
}

function isValidEmail($email, $domain = null)
{
    if ($domain === null) {
        return preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $email);
    }

    return preg_match("/^[a-zA-Z0-9_.-]+@+" . $domain . "+$/", $email);
}

function setOptionSelected($reference, $value)
{
    return strtolower($reference) === strtolower($value) ? ' selected' : '';
}

function setItemChecked($condition)
{
    return $condition ? ' checked' : '';
}

function getDateDifference($date)
{
    $now = new DateTime();
    $bdate = new DateTime($date);
    return $now->diff($bdate)->y;
}

function e($string)
{
    return htmlspecialchars((string) $string, ENT_QUOTES, 'UTF-8');
}

function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        try {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        } catch (Exception $e) {
            $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
        }
    }
    return $_SESSION['csrf_token'];
}

function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

function verify_csrf_token()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
            header('HTTP/1.1 403 Forbidden');
            die('CSRF token validation failed.');
        }
    }
}

function validateFileMimeType(string $filePath, array $allowedMimes): bool
{
    if (!file_exists($filePath)) {
        return false;
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $filePath);
    finfo_close($finfo);
    return in_array($mimeType, $allowedMimes, true);
}

function getFileExtension(string $filename): string
{
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

function validateFileExtension(string $filename, array $allowedExtensions): bool
{
    $ext = getFileExtension($filename);
    return in_array($ext, $allowedExtensions, true);
}

function sanitizeFilename(string $filename): string
{
    $filename = basename($filename);
    $filename = str_replace("\0", '', $filename);
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);
    $filename = preg_replace('/\.{2,}/', '.', $filename);
    return $filename;
}

function checkRateLimit(string $identifier, int $maxAttempts = 5, int $windowSeconds = 300): bool
{
    $sessionKey = "rate_limit_{$identifier}";
    if (!isset($_SESSION[$sessionKey])) {
        $_SESSION[$sessionKey] = [];
    }
    $now = time();
    $_SESSION[$sessionKey] = array_filter($_SESSION[$sessionKey], function ($timestamp) use ($now, $windowSeconds) {
        return $timestamp > ($now - $windowSeconds);
    });
    if (count($_SESSION[$sessionKey]) >= $maxAttempts) {
        return false;
    }
    $_SESSION[$sessionKey][] = $now;
    return true;
}

function getRateLimitRemainingTime(string $identifier, int $windowSeconds = 300): int
{
    $sessionKey = "rate_limit_{$identifier}";
    if (!isset($_SESSION[$sessionKey]) || empty($_SESSION[$sessionKey])) {
        return 0;
    }
    $oldestAttempt = min($_SESSION[$sessionKey]);
    $resetTime = $oldestAttempt + $windowSeconds;
    $remaining = $resetTime - time();
    return max(0, $remaining);
}

require_once('initialization.php');