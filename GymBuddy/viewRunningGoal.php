<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$failureOutputPara = $selectExe = "";
$user = getUser($_SESSION['userID']);
$userGoals = $user->getGoals();

$averageRunSpeedGoal = $averageRunDistanceGoal = $averageRunElevationGoal = 0;
$runWorkouts = getRunWorkouts($user);

foreach ($userGoals as $goal) {
    if ($goal->getType() === "1" && $goal->getTitle() === "averageSpeed") {
        $averageRunSpeedGoal = $goal->getValue();
        $avrSpeedDiff = averageSpeedDiff($runWorkouts);
        $averageRunSpeed = getAverageSpeed($runWorkouts);
        $speedPrediction = createSpeedPrediction($userGoals, $averageRunSpeed, $avrSpeedDiff);
        $runSpeedDates = createDates($speedPrediction, averageDateDiff($runWorkouts));
    } elseif ($goal->getType() === "1" && $goal->getTitle() === "averageDistance") {
        $averageRunDistanceGoal = $goal->getValue();
        $avrDistanceDiff = averageDistanceDiff($runWorkouts);
        $averageRunDistance = getAverageDistance($runWorkouts);
        $distancePrediction = createDistancePrediction($userGoals, $averageRunDistance, $avrDistanceDiff);
        $runDistanceDates = createDates($distancePrediction, averageDateDiff($runWorkouts));
    } elseif ($goal->getType() === "1" && $goal->getTitle() === "averageElevation") {
        $averageRunElevationGoal = $goal->getValue();
        $avrElevationDiff = averageElevationDiff($runWorkouts);
        $averageRunElevation = getAverageElevation($runWorkouts);
        $elevationPrediction = createElevationPrediction($userGoals, $averageRunElevation, $avrElevationDiff);
        $runElevationDates = createDates($elevationPrediction, averageDateDiff($runWorkouts));
    }
}

if (isset($_POST['btnSetRunSpeedGoal'])) {
    if (count($userGoals) === 0) {
        createGoal($_SESSION['userID'], 1, "averageSpeed", $_POST['speedGoal']);
    } else {
        $found = false;
        foreach ($userGoals as $goal) {
            if ($found == false && $goal->getType() === "1" && $goal->getTitle() === "averageSpeed") {
                editGoal($goal->getGoalID(), $_POST['speedGoal']);
                $found = true;
            }
        }
        if ($found == false) {
            createGoal($_SESSION['userID'], 1, "averageSpeed", $_POST['speedGoal']);
        }
    }
    header("Refresh:0");
}

if (isset($_POST['btnDeleteRunSpeedGoal'])) {
    $goalID = 0;
    foreach ($userGoals as $goal) {
        if ($goal->getType() === "1" && $goal->getTitle() === "averageSpeed") {
            $goalID = $goal->getGoalID();
        }
    }
    editGoal($goalID, 0);
    header("Refresh:0");
}

if (isset($_POST['btnSetRunDistanceGoal'])) {
    if (count($userGoals) === 0) {
        createGoal($_SESSION['userID'], 1, "averageDistance", $_POST['distanceGoal']);
    } else {
        $found = false;
        foreach ($userGoals as $goal) {
            if ($found == false && $goal->getType() === "1" && $goal->getTitle() === "averageDistance") {
                editGoal($goal->getGoalID(), $_POST['distanceGoal']);
                $found = true;
            }
        }
        if ($found == false) {
            createGoal($_SESSION['userID'], 1, "averageDistance", $_POST['distanceGoal']);
        }
    }
    header("Refresh:0");
}

if (isset($_POST['btnDeleteRunDistanceGoal'])) {
    $goalID = 0;
    foreach ($userGoals as $goal) {
        if ($goal->getType() === "1" && $goal->getTitle() === "averageDistance") {
            $goalID = $goal->getGoalID();
        }
    }
    editGoal($goalID, 0);
    header("Refresh:0");
}

if (isset($_POST['btnSetRunElevationGoal'])) {
    if (count($userGoals) === 0) {
        createGoal($_SESSION['userID'], 1, "averageElevation", $_POST['elevationGoal']);
    } else {
        $found = false;
        foreach ($userGoals as $goal) {
            if ($found == false && $goal->getType() === "1" && $goal->getTitle() === "averageElevation") {
                editGoal($goal->getGoalID(), $_POST['elevationGoal']);
                $found = true;
            }
        }
        if ($found == false) {
            createGoal($_SESSION['userID'], 1, "averageElevation", $_POST['elevationGoal']);
        }
    }
    header("Refresh:0");
}

if (isset($_POST['btnDeleteRunElevationGoal'])) {
    $goalID = 0;
    foreach ($userGoals as $goal) {
        if ($goal->getType() === "1" && $goal->getTitle() === "averageElevation") {
            $goalID = $goal->getGoalID();
        }
    }
    editGoal($goalID, 0);
    header("Refresh:0");
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
        if ($goal->getType() === "1" && $goal->getTitle() === "averageSpeed") {
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
        if ($goal->getType() === "1" && $goal->getTitle() === "averageDistance") {
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
    $elePrediction = array();
    foreach ($userGoal as $goal) {
        if ($goal->getType() === "1" && $goal->getTitle() === "averageElevation") {
            $goalEle = $goal->getValue();
        }
    }
    if ($averageDiff > 0) {
        for ($i = $averageEle; $i <= $goalEle; $i = $i + $averageDiff) {
            array_push($elePrediction, round($i, 2));
        }
    } elseif ($averageDiff < 0) {
        for ($i = $averageEle; $i >= $goalEle; $i = $i + $averageDiff) {

            array_push($elePrediction, round($i, 2));
        }
    }
    return $elePrediction;
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
        <title>Running Goals</title>
    </head>
    <body>
    <div class="container">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

            <h1 class="text-center mt-6">Running Goals</h1>
            <div class="row">
                <div class="col"></div>
                <div class="col-sm-5">
                    <div class="input-group mb-3 mt-4">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="speedGoal">Speed</label>
                        </div>
                        <input class="form-control" type="number" min="0" value="<?php echo $averageRunSpeedGoal ?>"
                               name="speedGoal">
                        <div class="input-group-append">
                            <label class="input-group-text" for="speedGoal">Km/h</label>
                            <button class="btn btn-success" name="btnSetRunSpeedGoal" type="submit">Set</button>
                            <button class="btn btn-danger" name="btnDeleteRunSpeedGoal" type="submit">Delete</button>
                        </div>
                    </div>
                </div>
                <div class="col"></div>
            </div>
            <?php
            echo '<p class="text-center">Your average speed for running is <b> ' . round($averageRunSpeed, 1) . '</b> Km/h and ';
            $avrDiff = averageSpeedDiff($runWorkouts);
            if ($avrDiff > 0) {
                echo 'on average you gain <b class="text-success">' . round($avrDiff, 2) . '</b> Km/h each run.';
            } elseif ($avrDiff < 0) {
                echo 'on average you lose <b class="text-danger">' . round($avrDiff, 2) . ' </b> Km/h each run.';
            } elseif ($avrDiff === 0) {
                echo 'you dont make any improvement from run to run.';
            }

            if ($averageRunSpeed < $averageRunSpeedGoal && $avrDiff > 0) {
                echo ' The graph below shows you how long we predict it will take to reach your goal.</p>';
            } elseif ($averageRunSpeed > $averageRunSpeedGoal && $avrDiff < 0) {
                echo ' The graph below shows you how long we predict it will take to reach your goal.</p>';
            } else {
                echo ' Meaning you will be unable to reach your goal at the moment.</p>';
            }

            ?>
            <canvas id="runAverageSpeedChart" width="200" height=75"></canvas>

            <div class="row">
                <div class="col"></div>
                <div class="col-sm-5">
                    <div class="input-group mb-3 mt-4">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="distanceGoal">Distance</label>
                        </div>
                        <input class="form-control" type="number" step="10" min="0"
                               value="<?php echo $averageRunDistanceGoal ?>"
                               name="distanceGoal">
                        <div class="input-group-append">
                            <label class="input-group-text" for="distanceGoal">meters</label>
                            <button class="btn btn-success" name="btnSetRunDistanceGoal" type="submit">Set</button>
                            <button class="btn btn-danger" name="btnDeleteRunDistanceGoal" type="submit">Delete
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col"></div>
            </div>
            <?php
            echo '<p class="text-center">Your average Distance for running is <b> ' . round($averageRunDistance, 1) . '</b> meters and ';
            $avrDiff = averageDistanceDiff($runWorkouts);
            if ($avrDiff > 0) {
                echo 'on average you gain <b class="text-success">' . round($avrDiff, 2) . '</b> meters each run.';
            } elseif ($avrDiff < 0) {
                echo 'on average you lose <b class="text-danger">' . round($avrDiff, 2) . ' </b> meters each run.';
            } elseif ($avrDiff === 0) {
                echo 'you dont make any improvement from run to run.';
            }

            if ($averageRunDistance < $averageRunDistanceGoal && $avrDiff > 0) {
                echo ' The graph below shows you how long we predict it will take to reach your goal.</p>';
            } elseif ($averageRunDistance > $averageRunDistanceGoal && $avrDiff < 0) {
                echo ' The graph below shows you how long we predict it will take to reach your goal.</p>';
            } else {
                echo ' Meaning you will be unable to reach your goal at the moment.</p>';
            }

            ?>
            <canvas id="runAverageDistanceChart" width="200" height=75"></canvas>


            <div class="row">
                <div class="col"></div>
                <div class="col-sm-5">
                    <div class="input-group mb-3 mt-4">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="elevationGoal">Elevation</label>
                        </div>
                        <input class="form-control" type="number" step="10" min="0"
                               value="<?php echo $averageRunElevationGoal ?>"
                               name="elevationGoal">
                        <div class="input-group-append">
                            <label class="input-group-text" for="elevationGoal">meters</label>
                            <button class="btn btn-success" name="btnSetRunElevationGoal" type="submit">Set</button>
                            <button class="btn btn-danger" name="btnDeleteRunElevationGoal" type="submit">Delete
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col"></div>
            </div>
            <?php
            echo '<p class="text-center">Your average Elevation for running is <b> ' . round($averageRunElevation, 1) . '</b> meters and ';
            $avrDiff = averageElevationDiff($runWorkouts);
            if ($avrDiff > 0) {
                echo 'on average you gain <b class="text-success">' . round($avrDiff, 2) . '</b> meters each run.';
            } elseif ($avrDiff < 0) {
                echo 'on average you lose <b class="text-danger">' . round($avrDiff, 2) . ' </b> meters each run.';
            } elseif ($avrDiff === 0) {
                echo 'you dont make any improvement from run to run.';
            }

            if ($averageRunElevation < $averageRunElevationGoal && $avrDiff > 0) {
                echo ' The graph below shows you how long we predict it will take to reach your goal.</p>';
            } elseif ($averageRunElevation > $averageRunElevationGoal && $avrDiff < 0) {
                echo ' The graph below shows you how long we predict it will take to reach your goal.</p>';
            } else {
                echo ' Meaning you will be unable to reach your goal at the moment.</p>';
            }

            ?>
            <canvas id="runAverageElevationChart" width="200" height=75"></canvas>
        </form>
    </div>
    </body>
    </html>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script>

        <?php
        $js_array = json_encode($speedPrediction);
        echo "let speedPrediction = " . $js_array . ";\n";

        $js_array = json_encode($runSpeedDates);
        echo "let runSpeedDates = " . $js_array . ";\n";

        $js_array = json_encode($distancePrediction);
        echo "let distancePrediction = " . $js_array . ";\n";

        $js_array = json_encode($runDistanceDates);
        echo "let runDistanceDates = " . $js_array . ";\n";

        $js_array = json_encode($elevationPrediction);
        echo "let elevationPrediction = " . $js_array . ";\n";

        $js_array = json_encode($runElevationDates);
        echo "let runElevationDates = " . $js_array . ";\n";



        ?>

        var ctx1 = document.getElementById('runAverageSpeedChart').getContext('2d');
        var myChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: runSpeedDates,
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

        var ctx2 = document.getElementById('runAverageDistanceChart').getContext('2d');
        var myChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: runDistanceDates,
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

        var ctx3 = document.getElementById('runAverageElevationChart').getContext('2d');
        var myChart = new Chart(ctx3, {
            type: 'line',
            data: {
                labels: runElevationDates,
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
    </script><?php
