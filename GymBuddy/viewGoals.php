<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$user = getUser($_SESSION['userID']);
$userGoals = $user->getGoals();

var_dump($userGoals);
$averageCycleSpeedGoal = $averageRunSpeedGoal = 0;

foreach ($userGoals as $goal) {
    if ($goal->getType() === "0") {
        //Cycle goal functions
        $averageCycleSpeedGoal = $goal->getValue();
        $cycleWorkouts = getCycleWorkouts($user);
        $averageDiff = averageWorkoutDiff($cycleWorkouts);
        $averageCycleSpeed = getAverageSpeed($cycleWorkouts);
        $cyclePrediction = createCardioPrediction($userGoals, $averageCycleSpeed, $averageDiff, 0);
        $cycleDates = createDates($cyclePrediction, averageDateDiff($cycleWorkouts));
    } elseif ($goal->getType() === "1") {
        //Run goal functions
        $averageRunSpeedGoal = $goal->getValue();
        $runWorkouts = getRunWorkouts($user);
        $averageDiff = averageWorkoutDiff($runWorkouts);
        $averageRunSpeed = getAverageSpeed($runWorkouts);
        $runPrediction = createCardioPrediction($userGoals, $averageRunSpeed, $averageDiff, 1);
        $runDates = createDates($runPrediction, averageDateDiff($runWorkouts));
    }
}

if (isset($_POST['btnSetCycleGoal'])) {
    if (count($userGoals) === 0) {
        // createGoal($_SESSION['userID'], 0, "averageSpeed", $_POST['cycleGoal']);
        var_dump("yeet");
    } else {
        foreach ($userGoals as $goal) {
            if ($goal->getType() === "0") {
                //  editGoal($goal->getGoalID(), $_POST['cycleGoal']);
                var_dump("feet");
            } else {
                var_dump("yoot");
                // createGoal($_SESSION['userID'], 0, "averageSpeed", $_POST['cycleGoal']);
            }
        }
    }
    $averageCycleSpeedGoal = $_POST['cycleGoal'];
}

if (isset($_POST['btnDeleteCycleGoal'])) {
    $goalID = 0;
    foreach ($userGoals as $goal) {
        if ($goal->getType() === "0") {
            $goalID = $goal->getGoalID();
        }
    }
    deleteGoal($goalID);
    $averageCycleSpeedGoal = 0;
}

if (isset($_POST['btnSetRunGoal'])) {
    if (count($userGoals) === 0) {
        var_dump("yeet");
        createGoal($_SESSION['userID'], 1, "averageSpeed", $_POST['runGoal']);
    } else {
        foreach ($userGoals as $goal) {
            if ($goal->getType() === "1") {
                var_dump("feet");
                editGoal($goal->getGoalID(), $_POST['runGoal']);
            } else {
                var_dump("yoot");
                createGoal($_SESSION['userID'], 1, "averageSpeed", $_POST['runGoal']);
            }
        }
    }
    $averageRunSpeedGoal = $_POST['runGoal'];
}

if (isset($_POST['btnDeleteRunGoal'])) {
    $goalID = 0;
    foreach ($userGoals as $goal) {
        if ($goal->getType() === "1") {
            $goalID = $goal->getGoalID();
        }
    }
    deleteGoal($goalID);
    $averageRunSpeedGoal = 0;
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

function getRunWorkouts($user)
{
    $runWorkouts = array();
    foreach ($user->getWorkouts() as $workout) {
        if (get_class($workout) == "run") {
            array_push($runWorkouts, $workout);
        }
    }
    return array_reverse($runWorkouts);
}

function getAverageSpeed($workouts)
{
    $speed = 0;
    foreach ($workouts as $x) {
        $speed = $speed + $x->getSpeed();
    }
    return ($speed / count($workouts)) * 3.6;
}

function averageWorkoutDiff($workouts)
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

function createCardioPrediction($userGoal, $averageSpeed, $averageDiff, $type)
{
    $speedPrediction = array();
    $goalSpeed = 0;
    if ($averageDiff > 0) {
        foreach ($userGoal as $goal) {
            if ($goal->getType() === strval($type)) {
                $goalSpeed = $goal->getValue();
            }
        }
        for ($i = $averageSpeed; $i <= $goalSpeed; $i = $i + $averageDiff) {
            array_push($speedPrediction, round($i, 2));
        }
    }

    return $speedPrediction;
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
    <title>My Goals</title>
</head>
<body>
<div class="container">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <h4 class="text-center mt-3">Select the exercise you would like to see.</h4>

        <div class="row">
            <div class="col"></div>
            <div class="col-sm-5">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="cycleGoal">Speed</label>
                    </div>
                    <input class="form-control" type="number" min="0" value="<?php echo $averageCycleSpeedGoal ?>"
                           name="cycleGoal">
                    <div class="input-group-append">
                        <label class="input-group-text" for="cycleGoal">Km/s</label>
                        <button class="btn btn-success" name="btnSetCycleGoal" type="submit">Set</button>
                        <button class="btn btn-danger" name="btnDeleteCycleGoal" type="submit">Delete</button>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>

        <?php
        foreach ($userGoals as $goal) {
            if ($goal->getType() === "0") {
                if ($goal->getValue() > $averageCycleSpeed) {
                    echo '<canvas id="cycleAverageSpeedChart" width="200" height=75"></canvas>';
                } else {
                    echo '<p class="text-center">Goal cannot be below your average speed.</p>';
                }
            }
        }
        ?>

        <div class="row">
            <div class="col"></div>
            <div class="col-sm-5">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                    </div>
                    <input class="form-control" type="number" min="0" value="<?php echo $averageRunSpeedGoal ?>"
                           name="runGoal">
                    <div class="input-group-append">
                        <button class="btn btn-success" name="btnSetRunGoal" type="submit">Set</button>
                        <button class="btn btn-danger" name="btnDeleteRunGoal" type="submit">Delete</button>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>

        <?php
        foreach ($userGoals as $goal) {
            if ($goal->getType() === "1") {
                if ($goal->getValue() > $averageRunSpeed) {
                    echo '<canvas id="runAverageSpeedChart" width="200" height=75"></canvas>';
                } else {
                    echo '<p class="text-center">Goal cannot be below your average speed.</p>';
                }
            }
        }
        ?>

        <div class="row">
            <div class="col"></div>
            <div class="col-sm-5">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                    </div>
                    <input type="number" name="cyc789789789leGoal">
                    <div class="input-group-append">
                        <button class="btn btn-warning" name="btnEditExercises" type="submit">Edit</button>
                        <button class="btn btn-danger" name="btnDeleteExercises" type="submit">Delete</button>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
        <canvas id="exercise" width="200" height=75"></canvas>
    </form>
</div>
</body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>

    <?php
    $js_array = json_encode($cyclePrediction);
    echo "let cyclePrediction = " . $js_array . ";\n";

    $js_array = json_encode($cycleDates);
    echo "let cycleDates = " . $js_array . ";\n";

    $js_array = json_encode($runPrediction);
    echo "let runPrediction = " . $js_array . ";\n";

    $js_array = json_encode($runDates);
    echo "let runDates = " . $js_array . ";\n";

    ?>

    var ctx = document.getElementById('cycleAverageSpeedChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: cycleDates,
            datasets: [{
                label: 'Speed (km/h)',
                data: cyclePrediction,
                fill: false,
                borderColor: 'navy',
                borderWidth: 2,
                showLine: false,
                pointRadius: 4
            }]
        },
        options: {}
    });
    var ctx = document.getElementById('runAverageSpeedChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: runDates,
            datasets: [{
                label: 'Speed (km/h)',
                data: runPrediction,
                fill: false,
                borderColor: 'navy',
                borderWidth: 2,
                showLine: false,
                pointRadius: 4
            }]
        },
        options: {}
    });

    var ctx = document.getElementById('exercise').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [1, 2, 3, 4, 5, 6, 7],
            datasets: [{
                label: 'Weight (kg)',
                data: [1, 2, 3, 4, 5, 6, 7],
                fill: false,
                borderColor: 'navy',
                borderWidth: 2,
                showLine: false,
                pointRadius: 4
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
</script>