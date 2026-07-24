<?php
// include/string.php
function toString(?string $string, ?string $prefix = null, ?string $suffix = null, $ischar = false): string
{
    if (empty($string))
        return '';
    if (strtolower($string) === 'n/a')
        return '';
    if ($ischar)
        $string = $string[0];
    return "{$prefix}{$string}{$suffix}";
}

function toName(string $last_name, string $first_name, ?string $middle_name = null, ?string $extension = null, $fname_first = false, $middle_initial = true): string
{
    if (strlen($middle_name) > 0 && $middle_name !== ' ' && strtoupper($middle_name) !== 'n/a') {
        $suffix = $middle_initial ? '.' : '';
        $middle_name = toString($middle_name, ' ', $suffix, $middle_initial);
    } else {
        $middle_name = '';
    }

    if (!$fname_first) {
        return $last_name . toString($first_name, ', ') . toString($extension, ' ') . $middle_name;
    } else {
        return $first_name . toString($middle_name) . toString($last_name, ' ') . toString($extension, ', ');
    }
}

function toAddress(?string $lot, ?string $street, ?string $subdivision, ?string $barangay, ?string $city, ?string $province = ''): string
{
    return toString($lot, '', ', ') . toString($street, '', ', ') . toString($subdivision, '', ', ') . toString($barangay, '', ', ') . toString($city) . toString($province, ', ');
}

function toHandleNull(?string $value, string $default = ''): string
{
    return !empty($value) ? $value : $default;
}

function toDate(?string $date, string $format = 'm/d/Y', string $default = ''): string
{
    return strtotime($date) ? date($format, strtotime($date)) : $default;
}

function toLongDate(string $date, string $default = ''): string
{
    return toDate($date, 'F j, Y', $default);
}

function toDatetime(string $date, string $separator = '<br>'): string
{
    return strtotime($date) ? date('F j, Y', strtotime($date)) . $separator . date('h:i:s A', strtotime($date)) : $date;
}

function toCurrency(string $value, string $currency = '&#8369;'): string
{
    $number = is_numeric($value) ? $value : 0;
    return "$currency " . number_format(floatval($number), 2);
}

function sanitize(?string $text): ?string
{
    $trimmed = isset($text) ? trim($text) : null;
    if ($trimmed === null || $trimmed === '') {
        return null;
    }
    return htmlspecialchars(stripslashes($trimmed), ENT_QUOTES);
}

function toHandleEncoding(?string $text)
{
    return mb_convert_encoding(html_entity_decode($text, ENT_QUOTES), 'ISO-8859-1', 'UTF-8');
}

function randomPassword(int $length): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*?';
    $charLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charLength - 1)];
    }
    return $randomString;
}

function checkPasswordStrength(string $password): bool
{
    $hasUppercase = preg_match('/[A-Z]/', $password);
    $hasLowercase = preg_match('/[a-z]/', $password);
    $hasNumber = preg_match('/\d/', $password);
    $hasSpecialCharacter = preg_match('/[^a-zA-Z\d]/', $password);
    return $hasUppercase && $hasLowercase && $hasNumber && $hasSpecialCharacter;
}

function generateStrongRandomPassword(): string
{
    $strongPassword = false;
    $randomPassword = '';
    $length = random_int(10, 12);
    while (!$strongPassword) {
        $randomPassword = randomPassword($length);
        $strongPassword = checkPasswordStrength($randomPassword);
    }
    return $randomPassword;
}

function toDateRange(string $from, string $to): string
{
    $from = strtotime($from);
    $to = strtotime($to);
    $sameDay = $from === $to;
    $sameYear = date('Y', $from) === date('Y', $to);
    $sameMonth = date('m', $from) === date('m', $to);
    if ($sameDay) {
        return date('F j, Y', $from);
    } elseif ($sameYear && $sameMonth) {
        return date('F j', $from) . '-' . date('j, Y', $to);
    } elseif ($sameYear && !$sameMonth) {
        return date('F j', $from) . ' - ' . date('F j, Y', $to);
    } else {
        return date('F j, Y', $from) . ' - ' . date('F j, Y', $to);
    }
}

function toOrdinal(int $number): string
{
    $ends = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
    if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
        return "{$number}th";
    } else {
        return $number . $ends[$number % 10];
    }
}

function toTruncate(string $text, int $length = 200): string
{
    $text = htmlspecialchars(trim($text), ENT_QUOTES);
    if (mb_strlen($text) > $length) {
        return mb_substr($text, 0, $length) . '...';
    }
    return $text;
}