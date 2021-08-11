<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$failureOutputPara = "";
$numOfRunsToDislay = 2;
$totalRuns = $totalDis = $totalDurMins = $avDis = $avDur = $avSpeed = $avCals = $count = 0;

if (isset($_POST['btnShowRuns'])) {
    if (!empty($_POST['numOfRuns'])) {
        $currentDate = new DateTime();
        $user = getUserWithYear($_SESSION['userID'], $currentDate->format("Y"));
        $numOfRunsToDislay = $_POST['numOfRuns'];
        $count = 0;
        foreach ($user->getWorkouts() as $workout) {
            if (get_class($workout) == "run") {
                $count++;
            }
        }
        if ($count > 0) {
            $runWorkouts = getRunWorkouts($user);
            $runDatesPrediction = runDatesPrediction($runWorkouts, $numOfRunsToDislay);
            $runDates = getRunDates($runWorkouts, $numOfRunsToDislay);

            $averageSpeeds = getRunSpeeds($runWorkouts, $numOfRunsToDislay);
            $distanceRun = getRunDistances($runWorkouts, $numOfRunsToDislay);
            $runsAMonth = runsAMonth($runWorkouts);
            $totalDis = getTotalDistanceRun($runWorkouts);
            $totalDurMins = getTotalDurationRun($runWorkouts);

            $avSpeed = getAverageSpeed($runWorkouts);
            $avDis = getAverageDistanceRun($runWorkouts);
            $avDur = getAverageDurationRun($runWorkouts);
            $avCals = getAverageCalories($runWorkouts);
            $trendLine = createTrendLine($runWorkouts, $numOfRunsToDislay);
            $totalRuns = count($runWorkouts);
        } else {
            $failureOutputPara = "No runs recorded for " . $_POST['selectYear'];
        }
    }
}

function getRunWorkouts($user)
{
    $runWorkouts = array();
    foreach ($user->getWorkouts() as $workout) {
        if (get_class($workout) == "run") {
            array_push($runWorkouts, $workout);
        }
    }
    return $runWorkouts;
}

function getRunDistances($runWorkouts, $numOfRunsToDislay)
{
    $distanceRun = array();
    // grab data from the last 10 runs or less
    for ($i = min($numOfRunsToDislay, count($runWorkouts) - 1); $i >= 0; $i--) {
        array_push($distanceRun, $runWorkouts[$i]->getDistance() / 1000);
    }
    return $distanceRun;
}

function getRunSpeeds($runWorkouts, $numOfRunsToDislay)
{
    $averageSpeeds = array();
    // grab data from the last 10 runs or less
    for ($i = min($numOfRunsToDislay, count($runWorkouts) - 1); $i >= 0; $i--) {
        array_push($averageSpeeds, round($runWorkouts[$i]->getSpeed() * 3.6, 1));
    }
    return $averageSpeeds;
}

function runDatesPrediction($runWorkouts, $numOfRunsToDislay)
{
    $runDates = array();
    // grab data from the last 10 runs or less
    for ($i = min($numOfRunsToDislay, count($runWorkouts) - 1); $i >= 0; $i--) {
        $datetime = new DateTime($runWorkouts[$i]->getDate());
        $date = "{$datetime->format('d/m/y')}";
        array_push($runDates, $date);
    }
    array_push($runDates, "Prediction");
    array_push($runDates, "Prediction");
    array_push($runDates, "Prediction");
    return $runDates;
}

function getRunDates($runWorkouts, $numOfRunsToDislay)
{
    $runDates = array();
    // grab data from the last 10 runs or less
    for ($i = min($numOfRunsToDislay, count($runWorkouts) - 1); $i >= 0; $i--) {
        $datetime = new DateTime($runWorkouts[$i]->getDate());
        $date = "{$datetime->format('d/m/y')}";
        array_push($runDates, $date);
    }
    return $runDates;
}

// count how many rides a month
function runsAMonth($runWorkouts)
{
    $runsAMonth = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
    for ($i = 0; $i < count($runWorkouts); $i++) {
        for ($j = 1; $j <= 12; $j++) {
            if (substr($runWorkouts[$i]->getDate(), 5, 2) == strval($j)) {
                $runsAMonth[$j - 1] = $runsAMonth[$j - 1] + 1;
                break;
            }
        }
    }
    return $runsAMonth;
}


// find averages and totals

function getTotalDistanceRun($runWorkouts)
{
    $totalDis = 0;
    foreach ($runWorkouts as $run) {
        $totalDis = $totalDis + $run->getDistance();
    }
    return $totalDis;
}

function getTotalDurationRun($runWorkouts)
{
    $totalDur = 0;
    foreach ($runWorkouts as $run) {
        $totalDur = $totalDur + $run->getDuration();
    }
    return $totalDur;
}


function getAverageDistanceRun($runWorkouts)
{
    return $avDis = getTotalDistanceRun($runWorkouts) / count($runWorkouts);
}

function getAverageDurationRun($runWorkouts)
{
    return $avDur = getTotalDurationRun($runWorkouts) / count($runWorkouts);
}

function getAverageSpeed($runWorkouts)
{
    $totalSpeed = 0;
    foreach ($runWorkouts as $run) {
        $totalSpeed = $totalSpeed + $run->getSpeed();
    }

    return $avSpeed = $totalSpeed / count($runWorkouts);
}

function getAverageCalories($runWorkouts)
{
    $totalCals = 0;
    foreach ($runWorkouts as $run) {
        $totalCals = $totalCals + $run->getCaloriesBurnt();
    }

    return $avCals = $totalCals / count($runWorkouts);
}

function createTrendLine($runWorkouts, $numOfRunsToDislay)
{
    $trendline = array();
    $totalDiff = 0;
    for ($i = min($numOfRunsToDislay, count($runWorkouts) - 1); $i >= 0; $i--) {
        if ($i === (count($runWorkouts) - 1)) {
            array_push($trendline, round($runWorkouts[$i]->getSpeed() * 3.6, 1));
        } else {
            $diff = ($runWorkouts[$i]->getSpeed() - $runWorkouts[$i + 1]->getSpeed()) / 2;
            $totalDiff = $totalDiff + $diff;
            array_push($trendline, round(($runWorkouts[$i + 1]->getSpeed() + $diff) * 3.6, 1));
        }
    }
    array_push($trendline, round(($runWorkouts[$i + 1]->getSpeed() + ($totalDiff / $numOfRunsToDislay)) * 3.6, 1));
    array_push($trendline, round(($trendline[count($trendline) - 1] + (($totalDiff / $numOfRunsToDislay) * 0.5) * 3.6), 1));
    array_push($trendline, round(($trendline[count($trendline) - 1] + (($totalDiff / $numOfRunsToDislay) * 0.5) * 3.6), 1));
    return $trendline;
}

function trendlineMessage($trendline)
{
    if ($trendline[count($trendline) - 1] < $trendline[count($trendline) - 2]) {
        echo '<p class="text-center mt-3 mb-5">Over time your speed has been trending slower.</p>';
    } elseif ($trendline[count($trendline) - 1] > $trendline[count($trendline) - 2]) {
        echo '<p class="text-center mt-3 mb-5">Over time your speed has been trending faster.</p>';
    } else {
        echo '<p class="text-center mt-3 mb-5">Over time your speed has been steady with little change to it.</p>';
    }
}


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Run Stats</title>
</head>
<body>
<div class="container">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <h4 class="text-center mt-3">Enter the number of runs you would like to see.</h4>

        <div class="row">
            <div class="col"></div>
            <div class="col">
                <div class="input-group mb-3 mt-3">
                    <input class="form-control" name="numOfRuns" min="2" max="50"
                           value="<?php echo $numOfRunsToDislay ?>"
                           type="number">
                    <div class="input-group-append">
                        <button class="btn btn-success" name="btnShowRuns" type="submit">Show</button>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </form>
    <p class="text-center text-danger"><?php echo $failureOutputPara ?></p>
    <canvas id="averageSpeedChart" width="200" height=75"></canvas>
    <?php
    if ($count > 0) {
        trendlineMessage($trendLine);
    }
    ?>
    <canvas id="distanceRiddenChart" width="200" height="75"></canvas>
    <canvas id="RidePerMonth" width="200" height=100"></canvas>
    <div class="row">
        <div class="col-sm-6 mt-5">
            <h4 class="text-center">Year Total</h4>
            <P>Number of Runs : <?php echo $totalRuns ?></P>
            <p>Distance : <?php echo round($totalDis / 1000, 1) ?> Km</p>
            <P>Duration
                : <?php echo $totalDurHrs = floor($totalDurMins / 60) . 'h ' . ($totalDurMins - floor($totalDurMins / 60) * 60 . 'm'); ?></P>
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

    $js_array = json_encode($trendLine);
    echo "let trendLine = " . $js_array . ";\n";


    $js_array = json_encode($distanceRun);
    echo "let distanceRun = " . $js_array . ";\n";

    $js_array = json_encode($runDatesPrediction);
    echo "let runDatesPrediction = " . $js_array . ";\n";

    $js_array = json_encode($runDates);
    echo "let runDates = " . $js_array . ";\n";

    $js_array = json_encode($runsAMonth);
    echo "let runsAMonth = " . $js_array . ";\n";
    ?>



    var ctx = document.getElementById('averageSpeedChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: runDatesPrediction,
            datasets: [{
                label: 'Average Speed (Km/h)',
                data: averageSpeeds,
                fill: false,
                borderColor: 'navy',
                borderWidth: 2,
                showLine: false,
                pointRadius: 4
            }, {
                label: 'Trend Line',
                data: trendLine,
                fill: false,
                borderColor: 'green',
                borderWidth: 2,
                pointRadius: 0,
                pointHitRadius: 0
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
                borderWidth: 2,
                pointRadius: 4,
                lineTension: 0.2
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

