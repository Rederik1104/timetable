<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="stundenplan.css"/>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Timetable</title>


</head>
<body>
    <nav class="navbar bg-body-tertiary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Your Timetable</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                    aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Timy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="infos.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="stundenplan.php">Timetable</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="user.php">User</a>
                        </li>
                        <li>
                            <button onclick="logout()" style="text-decoration: none; border: none; background: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                     class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                          d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                                    <path fill-rule="evenodd"
                                          d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                                </svg>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
<main>
    <script>
        function logout() {
            window.location.href = "logout.php";
        }
    </script>
    <table class="table" style="position:relative; margin-top: 75px;">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Monday</th>
            <th scope="col">Tuesday</th>
            <th scope="col">Wednesday</th>
            <th scope="col">Thursday</th>
            <th scope="col">Friday</th>
        </tr>
        </thead>
        <tbody class="table-group-divider">
        <?php
        include("database.php");

        // Prepare the main query to fetch schedule entries
        $sql = $pdo->prepare("SELECT day, lesson, duration, subject_name, subject.color FROM schedules JOIN subject on schedules.subjectID = subject.ID WHERE userID = :userID ORDER BY day ASC, lesson ASC");
        $sql->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
        $sql->execute();

        // Initialize an array to store schedule entries by day and lesson
        $schedule = [];
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $schedule[$row['day']][$row['lesson']] = [
                'subject_name' => $row['subject_name'],
                'duration' => $row['duration'],
                'color' => $row['color']
            ];
        }

        // Define fixed lesson times
        // The start time of the first lesson, can be changed by the user
        
        $start_time = "08:00";

        // Fetch lesson duration from the database
        $sqlDuration = $pdo->prepare("SELECT * FROM hourLength WHERE createdBy = :id");
        $sqlDuration->bindParam(":id", $_SESSION['userID']);
        $sqlDuration->execute();
        $duration = $sqlDuration->fetch(PDO::FETCH_ASSOC);
        $lesson_duration = $duration['length']; // lesson duration in minutes

        // Generate lesson times with breaks
        $lesson_times = [];
        for ($i = 0; $i < 9; $i++) {
            // Set lesson start and end times
            $time = new DateTime($start_time);
            $time->add(new DateInterval("PT{$lesson_duration}M"));
            $lesson_times[$i+1] = $start_time . " - " . $time->format("H:i");
            
            // Update start time for next lesson by adding the lesson duration + 5 minutes
            $time->add(new DateInterval("PT5M")); // 5-minute break after each lesson
            $start_time = $time->format("H:i");

            // Add a 15-minute break after the 2nd lesson
            if ($i == 1) {
                $break_start = new DateTime($start_time);
                $break_start->add(new DateInterval("PT15M"));
                $lesson_times['break_15'] = $start_time . " - " . $break_start->format("H:i");
                $start_time = $break_start->format("H:i");
            }
            
            // Add a 10-minute break after the 4th lesson
            if ($i == 3) {
                $break_start = new DateTime($start_time);
                $break_start->add(new DateInterval("PT10M"));
                $lesson_times['break_10'] = $start_time . " - " . $break_start->format("H:i");
                $start_time = $break_start->format("H:i");
            }
        }

        // Display the table rows with lessons and breaks
        foreach ($lesson_times as $key => $time_range) {
            echo "<tr>";

            // Check if the row is a break
            if ($key === 'break_15') {
                echo "<th scope='row'>Break (15 min)</th>";
            } elseif ($key === 'break_10') {
                echo "<th scope='row'>Break (10 min)</th>";
            } else {
                echo "<th scope='row'>{$time_range}</th>";
            }

            // Array of days for each lesson or break
            $days = ['1', '2', '3', '4', '5'];
            
            foreach ($days as $day) {
                if (is_numeric($key) && isset($schedule[$day][$key])) {
                    $subject_name = $schedule[$day][$key]['subject_name'];
                    $color = $schedule[$day][$key]['color'];
                    echo "<td style='background-color: $color' id='day-{$day}-lesson-{$key}' class='td' data-label='{$days[$day - 1]}'>{$subject_name}</td>";
                } else {
                    echo "<td class='td' data-label='{$days[$day - 1]}' id='day-{$day}-lesson-{$key}'></td>";
                }
            }
            echo "</tr>";
        }


        ?>
        </tbody>
    </table>

        <div class="button-container">
            <button class="btn-create-timetable" id="createTimetable" onclick="createTimetable()">Create Timetable</button>
        </div>

    <div class="draggable-items">
    <?php
    include "database.php";

    $sqlSubject = $pdo->query("SELECT * FROM subject ORDER BY subject_name");
    ?>
    <div class="subject-cards" style="display:flex; flex-direction: row">
    <?php

    while ($row = $sqlSubject->fetch()) {
    ?>
        <div class="card_add" id="<?php echo $row['ID']; ?>" draggable="true">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row["subject_name"]; ?></h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><?php echo $row["color"]; ?></li>
                </ul>
        <?php
        if ($row['editable'] == 0) {
            ?>
                <div class="card-body">
                    <button type="submit" class="btn-close" aria-label="Close"></button>
                </div>
            <?php
        } else {
            ?>
                <form action="subject_delete.php?roomID=<?php echo $row["ID"]; ?>" method="POST">
                    <div class="card-body">
                        <button type="submit" class="btn-close" aria-label="Close"></button>
                    </div>
                </form>
            <?php
        }
        ?>
            </div>
        </div>
    <?php
    }
    ?>
    </div>
    </div>





    <script src="stundenplan.js"></script>
    
</main>

    
</body>
</html>
