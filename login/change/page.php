<?php
// login/change/page.php
?>

<div class="col-xl-5 col-lg-5 col-md-8 col-sm-12">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header">
            <h3 class="text-center my-2"><?php echo $page; ?></h3>
        </div>

        <div class="card-body text-center">
            <?php displayLogo(120, 120, '3', uri(), title()); ?>

            <div class="text-left">
                <p class="text-center mb-2">Use a password that has the following: </p>

                <ul>
                    <li>Atleast ten (10) characters long</li>
                    <li>Atleast one (1) uppercase letter</li>
                    <li>Atleast one (1) lowercase letter</li>
                    <li>Atleast one (1) number</li>
                    <li>Atleast one (1) special character</li>
                </ul>
            </div>

            <?php messageAlert($showAlert, $message, $success); ?>

            <form action="" method="POST" class="text-left mt-3">
                <div class="form-group">
                    <label for="email-address" class="font-weight-bold mb-1">Email Address</label>
                    <input id="email-address" type="text" class="form-control border-right-0" value="<?php echo $email; ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="password" class="font-weight-bold mb-1">New Password <?php showAsterisk(); ?></label>
                    <div class="input-group">
                        <input id="password" name="password" type="password" class="form-control border-right-0" value="<?php echo $password; ?>" required>
                        <div class="input-group-append">
                            <button type="button" id="eye-toggle" class="input-group-text border-left-0 bg-white">
                                <i id="eye" class="small fas fa-eye fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="font-weight-bold mb-1">Confirm New Password <?php showAsterisk(); ?></label>
                    <div class="input-group">
                        <input id="password-confirm" name="password-confirm" type="password" class="form-control border-right-0" value="<?php echo $passwordConfirm; ?>" required>
                        <div class="input-group-append">
                            <button type="button" id="eye-confirm-toggle" class="input-group-text border-left-0 bg-white">
                                <i id="eye-confirm" class="small fas fa-eye fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <?php requiredLegend(); ?>

                <button type="submit" class="btn btn-primary btn-block" name="change-password">Change Password</button>
            </form>
        </div>
    </div>
</div>