<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$user = getUser($_SESSION['userID']);
$userGoals = $user->getGoals();

$failureOutputPara = "";
$averageSpeedGoal = 0;

var_dump($user->getGoals());

foreach ($userGoals as $goal) {
    if ($goal->getType() === "0") {
        $averageSpeedGoal = $goal->getValue();
    }
}

if (isset($_POST['btnSetCycleGoal'])) {

    if (count($userGoals) === 0) {
        createGoal($_SESSION['userID'], 0, "averageSpeed", $_POST['cycleGoal']);
    } else {
        foreach ($userGoals as $goal) {
            var_dump("pog");
            if ($goal->getType() === "0") {
                editGoal($goal->getGoalID(), $_POST['cycleGoal']);
            } else {
                createGoal($_SESSION['userID'], 0, "averageSpeed", $_POST['cycleGoal']);
            }
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


        <p class="text-center text-danger"><?php echo $failureOutputPara ?></p>

        <div class="row">
            <div class="col"></div>
            <div class="col-sm-5">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="cycleGoal">Speed</label>
                    </div>
                    <input class="form-control" type="number" min="0" value="<?php echo $averageSpeedGoal ?>"
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
        <canvas id="cycleAverageSpeedChart" width="200" height=75"></canvas>

        <div class="row">
            <div class="col"></div>
            <div class="col-sm-5">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                    </div>
                    <input type="number" name="789789">
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
    var ctx = document.getElementById('cycleAverageSpeedChart').getContext('2d');
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