<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$failureOutputPara = "";
$count = $maxLift = $totalExercises = $avgLifted = $avgReps = 0;
if (isset($_POST['btnShowExercise'])) {
    if ($_POST['selExercise'] === "Select an Exercise...") {
        $failureOutputPara = "Please select a Exercise.";
    } else {
        $currentDate = new DateTime();
        $user = getUser($_SESSION['userID']);
        $count = 0;
        foreach ($user->getWorkouts() as $workout) {
            if (get_class($workout) == "weights") {
                $count++;
            }
        }
        if ($count > 0) {
            $weightWorkouts = getWeightWorkouts($user);
            $selectedExercises = findExercises($weightWorkouts, $_POST['selExercise']);
            if (count($selectedExercises) > 0) {
                // complete if there are exercises
                $exerciseDates = getExerciseDates($weightWorkouts, $_POST['selExercise']);
                $exerciseWeights = getExerciseWeights($selectedExercises);
                $predictionLine = getPredictionLine($selectedExercises);
                $totalExercises = count($selectedExercises);
                $maxLift = getMaxLift($selectedExercises);
                $avgLifted = getAverageLifted($selectedExercises);
                $avgReps = getAverageReps($selectedExercises);
            } else {
                $failureOutputPara = "No exercise of this type are recorded.";
            }
        } else {
            $failureOutputPara = "No weight workouts are recorded.";
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
    return array_reverse($weightWorkouts);
}

function getExerciseDates($weightWorkouts, $exerciseToFind)
{
    $Dates = array();
    foreach ($weightWorkouts as $weights) {
        foreach ($weights->getExercises() as $ex) {
            if ($ex->getName() === $exerciseToFind) {
                $datetime = new DateTime($weights->getDate());
                $date = "{$datetime->format('d/m/y')}";
                array_push($Dates, $date);
            }
        }
    }
    array_push($Dates, "Predicted Heaviest Lift");
    return $Dates;
}

function findExercises($weightWorkouts, $exerciseToFind)
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

function getExerciseWeights($selectedExercises)
{
    $weights = array();

    foreach ($selectedExercises as $ex) {
        array_push($weights, $ex->getWeight());
    }
    return $weights;
}

function getPredictionLine($selectedExercises)
{
    $weights = array();

    foreach ($selectedExercises as $ex) {
        array_push($weights, $ex->getWeight());
    }
    $heaviestLift = getNon1RepMaxLiftExercise($selectedExercises);
    $prediction = getPrediction($heaviestLift);
    array_push($weights, $prediction);
    return $weights;
}

function getPrediction($heaviestLift)
{
    $x = $heaviestLift->getReps() * 2.5;
    $y = (100 - $x) / 100;
    return round($heaviestLift->getWeight() / $y);;
}

function getMaxLift($selectedExercises)
{
    $max = 0;
    foreach ($selectedExercises as $ex) {
        if (intval($ex->getWeight()) >= $max) {

            $max = intval($ex->getWeight());
        }
    }
    return $max;
}

function getNon1RepMaxLiftExercise($selectedExercises)
{
    $exercise = $max = 0;
    foreach ($selectedExercises as $ex) {
        if (intval($ex->getWeight()) >= $max && intval($ex->getReps()) > 1) {
            $max = intval($ex->getWeight());
            $exercise = $ex;
        }
    }
    return $exercise;
}

function getAverageLifted($selectedExercises)
{
    $weightTotal = 0;
    foreach ($selectedExercises as $ex) {
        $weightTotal = $weightTotal + intval($ex->getWeight());
    }
    return $weightTotal / count($selectedExercises);
}

function getAverageReps($selectedExercises)
{
    $repsTotal = 0;
    foreach ($selectedExercises as $ex) {
        $repsTotal = $repsTotal + intval($ex->getReps());
    }
    return $repsTotal / count($selectedExercises);
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Weights Stats</title>
</head>
<body>
<div class="container">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <h4 class="text-center mt-3">Select the exercise you would like to see.</h4>
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <div class="input-group mb-3 mt-3">
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
                        <button class="btn btn-success" name="btnShowExercise" type="submit">Show</button>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </form>
    <p class="text-center text-danger"><?php echo $failureOutputPara ?></p>
    <canvas id="exerciseWeightChart" width="200" height=75"></canvas>
    <?php
    if ($count > 0) {

        echo '<p class="text-center">To create the prediction your heaviest non one rep max lift is used, as it allows for the most accurate result.</p>';

        echo '<p class="text-center"> With the ';
        $lift = getNon1RepMaxLiftExercise($selectedExercises);
        if ($lift->getReps() <= 4) {
            echo 'low amount of reps of <b>' . $lift->getReps() . '</b> ';
        } elseif ($lift->getReps() >= 5 && $lift->getReps() <= 8) {
            echo 'medium amount of reps of <b> ' . $lift->getReps() . '</b> ';
        } else {
            echo 'high amount of reps of  <b>' . $lift->getReps() . '</b> ';
        }
        echo 'and the weight of  <b>' . $lift->getWeight() . '</b> kg, ';

        echo 'your predicted one rep maximum lift for ' . $_POST['selExercise'] . ' is <b>' . getPrediction($lift) . '</b> kg </p>';
    }


    ?>

    <div class="row">
        <div class="col-sm-6 mt-5">
            <h4 class="text-center">Exercise Totals</h4>
            <p>Heaviest lift : <?php echo $maxLift ?> kg </p>
            <p>Exercise Performed : <?php echo $totalExercises ?> times</p>
        </div>
        <div class="col-sm-6 mt-5">
            <h4 class="text-center">Exercise Averages</h4>
            <p>Average Lifted : <?php echo round($avgLifted) ?> kg </p>
            <p>Average Number of Reps : <?php echo round($avgReps) ?></p>
        </div>
    </div>
</div>
</body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>

    <?php
    $js_array = json_encode($exerciseWeights);
    echo "let exerciseWeights = " . $js_array . ";\n";

    $js_array = json_encode($exerciseDates);
    echo "let exerciseDates = " . $js_array . ";\n";

    $js_array = json_encode($predictionLine);
    echo "let predictionLine = " . $js_array . ";\n";

    ?>

    var ctx = document.getElementById('exerciseWeightChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: exerciseDates,
            datasets: [{
                label: 'Weight (kg)',
                data: exerciseWeights,
                fill: false,
                borderColor: 'navy',
                borderWidth: 2,
                showLine: false,
                pointRadius: 4
            }, {
                label: '1 Rep Max',
                data: predictionLine,
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
</script>
