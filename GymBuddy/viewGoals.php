<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$failureOutputPara = $selectExe = "";
$user = getUser($_SESSION['userID']);
$userGoals = $user->getGoals();

$averageCycleSpeedGoal = $averageRunSpeedGoal = $WeightGoal = 0;

$weightPrediction = $weightDates = array();
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
        createGoal($_SESSION['userID'], 0, "averageSpeed", $_POST['cycleGoal']);
    } else {
        $found = false;
        foreach ($userGoals as $goal) {
            if ($found == false && $goal->getType() === "0") {
                editGoal($goal->getGoalID(), $_POST['cycleGoal']);
                $found = true;
            }
        }
        if ($found == false) {
            createGoal($_SESSION['userID'], 0, "averageSpeed", $_POST['cycleGoal']);
        }
    }
    header("Refresh:0");
}

if (isset($_POST['btnDeleteCycleGoal'])) {
    $goalID = 0;
    foreach ($userGoals as $goal) {
        if ($goal->getType() === "0") {
            $goalID = $goal->getGoalID();
        }
    }
    deleteGoal($goalID);
    header("Refresh:0");
}

if (isset($_POST['btnSetRunGoal'])) {
    if (count($userGoals) === 0) {
        createGoal($_SESSION['userID'], 1, "averageSpeed", $_POST['runGoal']);
    } else {
        $found = false;
        foreach ($userGoals as $goal) {
            if ($found == false && $goal->getType() === "1") {
                editGoal($goal->getGoalID(), $_POST['runGoal']);
                $found = true;
            }
        }
        if ($found == false) {
            createGoal($_SESSION['userID'], 1, "averageSpeed", $_POST['runGoal']);
        }
    }
    header("Refresh:0");
}

if (isset($_POST['btnDeleteRunGoal'])) {
    $goalID = 0;
    foreach ($userGoals as $goal) {
        if ($goal->getType() === "1") {
            $goalID = $goal->getGoalID();
        }
    }
    deleteGoal($goalID);
    header("Refresh:0");
}

if (isset($_POST['btnSetWeightGoal'])) {

    if ($_POST['selExercise'] === "Select an Exercise...") {
        $failureOutputPara = "Please Select an Exercise";
    } else {
        if (count($userGoals) === 0) {
            createGoal($_SESSION['userID'], 2, $_POST['selExercise'], $_POST['weightGoal']);
        } else {
            $found = false;
            foreach ($userGoals as $goal) {
                if ($found == false && $goal->getType() === "2" && $_POST['selExercise'] === $goal->getTitle()) {
                    editGoal($goal->getGoalID(), $_POST['weightGoal']);
                    $found = true;
                }
            }
            if ($found == false) {
                createGoal($_SESSION['userID'], 2, $_POST['selExercise'], $_POST['weightGoal']);
            }
        }
        header("Refresh:0");
    }
}

if (isset($_POST['btnDeleteWeightGoal'])) {
    $goalID = 0;
    foreach ($userGoals as $goal) {
        if ($goal->getType() === "2" && $_POST['selExercise'] === $goal->getTitle()) {
            $goalID = $goal->getGoalID();
        }
    }
    deleteGoal($goalID);
    header("Refresh:0");
}

if (isset($_POST['btnShowExerciseGoal'])) {
    foreach ($userGoals as $goal) {
        if ($goal->getTitle() === $_POST['selExercise']) {
            $WeightGoal = $goal->getValue();
        }
    }
    $selectExe = $_POST['selExercise'];
    $weightWorkouts = getWeightWorkouts($user);
    $exerciseArray = getExercise($weightWorkouts, $_POST['selExercise']);
    $workoutsWithExercises = getWeightWorkoutDates($weightWorkouts, $_POST['selExercise']);
    $averageDiff = averageWeightWorkoutDiff($exerciseArray);
    $averageWeight = getAverageWeight($exerciseArray);
    $weightPrediction = createWeightPrediction($userGoals, $averageWeight, $averageDiff, $_POST['selExercise']);
    $weightDates = createDates($weightPrediction, averageDateDiff($weightWorkouts));
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

function getWeightWorkouts($user)
{
    $weightWorkouts = array();
    foreach ($user->getWorkouts() as $workout) {
        if (get_class($workout) == "weights") {
            array_push($weightWorkouts, $workout);
        }
    }
    return $weightWorkouts;
}

function getWeightWorkoutDates($weightWorkouts, $exerciseToFind)
{
    $wokrouts = array();
    foreach ($weightWorkouts as $weights) {
        foreach ($weights->getExercises() as $ex) {
            if ($ex->getName() === $exerciseToFind) {
                array_push($wokrouts, $weights);
            }
        }
    }
    return $wokrouts;
}

function getExercise($weightWorkouts, $exerciseToFind)
{
    $exercises = array();
    foreach ($weightWorkouts as $weights) {
        foreach ($weights->getExercises() as $ex) {
            if ($ex->getName() === $exerciseToFind) {
                array_push($exercises, $ex);
            }
        }
    }
    return $exercises;
}

function getAverageSpeed($workouts)
{
    $speed = 0;
    foreach ($workouts as $x) {
        $speed = $speed + $x->getSpeed();
    }
    return ($speed / count($workouts)) * 3.6;
}

function getAverageWeight($workouts)
{
    $speed = 0;
    foreach ($workouts as $x) {
        $speed = $speed + $x->getWeight();
    }
    return $speed / count($workouts);
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

function averageWeightWorkoutDiff($workouts)
{
    $totalDiff = 0;
    for ($i = 0; $i < count($workouts); $i++) {
        if ($i < count($workouts) - 1) {
            $diff = ($workouts[$i]->getWeight() - $workouts[$i + 1]->getWeight());
            $totalDiff = $totalDiff + $diff;
        }
    }
    return $totalDiff / count($workouts);
}

function createCardioPrediction($userGoal, $averageSpeed, $averageDiff, $type)
{
    $speedPrediction = array();

    foreach ($userGoal as $goal) {
        if ($goal->getType() === strval($type)) {
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

function createWeightPrediction($userGoal, $averageSpeed, $averageDiff, $exercise)
{
    $weightPrediction = array();

    foreach ($userGoal as $goal) {
        if ($goal->getTitle() === $exercise) {
            $goalSpeed = $goal->getValue();
        }
    }
    if ($averageDiff > 0) {
        for ($i = $averageSpeed; $i <= $goalSpeed; $i = $i + $averageDiff) {
            array_push($weightPrediction, $i);
        }
    } elseif ($averageDiff < 0) {
        for ($i = $averageSpeed; $i >= $goalSpeed; $i = $i + $averageDiff) {

            array_push($weightPrediction, $i);
        }
    }

    return $weightPrediction;
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
        <h2 class="text-center mt-3">My Goals</h2>
        <p class="text-center">On this page you can set goals for average cycling and running speed plus weight lifting
            goals for exercises. Once a goal is set a predicted time
            for you to achieve this goal will be displayed.</p>

        <h4 class="text-center mt-6">Cycling</h4>
        <?php
        echo '<p class="text-center">Your average speed for cycling is <b> ' . round($averageCycleSpeed, 1) . '</b> Km/h and ';
        $avrDiff = averageWorkoutDiff($cycleWorkouts);
        if ($avrDiff > 0) {
            echo 'on average you gain <b class="text-success">' . round($avrDiff, 2) . '</b> Km/h each ride.';
        } elseif ($avrDiff < 0) {
            echo 'on average you lose <b class="text-success">' . round($avrDiff, 2) . ' </b> Km/h each ride.';
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
                        <label class="input-group-text" for="cycleGoal">Km/h</label>
                        <button class="btn btn-success" name="btnSetCycleGoal" type="submit">Set</button>
                        <button class="btn btn-danger" name="btnDeleteCycleGoal" type="submit">Delete</button>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
        <canvas id="cycleAverageSpeedChart" width="200" height=75"></canvas>


        <h4 class="text-center mt-3">Running</h4>
        <?php
        echo '<p class="text-center">Your average speed for running is <b>' . round($averageRunSpeed, 1) . '</b> Km/h and ';
        $avrDiff = averageWorkoutDiff($runWorkouts);
        if ($avrDiff > 0) {
            echo 'on average you gain <b class="text-success"> ' . round($avrDiff, 2) . '</b> Km/h each run.';
        } elseif ($avrDiff < 0) {
            echo 'on average you lose <b class="text-danger"> ' . round($avrDiff, 2) . ' </b> Km/h each run.';
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
        <div class="row">
            <div class="col"></div>
            <div class="col-sm-5">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="runGoal">Speed</label>
                    </div>
                    <input class="form-control" type="number" min="0" value="<?php echo $averageRunSpeedGoal ?>"
                           name="runGoal">
                    <div class="input-group-append">
                        <label class="input-group-text" for="runGoal">Km/h</label>
                        <button class="btn btn-success" name="btnSetRunGoal" type="submit">Set</button>
                        <button class="btn btn-danger" name="btnDeleteRunGoal" type="submit">Delete</button>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
        <canvas id="runAverageSpeedChart" width="200" height=75"></canvas>


        <h4 class="text-center mt-3">Weights</h4>
        <?php
        if (isset($averageWeight)) {
            echo '<p class="text-center">Your average weight lifted for ' . $selectExe . ' is <b>' . round($averageWeight, 1) . '</b> Kg and ';
            $avrDiff = averageWeightWorkoutDiff($exerciseArray);
            if ($avrDiff > 0) {
                echo 'on average you gain <b class="text-success"> ' . round($avrDiff, 2) . '</b> Kg each session.';
            } elseif ($avrDiff < 0) {
                echo 'on average you lose <b class="text-danger"> ' . round($avrDiff, 2) . ' </b> Kg each session.';
            } elseif ($avrDiff === 0) {
                echo 'you dont make any improvement from session to session.';
            }

            if ($averageWeight < $WeightGoal && $avrDiff > 0) {
                echo ' The graph below shows you how long we predict it will take to reach your goal.</p>';
            } elseif ($averageWeight > $WeightGoal && $avrDiff < 0) {
                echo ' The graph below shows you how long we predict it will take to reach your goal.</p>';
            } else {
                echo ' Meaning you will be unable to reach your goal at the moment.</p>';
            }
        }
        ?>
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="selExercise">Exercise</label>
                    </div>
                    <select class="form-control" name="selExercise">
                        <option>Select an Exercise...</option>
                        <option>Barbell Bench Press</option>
                        <option>Dumbbell Bench Press</option>
                        <option>Incline Bench Press</option>
                        <option>Squat</option>
                        <option>Single Leg Curl</option>
                        <option>Leg Extension</option>
                        <option>Deadlift</option>
                        <option>Row</option>
                        <option>Barbell Bent-Over Row</option>
                        <option>Dumbbell Single-arm Row</option>
                        <option>Incline Bicep Curl</option>
                        <option>Concentration Curl</option>
                        <option>One Arm Tricep Extension</option>
                        <option>Skullcrusher</option>
                        <option>Military Press</option>
                        <option>Barbell Standing Press</option>
                        <option>Seated Dumbbell Press</option>
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-success" name="btnShowExerciseGoal" type="submit">Show</button>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col-sm-5">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="weightGoal">Weight</label>
                    </div>
                    <input class="form-control" type="number" min="0" value="<?php echo $WeightGoal ?>"
                           name="weightGoal">
                    <div class="input-group-append">
                        <label class="input-group-text" for="weightGoal">Kg</label>
                        <button class="btn btn-success" name="btnSetWeightGoal" type="submit">Set</button>
                        <button class="btn btn-danger" name="btnDeleteWeightGoal" type="submit">Delete</button>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
        <p class="text-center text-danger"><?php echo $failureOutputPara ?></p>
        <canvas id="weightChart" width="200" height=75"></canvas>
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

    $js_array = json_encode($weightPrediction);
    echo "let weightPrediction = " . $js_array . ";\n";

    $js_array = json_encode($weightDates);
    echo "let weightDates = " . $js_array . ";\n";

    ?>

    var ctx1 = document.getElementById('cycleAverageSpeedChart').getContext('2d');
    var myChart = new Chart(ctx1, {
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

    var ctx2 = document.getElementById('runAverageSpeedChart').getContext('2d');
    var myChart = new Chart(ctx2, {
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

    var ctx3 = document.getElementById('weightChart').getContext('2d');
    var myChart = new Chart(ctx3, {
        type: 'line',
        data: {
            labels: weightDates,
            datasets: [{
                label: 'Weight (kg)',
                data: weightPrediction,
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