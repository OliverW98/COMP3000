<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$failureOutputPara = $selectExe = "";
$user = getUser($_SESSION['userID']);
$userGoals = $user->getGoals();

$averageCycleSpeedGoal = $averageCycleDistanceGoal = $averageCycleElevationGoal = 0;
$cycleWorkouts = getCycleWorkouts($user);

foreach ($userGoals as $goal) {
    if ($goal->getType() === "0" && $goal->getTitle() === "averageSpeed") {
        $averageCycleSpeedGoal = $goal->getValue();
        $avrSpeedDiff = averageSpeedDiff($cycleWorkouts);
        $averageCycleSpeed = getAverageSpeed($cycleWorkouts);
        $speedPrediction = createSpeedPrediction($userGoals, $averageCycleSpeed, $avrSpeedDiff);
        $cycleSpeedDates = createDates($speedPrediction, averageDateDiff($cycleWorkouts));
    } elseif ($goal->getType() === "0" && $goal->getTitle() === "averageDistance") {
        $averageCycleDistanceGoal = $goal->getValue();
        $avrDistanceDiff = averageDistanceDiff($cycleWorkouts);
        $averageCycleDistance = getAverageDistance($cycleWorkouts);
        $distancePrediction = createDistancePrediction($userGoals, $averageCycleDistance, $avrDistanceDiff);
        $cycleDistanceDates = createDates($distancePrediction, averageDateDiff($cycleWorkouts));
    } elseif ($goal->getType() === "0" && $goal->getTitle() === "averageElevation") {
        $averageCycleElevationGoal = $goal->getValue();
        $avrElevationDiff = averageElevationDiff($cycleWorkouts);
        $averageCycleElevation = getAverageElevation($cycleWorkouts);
        $elevationPrediction = createElevationPrediction($userGoals, $averageCycleElevation, $avrElevationDiff);
        $cycleElevationDates = createDates($elevationPrediction, averageDateDiff($cycleWorkouts));
    }
}

if (isset($_POST['btnSetCycleSpeedGoal'])) {
    if (count($userGoals) === 0) {
        createGoal($_SESSION['userID'], 0, "averageSpeed", $_POST['speedGoal']);
    } else {
        $found = false;
        foreach ($userGoals as $goal) {
            if ($found == false && $goal->getType() === "0" && $goal->getTitle() === "averageSpeed") {
                editGoal($goal->getGoalID(), $_POST['speedGoal']);
                $found = true;
            }
        }
        if ($found == false) {
            createGoal($_SESSION['userID'], 0, "averageSpeed", $_POST['speedGoal']);
        }
    }
    header("Refresh:0");
}

if (isset($_POST['btnDeleteCycleSpeedGoal'])) {
    $goalID = 0;
    foreach ($userGoals as $goal) {
        if ($goal->getType() === "0" && $goal->getTitle() === "averageSpeed") {
            $goalID = $goal->getGoalID();
        }
    }
    editGoal($goalID, 0);
    header("Refresh:0");
}

if (isset($_POST['btnSetCycleDistanceGoal'])) {
    if (count($userGoals) === 0) {
        createGoal($_SESSION['userID'], 0, "averageDistance", $_POST['distanceGoal']);
    } else {
        $found = false;
        foreach ($userGoals as $goal) {
            if ($found == false && $goal->getType() === "0" && $goal->getTitle() === "averageDistance") {
                editGoal($goal->getGoalID(), $_POST['distanceGoal']);
                $found = true;
            }
        }
        if ($found == false) {
            createGoal($_SESSION['userID'], 0, "averageDistance", $_POST['distanceGoal']);
        }
    }
    header("Refresh:0");
}

if (isset($_POST['btnDeleteCycleDistanceGoal'])) {
    $goalID = 0;
    foreach ($userGoals as $goal) {
        if ($goal->getType() === "0" && $goal->getTitle() === "averageDistance") {
            $goalID = $goal->getGoalID();
        }
    }
    editGoal($goalID, 0);
    header("Refresh:0");
}

if (isset($_POST['btnSetCycleElevationGoal'])) {
    if (count($userGoals) === 0) {
        createGoal($_SESSION['userID'], 0, "averageElevation", $_POST['elevationGoal']);
    } else {
        $found = false;
        foreach ($userGoals as $goal) {
            if ($found == false && $goal->getType() === "0" && $goal->getTitle() === "averageElevation") {
                editGoal($goal->getGoalID(), $_POST['elevationGoal']);
                $found = true;
            }
        }
        if ($found == false) {
            createGoal($_SESSION['userID'], 0, "averageElevation", $_POST['elevationGoal']);
        }
    }
    header("Refresh:0");
}

if (isset($_POST['btnDeleteCycleElevationGoal'])) {
    $goalID = 0;
    foreach ($userGoals as $goal) {
        if ($goal->getType() === "0" && $goal->getTitle() === "averageElevation") {
            $goalID = $goal->getGoalID();
        }
    }
    editGoal($goalID, 0);
    header("Refresh:0");
}


function getCycleWorkouts($user)
{
    $cycleWorkouts = array();
    foreach ($user->getWorkouts() as $workout) {
        if (get_class($workout) == "cycle") {
            array_push($cycleWorkouts, $workout);
        }
    }
    return array_reverse($cycleWorkouts);
}


function getAverageSpeed($workouts)
{
    $speed = 0;
    foreach ($workouts as $x) {
        $speed = $speed + $x->getSpeed();
    }
    return ($speed / count($workouts)) * 3.6;
}

function getAverageDistance($workouts)
{
    $speed = 0;
    foreach ($workouts as $x) {
        $speed = $speed + $x->getDistance();
    }
    return $speed / count($workouts);
}

function getAverageElevation($workouts)
{
    $speed = 0;
    foreach ($workouts as $x) {
        $speed = $speed + $x->getElevation();
    }
    return $speed / count($workouts);
}

function averageSpeedDiff($workouts)
{
    $totalDiff = 0;
    for ($i = 0; $i < count($workouts); $i++) {
        if ($i < count($workouts) - 1) {
            $diff = ($workouts[$i]->getSpeed() - $workouts[$i + 1]->getSpeed());
            $totalDiff = $totalDiff + $diff;
        }
    }
    return ($totalDiff / count($workouts)) * 3.6;
}

function averageDistanceDiff($workouts)
{
    $totalDiff = 0;
    for ($i = 0; $i < count($workouts); $i++) {
        if ($i < count($workouts) - 1) {
            $diff = ($workouts[$i]->getDistance() - $workouts[$i + 1]->getDistance());
            $totalDiff = $totalDiff + $diff;
        }
    }
    return $totalDiff / count($workouts);
}

function averageElevationDiff($workouts)
{
    $totalDiff = 0;
    for ($i = 0; $i < count($workouts); $i++) {
        if ($i < count($workouts) - 1) {
            $diff = ($workouts[$i]->getElevation() - $workouts[$i + 1]->getElevation());
            $totalDiff = $totalDiff + $diff;
        }
    }
    return $totalDiff / count($workouts);
}

function createSpeedPrediction($userGoal, $averageSpeed, $averageDiff)
{
    $speedPrediction = array();
    foreach ($userGoal as $goal) {
        if ($goal->getType() === "0" && $goal->getTitle() === "averageSpeed") {
            $goalSpeed = $goal->getValue();
        }
    }
    if ($averageDiff > 0) {
        for ($i = $averageSpeed; $i <= $goalSpeed; $i = $i + $averageDiff) {
            array_push($speedPrediction, round($i, 2));
        }
    } elseif ($averageDiff < 0) {
        for ($i = $averageSpeed; $i >= $goalSpeed; $i = $i + $averageDiff) {

            array_push($speedPrediction, round($i, 2));
        }
    }
    return $speedPrediction;
}

function createDistancePrediction($userGoal, $averageDis, $averageDiff)
{
    $disPrediction = array();
    foreach ($userGoal as $goal) {
        if ($goal->getType() === "0" && $goal->getTitle() === "averageDistance") {
            $goalDis = $goal->getValue();
        }
    }
    if ($averageDiff > 0) {
        for ($i = $averageDis; $i <= $goalDis; $i = $i + $averageDiff) {
            array_push($disPrediction, round($i, 2));
        }
    } elseif ($averageDiff < 0) {
        for ($i = $averageDis; $i >= $goalDis; $i = $i + $averageDiff) {

            array_push($disPrediction, round($i, 2));
        }
    }
    return $disPrediction;
}

function createElevationPrediction($userGoal, $averageEle, $averageDiff)
{
    $ElePrediction = array();
    foreach ($userGoal as $goal) {
        if ($goal->getType() === "0" && $goal->getTitle() === "averageElevation") {
            $goalEle = $goal->getValue();
        }
    }
    if ($averageDiff > 0) {
        for ($i = $averageEle; $i <= $goalEle; $i = $i + $averageDiff) {
            array_push($ElePrediction, round($i, 2));
        }
    } elseif ($averageDiff < 0) {
        for ($i = $averageEle; $i >= $goalEle; $i = $i + $averageDiff) {

            array_push($ElePrediction, round($i, 2));
        }
    }
    return $ElePrediction;
}

function averageDateDiff($array)
{
    $totalDiff = 0;
    for ($i = 0; $i < count($array); $i++) {
        if ($i < count($array) - 1) {
            $origin = new DateTime($array[$i]->getDate());
            $target = new DateTime($array[$i + 1]->getDate());
            $interval = $origin->diff($target);
            $totalDiff = $totalDiff + intval($interval->format('%a'));
        }
    }
    return round($totalDiff / count($array));
}

function createDates($array, $dateDiff)
{
    $dates = array();
    $todaysDate = new DateTime();
    array_push($dates, $todaysDate->format('d/m/Y'));
    for ($i = 0; $i < count($array) - 1; $i++) {
        $todaysDate->add(new DateInterval('P' . $dateDiff . 'D'));
        array_push($dates, $todaysDate->format('d/m/Y'));
    }
    return $dates;
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cycling Goals</title>
</head>
<body>
<div class="container">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

        <h1 class="text-center mt-6">Cycling Goals</h1>
        <div class="row">
            <div class="col"></div>
            <div class="col-sm-5">
                <div class="input-group mb-3 mt-4">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="speedGoal">Speed</label>
                    </div>
                    <input class="form-control" type="number" min="0" value="<?php echo $averageCycleSpeedGoal ?>"
                           name="speedGoal">
                    <div class="input-group-append">
                        <label class="input-group-text" for="speedGoal">Km/h</label>
                        <button class="btn btn-success" name="btnSetCycleSpeedGoal" type="submit">Set</button>
                        <button class="btn btn-danger" name="btnDeleteCycleSpeedGoal" type="submit">Delete</button>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
        <?php
        echo '<p class="text-center">Your average speed for cycling is <b> ' . round($averageCycleSpeed, 1) . '</b> Km/h and ';
        $avrDiff = averageSpeedDiff($cycleWorkouts);
        if ($avrDiff > 0) {
            echo 'on average you gain <b class="text-success">' . round($avrDiff, 2) . '</b> Km/h each ride.';
        } elseif ($avrDiff < 0) {
            echo 'on average you lose <b class="text-danger">' . round($avrDiff, 2) . ' </b> Km/h each ride.';
        } elseif ($avrDiff === 0) {
            echo 'you dont make any improvement from ride to ride.';
        }

        if ($averageCycleSpeed < $averageCycleSpeedGoal && $avrDiff > 0) {
            echo ' The graph below shows you how long we predict it will take to reach your goal.</p>';
        } elseif ($averageCycleSpeed > $averageCycleSpeedGoal && $avrDiff < 0) {
            echo ' The graph below shows you how long we predict it will take to reach your goal.</p>';
        } else {
            echo ' Meaning you will be unable to reach your goal at the moment.</p>';
        }

        ?>
        <canvas id="cycleAverageSpeedChart" width="200" height=75"></canvas>

        <div class="row">
            <div class="col"></div>
            <div class="col-sm-5">
                <div class="input-group mb-3 mt-4">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="distanceGoal">Distance</label>
                    </div>
                    <input class="form-control" type="number" step="10" min="0"
                           value="<?php echo $averageCycleDistanceGoal ?>"
                           name="distanceGoal">
                    <div class="input-group-append">
                        <label class="input-group-text" for="distanceGoal">meters</label>
                        <button class="btn btn-success" name="btnSetCycleDistanceGoal" type="submit">Set</button>
                        <button class="btn btn-danger" name="btnDeleteCycleDistanceGoal" type="submit">Delete</button>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
        <?php
        echo '<p class="text-center">Your average Distance for cycling is <b> ' . round($averageCycleDistance, 1) . '</b> meters and ';
        $avrDiff = averageDistanceDiff($cycleWorkouts);
        if ($avrDiff > 0) {
            echo 'on average you gain <b class="text-success">' . round($avrDiff, 2) . '</b> meters each ride.';
        } elseif ($avrDiff < 0) {
            echo 'on average you lose <b class="text-danger">' . round($avrDiff, 2) . ' </b> meters each ride.';
        } elseif ($avrDiff === 0) {
            echo 'you dont make any improvement from ride to ride.';
        }

        if ($averageCycleDistance < $averageCycleDistanceGoal && $avrDiff > 0) {
            echo ' The graph below shows you how long we predict it will take to reach your goal.</p>';
        } elseif ($averageCycleDistance > $averageCycleDistanceGoal && $avrDiff < 0) {
            echo ' The graph below shows you how long we predict it will take to reach your goal.</p>';
        } else {
            echo ' Meaning you will be unable to reach your goal at the moment.</p>';
        }

        ?>
        <canvas id="cycleAverageDistanceChart" width="200" height=75"></canvas>


        <div class="row">
            <div class="col"></div>
            <div class="col-sm-5">
                <div class="input-group mb-3 mt-4">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="elevationGoal">Elevation</label>
                    </div>
                    <input class="form-control" type="number" step="10" min="0"
                           value="<?php echo $averageCycleElevationGoal ?>"
                           name="elevationGoal">
                    <div class="input-group-append">
                        <label class="input-group-text" for="elevationGoal">meters</label>
                        <button class="btn btn-success" name="btnSetCycleElevationGoal" type="submit">Set</button>
                        <button class="btn btn-danger" name="btnDeleteCycleElevationGoal" type="submit">Delete</button>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
        <?php
        echo '<p class="text-center">Your average Elevation for cycling is <b> ' . round($averageCycleElevation, 1) . '</b> meters and ';
        $avrDiff = averageElevationDiff($cycleWorkouts);
        if ($avrDiff > 0) {
            echo 'on average you gain <b class="text-success">' . round($avrDiff, 2) . '</b> meters each ride.';
        } elseif ($avrDiff < 0) {
            echo 'on average you lose <b class="text-danger">' . round($avrDiff, 2) . ' </b> meters each ride.';
        } elseif ($avrDiff === 0) {
            echo 'you dont make any improvement from ride to ride.';
        }

        if ($averageCycleElevation < $averageCycleElevationGoal && $avrDiff > 0) {
            echo ' The graph below shows you how long we predict it will take to reach your goal.</p>';
        } elseif ($averageCycleElevation > $averageCycleElevationGoal && $avrDiff < 0) {
            echo ' The graph below shows you how long we predict it will take to reach your goal.</p>';
        } else {
            echo ' Meaning you will be unable to reach your goal at the moment.</p>';
        }

        ?>
        <canvas id="cycleAverageElevationChart" width="200" height=75"></canvas>


    </form>
</div>
</body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>

    <?php
    $js_array = json_encode($speedPrediction);
    echo "let speedPrediction = " . $js_array . ";\n";

    $js_array = json_encode($cycleSpeedDates);
    echo "let cycleSpeedDates = " . $js_array . ";\n";

    $js_array = json_encode($distancePrediction);
    echo "let distancePrediction = " . $js_array . ";\n";

    $js_array = json_encode($cycleDistanceDates);
    echo "let cycleDistanceDates = " . $js_array . ";\n";

    $js_array = json_encode($elevationPrediction);
    echo "let elevationPrediction = " . $js_array . ";\n";

    $js_array = json_encode($cycleElevationDates);
    echo "let cycleElevationDates = " . $js_array . ";\n";



    ?>

    var ctx1 = document.getElementById('cycleAverageSpeedChart').getContext('2d');
    var myChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: cycleSpeedDates,
            datasets: [{
                label: 'Speed (km/h)',
                data: speedPrediction,
                fill: false,
                borderColor: 'navy',
                borderWidth: 2,
                showLine: false,
                pointRadius: 4
            }]
        },
        options: {}
    });

    var ctx2 = document.getElementById('cycleAverageDistanceChart').getContext('2d');
    var myChart = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: cycleDistanceDates,
            datasets: [{
                label: 'Distance (m)',
                data: distancePrediction,
                fill: false,
                borderColor: 'navy',
                borderWidth: 2,
                showLine: false,
                pointRadius: 4
            }]
        },
        options: {}
    });

    var ctx3 = document.getElementById('cycleAverageElevationChart').getContext('2d');
    var myChart = new Chart(ctx3, {
        type: 'line',
        data: {
            labels: cycleElevationDates,
            datasets: [{
                label: 'Distance (m)',
                data: elevationPrediction,
                fill: false,
                borderColor: 'navy',
                borderWidth: 2,
                showLine: false,
                pointRadius: 4
            }]
        },
        options: {}
    });
</script>