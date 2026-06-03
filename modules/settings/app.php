<?php
// modules/settings/app.php
$oldPassword = $password = $passwordConfirm = $generatePassword = null;

if (isset($_POST['update-password'])) {
    $showAlert = true;
    $oldPassword = sanitize($_POST['old-password']);
    $password = sanitize($_POST['password']);
    $passwordConfirm = sanitize($_POST['password-confirm']);
    $generatePassword = sanitize($_POST['generate-password']);

    if (empty($oldPassword) || empty($password) || empty($passwordConfirm)) {
        $message = 'All fields in asterisk (*) are required.';
        return;
    }

    if (!verifyAccountPassword($userId, $oldPassword)) {
        $message = 'You have entered an incorrect old password.';
        return;
    }

    if ($password !== $passwordConfirm) {
        $message = 'The new password you entered does not match.';
        return;
    }

    if (!checkPasswordStrength($passwordConfirm)) {
        $message = 'The new password you entered does not meet the recommendations specified below.';
        return;
    }

    if ($passwordConfirm === $oldPassword) {
        $message = 'The new password you entered matches your old password.';
        return;
    }

    $result = updateAccountPassword($userId, hashPassword($passwordConfirm), 'Changed');

    if ($result === false) {
        $message = 'We encountered an error on our end. Please try again later.';
        return;
    }

    $success = true;
    $message = $result === 0 ? 'No changes have been made to your password.' : 'Your password has been updated successfully.';

    createSystemLog($stationId, $userId, 'Updated password', $userId, clientIp());
}

if (isset($_POST['update-contact-details'])) {
    $alternateEmail = sanitize($_POST['alternate-email']);
    $alternateMobile = sanitize($_POST['alternate-mobile']);
    $showAlert = true;
    $result = updateEmployeeContactDetails($alternateMobile, $alternateEmail, $userId);

    if ($result === false) {
        $message = 'We encountered an error on our end. Please try again later.';
        return;
    }

    $success = true;
    $message = $result === 0 ? 'No changes have been made to your contact details.' : 'Your contact details have been updated successfully.';

    createSystemLog($stationId, $userId, 'Updated contact details', $userId, clientIp());
}

if (isset($_POST['update-professional-titles'])) {
    $before = sanitize($_POST['before-title']);
    $after = sanitize($_POST['after-title']);
    $showAlert = true;
    $result = updateProfessionalTitles($before, $after, $userId);

    if ($result === false) {
        $message = 'We encountered an error on our end. Please try again later.';
        return;
    }

    $success = true;
    $message = $result === 0 ? 'No changes have been made to your professional title.' : 'Your professional title has been updated successfully.';

    createSystemLog($stationId, $userId, 'Updated professional titles', $userId, clientIp());
}

if (isset($_POST['update-profile-photo'])) {
    $employeePhoto = sanitize(decipher($_POST['image-verifier'] ?? null));
    $employeeId = $userId;
    $showAlert = true;
    $stagedFile = null;

    try {
        if (!empty($_FILES['image-upload']['tmp_name']) && is_uploaded_file($_FILES['image-upload']['tmp_name'])) {
            $stagedFile = stageUploadedFile(
                $_FILES['image-upload'],
                ['image/png' => 'png', 'image/jpeg' => 'jpg'],
                root() . "/uploads/images/{$employeeId}",
                "USER"
            );
        } else {
            throw new Exception("Please select a valid profile image file before submitting.");
        }

        beginTransaction();

        $dbPhotoPath = "uploads/images/{$employeeId}/" . $stagedFile['secure_name'];
        $affectedProfilePhoto = updateProfilePhoto($dbPhotoPath, $employeeId);

        if ($affectedProfilePhoto === false) {
            throw new Exception("Database transaction subsystem mutation failure.");
        }

        commitStagedFile($stagedFile);
        commit();

        $success = true;
        $message = 'Profile photo has been updated successfully.';
        createSystemLog($stationId, $userId, 'Updated your profile photo', $userId, clientIp());

        if (!empty($employeePhoto) && file_exists(root() . '/' . $employeePhoto)) {
            if (basename(root() . '/' . $employeePhoto) !== 'user.png') {
                unlink(root() . '/' . $employeePhoto);
            }
        }

    } catch (Exception $e) {
        rollBack();
        if ($stagedFile && file_exists($stagedFile['full_path'])) {
            unlink($stagedFile['full_path']);
        }
        $success = false;
        $message = $e->getMessage();
    }
}