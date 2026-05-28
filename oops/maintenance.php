<?php
// oops/maintenance.php
?>

<div class="col-12">
    <div class="mt-5 mb-4 text-center">
        <?php displayLogo(120, 120, '0', uri(), title()) ?>
    </div>

    <div class="text-center py-0">
        <h1 class="mb-3">System Under Maintenance</h1>

        <div class="error mx-auto"><i class="fas fa-tools fa-fw"></i></div>

        <div class="row justify-content-center mt-3">
            <div class="col-xl-7 col-lg-7 col-md-10 col-sm-12">
                <p class="text-gray-600 px-2 mb-1">We sincerely apologize for the inconvenience. The system is currently
                    undergoing scheduled maintenance and upgrades, but will return shortly.</p>
                <p class="text-gray-600 px-2 mb-0">Thank you for your patience.</p>
            </div>
        </div>

        <a class="d-block text-center mx-2 my-5" href="<?= uri() ?>" title="Go to home page">Go to home page</a>
    </div>
</div>