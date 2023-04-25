<?php
// includes/layout/content.php
if ($show_prompt) {
  message_prompt($message, $type, $align);
}

if (!isset($url) || $url === 'dashboard') {
  include_once('dashboard.php');
} else {
  $file = '';

  switch($url) {
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
    case 'Receive Document':
      $file = 'documents/receive-document';
      break;
    case 'Forward Document':
      $file = 'documents/forward-document';
      break;
    case 'Approve Document':
      $file = 'documents/approve-document';
      break;
    case 'Active Employees':
      $file = 'employees/active-employees';
      break;
    case 'Retirable Employees':
      $file = 'employees/retirable-employees';
      break;
    case 'Archived Employees':
      $file = 'employees/archived-employees';
      break;
    case 'Activity Log':
      $file = 'activity/activity-log';
      break;
    case 'Settings':
      $file = 'settings/settings';
      break;
    case '404';
    default:
      $file = 'error/404';
      break;
  }

  include_once(root() . "/modules/{$file}.php");
}
?>