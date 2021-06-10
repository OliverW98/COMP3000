<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$failureOutputPara = "";

if (isset($_POST['btnShowExercise'])) {
    if ($_POST['selExercise'] === "Select an Exercise...") {
        $failureOutputPara = "Please select a Exercise.";
    } else {
        $currentDate = new DateTime();
        $user = getUser($_SESSION['userID'], $currentDate->format("Y"));
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
                        <option>Squat</option>
                        <option>Deadlift</option>
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
