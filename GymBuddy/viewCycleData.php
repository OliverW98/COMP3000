<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';


$selectedYear = date("Y");
$user = getUserWithYear($_SESSION['userID'], $selectedYear);
$cycleWorkouts = $cycleDates = $averageSpeeds = array();
$cyclesAMonth = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);


if (isset($_POST['btnFindYear'])) {
    $selectedYear = $_POST['selectYear'];
    $user = getUserWithYear($_SESSION['userID'], $selectedYear);
    $_POST['selectYear'] = $selectedYear;
}


foreach ($user->getWorkouts() as $workout) {
    if (get_class($workout) == "cycle") {
        array_push($cycleWorkouts, $workout);
    }
}

for ($i = 0; $i < min(10, count($cycleWorkouts)); $i++) {

    array_push($averageSpeeds, round($cycleWorkouts[$i]->getSpeed() * 3.6, 1));


    $datetime = new DateTime($cycleWorkouts[$i]->getDate());
    $date = "{$datetime->format('d/m/y')}";
    array_push($cycleDates, $date);
}

for ($i = 0; $i < count($cycleWorkouts); $i++) {
    for ($j = 1; $j <= 12; $j++) {
        if (substr($cycleWorkouts[$i]->getDate(), 5, 2) == strval($j)) {
            $cyclesAMonth[$j - 1] = $cyclesAMonth[$j - 1] + 1;
        }
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cycle Data Page</title>
</head>
<body>
<div class="container">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="input-group mb-3 mt-3">
            <select id="selectYear" class="custom-select" name="selectYear">
                <option selected>Choose a Year...</option>
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
    <canvas id="RidesPastWeek" width="200" height=100"></canvas>
    <canvas id="RidePerMonth" width="200" height=100"></canvas>
</div>
</body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>


    <?php
    $js_array = json_encode($averageSpeeds);
    echo "let averageSpeeds = " . $js_array . ";\n";

    $js_array = json_encode($cycleDates);
    echo "let cycleDates = " . $js_array . ";\n";

    $js_array = json_encode($cyclesAMonth);
    echo "let chartData = " . $js_array . ";\n";
    ?>



    var ctx1 = document.getElementById('RidesPastWeek').getContext('2d');
    var myChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: cycleDates,
            datasets: [{
                label: 'Average Speed (Km/h)',
                data: averageSpeeds,
                backgroundColor: [
                    'rgba(54, 162, 235, 0)',
                    'rgba(54, 162, 235, 0)',
                    'rgba(54, 162, 235, 0)',
                    'rgba(54, 162, 235, 0)',
                    'rgba(54, 162, 235, 0)',
                    'rgba(54, 162, 235, 0)',
                    'rgba(54, 162, 235, 0)',
                    'rgba(54, 162, 235, 0)',
                    'rgba(54, 162, 235, 0)',
                    'rgba(54, 162, 235, 0)',
                    'rgba(54, 162, 235, 0)',
                    'rgba(54, 162, 235, 0)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
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
    var ctx = document.getElementById('RidePerMonth').getContext('2d');
    var RidePerMonth = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Rides a Month',
                data: chartData,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderWidth: 1
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
