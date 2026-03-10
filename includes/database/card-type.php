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
function employeeIdentification($person_id)
{
	return find(
		"SELECT `card_type_id`, `id_number`, `place_issued`, `date_issued` 
        FROM `valid_ids` 
        WHERE `person_id` = ? LIMIT 1",
		[$person_id]
	);
}

function createIdentification($card_type_id, $id_number, $place_issued, $date_issued, $person_id)
{
	$data = [
		'card_type_id' => $card_type_id,
		'id_number' => $id_number,
		'place_issued' => $place_issued,
		'date_issued' => $date_issued,
		'person_ID' => $person_id,
		'created_at' => date('Y-m-d H:i:s'),
		'updated_at' => date('Y-m-d H:i:s')
	];
	return insert('valid_ids', $data);
}

function updateIdentification($card_type_id, $id_number, $place_issued, $date_issued, $person_id)
{
	$data = [
		'id_number' => $id_number,
		'place_issued' => $place_issued,
		'date_issued' => $date_issued,
		'updated_at' => date('Y-m-d H:i:s')
	];
	return update(
		'valid_ids',
		$data,
		"`person_id` = ? AND `card_type_id` = ?",
		[$person_id, $card_type_id]
	);
}