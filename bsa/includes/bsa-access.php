<?php
/**
 * bsa/includes/bsa-access.php
 * Central access policy for the Booking & Schedule (BSA) module.
 *
 * Policy (as of this revision):
 *   - Booking & Schedule (calendar + creating facility/vehicle/job-order
 *     requests) is open to every logged-in employee.
 *   - The Booking Approvals page and its decision endpoints are limited to:
 *       - Administrative Officer V (ADOF5) — DTC Manager / Admin Officer V (Admin), OR
 *       - an employee id listed in bsaBookingApproverIds() — the Facility
 *         Coordinator(s) / Administrative Aide VI (Personnel Section).
 */

if (!function_exists('bsaUserPositionId')) {
    /**
     * Current (latest) position id of an employee, or '' when unknown.
     */
    function bsaUserPositionId($employee_id): string
    {
        $employee_id = (int) $employee_id;
        if ($employee_id <= 0) {
            return '';
        }

        $row = find(
            "SELECT sa.`position_id` FROM `station_assignments` sa
             WHERE sa.`employee_id` = ?
             ORDER BY sa.`assignment_date` DESC, sa.`position_id` ASC
             LIMIT 1",
            [$employee_id]
        );

        return $row ? (string) ($row['position_id'] ?? '') : '';
    }
}

if (!function_exists('bsaBookingApproverIds')) {
    /**
     * Optional DB-configured approver employee IDs from `bsa_settings` (`booking_approver_ids`).
     *
     * @return string[]
     */
    function bsaBookingApproverIds(): array
    {
        $ids = [];

        try {
            if (function_exists('find')) {
                $row = find("SELECT `setting_value` FROM `bsa_settings` WHERE `setting_key` = ?", ['booking_approver_ids']);
                $value = $row ? trim((string) ($row['setting_value'] ?? '')) : '';
                if ($value !== '') {
                    foreach (preg_split('/[\s,;]+/', $value) as $id) {
                        $id = trim($id);
                        if ($id !== '') {
                            $ids[] = $id;
                        }
                    }
                }
            }
        } catch (Throwable $e) {
            // bsa_settings may not exist yet.
        }

        return array_values(array_unique($ids));
    }
}

if (!function_exists('canAccessBookingApprovals')) {
    /**
     * Whether the given account may use Booking Approvals (view + decide).
     *
     * Allowed via DB checks when the account:
     *   - holds the `bsa` role in `user_permissions`, OR
     *   - is the Administrative Section (ADM) head or Admin AO5 (`ADOF5` + `ADM`), OR
     *   - is an Administrative Aide VI (`ADA6`) assigned to `ADM` (Facility Coordinator), OR
     *   - is listed in `bsa_settings` (`booking_approver_ids`).
     */
    function canAccessBookingApprovals($employee_id): bool
    {
        $id = trim((string) $employee_id);
        if ($id === '') {
            return false;
        }

        $empId = (int) $id;

        if (function_exists('find')) {
            // 1. Explicit BSA role in user_permissions
            $hasBsaRole = find(
                "SELECT `employee_id` FROM `user_permissions` WHERE `employee_id` = ? AND LOWER(`access`) = 'bsa' LIMIT 1",
                [$empId]
            );
            if ($hasBsaRole) {
                return true;
            }

            // 2. Administrative Section (ADM) head (Admin AO5 / DTC Manager)
            $isAdmHead = find(
                "SELECT `id` FROM `sections` WHERE `id` = 'ADM' AND `head_id` = ? LIMIT 1",
                [$empId]
            );
            if ($isAdmHead) {
                return true;
            }

            // 3. ADM section member with position ADOF5 (Admin AO5) or ADA6 (Facility Coordinator)
            $hasAdmPermission = find(
                "SELECT `employee_id` FROM `user_permissions` WHERE `employee_id` = ? AND `access` = 'ADM' LIMIT 1",
                [$empId]
            );
            $positionId = strtoupper(bsaUserPositionId($empId));
            if ($hasAdmPermission && in_array($positionId, ['ADOF5', 'ADA6'], true)) {
                return true;
            }
        }

        return in_array($id, bsaBookingApproverIds(), true);
    }
}

if (!function_exists('denyBsaApprovalAccess')) {
    /**
     * Emit the 403 for a denied Booking Approvals request.
     *
     * @param bool $asJson true for the decide endpoints, false for the HTML view.
     */
    function denyBsaApprovalAccess(bool $asJson = false): void
    {
        if ($asJson) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'error' => 'FORBIDDEN',
                'message' => 'You do not have permission to use Booking Approvals.',
            ]);
            exit;
        }

        http_response_code(403);
        echo '<!doctype html><html lang="en"><head><meta charset="utf-8">'
            . '<meta name="viewport" content="width=device-width, initial-scale=1">'
            . '<title>Access denied</title></head><body style="margin:0;padding:48px;'
            . 'font-family:Segoe UI,Arial,sans-serif;background:#f8f9fc;color:#3a3b45">'
            . '<div style="max-width:640px;margin:0 auto;background:#fff;border-left:6px solid #e74a3b;'
            . 'border-radius:8px;box-shadow:0 2px 12px rgba(0,0,0,.08);padding:32px 36px">'
            . '<h1 style="margin:0 0 12px;font-size:22px;color:#e74a3b">Access denied</h1>'
            . '<p style="margin:0 0 8px;line-height:1.5">Booking Approvals is limited to the '
            . '<strong>DTC Manager (Administrative Officer V)</strong> and the '
            . '<strong>Facility Coordinator (Administrative Aide VI)</strong>.</p>'
            . '<p style="margin:0;color:#858796;font-size:13px">You can still use Booking &amp; Schedule to view and '
            . 'submit bookings. Contact your DMIS administrator if you believe you should have access.</p>'
            . '</div></body></html>';
        exit;
    }
}