<?php
function connection(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }
    $dsn = sprintf("mysql:host=%s;dbname=%s;charset=utf8mb4", HOSTNAME, DATABASE);
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_PERSISTENT => false,
    ];
    try {
        return $pdo = new PDO($dsn, USER, PASSWORD, $options);
    } catch (PDOException $e) {
        error_log(sprintf("Connection error [%s]: %s", $e->getCode(), $e->getMessage()));
        redirect(uri() . '/oops?e=500');
        exit;
    }
}

function query(string $sql, array $params = []): mixed
{
    try {
        $stmt = connection()->prepare($sql);
        $stmt->execute($params);
        if ($stmt->columnCount() > 0) {
            return $stmt->fetchAll();
        }
        return $stmt->rowCount();
    } catch (PDOException $e) {
        error_log(sprintf("Query Error: %s | SQL: %s | Params: %s", $e->getMessage(), $sql, json_encode($params)));
        return false;
    }
}

function beginTransaction(): bool
{
    $db = connection();
    if (!$db->inTransaction()) {
        return $db->beginTransaction();
    }
    return false;
}

function commit(): bool
{
    $db = connection();
    if ($db->inTransaction()) {
        return $db->commit();
    }
    return false;
}

function rollBack(): bool
{
    $db = connection();
    if ($db->inTransaction()) {
        return $db->rollBack();
    }
    return false;
}

function execute(string $sql, array $params = [])
{
    $db = connection();

    try {
        $stmt = $db->prepare($sql);
        return $stmt->execute($params);
    } catch (PDOException $e) {
        error_log(sprintf("Database execution error: ", $e->getMessage()));
        return false;
    }
}

function find(string $sql, array $params = []): array|bool
{
    try {
        $stmt = connection()->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        $stmt->closeCursor();
        return $result ?: false;
    } catch (PDOException $e) {
        error_log(sprintf("Find error: %s | SQL: %s | Params: %s", $e->getMessage(), $sql, json_encode($params)));
        return false;
    }
}

function insert(string $table, array $data): string|int|false
{
    if (empty($data)) {
        return false;
    }
    $keys = array_keys($data);
    $columns = '`' . implode('`, `', $keys) . '`';
    $placeholders = implode(', ', array_fill(0, count($keys), '?'));
    $sql = "INSERT INTO `$table` ($columns) VALUES ($placeholders)";
    try {
        $db = connection();
        $stmt = $db->prepare($sql);
        $result = $stmt->execute(array_values($data));
        return $result ? ($db->lastInsertId() ?: true) : false;
    } catch (PDOException $e) {
        error_log(sprintf("Insert error (Table: %s): %s", $table, $e->getMessage()));
        return false;
    }
}

function update(string $table, array $data, string $where, array $whereParams = []): int|false
{
    if (empty($data) || empty($where)) {
        error_log("Update error: Missing data or WHERE clause for table $table");
        return false;
    }
    $keys = array_keys($data);
    $fieldsStr = '`' . implode('` = ?, `', $keys) . '` = ?';
    $sql = "UPDATE `{$table}` SET {$fieldsStr} WHERE {$where}";
    $params = [...array_values($data), ...$whereParams];
    try {
        return query($sql, $params);
    } catch (PDOException $e) {
        error_log(sprintf("Update error (Table: %s): %s | SQL: %s", $table, $e->getMessage(), $sql));
        return false;
    }
}


function delete(string $table, string $where, array $whereParams = []): int|false
{
    if (empty(trim($where))) {
        error_log("Critical: Attempted to delete from $table without a WHERE clause.");
        return false;
    }
    $sql = "DELETE FROM `$table` WHERE $where";
    try {
        $result = query($sql, $whereParams);
        return $result;
    } catch (PDOException $e) {
        error_log(sprintf("Delete error (Table: %s): %s | SQL: %s", $table, $e->getMessage(), $sql));
        return false;
    }
}