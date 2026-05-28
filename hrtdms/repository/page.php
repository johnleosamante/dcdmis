<?php
// hrtdms/repository/page.php
if (!MAINTENANCE_MODE) {
    ?>
    <div class="col-12">
        <div class="mt-5 mb-4 text-center">
            <?php displayLogo(120, 120, '0', uri(), title()) ?>
            <h1 class="my-2"><?= e($appTitle) ?></h1>
        </div>

        <div class="text-center py-0">
            <div class="error mx-auto"><i class="fas fa-search fa-fw"></i></div>
            <p class="lead text-gray-800 mt-1 mb-0">Search trainings</p>
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12">
                    <p class="text-gray-600 px-2 mb-0">View completed workshops and training sessions conducted by the
                        schools
                        division. Instantly access and download training attendees' professional development credentials.
                    </p>
                </div>
            </div>
        </div>

        <div class="card mt-3 mb-4 mx-auto">
            <?php
            if (!isset($url) || $url === 'conducted-trainings') {
                $file = 'conducted-trainings.php';
            } else {
                switch ($url) {
                    case 'Training Details':
                        $file = 'training-details.php';
                        break;
                    case '404':
                    default:
                        $file = 'conducted-trainings.php';
                        break;
                }
            }

            require_once("{$file}");
            ?>
        </div>

        <?php if (isset($userId)): ?>
            <a class="d-block text-center mx-2 mb-5" href="<?= uri() . '/' . $activeApp ?>" title="Go to dashboard">Go to
                Dashboard</a>
        <?php else: ?>
            <a class="d-block text-center mx-2 mb-5" href="<?= uri() . '/login' ?>" title="Go to login page">Already have an
                account? Login instead</a>
        <?php endif ?>
    </div>
<?php } else {
    require_once(root() . 'oops/maintenance.php');
} ?>