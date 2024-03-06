<?php
// hrtdms/repository/app.php
restrictPublicAccess(hasHoliday());

$page = $appTitle = 'Division Training Certificate Finder';
$isFullScreen = $enableScripts = true;

if (isset($userId)) {
    redirect(customUri('hrtdms', 'Conducted Trainings'));
}
