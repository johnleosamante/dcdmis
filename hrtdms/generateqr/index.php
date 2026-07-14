<!DOCTYPE html>
<?php
require_once('../../includes/config.php');

$mysqli = new mysqli(HOSTNAME, USER, PASSWORD, DATABASE);

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

/**
 * SEARCH EMPLOYEES
 */
$employees = [];

if (!empty($_GET['search'])) {

    $search = '%' . trim($_GET['search']) . '%';

    $sql = "
        SELECT
            id,
            first_name,
            middle_name,
            last_name
        FROM employees
        WHERE
            (first_name LIKE ?
            OR middle_name LIKE ?
            OR last_name LIKE ?
            OR CONCAT(first_name, ' ', middle_name, ' ', last_name) LIKE ? OR CONCAT(first_name, ' ', last_name) LIKE ?) AND status='Active'
        ORDER BY last_name ASC, first_name ASC
        LIMIT 10
    ";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssss", $search, $search, $search, $search, $search);
    $stmt->execute();

    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
}

/**
 * SELECTED EMPLOYEE
 */
$selectedEmployee = null;

if (!empty($_GET['employee_id'])) {

    $sql = "
        SELECT
            id,
            first_name,
            middle_name,
            last_name
        FROM employees
        WHERE id = ?
        LIMIT 1
    ";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $_GET['employee_id']);
    $stmt->execute();

    $result = $stmt->get_result();
    $selectedEmployee = $result->fetch_assoc();
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DepEd Barcode Portal</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            padding: 20px;
            position: relative;
            min-height: 100vh;
            background: #f4f6f9;
        }

        /* Background Image Layer */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;

            background: url('../../assets/img/sdo-bg.jpg') center center no-repeat;
            background-size: cover;

            opacity: 0.2;
            /* 20% */

            z-index: -1;
        }

        .container {
            max-width: 500px;
            margin: auto;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .08);
            margin-bottom: 20px;
        }

        .logo {
            text-align: center;
            margin-bottom: 15px;
        }

        .logo h1 {
            margin: 0;
            font-size: 26px;
            color: #2d2f8d;
        }

        .logo p {
            margin-top: 5px;
            color: #6c757d;
            font-size: 14px;
        }

        .label {
            font-weight: 600;
            font-size: 16px;
            display: block;
            margin-bottom: 10px;
        }

        .search-box {
            width: 100%;
            padding: 16px;
            font-size: 18px;
            border-radius: 12px;
            border: 2px solid #dee2e6;
        }

        .btn {
            width: 100%;
            padding: 16px;
            font-size: 18px;
            border: none;
            border-radius: 12px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 12px;
        }

        .btn-primary {
            background: #2d2f8d;
            color: white;
        }

        .btn-success {
            background: #198754;
            color: white;
        }

        .employee-item {
            padding: 16px;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            margin-bottom: 10px;
            background: white;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .employee-item:hover {
            background: #f8f9fa;
        }

        .employee-name {
            font-size: 18px;
            font-weight: bold;
        }

        .barcode-card {
            text-align: center;
        }

        .employee-header h2 {
            margin: 0;
            font-size: 22px;
        }

        .employee-header p {
            margin-top: 5px;
            color: #6c757d;
        }

        svg {
            width: 100%;
            height: auto;
        }

        .app-footer {
            text-align: center;
            padding: 15px;
            font-size: 13px;
            color: #6c757d;
            margin-top: auto;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- SEARCH -->
        <div class="card">

            <div class="logo">
                <img src="../../assets/img/sdod.png" alt="DepEd Logo"
                    style="width:90px; height:auto; margin-bottom:10px;">

                <h1><i class="fa fa-barcode"></i> DepEd Barcode Portal</h1>
                <p>Find your employee barcode</p>
            </div>

            <hr style="color: #f0f0f3; margin: 20px;">

            <form method="GET">
                <label class="label">Search Employee Name</label>

                <input type="text" name="search" class="search-box" placeholder="ex: Juan dela Cruz"
                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search"></i> Search
                </button>
            </form>

        </div>

        <!-- RESULTS -->
        <?php if (!empty($employees)): ?>

            <div class="card">

                <h3>Search Results</h3>

                <?php foreach ($employees as $employee): ?>

                    <a class="employee-item"
                        href="?search=<?= urlencode($_GET['search'] ?? '') ?>&employee_id=<?= $employee['id'] ?>">

                        <div class="employee-name">
                            <?=
                                htmlspecialchars(trim(
                                    $employee['first_name'] . ' ' .
                                    $employee['middle_name'] . ' ' .
                                    $employee['last_name']
                                ))
                                ?>
                        </div>

                    </a>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

        <!-- BARCODE -->
        <?php if ($selectedEmployee): ?>

            <div class="card barcode-card" id="barcodeCard">

                <div class="employee-header">
                    <h2>
                        <?=
                            htmlspecialchars(trim(
                                $selectedEmployee['first_name'] . ' ' .
                                $selectedEmployee['middle_name'] . ' ' .
                                $selectedEmployee['last_name']
                            ))
                            ?>
                    </h2>

                    <p>Employee Barcode</p>
                </div>

                <svg id="barcode"></svg>


            </div>

            <button class="btn btn-success" onclick="downloadBarcode()">
                <i class="fa fa-download"></i>
                Download PNG
            </button>

            <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
            <script>
                JsBarcode("#barcode", "<?= $selectedEmployee['id'] ?>", {
                    format: "CODE128",
                    width: 4,
                    height: 140,
                    displayValue: true
                });

                function downloadBarcode() {

                    const element = document.getElementById("barcodeCard");

                    html2canvas(element, {
                        scale: 3, // better quality
                        useCORS: true
                    }).then(canvas => {

                        const link = document.createElement("a");
                        link.download = "employee-barcode.png";
                        link.href = canvas.toDataURL("image/png");

                        link.click();
                    });
                }
            </script>

        <?php endif; ?>

    </div>

</body>
<footer class="app-footer">
    <p style="margin:0;">
        Copyright © Department of Education<br>
        Schools Division of Dipolog City <?= date('Y') ?>
    </p>
</footer>

</html>