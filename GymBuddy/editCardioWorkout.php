<?php
include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$failureOutputPara = "";
$workout = $_SESSION['workoutToEdit'];


$datetime = new DateTime($workout->getDate());
$date = "{$datetime->format('Y-m-d')}T{$datetime->format('H:i')}";

if (isset($_POST['btnCancel'])) {
    unset($_SESSION['workoutToEdit']);
    header("Location: index.php");
}

if (isset($_POST['btnEditWorkout'])) {

    $today = new DateTime();
    $workoutDate = new DateTime($_POST['dateInput']);

    if (empty($_POST['titleInput']) || empty($_POST['dateInput']) || empty($_POST['durationInput']) ||
        empty($_POST['distanceInput']) || empty($_POST['elevationInput']) || empty($_POST['notesInput'])) {
        $failureOutputPara = "Fields must be filled to edit a workout";
    } elseif ($today < $workoutDate) {
        $failureOutputPara = "Can't record a workout in the future";
    } else {
        //editCardioWorkout($workout->getWorkoutID(), $_POST['titleInput'], $_POST['dateInput'], $_POST['durationInput'], $_POST['distanceInput'], $_POST['elevationInput'], $_POST['notesInput']);
        $failureOutputPara = "edited lol";
        // header("Location: index.php");
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Cardio Workout</title>
</head>
<body>
<div class="container">
    <p class="text-center">Enter Details about your cardio</p>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="titleInput">Title</label>
            </div>
            <input class="form-control" name="titleInput" value="<?php echo $workout->getTitle() ?>" type="text">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="dateInput">Date</label>
            </div>
            <input class="form-control" name="dateInput" value="<?php echo $date ?>" type="datetime-local">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="durationInput">Duration</label>
            </div>
            <input class="form-control" name="durationInput" value="<?php echo $workout->getDuration() ?>"
                   type="number">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" min="0" for="durationInput">Mins</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="distanceInput">Distance</label>
            </div>
            <input class="form-control" name="distanceInput" min="0" value="<?php echo $workout->getDistance() ?>"
                   type="number">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="distanceInput">M</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="elevationInput">Elevation</label>
            </div>
            <input class="form-control" name="elevationInput" min="0" value="<?php echo $workout->getElevation() ?>"
                   type="number">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="elevationInput">M</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="notesInput">Notes</label>
            </div>
            <textarea class="form-control" name="notesInput" value="<?php echo $workout->getNotes() ?>" maxlength="300"
                      style="resize: none;height: 90px;"></textarea>
        </div>

        <div>
            <input class="btn btn-primary float-right" name="btnCancel" type="submit" value="Record Workout">
            <input class="btn btn-warning float-right" name="btnEditWorkout" type="submit" value="Record Workout">
        </div>

        <p class="text-center text-danger"><?php echo $failureOutputPara ?></p>
    </form>
</div>

</body>
</html>