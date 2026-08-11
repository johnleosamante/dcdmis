<?php
// religions
function religions()
{
    return query("SELECT `id`, `name` FROM `religion` ORDER BY `name` ASC") ?: [];
}

function religion($religion_id)
{
    if (empty($religion_id)) {
        return null;
    }
    return find("SELECT `id`, `name` FROM `religion` WHERE `id` = ? LIMIT 1", [$religion_id]);
}