<?php
// includes/layout/content.php
if (!isset($url) || $url === 'dashboard') {
    require_once('dashboard.php');
} else {
    $file = '';

    switch ($url) {
        case 'Incoming Documents':
            $file = 'documents/incoming-documents';
            break;
        case 'Pending Documents':
            $file = 'documents/pending-documents';
            break;
        case 'Outgoing Documents':
            $file = 'documents/outgoing-documents';
            break;
        case 'Ongoing Documents':
            $file = 'documents/ongoing-documents';
            break;
        case 'Completed Documents':
            $file = 'documents/completed-documents';
            break;
        case 'Received Documents':
            $file = 'documents/received-documents';
            break;
        case 'Canceled Documents':
            $file = 'documents/canceled-documents';
            break;
        case 'Document Information':
            $file = 'documents/document-information';
            break;
        case 'Document Search':
            $file = 'documents/document-search';
            break;
        case 'Edit Document':
            $file = 'documents/edit-document';
            break;
        case 'Receive Document':
            $file = 'documents/receive-document';
            break;
        case 'Forward Document':
            $file = 'documents/forward-document';
            break;
        case 'Approve Document':
            $file = 'documents/approve-document';
            break;
        case 'Transactions':
            $file = 'documents/transactions';
            break;
        case 'Active Employees':
        case 'Employees':
            $file = 'employees/active-employees';
            break;
        case 'Retirable Employees':
            $file = 'employees/retirable-employees';
            break;
        case 'Archived Employees':
            $file = 'employees/archived-employees';
            break;
        case 'Employee Information':
        case 'Edit Employee Information':
            $file = 'employees/employee-information';
            break;
        case 'Service Record':
            $file = 'service-record/page';
            break;
        case '201 Files':
            $file = '201-file/page';
            break;
        case 'Payslips':
            $file = 'payslip/page';
            break;
        case 'Step Increment':
            $file = 'step-increment/page';
            break;
        case 'Loyalty Award':
            $file = 'loyalty-award/page';
            break;
        case 'Employee Search':
            $file = 'employees/employee-search';
            break;
        case 'Celebrant Employees':
            $file = 'employees/celebrant-employees';
            break;
        case 'Employees by Position':
            $file = 'employees/employees-position';
            break;
        case 'Users':
            $file = 'users/page';
            break;
        case 'Event Schedules':
        case 'Awards List':
        case 'Nominees List':
        case 'Winners Lookup':
        case 'Awards and Recognitions':
            $file = 'race/page';
            break;
        case 'Trainings':
            $file = 'trainings/attended-trainings';
            break;
        case 'Scheduled Trainings':
            $file = 'trainings/scheduled-trainings';
            break;
        case 'Conducted Trainings':
            $file = 'trainings/conducted-trainings';
            break;
        case 'Training Details':
            $file = 'trainings/training-details';
            break;
        case 'Add Training Participants':
            $file = 'trainings/add-training-participants';
            break;
        case 'Districts':
            $file = 'districts/page';
            break;
        case 'District Information':
            $file = 'districts/district-information';
            break;
        case 'Schools':
            $file = 'schools/page';
            break;
        case 'Positions':
            $file = 'positions/page';
            break;
        case 'Plantilla Items':
            $file = 'positions/plantilla-items';
            break;
        case 'School Information':
            $file = 'schools/school-information';
            break;
        case 'Sections':
            $file = 'sections/page';
            break;
        case 'Section Information':
            $file = 'sections/section-information';
            break;
        case 'Activity Log':
            $file = 'activity/page';
            break;
        case 'Edit History':
            $file = 'activity/edit-history';
            break;
        case 'System Logs':
            $file = 'activity/system-log';
            break;
        case 'Transactions Summary':
        case 'Section Summary':
            $file = 'documents/transactions-summary';
            break;
        case 'Settings':
            $file = 'settings/page';
            break;
        case 'Vacancies':
            $file = 'vacancies/page';
            break;
        case 'Create Call for Application':
        case 'Edit Call for Application':
            $file = 'vacancies/publish-vacancies';
            break;
        case 'Call for Application Details':
            $file = 'vacancies/publication-details';
            break;
        case 'Qualified Applicants':
            $file = 'vacancies/qualified-applicants';
            break;
        case 'Comparative Assessment Results':
            $file = 'vacancies/comparative-assessment-results';
            break;
        case 'Assess Applicant':
            $file = 'vacancies/assess-applicant';
            break;
        case 'Disqualified Applicants':
            $file = 'vacancies/disqualified-applicants';
            break;
        case 'Call for Applications':
            $file = 'vacancies/publications';
            break;
        case 'Monitoring Tools':
            $file = 'tools/index';
            break;
        case 'Demographics - Gender':
        case 'Demographics - Category':
        case 'Demographics - Category by Gender':
        case 'Demographics - Position':
        case 'Demographics - Generation':
        case 'Demographics - Education':
        case 'Demographics - Religion':
        case 'Demographics - Ethnic Group':
        case 'Demographics - PWD':
        case 'Demographics - Solo Parent':
        case 'Demographics - District':
        case 'Demographics - Assignment':
            $file = 'employees/demographics/page';
            break;
        case '404':
        default:
            $file = 'error/404';
            break;
    }

    require_once(root() . "/modules/{$file}.php");
}
