<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';


$selectedYear = date("Y");
$user = getUserWithYear($_SESSION['userID'], $selectedYear);
$runWorkouts = $runDates = $averageSpeeds = $distanceRun = $averageWatts = array();
$runsAMonth = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$failureOutputPara = "";

if (isset($_POST['btnFindYear'])) {
    if ($_POST['selectYear'] === "Choose a Year...") {
        $failureOutputPara = "Must choose a year";
    } elseif (count(getUsersWorkoutsByYear($_SESSION['userID'], $_POST['selectYear'])) === 0) {
        $failureOutputPara = "No runs recorded for " . $_POST['selectYear'];
    } else {
        $selectedYear = $_POST['selectYear'];
        $user = getUserWithYear($_SESSION['userID'], $selectedYear);
    }
}

foreach ($user->getWorkouts() as $workout) {
    if (get_class($workout) == "run") {
        array_push($runWorkouts, $workout);
    }
}

// grab data from the last 10 runs or less
for ($i = min(10, count($runWorkouts) - 1); $i >= 0; $i--) {

    array_push($averageSpeeds, round($runWorkouts[$i]->getSpeed() * 3.6, 1));
    array_push($distanceRun, $runWorkouts[$i]->getDistance() / 1000);

    $datetime = new DateTime($runWorkouts[$i]->getDate());
    $date = "{$datetime->format('d/m/y')}";
    array_push($runDates, $date);
}

// count how many rides a month
for ($i = 0; $i < count($runWorkouts); $i++) {
    for ($j = 1; $j <= 12; $j++) {
        if (substr($runWorkouts[$i]->getDate(), 5, 2) == strval($j)) {
            $runsAMonth[$j - 1] = $runsAMonth[$j - 1] + 1;
        }
    }
}

// find averages and totals
$totalDis = $totalDurMins = $totalSpeed = $totalCals = $avDis = $avDur = $avSpeed = $avCals = 0;
foreach ($runWorkouts as $run) {

    $totalDis = $totalDis + $run->getDistance();
    $totalDurMins = $totalDurMins + $run->getDuration();
    $totalSpeed = $totalSpeed + $run->getSpeed();
    $totalCals = $totalCals + $run->getCaloriesBurnt();
}
$avDis = $totalDis / count($runWorkouts);
$avDur = $totalDurMins / count($runWorkouts);
$avSpeed = $totalSpeed / count($runWorkouts);
$avCals = $totalCals / count($runWorkouts);


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Run Stats</title>
</head>
<body>
<div class="container">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="input-group mb-3 mt-3">
            <select id="selectYear" class="custom-select" name="selectYear">
                <option selected>Choose a Year...</option>
                <option>2020</option>
                <option>2019</option>
                <option>2018</option>
                <option>2017</option>
            </select>
            <div class="input-group-append">
                <button id="FindYear" class="btn btn-success" name="btnFindYear" type="submit">Find</button>
            </div>
        </div>
    </form>
    <p class="text-center text-danger"><?php echo $failureOutputPara ?></p>
    <canvas id="averageSpeedChart" width="200" height=75"></canvas>
    <canvas id="distanceRiddenChart" width="200" height="75"></canvas>
    <canvas id="RidePerMonth" width="200" height=100"></canvas>
    <div class="row">
        <div class="col-sm-6 mt-5">
            <h4 class="text-center">Year Total</h4>
            <P>Number of Runs : <?php echo count($runWorkouts) ?></P>
            <p>Distance : <?php echo round($totalDis / 1000, 1) ?> Km</p>
            <P>Duration
                : <?php echo $totalDurHrs = floor($totalDurMins / 60) . 'h' . ($totalDurMins - floor($totalDurMins / 60) * 60 . 'm'); ?></P>
        </div>
        <div class="col-sm-6 mt-5">
            <h4 class="text-center">Average Run</h4>
            <p>Distance : <?php echo round($avDis / 1000, 1) ?> Km</p>
            <P>Duration : <?php echo $avDur ?> Mins</P>
            <P>Speed : <?php echo round($avSpeed * 3.6, 1) ?> Km/h</P>
            <P>Calories Burnt : <?php echo round($avCals) ?></P>
        </div>
    </div>
</div>
</body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>


    <?php
    $js_array = json_encode($averageSpeeds);
    echo "let averageSpeeds = " . $js_array . ";\n";

    $js_array = json_encode($distanceRun);
    echo "let distanceRun = " . $js_array . ";\n";

    $js_array = json_encode($runDates);
    echo "let runDates = " . $js_array . ";\n";

    $js_array = json_encode($runsAMonth);
    echo "let runsAMonth = " . $js_array . ";\n";
    ?>



    var ctx = document.getElementById('averageSpeedChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: runDates,
            datasets: [{
                label: 'Average Speed (Km/h)',
                data: averageSpeeds,
                fill: false,
                borderColor: 'navy',
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var ctx1 = document.getElementById('distanceRiddenChart').getContext('2d');
    var myChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: runDates,
            datasets: [{
                label: 'Distance Riden (Km)',
                data: distanceRun,
                fill: false,
                borderColor: 'navy',
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var ctx2 = document.getElementById('RidePerMonth').getContext('2d');
    var RidePerMonth = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Rides a Month',
                data: runsAMonth,
                backgroundColor: 'navy',
                borderColor: 'navy',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }]
            }
        }
    });


</script>

