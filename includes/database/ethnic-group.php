<?php
function indigenous_groups()
{
    $sql = "SELECT eg.`id`, eg.`name`, eg.`category_id`, egc.`name` AS `category_name` 
            FROM `ethnic_groups` AS eg 
            LEFT JOIN `ethnic_group_categories` AS egc ON eg.`category_id` = egc.`id` 
            WHERE eg.`is_indigenous` = 1 
            ORDER BY egc.`id` ASC, eg.`name` ASC";
    return query($sql) ?: [];
}

function ethnic_groups()
{
    $sql = "SELECT eg.`id`, eg.`name`, eg.`category_id`, egc.`name` AS `category_name`, eg.`is_indigenous` 
            FROM `ethnic_groups` AS eg 
            LEFT JOIN `ethnic_group_categories` AS egc ON eg.`category_id` = egc.`id` 
            ORDER BY egc.`id` ASC, eg.`name` ASC";
    return query($sql) ?: [];
}