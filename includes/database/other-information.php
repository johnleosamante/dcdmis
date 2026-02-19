<?php
// other_informations
function otherInformation($person_id)
{
    return find("SELECT * FROM `other_informations` WHERE `person_id` = ? LIMIT 1;", [$person_id]);
}

function createOtherInformation($has_third_degree, $has_fourth_degree, $relation_details, $was_guilty, $guilty_details, $was_charged, $date_filed, $case_status, $was_convicted, $conviction_details, $was_separated, $separation_details, $was_candidate, $candidacy_details, $have_resigned, $resignation_details, $is_immigrant, $immigrant_country_id, $is_indigenous, $indigenous_group, $with_disability, $disability, $is_solo_parent, $solo_parent_id, $person_id)
{
    $data = [
        'has_third_degree' => $has_third_degree,
        'has_fourth_degree' => $has_fourth_degree,
        'relation_details' => $relation_details,
        'was_guilty' => $was_guilty,
        'guilty_details' => $guilty_details,
        'was_charged' => $was_charged,
        'date_filed' => $date_filed,
        'case_status' => $case_status,
        'was_convicted' => $was_convicted,
        'conviction_details' => $conviction_details,
        'was_separated' => $was_separated,
        'separation_ddetails' => $separation_details,
        'was_candidate' => $was_candidate,
        'candidacy_details' => $candidacy_details,
        'have_resigned' => $have_resigned,
        'resignation_details' => $resignation_details,
        'is_immigrant' => $is_immigrant,
        'immigrant_country_id' => $immigrant_country_id,
        'is_indigenous' => $is_indigenous,
        'indigenous_group' => $indigenous_group,
        'with_disability' => $with_disability,
        'disability' => $disability,
        'is_solo_parent' => $is_solo_parent,
        'solo_parent_id' => $solo_parent_id,
        'person_id' => $person_id
    ];
    return insert('other_informations', $data);
}

function updateOtherInformation($has_third_degree, $has_fourth_degree, $relation_details, $was_guilty, $guilty_details, $was_charged, $date_filed, $case_status, $was_convicted, $conviction_details, $was_separated, $separation_details, $was_candidate, $candidacy_details, $have_resigned, $resignation_details, $is_immigrant, $immigrant_country_id, $is_indigenous, $indigenous_group, $with_disability, $disability, $is_solo_parent, $solo_parent_id, $person_id)
{
    $data = [
        'has_third_degree' => $has_third_degree,
        'has_fourth_degree' => $has_fourth_degree,
        'relation_details' => $relation_details,
        'was_guilty' => $was_guilty,
        'guilty_details' => $guilty_details,
        'was_charged' => $was_charged,
        'date_filed' => $date_filed,
        'case_status' => $case_status,
        'was_convicted' => $was_convicted,
        'conviction_details' => $conviction_details,
        'was_separated' => $was_separated,
        'separation_ddetails' => $separation_details,
        'was_candidate' => $was_candidate,
        'candidacy_details' => $candidacy_details,
        'have_resigned' => $have_resigned,
        'resignation_details' => $resignation_details,
        'is_immigrant' => $is_immigrant,
        'immigrant_country_id' => $immigrant_country_id,
        'is_indigenous' => $is_indigenous,
        'indigenous_group' => $indigenous_group,
        'with_disability' => $with_disability,
        'disability' => $disability,
        'is_solo_parent' => $is_solo_parent,
        'solo_parent_id' => $solo_parent_id,
    ];
    return update('other_informations', $data, '`person_id` = ?', [$person_id]);
}

function deleteOtherInformation($person_id)
{
    return delete('other_informations', '`person_id` = ?', [$person_id]);
}

// persons, other_informations
function indigenousEmployeeCount()
{
    $sql = "SELECT 
                CASE 
                    WHEN o.`is_indigenous` = 1 AND o.`indigenous_group` > '' 
                    THEN o.`indigenous_group` 
                    ELSE 'No' 
                END AS `name`, 
                COUNT(p.`id`) AS `count` 
            FROM `persons` p 
            LEFT JOIN `other_informations` o ON p.`id` = o.`person_id` 
            WHERE p.`status` = 'Active' GROUP BY `name` ORDER BY `count` DESC";
    return query($sql);
}

function pwdEmployeeCount()
{
    $sql = "SELECT 
                CASE 
                    WHEN o.`with_disability` = 1 AND o.`disability` > '' 
                    THEN o.`disability` 
                    ELSE 'No' 
                END AS `name`, 
                COUNT(p.`id`) AS `count` 
            FROM `persons` p 
            LEFT JOIN `other_informations` o ON p.`id` = o.`person_id` 
            WHERE p.`status` = 'Active' GROUP BY `name` ORDER BY `count` DESC";
    return query($sql);
}

function soloParentEmployeeCount()
{
    $sql = "SELECT 
                CASE WHEN o.`is_solo_parent` = 1 THEN 'Yes' ELSE 'No' END AS `name`, 
                COUNT(p.`id`) AS `count` 
            FROM `persons` p 
            LEFT JOIN `other_informations` o ON p.`id` = o.`person_id` 
            WHERE p.`status` = 'Active' GROUP BY `name` ORDER BY `name` DESC";
    return query($sql);
}