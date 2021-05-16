<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';


$failureOutputPara = "";
$avgActivitiesAWeek = $avgActivitiesCalsBurnt = $avgActivitiesADay = $avgCalsADay = $avgBurntCalsADay = $avgMealCals = $avgMealsADay = $snapshotCount = 0;
$lastMonthMeals = $lastMonthActivities = array();

if (isset($_POST['btnFindYear'])) {
    if ($_POST['selectYear'] === "Choose a Year...") {
        $failureOutputPara = "Must choose a year";
    } else {
        $user = getUserWithYear($_SESSION['userID'], $_POST['selectYear']);
        $snapshotCount = 0;
        //  var_dump($user);
        foreach ($user->getSnapshots() as $snapshots) {
            $snapshotCount++;
        }
        if ($snapshotCount > 0) {
            // do all the stuff
            $bodySnapshots = getBodySnapshots($user);
            $snapshotDates = getSnapshotDates($bodySnapshots);
            $snapshotWeights = getSnapshotWeights($bodySnapshots);
            $snapshotBFPs = getSnapshotBFP($bodySnapshots);
            $snapshotMMPs = getSnapshotMMP($bodySnapshots);
            $currentSnapshotWeights = getCurrentSnapshotWeights($bodySnapshots[0]);
            $avgBurntCalsADay = BMR($bodySnapshots[0], $user->getDob(), $user->getGender());

            if (count($user->getMeals()) > 0 && count($user->getWorkouts()) > 0) {
                $lastMonthMeals = getLastMonthsMeals($user->getMeals());
                $lastMonthActivities = getLastMonthsActivities($user->getWorkouts());

                if (count($lastMonthMeals) > 0) {
                    $avgMealsADay = count($lastMonthMeals) / getDaysWithData($lastMonthMeals);
                    $avgMealCals = getAverageMealsCals($lastMonthMeals);
                    $avgCalsADay = getTotalCals($lastMonthMeals) / getDaysWithData($lastMonthMeals);
                }
                if (count($lastMonthActivities) > 0) {
                    $avgActivitiesAWeek = count($lastMonthActivities) / getWeeksWithData($lastMonthActivities);
                    $avgActivitiesADay = count($lastMonthActivities) / getDaysWithData($lastMonthActivities);
                    $avgActivitiesCalsBurnt = getAverageActCalsBurnt($lastMonthActivities);
                }

            }
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

function getLastMonthsActivities($workouts)
{
    $workoutsLastMonth = array();

    $currentDate = new DateTime();
    $currentMonth = $currentDate->format("m");

    if ($currentMonth === "1") {
        $lastMonth = "12";
    } elseif ($currentMonth !== "12" || "11") {
        $lastMonth = "0" . (((int)$currentMonth) - 1);
    } else {
        $lastMonth = (string)((int)$currentMonth) - 1;
    }

    foreach ($workouts as $workout) {
        if (get_class($workout) === "run" || get_class($workout) === "cycle") {
            if (substr($workout->getDate(), 5, 2) === $lastMonth) {
                array_push($workoutsLastMonth, $workout);
            }
        }

    }

    return $workoutsLastMonth;
}

function getDaysWithData($usersArray)
{
    $Month = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

    foreach ($usersArray as $data) {
        for ($i = 1; $i <= 31; $i++) {
            $date = new DateTime($data->getDate());
            $day = $date->format("j");
            if ($day === strval($i)) {
                $Month[$i - 1] = $Month[$i - 1] + 1;
                break;
            }
        }
    }

    $daysWithData = 0;
    foreach ($Month as $day) {
        if ($day !== 0) {
            $daysWithData++;
        }
    }

    return $daysWithData;
}

function getWeeksWithData($usersArray)
{
    $weeks = array(0, 0, 0, 0);

    foreach ($usersArray as $data) {

        $date = new DateTime($data->getDate());
        $day = $date->format("j");

        if ($day >= 0 && $day <= 7) {
            $weeks[0] = $weeks[0] + 1;
        } elseif ($day >= 8 && $day <= 14) {
            $weeks[1] = $weeks[1] + 1;
        } elseif ($day >= 15 && $day <= 21) {
            $weeks[2] = $weeks[2] + 1;
        } elseif ($day >= 22 && $day <= 28) {
            $weeks[3] = $weeks[3] + 1;
        }

    }

    $weeksWithData = 0;
    foreach ($weeks as $week) {
        if ($week !== 0) {
            $weeksWithData++;
        }
    }
    return $weeksWithData;
}

function getTotalCals($meals)
{
    $totalCals = 0;

    foreach ($meals as $meal) {
        $totalCals = $totalCals + $meal->getCalorieIntake();
    }

    return $totalCals;
}

function getAverageMealsCals($meals)
{
    $totalCals = 0;

    foreach ($meals as $meal) {
        $totalCals = $totalCals + $meal->getCalorieIntake();
    }

    return $totalCals / count($meals);
}

function getAverageActCalsBurnt($activities)
{
    $totalBurnt = 0;

    foreach ($activities as $act) {
        $totalBurnt = $totalBurnt + $act->getCaloriesBurnt();
    }

    return $totalBurnt / count($activities);
}

function BMR($user, $dob, $gender)
{
    if ($gender == "Male") {
        return 66.47 + (13.75 * $user->getWeight()) + (5.003 * $user->getHeight()) - (6.755 * age($dob));
    } else {
        return 655.1 + (9.563 * $user->getWeight()) + (1.85 * $user->getHeight()) - (4.676 * age($dob));
    }
}

function age($dob)
{
    $dob = new DateTime($dob);
    $birthDate = "{$dob->format('m/d/Y')}";

    $birthDate = explode("/", $birthDate);
    //get age from date or birthdate
    $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
        ? ((date("Y") - $birthDate[2]) - 1)
        : (date("Y") - $birthDate[2]));
    return $age;
}

function pieChartMessage($bodySnapshots)
{
    echo '<p class="text-center mt-3 mb-3">The Pie chart below shows how your weight of ' . $bodySnapshots[0]->getWeight() . ' Kg is divided up.  ';
}

function predictionMessage($avgCalsADay, $avgBurntCalsADay, $avgActivitiesAWeek, $avgActivitiesCalsBurnt)
{
    echo ' <p>Your weight, height and age means your body burn a average of
                <b> ' . round(abs($avgBurntCalsADay)) . '</b>
                calories a day.</p>';

    echo '<p> Plus with the ';
    $actCals = 0;
    if ($avgActivitiesAWeek === 0) {
        echo ' no additional exercise  ';
    } elseif ($avgActivitiesAWeek > 0 && $avgActivitiesAWeek <= 3) {
        $actCals = $avgActivitiesCalsBurnt / 7;
        echo ' light exercise you perform of an average  ' . $avgActivitiesAWeek . ' activities a week this will add about <b> ' . round($avgActivitiesCalsBurnt / 7) . '</b> calories burnt a day.';
    } elseif ($avgActivitiesAWeek > 3 && $avgActivitiesAWeek <= 5) {
        $actCals = $avgActivitiesCalsBurnt / 3;
        echo ' moderate exercise you perform of an average  ' . $avgActivitiesAWeek . ' activities a week this will add about <b> ' . round($avgActivitiesCalsBurnt / 3) . '</b> calories burnt a day.';
    } elseif ($avgActivitiesAWeek > 5) {
        $actCals = $avgActivitiesCalsBurnt;
        echo ' hard exercise you perform of an average ' . $avgActivitiesAWeek . ' activities a week this will add about <b> ' . round($avgActivitiesCalsBurnt) . '</b> calories burnt a day.';
    }

    echo '<p>This means on a average day you ';
    $calsTotal = round($avgCalsADay - ($avgBurntCalsADay + $actCals));

    if ($calsTotal === 0) {
        echo " are matching you calories in and out.";
    } elseif ($calsTotal > 0) {
        echo " have a excess <b>" . $calsTotal . " </b> calories.";
    } elseif ($calsTotal < 0) {
        echo " are in a deficit of <b>" . abs($calsTotal) . "</b> calories.";
    }

    echo '</p>';
    echo '<p>A calorie differential of 500 calories a day is equivalent to a 2 kg per month change in weight.</p>';
    echo '<p>Meaning if you maintain your current calorie intake you are predicted to ';
    if ($calsTotal === 0) {
        echo " maintain the same weight ";
    } elseif ($calsTotal > 0) {
        echo " gain <b>" . round(($calsTotal / 500) * 2, 1) . "</b> Kgs ";
    } elseif ($calsTotal < 0) {
        echo " lose <b>" . round(abs(($calsTotal) / 500) * 2, 1) . "</b> Kgs ";
    }
    echo 'for the next month.</p>';
}


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Snapshots</title>
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
    if ($snapshotCount > 0) {
        pieChartMessage($bodySnapshots);
    }
    ?>
    <canvas id="CurrentBodySnapshotChart" width="200" height="75"></canvas>
    <h4 class="text-center mt-5">Past Snapshots</h4>
    <canvas id="bodySnapshotChart" width="200" height=75"></canvas>
    <div class="row">
        <div class="col-sm-6 mt-5">
            <h4 class="text-center">Meals</h4>
            <p>Meal This Month: <?php echo count($lastMonthMeals) ?></p>
            <p>Average Meals a day : <?php echo $avgMealsADay ?></p>
            <p>Average meal calories : <?php echo round($avgMealCals) ?> </p>
            <p>Average calories a day : <?php echo round($avgCalsADay) ?> </p>
            <h4 class="text-center mt-3">Activities</h4>
            <p>Activities This Month : <?php echo count($lastMonthActivities) ?></p>
            <p>Average activities a day : <?php echo $avgActivitiesADay ?></p>
            <p>Average calories burnt : <?php echo round($avgActivitiesCalsBurnt) ?> </p>

        </div>
        <div class="col-sm-6 mt-5">
            <h4 class="text-center">Prediction</h4>
            <?php
            if ($snapshotCount > 0 && count($lastMonthMeals) > 0 && count($lastMonthActivities) > 0) {
                predictionMessage($avgCalsADay, $avgBurntCalsADay, $avgActivitiesAWeek, $avgActivitiesCalsBurnt);
            } else {
                echo '<p>No Meal or Workouts are recorded last month meaning we cannot create a prediction.</p>';
            }
            ?>
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

