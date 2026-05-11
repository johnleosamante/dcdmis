<?php
// includes/layout/theme-page.php
require_once('app.php');

$url = isset($_GET['v']) ? sanitize(decode($_GET['v'])) : null;

$page = http_response_code() === 200 ?
    isset($url) && !empty($url) ? "{$url} | {$appTitle}" : $appTitle :
    match (http_response_code()) {
        403 => 'Access Denied',
        404 => 'Page Not Found',
        default => 'Unexpected Error'
    };

require_once(root() . '/includes/layout/components.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once(root() . '/includes/layout/header.php') ?>
    <?php if ($enableScripts): ?>
        <link rel="stylesheet" href="<?= uri() ?>/assets/vendor/datatables/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="<?= uri() ?>/assets/vendor/datatables-responsive/css/responsive.bootstrap4.min.css">
    <?php endif ?>
</head>

<body id="page-top" class="background-cover">
    <div id="layout">
        <div id="layout-content" class="container-xl">
            <div id="main-content" class="row justify-content-center">
                <?php require_once('page.php') ?>
            </div>
        </div>

        <div id="layout-footer">
            <?php require_once(root() . '/includes/layout/footer.php') ?>
        </div>
    </div>

    <?php scrollToTop() ?>

    <script src="<?= uri() ?>/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= uri() ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= uri() ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?= uri() ?>/assets/js/sb-admin-2.min.js"></script>

    <?php if ($enableScripts): ?>
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js" integrity="sha384-Udt767MMeKelGRBxaCfxX88YDLbViYdQ7T/gkRoB197Jf+OviZ+lsaRAOpS/MIjf" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js" integrity="sha384-vCX+UFRnh1Gp0hr9dL82snXI1HvdBaApGHMjbewoGQ69VkYcHt9jvTy+Q4CAWwPX" crossorigin="anonymous"></script>
        <script src="<?= uri() ?>/assets/vendor/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?= uri() ?>/assets/vendor/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <?php endif ?>

    <script src="<?= uri() ?>/assets/js/script.js?v=1.2.3"></script>
</body>

</html>