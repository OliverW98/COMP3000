<?php
include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$workout = $_SESSION['workoutToEdit'];
$exercises = $workout->getExercises();
$failureOutputPara = "";

$datetime = new DateTime($workout->getDate());
$date = "{$datetime->format('Y-m-d')}T{$datetime->format('H:i')}";

if (isset($_POST['btnCancel'])) {
    unset($_SESSION['workoutToEdit']);
    header("Location: index.php");
}

if (isset($_POST['btnAddExercises'])) {
    header("Location: editExercisesPage.php");
    $_SESSION['boolAddExercise'] = true;
}

if (isset($_POST['btnEditExercises'])) {
    if ($_POST['selectExercise'] == "Choose Exercise...") {
        $failureOutputPara = "Must chose a exercise to Edit";
    } else {
        $_SESSION['exerciseToEdit'] = $_POST['selectExercise'];
        header("Location: editExercisesPage.php");
        $_SESSION['boolAddExercise'] = false;
    }

}

if (isset($_POST['btnDeleteExercises'])) {
    if (count($exercises) <= 0) {
        $failureOutputPara = "There are no exercise to Delete";
    } elseif ($_POST['selectExercise'] == "Choose Exercise...") {
        $failureOutputPara = "Must chose a exercise to Delete";
    } else {
        $tempArray = array();
        for ($i = 0; $i < count($exercises); $i++) {
            if ($exercises[$i]->getName() != $_POST['selectExercise']) {
                array_push($tempArray, $exercises[$i]);
            } else {
                deleteExercise($exercises[$i]->getExerciseID());
            }
        }
        $workout->setExercises($tempArray);
        header("Refresh:0");
    }

}

if (isset($_POST['btnEditWorkout'])) {
    $today = new DateTime();
    $workoutDate = new DateTime($_POST['dateInput']);

    if (empty($_POST['titleInput']) || empty($_POST['dateInput']) || empty($_POST['durationInput'])) {
        $failureOutputPara = "Required fields must be filled to edit a workout";
    } elseif ($today < $workoutDate) {
        $failureOutputPara = "Workout cannot occur in the future";
    } elseif (count($exercises) === 0) {
        $failureOutputPara = "Workout must contain atleast one exercise";
    } else {
        editWorkout($workout->getWorkoutID(), $_POST['titleInput'], $_POST['dateInput'], $_POST['durationInput'], 0, 0, $_POST['notesInput']);
        header("Location: index.php");
    }
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Weights Workout</title>
</head>
<body>
<div class="container">
    <p class="text-center mt-5">Edit Details about your weights session</p>
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
            <input class="form-control" name="dateInput" value="<?php echo $date ?>"
                   type="datetime-local">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="durationInput">Duration<span
                            style="color: red">*</span></label>
            </div>
            <input class="form-control" name="durationInput" value="<?php echo $workout->getDuration() ?>"
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
                      style="resize: none;height: 90px;"><?php echo $workout->getNotes() ?></textarea>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <button class="btn btn-success" name="btnAddExercises" type="submit">Add</button>
            </div>
            <select class="custom-select" name="selectExercise">
                <option>Choose Exercise...</option>
                <?php foreach ($exercises as $ex) {
                    echo '<option>' . $ex->getName() . '</option>';
                }
                ?>
            </select>
            <div class="input-group-append">
                <button class="btn btn-warning" name="btnEditExercises" type="submit">Edit</button>
                <button class="btn btn-danger" name="btnDeleteExercises" type="submit">Delete</button>
            </div>
        </div>
        <p class="text-center">A workout must contain atleast one exercise</p>
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
                for ($i = 0; $i < count($exercises); $i++) {
                    echo '<tr>';
                    echo '<th scope="row">' . ($i + 1) . '</th>';
                    echo '<td>' . $exercises[$i]->getName() . '</td>';
                    echo '<td>' . $exercises[$i]->getSets() . '</td>';
                    echo '<td>' . $exercises[$i]->getReps() . '</td>';
                    echo '<td>' . $exercises[$i]->getWeight() . '</td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>

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