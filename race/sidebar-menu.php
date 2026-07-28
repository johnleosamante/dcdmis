<?php
// race/sidebar-menu.php
sidebarDivider();
sidebarHeading('Rewards & Recognition');

$nominatorOnly = isNominatorOnly($userId);
$countSchedules = number_format(count(awardSchedules()));
$countAwards = number_format(count(recognitionAwardsWithCategory()));
$countNominees = number_format(count(allNominees()));
$countWinners = number_format(count(awardWinners()));

if ($isICT || !$nominatorOnly):
    sidebarMenuItem(customUri('race', 'Event Schedules'), 'Schedules', 'fa-calendar-plus', isset($url) && str_contains($url, 'Event Schedules'), $countSchedules);
endif;

sidebarMenuItem(customUri('race', 'Nominees List'), 'Nominees', 'fa-user', isset($url) && str_contains($url, 'Nominees List'), $countNominees);
sidebarMenuItem(customUri('race', 'Awards List'), 'Awards', 'fa-award', isset($url) && str_contains($url, 'Awards List'), $countAwards);

if ($isICT || !$nominatorOnly):
    sidebarMenuItem(customUri('race', 'Ranking'), 'Ranking', 'fa-chart-bar', isset($url) && str_contains($url, 'Ranking'), number_format(count(awardsWithNominees())));
    sidebarMenuItem(customUri('race', 'Winners Lookup'), 'Winners', 'fa-trophy', isset($url) && str_contains($url, 'Winners Lookup'), $countWinners);
endif;