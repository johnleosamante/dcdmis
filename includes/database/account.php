<?php
// persons
function account($email_address)
{
    return find(
        "SELECT `id`, `email_address` FROM `persons` 
        WHERE `status`='Active' AND `email_address` = ? LIMIT 1",
        [$email_address]
    );
}

// credentials
function accountPassword($person_id, $password)
{
    return find(
        "SELECT `person_id`, `status` FROM `credentials` 
        WHERE `person_id` = ? AND `password` = ? LIMIT 1",
        [$person_id, $password]
    );
}

function createAccount($person_id, $password)
{
    $data = [
        'person_id' => $person_id,
        'password' => $password,
        'status' => 'Default',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    return insert('credentials', $data);
}

function deleteAccount($person_id)
{
    return delete('credentials', '`person_id` = ?', [$person_id]);
}

function updateAccountPassword($person_id, $password, $status = null)
{
    $data = [
        'password' => $password,
        'updated_at' => date('Y-m-d H:i:s')
    ];

    if (!empty($status)) {
        $data['status'] = $status;
    }

    return update('credentials', $data, '`person_id` = ?', [$person_id]);
}

// user_permissions
function userRole($person_id, $access)
{
    return find(
        "SELECT `person_id` FROM `user_permissions` 
        WHERE `person_id` = ? AND `access` = ? LIMIT 1",
        [$person_id, $access]
    );
}

function dtsUser($person_id)
{
    return find(
        "SELECT * FROM `user_permissions` 
        WHERE `person_id` = ? AND `link` <> ''",
        [$person_id]
    );
}

function isStationUser($person_id, $access)
{
    return find(
        "SELECT `person_id` FROM `user_permissions` 
        WHERE `person_id` = ? AND `access` = ?",
        [$person_id, $access]
    );
}

function createUserRole($person_id, $access, $link = null)
{
    $data = [
        'person_id' => $person_id,
        'access' => $access,
        'link' => $link,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    return insert('user_permissions', $data);
}

function updateUserRole($person_id, $access, $link = null)
{
    $data = [
        'access' => $access,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    if (!empty($link)) {
        $data['link'] = $link;
    }
    return update('user_permissions', $data, "`person_id` = ? AND `link` LIKE '%_portal%'", [$person_id]);
}

function deleteUserRole($person_id, $access)
{
    return delete('user_permissions', '`person_id` = ? AND `access` = ?', [$person_id, $access]);
}

function deleteUserRoles($person_id)
{
    return delete('user_permissions', '`person_id` = ?', [$person_id]);
}

function updateUsersStation($new_access, $old_access, $link = null)
{
    $data = [
        'access' => $new_access,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    if (!empty($link)) {
        $data['link'] = $link;
    }
    return update('user_permissions', $data, '`access` = ?', [$old_access]);
}

// user_permissions, station_assignments
function user($person_id)
{
    return find(
        "SELECT u.`person_id`, u.`access`, s.`station_id`, u.`link` FROM `user_permissions` u 
        INNER JOIN `station_assignments` s ON u.`person_id` = s.`person_id` 
        WHERE u.`person_id` = ? LIMIT 1",
        [$person_id]
    );
}

// persons, user_permissions, station_assignments
function users()
{
    return query(
        "SELECT p.`id`, p.`last_name`, p.`first_name`, p.`middle_name`, p.`name_extension`, 
            p.`sex`, p.`email_address`, u.`access`, u.`link`, s.`station_id`, s.`position_id`, 
            p.`profile_picture`, p.`status` 
        FROM `persons` p 
        INNER JOIN `user_permissions` u ON p.`id` = u.`person_id` 
        INNER JOIN `station_assignments` s ON u.`person_id` = s.`person_id` 
        GROUP BY u.`person_id` 
        ORDER BY p.`last_name` ASC"
    );
}

// persons, station_assignments, user_permissions
function sectionUsers($access)
{
    return query(
        "SELECT p.`id`, p.`last_name`, p.`first_name`, p.`middle_name`, 
            p.`name_extension`, p.`sex`, p.`birth_month`, p.`birth_day`, 
            p.`birth_year`, p.`agency_id`, s.`position_id`, 
            s.`station_id`, p.`profile_picture`, p.`email_address`, p.`mobile_number` 
        FROM `persons` p 
        INNER JOIN `station_assignments` s ON p.`id` = s.`person_id` 
        INNER JOIN `user_permissions` u ON p.`id` = u.`person_id` 
        WHERE p.`status`='Active' AND u.access = ? 
        ORDER BY p.`last_name` ASC",
        [$access]
    );
}

// persons, station_assignments, document_transaction_logs
function portalUsers($station_id, $from_date, $to_date)
{
    return query(
        "SELECT p.`id`, p.`last_name`, p.`first_name`, p.`middle_name`, 
            p.`name_extension`, p.`sex`, p.`profile_picture`, s.`position_id` 
        FROM `persons` p 
        INNER JOIN `station_assignments` s ON p.`id` = s.`person_id` 
        INNER JOIN `document_transaction_logs` t ON p.`id` = t.`processed_by` 
        WHERE t.`received_from` = ? AND t.`created_at` BETWEEN ? AND DATE_ADD(?, INTERVAL 1 DAY) 
        GROUP BY p.`id` ORDER BY p.`last_name` ASC",
        [$station_id, $from_date, $to_date]
    );
}