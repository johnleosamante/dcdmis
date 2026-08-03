<?php
// login/reset/page.php
?>
<div class="col-xl-5 col-lg-5 col-md-8 col-sm-12">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header">
            <h3 class="text-center my-2"><?= $page ?></h3>
        </div>

        <div class="card-body text-center">
            <?php displayLogo(120, 120, '3', uri(), title()) ?>

            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-2">Forgot Your Applicant ID?</h1>

                <p class="mb-4">
                    Enter the email address that you used to register with us below and we will send you the details.
                </p>
            </div>

            <?php messageAlert($showAlert, $message, $success) ?>

            <form action="" method="POST" class="mb-0">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <input class="form-control" id="email" name="email" type="email"
                        placeholder="juan.delacruz@email.com" value="" autofocus required>
                </div>

                <button type="submit" class="btn btn-primary btn-block" name="recover-applicant-id">Submit</button>
            </form>
        </div>

        <div class="card-footer text-center">
            <a class="small" href="<?= uri() . '/hrmis/apply' ?>" title="Proceed to call for applications">Proceed to
                call for applications instead</a>
        </div>
    </div>
</div>