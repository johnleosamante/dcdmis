<?php
// 201_files
function fileAttachments($person_id)
{
    $results = query(
        "SELECT * FROM `201_files` WHERE `person_id` = ? ORDER BY `created_at` DESC",
        [$person_id]
    );
    return is_array($results) ? $results : [];
}

function fileAttachment($person_id, $file_attachment_id)
{
    return find(
        "SELECT * FROM `201_files` WHERE `person_id` = ? AND `id` = ? LIMIT 1",
        [$person_id, $file_attachment_id]
    );
}

function createFileAttachment($description, $file_name, $file_extension, $person_id)
{
    $data = [
        'person_id' => $person_id,
        'description' => $description,
        'file_name' => $file_name,
        'file_extension' => $file_extension,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    return insert('201_files', $data);
}

function updateFileAttachment($description, $file_name, $file_extension, $person_id, $file_attachment_id)
{
    $data = [
        'description' => $description,
        'file_name' => $file_name,
        'file_extension' => $file_extension,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    return update('201_files', $data, '`person_id` = ? AND `id` = ?', [$person_id, $file_attachment_id]);
}

function deleteFileAttachment($person_id, $file_attachment_id)
{
    return delete('201_files', '`person_id` = ? AND `id` = ?', [$person_id, $file_attachment_id]);
}

function deleteFileAttachments($person_id)
{
    return delete('201_files', '`person_id` = ?', [$person_id]);
}