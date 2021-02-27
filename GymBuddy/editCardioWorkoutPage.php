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
        empty($_POST['distanceInput'])) {
        $failureOutputPara = "Required fields must be filled to edit a workout";
    } elseif ($today < $workoutDate) {
        $failureOutputPara = "Workout cannot occur in the future";
    } else {
        $elevation = "";
        if ($_POST['elevationInput'] === "") {
            $elevation = "0";
        } else {
            $elevation = $_POST['elevationInput'];
        }
        editWorkout($workout->getWorkoutID(), $_POST['titleInput'], $_POST['dateInput'], $_POST['durationInput'], $_POST['distanceInput'], $elevation, $_POST['notesInput']);
        header("Location: index.php");
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Cardio Workout</title>
</head>
<body>
<div class="container">
    <p class="text-center mt-5">Edit details about your workout</p>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="titleInput">Title<span
                            style="color: red">*</span></label>
            </div>
            <input class="form-control" name="titleInput" value="<?php echo $workout->getTitle() ?>" type="text">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="dateInput">Date<span
                            style="color: red">*</span></label>
            </div>
            <input class="form-control" name="dateInput" value="<?php echo $date ?>" type="datetime-local">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="durationInput">Duration<span
                            style="color: red">*</span></label>
            </div>
            <input class="form-control" name="durationInput" min="0" value="<?php echo $workout->getDuration() ?>"
                   type="number">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="durationInput">Mins</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="distanceInput">Distance<span
                            style="color: red">*</span></label>
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
            <textarea class="form-control" name="notesInput" maxlength="300"
                      style="resize: none;height: 90px;"><?php echo $workout->getNotes() ?></textarea>
        </div>

        <div>
            <input class="btn btn-danger" name="btnCancel" type="submit" value="Cancel">
            <input class="btn btn-warning float-right" name="btnEditWorkout" type="submit" value="Edit Workout">
        </div>

        <p class="text-center text-danger"><?php echo $failureOutputPara ?></p>
    </form>
</div>

</body>
</html>