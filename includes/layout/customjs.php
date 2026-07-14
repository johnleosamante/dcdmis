<?php

if (isset($_GET['v'])) {
    $v = base64_decode($_GET['v']);

    if ($v === 'Courses') {
        echo ' <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>';
        echo '<script src="' . uri() . '/modules/courses/course.js" type="text/javascript"></script>';
    } else if ($v === 'Activity') {
        echo ' <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>';
        echo '<script src="' . uri() . '/modules/lnd-activity/activity.js" type="text/javascript"></script>';
        echo '<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>';
    } else if ($v === 'ProjectDetail') {
        echo '<script src="' . uri() . '/modules/lnd-activity/activity.js" type="text/javascript"></script>';
    } else if ($v === 'Add Attendance') {
        echo '<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>';
        echo '<script src="' . uri() . '/modules/trainings/modules/activity.js" type="text/javascript"></script>';
    } else if ($v === 'Attendance Summary') {
        echo '<script src="' . uri() . '/assets/vendor/toastr/toastr.min.js" type="text/javascript"></script>';
        echo '<script src="' . uri() . '/modules/trainings/modules/activity.js" type="text/javascript"></script>';

        // DataTables Buttons
        echo '<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>';
        echo '<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>';

        // Excel Export
        echo '<script src="' . uri() . '/assets/vendor/datatables-btns/jszip.min.js" type="text/javascript"></script>';

        // HTML5 Export Buttons
        echo '<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>';

        // Print Button
        echo '<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>';
    } else if ($v === 'Programs') {
        echo '<script src="' . uri() . '/modules/trainings/modules/program.js" type="text/javascript"></script>';
    } else if ($v === 'Conducted Trainings') {
        echo '<script src="' . uri() . '/modules/trainings/modules/program.js" type="text/javascript"></script>';
    } else if ($v === 'Program Detail') {
        echo '<script src="' . uri() . '/assets/vendor/toastr/toastr.min.js" type="text/javascript"></script>';
        echo '<script src="' . uri() . '/modules/trainings/modules/program.js" type="text/javascript"></script>';
    }
    if ($v === 'Rewards') {
        echo '<script src="' . uri() . '/modules/rewards/reward.js" type="text/javascript"></script>';
    }
}