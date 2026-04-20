<?php
$code = sanitize($_GET['p'] ?? '');
?>

<div class="col-12">
    <div class="mt-5 mb-4 text-center">
        <?php displayLogo(120, 120, '0', uri(), title()) ?>
        <h1 class="my-2"><?= e($appTitle) ?></h1>
    </div>

    <div class="text-center py-0">
        <div class="error mx-auto"><i class="fas fa-briefcase fa-fw"></i></div>
        <p class="lead text-gray-800 mt-1 mb-0">Career Opportunities</p>
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12">
                <p class="text-gray-600 px-2 mb-0">Discover career paths in education and administration. Explore
                    current professional openings, review submission guidelines and start your application process
                    today.
                    Become part of our dedicated
                    workforce.</p>
            </div>
        </div>
    </div>

    <?php
    $file = empty($code) ? 'publications.php' : 'publication-details.php';

    require_once($file);
    ?>

    <?php if (isset($userId)): ?>
        <a class="d-block text-center mx-2 mb-5" href="<?= uri() . '/' . $activeApp ?>" title="Go to dashboard">Go to
            Dashboard</a>
    <?php else: ?>
        <a class="d-block text-center mx-2 mb-5" href="<?= uri() . '/login' ?>" title="Go to login page">Already have an
            account? Login instead</a>
    <?php endif ?>
</div>