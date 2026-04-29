<?php
// includes/database/document.php
function documentTransactionStatus(?int $status_id = null): string|array
{
    $sql = "SELECT `id`, `name` FROM `document_transaction_statuses`";
    if ($status_id) {
        $sql .= " WHERE `id` = ? LIMIT 1";
        $row = find($sql, [$status_id]);
        return $row['name'] ?? '';
    }
    $sql .= " WHERE `for_processing` = 1 ORDER BY `name` ASC";
    $result = query($sql);
    return is_array($result) ? $result : [];
}

function documentStatusId(string $status): int|null
{
    $sql = "SELECT `id` FROM `document_transaction_statuses` WHERE `name` = ? LIMIT 1";
    $result = find($sql, [$status]);
    return $result ? (int) $result['id'] : null;
}

function documentTypes(bool $for_school = false): array
{
    $where = ["`id` <> 1"];
    $params = [];
    if ($for_school) {
        $where[] = "`for_school` = ?";
        $params[] = 1;
    }
    $whereClause = implode(" AND ", $where);
    $sql = "SELECT `id`, `name` FROM `document_types` WHERE $whereClause ORDER BY `name` ASC";
    $result = query($sql, $params);
    return is_array($result) ? $result : [];
}

function documentType(int $document_type_id): string
{
    $sql = "SELECT `name` FROM `document_types` WHERE `id` = ? LIMIT 1";
    $result = find($sql, [$document_type_id]);
    return $result['name'] ?? '';
}

function document($document_transaction_id)
{
    $sql = "SELECT t.id, t.document_type_id, t.description, t.created_from, t.head_id, t.created_at, l.status_id FROM `document_transactions` AS t
            INNER JOIN `document_transaction_logs` AS l ON l.document_transaction_id = t.id
            WHERE t.id = ? AND l.is_new = 1 LIMIT 1";
    return find($sql, [$document_transaction_id]);
}

function isDocument($document_transaction_id, $status): bool
{
    $sql = "SELECT 1 
            FROM `document_transaction_logs` AS l 
            INNER JOIN `document_transaction_statuses` AS s ON l.status_id = s.id 
            WHERE l.document_transaction_id = ? 
              AND s.name LIKE ? AND l.is_new=1
            LIMIT 1";
    $statusPattern = "%{$status}%";
    $result = find($sql, [$document_transaction_id, $statusPattern]);
    return !empty($result);
}

function countDocumentsFrom($station_id, $year, $code)
{
    $sql = "SELECT COUNT(`id`) AS `total` 
            FROM `document_transactions` 
            WHERE `created_from` = ? 
              AND `id` LIKE ?";
    $pattern = "{$code}-{$year}-%";
    $result = find($sql, [$station_id, $pattern]);
    return (int) ($result['total'] ?? 0);
}

function documentOrigin($document_transaction_id)
{
    $sql = "SELECT 
                t.id, 
                t.description, 
                t.document_type_id, 
                l.status_id, 
                l.details, 
                t.head_id, 
                t.created_from, 
                t.created_at,
                l.created_at AS processed_at, 
                l.processor_id, 
                l.received_from 
            FROM `document_transactions` AS t 
            INNER JOIN `document_transaction_logs` AS l ON t.id = l.document_transaction_id 
            WHERE t.id = ? 
            ORDER BY l.created_at ASC 
            LIMIT 1";
    return find($sql, [$document_transaction_id]);
}

function isDocumentFrom($document_transaction_id, $received_from): bool
{
    $sql = "SELECT 1 FROM `document_transaction_logs` 
            WHERE `document_transaction_id` = ? 
              AND `received_from` = ? 
              AND `is_new` = 1 
            LIMIT 1";
    $results = query($sql, [$document_transaction_id, $received_from]);
    return !empty($results);
}

// document_transactions
function createDocument($document_transaction_id, $description, $document_type_id, $created_from, $head_id)
{
    $data = [
        'id' => $document_transaction_id,
        'document_type_id' => $document_type_id,
        'description' => $description,
        'created_from' => $created_from,
        'head_id' => $head_id,
    ];
    return insert('document_transactions', $data);
}

function updateDocument($document_transaction_id, $description, $document_type_id, $update_description = true)
{
    $data = [];
    if ($update_description) {
        $data['description'] = $description;
        $data['document_type_id'] = $document_type_id;
    }
    if (empty($data)) {
        return false;
    }
    return update('document_transactions', $data, "`id` = ?", [$document_transaction_id]);
}

function incomingDocuments($station_id)
{
    $sql = "SELECT 
                t.id, 
                t.description, 
                l.status_id, 
                t.created_from,
                l.received_from, 
                l.created_at
            FROM `document_transaction_logs` AS l 
            INNER JOIN `document_transactions` AS t ON l.document_transaction_id = t.id 
            WHERE l.received_from IS NOT NULL
                AND l.forwarded_to = ?
                AND l.status_id NOT IN (10, 11)
                AND l.is_new = 1 
            ORDER BY l.created_at DESC LIMIT 1000";
    $results = query($sql, [$station_id]);
    return is_array($results) ? $results : [];
}

function countIncomingDocuments($station_id)
{
    $sql = "SELECT COUNT(DISTINCT document_transaction_id) AS `count` 
            FROM `document_transaction_logs` 
            WHERE received_from IS NOT NULL
                AND forwarded_to = ?
                AND status_id NOT IN (10, 11)
                AND is_new = 1";
    $result = find($sql, [$station_id]);
    return (int) ($result['count'] ?? 0);
}

function isIncomingDocument($document_transaction_id, $station_id): bool
{
    $sql = "SELECT 1 FROM `document_transaction_logs` 
            WHERE `document_transaction_id` = ?
                AND received_from IS NOT NULL 
                AND forwarded_to = ? 
                AND status_id NOT IN (10, 11)
                AND is_new = 1
            LIMIT 1";
    $results = find($sql, [$document_transaction_id, $station_id]);

    return (bool) $results;
}

function pendingDocuments($station_id)
{
    $sql = "SELECT 
                t.id, 
                t.description, 
                l.processor_id, 
                t.created_from, 
                l.created_at
            FROM `document_transaction_logs` AS l 
            INNER JOIN `document_transactions` AS t ON l.document_transaction_id = t.id 
            WHERE l.received_from = ?
                AND l.forwarded_to IS NULL
                AND l.status_id NOT IN (10, 11)
                AND l.is_new = 1
            ORDER BY l.created_at DESC LIMIT 1000";
    $results = query($sql, [$station_id]);
    return is_array($results) ? $results : [];
}

function countPendingDocuments($station_id)
{
    $sql = "SELECT COUNT(DISTINCT document_transaction_id) AS `count` 
            FROM `document_transaction_logs`
            WHERE received_from = ?
                AND forwarded_to IS NULL
                AND status_id NOT IN (10, 11)
                AND is_new = 1";
    $result = find($sql, [$station_id]);
    return (int) ($result['count'] ?? 0);
}

function isPendingDocument($document_transaction_id, $station_id): bool
{
    $sql = "SELECT 1 FROM `document_transaction_logs`
            WHERE document_transaction_id = ? 
              AND received_from = ? 
              AND forwarded_to IS NULL
              AND status_id NOT IN (10, 11)
              AND is_new = 1";
    $results = find($sql, [$document_transaction_id, $station_id]);
    return (bool) $results;
}

function outgoingDocuments($station_id)
{
    $sql = "SELECT 
                t.id, 
                t.description, 
                l.forwarded_to, 
                l.processor_id, 
                t.created_from, 
                l.created_at 
            FROM `document_transaction_logs` AS l 
            INNER JOIN `document_transactions` AS t ON l.document_transaction_id = t.id 
            WHERE l.received_from = ?
                AND l.forwarded_to IS NOT NULL
                AND l.status_id NOT IN (10, 11)
                AND l.is_new = 1
            ORDER BY l.created_at DESC LIMIT 1000";
    $results = query($sql, [$station_id]);
    return is_array($results) ? $results : [];
}

function countOutgoingDocuments($station_id)
{
    $sql = "SELECT COUNT(DISTINCT document_transaction_id) AS `count` 
            FROM `document_transaction_logs`
            WHERE received_from = ?
                AND forwarded_to IS NOT NULL 
                AND status_id NOT IN (10, 11)
                AND is_new = 1";
    $result = find($sql, [$station_id]);
    return (int) ($result['count'] ?? 0);
}

function isOutgoingDocument($document_transaction_id, $station_id): bool
{
    $sql = "SELECT 1 FROM `document_transaction_logs` 
            WHERE document_transaction_id = ? 
                AND received_from = ?
                AND forwarded_to IS NOT NULL
                AND status_id NOT IN (10, 11)
                AND is_new = 1 
            LIMIT 1";
    $results = find($sql, [$document_transaction_id, $station_id]);
    return (bool) $results;
}

function ongoingDocuments($station_id)
{
    $sql = "SELECT 
                t.id, 
                t.description, 
                l.forwarded_to, 
                t.created_from,
                l.status_id, 
                t.created_at
            FROM `document_transactions` AS t
            INNER JOIN `document_transaction_logs` AS l ON t.id = l.document_transaction_id 
            WHERE t.created_from = ?
                AND l.forwarded_to IS NOT NULL
                AND l.status_id NOT IN (10, 11)
            GROUP BY t.id 
            ORDER BY l.created_at DESC LIMIT 1000";
    $results = query($sql, [$station_id]);
    return is_array($results) ? $results : [];
}

function countOngoingDocuments($station_id)
{
    $sql = "SELECT COUNT(DISTINCT t.id) AS `count` 
            FROM `document_transactions` AS t
            INNER JOIN `document_transaction_logs` AS l ON t.id = l.document_transaction_id 
            WHERE t.created_from = ?
                AND l.forwarded_to IS NOT NULL
                AND l.status_id NOT IN (10, 11)";
    $result = find($sql, [$station_id]);
    return (int) ($result['count'] ?? 0);
}

function completedDocuments($station_id, $from_date, $to_date)
{
    $sql = "SELECT 
                t.`id`, 
                t.`description`, 
                t.`document_type_id`, 
                t.`created_at` AS `posted_on`, 
                l.`created_at` AS `completed_on`, 
                t.`created_from` 
            FROM `document_transactions` AS `t` 
            INNER JOIN `document_transaction_logs` AS `l` ON t.`id` = l.`document_transaction_id` 
            WHERE t.`created_from` = ?
                AND l.`forwarded_to` IS NULL
                AND l.`status_id` = 10
                AND l.`is_new` = 1
                AND l.`created_at` >= ? 
                AND l.`created_at` < DATE_ADD(?, INTERVAL 1 DAY) 
            ORDER BY l.`created_at` DESC LIMIT 1000";
    return query($sql, [$station_id, $from_date, $to_date]);
}

function isCompletedDocument($document_transaction_id, $station_id): bool
{
    $sql = "SELECT 1 FROM `document_transactions` AS t 
            INNER JOIN `document_transaction_logs` AS l ON t.id = l.document_transaction_id 
            WHERE t.id = ? 
              AND t.created_from = ? 
              AND l.forwarded_to IS NULL
              AND l.status_id = 10
              AND l.is_new = 1 
            LIMIT 1";
    $results = find($sql, [$document_transaction_id, $station_id]);
    return (bool) $results;
}

function receivedDocuments($station_id, $from_date, $to_date)
{
    $sql = "SELECT 
                t.`id`, 
                t.`description`, 
                t.`document_type_id`, 
                t.`created_from`,
                l.`created_at`, 
                l.`processor_id`
            FROM `document_transaction_logs` AS `l` 
            INNER JOIN `document_transactions` AS `t` ON l.`document_transaction_id` = t.`id` 
            WHERE t.`created_from` != ?
                AND l.`received_from` = ?
                AND l.`forwarded_to` IS NULL
                AND l.`status_id` = 9
                AND l.`created_at` >= ? 
                AND l.`created_at` < DATE_ADD(?, INTERVAL 1 DAY) 
            ORDER BY l.`created_at` DESC 
            LIMIT 1000";
    return query($sql, [$station_id, $station_id, $from_date, $to_date]);
}

function isReceivedDocument($document_transaction_id, $station_id): bool
{
    $sql = "SELECT 1 FROM `document_transactions` AS t 
            INNER JOIN `document_transaction_logs` AS l ON t.`id` = l.`document_transaction_id` 
            WHERE t.`id` = ? 
                AND t.`created_from` != ?
                AND l.`received_from` = ?
                AND l.`forwarded_to` IS NULL
                AND l.`status_id` = 9
            LIMIT 1";
    $results = find($sql, [$document_transaction_id, $station_id, $station_id]);
    return (bool) $results;
}

function canceledDocuments($station_id, $from_date, $to_date)
{
    $sql = "SELECT 
                t.id, 
                t.description, 
                t.document_type_id, 
                t.created_at AS posted_on, 
                l.created_at AS canceled_on, 
                t.created_from 
            FROM `document_transactions` AS t 
            INNER JOIN `document_transaction_logs` AS l ON t.id = l.document_transaction_id 
            WHERE t.created_from = ?
                AND l.forwarded_to IS NULL
                AND l.status_id = 11
                AND l.is_new = 1 
                AND l.created_at >= ? 
                AND l.created_at < DATE_ADD(?, INTERVAL 1 DAY) 
            ORDER BY l.created_at DESC LIMIT 1000";
    return query($sql, [$station_id, $from_date, $to_date]);
}

function isCanceledDocument($document_transaction_id, $station_id): bool
{
    $sql = "SELECT 1 FROM `document_transactions` AS t
            INNER JOIN `document_transaction_logs` AS l ON t.`id` = l.`document_transaction_id`
            WHERE t.`id` = ?
                AND t.created_from = ?
                AND l.forwarded_to IS NULL
                AND l.status_id = 11
                AND l.is_new = 1
            LIMIT 1";
    $results = find($sql, [$document_transaction_id, $station_id]);
    return (bool) $results;
}

function documentLog($document_transaction_id)
{
    $sql = "SELECT 
                t.id, 
                t.description, 
                t.document_type_id, 
                t.created_from, 
                l.created_at, 
                l.forwarded_to, 
                l.status_id, 
                l.details 
            FROM `document_transactions` AS t 
            INNER JOIN `document_transaction_logs` AS l ON t.id = l.document_transaction_id 
            WHERE t.id = ? 
            ORDER BY l.created_at DESC 
            LIMIT 1";
    return find($sql, [$document_transaction_id]);
}

function documentLogs($document_transaction_id)
{
    $sql = "SELECT 
                id, 
                processor_id, 
                received_from, 
                forwarded_to, 
                status_id, 
                details, 
                created_at 
            FROM `document_transaction_logs` 
            WHERE `document_transaction_id` = ? 
            ORDER BY `created_at` DESC";
    $results = query($sql, [$document_transaction_id]);
    return is_array($results) ? $results : [];
}

function createDocumentLog($document_transaction_id, $processor_id, $received_from, $forwarded_to, $status_id, $is_new = true, $details = '')
{
    $data = [
        'processor_id' => $processor_id,
        'received_from' => $received_from,
        'forwarded_to' => $forwarded_to,
        'status_id' => $status_id,
        'document_transaction_id' => $document_transaction_id,
        'is_new' => $is_new,
        'details' => $details
    ];
    return insert('document_transaction_logs', $data);
}

function updateDocumentLog($document_transaction_id, $processor_id, $received_from, $forwarded_to, $status_id, $is_new = true, $details = '')
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
        'processor_id' => $processor_id,
        'received_from' => $received_from,
        'forwarded_to' => $forwarded_to,
        'status_id' => $status_id,
        'is_new' => $is_new,
        'details' => $details
    ];
    return update('document_transaction_logs', $data, '`id` = ?', [$log_id]);
}

function updateDocumentLogsDone($document_transaction_id)
{
    $data = ['is_new' => false];
    return update('document_transaction_logs', $data, "`document_transaction_id` = ? AND `is_new` = 1", [$document_transaction_id]);
}

function documentLogAttachments($transaction_log_id)
{
    return query(
        "SELECT `id`, `file_name`, `file_extension` FROM `document_transaction_log_attachments` WHERE `transaction_log_id` = ?",
        [$transaction_log_id]
    );
}

function createDocumentLogAttachment($transaction_log_id, $file_name, $file_extension)
{
    $data = [
        'transaction_log_id' => $transaction_log_id,
        'file_name' => $file_name,
        'file_extension' => $file_extension
    ];
    return insert('document_transaction_log_attachments', $data);
}

function deleteDocumentLogAttachment($attachment_id)
{
    $sql = "SELECT `file_name` FROM `document_transaction_log_attachments` WHERE `id` = ? LIMIT 1";
    $attachment = find($sql, [$attachment_id]);
    if ($attachment && file_exists(root() . '/' . $attachment['file_name'])) {
        unlink(root() . '/' . $attachment['file_name']);
    }
    return delete('document_transaction_log_attachments', '`id` = ?', [$attachment_id]);
}

function updateTransactionLogFrom($new_alias, $old_alias)
{
    $data = ['received_from' => $new_alias];
    if ($new_alias === $old_alias) {
        return 0;
    }
    return update(
        'document_transaction_logs',
        $data,
        '`received_from` = ?',
        [$old_alias]
    );
}

function updateTransactionLogTo($new_alias, $old_alias)
{
    $data = ['forwarded_to' => $new_alias];
    if ($new_alias === $old_alias) {
        return 0;
    }
    return update(
        'document_transaction_logs',
        $data,
        '`forwarded_to` = ?',
        [$old_alias]
    );
}

function updateTransactionFrom($new_alias, $old_alias)
{
    $data = ['created_from' => $new_alias];
    if ($new_alias === $old_alias) {
        return 0;
    }
    return update(
        'document_transactions',
        $data,
        '`created_from` = ?',
        [$old_alias]
    );
}

function documentByStatus($status, $employee_id, $station_id, $from_date = '', $to_date = '')
{
    $station_filter = "$station_id%";
    if (empty($from_date)) {
        $from_date = date('Y-m-d');
    }
    if (empty($to_date)) {
        $to_date = $from_date;
    }
    $sql = "SELECT COUNT(*) AS `count` FROM `system_logs` 
            WHERE `action` = ? AND `target_id` 
            LIKE ? AND `employee_id` = ? AND `created_at` >= ? AND `created_at` < DATE_ADD(?, INTERVAL 1 DAY)";
    $row = find($sql, [$status, $station_filter, $employee_id, $from_date, $to_date]);
    return $row ? (int) $row['count'] : 0;
}

function documentSearch($string, $station_id)
{
    $likeTerm = "%{$string}%";
    $sql = "SELECT 
                t.`id`, 
                t.`description`, 
                t.`created_from`, 
                l.`status_id`, 
                t.`created_at`  
            FROM `document_transactions` AS t
            INNER JOIN `document_transaction_logs` AS l ON l.`id` = (
                SELECT MAX(`id`) 
                FROM `document_transaction_logs` 
                WHERE `document_transaction_id` = t.`id`
            )
            WHERE (
                t.`id` LIKE ? 
                OR MATCH(t.`description`) AGAINST (? IN BOOLEAN MODE)
                OR EXISTS (
                    SELECT 1
                    FROM `document_transaction_logs` AS sub_l
                    WHERE sub_l.`document_transaction_id` = t.`id`
                        AND MATCH(sub_l.`details`) AGAINST(? IN BOOLEAN MODE)
                        AND (sub_l.`received_from` = ? OR sub_l.`forwarded_to` = ?)
                )
            ) 
            ORDER BY t.`created_at` DESC 
            LIMIT 1000";
    return query($sql, [$likeTerm, $string, $string, $station_id, $station_id]);
}