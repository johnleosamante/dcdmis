<?php
// includes/database/call-for-submission.php

function canManageCallForSubmissions($userId, $stationId, $code = null): bool
{
    if (empty($userId) || (string) $stationId !== (string) DIVISION_ID) {
        return false;
    }

    if ($code === 'ADS') {
        return true;
    }

    if (function_exists('employeeSection')) {
        $sec = employeeSection($userId);
        if (($sec['id'] ?? null) === 'ADS') {
            return true;
        }
    }

    if (function_exists('userRole') && userRole($userId, 'ADS')) {
        return true;
    }

    if (function_exists('position')) {
        $posId = position($userId)['position_id'] ?? null;
        if (in_array($posId, ['ASDS', 'SDS'], true)) {
            return true;
        }
    }

    return false;
}

// ========== Call for Submissions (`call_for_submissions`) ==========

function callForSubmissions(): array
{
    $rows = query(
        "SELECT cfs.*, CONCAT(
                e.`last_name`,
                ', ',
                e.`first_name`,
                IF(e.`middle_name` IS NOT NULL AND TRIM(e.`middle_name`) != '', CONCAT(' ', LEFT(e.`middle_name`, 1), '.'), '')
            ) AS `created_by_name`
         FROM `call_for_submissions` cfs
         LEFT JOIN `employees` e ON cfs.`created_by` = e.`id`
         ORDER BY cfs.`created_at` DESC"
    );

    return is_array($rows) ? $rows : [];
}

function callForSubmission($id)
{
    if (empty($id)) {
        return false;
    }

    return find(
        "SELECT cfs.*, CONCAT(
                e.`last_name`,
                ', ',
                e.`first_name`,
                IF(e.`middle_name` IS NOT NULL AND TRIM(e.`middle_name`) != '', CONCAT(' ', LEFT(e.`middle_name`, 1), '.'), '')
            ) AS `created_by_name`
         FROM `call_for_submissions` cfs
         LEFT JOIN `employees` e ON cfs.`created_by` = e.`id`
         WHERE cfs.`id` = ? LIMIT 1",
        [$id]
    );
}

function activeCallForSubmissions(): array
{
    $rows = query(
        "SELECT cfs.*, CONCAT(
                e.`last_name`,
                ', ',
                e.`first_name`,
                IF(e.`middle_name` IS NOT NULL AND TRIM(e.`middle_name`) != '', CONCAT(' ', LEFT(e.`middle_name`, 1), '.'), '')
            ) AS `created_by_name`
         FROM `call_for_submissions` cfs
         LEFT JOIN `employees` e ON cfs.`created_by` = e.`id`
         WHERE (cfs.`due_date` >= CURDATE() OR cfs.`due_date` IS NULL) AND cfs.`is_closed` = 0
         ORDER BY cfs.`due_date` ASC, cfs.`created_at` DESC"
    );

    return is_array($rows) ? $rows : [];
}

function createCallForSubmission($title, $description, $schoolYear, $dueDate, $createdBy)
{
    return insert('call_for_submissions', [
        'title' => $title,
        'description' => $description !== '' ? $description : null,
        'school_year' => $schoolYear,
        'due_date' => !empty($dueDate) ? $dueDate : null,
        'is_closed' => 0,
        'created_by' => $createdBy,
        'updated_by' => $createdBy,
    ]);
}

function updateCallForSubmission($id, $title, $description, $schoolYear, $dueDate, $updatedBy)
{
    return update('call_for_submissions', [
        'title' => $title,
        'description' => $description !== '' ? $description : null,
        'school_year' => $schoolYear,
        'due_date' => !empty($dueDate) ? $dueDate : null,
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
        'is_closed' => 1,
        'updated_by' => $updatedBy,
    ], '`id` = ?', [$id]);
}

function reopenCallForSubmission($id, $updatedBy)
{
    return update('call_for_submissions', [
        'is_closed' => 0,
        'updated_by' => $updatedBy,
    ], '`id` = ?', [$id]);
}

// ========== Call Submissions (`call_submissions`) ==========

function callSubmissions($callId): array
{
    $rows = query(
        "SELECT cs.*,
                cs.`call_id` AS `call_for_submission_id`,
                sc.`name` AS `school_name`,
                sc.`alias` AS `school_alias`,
                sc.`head_id` AS `school_head_id`,
                CONCAT(
                    e.`last_name`,
                    ', ',
                    e.`first_name`,
                    IF(e.`middle_name` IS NOT NULL AND TRIM(e.`middle_name`) != '', CONCAT(' ', LEFT(e.`middle_name`, 1), '.'), '')
                ) AS `submitted_by_name`
         FROM `call_submissions` cs
         LEFT JOIN `schools` sc ON cs.`school_id` = sc.`id`
         LEFT JOIN `employees` e ON sc.`head_id` = e.`id`
         WHERE cs.`call_id` = ?
         ORDER BY cs.`updated_at` DESC, cs.`created_at` DESC",
        [$callId]
    );

    return is_array($rows) ? $rows : [];
}

function programSubmissions($callId): array
{
    return callSubmissions($callId);
}

function callSubmission($id)
{
    if (empty($id)) {
        return false;
    }

    return find(
        "SELECT cs.*,
                cs.`call_id` AS `call_for_submission_id`,
                sc.`name` AS `school_name`,
                sc.`alias` AS `school_alias`,
                sc.`head_id` AS `school_head_id`,
                cfs.`title` AS `call_title`,
                cfs.`school_year` AS `call_school_year`,
                cfs.`due_date` AS `call_due_date`,
                cfs.`is_closed` AS `call_is_closed`,
                cfs.`description` AS `call_description`,
                CONCAT(
                    e.`last_name`,
                    ', ',
                    e.`first_name`,
                    IF(e.`middle_name` IS NOT NULL AND TRIM(e.`middle_name`) != '', CONCAT(' ', LEFT(e.`middle_name`, 1), '.'), '')
                ) AS `submitted_by_name`
         FROM `call_submissions` cs
         LEFT JOIN `schools` sc ON cs.`school_id` = sc.`id`
         LEFT JOIN `call_for_submissions` cfs ON cs.`call_id` = cfs.`id`
         LEFT JOIN `employees` e ON sc.`head_id` = e.`id`
         WHERE cs.`id` = ? LIMIT 1",
        [$id]
    );
}

function programSubmission($id)
{
    return callSubmission($id);
}

function callSubmissionBySchool($callId, $schoolId)
{
    return find(
        "SELECT cs.*,
                cs.`call_id` AS `call_for_submission_id`,
                sc.`name` AS `school_name`,
                sc.`alias` AS `school_alias`,
                sc.`head_id` AS `school_head_id`,
                CONCAT(
                    e.`last_name`,
                    ', ',
                    e.`first_name`,
                    IF(e.`middle_name` IS NOT NULL AND TRIM(e.`middle_name`) != '', CONCAT(' ', LEFT(e.`middle_name`, 1), '.'), '')
                ) AS `submitted_by_name`
         FROM `call_submissions` cs
         LEFT JOIN `schools` sc ON cs.`school_id` = sc.`id`
         LEFT JOIN `employees` e ON sc.`head_id` = e.`id`
         WHERE cs.`call_id` = ? AND cs.`school_id` = ? LIMIT 1",
        [$callId, $schoolId]
    );
}

function programSubmissionBySchool($callId, $schoolId)
{
    return callSubmissionBySchool($callId, $schoolId);
}

function createCallSubmission($callId, $schoolId)
{
    return insert('call_submissions', [
        'call_id' => $callId,
        'school_id' => $schoolId,
    ]);
}

function touchCallSubmission($id)
{
    return query(
        "UPDATE `call_submissions` SET `updated_at` = CURRENT_TIMESTAMP WHERE `id` = ?",
        [$id]
    );
}

function deleteCallSubmission($id)
{
    return delete('call_submissions', '`id` = ?', [$id]);
}

function deleteProgramSubmission($id)
{
    return deleteCallSubmission($id);
}

function countCallSubmissions($callId): int
{
    $result = find(
        "SELECT COUNT(*) AS `count` FROM `call_submissions` WHERE `call_id` = ?",
        [$callId]
    );
    return (int) ($result['count'] ?? 0);
}

function countProgramSubmissions($callId): int
{
    return countCallSubmissions($callId);
}

function countCallAttachments($callId): int
{
    $result = find(
        "SELECT COUNT(csa.`id`) AS `count`
         FROM `call_submission_attachments` csa
         INNER JOIN `call_submissions` cs ON csa.`submission_id` = cs.`id`
         WHERE cs.`call_id` = ?",
        [$callId]
    );
    return (int) ($result['count'] ?? 0);
}

function countCallProjects($callId): int
{
    $result = find(
        "SELECT COUNT(csp.`id`) AS `count`
         FROM `call_submission_projects` csp
         INNER JOIN `call_submissions` cs ON csp.`submission_id` = cs.`id`
         WHERE cs.`call_id` = ?",
        [$callId]
    );
    return (int) ($result['count'] ?? 0);
}

// ========== Call Submission Attachments (`call_submission_attachments`) ==========

function callSubmissionAttachments($submissionId): array
{
    $rows = query(
        "SELECT csa.*,
                sat.`name` AS `attachment_type_name`,
                sat.`description` AS `attachment_type_description`
         FROM `call_submission_attachments` csa
         LEFT JOIN `submission_attachment_types` sat ON csa.`attachment_type_id` = sat.`id`
         WHERE csa.`submission_id` = ?
         ORDER BY csa.`attachment_type_id` ASC, csa.`created_at` ASC",
        [$submissionId]
    );

    return is_array($rows) ? $rows : [];
}

function programSubmissionAttachments($submissionId): array
{
    return callSubmissionAttachments($submissionId);
}

function callSubmissionAttachment($id)
{
    if (empty($id)) {
        return false;
    }

    return find(
        "SELECT csa.*,
                sat.`name` AS `attachment_type_name`,
                cs.`call_id`,
                cs.`school_id`,
                cfs.`is_closed` AS `call_is_closed`,
                cfs.`title` AS `call_title`
         FROM `call_submission_attachments` csa
         LEFT JOIN `submission_attachment_types` sat ON csa.`attachment_type_id` = sat.`id`
         LEFT JOIN `call_submissions` cs ON csa.`submission_id` = cs.`id`
         LEFT JOIN `call_for_submissions` cfs ON cs.`call_id` = cfs.`id`
         WHERE csa.`id` = ? LIMIT 1",
        [$id]
    );
}

function programSubmissionAttachment($id)
{
    return callSubmissionAttachment($id);
}

function createCallSubmissionAttachment($submissionId, $attachmentTypeId, $description, $fileName, $fileExtension)
{
    return insert('call_submission_attachments', [
        'submission_id' => $submissionId,
        'attachment_type_id' => $attachmentTypeId,
        'description' => mb_substr((string) ($description ?? ''), 0, 255),
        'file_name' => $fileName,
        'file_extension' => mb_substr(ltrim((string) $fileExtension, '.'), 0, 5),
    ]);
}

function createProgramSubmissionAttachment($submissionId, $attachmentTypeId, $description, $fileName = null, $fileExtension = null)
{
    return createCallSubmissionAttachment($submissionId, $attachmentTypeId, $description, $fileName, $fileExtension);
}

function deleteCallSubmissionAttachment($id)
{
    return delete('call_submission_attachments', '`id` = ?', [$id]);
}

function deleteProgramSubmissionAttachment($id)
{
    return deleteCallSubmissionAttachment($id);
}

function deleteAllCallSubmissionAttachments($submissionId)
{
    return delete('call_submission_attachments', '`submission_id` = ?', [$submissionId]);
}

function deleteAllProgramSubmissionAttachments($submissionId)
{
    return deleteAllCallSubmissionAttachments($submissionId);
}

function countCallSubmissionAttachments($submissionId): int
{
    $result = find(
        "SELECT COUNT(*) AS `count` FROM `call_submission_attachments` WHERE `submission_id` = ?",
        [$submissionId]
    );
    return (int) ($result['count'] ?? 0);
}

function countProgramSubmissionAttachments($submissionId): int
{
    return countCallSubmissionAttachments($submissionId);
}

// ========== Attachment Types (`submission_attachment_types`) ==========

function submissionAttachmentTypes(): array
{
    $rows = query("SELECT `id`, `name`, `description` FROM `submission_attachment_types` ORDER BY `id` ASC");
    return is_array($rows) ? $rows : [];
}

function submissionAttachmentType($id)
{
    return find("SELECT `id`, `name`, `description` FROM `submission_attachment_types` WHERE `id` = ? LIMIT 1", [$id]);
}

// ========== Project Agendas (`project_agendas`) ==========

function projectAgendas(): array
{
    $rows = query("SELECT `id`, `name`, `description` FROM `project_agendas` ORDER BY `id` ASC");
    return is_array($rows) ? $rows : [];
}

function projectAgenda($id)
{
    return find("SELECT `id`, `name`, `description` FROM `project_agendas` WHERE `id` = ? LIMIT 1", [$id]);
}

// ========== Call Submission Projects (`call_submission_projects`) ==========

function callSubmissionProjects($submissionId): array
{
    $rows = query(
        "SELECT csp.*,
                pa.`name` AS `agenda_name`,
                pa.`description` AS `agenda_description`,
                CONCAT(
                    e.`last_name`,
                    ', ',
                    e.`first_name`,
                    IF(e.`middle_name` IS NOT NULL AND TRIM(e.`middle_name`) != '', CONCAT(' ', LEFT(e.`middle_name`, 1), '.'), '')
                ) AS `created_by_name`
         FROM `call_submission_projects` csp
         LEFT JOIN `project_agendas` pa ON csp.`agenda_id` = pa.`id`
         LEFT JOIN `employees` e ON csp.`created_by` = e.`id`
         WHERE csp.`submission_id` = ?
         ORDER BY csp.`created_at` ASC",
        [$submissionId]
    );

    return is_array($rows) ? $rows : [];
}

function submissionProjects($submissionId): array
{
    return callSubmissionProjects($submissionId);
}

function callSubmissionProject($id)
{
    if (empty($id)) {
        return false;
    }

    return find(
        "SELECT csp.*,
                pa.`name` AS `agenda_name`,
                pa.`description` AS `agenda_description`,
                cs.`call_id`,
                cs.`call_id` AS `call_for_submission_id`,
                cs.`school_id`,
                sc.`name` AS `school_name`,
                cfs.`title` AS `call_title`,
                cfs.`school_year` AS `call_school_year`,
                cfs.`due_date` AS `call_due_date`,
                cfs.`is_closed` AS `call_is_closed`,
                CONCAT(
                    e.`last_name`,
                    ', ',
                    e.`first_name`,
                    IF(e.`middle_name` IS NOT NULL AND TRIM(e.`middle_name`) != '', CONCAT(' ', LEFT(e.`middle_name`, 1), '.'), '')
                ) AS `created_by_name`
         FROM `call_submission_projects` csp
         LEFT JOIN `project_agendas` pa ON csp.`agenda_id` = pa.`id`
         LEFT JOIN `call_submissions` cs ON csp.`submission_id` = cs.`id`
         LEFT JOIN `schools` sc ON cs.`school_id` = sc.`id`
         LEFT JOIN `call_for_submissions` cfs ON cs.`call_id` = cfs.`id`
         LEFT JOIN `employees` e ON csp.`created_by` = e.`id`
         WHERE csp.`id` = ? LIMIT 1",
        [$id]
    );
}

function submissionProject($id)
{
    return callSubmissionProject($id);
}

function createCallSubmissionProject($submissionId, $agendaId, $title, $startYear, $endYear, $createdBy)
{
    return insert('call_submission_projects', [
        'submission_id' => $submissionId,
        'agenda_id' => $agendaId,
        'title' => mb_substr((string) $title, 0, 255),
        'start_year' => (int) $startYear,
        'end_year' => (int) $endYear,
        'created_by' => $createdBy,
        'updated_by' => $createdBy,
    ]);
}

function updateCallSubmissionProject($id, $agendaId, $title, $startYear, $endYear, $updatedBy)
{
    return update('call_submission_projects', [
        'agenda_id' => $agendaId,
        'title' => mb_substr((string) $title, 0, 255),
        'start_year' => (int) $startYear,
        'end_year' => (int) $endYear,
        'updated_by' => $updatedBy,
    ], '`id` = ?', [$id]);
}

function deleteCallSubmissionProject($id)
{
    deleteAllProjectObjectives($id);
    return delete('call_submission_projects', '`id` = ?', [$id]);
}

function deleteAllCallSubmissionProjects($submissionId)
{
    $projects = query("SELECT `id` FROM `call_submission_projects` WHERE `submission_id` = ?", [$submissionId]);
    if (is_array($projects)) {
        foreach ($projects as $p) {
            deleteAllProjectObjectives((int) $p['id']);
        }
    }
    return delete('call_submission_projects', '`submission_id` = ?', [$submissionId]);
}

function countCallSubmissionProjects($submissionId): int
{
    $result = find(
        "SELECT COUNT(*) AS `count` FROM `call_submission_projects` WHERE `submission_id` = ?",
        [$submissionId]
    );
    return (int) ($result['count'] ?? 0);
}

function countSubmissionProjects($submissionId): int
{
    return countCallSubmissionProjects($submissionId);
}

// ========== Project Objectives (`project_objectives`) ==========

function projectObjectives($projectId): array
{
    $rows = query(
        "SELECT `id`, `project_id`, `description`, `created_at`, `updated_at`
         FROM `project_objectives`
         WHERE `project_id` = ?
         ORDER BY `id` ASC",
        [$projectId]
    );

    return is_array($rows) ? $rows : [];
}

function projectObjective($id)
{
    if (empty($id)) {
        return false;
    }

    return find(
        "SELECT obj.*,
                csp.`title` AS `project_title`,
                csp.`submission_id`,
                pa.`name` AS `agenda_name`,
                cs.`call_id`,
                cs.`school_id`,
                cfs.`title` AS `call_title`,
                cfs.`is_closed` AS `call_is_closed`
         FROM `project_objectives` obj
         LEFT JOIN `call_submission_projects` csp ON obj.`project_id` = csp.`id`
         LEFT JOIN `project_agendas` pa ON csp.`agenda_id` = pa.`id`
         LEFT JOIN `call_submissions` cs ON csp.`submission_id` = cs.`id`
         LEFT JOIN `call_for_submissions` cfs ON cs.`call_id` = cfs.`id`
         WHERE obj.`id` = ? LIMIT 1",
        [$id]
    );
}

function createProjectObjective($projectId, $description)
{
    return insert('project_objectives', [
        'project_id' => $projectId,
        'description' => mb_substr((string) $description, 0, 255),
    ]);
}

function updateProjectObjective($id, $description)
{
    return update('project_objectives', [
        'description' => mb_substr((string) $description, 0, 255),
    ], '`id` = ?', [$id]);
}

function deleteProjectObjective($id)
{
    deleteProjectOutcomesByObjective($id);
    return delete('project_objectives', '`id` = ?', [$id]);
}

function deleteAllProjectObjectives($projectId)
{
    $objectives = query("SELECT `id` FROM `project_objectives` WHERE `project_id` = ?", [$projectId]);
    if (is_array($objectives)) {
        foreach ($objectives as $obj) {
            deleteProjectOutcomesByObjective((int) $obj['id']);
        }
    }
    return delete('project_objectives', '`project_id` = ?', [$projectId]);
}

function countProjectObjectives($projectId): int
{
    $result = find(
        "SELECT COUNT(*) AS `count` FROM `project_objectives` WHERE `project_id` = ?",
        [$projectId]
    );
    return (int) ($result['count'] ?? 0);
}

// ========== Project Outcomes (`project_outcomes`) ==========

function projectOutcomesByObjective($objectiveId): array
{
    $rows = query(
        "SELECT po.*,
                CONCAT(
                    e.`last_name`,
                    ', ',
                    e.`first_name`,
                    IF(e.`middle_name` IS NOT NULL AND TRIM(e.`middle_name`) != '', CONCAT(' ', LEFT(e.`middle_name`, 1), '.'), '')
                ) AS `created_by_name`
         FROM `project_outcomes` po
         LEFT JOIN `employees` e ON po.`created_by` = e.`id`
         WHERE po.`objective_id` = ?
         ORDER BY po.`id` ASC",
        [$objectiveId]
    );

    return is_array($rows) ? $rows : [];
}

function projectOutcomesByProject($projectId): array
{
    $rows = query(
        "SELECT po.*,
                obj.`project_id`,
                obj.`description` AS `objective_description`,
                CONCAT(
                    e.`last_name`,
                    ', ',
                    e.`first_name`,
                    IF(e.`middle_name` IS NOT NULL AND TRIM(e.`middle_name`) != '', CONCAT(' ', LEFT(e.`middle_name`, 1), '.'), '')
                ) AS `created_by_name`
         FROM `project_outcomes` po
         INNER JOIN `project_objectives` obj ON po.`objective_id` = obj.`id`
         LEFT JOIN `employees` e ON po.`created_by` = e.`id`
         WHERE obj.`project_id` = ?
         ORDER BY obj.`id` ASC, po.`id` ASC",
        [$projectId]
    );

    return is_array($rows) ? $rows : [];
}

function projectOutcomes($projectId): array
{
    return projectOutcomesByProject($projectId);
}

function projectOutcome($id)
{
    if (empty($id)) {
        return false;
    }

    return find(
        "SELECT po.*,
                obj.`project_id`,
                obj.`description` AS `objective_description`,
                csp.`title` AS `project_title`,
                csp.`submission_id`,
                pa.`name` AS `agenda_name`,
                cs.`call_id`,
                cs.`school_id`,
                cfs.`title` AS `call_title`,
                cfs.`is_closed` AS `call_is_closed`,
                CONCAT(
                    e.`last_name`,
                    ', ',
                    e.`first_name`,
                    IF(e.`middle_name` IS NOT NULL AND TRIM(e.`middle_name`) != '', CONCAT(' ', LEFT(e.`middle_name`, 1), '.'), '')
                ) AS `created_by_name`
         FROM `project_outcomes` po
         LEFT JOIN `project_objectives` obj ON po.`objective_id` = obj.`id`
         LEFT JOIN `call_submission_projects` csp ON obj.`project_id` = csp.`id`
         LEFT JOIN `project_agendas` pa ON csp.`agenda_id` = pa.`id`
         LEFT JOIN `call_submissions` cs ON csp.`submission_id` = cs.`id`
         LEFT JOIN `call_for_submissions` cfs ON cs.`call_id` = cfs.`id`
         LEFT JOIN `employees` e ON po.`created_by` = e.`id`
         WHERE po.`id` = ? LIMIT 1",
        [$id]
    );
}

function createProjectOutcome($objectiveId, $description, $createdBy)
{
    return insert('project_outcomes', [
        'objective_id' => $objectiveId,
        'description' => mb_substr((string) $description, 0, 255),
        'created_by' => $createdBy,
        'updated_by' => $createdBy,
    ]);
}

function updateProjectOutcome($id, $description, $updatedBy)
{
    return update('project_outcomes', [
        'description' => mb_substr((string) $description, 0, 255),
        'updated_by' => $updatedBy,
    ], '`id` = ?', [$id]);
}

function deleteProjectOutcome($id)
{
    return delete('project_outcomes', '`id` = ?', [$id]);
}

function deleteProjectOutcomesByObjective($objectiveId)
{
    return delete('project_outcomes', '`objective_id` = ?', [$objectiveId]);
}

function countProjectOutcomesByProject($projectId): int
{
    $result = find(
        "SELECT COUNT(po.`id`) AS `count`
         FROM `project_outcomes` po
         INNER JOIN `project_objectives` obj ON po.`objective_id` = obj.`id`
         WHERE obj.`project_id` = ?",
        [$projectId]
    );
    return (int) ($result['count'] ?? 0);
}