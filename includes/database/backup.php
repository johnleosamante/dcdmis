<?php
// public/includes/database/backup.php
function checkAndRunDatabaseBackup(): void
{
    $isPageLoad = ($_SERVER['REQUEST_METHOD'] === 'GET' && strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'text/html') !== false);
    if (!$isPageLoad) {
        return;
    }

    $prefix = alias() . '_';
    $today = date('Y-m-d');

    if (isset($_SESSION[$prefix . 'backup_checked_today']) && $_SESSION[$prefix . 'backup_checked_today'] === $today) {
        return;
    }

    $log = find("SELECT * FROM `backup_logs` WHERE `backup_date` = ? LIMIT 1", [$today]);

    $shouldBackup = false;

    if ($log === false) {
        $inserted = insert('backup_logs', [
            'backup_date' => $today,
            'status' => 'Pending'
        ]);
        if ($inserted !== false) {
            $shouldBackup = true;
        }
    } else {
        if ($log['status'] === 'Success') {
            $_SESSION["{$prefix}backup_checked_today"] = $today;
            return;
        } elseif ($log['status'] === 'Failed') {
            $updated = update('backup_logs', ['status' => 'Pending', 'error_message' => null], '`backup_date` = ? AND `status` = ?', [$today, 'Failed']);
            if ($updated > 0) {
                $shouldBackup = true;
            }
        } elseif ($log['status'] === 'Pending') {
            $lastUpdated = strtotime($log['updated_at'] ?? $log['created_at']);
            if (time() - $lastUpdated > 900) {
                $updated = update('backup_logs', ['status' => 'Pending', 'error_message' => 'Pending timeout retry'], '`backup_date` = ? AND `status` = ?', [$today, 'Pending']);
                if ($updated > 0) {
                    $shouldBackup = true;
                }
            }
        }
    }

    if ($shouldBackup) {
        runDatabaseBackup($today);
    }
}

function runDatabaseBackup(string $today): void
{
    $prefix = alias() . '_';
    $backupDir = defined('BACKUP_DIR') ? BACKUP_DIR : dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'backups';
    if (!is_dir($backupDir)) {
        if (!mkdir($backupDir, 0755, true) && !is_dir($backupDir)) {
            $errorMsg = "Failed to create backup directory: {$backupDir}";
            update('backup_logs', ['status' => 'Failed', 'error_message' => $errorMsg], '`backup_date` = ?', [$today]);
            return;
        }
    }

    secureBackupDirectory($backupDir);

    $fileName = 'backup_' . DATABASE . '_' . date('Ymd_His') . '.sql';
    $filePath = $backupDir . DIRECTORY_SEPARATOR . $fileName;

    $success = false;
    $errorMsg = '';

    $mysqldumpPath = defined('MYSQLDUMP_PATH') ? MYSQLDUMP_PATH : null;
    if ($mysqldumpPath && file_exists($mysqldumpPath)) {
        $success = runMysqldump($mysqldumpPath, $filePath, $errorMsg);
    } else {
        $errorMsg = "mysqldump executable not configured or not found. ";
    }

    if (!$success) {
        $phpStartMsg = "Falling back to pure PHP backup logic... ";
        $phpSuccess = runPHPBackup($filePath, $phpErrorMsg);
        if ($phpSuccess) {
            $success = true;
        } else {
            $errorMsg .= "{$phpStartMsg}{$phpErrorMsg}";
        }
    }

    if ($success && file_exists($filePath) && filesize($filePath) > 0) {
        $size = filesize($filePath);
        update('backup_logs', [
            'file_name' => $fileName,
            'file_path' => $filePath,
            'file_size' => $size,
            'status' => 'Success',
            'error_message' => null
        ], '`backup_date` = ?', [$today]);

        $_SESSION["{$prefix}backup_checked_today"] = $today;
    } else {
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
        update('backup_logs', [
            'status' => 'Failed',
            'error_message' => $errorMsg ?: "Unknown error"
        ], '`backup_date` = ?', [$today]);
    }
}

function runMysqldump(string $path, string $filePath, string &$errorMsg): bool
{
    $descriptorspec = [
        0 => ["pipe", "r"],
        1 => ["file", $filePath, "w"],
        2 => ["pipe", "w"]
    ];

    $cmd = [
        $path,
        '-h',
        HOSTNAME,
        '-u',
        USER,
    ];
    if (PASSWORD !== '') {
        $cmd[] = '-p' . PASSWORD;
    }
    $cmd[] = DATABASE;

    $process = proc_open($cmd, $descriptorspec, $pipes);

    if (is_resource($process)) {
        fclose($pipes[0]);
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
        $return_val = proc_close($process);

        if ($return_val === 0) {
            return true;
        } else {
            $errorMsg = "mysqldump error (code $return_val): " . trim($stderr);
            return false;
        }
    }

    $errorMsg = "Failed to run mysqldump process.";
    return false;
}

function runPHPBackup(string $filePath, ?string &$errorMsg = null): bool
{
    try {
        $db = connection();
        $handle = fopen($filePath, 'w');
        if (!$handle) {
            throw new Exception("Cannot open file: {$filePath}");
        }

        fwrite($handle, "-- Pure PHP Database Dump\n");
        fwrite($handle, "-- Generated: " . date('Y-m-d H:i:s') . "\n\n");
        fwrite($handle, "/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;\n");
        fwrite($handle, "SET NAMES utf8mb4;\n\n");

        $stmt = $db->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            if ($table === 'backup_logs') {
                continue;
            }

            $createStmt = $db->query("SHOW CREATE TABLE `$table`")->fetch();
            fwrite($handle, "DROP TABLE IF EXISTS `$table`;\n");
            fwrite($handle, $createStmt['Create Table'] . ";\n\n");

            $dataStmt = $db->query("SELECT * FROM `$table`");
            $rows = [];
            $chunkSize = 100;

            while ($row = $dataStmt->fetch(PDO::FETCH_ASSOC)) {
                $rows[] = $row;
                if (count($rows) >= $chunkSize) {
                    writeInsertChunkToFile($handle, $table, $rows, $db);
                    $rows = [];
                }
            }

            if (count($rows) > 0) {
                writeInsertChunkToFile($handle, $table, $rows, $db);
            }

            fwrite($handle, "\n");
        }

        fwrite($handle, "/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;\n");
        fclose($handle);
        return true;
    } catch (Exception $e) {
        $errorMsg = "PHP Dump error: " . $e->getMessage();
        return false;
    }
}

function writeInsertChunkToFile($handle, string $table, array $rows, PDO $db): void
{
    $keys = array_map(function ($k) {
        return "`$k`";
    }, array_keys($rows[0]));
    $sqlHeader = "INSERT INTO `$table` (" . implode(', ', $keys) . ") VALUES \n";

    $valueGroups = [];
    foreach ($rows as $row) {
        $values = array_map(function ($v) use ($db) {
            if ($v === null) {
                return 'NULL';
            }
            return $db->quote($v);
        }, array_values($row));
        $valueGroups[] = "(" . implode(', ', $values) . ")";
    }

    fwrite($handle, $sqlHeader . implode(",\n", $valueGroups) . ";\n");
}

function secureBackupDirectory(string $backupDir): void
{
    // .htaccess
    $htaccessFile = $backupDir . DIRECTORY_SEPARATOR . '.htaccess';
    if (!file_exists($htaccessFile)) {
        @file_put_contents($htaccessFile, "Deny from all\n");
    }

    // web.config
    $webConfigFile = $backupDir . DIRECTORY_SEPARATOR . 'web.config';
    if (!file_exists($webConfigFile)) {
        $configContent = '<?xml version="1.0" encoding="UTF-8"?>
<configuration>
    <system.webServer>
        <authorization>
            <deny users="*" />
        </authorization>
    </system.webServer>
</configuration>';
        @file_put_contents($webConfigFile, $configContent);
    }
}