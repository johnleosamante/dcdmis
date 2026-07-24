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
    if ($string === null) {
        return '';
    }
    return base64_decode((string) $string);
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

    return uri($domain) . "/{$page}?v=" . encode($view) . $value;
}

function title($page = null)
{
    return $page === null ? SITE_TITLE : "{$page} | " . SITE_TITLE;
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
    return $_SERVER['REMOTE_ADDR'];
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

    return preg_match("/^[a-zA-Z0-9_.-]+@" . preg_quote($domain, '/') . "$/", $email);
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

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($filePath);

    if ($mimeType === false) {
        return false;
    }

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

function uploadMaxBytes()
{
    $val = trim(ini_get('upload_max_filesize'));
    $last = strtolower($val[strlen($val) - 1]);
    $val = (int) $val;
    switch ($last) {
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }
    return $val;
}

function parseSizeToBytes($size_string)
{
    $size_string = trim($size_string);
    $last = strtolower($size_string[strlen($size_string) - 1]);
    $val = (int) $size_string;
    switch ($last) {
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }
    return $val;
}

function stageUploadedFile(array $file_data, array $allowed_MIME_map, string $target_folder, string $prefix = 'FILE'): array
{
    if ($file_data['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("File upload failed with error system code: " . $file_data['error']);
    }

    if ($file_data['size'] > FILE_UPLOAD_SIZE_LIMIT) {
        throw new Exception("The chosen file size exceeds the strict system limit configuration.");
    }

    try {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $real_MIME_type = $finfo->file($file_data['tmp_name']);
    } catch (Exception $e) {
        throw new Exception("Failed to analyze the file properties securely.");
    }

    if (!$real_MIME_type || !array_key_exists($real_MIME_type, $allowed_MIME_map)) {
        throw new Exception("Invalid file content structure detected. Format transformation rejected.");
    }

    $ext = $allowed_MIME_map[$real_MIME_type];
    $timestamp = date('YmdHis');
    $secure_name = strtoupper("{$prefix}_{$timestamp}_" . bin2hex(random_bytes(4))) . ".{$ext}";
    $sanitized_target_folder = rtrim($target_folder, '/\\');

    return [
        'tmp_name' => $file_data['tmp_name'],
        'secure_name' => $secure_name,
        'full_path' => "{$sanitized_target_folder}/{$secure_name}",
        'extension' => $ext
    ];
}

function commitStagedFile(array $staged_file): void
{
    $directory = dirname($staged_file['full_path']);
    if (!is_dir($directory)) {
        if (!mkdir($directory, 0755, true) && !is_dir($directory)) {
            throw new Exception("Failed to establish isolated system directory tracks.");
        }
    }

    if (!move_uploaded_file($staged_file['tmp_name'], $staged_file['full_path'])) {
        throw new Exception("Failed to execute storage target disk migrations safely.");
    }
}

require_once('initialization.php');