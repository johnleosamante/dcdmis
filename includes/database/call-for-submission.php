<?php
// includes/database/call-for-submission.php

function callForSubmissions()
{
    return query(
        "SELECT cfs.*, CONCAT(e.`last_name`, ', ', e.`first_name`, ' ', COALESCE(e.`middle_name`, '')) AS created_by_name
         FROM `call_for_submissions` cfs
         LEFT JOIN `employees` e ON cfs.`created_by` = e.`id`
         ORDER BY cfs.`created_at` DESC"
    );
}

function callForSubmission($id)
{
    return find(
        "SELECT cfs.*, CONCAT(e.`last_name`, ', ', e.`first_name`, ' ', COALESCE(e.`middle_name`, '')) AS created_by_name
         FROM `call_for_submissions` cfs
         LEFT JOIN `employees` e ON cfs.`created_by` = e.`id`
         WHERE cfs.`id` = ? LIMIT 1",
        [$id]
    );
}

function activeCallForSubmissions()
{
    return query(
        "SELECT cfs.*, CONCAT(e.`last_name`, ', ', e.`first_name`, ' ', COALESCE(e.`middle_name`, '')) AS created_by_name
         FROM `call_for_submissions` cfs
         LEFT JOIN `employees` e ON cfs.`created_by` = e.`id`
         WHERE cfs.`due_date` >= CURDATE() OR cfs.`due_date` IS NULL
         ORDER BY cfs.`due_date` ASC, cfs.`created_at` DESC"
    );
}

function createCallForSubmission($title, $description, $schoolYear, $dueDate, $createdBy)
{
    return insert('call_for_submissions', [
        'title' => $title,
        'description' => $description,
        'school_year' => $schoolYear,
        'due_date' => $dueDate ?: null,
        'created_by' => $createdBy,
        'updated_by' => $createdBy,
    ]);
}

function updateCallForSubmission($id, $title, $description, $schoolYear, $dueDate, $updatedBy)
{
    return update('call_for_submissions', [
        'title' => $title,
        'description' => $description,
        'school_year' => $schoolYear,
        'due_date' => $dueDate ?: null,
        'updated_by' => $updatedBy,
    ], '`id` = ?', [$id]);
}

function deleteCallForSubmission($id)
{
    return delete('call_for_submissions', '`id` = ?', [$id]);
}

function closeCallForSubmission($id, $updatedBy)
{
    return update('call_for_submissions', [
        'is_closed' => '1',
        'updated_by' => $updatedBy,
    ], '`id` = ?', [$id]);
}

function reopenCallForSubmission($id, $updatedBy)
{
    return update('call_for_submissions', [
        'is_closed' => '0',
        'updated_by' => $updatedBy,
    ], '`id` = ?', [$id]);
}

function programSubmissions($callForSubmissionId)
{
    return query(
        "SELECT ps.*, sc.`name` AS school_name,
                CONCAT(e.`last_name`, ', ', e.`first_name`, ' ', COALESCE(e.`middle_name`, '')) AS submitted_by_name
         FROM `program_submissions` ps
         LEFT JOIN `schools` sc ON ps.`school_id` = sc.`id`
         LEFT JOIN `employees` e ON ps.`created_by` = e.`id`
         WHERE ps.`call_for_submission_id` = ?
         ORDER BY ps.`created_at` DESC",
        [$callForSubmissionId]
    );
}

function programSubmission($id)
{
    return find(
        "SELECT ps.*, sc.`name` AS school_name,
                CONCAT(e.`last_name`, ', ', e.`first_name`, ' ', COALESCE(e.`middle_name`, '')) AS submitted_by_name
         FROM `program_submissions` ps
         LEFT JOIN `schools` sc ON ps.`school_id` = sc.`id`
         LEFT JOIN `employees` e ON ps.`created_by` = e.`id`
         WHERE ps.`id` = ? LIMIT 1",
        [$id]
    );
}

function programSubmissionBySchool($callForSubmissionId, $schoolId)
{
    return find(
        "SELECT * FROM `program_submissions`
         WHERE `call_for_submission_id` = ? AND `school_id` = ? LIMIT 1",
        [$callForSubmissionId, $schoolId]
    );
}

function createProgramSubmission($callForSubmissionId, $schoolId, $description, $createdBy)
{
    return insert('program_submissions', [
        'call_for_submission_id' => $callForSubmissionId,
        'school_id' => $schoolId,
        'description' => $description,
        'created_by' => $createdBy,
        'updated_by' => $createdBy,
    ]);
}

function updateProgramSubmission($id, $description, $updatedBy)
{
    return update('program_submissions', [
        'description' => $description,
        'updated_by' => $updatedBy,
    ], '`id` = ?', [$id]);
}

function deleteProgramSubmission($id)
{
    return delete('program_submissions', '`id` = ?', [$id]);
}

function countProgramSubmissions($callForSubmissionId)
{
    $result = find(
        "SELECT COUNT(*) AS `count` FROM `program_submissions` WHERE `call_for_submission_id` = ?",
        [$callForSubmissionId]
    );
    return (int) ($result['count'] ?? 0);
}

function programSubmissionAttachments($programSubmissionId)
{
    return query(
        "SELECT * FROM `program_submission_attachments`
         WHERE `program_submission_id` = ?
         ORDER BY `created_at` ASC",
        [$programSubmissionId]
    );
}

function programSubmissionAttachment($id)
{
    return find(
        "SELECT * FROM `program_submission_attachments` WHERE `id` = ? LIMIT 1",
        [$id]
    );
}

function createProgramSubmissionAttachment($programSubmissionId, $fileName, $fileExtension)
{
    return insert('program_submission_attachments', [
        'program_submission_id' => $programSubmissionId,
        'file_name' => $fileName,
        'file_extension' => $fileExtension,
    ]);
}

function deleteProgramSubmissionAttachment($id)
{
    return delete('program_submission_attachments', '`id` = ?', [$id]);
}

function deleteAllProgramSubmissionAttachments($programSubmissionId)
{
    return delete('program_submission_attachments', '`program_submission_id` = ?', [$programSubmissionId]);
}
