<?php
// file_types
function fileTypes()
{
    $result = query("SELECT `id`, `name` FROM `file_types` ORDER BY `id` ASC");
    return is_array($result) ? $result : [];
}

// files, file_types
function fileAttachments($employee_id)
{
    $results = query(
        "SELECT f.id, f.employee_id, t.name AS file_type, f.description, 
            f.file_name, f.file_extension, f.created_at 
        FROM `files` AS f INNER JOIN `file_types` AS t ON f.file_type_id = t.id 
        WHERE f.employee_id = ? ORDER BY f.created_at DESC",
        [$employee_id]
    );
    return is_array($results) ? $results : [];
}

// files
function fileAttachment($employee_id, $file_attachment_id)
{
    return find(
        "SELECT `id`, `employee_id`, `file_type_id`, `description`, `file_name`, `file_extension` FROM `files` WHERE `employee_id` = ? AND `id` = ? LIMIT 1",
        [$employee_id, $file_attachment_id]
    );
}

// files
function createFileAttachment($file_type_id, $description, $file_name, $file_extension, $employee_id)
{
    $data = [
        'employee_id' => $employee_id,
        'file_type_id' => $file_type_id,
        'description' => $description,
        'file_name' => $file_name,
        'file_extension' => $file_extension
    ];
    return insert('files', $data);
}

// files
function updateFileAttachment($file_type_id, $description, $file_name, $file_extension, $employee_id, $file_attachment_id)
{
    $data = [
        'file_type_id' => $file_type_id,
        'description' => $description,
        'file_name' => $file_name,
        'file_extension' => $file_extension
    ];
    return update('files', $data, '`employee_id` = ? AND `id` = ?', [$employee_id, $file_attachment_id]);
}

// files
function deleteFileAttachment($employee_id, $file_attachment_id)
{
    return delete('files', '`employee_id` = ? AND `id` = ?', [$employee_id, $file_attachment_id]);
}

// files
function deleteFileAttachments($employee_id)
{
    return delete('files', '`employee_id` = ?', [$employee_id]);
}