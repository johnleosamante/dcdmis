<?php
// countries
function countries()
{
    return query("SELECT `id`, `name` FROM `countries` ORDER BY `name` ASC");
}

function country($country_id)
{
    return find("SELECT `id`, `name` FROM `countries` WHERE `id` = ? LIMIT 1", [$country_id]);
}

// citizenships
function citizenships()
{
    return query("SELECT `id`, `country_id`, `name` FROM `citizenships` ORDER BY `name` ASC");
}

function citizenship($citizenship_id)
{
    return find("SELECT `id`, `country_id`, `name` FROM `citizenships` WHERE `id` = ? LIMIT 1", [$citizenship_id]);
}