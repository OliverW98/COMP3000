<?php
include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$usersWorkouts = $_SESSION['tempWorkoutArray'];
$workoutIDToDelete = $_SESSION['workoutIDToDelete'];

foreach ($usersWorkouts as $workout) {
    if ($workout->getWorkoutID() == $workoutIDToDelete) {
        $title = $workout->getTitle();
        $datetime = new DateTime($workout->getDate());
        $date = "{$datetime->format('Y-m-d')}T{$datetime->format('H:i')}";
    }
}

function unsetSessions()
{
    unset($_SESSION['tempWorkoutArray']);
    unset($_SESSION['workoutIDToDelete']);
}

if (isset($_POST['btnCancel'])) {
    unsetSessions();
    header("Location: index.php");
}

if (isset($_POST['btnDeleteWorkout'])) {
    deleteWorkout($workoutIDToDelete);
    unsetSessions();
    header("Location: index.php");
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Workout</title>
</head>
<body>
<div class="container">
    <p class="text-center">Are you sure you want to delete this workout?</p>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">


        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="titleInput">Title</label>
            </div>
            <input class="form-control" name="titleInput" disabled value="<?php echo $title ?>" type="text">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="dateInput">Date</label>
            </div>
            <input class="form-control" name="dateInput" disabled value="<?php echo $date ?>" type="datetime-local">
        </div>

        <div>
            <input class="btn btn-primary" name="btnCancel" type="submit" value="Cancel">
            <input class="btn btn-danger float-right" name="btnDeleteWorkout" type="submit" value="Delete Workout">
        </div>

    </form>
</div>

</body>
</html>
