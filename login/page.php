<?php
// login/page.php
if (!MAINTENANCE_MODE) {
    require_once('services.php'); ?>
    <div id="login-panel" class="col-xl-4 col-lg-4 col-md-5 col-sm-12">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-header">
                <h3 class="text-center my-2"><?= e($page) ?></h3>
            </div>

            <div class="card-body text-center">
                <?php
                displayLogo(120, 120, '3', uri(), title());
                messageAlert($showAlert, $message, $success);
                ?>

                <form action="" method="POST" class="text-left">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="email" class="font-weight-bold mb-1">Email Address</label>
                        <input class="form-control" id="email" name="email" type="email"
                            placeholder="juan.delacruz@deped.gov.ph" autofocus required>
                    </div>

                    <div class="form-group">
                        <label for="password" class="font-weight-bold mb-1">Password</label>
                        <div class="input-group">
                            <input class="form-control border-right-0" id="password" name="password" type="password"
                                placeholder="Password" required>
                            <div class="input-group-append">
                                <button type="button" id="eye-toggle" class="input-group-text border-left-0 bg-white">
                                    <i id="eye" class="small fas fa-eye fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                            <label class="custom-control-label pt-1" for="remember">Remember me</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block" name="login">Login</button>
                </form>
            </div>

            <div class="card-footer text-center">
                <a class="small" href="<?php echo uri() . '/login/reset'; ?>" title="Reset your forgotten password">Forgot
                    your password?</a>
            </div>
        </div>
    </div>
<?php } else {
    require_once(root() . '/oops/maintenance.php');
} ?>