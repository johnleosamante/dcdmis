<?php
// public/includes/database/backup.php

/**
 * Main entrance function triggered on page load.
 * Performs database backup checks and execution.
 */
function checkAndRunDatabaseBackup(): void
{
    // 1. Only run for GET requests with HTML accept headers (actual visitor page load)
    $isPageLoad = ($_SERVER['REQUEST_METHOD'] === 'GET' && strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'text/html') !== false);
    if (!$isPageLoad) {
        return;
    }

    $prefix = alias() . '_';
    $today = date('Y-m-d');

    // 2. Performance optimization: skip DB query if checked in current session today
    if (isset($_SESSION[$prefix . 'backup_checked_today']) && $_SESSION[$prefix . 'backup_checked_today'] === $today) {
        return;
    }

    // 3. Check if backup for today has already run successfully
    $log = find("SELECT * FROM `backup_logs` WHERE `backup_date` = ? LIMIT 1", [$today]);

    $shouldBackup = false;

    if ($log === false) {
        // Insert entry with 'Pending' status. Unique index on backup_date prevents concurrent inserts
        $inserted = insert('backup_logs', [
            'backup_date' => $today,
            'status' => 'Pending'
        ]);
        if ($inserted !== false) {
            $shouldBackup = true;
        }
    } else {
        if ($log['status'] === 'Success') {
            // Already backed up successfully today, save in session
            $_SESSION[$prefix . 'backup_checked_today'] = $today;
            return;
        } elseif ($log['status'] === 'Failed') {
            // Previously failed, attempt retry by updating status to Pending
            $updated = update('backup_logs', ['status' => 'Pending', 'error_message' => null], '`backup_date` = ? AND `status` = ?', [$today, 'Failed']);
            if ($updated > 0) {
                $shouldBackup = true;
            }
        } elseif ($log['status'] === 'Pending') {
            // Check for timeout / crashed process (older than 15 minutes)
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

/**
 * Executes the database backup and updates the log.
 */
function runDatabaseBackup(string $today): void
{
    $prefix = alias() . '_';

    // Resolve backup directory
    $backupDir = defined('BACKUP_DIR') ? BACKUP_DIR : dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'backups';

    // Auto-create directory and secure it
    if (!is_dir($backupDir)) {
        if (!mkdir($backupDir, 0755, true) && !is_dir($backupDir)) {
            $errorMsg = "Failed to create backup directory: " . $backupDir;
            update('backup_logs', ['status' => 'Failed', 'error_message' => $errorMsg], '`backup_date` = ?', [$today]);
            return;
        }
    }

    // Secure the folder if it's accessible from the web
    secureBackupDirectory($backupDir);

    $fileName = 'backup_' . DATABASE . '_' . date('Ymd_His') . '.sql';
    $filePath = $backupDir . DIRECTORY_SEPARATOR . $fileName;

    $success = false;
    $errorMsg = '';

    // Method 1: Try using mysqldump if path is defined
    $mysqldumpPath = defined('MYSQLDUMP_PATH') ? MYSQLDUMP_PATH : null;
    if ($mysqldumpPath && file_exists($mysqldumpPath)) {
        $success = runMysqldump($mysqldumpPath, $filePath, $errorMsg);
    } else {
        $errorMsg = "mysqldump executable not configured or not found. ";
    }

    // Method 2: Fallback to PHP streaming dumper
    if (!$success) {
        $phpStartMsg = "Falling back to pure PHP backup logic... ";
        $phpSuccess = runPHPBackup($filePath, $phpErrorMsg);
        if ($phpSuccess) {
            $success = true;
        } else {
            $errorMsg .= $phpStartMsg . $phpErrorMsg;
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

        $_SESSION[$prefix . 'backup_checked_today'] = $today;
    } else {
        // Clean up partial file if exists
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
        update('backup_logs', [
            'status' => 'Failed',
            'error_message' => $errorMsg ?: "Unknown error"
        ], '`backup_date` = ?', [$today]);
    }
}

/**
 * Runs backup using mysqldump executable.
 */
function runMysqldump(string $path, string $filePath, string &$errorMsg): bool
{
    $descriptorspec = [
        0 => ["pipe", "r"], // stdin
        1 => ["file", $filePath, "w"], // stdout to file
        2 => ["pipe", "w"] // stderr
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

/**
 * Runs backup using pure PHP streaming.
 */
function runPHPBackup(string $filePath, ?string &$errorMsg = null): bool
{
    try {
        $db = connection();
        $handle = fopen($filePath, 'w');
        if (!$handle) {
            throw new Exception("Cannot open file: " . $filePath);
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

/**
 * Writes a chunk of rows as a single multi-row INSERT statement to avoid overhead.
 */
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

/**
 * Secures the backup folder by placing .htaccess and web.config request blocking configurations.
 */
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