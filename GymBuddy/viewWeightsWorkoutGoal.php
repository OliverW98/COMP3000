<?php
include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$failureOutputPara = $selectExe = "";
$user = getUser($_SESSION['userID']);
$userGoals = $user->getGoals();

$WeightGoal = 0;
$weightPrediction = $weightDates = array();

if (isset($_POST['btnSetWeightGoal'])) {
    if ($_POST['selExercise'] === "Select an Exercise...") {
        $failureOutputPara = "Please Select an Exercise.";
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
    editGoal($goal->getGoalID(), 0);
    header("Refresh:0");
}

if (isset($_POST['btnShowExerciseGoal'])) {
    foreach ($userGoals as $goal) {
        if ($goal->getTitle() === $_POST['selExercise']) {
            $WeightGoal = $goal->getValue();
            $selectExe = $_POST['selExercise'];
            $failureOutputPara = "";
            $weightWorkouts = getWeightWorkouts($user);
            $exerciseArray = getExercise($weightWorkouts, $_POST['selExercise']);
            $workoutsWithExercises = getWeightWorkoutDates($weightWorkouts, $_POST['selExercise']);
            $averageDiff = averageWeightWorkoutDiff($exerciseArray);
            $averageWeight = getAverageWeight($exerciseArray);
            $weightPrediction = createWeightPrediction($userGoals, $averageWeight, $averageDiff, $_POST['selExercise']);
            $weightDates = createDates($weightPrediction, averageDateDiff($weightWorkouts));
            break;
        } elseif ($_POST['selExercise'] === "Select an Exercise...") {
            $failureOutputPara = "Please Select an Exercise.";
            break;
        } else {
            $failureOutputPara = "No goal set for this exercise.";
        }
    }
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


function getAverageWeight($workouts)
{
    $speed = 0;
    foreach ($workouts as $x) {
        $speed = $speed + $x->getWeight();
    }
    return $speed / count($workouts);
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
    <title>Weights Goals</title>
</head>
<body>
<div class="container">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

        <h1 class="text-center mt-6">Weights Goals</h1>

        <div class="row">
            <div class="col"></div>
            <div class="col">
                <div class="input-group mb-3 mt-4">
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
        <canvas id="weightChart" width="200" height=75"></canvas>
    </form>
</div>
</body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>

    <?php


    $js_array = json_encode($weightPrediction);
    echo "let weightPrediction = " . $js_array . ";\n";

    $js_array = json_encode($weightDates);
    echo "let weightDates = " . $js_array . ";\n";

    ?>


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