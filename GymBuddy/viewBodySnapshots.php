<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';


$failureOutputPara = "";
$count = 0;

if (isset($_POST['btnFindYear'])) {
    if ($_POST['selectYear'] === "Choose a Year...") {
        $failureOutputPara = "Must choose a year";
    } else {
        $user = getUserWithYear($_SESSION['userID'], $_POST['selectYear']);
        $count = 0;
        foreach ($user->getSnapshots() as $snapshots) {
            $count++;
        }
        if ($count > 0) {
            // do all the stuff
            $bodySnapshots = getBodySnapshots($user);
            $snapshotDates = getSnapshotDates($bodySnapshots);
            $snapshotWeights = getSnapshotWeights($bodySnapshots);
            $snapshotBFPs = getSnapshotBFP($bodySnapshots);
            $snapshotMMPs = getSnapshotMMP($bodySnapshots);
            $currentSnapshotWeights = getCurrentSnapshotWeights($bodySnapshots[0]);
            $lastMonthMeals = getLastMonthsMeals($user->getMeals());
        } else {
            $failureOutputPara = "No Body Snapshots recorded for " . $_POST['selectYear'];
        }
    }
}

function getBodySnapshots($user)
{
    $snapshots = array();
    foreach ($user->getSnapshots() as $snapshot) {
        array_push($snapshots, $snapshot);
    }
    return $snapshots;
}

function getSnapshotDates($bodySnapshots)
{
    $snapshotDates = array();
    for ($i = min(10, count($bodySnapshots) - 1); $i >= 0; $i--) {
        $datetime = new DateTime($bodySnapshots[$i]->getDate());
        $date = "{$datetime->format('d/m/y')}";
        array_push($snapshotDates, $date);
    }
    return $snapshotDates;
}

function getSnapshotWeights($bodySnapshots)
{
    $snapshotWeights = array();
    for ($i = min(10, count($bodySnapshots) - 1); $i >= 0; $i--) {
        array_push($snapshotWeights, $bodySnapshots[$i]->getWeight());
    }
    return $snapshotWeights;
}

function getSnapshotBFP($bodySnapshots)
{
    $snapshotBFPs = array();
    for ($i = min(10, count($bodySnapshots) - 1); $i >= 0; $i--) {
        array_push($snapshotBFPs, $bodySnapshots[$i]->getBodyFatPercent());

    }
    return $snapshotBFPs;
}

function getSnapshotMMP($bodySnapshots)
{
    $snapshotMMP = array();
    for ($i = min(10, count($bodySnapshots) - 1); $i >= 0; $i--) {
        array_push($snapshotMMP, $bodySnapshots[$i]->getMuscleMassPercent());
    }
    return $snapshotMMP;
}

function getCurrentSnapshotWeights($snapshot)
{
    $Weights = array();
    $fatWeight = round(($snapshot->getBodyFatPercent() / 100) * $snapshot->getWeight());
    $muscleWeight = round(($snapshot->getMuscleMassPercent() / 100) * $snapshot->getWeight());
    array_push($Weights, $snapshot->getWeight() - ($fatWeight + $muscleWeight));
    array_push($Weights, $fatWeight);
    array_push($Weights, $muscleWeight);
    return $Weights;
}

function getLastMonthsMeals($meals)
{
    $mealsLastmonth = array();

    $currentDate = new DateTime();
    $currentMonth = $currentDate->format("m");

    if ($currentMonth === "1") {
        $lastMonth = "12";
    } elseif ($currentMonth !== "12" || "11") {
        $lastMonth = "0" . (((int)$currentMonth) - 1);
    } else {
        $lastMonth = (string)((int)$currentMonth) - 1;
    }

    foreach ($meals as $meal) {

        if (substr($meal->getDate(), 5, 2) === $lastMonth) {
            array_push($mealsLastmonth, $meal);
        }
    }

    return $mealsLastmonth;
}

function pieChartMessage($bodySnapshots)
{
    echo '<p class="text-center mt-3 mb-3">The Pie chart below shows how your weight of ' . $bodySnapshots[0]->getWeight() . ' Kg is divided up.  ';
}


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Snapshots</title>
</head>
<body>
<div class="container">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="input-group mb-3 mt-3">
            <select id="selectYear" class="custom-select" name="selectYear">
                <option selected>Choose a Year...</option>
                <option>2021</option>
                <option>2020</option>
                <option>2019</option>
                <option>2018</option>
                <option>2017</option>
            </select>
            <div class="input-group-append">
                <button id="FindYear" class="btn btn-success" name="btnFindYear" type="submit">Find</button>
            </div>
        </div>
    </form>
    <p class="text-center text-danger"><?php echo $failureOutputPara ?></p>
    <h4 class="text-center">Current Body Composition</h4>
    <?php
    if ($count > 0) {
        pieChartMessage($bodySnapshots);
    }
    ?>
    <canvas id="CurrentBodySnapshotChart" width="200" height="75"></canvas>
    <h4 class="text-center mt-5">Past Snapshots</h4>
    <canvas id="bodySnapshotChart" width="200" height=75"></canvas>
    <div class="row">
        <div class="col-sm-6 mt-5">
            <h4 class="text-center">Total Meal</h4>
            <p>meals a month</p>
            <p>num opf activitys </p>
        </div>
        <div class="col-sm-6 mt-5">
            <h4 class="text-center">Average Meal</h4>
            <p>average meals a day : Km</p>
            <p>average meal cal</p>
            <p>average cals in a day</p>
            <p> cals to be burn in a day +/-</p>
            <p>average cals burnt </p>
        </div>
    </div>
</div>
</body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>


    <?php
    $js_array = json_encode($snapshotWeights);
    echo "let snapshotWeights = " . $js_array . ";\n";

    $js_array = json_encode($snapshotBFPs);
    echo "let snapshotBFPs = " . $js_array . ";\n";

    $js_array = json_encode($snapshotMMPs);
    echo "let snapshotMMPs = " . $js_array . ";\n";

    $js_array = json_encode($currentSnapshotWeights);
    echo "let currentSnapshot = " . $js_array . ";\n";

    $js_array = json_encode($snapshotDates);
    echo "let snapshotDates = " . $js_array . ";\n";

    ?>


    var ctx = document.getElementById('bodySnapshotChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: snapshotDates,
            datasets: [{
                label: 'Weight (Kg)',
                data: snapshotWeights,
                fill: false,
                borderColor: 'navy',
                borderWidth: 2
            }, {
                label: 'Body Fat (%)',
                data: snapshotBFPs,
                fill: false,
                borderColor: 'red',
                borderWidth: 2
            }, {
                label: 'Muscle Mass (%)',
                data: snapshotMMPs,
                fill: false,
                borderColor: 'green',
                borderWidth: 2
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


    var ctx1 = document.getElementById('CurrentBodySnapshotChart').getContext('2d');
    var myChart = new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: ["Weight (Kg)", "Body Fat (Kg)", "Muscle Mass (Kg)"],
            datasets: [{
                label: 'Weight (Kg)',
                data: currentSnapshot,
                backgroundColor: ['navy', 'red', 'green']
            }]
        },
        options: {}
    });

</script>

