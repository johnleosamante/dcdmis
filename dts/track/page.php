<?php
// dts/track/page.php
?>
<div class="col-12">
    <div class="mt-5 mb-4 text-center">
        <?php displayLogo(120, 120, '0', uri(), title()) ?>
        <h1 class="my-2"><?= e($appTitle) ?></h1>
    </div>

    <?php
    $file = !isset($url) || $url === 'track-document' ?
        'track-document.php' :
        match ($url) {
            'Document Information' => 'document-information.php',
            default => 'track-document.php'
        };

    require_once("{$file}");
    ?>

    <a class="d-block text-center mx-2 mb-5" href="<?= uri() . '/login' ?>" title="Go to login page">Already have an
        account? Login instead</a>
</div>