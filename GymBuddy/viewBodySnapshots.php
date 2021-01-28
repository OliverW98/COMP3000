<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';


$failureOutputPara = "";
$totalDis = $totalDurMins = $totalSpeed = $totalWatts = $totalCals = $avDis = $avDur = $avSpeed = $avWatts = $avCals = $totalCycles = 0;

if (isset($_POST['btnFindYear'])) {
    if ($_POST['selectYear'] === "Choose a Year...") {
        $failureOutputPara = "Must choose a year";
    } else {
        $user = getUserWithYear($_SESSION['userID'], $_POST['selectYear']); //Snapshots not return sorted by year
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
//            $cyclesAMonth = getCyclesAMonth($cycleWorkouts);
//            $totalDis = getTotalDistance($cycleWorkouts);
//            $totalDurMins = getTotalDuration($cycleWorkouts);
//            $avDis = getAverageDistance($cycleWorkouts);
//            $avDur = getAverageDuration($cycleWorkouts);
//            $avSpeed = getAverageSpeed($cycleWorkouts);
//            $avWatts = getAverageWatts($cycleWorkouts);
//            $avCals = getAverageCals($cycleWorkouts);
//            $totalCycles = count($cycleWorkouts);
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

//// count how many rides a month
//function getCyclesAMonth($cycleWorkouts)
//{
//    $cyclesAMonth = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
//    for ($i = 0; $i < count($cycleWorkouts); $i++) {
//        for ($j = 1; $j <= 12; $j++) {
//            if (substr($cycleWorkouts[$i]->getDate(), 5, 2) == strval($j)) {
//                $cyclesAMonth[$j - 1] = $cyclesAMonth[$j - 1] + 1;
//            }
//        }
//    }
//    return $cyclesAMonth;
//}
//
//function getTotalDistance($cycleWorkouts)
//{
//    $totalDis = 0;
//    foreach ($cycleWorkouts as $cycle) {
//        $totalDis = $totalDis + $cycle->getDistance();
//    }
//    return $totalDis;
//}
//
//function getTotalDuration($cycleWorkouts)
//{
//    $totalDur = 0;
//    foreach ($cycleWorkouts as $cycle) {
//        $totalDur = $totalDur + $cycle->getDuration();
//    }
//    return $totalDur;
//}
//
//function getAverageDistance($cycleWorkouts)
//{
//    return getTotalDistance($cycleWorkouts) / count($cycleWorkouts);
//}
//
//function getAverageDuration($cycleWorkouts)
//{
//    return getTotalDuration($cycleWorkouts) / count($cycleWorkouts);
//}
//
//function getAverageSpeed($cycleWorkouts)
//{
//    $totalSpeed = 0;
//    foreach ($cycleWorkouts as $cycle) {
//        $totalSpeed = $totalSpeed + $cycle->getSpeed();
//    }
//    return $totalSpeed / count($cycleWorkouts);
//}
//
//function getAverageWatts($cycleWorkouts)
//{
//    $totalWatts = 0;
//    foreach ($cycleWorkouts as $cycle) {
//        $totalWatts = $totalWatts + $cycle->getAverageWatts();
//    }
//    return $totalWatts / count($cycleWorkouts);
//}
//
//function getAverageCals($cycleWorkouts)
//{
//    $totalCals = 0;
//    foreach ($cycleWorkouts as $cycle) {
//        $totalCals = $totalCals + $cycle->getCaloriesBurnt();
//    }
//    return $totalCals / count($cycleWorkouts);
//}


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cycle Stats</title>
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
    <canvas id="averageSpeedChart" width="200" height=75"></canvas>
    <!--    <canvas id="distanceRiddenChart" width="200" height="75"></canvas>-->
    <!--    <canvas id="averageWattsChart" width="200" height="75"></canvas>-->
    <!--    <canvas id="RidePerMonth" width="200" height=100"></canvas>-->
    <!--    <div class="row">-->
    <!--        <div class="col-sm-6 mt-5">-->
    <!--            <h4 class="text-center">Year Total</h4>-->
    <!--            <P>Number of Rides : --><?php //echo $totalCycles ?><!--</P>-->
    <!--            <p>Distance : --><?php //echo round($totalDis / 1000, 1) ?><!-- Km</p>-->
    <!--            <P>Duration-->
    <!--                : -->
    <?php //echo $totalDurHrs = floor($totalDurMins / 60) . 'h' . ($totalDurMins - floor($totalDurMins / 60) * 60 . 'm'); ?><!--</P>-->
    <!--        </div>-->
    <!--        <div class="col-sm-6 mt-5">-->
    <!--            <h4 class="text-center">Average Ride</h4>-->
    <!--            <p>Distance : --><?php //echo round($avDis / 1000, 1) ?><!-- Km</p>-->
    <!--            <P>Duration : --><?php //echo $avDur ?><!-- Mins</P>-->
    <!--            <P>Speed : --><?php //echo round($avSpeed * 3.6, 1) ?><!-- Km/h</P>-->
    <!--            <P>Watts : --><?php //echo round($avWatts, 1) ?><!--</P>-->
    <!--            <P>Calories Burnt : --><?php //echo round($avCals) ?><!--</P>-->
    <!--        </div>-->
    <!--    </div>-->
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

    $js_array = json_encode($snapshotDates);
    echo "let snapshotDates = " . $js_array . ";\n";

    ?>



    var ctx = document.getElementById('averageSpeedChart').getContext('2d');
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

    // var ctx1 = document.getElementById('distanceRiddenChart').getContext('2d');
    // var myChart = new Chart(ctx1, {
    //     type: 'line',
    //     data: {
    //         labels: cycleDates,
    //         datasets: [{
    //             label: 'Distance Riden (Km)',
    //             data: distanceRidden,
    //             fill: false,
    //             borderColor: 'navy',
    //             borderWidth: 2
    //         }]
    //     },
    //     options: {
    //         scales: {
    //             yAxes: [{
    //                 ticks: {
    //                     beginAtZero: true
    //                 }
    //             }]
    //         }
    //     }
    // });
    //
    // var ctx2 = document.getElementById('averageWattsChart').getContext('2d');
    // var myChart = new Chart(ctx2, {
    //     type: 'line',
    //     data: {
    //         labels: cycleDates,
    //         datasets: [{
    //             label: 'Average Watts',
    //             data: averageWatts,
    //             fill: false,
    //             borderColor: 'navy',
    //             borderWidth: 2
    //         }]
    //     },
    //     options: {
    //         scales: {
    //             yAxes: [{
    //                 ticks: {
    //                     beginAtZero: true
    //                 }
    //             }]
    //         }
    //     }
    // });

    // var ctx3 = document.getElementById('RidePerMonth').getContext('2d');
    // var RidePerMonth = new Chart(ctx3, {
    //     type: 'bar',
    //     data: {
    //         labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    //         datasets: [{
    //             label: 'Rides a Month',
    //             data: cyclesAMonth,
    //             backgroundColor: 'navy',
    //             borderColor: 'navy',
    //             borderWidth: 1
    //         }]
    //     },
    //     options: {
    //         scales: {
    //             yAxes: [{
    //                 ticks: {
    //                     beginAtZero: true,
    //                     stepSize: 1
    //                 }
    //             }]
    //         }
    //     }
    // });


</script>

