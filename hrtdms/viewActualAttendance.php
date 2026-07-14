<!DOCTYPE html>

<?php
require_once('../includes/config.php');
// GET VALUES FROM URL
$training_id = isset($_GET['training_id']) ? base64_decode($_GET['training_id']) : '';
$date = isset($_GET['date']) ? base64_decode($_GET['date']) : '';

if (!$training_id || !$date) {
    die("Invalid request.");
}

// DATABASE CONNECTION
$mysqli = new mysqli(HOSTNAME, USER, PASSWORD, DATABASE);

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// FETCH TRAINING DETAILS
$trainingQuery = "
    SELECT 
        title,
        venue
    FROM trainings
    WHERE id = ?
";

$stmtTraining = $mysqli->prepare($trainingQuery);
$stmtTraining->bind_param("s", $training_id);
$stmtTraining->execute();

$trainingResult = $stmtTraining->get_result()->fetch_assoc();

$training_title = $trainingResult['title'] ?? 'N/A';
$training_venue = $trainingResult['venue'] ?? 'N/A';
?>

<html>

<head>

    <meta charset="utf-8">
    <title>Training Attendance Dashboard</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        html,
        body {
            margin: 0;
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            position: relative;
        }

        /* Background image layer with opacity */
        body::before {
            content: "";
            position: fixed;
            inset: 0;

            background-image: url('../assets/img/sdo-bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            opacity: 0.2;
            z-index: -1;
        }

        .header-bar {
            background: linear-gradient(90deg, #034068 0%, #0b5f98 55%, #09436d 100%);
            color: white;
            font-family: 'Oswald', sans-serif;
            padding: 12px 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }

        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1400px;
            margin: auto;
        }

        /* SIDES */
        .header-side {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 277px;
        }

        /* LOGO */
        .logo {
            height: 120px;
            width: auto;
        }

        /* CENTER */
        .header-center {
            text-align: center;
            flex: 1;
        }

        .gov-title {
            font-size: 15px;
            letter-spacing: 2px;
        }

        .main-title {
            font-size: 30px;
            font-weight: bold;
            letter-spacing: 2px;
            margin: 4px 0;
            padding: 20px;
        }

        .region-title {
            font-size: 18px;
            letter-spacing: 1px;
        }

        .meta {
            margin-top: 6px;
            font-size: 18px;
            line-height: 1.5;
        }

        /* COUNT BOX */
        .count-box {
            margin-top: 10px;
            text-align: center;
        }

        .count-number {
            font-size: 40px;
            font-weight: bold;
        }

        .count-label {
            font-size: 12px;
            opacity: 0.9;
        }

        /* ===== CONTENT ===== */

        .container {
            width: 80%;
            margin: auto;
            padding-top: 30px;
            flex: 1;
            color: #0c5e97;
        }

        .section-title {
            margin-bottom: 20px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            padding: 10px 15px;
            border-radius: 25px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s, box-shadow 0.2s;
            background-color: white;
        }

        .card:hover {
            transform: scale(1.03);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .avatar {
            flex: 0 0 30%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .avatar img {
            width: 75px;
            height: 75px;
            border-radius: 50%;
            border: 4px solid #a0d5f9;
        }

        .info {
            flex: 1 1 70%;
            padding-left: 15px;
        }

        .info .name {
            font-size: 1.1m;
            font-weight: bold;
        }

        .info .position {
            font-size: 0.95em;
            opacity: 0.9;
            margin-top: 5px;
        }

        .footer {
            text-align: center;
            font-size: 1em;
            color: #0c5e96;
            padding: 15px 0;
            margin-top: 200px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        /* LEFT TITLE */
        .section-title {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            color: #0c5e96;
        }

        /* RIGHT COUNT BOX (MAKE IT POP) */
        .count-box {
            text-align: center;
            background-color: white;
            padding: 10px 18px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(5px);
        }

        /* BIG NUMBER */
        .count-number {
            font-size: 52px;
            font-weight: 800;
            color: #0c5e96;
            line-height: 1;
        }

        /* LABEL */
        .count-label {
            font-size: 12px;
            letter-spacing: 1px;
            opacity: 0.9;
        }

        @media(max-width:768px) {

            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .count-card {
                width: 100%;
            }

            .grid {
                grid-template-columns: repeat(1, 1fr);
            }
        }
    </style>

</head>

<body>

    <!-- HEADER -->

    <div class="header-bar">

        <div class="header-inner">

            <!-- LEFT LOGO -->
            <div class="header-side left">

                <img src="<?php echo 'http://' . $_SERVER['HTTP_HOST']; ?>/assets/img/sdod.png" class="logo">


            </div>

            <!-- CENTER CONTENT -->
            <div class="header-center">


                <div class="main-title">
                    <?= htmlspecialchars($training_title) ?>
                </div>
                <div style="background: #6391ba; width: 80%; height: 3px; margin: auto; margin-bottom: 20px; "></div>
                <div class="region-title">
                    Venue: <strong><?= htmlspecialchars($training_venue) ?></strong>
                </div>

                <div class="meta">
                    <div id="date-time"></div>
                </div>

            </div>

            <!-- RIGHT LOGO + COUNT -->
            <div class="header-side right">
                <img src="<?php echo 'http://' . $_SERVER['HTTP_HOST']; ?>/assets/img/dpl.png" class="logo">
            </div>

        </div>

    </div>

    <!-- CONTENT -->

    <div class="container">

        <div class="section-header">
            <h3 class="section-title">
                List of Attendees
            </h3>
            <div class="count-box">
                <div class="count-number" id="participant-count">0</div>
                <div class="count-label">Participants Present</div>
            </div>

        </div>
        <div class="grid" id="participant-grid"></div>

        <div class="footer">
            DepEd Dipolog - Training Attendance Dashboard
            <br>
            <i>Copyright © Department of Education Schools Division of Dipolog City 2026 </i>
        </div>

    </div>

    <!-- DATE TIME -->

    <script>

        function updateDateTime() {

            const now = new Date();

            const options = {
                weekday: 'short',
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            };

            const dateStr = now.toLocaleDateString(undefined, options);

            const timeStr = now.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            });

            document.getElementById('date-time').innerHTML =
                `Current Date & Time: <strong>${dateStr} | ${timeStr}</strong>`;
        }

        updateDateTime();

        setInterval(updateDateTime, 60000);

    </script>

    <!-- LOAD ATTENDANCE -->

    <script>

        //            setInterval(() => {
        //                loadAttendance();
        //            }, 5000);

        function loadAttendance() {

            const params = new URLSearchParams(window.location.search);

            const training_id = params.get('training_id');
            const selected_date = params.get('date');

            if (!training_id || !selected_date) {

                alert("Missing training_id or date in URL");

                return;
            }

            fetch(`get_attendance.php?training_id=${training_id}&date=${selected_date}`)

                .then(response => response.json())

                .then(participants => {

                    const grid = document.getElementById('participant-grid');

                    grid.innerHTML = "";

                    document.getElementById('participant-count').innerText = participants.length;

                    participants.forEach(p => {

                        const card = document.createElement('div');

                        card.className = 'card';

                        const avatar = document.createElement('div');
                        avatar.className = 'avatar';
                        const img = document.createElement('img');
                        //                                if (p.img_url) {
                        //                                    // Attendance image always wins
                        //                                    img.src = '../' + p.img_url;
                        //                                } else {
                        // Gender-based default only
                        img.src = (p.gender === 'Male')
                            ? '../assets/img/male.jpg'
                            : '../assets/img/female.jpg';
                        //                                }
                        avatar.appendChild(img);

                        // INFO

                        const info = document.createElement('div');
                        info.className = 'info';
                        const nameDiv = document.createElement('div');
                        nameDiv.className = 'name';
                        nameDiv.innerText = p.name.toUpperCase();
                        const posDiv = document.createElement('div');
                        posDiv.className = 'position';

                        posDiv.innerText = p.position;

                        info.appendChild(nameDiv);

                        info.appendChild(posDiv);

                        card.appendChild(avatar);

                        card.appendChild(info);

                        grid.appendChild(card);

                    });

                })

                .catch(error => {

                    console.error("Error fetching attendance:", error);

                });
        }

        document.addEventListener("DOMContentLoaded", function () {

            loadAttendance();

        });

    </script>

</body>

</html>