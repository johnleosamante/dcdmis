<?php
// modules/pm/phase4.php - Phase 4: Performance Rewarding and Development Planning
if (!$isPis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$ipcrfId = (int) sanitize(decode($_GET['id'] ?? null));
$ipcrf = pmIpcrf($ipcrfId);

if (!$ipcrf) {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

$isOwner = ($userId === (int) $ipcrf['employee_id']);
$isValidator = ($userId === (int) $ipcrf['validator_id']);

if (!$isOwner && !$isValidator) {
    require_once(root() . '/modules/error/403.php');
    return;
}

// Phase 4 only
if ($ipcrf['phase'] < 4) {
    redirect(customUri('pis', 'IPCRF Details', $ipcrfId));
}

$employee = employee($ipcrf['employee_id']);
$validator = $ipcrf['validator_id'] ? employee($ipcrf['validator_id']) : null;
$developmentPlans = pmDevelopmentPlans($ipcrfId);
$competencyRatings = pmCompetencyRatings($ipcrfId);
$objectives = pmObjectives($ipcrfId);

// Compute final rating from objectives if not stored
$finalRating = $ipcrf['final_rating'];
$adjectivalRating = $ipcrf['adjectival_rating'];

if (!$finalRating && !empty($objectives)) {
    $totalScore = 0;
    foreach ($objectives as $obj) {
        $totalScore += (float) ($obj['score'] ?? 0);
    }
    $finalRating = $totalScore;
    $adjectivalRating = pmAdjectivalRating($finalRating);
}

// Index competency ratings by category and number
$competencyIndex = [];
foreach ($competencyRatings as $cr) {
    $competencyIndex[$cr['category']][$cr['competency_number']] = $cr['rating'];
}

// Get position info to determine if head/supervisor (for leadership competencies)
$rateePosition = position($ipcrf['employee_id']);
$rateePositionTitle = $ipcrf['position_title'] ?: ($rateePosition['official_title'] ?? '');
$isHead = stripos($rateePositionTitle, 'head') !== false || 
          stripos($rateePositionTitle, 'principal') !== false || 
          stripos($rateePositionTitle, 'supervisor') !== false ||
          stripos($rateePositionTitle, 'chief') !== false;

$validatorPosition = $validator ? position($validator['id']) : null;
$validatorPositionTitle = $validatorPosition['official_title'] ?? '';

// Calculate category averages
$coreBehavioralAvg = pmCompetencyCategoryAverage($ipcrfId, 'core_behavioral');
$leadershipAvg = pmCompetencyCategoryAverage($ipcrfId, 'leadership');

// Core Behavioral Competencies definitions
$coreBehavioralCompetencies = [
    'self_management' => [
        'title' => 'Self-Management',
        'items' => [
            1 => 'Sets personal goals and direction, needs and development.',
            2 => 'Undertakes personal actions and behaviors that are clear and purposive and takes into account personal goals and values congruent to that of the organization.',
            3 => 'Display emotional maturity and enthusiasm for and is challenged by higher goals.',
            4 => 'Prioritize work task and schedules (through Gantt charts, checklist, etc.) to achieve goals.',
            5 => 'Sets high quality, challenging, realistic goals for self and others.'
        ]
    ],
    'professionalism_ethics' => [
        'title' => 'Professionalism and Ethics',
        'items' => [
            1 => 'Demonstrate the values and behavior enshrined in the Norms or Conduct and Ethical Standards for public officials and employee (RA 6713).',
            2 => 'Practices ethical and professional behavior and conduct taking into account the impact of his/her actions and decisions.',
            3 => 'Maintains professional image: being trustworthy, regularity of attendance and punctuality, good grooming and communication.',
            4 => 'Makes personal sacrifices to meet the organization\'s needs.',
            5 => 'Acts with a sense of urgency and responsibility to meet the organization\'s needs, improves systems and help others improve their effectiveness.'
        ]
    ],
    'result_focus' => [
        'title' => 'Result Focus',
        'items' => [
            1 => 'Achieves results with optimal use of time and resources most of the time.',
            2 => 'Avoids rework, mistakes and wastage through effective work methods by placing organizational needs before personal needs.',
            3 => 'Delivers error-free outputs most of the time by conforming to standard operating procedures correctly and consistently. Able to produce very satisfactory quality of work in terms of usefulness/acceptability and completeness with no supervision required.',
            4 => 'Expresses a desire to do better and may express frustration at waste of inefficiency. May focus on new or more precise ways of meeting goals set.',
            5 => 'Make specific changes in the system or in own work methods to improve performance.'
        ]
    ],
    'teamwork' => [
        'title' => 'Teamwork',
        'items' => [
            1 => 'Willingly does his/her share of responsibility.',
            2 => 'Promotes collaboration and removes barriers to teamwork and goal accomplishment across the organization.',
            3 => 'Applies negotiation principles in arriving at win-win agreements.',
            4 => 'Drives consensus and team ownership of decisions.',
            5 => 'Works constructively and collaboratively with others and across organizations to accomplish organizational goals and objectives.'
        ]
    ],
    'service_orientation' => [
        'title' => 'Service Orientation',
        'items' => [
            1 => 'Can explain and articulate organizational directions, issues and problems.',
            2 => 'Take personal responsibility for dealing with and/or correcting customer service issues and concern.',
            3 => 'Initiates activities that promotes advocacy for men and women empowerment.',
            4 => 'Participates in updating of office vision, mission, mandates and strategies based on DepEd strategies and directions.',
            5 => 'Develops and adopts service improvement programs through simplified procedures that will further enhance service delivery.'
        ]
    ],
    'innovation' => [
        'title' => 'Innovation',
        'items' => [
            1 => 'Examines the root cause of problems and suggests effective solution. Fosters new ideas, processes, and suggest better ways to do things (cost and/or operational efficiency).',
            2 => 'Demonstrates an ability to think "beyond the box". Continuously focused on improving personal productivity to create higher values and results.',
            3 => 'Promotes a creative climate and inspire co-workers to develop original ideas or solutions.',
            4 => 'Translates creative thinking into tangible changes and solutions that improve the work unit and organization.',
            5 => 'Uses ingenious methods to accomplish responsibilities. Demonstrate resourcefulness and the ability to succeed with minimal resources.'
        ]
    ]
];

// Leadership Competencies (for Heads/Supervisors)
$leadershipCompetencies = [
    'leading_people' => [
        'title' => 'Leading People',
        'items' => [
            1 => 'Uses basic persuasion techniques in a discussion or presentation e.g., staff mobilization, appeals to reason and/or emotions, uses data and examples, visual aids.',
            2 => 'Persuades, convinces or influences others, in order to have a specific impact or effect.',
            3 => '"Sets a good example", is a credible and respected leader; and demonstrates desired behavior.',
            4 => 'Forwards personal, professionalism and work unit needs and interest in an issue.',
            5 => 'Relevant vision for the organization and influences other to share ownership of DepEd goals, in order to create an effective work environment.'
        ]
    ],
    'people_performance' => [
        'title' => 'People Performance Management',
        'items' => [
            1 => 'Makes specific changes in the performance (e.g., does something better, faster, at lower cost, more efficiently; improves quality, customer satisfaction, morale, revenues).',
            2 => 'Set performance standards and measures progress of employees based on office and department targets.',
            3 => 'Provides feedback and technical assistance such as coaching for performance improvement and action planning.',
            4 => 'States performance expectations clearly and checks understanding and commitment.',
            5 => 'Performs all the stages of Result-Based Performance Management System supported by evidence and required documents/forms.'
        ]
    ],
    'people_development' => [
        'title' => 'People Development',
        'items' => [
            1 => 'Improves the skills and effectiveness of individuals through employing a range of development strategies.',
            2 => 'Facilitates workplace effectiveness through coaching and motivating/developing people a work environment that promotes mutual trust and respect.',
            3 => 'Conceptualizes and implements learning interventions to meet identified training needs.',
            4 => 'Does long term coaching or training by arranging appropriate and helpful assignments, formal training, or other experiences for the purpose of supporting a person\'s learning and development.',
            5 => 'Cultivates a learning environment by structuring interactive experiences such as looking for the future opportunities that are in support of achieving individual career goals.'
        ]
    ]
];

// Core Skills (for Teachers)
$coreSkills = [
    'oral_communication' => [
        'title' => 'Oral Communication',
        'items' => [
            1 => 'Follows instructions accurately.',
            2 => 'Expresses self clearly, fluently and articulately.',
            3 => 'Uses appropriate medium for the message.',
            4 => 'Adjust communication style to others.',
            5 => 'Guides discussions between and among peers to meet an objective.'
        ]
    ],
    'written_communication' => [
        'title' => 'Written Communication',
        'items' => [
            1 => 'Knows the different written business communication formats used in the DepEd.',
            2 => 'Write routine correspondence/communications, narrative and descriptive report based on ready available information data with minimal spelling or grammatical errors (e.g. Memos, minutes, etc.)',
            3 => 'Secures information from required references (i.e., Directories, schedules, notices, instruction) for specific purposes.',
            4 => 'Self-edits words, numbers, phonetic notation and content, if necessary.',
            5 => 'Demonstrates clarity, fluency, impact, conciseness, and effectiveness in his/her written communications.'
        ]
    ],
    'computer_ict' => [
        'title' => 'Computer / ICT Skills',
        'items' => [
            1 => 'Prepares basic composition (e.g., letters, reports, spreadsheets and graphic presentation using word processing and Excel.',
            2 => 'Identifies different computer parts, turns the computer on/off, and work on a given task with acceptable speed and accuracy and connects computer peripherals (e.g., printers, modems, multi-media projectors, etc.)',
            3 => 'Prepares simple presentations using Microsoft PowerPoint.',
            4 => 'Utilizes technologies to: access information to enhance professional productivity, assists in conducting research and communication through local and global professional networks.',
            5 => 'Recommends appropriate and updated technology to enhance productivity and professional practice.'
        ]
    ]
];

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('pis', 'IPCRF', $userId) ?>">IPCRF</a></li>
            <li class="breadcrumb-item"><a href="<?= customUri('pis', 'IPCRF Details', $ipcrfId) ?>">Details</a></li>
            <li class="breadcrumb-item active">Phase 4</li>
        </ol>
    </nav>
    <div>
        <?= pmStatusBadge($ipcrf['status']) ?>
        <span class="badge badge-light px-2 py-1 ml-1">Phase <?= e($ipcrf['phase']) ?></span>
    </div>
</div>

<!-- Header Card -->
<div class="card border-left-success shadow mb-4">
    <div class="card-header py-3 bg-success text-white">
        <h6 class="m-0 font-weight-bold text-center">
            PERFORMANCE REWARDING AND DEVELOPMENT PLANNING
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="font-weight-bold" width="35%">Name of Employee:</td>
                        <td class="text-uppercase"><?= e(toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension'])) ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Position:</td>
                        <td><?= e($rateePositionTitle) ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="font-weight-bold" width="35%">Name of Superior:</td>
                        <td class="text-uppercase">
                            <?= $validator ? e(toName($validator['last_name'], $validator['first_name'], $validator['middle_name'], $validator['name_extension'])) : '<span class="text-muted">Not assigned</span>' ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Rating Period:</td>
                        <td><?= e($ipcrf['school_year']) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Part III: Summary of Ratings -->
<?php
// Get adjectival badge class
$adjectivalBadgeClass = 'secondary';
if ($adjectivalRating) {
    switch ($adjectivalRating) {
        case 'Outstanding': $adjectivalBadgeClass = 'success'; break;
        case 'Very Satisfactory': $adjectivalBadgeClass = 'primary'; break;
        case 'Satisfactory': $adjectivalBadgeClass = 'info'; break;
        case 'Unsatisfactory': $adjectivalBadgeClass = 'warning'; break;
        case 'Poor': $adjectivalBadgeClass = 'danger'; break;
    }
}
?>
<div class="card shadow mb-4">
    <div class="card-header py-2 bg-light">
        <h6 class="m-0 font-weight-bold text-dark">
            Part III: Summary of Ratings for Discussion
        </h6>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table class="table table-bordered text-center">
                    <tbody>
                        <tr>
                            <td class="font-weight-bold bg-light" width="60%">Final Performance Results<br><small>Accomplishments of KRAs and Objectives</small></td>
                            <td class="align-middle">
                                <?php if ($finalRating): ?>
                                    <span class="h4 mb-0 font-weight-bold"><?= number_format($finalRating, 2) ?></span>
                                    <br><span class="badge badge-<?= $adjectivalBadgeClass ?> px-3 py-2"><?= e($adjectivalRating) ?></span>
                                <?php else: ?>
                                    <span class="text-muted">Not yet rated</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Part II: Competencies -->
<form action="" method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="verifier" value="<?= cipher($ipcrfId) ?>">

    <div class="card shadow mb-4">
        <div class="card-header py-2 bg-light">
            <h6 class="m-0 font-weight-bold text-dark">
                Part II: Competencies
            </h6>
        </div>
        <div class="card-body">
            <p class="small text-muted mb-3">
                <strong>Rating Scale:</strong> 
                5 – Role Model; 
                4 – Consistently Demonstrates; 
                3 – Most of the Time Demonstrates; 
                2 – Sometimes Demonstrates; 
                1 – Rarely Demonstrates
            </p>

            <!-- Core Behavioral Competencies -->
            <h6 class="font-weight-bold text-primary mb-3">Core Behavioral Competencies</h6>
            
            <div class="row">
                <?php foreach ($coreBehavioralCompetencies as $key => $competency): ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header py-2 bg-light">
                            <strong><?= e($competency['title']) ?></strong>
                        </div>
                        <div class="card-body p-2">
                            <table class="table table-sm table-bordered mb-0 small">
                                <tbody>
                                    <?php foreach ($competency['items'] as $num => $desc): ?>
                                    <tr>
                                        <td width="85%"><?= $num ?>. <?= e($desc) ?></td>
                                        <td width="15%" class="text-center align-middle">
                                            <?php if ($isOwner || $isValidator): ?>
                                                <input type="number" name="competency[core_behavioral][<?= $key ?>][<?= $num ?>]" 
                                                    class="form-control form-control-sm text-center competency-rating" 
                                                    min="1" max="5" step="1"
                                                    value="<?= e($competencyIndex['core_behavioral'][$key . '_' . $num] ?? '') ?>"
                                                    data-category="core_behavioral">
                                            <?php else: ?>
                                                <span class="font-weight-bold"><?= e($competencyIndex['core_behavioral'][$key . '_' . $num] ?? '-') ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Core Behavioral Average -->
            <div class="row mb-4">
                <div class="col-md-6 offset-md-3">
                    <div class="alert alert-info mb-0 text-center">
                        <strong>CORE BEHAVIORAL COMPETENCIES Average:</strong>
                        <span class="h5 ml-2" id="coreBehavioralAvg"><?= $coreBehavioralAvg ? number_format($coreBehavioralAvg, 2) : '-' ?></span>
                    </div>
                </div>
            </div>

            <?php if ($isHead): ?>
            <!-- Leadership Competencies (for Heads/Supervisors) -->
            <hr>
            <h6 class="font-weight-bold text-primary mb-3">Leadership Competencies</h6>
            
            <div class="row">
                <?php foreach ($leadershipCompetencies as $key => $competency): ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header py-2 bg-light">
                            <strong><?= e($competency['title']) ?></strong>
                        </div>
                        <div class="card-body p-2">
                            <table class="table table-sm table-bordered mb-0 small">
                                <tbody>
                                    <?php foreach ($competency['items'] as $num => $desc): ?>
                                    <tr>
                                        <td width="85%"><?= $num ?>. <?= e($desc) ?></td>
                                        <td width="15%" class="text-center align-middle">
                                            <?php if ($isOwner || $isValidator): ?>
                                                <input type="number" name="competency[leadership][<?= $key ?>][<?= $num ?>]" 
                                                    class="form-control form-control-sm text-center competency-rating" 
                                                    min="1" max="5" step="1"
                                                    value="<?= e($competencyIndex['leadership'][$key . '_' . $num] ?? '') ?>"
                                                    data-category="leadership">
                                            <?php else: ?>
                                                <span class="font-weight-bold"><?= e($competencyIndex['leadership'][$key . '_' . $num] ?? '-') ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Leadership Average -->
            <div class="row mb-4">
                <div class="col-md-6 offset-md-3">
                    <div class="alert alert-warning mb-0 text-center">
                        <strong>LEADERSHIP COMPETENCIES Average:</strong>
                        <span class="h5 ml-2" id="leadershipAvg"><?= $leadershipAvg ? number_format($leadershipAvg, 2) : '-' ?></span>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <!-- Core Skills (for Teachers) -->
            <hr>
            <h6 class="font-weight-bold text-primary mb-3">Core Skills</h6>
            
            <div class="row">
                <?php foreach ($coreSkills as $key => $competency): ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header py-2 bg-light">
                            <strong><?= e($competency['title']) ?></strong>
                        </div>
                        <div class="card-body p-2">
                            <table class="table table-sm table-bordered mb-0 small">
                                <tbody>
                                    <?php foreach ($competency['items'] as $num => $desc): ?>
                                    <tr>
                                        <td width="85%"><?= $num ?>. <?= e($desc) ?></td>
                                        <td width="15%" class="text-center align-middle">
                                            <?php if ($isOwner || $isValidator): ?>
                                                <input type="number" name="competency[core_skills][<?= $key ?>][<?= $num ?>]" 
                                                    class="form-control form-control-sm text-center competency-rating" 
                                                    min="1" max="5" step="1"
                                                    value="<?= e($competencyIndex['core_skills'][$key . '_' . $num] ?? '') ?>"
                                                    data-category="core_skills">
                                            <?php else: ?>
                                                <span class="font-weight-bold"><?= e($competencyIndex['core_skills'][$key . '_' . $num] ?? '-') ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if ($isOwner || $isValidator): ?>
            <div class="text-center">
                <button type="submit" name="save-competencies" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Save Competency Ratings
                </button>
            </div>
            <?php endif; ?>
        </div>
    </div>
</form>

<!-- Part IV: Development Plans -->
<div class="card shadow mb-4">
    <div class="card-header py-2 bg-light d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-dark">
            Part IV: Development Plans
        </h6>
        <?php if ($isOwner || $isValidator): ?>
        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addPlanModal">
            <i class="fas fa-plus mr-1"></i> Add Plan
        </button>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <?php if (empty($developmentPlans)): ?>
            <div class="text-center py-4">
                <i class="fas fa-clipboard-list fa-3x text-gray-300 mb-3"></i>
                <p class="text-muted mb-0">No development plans added yet.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered small">
                    <thead class="bg-light">
                        <tr class="text-center">
                            <th width="15%">Strengths</th>
                            <th width="15%">Development Needs</th>
                            <th width="30%">Action Plan<br><small>(Recommended Development Intervention)</small></th>
                            <th width="15%">Timeline</th>
                            <th width="15%">Resources Needed</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($developmentPlans as $plan): ?>
                        <tr>
                            <td><?= nl2br(e($plan['strengths'])) ?></td>
                            <td><?= nl2br(e($plan['development_needs'])) ?></td>
                            <td><?= nl2br(e($plan['action_plan'])) ?></td>
                            <td class="text-center"><?= nl2br(e($plan['timeline'])) ?></td>
                            <td><?= nl2br(e($plan['resources'])) ?></td>
                            <td class="text-center">
                                <?php if ($isOwner || $isValidator): ?>
                                    <button type="button" class="btn btn-sm btn-outline-primary mb-1" 
                                        data-toggle="modal" data-target="#editPlanModal<?= $plan['id'] ?>" title="Edit">
                                        <i class="fas fa-edit fa-sm"></i>
                                    </button>
                                    <form action="" method="POST" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="plan_id" value="<?= cipher($plan['id']) ?>">
                                        <input type="hidden" name="verifier" value="<?= cipher($ipcrfId) ?>">
                                        <button type="submit" name="delete-plan" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Delete this development plan?')" title="Delete">
                                            <i class="fas fa-trash fa-sm"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Employee-Superior Agreement / Signatures -->
<div class="card shadow mb-4">
    <div class="card-header py-2 bg-light">
        <h6 class="m-0 font-weight-bold text-dark">
            Employee-Superior Agreement
        </h6>
    </div>
    <div class="card-body">
        <p class="small text-muted mb-3">
            The signatures below confirms that the employee and his/her superior have agreed to the contents of the performance as captured in this form.
        </p>
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <td class="font-weight-bold bg-light">Name of Employee:</td>
                        <td class="text-uppercase"><?= e(toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension'])) ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold bg-light">Signature:</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold bg-light">Date:</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <td class="font-weight-bold bg-light">Name of Superior:</td>
                        <td class="text-uppercase"><?= $validator ? e(toName($validator['last_name'], $validator['first_name'], $validator['middle_name'], $validator['name_extension'])) : '-' ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold bg-light">Signature:</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold bg-light">Date:</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <a href="<?= customUri('pis', 'IPCRF Details', $ipcrfId) ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Back to IPCRF
            </a>
        </div>
    </div>
</div>

<!-- Add Development Plan Modal -->
<div class="modal fade" id="addPlanModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="verifier" value="<?= cipher($ipcrfId) ?>">
                <div class="modal-header bg-success text-white">
                    <h6 class="modal-title font-weight-bold">
                        <i class="fas fa-plus mr-2"></i> Add Development Plan
                    </h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Strengths <span class="text-danger">*</span></label>
                        <textarea name="strengths" class="form-control" rows="2" required
                            placeholder="e.g., Team Work, Self-Management, Professional and Ethics"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Development Needs <span class="text-danger">*</span></label>
                        <textarea name="development_needs" class="form-control" rows="2" required
                            placeholder="e.g., Website Management, Word Press, File Server Management"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Action Plan (Recommended Development Intervention) <span class="text-danger">*</span></label>
                        <textarea name="action_plan" class="form-control" rows="3" required
                            placeholder="e.g., Attendance to Training Workshop on ICT related skills and communication skills."></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Timeline <span class="text-danger">*</span></label>
                                <input type="text" name="timeline" class="form-control" required
                                    placeholder="e.g., January 2024 to December 2024">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Resources Needed <span class="text-danger">*</span></label>
                                <textarea name="resources" class="form-control" rows="2" required
                                    placeholder="e.g., HRTD funds if allowed and other allowable funding resources"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="add-plan" class="btn btn-success">
                        <i class="fas fa-save mr-1"></i> Save Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Development Plan Modals -->
<?php foreach ($developmentPlans as $plan): ?>
<div class="modal fade" id="editPlanModal<?= $plan['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="verifier" value="<?= cipher($ipcrfId) ?>">
                <input type="hidden" name="plan_id" value="<?= cipher($plan['id']) ?>">
                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title font-weight-bold">
                        <i class="fas fa-edit mr-2"></i> Edit Development Plan
                    </h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Strengths <span class="text-danger">*</span></label>
                        <textarea name="strengths" class="form-control" rows="2" required><?= e($plan['strengths']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Development Needs <span class="text-danger">*</span></label>
                        <textarea name="development_needs" class="form-control" rows="2" required><?= e($plan['development_needs']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Action Plan (Recommended Development Intervention) <span class="text-danger">*</span></label>
                        <textarea name="action_plan" class="form-control" rows="3" required><?= e($plan['action_plan']) ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Timeline <span class="text-danger">*</span></label>
                                <input type="text" name="timeline" class="form-control" required value="<?= e($plan['timeline']) ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Resources Needed <span class="text-danger">*</span></label>
                                <textarea name="resources" class="form-control" rows="2" required><?= e($plan['resources']) ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="edit-plan" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Update Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>
