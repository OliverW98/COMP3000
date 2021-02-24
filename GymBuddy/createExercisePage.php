<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$outputPara = "";

$_SESSION['count'] = 1;

if (isset($_POST['btnBack'])) {
    header("Location: createWeightsWorkoutPage.php");
}

if (isset($_POST['btnAddExercise'])) {
    if (empty($_POST['nameInput']) || empty($_POST['setsInput']) || empty($_POST['repsInput']) || empty($_POST['weightInput'])) {
        $outputPara = "All fields must be filled to add an exercise";
    } else if ($_POST['setsInput'] <= 0) {
        $outputPara = "Sets can't be negative";
    } else if ($_POST['repsInput'] <= 0) {
        $outputPara = "Reps can't be negative";
    } else if ($_POST['weightInput'] <= 0) {
        $outputPara = "Weight can't be negative";
    } else {

        $exercise = new exercise("1", $_POST['nameInput'], $_POST['setsInput'], $_POST['repsInput'], $_POST['weightInput']);
        array_push($_SESSION['tempExerciseArray'], $exercise);
        header("Location: createWeightsWorkoutPage.php");
    }
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Exercise</title>
</head>
<body>
<div class="container">
    <p class="text-center">Enter Exercise Information</p>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="nameInput">Name</label>
            </div>
            <input class="form-control" name="nameInput" type="text">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" min="0" for="setsInput">Sets</label>
            </div>
            <input class="form-control" name="setsInput" type="number">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" min="0" for="repsInput">Reps</label>
            </div>
            <input class="form-control" name="repsInput" type="number">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="weightInput">Weight</label>
            </div>
            <input class="form-control" name="weightInput" min="0" type="number">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="weightInput">Kg</label>
            </div>
        </div>

        <div>
            <input class="btn btn-danger" name="btnBack" type="submit" value="Back">
            <input class="btn btn-success float-right" name="btnAddExercise" type="submit" value="Add Exercise">
        </div>

        <p class="text-center text-danger"><?php echo $outputPara ?></p>
    </form>
</div>

</body>
</html>
