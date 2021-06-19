<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$user = getUser($_SESSION['userID']);
$failureOutputPara = "";

if (isset($_POST['btnShowExercise'])) {
    if ($_POST['selExercise'] === "Select an Exercise...") {
        $failureOutputPara = "Please select a Exercise.";
    }
}

if (isset($_POST['btnSetCycleGoal'])) {
    createGoal($_SESSION['userID'], 1, 'averageSpeed', $_POST['cycleGoal']);

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
        </div>
    </form>
    <p class="text-center text-danger"><?php echo $failureOutputPara ?></p>

    <div class="row">
        <div class="col"></div>
        <div class="col-sm-5">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="cycleGoal">Speed</label>
                </div>
                <input type="number" min="0" name="cycleGoal">
                <div class="input-group-append">
                    <button class="btn btn-success" name="btnSetCycleGoal" type="submit">Set</button>
                    <button class="btn btn-danger" name="btnDeleteCycleGoa" type="submit">Delete</button>
                </div>
            </div>
        </div>
        <div class="col"></div>
    </div>
    <canvas id="exerciseWeightChart" width="200" height=75"></canvas>

    <div class="row">
        <div class="col"></div>
        <div class="col-sm-5">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Options</label>
                </div>
                <input type="number" name="cycleGoal">
                <div class="input-group-append">
                    <button class="btn btn-warning" name="btnEditExercises" type="submit">Edit</button>
                    <button class="btn btn-danger" name="btnDeleteExercises" type="submit">Delete</button>
                </div>
            </div>
        </div>
        <div class="col"></div>
    </div>
    <canvas id="exerciseWeight" width="200" height=75"></canvas>

    <div class="row">
        <div class="col"></div>
        <div class="col-sm-5">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Options</label>
                </div>
                <input type="number" name="cycleGoal">
                <div class="input-group-append">
                    <button class="btn btn-warning" name="btnEditExercises" type="submit">Edit</button>
                    <button class="btn btn-danger" name="btnDeleteExercises" type="submit">Delete</button>
                </div>
            </div>
        </div>
        <div class="col"></div>
    </div>
    <canvas id="exercise" width="200" height=75"></canvas>
</div>
</body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
    var ctx = document.getElementById('exerciseWeightChart').getContext('2d');
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
    var ctx = document.getElementById('exerciseWeight').getContext('2d');
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