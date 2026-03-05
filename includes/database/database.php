<?php
function connection()
{
    static $pdo = null;
    if ($pdo === null) {
        $dsn = "mysql:host=" . HOSTNAME . ";dbname=" . DATABASE . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $pdo = new PDO($dsn, USER, PASSWORD, $options);
        } catch (PDOException $e) {
            error_log("Connection failed: " . $e->getMessage());
            redirect(uri() . '/oops?e=500');
            exit;
        }
    }
    return $pdo;
}

function query($sql, $params = [])
{
    try {
        $stmt = connection()->prepare($sql);
        $stmt->execute($params);
        if ($stmt->columnCount() > 0) {
            return $stmt->fetchAll();
        }
        return $stmt->rowCount();
    } catch (PDOException $e) {
        error_log("Query Error: " . $e->getMessage() . " | SQL: {$sql}");
        return false;
    }
}

function lastInsertId()
{
    return connection()->lastInsertId();
}

function beginTransaction()
{
    return connection()->beginTransaction();
}

function commit()
{
    return connection()->commit();
}

function rollBack()
{
    return connection()->rollBack();
}

function find($sql, $params = [])
{
    try {
        $stmt = connection()->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result ?: null;
    } catch (PDOException $e) {
        error_log("Find Error: " . $e->getMessage());
        return false;
    }
}

function insert($table, $data)
{
    $columns = implode(', ', array_map(fn($col) => "`$col`", array_keys($data)));
    $placeholders = implode(', ', array_fill(0, count($data), '?'));
    $sql = "INSERT INTO `{$table}` ({$columns}) VALUES ({$placeholders});";
    $result = query($sql, array_values($data));
    return ($result !== false) ? connection()->lastInsertId() : false;
}

function update($table, $data, $where, $whereParams = [])
{
    if (empty($data) || empty($where)) {
        error_log("Update Error: Missing data or WHERE clause for table {$table}");
        return false;
    }
    $fields = [];
    foreach (array_keys($data) as $column) {
        $fields[] = "`{$column}` = ?";
    }
    $fieldsStr = implode(', ', $fields);
    $sql = "UPDATE `{$table}` SET {$fieldsStr} WHERE {$where};";
    $params = array_merge(array_values($data), (array) $whereParams);

    return query($sql, $params);
}

function delete($table, $where, $whereParams = [])
{
    if (empty($where)) {
        error_log("Delete Error: Attempted to delete from {$table} without a WHERE clause.");
        return false;
    }
    $sql = "DELETE FROM `{$table}` WHERE {$where};";
    return query($sql, (array) $whereParams);
}