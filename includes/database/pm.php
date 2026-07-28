<?php
// includes/database/pm.php
// IPCRF (Individual Performance Commitment and Review Form) Database Functions

// ========== CYCLES ==========

function pmCycles()
{
    return query("SELECT * FROM `pm_cycles` ORDER BY `date_start` DESC") ?: [];
}

function pmActiveCycle()
{
    return find("SELECT * FROM `pm_cycles` WHERE `status` = 'Active' ORDER BY `date_start` DESC LIMIT 1");
}

function pmCycle($id)
{
    return find("SELECT * FROM `pm_cycles` WHERE `id` = ?", [$id]);
}

function createPmCycle($title, $schoolYear, $dateStart, $dateEnd, $createdBy)
{
    return insert('pm_cycles', [
        'title' => $title,
        'school_year' => $schoolYear,
        'date_start' => $dateStart,
        'date_end' => $dateEnd,
        'created_by' => $createdBy
    ]);
}

function updatePmCycle($title, $schoolYear, $dateStart, $dateEnd, $status, $id)
{
    return update('pm_cycles', [
        'title' => $title,
        'school_year' => $schoolYear,
        'date_start' => $dateStart,
        'date_end' => $dateEnd,
        'status' => $status
    ], '`id` = ?', [$id]);
}

function activatePmCycle($cycleId)
{
    // Deactivate all cycles first
    update('pm_cycles', ['status' => 'Inactive'], '`status` = ?', ['Active']);
    // Activate the specified cycle
    if ($cycleId > 0) {
        return update('pm_cycles', ['status' => 'Active'], '`id` = ?', [$cycleId]);
    }
    return true;
}

function deletePmCycle($id)
{
    return delete('pm_cycles', '`id` = ?', [$id]);
}

// ========== KRA (Key Result Areas) ==========

function pmKras($activeOnly = true)
{
    $sql = "SELECT * FROM `pm_kra`";
    if ($activeOnly) {
        $sql .= " WHERE `is_active` = 1";
    }
    $sql .= " ORDER BY `sort_order` ASC";
    return query($sql) ?: [];
}

function pmKra($id)
{
    return find("SELECT * FROM `pm_kra` WHERE `id` = ?", [$id]);
}

function createPmKra($title, $description, $weight, $sortOrder, $createdBy)
{
    return insert('pm_kra', [
        'title' => $title,
        'description' => $description,
        'weight' => $weight,
        'sort_order' => $sortOrder,
        'created_by' => $createdBy
    ]);
}

function updatePmKra($id, $title, $description, $weight, $sortOrder, $isActive)
{
    return update('pm_kra', [
        'title' => $title,
        'description' => $description,
        'weight' => $weight,
        'sort_order' => $sortOrder,
        'is_active' => $isActive
    ], '`id` = ?', [$id]);
}

function deletePmKra($id)
{
    return delete('pm_kra', '`id` = ?', [$id]);
}

// ========== KRA ASSIGNMENTS ==========

function pmKraAssignments($employeeId, $cycleId)
{
    return query(
        "SELECT ka.*, k.title, k.description 
        FROM `pm_kra_assignments` ka
        JOIN `pm_kra` k ON k.id = ka.kra_id
        WHERE ka.employee_id = ? AND ka.cycle_id = ?
        ORDER BY k.sort_order ASC",
        [$employeeId, $cycleId]
    ) ?: [];
}

function pmKraAssignment($kraId, $employeeId, $cycleId)
{
    return find(
        "SELECT * FROM `pm_kra_assignments` WHERE `kra_id` = ? AND `employee_id` = ? AND `cycle_id` = ?",
        [$kraId, $employeeId, $cycleId]
    );
}

function assignPmKra($kraId, $employeeId, $cycleId, $weight, $assignedBy)
{
    return insert('pm_kra_assignments', [
        'kra_id' => $kraId,
        'employee_id' => $employeeId,
        'cycle_id' => $cycleId,
        'weight' => $weight,
        'assigned_by' => $assignedBy
    ]);
}

function updatePmKraAssignment($id, $weight)
{
    return update('pm_kra_assignments', ['weight' => $weight], '`id` = ?', [$id]);
}

function removePmKraAssignment($kraId, $employeeId, $cycleId)
{
    return delete('pm_kra_assignments', '`kra_id` = ? AND `employee_id` = ? AND `cycle_id` = ?', [$kraId, $employeeId, $cycleId]);
}

// ========== VALIDATORS (Rater/Ratee Assignments) ==========

function pmValidators($cycleId = null)
{
    $sql = "SELECT v.*, 
            CONCAT(r.last_name, ', ', r.first_name, ' ', COALESCE(r.middle_name, '')) AS rater_name,
            CONCAT(e.last_name, ', ', e.first_name, ' ', COALESCE(e.middle_name, '')) AS ratee_name
            FROM `pm_validators` v
            JOIN `employees` r ON r.id = v.validator_id
            JOIN `employees` e ON e.id = v.ratee_id";
    $params = [];
    if ($cycleId) {
        $sql .= " WHERE v.cycle_id = ?";
        $params[] = $cycleId;
    }
    $sql .= " ORDER BY r.last_name ASC, e.last_name ASC";
    return query($sql, $params) ?: [];
}

function pmValidator($validatorId, $rateeId, $cycleId)
{
    return find(
        "SELECT * FROM `pm_validators` WHERE `validator_id` = ? AND `ratee_id` = ? AND `cycle_id` = ?",
        [$validatorId, $rateeId, $cycleId]
    );
}

function pmValidatorOf($rateeId, $cycleId)
{
    return find(
        "SELECT v.*, CONCAT(e.last_name, ', ', e.first_name, ' ', COALESCE(e.middle_name, '')) AS validator_name
        FROM `pm_validators` v
        JOIN `employees` e ON e.id = v.validator_id
        WHERE v.ratee_id = ? AND v.cycle_id = ?",
        [$rateeId, $cycleId]
    );
}

function pmRatees($validatorId, $cycleId)
{
    return query(
        "SELECT v.*, CONCAT(e.last_name, ', ', e.first_name, ' ', COALESCE(e.middle_name, '')) AS ratee_name,
                e.id AS employee_id
        FROM `pm_validators` v
        JOIN `employees` e ON e.id = v.ratee_id
        WHERE v.validator_id = ? AND v.cycle_id = ?
        ORDER BY e.last_name ASC",
        [$validatorId, $cycleId]
    ) ?: [];
}

function assignPmValidator($validatorId, $rateeId, $cycleId)
{
    return insert('pm_validators', [
        'validator_id' => $validatorId,
        'ratee_id' => $rateeId,
        'cycle_id' => $cycleId
    ]);
}

function removePmValidator($validatorId, $rateeId, $cycleId)
{
    return delete('pm_validators', '`validator_id` = ? AND `ratee_id` = ? AND `cycle_id` = ?', [$validatorId, $rateeId, $cycleId]);
}

// ========== TOP MANAGEMENT ==========

function pmTopManagement($activeOnly = true)
{
    $sql = "SELECT tm.*, CONCAT(e.last_name, ', ', e.first_name, ' ', COALESCE(e.middle_name, '')) AS name,
            e.email_address
            FROM `pm_top_management` tm
            JOIN `employees` e ON e.id = tm.employee_id";
    if ($activeOnly) {
        $sql .= " WHERE tm.is_active = 1";
    }
    $sql .= " ORDER BY e.last_name ASC";
    return query($sql) ?: [];
}

function pmTopManagementRecord($employeeId)
{
    return find("SELECT * FROM `pm_top_management` WHERE `employee_id` = ?", [$employeeId]);
}

function addPmTopManagement($employeeId, $positionTitle)
{
    return insert('pm_top_management', [
        'employee_id' => $employeeId,
        'position_title' => $positionTitle
    ]);
}

function updatePmTopManagement($id, $positionTitle, $isActive)
{
    return update('pm_top_management', [
        'position_title' => $positionTitle,
        'is_active' => $isActive
    ], '`id` = ?', [$id]);
}

function removePmTopManagement($id)
{
    return delete('pm_top_management', '`id` = ?', [$id]);
}

// Section Heads / Raters from the sections table
function pmSectionHeads()
{
    $sql = "SELECT e.id AS employee_id,
            CONCAT(e.last_name, ', ', e.first_name, ' ', COALESCE(e.middle_name, '')) AS name,
            COALESCE(MAX(p.official_title), CONCAT('Head of ', MIN(s.name))) AS position_title,
            e.email_address
            FROM `sections` s
            INNER JOIN `employees` e ON e.id = s.head_id
            LEFT JOIN (
                SELECT `employee_id`, MAX(`assignment_date`) AS latest_date
                FROM `station_assignments`
                GROUP BY `employee_id`
            ) latest ON latest.employee_id = e.id
            LEFT JOIN `station_assignments` sa ON sa.employee_id = e.id AND sa.assignment_date = latest.latest_date
            LEFT JOIN `positions` p ON p.id = sa.position_id
            GROUP BY e.id
            ORDER BY e.last_name ASC";
    return query($sql) ?: [];
}

// ========== IPCRF ==========

function pmIpcrf($id)
{
    return find(
        "SELECT i.*, c.title AS cycle_title, c.school_year, c.date_start, c.date_end
        FROM `pm_ipcrf` i
        JOIN `pm_cycles` c ON c.id = i.cycle_id
        WHERE i.id = ?",
        [$id]
    );
}

function pmIpcrfByEmployee($employeeId, $cycleId)
{
    return find(
        "SELECT * FROM `pm_ipcrf` WHERE `employee_id` = ? AND `cycle_id` = ?",
        [$employeeId, $cycleId]
    );
}

function pmIpcrfList($employeeId)
{
    return query(
        "SELECT i.*, c.title AS cycle_title, c.school_year, c.date_start, c.date_end
        FROM `pm_ipcrf` i
        JOIN `pm_cycles` c ON c.id = i.cycle_id
        WHERE i.employee_id = ?
        ORDER BY c.date_start DESC",
        [$employeeId]
    ) ?: [];
}

function pmIpcrfByValidator($validatorId, $cycleId = null)
{
    $sql = "SELECT i.*, c.title AS cycle_title, c.school_year,
            CONCAT(e.last_name, ', ', e.first_name, ' ', COALESCE(e.middle_name, '')) AS ratee_name,
            e.id AS ratee_employee_id
            FROM `pm_ipcrf` i
            JOIN `pm_cycles` c ON c.id = i.cycle_id
            JOIN `employees` e ON e.id = i.employee_id
            WHERE i.validator_id = ?";
    $params = [$validatorId];

    if ($cycleId) {
        $sql .= " AND i.cycle_id = ?";
        $params[] = $cycleId;
    }

    $sql .= " ORDER BY c.date_start DESC, e.last_name ASC";
    return query($sql, $params) ?: [];
}

function pmAllIpcrf($cycleId = null, $status = null)
{
    $sql = "SELECT i.*, c.title AS cycle_title, c.school_year,
            CONCAT(e.last_name, ', ', e.first_name, ' ', COALESCE(e.middle_name, '')) AS ratee_name,
            CONCAT(v.last_name, ', ', v.first_name, ' ', COALESCE(v.middle_name, '')) AS validator_name
            FROM `pm_ipcrf` i
            JOIN `pm_cycles` c ON c.id = i.cycle_id
            JOIN `employees` e ON e.id = i.employee_id
            LEFT JOIN `employees` v ON v.id = i.validator_id
            WHERE 1=1";
    $params = [];

    if ($cycleId) {
        $sql .= " AND i.cycle_id = ?";
        $params[] = $cycleId;
    }
    if ($status) {
        $sql .= " AND i.status = ?";
        $params[] = $status;
    }

    $sql .= " ORDER BY e.last_name ASC";
    return query($sql, $params) ?: [];
}

function createPmIpcrf($cycleId, $employeeId, $validatorId = null, $positionTitle = null)
{
    return insert('pm_ipcrf', [
        'cycle_id' => $cycleId,
        'employee_id' => $employeeId,
        'validator_id' => $validatorId,
        'position_title' => $positionTitle,
        'status' => 'Draft',
        'phase' => 1
    ]);
}

function updatePmIpcrfStatus($id, $status, $remarks = null, $field = 'ratee_remarks')
{
    $data = ['status' => $status];

    if ($remarks !== null) {
        $data[$field] = $remarks;
    }

    if ($status === 'Submitted') {
        $data['submitted_at'] = date('Y-m-d H:i:s');
    } elseif ($status === 'Approved') {
        $data['approved_at'] = date('Y-m-d H:i:s');
    } elseif ($status === 'Validated') {
        $data['validated_at'] = date('Y-m-d H:i:s');
    } elseif ($status === 'Completed') {
        $data['completed_at'] = date('Y-m-d H:i:s');
    }

    return update('pm_ipcrf', $data, '`id` = ?', [$id]);
}

function updatePmIpcrfPhase($id, $phase)
{
    return update('pm_ipcrf', ['phase' => $phase], '`id` = ?', [$id]);
}

function updatePmIpcrfFinalRating($id, $finalRating, $adjectivalRating)
{
    return update('pm_ipcrf', [
        'final_rating' => $finalRating,
        'adjectival_rating' => $adjectivalRating
    ], '`id` = ?', [$id]);
}

function updatePmIpcrfValidator($id, $validatorId)
{
    return update('pm_ipcrf', ['validator_id' => $validatorId], '`id` = ?', [$id]);
}

function updatePmIpcrfApprovingOfficer($id, $approvingOfficerId)
{
    return update('pm_ipcrf', ['approving_officer_id' => $approvingOfficerId], '`id` = ?', [$id]);
}

function deletePmIpcrf($id)
{
    return delete('pm_ipcrf', '`id` = ?', [$id]);
}

// ========== OBJECTIVES ==========

function pmObjectives($ipcrfId)
{
    return query(
        "SELECT * FROM `pm_objectives` WHERE `ipcrf_id` = ? ORDER BY `kra_id` ASC, `sort_order` ASC",
        [$ipcrfId]
    ) ?: [];
}

function pmObjectivesByKra($ipcrfId, $kraId)
{
    return query(
        "SELECT * FROM `pm_objectives` WHERE `ipcrf_id` = ? AND `kra_id` = ? ORDER BY `sort_order` ASC",
        [$ipcrfId, $kraId]
    ) ?: [];
}

function pmObjective($id)
{
    return find("SELECT * FROM `pm_objectives` WHERE `id` = ?", [$id]);
}

function createPmObjective($ipcrfId, $kraId, $kraTitle, $kraWeight, $objective, $timeline, $weight, $performanceIndicator, $pi4 = '', $pi3 = '', $pi2 = '', $pi1 = '', $sortOrder = 0)
{
    return insert('pm_objectives', [
        'ipcrf_id' => $ipcrfId,
        'kra_id' => $kraId,
        'kra_title' => $kraTitle,
        'kra_weight' => $kraWeight,
        'objective' => $objective,
        'timeline' => $timeline,
        'weight' => $weight,
        'performance_indicator' => $performanceIndicator,
        'sort_order' => $sortOrder
    ]);
}

function updatePmObjective($id, $kraId, $kraTitle, $objective, $timeline, $weight, $performanceIndicator)
{
    return update('pm_objectives', [
        'kra_id' => $kraId,
        'kra_title' => $kraTitle,
        'objective' => $objective,
        'timeline' => $timeline,
        'weight' => $weight,
        'performance_indicator' => $performanceIndicator
    ], '`id` = ?', [$id]);
}

function updatePmObjectiveResult($id, $actualResult)
{
    return update('pm_objectives', ['actual_result' => $actualResult], '`id` = ?', [$id]);
}

function updatePmObjectivePhase2($id, $actualResult, $ratingQ, $ratingE, $ratingT, $averageRating, $score)
{
    $data = [
        'actual_result' => $actualResult,
        'rating_q' => $ratingQ,
        'rating_e' => $ratingE,
        'rating_t' => $ratingT,
        'average_rating' => $averageRating,
        'score' => $score
    ];
    return update('pm_objectives', $data, '`id` = ?', [$id]);
}

function updatePmObjectiveRating($id, $ratingQ, $ratingE, $ratingT, $remarks = null)
{
    $avg = ($ratingQ + $ratingE + $ratingT) / 3;
    return update('pm_objectives', [
        'rating_q' => $ratingQ,
        'rating_e' => $ratingE,
        'rating_t' => $ratingT,
        'average_rating' => round($avg, 2),
        'remarks' => $remarks
    ], '`id` = ?', [$id]);
}

function deletePmObjective($id)
{
    return delete('pm_objectives', '`id` = ?', [$id]);
}

// ========== ADJUSTMENT REQUESTS ==========

function pmAdjustmentRequests($ipcrfId, $status = null)
{
    $sql = "SELECT ar.*, o.objective, o.kra_title
            FROM `pm_adjustment_requests` ar
            JOIN `pm_objectives` o ON o.id = ar.objective_id
            WHERE ar.ipcrf_id = ?";
    $params = [$ipcrfId];
    
    if ($status) {
        $sql .= " AND ar.status = ?";
        $params[] = $status;
    }
    
    $sql .= " ORDER BY ar.created_at DESC";
    return query($sql, $params) ?: [];
}

function pmAdjustmentRequest($id)
{
    return find("SELECT * FROM `pm_adjustment_requests` WHERE `id` = ?", [$id]);
}

function createPmAdjustmentRequest($objectiveId, $ipcrfId, $requestedBy, $requestType, $reason, $proposedChanges = null)
{
    return insert('pm_adjustment_requests', [
        'objective_id' => $objectiveId,
        'ipcrf_id' => $ipcrfId,
        'requested_by' => $requestedBy,
        'request_type' => $requestType,
        'reason' => $reason,
        'proposed_changes' => $proposedChanges
    ]);
}

function reviewPmAdjustmentRequest($id, $status, $reviewedBy, $remarks = null)
{
    return update('pm_adjustment_requests', [
        'status' => $status,
        'reviewed_by' => $reviewedBy,
        'reviewer_remarks' => $remarks,
        'reviewed_at' => date('Y-m-d H:i:s')
    ], '`id` = ?', [$id]);
}

// ========== MEANS OF VERIFICATION (MOV) ==========

function pmMovList($objectiveId)
{
    return query(
        "SELECT * FROM `pm_mov` WHERE `objective_id` = ? ORDER BY `created_at` DESC",
        [$objectiveId]
    ) ?: [];
}

function pmMovByIpcrf($ipcrfId)
{
    return query(
        "SELECT m.*, o.objective, o.kra_title
        FROM `pm_mov` m
        JOIN `pm_objectives` o ON o.id = m.objective_id
        WHERE m.ipcrf_id = ?
        ORDER BY o.kra_id ASC, m.created_at DESC",
        [$ipcrfId]
    ) ?: [];
}

function pmMov($id)
{
    return find("SELECT * FROM `pm_mov` WHERE `id` = ?", [$id]);
}

function createPmMov($objectiveId, $ipcrfId, $fileName, $originalName, $fileType, $fileSize, $description, $uploadedBy)
{
    return insert('pm_mov', [
        'objective_id' => $objectiveId,
        'ipcrf_id' => $ipcrfId,
        'file_name' => $fileName,
        'original_name' => $originalName,
        'file_type' => $fileType,
        'file_size' => $fileSize,
        'description' => $description,
        'uploaded_by' => $uploadedBy
    ]);
}

function deletePmMov($id)
{
    return delete('pm_mov', '`id` = ?', [$id]);
}

// ========== COACHING ENTRIES ==========

function pmCoachingEntries($ipcrfId)
{
    return query(
        "SELECT c.*, o.objective, o.kra_title
        FROM `pm_coaching` c
        JOIN `pm_objectives` o ON o.id = c.objective_id
        WHERE c.ipcrf_id = ?
        ORDER BY c.coaching_date DESC, c.created_at DESC",
        [$ipcrfId]
    ) ?: [];
}

function pmCoachingEntry($id)
{
    return find("SELECT * FROM `pm_coaching` WHERE `id` = ?", [$id]);
}

function createPmCoaching($ipcrfId, $objectiveId, $coachingDate, $incident, $feedback, $actionAgreed, $rateeSignature, $raterSignature, $createdBy)
{
    return insert('pm_coaching', [
        'ipcrf_id' => $ipcrfId,
        'objective_id' => $objectiveId,
        'coaching_date' => $coachingDate,
        'incident' => $incident,
        'feedback' => $feedback,
        'action_agreed' => $actionAgreed,
        'ratee_signature' => $rateeSignature,
        'rater_signature' => $raterSignature,
        'created_by' => $createdBy
    ]);
}

function updatePmCoaching($id, $coachingDate, $incident, $feedback, $actionAgreed)
{
    return update('pm_coaching', [
        'coaching_date' => $coachingDate,
        'incident' => $incident,
        'feedback' => $feedback,
        'action_agreed' => $actionAgreed
    ], '`id` = ?', [$id]);
}

function deletePmCoaching($id)
{
    return delete('pm_coaching', '`id` = ?', [$id]);
}

// ========== COMPETENCY RATINGS (Phase 4) ==========

function pmCompetencyRatings($ipcrfId)
{
    return query(
        "SELECT * FROM `pm_competency_ratings` WHERE `ipcrf_id` = ? ORDER BY `category`, `id`",
        [$ipcrfId]
    ) ?: [];
}

function pmCompetencyRating($id)
{
    return find("SELECT * FROM `pm_competency_ratings` WHERE `id` = ?", [$id]);
}

function createPmCompetencyRating($ipcrfId, $category, $competencyNumber, $rating)
{
    return insert('pm_competency_ratings', [
        'ipcrf_id' => $ipcrfId,
        'category' => $category,
        'competency_number' => $competencyNumber,
        'rating' => $rating
    ]);
}

function updatePmCompetencyRating($id, $rating)
{
    return update('pm_competency_ratings', ['rating' => $rating], '`id` = ?', [$id]);
}

function upsertPmCompetencyRating($ipcrfId, $category, $competencyNumber, $rating)
{
    $existing = find(
        "SELECT id FROM `pm_competency_ratings` WHERE `ipcrf_id` = ? AND `category` = ? AND `competency_number` = ?",
        [$ipcrfId, $category, $competencyNumber]
    );
    
    if ($existing) {
        return update('pm_competency_ratings', ['rating' => $rating], '`id` = ?', [$existing['id']]);
    } else {
        return createPmCompetencyRating($ipcrfId, $category, $competencyNumber, $rating);
    }
}

function pmCompetencyCategoryAverage($ipcrfId, $category)
{
    $result = find(
        "SELECT AVG(rating) as avg_rating FROM `pm_competency_ratings` WHERE `ipcrf_id` = ? AND `category` = ? AND `rating` IS NOT NULL",
        [$ipcrfId, $category]
    );
    return $result ? round((float) $result['avg_rating'], 2) : null;
}

// ========== DEVELOPMENT PLANS (Phase 4) ==========

function pmDevelopmentPlans($ipcrfId)
{
    return query(
        "SELECT * FROM `pm_development_plans` WHERE `ipcrf_id` = ? ORDER BY `created_at`",
        [$ipcrfId]
    ) ?: [];
}

function pmDevelopmentPlan($id)
{
    return find("SELECT * FROM `pm_development_plans` WHERE `id` = ?", [$id]);
}

function createPmDevelopmentPlan($ipcrfId, $strengths, $developmentNeeds, $actionPlan, $timeline, $resources)
{
    return insert('pm_development_plans', [
        'ipcrf_id' => $ipcrfId,
        'strengths' => $strengths,
        'development_needs' => $developmentNeeds,
        'action_plan' => $actionPlan,
        'timeline' => $timeline,
        'resources' => $resources
    ]);
}

function updatePmDevelopmentPlan($id, $strengths, $developmentNeeds, $actionPlan, $timeline, $resources)
{
    return update('pm_development_plans', [
        'strengths' => $strengths,
        'development_needs' => $developmentNeeds,
        'action_plan' => $actionPlan,
        'timeline' => $timeline,
        'resources' => $resources
    ], '`id` = ?', [$id]);
}

function deletePmDevelopmentPlan($id)
{
    return delete('pm_development_plans', '`id` = ?', [$id]);
}

// ========== UTILITY FUNCTIONS ==========

function pmAdjectivalRating($rating)
{
    if ($rating >= 10) {
        if ($rating >= 90) return 'Outstanding';
        if ($rating >= 80) return 'Very Satisfactory';
        if ($rating >= 70) return 'Satisfactory';
        if ($rating >= 60) return 'Unsatisfactory';
        return 'Poor';
    }

    if ($rating >= 4.500) return 'Outstanding';
    if ($rating >= 3.500) return 'Very Satisfactory';
    if ($rating >= 2.500) return 'Satisfactory';
    if ($rating >= 1.500) return 'Unsatisfactory';
    return 'Poor';
}

function pmComputeFinalRating($ipcrfId)
{
    $objectives = pmObjectives($ipcrfId);
    
    if (empty($objectives)) {
        return null;
    }

    // Group objectives by KRA
    $kraGroups = [];
    foreach ($objectives as $obj) {
        $kraId = $obj['kra_id'];
        if (!isset($kraGroups[$kraId])) {
            $kraGroups[$kraId] = [
                'weight' => $obj['kra_weight'],
                'objectives' => []
            ];
        }
        $kraGroups[$kraId]['objectives'][] = $obj;
    }

    $totalWeightedScore = 0;
    $totalWeight = 0;

    foreach ($kraGroups as $kraId => $kra) {
        $kraRatingSum = 0;
        $kraWeightSum = 0;

        foreach ($kra['objectives'] as $obj) {
            if ($obj['average_rating'] !== null) {
                $objWeight = $obj['weight'] > 0 ? $obj['weight'] : 1;
                $kraRatingSum += $obj['average_rating'] * $objWeight;
                $kraWeightSum += $objWeight;
            }
        }

        if ($kraWeightSum > 0) {
            $kraAvg = $kraRatingSum / $kraWeightSum;
            $kraWeightedScore = $kraAvg * ($kra['weight'] / 100);
            $totalWeightedScore += $kraWeightedScore;
            $totalWeight += $kra['weight'];
        }
    }

    if ($totalWeight > 0) {
        // Normalize to account for total weight
        $finalRating = ($totalWeightedScore / $totalWeight) * 100;
        return round($finalRating, 2);
    }

    return null;
}

function pmPhaseLabel($phase)
{
    $labels = [
        1 => 'Performance Planning and Commitment',
        2 => 'Performance Monitoring and Coaching',
        3 => 'Performance Review and Evaluation',
        4 => 'Performance Rewarding and Development Planning'
    ];
    return $labels[$phase] ?? 'Unknown';
}

function pmStatusBadge($status)
{
    $colors = [
        'Draft' => 'secondary',
        'Submitted' => 'info',
        'Approved' => 'success',
        'Validated' => 'success',
        'Returned' => 'warning',
        'Completed' => 'primary'
    ];
    $color = $colors[$status] ?? 'secondary';
    return "<span class=\"badge badge-{$color} px-2 py-1\">{$status}</span>";
}

function pmRatingDescription($rating)
{
    $descriptions = [
        5 => 'Outstanding',
        4 => 'Very Satisfactory',
        3 => 'Satisfactory',
        2 => 'Unsatisfactory',
        1 => 'Poor'
    ];
    return $descriptions[$rating] ?? '';
}

// Count functions for dashboard
function pmCountIpcrfByStatus($cycleId, $status)
{
    $result = find(
        "SELECT COUNT(*) as count FROM `pm_ipcrf` WHERE `cycle_id` = ? AND `status` = ?",
        [$cycleId, $status]
    );
    return $result ? (int)$result['count'] : 0;
}

function pmCountRatees($validatorId, $cycleId)
{
    $result = find(
        "SELECT COUNT(*) as count FROM `pm_validators` WHERE `validator_id` = ? AND `cycle_id` = ?",
        [$validatorId, $cycleId]
    );
    return $result ? (int)$result['count'] : 0;
}
