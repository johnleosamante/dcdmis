<?php
function hashPassword(string $password): string
{
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

function encrypt(string $data, string $key = null): string
{
    $key ??= hash('sha256', ENCRYPTION_KEY ?? 'default-insecure-key', true);
    $algorithm = 'aes-256-gcm';
    $iv = openssl_random_pseudo_bytes(12);
    $tag = '';
    $encrypted = openssl_encrypt($data, $algorithm, $key, OPENSSL_RAW_DATA, $iv, $tag);
    if ($encrypted === false) {
        return false;
    }
    $combined = "{$iv}{$encrypted}{$tag}";
    return base64_encode($combined);
}

function decrypt(string $data, string $key = null): string
{
    $key ??= hash('sha256', ENCRYPTION_KEY ?? 'default-insecure-key', true);
    $algorithm = 'aes-256-gcm';
    $combined = base64_decode($data, true);
    if ($combined === false || strlen($combined) < 28) {
        return false;
    }
    $iv = substr($combined, 0, 12);
    $tag = substr($combined, -16);
    $encrypted = substr($combined, 12, -16);
    $decrypted = openssl_decrypt($encrypted, $algorithm, $key, OPENSSL_RAW_DATA, $iv, $tag);
    return $decrypted;
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