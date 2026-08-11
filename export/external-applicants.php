<?php
// export/external-applicants.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once('../includes/function.php');
    redirect(uri() . '/login');
}

require_once(root() . '/includes/database/vacancy.php');
require_once(root() . '/includes/database/employee.php');

$applicants = externalApplicantsList();
?>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Applicant ID</th>
            <th>Full Name</th>
            <th>Sex</th>
            <th>Birthdate</th>
            <th>Age</th>
            <th>Civil Status</th>
            <th>Religion</th>
            <th>Ethnic Group</th>
            <th>PWD Status</th>
            <th>Email Address</th>
            <th>Mobile Number</th>
            <th>Residential Address</th>
            <th>Undergraduate Degree</th>
            <th>Graduate Studies</th>
            <th>Eligibilities</th>
            <th>Job Applications Submitted</th>
            <th>Date Registered</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $i = 1;
        foreach ($applicants as $row):
            $fullName = toName($row['last_name'], $row['first_name'], $row['middle_name'], $row['name_extension'], true);
            $age = !empty($row['birthdate']) && $row['birthdate'] !== '0000-00-00' ? date_diff(date_create($row['birthdate']), date_create('today'))->y : 'N/A';
            $address = implode(', ', array_filter([$row['lot'], $row['street'], $row['subdivision'], $row['barangay'], $row['city'], $row['province'], $row['zip']]));
            $eligibilities = !empty($row['eligibilities']) ? implode('; ', (array)json_decode($row['eligibilities'], true)) : 'None';
        ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= e($row['id']) ?></td>
                <td><?= strtoupper($fullName) ?></td>
                <td><?= e($row['sex']) ?></td>
                <td><?= !empty($row['birthdate']) ? date('Y-m-d', strtotime($row['birthdate'])) : '' ?></td>
                <td><?= $age ?></td>
                <td><?= e($row['civil_status']) ?></td>
                <td><?= e($row['religion']) ?></td>
                <td><?= e($row['ethnic_group']) ?></td>
                <td><?= !empty($row['with_disability']) ? 'PWD' : 'Non-PWD' ?></td>
                <td><?= e($row['email_address']) ?></td>
                <td><?= e($row['mobile_number']) ?></td>
                <td><?= e($address) ?></td>
                <td><?= e($row['undergraduate']) ?></td>
                <td><?= e($row['graduate_studies']) ?></td>
                <td><?= e($eligibilities) ?></td>
                <td><?= (int)$row['application_count'] ?></td>
                <td><?= date('Y-m-d H:i:s', strtotime($row['created_at'])) ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="18"><?= 'Data as of ' . date("F j, Y, g:i a") ?></td>
        </tr>
    </tbody>
</table>
