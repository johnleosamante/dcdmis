<?php
// includes/database/vacancy.php
// vacancies

function vacancy($id) {}

function createVacancy($status, $positionId, $stationId, $psipop, $employeeId, $dateVacated, $reason, $userId)
{
    nonQuery("INSERT INTO `vacancies` (`status`, `position_id`, `station_id`, `psipop`, `employee_id`, `date_vacated`, `reason`, `created_by`, `updated_by`, `created_on`, `updated_on`) VALUES ('{$status}', '{$positionId}', '{$stationId}', '{$psipop}', '{$employeeId}', '{$dateVacated}', '{$reason}', '{$userId}', '{$userId}', NOW(), NOW());");
}

function vacancies($status = 'open')
{
    return query("SELECT `vacancies`.`id`, `vacancies`.`status`, `tbl_job`.`Job_description` AS `position`, `vacancies`.`station_id`, `vacancies`.`psipop`, `vacancies`.`employee_id`, `vacancies`.`date_vacated`, `vacancies`.`reason`, `vacancies`.`created_on`, `vacancies`.`updated_on` FROM `vacancies` INNER JOIN `tbl_job` ON `vacancies`.`position_id` = `tbl_job`.`Job_code` WHERE `status`='{$status}';");
}
