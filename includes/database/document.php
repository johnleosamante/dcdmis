<?php
// transaction_purposes
function documentPurpose()
{
    $sql = "SELECT `name` FROM `transaction_purposes` ORDER BY `name` ASC";
    $result = query($sql);
    return is_array($result) ? $result : [];
}

// document_types
function documentTypes($for_school = false)
{
    $params = [];
    $where = "`id` <> '1'";
    if ($for_school) {
        $where .= " AND `for_school` = ?";
        $params[] = '1';
    }
    $sql = "SELECT `id`, `name` FROM `document_types` WHERE {$where} ORDER BY `name` ASC";
    $result = query($sql, $params);
    return is_array($result) ? $result : [];
}

function documentType($document_type_id)
{
    $sql = "SELECT `name` FROM `document_types` WHERE `id` = ? LIMIT 1";
    return find($sql, [$document_type_id]);
}

// document_transactions
function document($document_transaction_id)
{
    $sql = "SELECT * FROM `document_transactions` WHERE `id` = ? LIMIT 1";
    return find($sql, [$document_transaction_id]);
}

function isDocument($document_transaction_id, $status)
{
    $statusPattern = "%{$status}%";
    $sql = "SELECT `id` FROM `document_transactions` WHERE `id` = ? AND `status` LIKE ? LIMIT 1";
    $results = query($sql, [$document_transaction_id, $statusPattern]);
    return !empty($results);
}

function countDocumentsFrom($station_id, $year, $code)
{
    $pattern = "%{$code}-{$year}-%";
    $sql = "SELECT `id` FROM `document_transactions` WHERE `created_from` = ? AND `id` LIKE ?";
    $results = query($sql, [$station_id, $pattern]);
    return is_array($results) ? count($results) : 0;
}

// document_transactions, document_transaction_logs
function documentFrom($document_transaction_id, $station_id)
{
    $sql = "SELECT t.`id`, t.`description`, t.`document_type_id`, t.`created_from`, 
                t.`status`, t.`details`, t.`created_at` 
            FROM `document_transactions` AS t 
            INNER JOIN `document_transaction_logs` AS l ON t.`id` = l.`document_transaction_id` 
            WHERE t.`id` = ? AND (l.`received_from` = ? OR l.`forwarded_to` = ?) 
            GROUP BY t.`id` LIMIT 1";
    return find($sql, [$document_transaction_id, $station_id, $station_id]);
}

function documentOrigin($document_transaction_id)
{
    $sql = "SELECT t.`id`, t.`description`, t.`document_type_id`, t.`status`, t.`head_id`, t.`created_from`, 
                t.`created_at`, l.`processed_by`, l.`received_from` 
            FROM `document_transactions` AS t 
            INNER JOIN `document_transaction_logs` AS l ON t.`id` = l.`document_transaction_id` 
            WHERE t.`id` = ? ORDER BY l.`created_at` ASC LIMIT 1";
    return find($sql, [$document_transaction_id]);
}

// document_transaction_logs
function isDocumentFrom($document_transaction_id, $received_from)
{
    $sql = "SELECT `id` FROM `document_transaction_logs` 
            WHERE `received_from` = ? AND `is_new` = '1' AND `document_transaction_id` = ? LIMIT 1";
    $results = query($sql, [$received_from, $document_transaction_id]);
    return is_array($results) && count($results) > 0;
}

// document_transactions
function createDocument($document_transaction_id, $description, $document_type_id, $created_from, $status, $head_id, $details = '')
{
    $data = [
        'id' => $document_transaction_id,
        'document_type_id' => $document_type_id,
        'description' => $description,
        'created_from' => $created_from,
        'status' => $status,
        'is_unread' => '1',
        'head_id' => $head_id,
        'details' => $details
    ];
    return insert('document_transactions', $data);
}

function updateDocument($document_transaction_id, $description, $document_type_id, $status, $details = '', $update_description = true)
{
    $data = [
        'status' => $status,
        'details' => $details
    ];
    if ($update_description) {
        $data['description'] = $description;
        $data['document_type_id'] = $document_type_id;
    }
    return update('document_transactions', $data, "`id` = ?", [$document_transaction_id]);
}

// document_transactions, document_transaction_logs
function incomingDocuments($station_id)
{
    $sql = "SELECT t.`id`, t.`description`, l.`received_from`, l.`created_at`, t.`status`, t.`created_from` FROM `document_transactions` AS t 
            INNER JOIN `document_transaction_logs` AS l ON t.`id` = l.`document_transaction_id` 
            WHERE l.`forwarded_to` = ? AND l.`is_new` = '1' ORDER BY l.`created_at` DESC";
    $results = query($sql, [$station_id]);
    return is_array($results) ? $results : [];
}

function isIncomingDocument($document_transaction_id, $station_id)
{
    $sql = "SELECT t.`id` FROM `document_transactions` AS t 
            INNER JOIN `document_transaction_logs` AS l ON t.`id` = l.`document_transaction_id` 
            WHERE t.`id` = ? AND l.`forwarded_to` = ? AND l.`is_new` = '1' 
            ORDER BY l.`created_at` DESC LIMIT 1";
    $results = query($sql, [$document_transaction_id, $station_id]);
    return is_array($results) && count($results) > 0;
}

function pendingDocuments($station_id)
{
    $sql = "SELECT t.`id`, t.`description`, l.`processed_by`, t.`created_from`, l.`created_at`
            FROM `document_transactions` AS t 
            INNER JOIN `document_transaction_logs` AS l ON t.`id` = l.`document_transaction_id` 
            WHERE l.`received_from` = ? AND l.`forwarded_to` = '-' AND l.`is_new` = '1' 
                AND t.`status` NOT LIKE '%Complete%' AND t.`status` NOT LIKE '%Cancel%' 
            ORDER BY l.`created_at` DESC";
    $results = query($sql, [$station_id]);
    return is_array($results) ? $results : [];
}

function isPendingDocument($document_transaction_id, $station_id)
{
    $sql = "SELECT t.`id` FROM `document_transactions` AS t 
            INNER JOIN `document_transaction_logs` AS l ON t.`id` = l.`document_transaction_id` 
            WHERE t.`id` = ? AND l.`received_from` = ? AND l.`forwarded_to` = '-' AND l.`is_new` = '1' 
                AND t.`status` NOT LIKE '%Complete%' AND t.`status` NOT LIKE '%Cancel%' 
            ORDER BY l.`created_at` DESC LIMIT 1";
    $results = query($sql, [$document_transaction_id, $station_id]);
    return is_array($results) && count($results) > 0;
}

function outgoingDocuments($station_id)
{
    $sql = "SELECT t.`id`, t.`description`, l.`forwarded_to`, l.`processed_by`, 
                t.`created_from`, l.`created_at` 
            FROM `document_transaction_logs` AS l 
            INNER JOIN `document_transactions` AS t ON l.`document_transaction_id` = t.`id` 
            WHERE l.`received_from` = ? AND t.`status` NOT LIKE '%Complete%' AND t.`status` NOT LIKE '%Cancel%' 
                AND l.`forwarded_to` <> '' AND l.`forwarded_to` <> '-' AND l.`is_new` = '1' 
            ORDER BY l.`created_at` DESC";
    $results = query($sql, [$station_id]);
    return is_array($results) ? $results : [];
}

function isOutgoingDocument($document_transaction_id, $station_id)
{
    $sql = "SELECT t.`id` FROM `document_transactions` AS t 
            INNER JOIN `document_transaction_logs` AS l ON t.`id` = l.`document_transaction_id` 
            WHERE t.`id` = ? AND l.`received_from` = ? AND t.`status` NOT LIKE '%Complete%' 
                AND t.`status` NOT LIKE '%Cancel%' AND l.`forwarded_to` <> '' AND l.`forwarded_to` <> '-' 
                AND l.`is_new` = '1' LIMIT 1";
    $results = query($sql, [$document_transaction_id, $station_id]);
    return is_array($results) && count($results) > 0;
}

function ongoingDocuments($station_id)
{
    $sql = "SELECT t.`id`, t.`description`, l.`forwarded_to`, t.`created_from`,
                t.`status`, t.`created_at`
            FROM `document_transactions` AS t
            INNER JOIN `document_transaction_logs` AS l ON l.`document_transaction_id` = t.`id` 
            WHERE t.`created_from` = ? AND t.`status` NOT LIKE '%Complete%' AND l.`status` NOT LIKE '%Complete%' 
                AND t.`status` NOT LIKE '%Cancel%' AND l.`status` NOT LIKE '%Cancel%' 
            GROUP BY t.`id` ORDER BY l.`created_at` DESC";
    $results = query($sql, [$station_id]);
    return is_array($results) ? $results : [];
}

function isOngoingDocument($document_transaction_id, $station_id)
{
    $sql = "SELECT t.`id` FROM `document_transactions` AS t 
            INNER JOIN `document_transaction_logs` AS l ON t.`id` = l.`document_transaction_id` 
            WHERE t.`id` = ? AND t.`created_from` = ? AND t.`status` NOT LIKE '%Complete%' 
                AND l.`status` NOT LIKE '%Complete%' AND t.`status` NOT LIKE '%Cancel%' 
                AND l.`status` NOT LIKE '%Cancel%' 
            GROUP BY t.`id` LIMIT 1";
    $results = query($sql, [$document_transaction_id, $station_id]);
    return is_array($results) && count($results) > 0;
}

function completedDocuments($station_id, $from_date, $to_date)
{
    $sql = "SELECT t.`id`, t.`description`, t.`document_type_id`, t.`created_at` AS `posted_on`, 
                l.`created_at` AS `completed_on`, t.`created_from` 
            FROM `document_transactions` AS t 
            INNER JOIN `document_transaction_logs` AS l ON l.`document_transaction_id` = t.`id` 
            WHERE t.`created_from` = ? AND t.`status` LIKE '%Complete%' AND l.`status` LIKE '%Complete%' 
                AND l.`created_at` >= ? AND l.`created_at` < DATE_ADD(?, INTERVAL 1 DAY) 
            ORDER BY l.`created_at` DESC";
    return query($sql, [$station_id, $from_date, $to_date]);
}

function isCompletedDocument($document_transaction_id, $station_id)
{
    $sql = "SELECT t.`id` FROM `document_transactions` AS t 
            INNER JOIN `document_transaction_logs` AS l ON t.`id` = l.`document_transaction_id` 
            WHERE t.`id` = ? AND t.`created_from` = ? AND t.`status` LIKE '%Complete%' 
                AND l.`status` LIKE '%Complete%' LIMIT 1";
    $results = query($sql, [$document_transaction_id, $station_id]);
    return !empty($results);
}

// document_transaction_logs
function wasDocumentCompleted($document_transaction_id, $station_id)
{
    $sql = "SELECT `document_transaction_id` FROM `document_transaction_logs` 
            WHERE `document_transaction_id` = ? AND `received_from` = ? AND `status` = 'Completed' LIMIT 1";
    $results = query($sql, [$document_transaction_id, $station_id]);
    return !empty($results);
}

// document_transaction_logs, document_transactions
function receivedDocuments($station_id, $from_date, $to_date)
{
    $sql = "SELECT t.`id`, t.`description`, t.`document_type_id`, l.`created_at`, 
                l.`processed_by`, t.`created_from` 
            FROM `document_transaction_logs` AS l 
            INNER JOIN `document_transactions` AS t ON l.`document_transaction_id` = t.`id` 
            WHERE t.`created_from` <> ? AND l.`received_from` = ? AND l.`forwarded_to` = '-' 
                AND (l.`status` LIKE '%Received%' OR l.`status` LIKE '%On Process%') 
                AND l.`is_new` = '0' AND l.`created_at` >= ? AND l.`created_at` < DATE_ADD(?, INTERVAL 1 DAY) 
            ORDER BY l.`created_at` DESC";
    return query($sql, [$station_id, $station_id, $from_date, $to_date]);
}

function isReceivedDocument($document_transaction_id, $station_id)
{
    $sql = "SELECT t.`id` FROM `document_transactions` AS t 
            INNER JOIN `document_transaction_logs` AS l ON l.`document_transaction_id` = t.`id` 
            WHERE t.`id` = ? AND t.`created_from` <> ? AND l.`received_from` = ? AND l.`forwarded_to` = '-' 
                AND (l.`status` LIKE '%Received%' OR l.`status` LIKE '%On Process%') AND l.`status` = 'Done' LIMIT 1";
    $results = query($sql, [$document_transaction_id, $station_id, $station_id]);
    return !empty($results);
}

function canceledDocuments($station_id, $from_date, $to_date)
{
    $sql = "SELECT t.`id`, t.`description`, t.`document_type_id`, t.`created_at` AS `posted_on`, 
                l.`created_at` AS `canceled_on`, t.`created_from` 
            FROM `document_transactions` AS t 
            INNER JOIN `document_transaction_logs` AS l ON l.`document_transaction_id` = t.`id` 
            WHERE t.`created_from` = ? AND t.`status` LIKE '%Cancel%' AND l.`status` LIKE '%Cancel%' 
                AND l.`created_at` >= ? AND l.`created_at` < DATE_ADD(?, INTERVAL 1 DAY) 
            ORDER BY l.`created_at` DESC";
    return query($sql, [$station_id, $from_date, $to_date]);
}

function isCanceledDocument($document_transaction_id, $station_id)
{
    $sql = "SELECT t.`id` FROM `document_transactions` AS t 
            INNER JOIN `document_transaction_logs` AS l ON t.`id` = l.`document_transaction_id` 
            WHERE t.`id` = ? AND t.`created_from` = ? AND t.`status` LIKE '%Cancel%' AND l.`status` LIKE '%Cancel%' 
            ORDER BY l.`created_at` DESC LIMIT 1";
    $results = query($sql, [$document_transaction_id, $station_id]);
    return !empty($results);
}

function documentLog($document_transaction_id)
{
    $sql = "SELECT t.`id`, t.`description`, t.`document_type_id`, t.`created_from`, 
                l.`created_at`, l.`forwarded_to`, l.`status`, l.`details` 
            FROM `document_transactions` AS t 
            INNER JOIN `document_transaction_logs` AS l ON t.`id` = l.`document_transaction_id` 
            WHERE t.`id` = ? ORDER BY l.`created_at` DESC LIMIT 1";
    return find($sql, [$document_transaction_id]);
}

// document_transaction_logs
function documentLogs($document_transaction_id)
{
    return query(
        "SELECT `id`, `processed_by`, `received_from`, `forwarded_to`, `status`, `details`, `created_at` FROM `document_transaction_logs` 
        WHERE `document_transaction_id` = ? ORDER BY `created_at` DESC",
        [$document_transaction_id]
    );
}

function createDocumentLog($document_transaction_id, $processed_by, $received_from, $forwarded_to, $purpose, $is_new = true, $details = '')
{
    $data = [
        'processed_by' => $processed_by,
        'received_from' => $received_from,
        'forwarded_to' => $forwarded_to,
        'status' => $purpose,
        'document_transaction_id' => $document_transaction_id,
        'is_new' => $is_new,
        'details' => $details
    ];
    return insert('document_transaction_logs', $data);
}

function updateDocumentLog($document_transaction_id, $processed_by, $received_from, $forwarded_to, $purpose, $is_new = true, $details = '')
{
    $latest = find(
        "SELECT `id` FROM `document_transaction_logs` WHERE `document_transaction_id` = ? 
        ORDER BY `created_at` DESC LIMIT 1",
        [$document_transaction_id]
    );
    if (!$latest) {
        return 0;
    }
    $log_id = $latest['id'];
    $data = [
        'processed_by' => $processed_by,
        'received_from' => $received_from,
        'forwarded_to' => $forwarded_to,
        'status' => $purpose,
        'is_new' => $is_new,
        'details' => $details,
    ];
    return update('document_transaction_logs', $data, '`id` = ?', [$log_id]);
}

function updateDocumentLogsDone($document_transaction_id)
{
    return update(
        'document_transaction_logs',
        ['is_new' => false],
        "`document_transaction_id` = ? AND `is_new` = 1",
        [$document_transaction_id,]
    );
}

// document_transactions
function updateDocumentStatus($document_transaction_id, $status, $is_unread = true, $details = '')
{
    $data = [
        'status' => $status,
        'is_unread' => $is_unread,
        'details' => $details
    ];
    return update('document_transactions', $data, '`id` = ?', [$document_transaction_id]);
}

function documentLogAttachments($document_transaction_id, $document_transaction_log_id)
{
    return query(
        "SELECT `id`, `file_name`, `file_extension` FROM `document_transaction_log_attachments` WHERE `document_transaction_id` = ? AND `document_transaction_log_id` = ?",
        [$document_transaction_id, $document_transaction_log_id]
    );
}

function createDocumentLogAttachment($document_transaction_id, $document_transaction_log_id, $file_name, $file_extension)
{
    $data = [
        'document_transaction_id' => $document_transaction_id,
        'document_transaction_log_id' => $document_transaction_log_id,
        'file_name' => $file_name,
        'file_extension' => $file_extension
    ];
    return insert('document_transaction_log_attachments', $data);
}

// document_transaction_logs
function updateTransactionLogFrom($new_alias, $old_alias)
{
    if ($new_alias === $old_alias) {
        return 0;
    }
    return update(
        'document_transaction_logs',
        ['received_from' => $new_alias],
        '`received_from` = ?',
        [$old_alias]
    );
}

function updateTransactionLogTo($new_alias, $old_alias)
{
    if ($new_alias === $old_alias) {
        return 0;
    }
    return update(
        'document_transaction_logs',
        ['forwarded_to' => $new_alias],
        '`forwarded_to` = ?',
        [$old_alias]
    );
}

// document_transactions
function updateTransactionFrom($new_alias, $old_alias)
{
    if ($new_alias === $old_alias) {
        return 0;
    }
    return update(
        'document_transactions',
        ['created_from' => $new_alias],
        '`created_from` = ?',
        [$old_alias]
    );
}

// system_logs
function documentByStatus($status, $person_id, $station_id, $from_date = '', $to_date = '')
{
    $station_filter = "$station_id%";
    if (empty($from_date)) {
        $from_date = date('Y-m-d');
    }
    if (empty($to_date)) {
        $to_date = $from_date;
    }
    $sql = "SELECT COUNT(*) AS `count` FROM `system_logs` WHERE `status` = ? AND `target_id` 
            LIKE ? AND `person_id` = ? AND `created_at` >= ? AND `created_at` < DATE_ADD(?, INTERVAL 1 DAY)";
    $row = find($sql, [$status, $station_filter, $person_id, $from_date, $to_date]);
    return $row ? (int) $row['count'] : 0;
}

function documentSearch($string, $station_id)
{
    $searchTerm = "%{$string}%";

    $sql = "SELECT t.`id`, t.`description`, t.`created_from`, t.`status`, t.`created_at`  
            FROM `document_transactions` AS t 
            WHERE (
                t.`id` LIKE ?
                OR MATCH(t.`description`) AGAINST (? IN BOOLEAN MODE)
                OR EXISTS (
                    SELECT 1
                    FROM `document_transaction_logs` AS l
                    WHERE l.`document_transaction_id` = t.`id`
                        AND MATCH(l.`details`) AGAINST(? IN BOOLEAN MODE)
                        AND (l.`received_from` = ? OR l.`forwarded_to` = ?)
                )
            ) ORDER BY t.`created_at` DESC LIMIT 1000;";
    return query($sql, [$searchTerm, $searchTerm, $searchTerm, $station_id, $station_id]);
}