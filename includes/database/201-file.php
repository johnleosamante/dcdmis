<?php
// files
function fileAttachments($employee_id)
{
    $results = query(
        "SELECT `id`, `employee_id`, `file_type_id`, `description`, `file_name`, `file_extension`, `created_at` FROM `files` WHERE `employee_id` = ? ORDER BY `created_at` DESC",
        [$employee_id]
    );
    return is_array($results) ? $results : [];
}

function fileAttachment($employee_id, $file_attachment_id)
{
    return find(
        "SELECT `id`, `employee_id`, `file_type_id`, `description`, `file_name`, `file_extension`, `created_at` FROM `files` WHERE `employee_id` = ? AND `id` = ? LIMIT 1",
        [$employee_id, $file_attachment_id]
    );
}

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

function deleteFileAttachment($employee_id, $file_attachment_id)
{
    return delete('files', '`employee_id` = ? AND `id` = ?', [$employee_id, $file_attachment_id]);
}

function deleteFileAttachments($employee_id)
{
    return delete('files', '`employee_id` = ?', [$employee_id]);
}

function fileTypes()
{
    $result = query("SELECT `id`, `name` FROM `file_types` ORDER BY `id` ASC");
    return is_array($result) ? $result : [];
}