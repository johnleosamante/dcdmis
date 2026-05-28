<div class="text-center py-0">
    <div class="error mx-auto"><i class="fas fa-check-circle fa-fw"></i></div>
    <p class="lead text-gray-800 mt-1 mb-0">Registration Successful</p>
    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-8 col-md-10 col-sm-12">
            <p class="px-2 mb-2">Thank you for submitting your applicant information. We have received your
                registration.</p>
        </div>
    </div>
</div>

<div class="card mt-3 mb-4 mx-auto col-xl-9 col-lg-8 col-md-10 col-sm-12">
    <div class="card-body text-center">
        <p>A confirmation email has been sent to:</p>
        <p class="text-muted"><strong><?= e($applicant_email) ?></strong></p>
        <p class="mt-2">Get your unique and permanent 18-digit applicant ID in your email (check SPAM or JUNK folder if
            not found
            in inbox) and use it to apply to available vacant positions.
        </p>

        <div class="mt-5">
            <a href="<?= uri() . '/hrmis/apply' ?>" class="btn btn-primary btn-lg">
                View Published Vacant Positions
            </a>
        </div>
    </div>
</div>