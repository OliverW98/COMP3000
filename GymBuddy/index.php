<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$workoutIDArray = $mealIDArray = array();
$ButtonID = "";


if (isset($_SESSION['userID'])) {
    $user = getUser($_SESSION['userID']);
    $usersMeals = $user->getMeals();
    $usersWorkouts = $user->getWorkouts();
    foreach ($usersMeals as $meal) {
        array_push($mealIDArray, $meal->getMealID());
    }
    foreach ($usersWorkouts as $workout) {
        array_push($workoutIDArray, $workout->getWorkoutID());
    }
}

$i = $j = 0;
//Checks which Workouts Delete or Edit button has been pressed
while ($i < count($workoutIDArray) && empty($ButtonID)) {
    if (isset($_POST['btnDeleteWorkout' . $workoutIDArray[$i]])) {

        $ButtonID = $workoutIDArray[$i];

        foreach ($usersWorkouts as $workout) {
            if ($workout->getWorkoutID() == $ButtonID) {
                $_SESSION['activityToDelete'] = $workout;
            }
        }
        header("Location: deleteWorkoutMealConfirmPage.php");
    }
    if (isset($_POST['btnEditWorkout' . $workoutIDArray[$i]])) {

        $ButtonID = $workoutIDArray[$i];

        foreach ($usersWorkouts as $workout) {
            if ($workout->getWorkoutID() == $ButtonID) {
                $_SESSION['workoutToEdit'] = $workout;

                if (get_class($workout) == "run" || get_class($workout) == "cycle") {
                    header("Location: editCardioWorkoutPage.php");
                } elseif (get_class($workout) == "weights") {
                    header("Location: editWeightsWorkoutPage.php");
                }
            }
        }

    }
    $i++;
}
//Checks which Meals Delete or Edit button has been pressed
while ($j < count($mealIDArray) && empty($ButtonID)) {
    if (isset($_POST['btnDeleteMeal' . $mealIDArray[$j]])) {

        $ButtonID = $mealIDArray[$j];

        foreach ($usersMeals as $meal) {
            if ($meal->getMealID() == $ButtonID) {
                $_SESSION['activityToDelete'] = $meal;
            }
        }

        header("Location: deleteWorkoutMealConfirmPage.php");
    }
    if (isset($_POST['btnEditMeal' . $mealIDArray[$j]])) {

        $ButtonID = $mealIDArray[$j];

        foreach ($usersMeals as $meal) {
            if ($meal->getMealID() == $ButtonID) {
                $_SESSION['mealToEdit'] = $meal;
            }
        }

        header("Location: editMealPage.php");
    }

    $j++;
}


function displayMeal($meal)
{
    $datetime = new DateTime($meal->getDate());
    $date = "{$datetime->format('d/m/y')} at {$datetime->format('H:i')}";
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    if ($meal->getImageName() != "") {
        echo '<img src="../Images/' . $meal->getImageName() . '" class="card-img-top" alt="...">';
    }
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . $meal->getTitle() . '</h5>';
    echo '<p class="card-text">' . $meal->getNotes() . '</p>';
    echo '</div>';
    echo '<ul class="list-group list-group-flush">';
    echo '<li class="list-group-item">' . $date . '</li>';
    echo '<li class="list-group-item">' . $meal->getCalorieIntake() . ' Cals</li>';
    echo '</ul>';
    echo '<div class="card-body">';
    echo '<input class="btn btn-danger" name="btnDeleteMeal' . $meal->getMealID() . '" type="submit" value="Delete">';
    echo '<input class="btn btn-primary float-right" name="btnEditMeal' . $meal->getMealID() . '" type="submit" value="Edit">';
    echo '</div>';
    echo '</div>';
}


function displayWorkout($workout)
{
    $datetime = new DateTime($workout->getDate());
    $date = "{$datetime->format('d/m/y')} at {$datetime->format('H:i')}";
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    if ($workout->getImageName() != "") {
        echo '<img src="../Images/' . $workout->getImageName() . '" class="card-img-top" alt="...">';
    }
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . $workout->getTitle() . '</h5>';
    echo '<p class="card-text">' . $workout->getNotes() . '</p>';
    echo '</div>';
    echo '<ul class="list-group list-group-flush">';
    echo '<li class="list-group-item">' . $date . '</li>';
    $totalDurMins = $workout->getDuration();
    if ($totalDurMins >= 60) {
        $totalDurHrs = floor($totalDurMins / 60) . 'h ' . ($totalDurMins - floor($totalDurMins / 60) * 60 . 'm');
        $timeToDisplay = $totalDurHrs;
    } else {
        $timeToDisplay = $totalDurMins . ' Minutes';
    }


    echo '<li class="list-group-item">Duration : ' . $timeToDisplay . '</li>';
    if (get_class($workout) == "run" || get_class($workout) == "cycle") {
        echo '<li class="list-group-item">Speed : ' . round(($workout->getSpeed() * 3.6), 1) . ' Km/h</li>';
        echo '<li class="list-group-item">Distance : ' . $workout->getDistance() . ' Meters</li>';
        echo '<li class="list-group-item">Elevation : ' . $workout->getElevation() . ' Meters</li>';
        echo '<li class="list-group-item">Calories Burnt: ' . round($workout->getCaloriesBurnt()) . ' Cals</li>';
    }
    if (get_class($workout) == "cycle") {
        echo '<li class="list-group-item">Average Watts : ' . round($workout->getAverageWatts(), 2) . ' Watts</li>';
    }
    echo '</ul>';
    if (get_class($workout) == "weights") {
        echo '<table class="table" id="exerciseTable">';
        echo '<thead class="thead-dark mt-3">';
        echo '<tr>';
        echo '<th scope="col">#</th>';
        echo '<th scope="col">Exercise</th>';
        echo '<th scope="col">Sets</th>';
        echo '<th scope="col">Reps</th>';
        echo '<th scope="col">Weight (kg)</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        $exercises = $workout->getExercises();
        for ($i = 0; $i < count($exercises); $i++) {
            echo '<tr>';
            echo '<th scope="row">' . ($i + 1) . '</th>';
            echo '<td>' . $exercises[$i]->getName() . '</td>';
            echo '<td>' . $exercises[$i]->getSets() . '</td>';
            echo '<td>' . $exercises[$i]->getReps() . '</td>';
            echo '<td>' . $exercises[$i]->getWeight() . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }
    echo '<div class="card-body">';
    echo '<input class="btn btn-danger" name="btnDeleteWorkout' . $workout->getWorkoutID() . '" type="submit" value="Delete">';
    echo '<input class="btn btn-primary float-right" name="btnEditWorkout' . $workout->getWorkoutID() . '" type="submit" value="Edit">';
    echo '</div>';
    echo '</div>';
}


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Page</title>
</head>
<body>
<div class="container">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="row">
            <div class="col-sm-6">
                <p class="text-center mt-3" style="font-size: 40px">Workouts</p>
                <!--            php for each workout row: render card -> function renderCard($workout) { return <div> $workout_title</div>}  -->

                <?php
                if (isset($_SESSION['userID'])) {
                    if (count($usersWorkouts) <= 0) {
                        echo '<p class="text-center">User does not have any workouts recorded</p>';
                    } else {
                        foreach ($usersWorkouts as $workout) {
                            displayWorkout($workout);
                        }
                    }
                } else {
                    echo '<p class="text-center">Please Log In to see your workouts</p>';
                }
                ?>
            </div>
            <div class="col-sm-6">
                <p class="text-center mt-3" style="font-size: 40px">Meals</p>
                <?php
                if (isset($_SESSION['userID'])) {
                    if (count($usersMeals) <= 0) {
                        echo '<p class="text-center">User does not have any meals recorded</p>';
                    } else {
                        foreach ($usersMeals as $meal) {
                            displayMeal($meal);
                        }
                    }
                } else {
                    echo '<p class="text-center">Please Log In to see your meals</p>';
                }
                ?>
            </div>
        </div>
    </form>
</div>
</body>
</html>