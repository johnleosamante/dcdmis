<?php
// includes/database/vacancy.php
// vacancies

function vacancy($id)
{
    return query("SELECT `id`, `status`, `position_id`, `station_id`, `psipop` AS `item_number`, `employee_id`, `date_vacated`, `reason`, `created_on`, `updated_on` FROM `vacancies` WHERE `id`='{$id}';");
}

function doesItemNumberExist($itemNumber)
{
    return numRows(query("SELECT `id` FROM `vacancies` WHERE `psipop`='{$itemNumber}' LIMIT 1;")) > 0;
}

function createVacancy($status, $positionId, $stationId, $psipop, $employeeId, $dateVacated, $reason, $userId)
{
    nonQuery("INSERT INTO `vacancies` (`status`, `position_id`, `station_id`, `psipop`, `employee_id`, `date_vacated`, `reason`, `created_by`, `updated_by`, `created_on`, `updated_on`) VALUES ('{$status}', '{$positionId}', '{$stationId}', '{$psipop}', '{$employeeId}', '{$dateVacated}', '{$reason}', '{$userId}', '{$userId}', NOW(), NOW());");
}

function updateVacancy($id, $status, $positionId, $stationId, $itemNumber, $dateVacated, $reason, $userId)
{
    nonQuery("UPDATE `vacancies` SET `status`='{$status}', `position_id`='{$positionId}', `station_id`='{$stationId}', `psipop`='{$itemNumber}', `date_vacated`='{$dateVacated}', `reason`='{$reason}', `updated_by`='{$userId}', `updated_on`=NOW() WHERE `id`='{$id}';");
}

function updateFilledVacancy($id, $userId) {}

function vacancies($status = 'open')
{
    return query("SELECT `vacancies`.`id`, `vacancies`.`status`, `tbl_job`.`Job_description` AS `position`, `vacancies`.`station_id`, `vacancies`.`psipop`, `vacancies`.`employee_id`, `vacancies`.`date_vacated`, `vacancies`.`reason`, `vacancies`.`created_on`, `vacancies`.`updated_on` FROM `vacancies` INNER JOIN `tbl_job` ON `vacancies`.`position_id` = `tbl_job`.`Job_code` WHERE `status`='{$status}';");
}

function publications()
{
    return query("SELECT * FROM `vacancy_publications`;");
}
