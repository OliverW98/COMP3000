<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$outputPara = "";

if (isset($_POST['btnCancel'])) {
    header("Location: home.php");
}

if (!isset($_SESSION['titleInput'])) {
    $_SESSION['titleInput'] = "";
    $_SESSION['dateInput'] = "";
    $_SESSION['durationInput'] = "";
    $_SESSION['notesInput'] = "";
}

if (isset($_POST['btnAddExercise'])) {
    if (!isset($_SESSION['tempExerciseArray'])) {
        $_SESSION['tempExerciseArray'] = array();
    }
    $_SESSION['titleInput'] = $_POST['titleInput'];
    $_SESSION['dateInput'] = $_POST['dateInput'];
    $_SESSION['durationInput'] = $_POST['durationInput'];
    $_SESSION['notesInput'] = $_POST['notesInput'];
    header("Location: createExercisePage.php");
}

if (isset($_POST['btnCreateWorkout'])) {

    $today = new DateTime();
    $workoutDate = new DateTime($_POST['dateInput']);

    if (empty($_POST['titleInput']) || empty($_POST['dateInput']) || empty($_POST['durationInput'])) {
        $outputPara = "Required fields must be filled to record a workout";
    } elseif (!isset($_SESSION['tempExerciseArray'])) {
        $outputPara = "Workout must contain atleast one exercise";
    } elseif ($today < $workoutDate) {
        $outputPara = "Can't record a workout in the future";
    } else {
        $type = "2";
        $distance = 0;
        $elevation = 0;
        createWorkout($_SESSION['userID'], $type, $_POST['titleInput'], $_POST['dateInput'], $_POST['durationInput'], $distance, $elevation, $_POST['notesInput']);
        $workoutID = getWorkoutID($_POST['dateInput']);
        $exercises = $_SESSION['tempExerciseArray'];
        foreach ($exercises as $ex) {
            createExercise($workoutID, $ex->getName(), $ex->getSets(), $ex->getReps(), $ex->getWeight());
        }
        unset($_SESSION['tempExerciseArray']);
        header("Location: home.php");
    }
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Weights Workout</title>
</head>
<body>
<div class="container">
    <p class="text-center">Enter Details about your weights session</p>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="titleInput">Title<span
                            style="color: red">*</span></label>
            </div>
            <input class="form-control" name="titleInput" value="<?php echo $_SESSION['titleInput'] ?>" type="text">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="dateInput">Date<span
                            style="color: red">*</span></label>
            </div>
            <input class="form-control" name="dateInput" value="<?php echo $_SESSION['dateInput'] ?>"
                   type="datetime-local">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="durationInput">Duration<span
                            style="color: red">*</span></label>
            </div>
            <input class="form-control" name="durationInput" value="<?php echo $_SESSION['durationInput'] ?>"
                   type="number">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" min="0" for="durationInput">Mins</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="notesInput">Notes</label>
            </div>
            <textarea class="form-control" name="notesInput" maxlength="300"
                      style="resize: none;height: 90px;"><?php echo $_SESSION['notesInput'] ?></textarea>
        </div>

        <div>
            <table class="table" id="exerciseTable">
                <thead class="thead-dark mt-3">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Exercise</th>
                    <th scope="col">Sets</th>
                    <th scope="col">Reps</th>
                    <th scope="col">Weight (kg)</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (isset($_SESSION['tempExerciseArray'])) {
                    $exercises = $_SESSION['tempExerciseArray'];
                    for ($i = 0; $i < count($exercises); $i++) {
                        echo '<tr>';
                        echo '<th scope="row">' . ($i + 1) . '</th>';
                        echo '<td>' . $exercises[$i]->getName() . '</td>';
                        echo '<td>' . $exercises[$i]->getSets() . '</td>';
                        echo '<td>' . $exercises[$i]->getReps() . '</td>';
                        echo '<td>' . $exercises[$i]->getWeight() . '</td>';
                        echo '</tr>';
                    }
                }
                ?>
                </tbody>
            </table>

        </div>

        <div>
            <input class="btn btn-danger" name="btnCancel" type="submit" value="Cancel">
            <div class="btn-group float-right">
                <input class="btn btn-primary" name="btnAddExercise" type="submit" value="Add Exercise">
                <input class="btn btn-success" name="btnCreateWorkout" type="submit" value="Record Workout">
            </div>
        </div>

        <p class="text-center text-danger"><?php echo $outputPara ?></p>
    </form>
</div>

</body>
</html>
