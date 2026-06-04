<?php
// card_types
function cardTypes()
{
	return query("SELECT `id`, `name` FROM `card_types` ORDER BY `name` ASC");
}

function cardType($card_type_id)
{
	return find("SELECT `name` FROM `card_types` WHERE `id` = ? LIMIT 1", [$card_type_id]);
}

// valid_ids
function employeeIdentification($employee_id)
{
	return find(
		"SELECT `card_type_id`, `id_number`, `place_issued`, `date_issued` 
        FROM `valid_ids` 
        WHERE `employee_id` = ? LIMIT 1",
		[$employee_id]
	);
}

function createIdentification($card_type_id, $id_number, $place_issued, $date_issued, $employee_id)
{
	$data = [
		'card_type_id' => $card_type_id,
		'id_number' => $id_number,
		'place_issued' => $place_issued,
		'date_issued' => $date_issued,
		'employee_id' => $employee_id,
	];
	return insert('valid_ids', $data);
}

function updateIdentification($card_type_id, $id_number, $place_issued, $date_issued, $employee_id)
{
	$data = [
		'card_type_id' => $card_type_id,
		'id_number' => $id_number,
		'place_issued' => $place_issued,
		'date_issued' => $date_issued
	];
	return update('valid_ids', $data, "`employee_id` = ?", [$employee_id]);
}

function deleteIdentification($employee_id)
{
	return delete('valid_ids', '`employee_id` = ?', [$employee_id]);
}