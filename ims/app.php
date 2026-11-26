<?php
$activeApp = $_SESSION["{$prefix}activeApp"] = 'ims';
$page = $appTitle = 'Inventory Management System';
require_once(root() . '/ims/helpers.php');

if (!isset($userId)) {
    redirect("{$baseUri}/login");
}

if (isset($_SESSION["{$prefix}stock_flash"])) {
    $flash = $_SESSION["{$prefix}stock_flash"];
    $showAlert = true;
    $success = $flash['success'];
    $message = $flash['message'];
    unset($_SESSION["{$prefix}stock_flash"]);
}

if (isset($_SESSION["{$prefix}change_password"])) {
    redirect("{$baseUri}/login/change");
}

if (isset($_POST['primary-search-button'])) {
    redirect(customUri('ims', 'Stock and Inventory', sanitize($_POST['primary-search-text'])));
}

// ========== Suppliers ==========

if (isset($_POST['save-supplier'])) {
    requireImsStaff();
    $name = trim($_POST['name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $contact = trim($_POST['contact'] ?? '');
    $showAlert = true;
    $success = false;

    if ($name === '') {
        $message = 'Supplier name is required.';
        return;
    }

    if (find('SELECT id FROM suppliers WHERE name = ?', [$name])) {
        $message = 'A supplier with that name already exists.';
        return;
    }

    $result = insert('suppliers', [
        'name' => $name,
        'address' => $address !== '' ? $address : null,
        'contact' => $contact !== '' ? $contact : null,
    ]);

    if ($result === false) {
        $message = 'The supplier could not be saved.';
        return;
    }

    createSystemLog($stationId, $userId, 'Added supplier ' . $name, $result, clientIp());
    $_SESSION["{$prefix}stock_flash"] = ['success' => true, 'message' => "Supplier {$name} added successfully."];
    redirect(customUri('ims', 'Supplier'));
}

if (isset($_POST['delete-supplier'])) {
    requireImsStaff();
    $deleteId = (int) sanitize(decipher($_POST['verifier'] ?? ''));
    $showAlert = true;
    $success = false;

    $supplier = $deleteId > 0 ? find('SELECT id, name FROM suppliers WHERE id = ?', [$deleteId]) : false;
    if (!$supplier) {
        $message = 'Supplier not found.';
        return;
    }

    $prRow = find('SELECT COUNT(*) AS total FROM purchase_requests WHERE supplier_id = ?', [$deleteId]);
    $prCount = $prRow ? (int) $prRow['total'] : 0;
    if ($prCount > 0) {
        $message = "Supplier {$supplier['name']} is used by {$prCount} purchase request(s) and cannot be deleted.";
        return;
    }

    $result = delete('suppliers', '`id` = ?', [$deleteId]);
    if ($result !== false) {
        createSystemLog($stationId, $userId, 'Deleted supplier ' . $supplier['name'], $deleteId, clientIp());
        $_SESSION["{$prefix}stock_flash"] = ['success' => true, 'message' => 'Supplier deleted successfully.'];
        redirect(customUri('ims', 'Supplier'));
    } else {
        $message = 'Failed to delete supplier. Please try again.';
    }
}

// ========== Stock and Inventory ==========

if (isset($_POST['save-pr'])) {
    $employeeId = (int) ($_POST['employee_id'] ?? 0);
    $itemId = (int) ($_POST['item_id'] ?? 0);
    $quantity = (int) ($_POST['quantity'] ?? 0);
    $unitCost = (float) ($_POST['unit_cost'] ?? 0);
    $purpose = trim($_POST['purpose'] ?? '');
    $supplierId = (int) ($_POST['supplier_id'] ?? 0) ?: null;
    $showAlert = true;
    $success = false;

    if ($employeeId <= 0 || !find('SELECT id FROM employees WHERE id = ?', [$employeeId])) {
        $message = 'Please select a valid employee.';
        return;
    }
    if ($itemId <= 0 || !find('SELECT id FROM items WHERE id = ?', [$itemId])) {
        $message = 'Please select a valid item.';
        return;
    }
    if ($quantity <= 0) {
        $message = 'Quantity must be greater than zero.';
        return;
    }
    if ($unitCost < 0) {
        $message = 'Unit cost cannot be negative.';
        return;
    }
    if ($supplierId !== null && !find('SELECT id FROM suppliers WHERE id = ?', [$supplierId])) {
        $message = 'Please select a valid supplier.';
        return;
    }

    $prNo = imsNextDocumentNumber('PR', 'purchase_requests', 'pr_no');
    $result = insert('purchase_requests', [
        'pr_no' => $prNo,
        'employee_id' => $employeeId,
        'item_id' => $itemId,
        'quantity' => $quantity,
        'unit_cost' => $unitCost,
        'total_cost' => $quantity * $unitCost,
        'purpose' => $purpose,
        'supplier_id' => $supplierId,
        'po_no' => trim($_POST['po_no'] ?? ''),
        'po_date' => trim($_POST['po_date'] ?? '') ?: null,
        'status' => 'pending',
    ]);

    if ($result === false) {
        $message = 'The purchase request could not be saved.';
        return;
    }

    createSystemLog($stationId, $userId, 'Created purchase request', $result, clientIp());
    $_SESSION["{$prefix}stock_flash"] = ['success' => true, 'message' => "Purchase request {$prNo} created successfully."];
    redirect(customUri('ims', 'Purchase Requests'));
}

if (isset($_POST['add-item-unit'])) {
    requireImsStaff();
    $itemId = (int) sanitize(decipher($_POST['item_id_id'] ?? ''));
    $unit = strtolower(trim($_POST['new_unit'] ?? ''));
    $pcs = (int) ($_POST['new_pcs'] ?? 1);
    $showAlert = true;
    $success = false;

    if ($itemId <= 0) {
        $message = 'Invalid item.';
        return;
    }
    if ($unit === '') {
        $message = 'Please select a unit.';
        return;
    }
    if ($pcs < 1) {
        $message = 'Pieces per unit must be at least 1.';
        return;
    }

    $existing = find('SELECT id FROM item_units WHERE item_id = ? AND LOWER(unit) = ?', [$itemId, $unit]);
    if ($existing) {
        $message = 'That unit is already added for this item.';
        return;
    }

    $result = insert('item_units', ['item_id' => $itemId, 'unit' => $unit, 'pcs_per_unit' => $pcs]);
    if ($result !== false) {
        createSystemLog($stationId, $userId, 'Added unit ' . ucfirst($unit) . ' (' . $pcs . ' pcs/unit) for stock item #' . $itemId, $itemId, clientIp());
        $_SESSION["{$prefix}stock_flash"] = ['success' => true, 'message' => 'Unit added.'];
        redirect(customUri('ims', 'Edit Stock Item', $itemId));
    } else {
        $message = 'Failed to add the unit. Please try again.';
    }
}

if (isset($_POST['remove-item-unit'])) {
    requireImsStaff();
    $unitId = (int) sanitize(decipher($_POST['item_unit_id'] ?? ''));
    $showAlert = true;
    $success = false;

    $unitRow = find('SELECT id, item_id, unit FROM item_units WHERE id = ?', [$unitId]);
    if (!$unitRow) {
        $message = 'Unit not found.';
        return;
    }

    $result = delete('item_units', '`id` = ?', [$unitId]);
    if ($result !== false) {
        createSystemLog($stationId, $userId, 'Removed unit ' . ucfirst($unitRow['unit']) . ' from stock item #' . $unitRow['item_id'], (int) $unitRow['item_id'], clientIp());
        $_SESSION["{$prefix}stock_flash"] = ['success' => true, 'message' => 'Unit removed.'];
        redirect(customUri('ims', 'Edit Stock Item', (int) $unitRow['item_id']));
    } else {
        $message = 'Failed to remove the unit. Please try again.';
    }
}

if (isset($_POST['save-item'])) {
    requireImsStaff();
    $editId = !empty($_POST['item_id']) ? (int) sanitize(decipher($_POST['item_id'])) : 0;
    $showAlert = true;
    $success = false;

    $stockNo = trim($_POST['stock_no'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $itemGroup = trim($_POST['item_group'] ?? '');
    $unit = trim($_POST['unit'] ?? '');
    $existing = $editId > 0 ? find('SELECT pcs_per_unit, number_of_units, number_units_unit, total_units FROM items WHERE id = ?', [$editId]) : null;
    $pcsPerUnit = array_key_exists('pcs_per_unit', $_POST) ? (int) $_POST['pcs_per_unit'] : (int) ($existing['pcs_per_unit'] ?? 0);
    $numberOfUnits = array_key_exists('number_of_units', $_POST) ? (int) $_POST['number_of_units'] : (int) ($existing['number_of_units'] ?? 0);
    $numberUnitsUnit = array_key_exists('number_units_unit', $_POST) ? strtolower(trim($_POST['number_units_unit'] ?? '')) : (isset($existing['number_units_unit']) ? strtolower(trim($existing['number_units_unit'])) : '');
    $quantity = (int) ($_POST['quantity'] ?? 0);
    $minQty = (int) ($_POST['min_qty'] ?? 0);
    $unitCost = (float) ($_POST['unit_cost'] ?? 0);
    $remarks = trim($_POST['remarks'] ?? '');
    $totalUnits = array_key_exists('total_units', $_POST) ? (int) $_POST['total_units'] : (int) ($existing['total_units'] ?? 0);
    $personnel = trim($_POST['personnel'] ?? '');
    $office = trim($_POST['office'] ?? '');
    $itemStatus = trim($_POST['item_status'] ?? 'Functional');
    if (!in_array($itemStatus, ['Functional', 'Transferred'], true)) {
        $itemStatus = 'Functional';
    }
    $transferTo = trim($_POST['transfer_to'] ?? '');

    if ($stockNo === '') {
        $message = 'Stock No. is required.';
        return;
    }
    if ($description === '') {
        $message = 'Description is required.';
        return;
    }
    if ($quantity < 0) {
        $message = 'Quantity cannot be negative.';
        return;
    }
    if ($minQty < 0) {
        $message = 'Minimum QTY cannot be negative.';
        return;
    }
    if ($pcsPerUnit < 0) {
        $message = 'Pieces per unit cannot be negative.';
        return;
    }
    if ($numberOfUnits < 0) {
        $message = 'Number of units cannot be negative.';
        return;
    }
    if ($unitCost < 0) {
        $message = 'Unit cost cannot be negative.';
        return;
    }
    if ($itemStatus === 'Transferred' && $transferTo === '') {
        $message = 'Transferred-to personnel name is required when status is Transferred.';
        return;
    }

    if ($editId > 0) {
        $existingItem = find('SELECT quantity, unit_cost FROM items WHERE id = ?', [$editId]);
        $dup = connection()->prepare('SELECT id FROM items WHERE stock_no = ? AND id <> ?');
        $dup->execute([$stockNo, $editId]);
    } else {
        $dup = connection()->prepare('SELECT id FROM items WHERE stock_no = ?');
        $dup->execute([$stockNo]);
    }
    if ($dup->fetch()) {
        $message = 'Stock No. already exists.';
        return;
    }

    $data = [
        'stock_no' => $stockNo,
        'description' => $description,
        'unit' => $unit,
        'pcs_per_unit' => $pcsPerUnit,
        'number_of_units' => $numberOfUnits,
        'number_units_unit' => $numberUnitsUnit,
        'total_units' => $totalUnits,
        'quantity' => $quantity,
        'min_qty' => $minQty,
        'unit_cost' => $unitCost,
        'personnel' => $personnel,
        'office' => $office,
        'item_status' => $itemStatus,
        'transfer_to' => $itemStatus === 'Transferred' ? $transferTo : null,
        'remarks' => $remarks,
    ];

    if (array_key_exists('item_group', $_POST)) {
        $data['item_group'] = $itemGroup !== '' ? $itemGroup : null;
    }

    if ($editId > 0) {
        $result = update('items', $data, '`id` = ?', [$editId]);
        if ($result !== false) {
            $base = find('SELECT id FROM item_units WHERE item_id = ? AND LOWER(unit) = ?', [$editId, strtolower($unit)]);
            if ($base) {
                update('item_units', ['pcs_per_unit' => max($pcsPerUnit, 1)], '`id` = ?', [$base['id']]);
            } else {
                insert('item_units', ['item_id' => $editId, 'unit' => strtolower($unit), 'pcs_per_unit' => max($pcsPerUnit, 1)]);
            }
            createSystemLog($stationId, $userId, 'Updated stock item', $editId, clientIp());
            if ($existingItem && (int) $existingItem['quantity'] !== $quantity) {
                insert('stock_movements', [
                    'item_id' => $editId,
                    'movement_type' => 'Adjustment',
                    'quantity' => $quantity - (int) $existingItem['quantity'],
                    'reference_no' => 'Physical Count',
                    'personnel' => userName((int) $userId),
                    'office' => 'Inventory Office',
                    'remarks' => 'Stock adjusted from ' . (int) $existingItem['quantity'] . ' to ' . $quantity,
                ]);
            }
            imsRecordCostHistory($editId, $unitCost, (float) ($existingItem['unit_cost'] ?? 0), 'Manual Edit', null, null, (int) $userId);
            $_SESSION["{$prefix}stock_flash"] = ['success' => true, 'message' => 'Item updated successfully.'];
            redirect(customUri('ims', 'Stock and Inventory'));
        } else {
            $message = 'Failed to update item. Please try again.';
        }
    } else {
        $result = insert('items', $data);
        if ($result !== false) {
            insert('item_units', ['item_id' => $result, 'unit' => strtolower($unit), 'pcs_per_unit' => max($pcsPerUnit, 1)]);
            imsRecordCostHistory((int) $result, $unitCost, 0.0, 'Opening', 'Initial unit cost on creation', null, (int) $userId);
            if ($quantity > 0) {
                insert('stock_movements', [
                    'item_id' => $result,
                    'movement_type' => 'Receipt',
                    'quantity' => $quantity,
                    'reference_no' => 'Opening Stock',
                    'personnel' => userName((int) $userId),
                    'office' => 'Inventory Office',
                    'remarks' => 'Initial stock for new item',
                ]);
            }
            createSystemLog($stationId, $userId, 'Added stock item', $result, clientIp());
            $_SESSION["{$prefix}stock_flash"] = ['success' => true, 'message' => 'Item added successfully.'];
            redirect(customUri('ims', 'Stock and Inventory'));
        } else {
            $message = 'Failed to add item. Please try again.';
        }
    }
}

if (isset($_POST['delete-item'])) {
    requireImsStaff();
    $deleteId = !empty($_POST['verifier']) ? (int) sanitize(decipher($_POST['verifier'])) : 0;
    $showAlert = true;
    $success = false;

    if ($deleteId <= 0) {
        $message = 'Invalid item selected.';
        return;
    }

    $stmt = connection()->prepare('SELECT id FROM items WHERE id = ?');
    $stmt->execute([$deleteId]);
    if (!$stmt->fetch()) {
        $message = 'Item not found.';
        return;
    }

    $result = delete('items', '`id` = ?', [$deleteId]);
    if ($result !== false) {
        createSystemLog($stationId, $userId, 'Deleted stock item', $deleteId, clientIp());
        $_SESSION["{$prefix}stock_flash"] = ['success' => true, 'message' => 'Item deleted successfully.'];
        redirect(customUri('ims', 'Stock and Inventory'));
    } else {
        $message = 'Failed to delete item. Please try again.';
    }
}

// ========== Requisition and Issue Slip ==========

if (isset($_POST['save-ris'])) {
    $employeeId = (int) ($_POST['employee_id'] ?? 0);
    $itemIds = $_POST['item_id'] ?? [];
    $quantities = $_POST['quantity'] ?? [];
    $units = $_POST['unit'] ?? [];
    $unitPcs = $_POST['unit_pcs'] ?? [];
    if (!is_array($itemIds)) {
        $itemIds = [$itemIds];
    }
    if (!is_array($quantities)) {
        $quantities = [$quantities];
    }
    if (!is_array($units)) {
        $units = [$units];
    }
    if (!is_array($unitPcs)) {
        $unitPcs = [$unitPcs];
    }
    $purpose = trim($_POST['purpose'] ?? '');
    $division = trim((string) ($_POST['division'] ?? ''));
    $showAlert = true;
    $success = false;

    $lines = [];
    foreach ($itemIds as $index => $itemId) {
        $itemId = (int) $itemId;
        $quantity = (int) ($quantities[$index] ?? 0);
        if ($itemId <= 0 || $quantity <= 0) {
            continue;
        }
        $unit = strtolower(trim((string) ($units[$index] ?? '')));
        if ($unit === '') {
            $message = 'Please select a unit for every item.';
            return;
        }
        $lines[] = ['item_id' => $itemId, 'quantity' => $quantity, 'unit' => $unit];
    }

    if ($employeeId <= 0) {
        $message = 'Please select an employee.';
        return;
    }
    if (empty($lines)) {
        $message = 'Please select at least one item with a quantity.';
        return;
    }
    if ($purpose === '') {
        $message = 'Purpose is required.';
        return;
    }
    if ($division === '') {
        $message = 'Please select a Division.';
        return;
    }

    $risNo = 'RIS-' . date('Ymd') . '-' . str_pad(
        (int) query("SELECT COUNT(*) as cnt FROM requisition_slips WHERE DATE(created_at) = CURDATE()")[0]['cnt'] + 1,
        4,
        '0',
        STR_PAD_LEFT
    );

    beginTransaction();
    $result = insert('requisition_slips', [
        'ris_no' => $risNo,
        'employee_id' => $employeeId,
        'division' => $division,
        'office' => risDivisionOfficeFromEmployee($employeeId)['office'],
        'purpose' => $purpose,
    ]);

    $allOk = $result !== false;
    if ($allOk) {
        foreach ($lines as $line) {
            $item = find('SELECT id, quantity FROM items WHERE id = ?', [$line['item_id']]);
            if (!$item) {
                $allOk = false;
                break;
            }
            $iu = find('SELECT unit, pcs_per_unit FROM item_units WHERE item_id = ? AND LOWER(unit) = ?', [$line['item_id'], $line['unit']]);
            $factor = $iu ? max((int) $iu['pcs_per_unit'], 1) : 1;
            $requestedPieces = (int) $line['quantity'];
            $hasStock = (int) $item['quantity'] >= $requestedPieces;
            $detailResult = insert('requisition_slip_items', [
                'ris_id' => $result,
                'item_id' => $line['item_id'],
                'unit' => $line['unit'],
                'pcs_per_unit' => $factor,
                'quantity' => $line['quantity'],
                'has_stock' => $hasStock ? 1 : 0,
                'status' => 'Pending',
            ]);
            if ($detailResult === false) {
                $allOk = false;
                break;
            }
        }
    }

    if ($allOk && $result !== false) {
        commit();
        createSystemLog($stationId, $userId, 'Created requisition slip', $result, clientIp());
        $_SESSION["{$prefix}stock_flash"] = ['success' => true, 'message' => 'Requisition slip ' . $risNo . ' created successfully.'];
        redirect(customUri('ims', 'Requisition Slips'));
    } else {
        rollBack();
        $message = 'Failed to create requisition slip. Please try again.';
    }
}

// ========== Purchase Order ==========

if (isset($_POST['generate-po'])) {
    requireImsStaff();
    $prId = (int) sanitize(decipher($_POST['pr_id'] ?? null));
    $showAlert = true;
    $success = false;

    $pr = find('SELECT id, pr_no, po_no FROM purchase_requests WHERE id = ?', [$prId]);
    if (!$pr) {
        $message = 'Purchase request not found.';
        return;
    }

    $poNo = trim($pr['po_no'] ?? '');
    if ($poNo === '') {
        $poNo = imsNextDocumentNumber('PO', 'purchase_requests', 'po_no');
    }

    $result = update('purchase_requests', ['po_no' => $poNo, 'po_date' => date('Y-m-d')], '`id` = ?', [$prId]);
    if ($result === false) {
        $message = 'Failed to generate the purchase order. Please try again.';
        return;
    }

    createSystemLog($stationId, $userId, 'Generated purchase order ' . $poNo . ' for PR ' . $pr['pr_no'], $prId, clientIp());
    $_SESSION["{$prefix}stock_flash"] = ['success' => true, 'message' => 'Purchase order ' . $poNo . ' generated successfully.'];
    redirect(customUri('ims', 'Purchase Order'));
}

// ========== Inspection and Acceptance Report ==========

if (isset($_POST['save-iar'])) {
    requireImsStaff();
    $risId = (int) sanitize(decipher($_POST['ris_id'] ?? null));
    $itemsInput = $_POST['items'] ?? [];
    $inspectorName = trim($_POST['inspector_name'] ?? '');
    $supplier = trim($_POST['supplier'] ?? '');
    $poNo = trim($_POST['po_no'] ?? '');
    $poDate = !empty($_POST['po_date']) ? $_POST['po_date'] : null;
    $officeDept = trim($_POST['office_dept'] ?? '');
    $rcc = trim($_POST['responsibility_center_code'] ?? '');
    $invoiceNo = trim($_POST['invoice_no'] ?? '');
    $invoiceDate = !empty($_POST['invoice_date']) ? $_POST['invoice_date'] : null;
    $showAlert = true;
    $success = false;

    if ($risId <= 0) {
        $message = 'Invalid requisition slip.';
        return;
    }
    if ($inspectorName === '') {
        $message = 'Inspector name is required.';
        return;
    }
    if (!is_array($itemsInput) || empty($itemsInput)) {
        $message = 'No items to accept.';
        return;
    }

    $lines = [];
    foreach ($itemsInput as $line) {
        $detailId = (int) ($line['detail_id'] ?? 0);
        $itemId = (int) ($line['item_id'] ?? 0);
        $quantity = (int) ($line['quantity'] ?? 0);
        if ($itemId <= 0 || $quantity <= 0) {
            continue;
        }
        $lines[] = ['detail_id' => $detailId, 'item_id' => $itemId, 'quantity' => $quantity];
    }
    if (empty($lines)) {
        $message = 'No valid items to accept.';
        return;
    }

    $ris = find('SELECT r.id, d.id AS detail_id, d.item_id, d.quantity, d.status FROM requisition_slips r JOIN requisition_slip_items d ON d.ris_id = r.id WHERE r.id = ?', [$risId]);
    if (!$ris) {
        $message = 'Requisition slip not found.';
        return;
    }
    if ($ris['status'] !== 'Pending') {
        $message = 'This requisition slip has already been processed.';
        return;
    }

    beginTransaction();

    try {
        $allOk = true;
        $createdNos = [];
        foreach ($lines as $line) {
            $item = find('SELECT id, stock_no, description, unit, quantity, pcs_per_unit FROM items WHERE id = ?', [$line['item_id']]);
            if (!$item) {
                throw new Exception('Item not found.');
            }

            $iarNo = 'IAR-' . date('Ymd') . '-' . str_pad(
                (int) query("SELECT COUNT(*) as cnt FROM iar WHERE DATE(created_at) = CURDATE()")[0]['cnt'] + 1,
                4,
                '0',
                STR_PAD_LEFT
            );

            $iarResult = insert('iar', [
                'iar_no' => $iarNo,
                'ris_id' => $risId,
                'inspector_name' => $inspectorName,
                'supplier' => $supplier,
                'po_no' => $poNo,
                'po_date' => $poDate,
                'office_dept' => $officeDept,
                'responsibility_center_code' => $rcc,
                'invoice_no' => $invoiceNo,
                'invoice_date' => $invoiceDate,
                'stock_no' => $item['stock_no'],
                'description' => $item['description'],
                'unit' => $item['unit'],
                'quantity' => $line['quantity'],
                'status' => 'Accepted',
            ]);

            if ($iarResult === false) {
                throw new Exception('Failed to create IAR record.');
            }
            $createdNos[] = $iarNo;

            $newQty = (int) $item['quantity'] + $line['quantity'];
            $basePcs = max((int) ($item['pcs_per_unit'] ?? 0), 1);
            $newUnits = (int) floor($newQty / $basePcs);
            $newTotalUnits = $newUnits * $basePcs;
            update('items', ['quantity' => $newQty, 'number_of_units' => $newUnits, 'total_units' => $newTotalUnits], '`id` = ?', [$line['item_id']]);
            insert('stock_movements', [
                'item_id' => $line['item_id'],
                'movement_type' => 'Receipt',
                'quantity' => $line['quantity'],
                'reference_no' => $iarNo,
                'personnel' => $inspectorName,
                'office' => $officeDept,
                'remarks' => 'IAR accepted',
            ]);
        }

        foreach ($lines as $line) {
            if ($line['detail_id'] > 0) {
                update('requisition_slip_items', ['status' => 'Issued'], '`id` = ?', [$line['detail_id']]);
            }
        }

        commit();

        createSystemLog($stationId, $userId, 'Created IAR and issued stock', $risId, clientIp());
        $_SESSION["{$prefix}stock_flash"] = ['success' => true, 'message' => 'IAR ' . implode(', ', $createdNos) . ' created. Stock issued successfully.'];
        redirect(customUri('ims', 'Requisition Slips'));

    } catch (Exception $e) {
        rollBack();
        $message = $e->getMessage();
    }
}

// Disapprove an out-of-stock RIS item
if (isset($_POST['disapprove-ris-item'])) {
    requireImsStaff();
    $detailId = (int) sanitize(decipher($_POST['disapprove-ris-item'] ?? null));
    $showAlert = true;
    $success = false;

    if ($detailId <= 0) {
        $message = 'Invalid item.';
        return;
    }

    $detail = find(
        "SELECT d.id, d.ris_id, d.item_id, d.quantity, d.status
         FROM requisition_slip_items d
         WHERE d.id = ?",
        [$detailId]
    );
    if (!$detail) {
        $message = 'Requisition slip item not found.';
        return;
    }
    if (strtolower((string) $detail['status']) !== 'pending') {
        $message = 'This item has already been processed.';
        return;
    }

    $updateResult = update('requisition_slip_items', ['status' => 'Disapproved'], '`id` = ?', [$detailId]);
    if ($updateResult !== false) {
        createSystemLog($stationId, $userId, 'Disapproved RIS item', (int) $detail['ris_id'], clientIp());
        $_SESSION["{$prefix}stock_flash"] = ['success' => true, 'message' => 'Item disapproved.'];
        redirect(customUri('ims', 'Requisition Slips'));
    } else {
        $message = 'Failed to disapprove item.';
    }
}

// Issue an in-stock pending RIS item (release stock to the requester)
if (isset($_POST['issue-ris-item'])) {
    requireImsStaff();
    $detailId = (int) sanitize(decipher($_POST['issue-ris-item'] ?? null));
    $showAlert = true;
    $success = false;

    if ($detailId <= 0) {
        $message = 'Invalid item.';
        return;
    }

    $detail = find(
        "SELECT d.id, d.ris_id, d.item_id, d.quantity, d.unit, d.pcs_per_unit, d.status,
                CONCAT(e.first_name, ' ', e.last_name) AS requesting_employee,
                r.office AS ris_office
         FROM requisition_slip_items d
         JOIN requisition_slips r ON r.id = d.ris_id
         LEFT JOIN employees e ON e.id = r.employee_id
         WHERE d.id = ?",
        [$detailId]
    );
    if (!$detail) {
        $message = 'Requisition slip item not found.';
        return;
    }
    if (strtolower((string) $detail['status']) !== 'pending') {
        $message = 'This item has already been processed.';
        return;
    }

    $userUnit = strtolower((string) ($detail['unit'] ?? ''));
    $item = find('SELECT id, stock_no, description, unit, quantity, pcs_per_unit, number_of_units, total_units FROM items WHERE id = ?', [$detail['item_id']]);
    if (!$item) {
        $message = 'Item not found.';
        return;
    }

    $requestedQty = (int) $detail['quantity'];
    $factor = max((int) ($detail['pcs_per_unit'] ?? 1), 1);
    $requestedPieces = $requestedQty;
    $available = (int) $item['quantity'];
    if ($requestedQty <= 0) {
        $message = 'Invalid quantity on the requisition slip item.';
        return;
    }
    if ($available < $requestedPieces) {
        $message = 'Insufficient stock to issue. Available: ' . $available . ' pieces (need ' . $requestedPieces . ').';
        return;
    }

    $basePcs = max((int) ($item['pcs_per_unit'] ?? 0), 1);
    $newQty = $available - $requestedPieces;
    $newUnits = (int) floor($newQty / $basePcs);
    $newTotalUnits = $newUnits * $basePcs;
    beginTransaction();
    $statusResult = update('requisition_slip_items', ['status' => 'Issued'], '`id` = ?', [$detailId]);
    $stockResult = $statusResult !== false
        ? update(
            'items',
            ['quantity' => $newQty, 'number_of_units' => $newUnits, 'total_units' => $newTotalUnits],
            '`id` = ?',
            [$detail['item_id']]
        )
        : false;

    if ($statusResult !== false && $stockResult !== false) {
        commit();
        $risRef = find('SELECT ris_no FROM requisition_slips WHERE id = ?', [(int) $detail['ris_id']]);
        $personnelName = trim((string) ($detail['requesting_employee'] ?? ''));
        if ($personnelName === '') {
            $personnelName = $userUnit !== '' ? $userUnit : $item['unit'];
        }
        insert('stock_movements', [
            'item_id' => $detail['item_id'],
            'movement_type' => 'Issue',
            'quantity' => -$requestedPieces,
            'reference_no' => $risRef ? $risRef['ris_no'] : 'RIS-' . $detail['ris_id'],
            'personnel' => $personnelName,
            'office' => trim((string) ($detail['ris_office'] ?? '')),
            'remarks' => 'Issued ' . $requestedQty . ' ' . ($userUnit !== '' ? $userUnit : $item['unit']),
        ]);
        createSystemLog(
            $stationId,
            $userId,
            'Issued ' . $requestedQty . ' ' . ($userUnit !== '' ? $userUnit : $item['unit']) . ' of ' . $item['stock_no'] . ' (' . $item['description'] . ')',
            (int) $detail['ris_id'],
            clientIp()
        );
        $_SESSION["{$prefix}stock_flash"] = ['success' => true, 'message' => 'Item issued. Stock reduced to ' . $newQty . ' pieces (' . $newUnits . ' ' . (empty($item['unit']) ? 'units' : $item['unit']) . ').'];
        redirect(customUri('ims', 'Requisition Slips'));
    } else {
        rollBack();
        $message = 'Failed to issue the item.';
    }
}

// Approve a disapproved RIS item via MOOE (creates a purchase request)
if (isset($_POST['approve-mooe-ris-item'])) {
    requireImsStaff();
    $detailId = (int) sanitize(decipher($_POST['approve-mooe-ris-item'] ?? null));
    $showAlert = true;
    $success = false;

    if ($detailId <= 0) {
        $message = 'Invalid item.';
        return;
    }

    $detail = find(
        "SELECT d.id, d.ris_id, d.item_id, d.quantity, d.status,
                r.ris_no, r.purpose, r.employee_id
         FROM requisition_slip_items d
         JOIN requisition_slips r ON r.id = d.ris_id
         WHERE d.id = ?",
        [$detailId]
    );
    if (!$detail) {
        $message = 'Requisition slip item not found.';
        return;
    }
    if (strtolower((string) $detail['status']) !== 'disapproved') {
        $message = 'This item has already been processed.';
        return;
    }

    $item = find('SELECT id, stock_no, description, unit FROM items WHERE id = ?', [$detail['item_id']]);
    if (!$item) {
        $message = 'Item not found.';
        return;
    }

    $prNo = imsNextDocumentNumber('PR', 'purchase_requests', 'pr_no');

    beginTransaction();
    $prResult = insert('purchase_requests', [
        'pr_no' => $prNo,
        'employee_id' => (int) $detail['employee_id'],
        'item_id' => (int) $detail['item_id'],
        'quantity' => (int) $detail['quantity'],
        'unit_cost' => 0,
        'total_cost' => 0,
        'purpose' => 'From RIS ' . $detail['ris_no'] . ($detail['purpose'] ? ' - ' . $detail['purpose'] : ''),
        'supplier_id' => null,
        'source_of_funds' => 'MOOE',
        'status' => 'pending',
    ]);

    $updateResult = $prResult !== false
        ? update('requisition_slip_items', ['status' => 'Approved'], '`id` = ?', [$detailId])
        : false;

    if ($prResult !== false && $updateResult !== false) {
        commit();
        createSystemLog($stationId, $userId, 'Approved RIS item via MOOE, created PR ' . $prNo, (int) $detail['ris_id'], clientIp());
        $_SESSION["{$prefix}stock_flash"] = ['success' => true, 'message' => 'Item approved via MOOE. Purchase request ' . $prNo . ' created.'];
        redirect(customUri('ims', 'Purchase Requests'));
    } else {
        rollBack();
        $message = 'Failed to approve item via MOOE and create purchase request.';
    }
}

// Save physical count adjustments: update recorded quantity to the actual count.
if (isset($_POST['save-physical-count'])) {
    requireImsStaff();
    $actualCounts = $_POST['actual_count'] ?? [];
    $remarks = $_POST['remarks'] ?? [];
    $showAlert = true;
    $success = false;

    if (!is_array($actualCounts)) {
        $actualCounts = [];
    }
    if (!is_array($remarks)) {
        $remarks = [];
    }

    if (!$actualCounts) {
        $message = 'No item counts were submitted.';
        return;
    }

    $updated = 0;
    beginTransaction();
    try {
        foreach ($actualCounts as $rawId => $rawQty) {
            $itemId = (int) $rawId;
            $qty = max(0, (int) $rawQty);
            $note = trim((string) ($remarks[$rawId] ?? ''));
            if ($itemId <= 0) {
                continue;
            }

            $item = find('SELECT id, stock_no, description, quantity, pcs_per_unit FROM items WHERE id = ?', [$itemId]);
            if (!$item) {
                continue;
            }

            $oldQty = (int) $item['quantity'];
            $basePcs = max((int) ($item['pcs_per_unit'] ?? 0), 1);
            $newUnits = (int) floor($qty / $basePcs);
            $newTotalUnits = $newUnits * $basePcs;
            $result = update('items', ['quantity' => $qty, 'number_of_units' => $newUnits, 'total_units' => $newTotalUnits], '`id` = ?', [$itemId]);
            if ($result !== false) {
                $delta = $qty - $oldQty;
                if ($delta !== 0) {
                    insert('stock_movements', [
                        'item_id' => $itemId,
                        'movement_type' => 'Adjustment',
                        'quantity' => $delta,
                        'reference_no' => 'Physical Count',
                        'personnel' => userName((int) $userId),
                        'office' => 'Inventory Office',
                        'remarks' => ($note !== '' ? $note . ': ' : '') . 'Adjusted from ' . $oldQty . ' to ' . $qty,
                    ]);
                }
                $logDetail = 'Item ' . $item['stock_no'] . ' (' . $item['description'] . ') adjusted from ' . $oldQty . ' to ' . $qty;
                if ($note !== '') {
                    $logDetail .= ' - ' . $note;
                }
                createSystemLog($stationId, $userId, 'Physical count adjustment: ' . $logDetail, $itemId, clientIp());
                $updated++;
            }
        }
        commit();
    } catch (Throwable $ex) {
        rollBack();
        $message = 'Failed to save physical count adjustments.';
        return;
    }

    $success = true;
    $_SESSION["{$prefix}stock_flash"] = ['success' => true, 'message' => 'Physical count adjustments saved for ' . $updated . ' item(s).'];
    redirect(customUri('ims', 'Physical Count'));
}
