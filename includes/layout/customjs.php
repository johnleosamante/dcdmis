<?php

if (isset($_GET['v'])) {
    $v = sanitize(decode($_GET['v']));

    if ($v === 'Project Detail') {
        echo '<script src="' . uri() . '/assets/vendor/toastr/toastr.min.js" type="text/javascript"></script>';
        echo '<script src="' . uri() . '/modules/trainings/modules/program.js?v=' . VERSION . '" type="text/javascript"></script>';
    } elseif ($v === 'Attendance') {
        echo '<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>';
        echo '<script src="' . uri() . '/modules/trainings/modules/activity.js?v=' . VERSION . '" type="text/javascript"></script>';
    } elseif ($v === 'Attendance Summary') {
        echo '<script src="' . uri() . '/assets/vendor/toastr/toastr.min.js" type="text/javascript"></script>';
        echo '<script src="' . uri() . '/modules/trainings/modules/activity.js?v=' . VERSION . '" type="text/javascript"></script>';

        // DataTables Buttons
        echo '<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>';
        echo '<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>';

        // Excel Export
        echo '<script src="' . uri() . '/assets/vendor/datatables-btns/jszip.min.js" type="text/javascript"></script>';

        // HTML5 Export Buttons
        echo '<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>';

        // Print Button
        echo '<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>';
    } elseif ($v === 'Programs') {
        echo '<script src="' . uri() . '/modules/trainings/modules/program.js?v=' . VERSION . '" type="text/javascript"></script>';
    } elseif ($v === 'Conducted Trainings') {
        echo '<script src="' . uri() . '/modules/trainings/modules/program.js?v=' . VERSION . '" type="text/javascript"></script>';
    } elseif ($v === 'Program Detail') {
        echo '<script src="' . uri() . '/assets/vendor/toastr/toastr.min.js" type="text/javascript"></script>';
        echo '<script src="' . uri() . '/modules/trainings/modules/program.js?v=' . VERSION . '" type="text/javascript"></script>';
    }
}
