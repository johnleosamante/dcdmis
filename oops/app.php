<?php
// oops/app.php
$code = !isset($_GET['e']) ? http_response_code() : (int) $_GET['e'];
$validCodes = [403, 404, 500];
if (!in_array($code, $validCodes, true)) {
    $code = 500;
}

switch ($code) {
    case '403':
        $file = '403';
        $error = 'Access Denied';
        break;
    case '404':
        $file = '404';
        $error = 'Page Not Found';
        break;
    case '500':
    default:
        $file = '500';
        $error = 'Server Error';
        break;
}

http_response_code($code);
$page = $appTitle = $error;