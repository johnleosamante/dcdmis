<?php
// employees
function account($email_address)
{
    return find(
        "SELECT `id`, `email_address` FROM `employees` 
        WHERE `status`='Active' AND `email_address` = ? LIMIT 1",
        [$email_address]
    );
}

function verifyAccountPassword(int $employee_id, string $plainPassword): array|bool
{
    $credentials = find(
        "SELECT `employee_id`, `password`, `status` FROM `credentials` 
        WHERE `employee_id` = ? LIMIT 1",
        [$employee_id]
    );
    if (!$credentials) {
        return false;
    }
    $storedHash = $credentials['password'];
    if (password_get_info($storedHash)['algo'] !== null) {
        if (password_verify($plainPassword, $storedHash)) {
            if (password_needs_rehash($storedHash, PASSWORD_BCRYPT, ['cost' => 12])) {
                $newHash = password_hash($plainPassword, PASSWORD_BCRYPT, ['cost' => 12]);
                update('credentials', ['password' => $newHash], '`employee_id` = ?', [$employee_id]);
            }
            return $credentials;
        }
    } else {
        $md5Hash = md5($plainPassword);
        if (hash_equals($storedHash, $md5Hash)) {
            $newHash = password_hash($plainPassword, PASSWORD_BCRYPT, ['cost' => 12]);
            update('credentials', ['password' => $newHash], '`employee_id` = ?', [$employee_id]);
            return $credentials;
        }
    }
    return false;
}

function createAccount($employee_id, $password)
{
    $data = [
        'employee_id' => $employee_id,
        'password' => $password,
        'status' => 'Default'
    ];
    return insert('credentials', $data);
}

function deleteAccount($employee_id)
{
    return delete('credentials', '`employee_id` = ?', [$employee_id]);
}

function updateAccountPassword($employee_id, $password, $status = null)
{
    $data = [
        'password' => $password
    ];
    if (!empty($status)) {
        $data['status'] = $status;
    }

    return update('credentials', $data, '`employee_id` = ?', [$employee_id]);
}

// user_permissions
function userRole($employee_id, $access)
{
    return find(
        "SELECT `employee_id` FROM `user_permissions` 
        WHERE `employee_id` = ? AND `access` = ? LIMIT 1",
        [$employee_id, $access]
    );
}

function dtsUser($employee_id)
{
    return find(
        "SELECT * FROM `user_permissions` 
        WHERE `employee_id` = ? AND `link` <> ''",
        [$employee_id]
    );
}

function isStationUser($employee_id, $access)
{
    return find(
        "SELECT `employee_id` FROM `user_permissions` 
        WHERE `employee_id` = ? AND `access` = ?",
        [$employee_id, $access]
    );
}

function createUserRole($employee_id, $access, $link = null)
{
    $data = [
        'employee_id' => $employee_id,
        'access' => $access,
        'link' => $link
    ];
    return insert('user_permissions', $data);
}

function updateUserRole($employee_id, $access, $link = null)
{
    $data = [
        'access' => $access
    ];
    if (!empty($link)) {
        $data['link'] = $link;
    }
    return update('user_permissions', $data, "`employee_id` = ? AND `link` LIKE '%_portal%'", [$employee_id]);
}

function deleteUserRole($employee_id, $access)
{
    return delete('user_permissions', '`employee_id` = ? AND `access` = ?', [$employee_id, $access]);
}

function deleteUserRoles($employee_id)
{
    return delete('user_permissions', '`employee_id` = ?', [$employee_id]);
}

function updateUsersStation($new_access, $old_access, $link = null)
{
    $data = [
        'access' => $new_access
    ];
    if (!empty($link)) {
        $data['link'] = $link;
    }
    return update('user_permissions', $data, '`access` = ?', [$old_access]);
}

// user_permissions, station_assignments
function user($employee_id)
{
    return find(
        "SELECT u.`employee_id`, u.`access`, s.`station_id`, u.`link` FROM `user_permissions` u 
        INNER JOIN `station_assignments` s ON u.`employee_id` = s.`employee_id` 
        WHERE u.`employee_id` = ? LIMIT 1",
        [$employee_id]
    );
}

// employees, user_permissions, station_assignments
function users()
{
    return query(
        "SELECT p.`id`, p.`last_name`, p.`first_name`, p.`middle_name`, p.`name_extension`, 
            p.`sex`, p.`email_address`, u.`access`, u.`link`, s.`station_id`, s.`position_id`, 
            p.`profile_picture`, p.`status` 
        FROM `employees` p 
        INNER JOIN `user_permissions` u ON p.`id` = u.`employee_id` 
        INNER JOIN `station_assignments` s ON u.`employee_id` = s.`employee_id` 
        GROUP BY u.`employee_id` 
        ORDER BY p.`last_name` ASC"
    );
}

function countUsers()
{
    $sql = "SELECT COUNT(DISTINCT u.`employee_id`) AS `count` FROM `employees` p 
            INNER JOIN `user_permissions` u ON p.`id` = u.`employee_id` 
            INNER JOIN `station_assignments` s ON u.`employee_id` = s.`employee_id`";
    $result = find($sql);
    return (int) ($result['count'] ?? 0);
}

// employees, station_assignments, user_permissions
function sectionUsers($access)
{
    return query(
        "SELECT p.`id`, p.`last_name`, p.`first_name`, p.`middle_name`, 
            p.`name_extension`, p.`sex`, p.`birthdate`, p.`agency_id`, s.`position_id`, 
            s.`station_id`, p.`profile_picture`, p.`email_address`, p.`mobile_number` 
        FROM `employees` p 
        INNER JOIN `station_assignments` s ON p.`id` = s.`employee_id` 
        INNER JOIN `user_permissions` u ON p.`id` = u.`employee_id` 
        WHERE p.`status`='Active' AND u.access = ? 
        ORDER BY p.`last_name` ASC",
        [$access]
    );
}

function portalUsers($station_id, $from_date, $to_date)
{
    $sql = "SELECT 
                p.`id`, 
                p.`last_name`, 
                p.`first_name`, 
                p.`middle_name`, 
                p.`name_extension`, 
                p.`sex`, 
                p.`profile_picture`, 
                s.`position_id` 
            FROM `employees` AS `p` 
            INNER JOIN `station_assignments` AS `s` ON p.`id` = s.`employee_id` 
            INNER JOIN `document_transaction_logs` AS `t` ON p.`id` = t.`processor_id` 
            WHERE t.`received_from` = ? 
                AND t.`created_at` >= ? 
                AND t.`created_at` < DATE_ADD(?, INTERVAL 1 DAY)
            GROUP BY 
                p.`id`, p.`last_name`, p.`first_name`, p.`middle_name`, 
                p.`name_extension`, p.`sex`, p.`profile_picture`, s.`position_id` 
            ORDER BY p.`last_name` ASC";
    return query($sql, [$station_id, $from_date, $to_date]);
}