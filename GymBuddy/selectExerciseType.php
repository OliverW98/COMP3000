<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$outputPara = "";
$_SESSION['muscleGroup'] = "";

if (isset($_POST['btnBack'])) {
    header("Location: createWeightsWorkoutPage.php");
}

if (isset($_POST['btnNext'])) {
    if ($_POST['selMuscleGroup'] === "Choose Muscle Group...") {
        $outputPara = "You must choose a muscle group";
    } else {
        $_SESSION['muscleGroup'] = $_POST['selMuscleGroup'];
        header("Location: createExercisePage.php");
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
    <p class="text-center mt-5">Choose A Muscle Group</p>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="nameInput">Muscle Group</label>
            </div>
            <select class="form-control" name="selMuscleGroup" type="text">
                <option>Choose Muscle Group...</option>
                <option>Chest</option>
                <option>Legs</option>
                <option>Back</option>
                <option>Arms</option>
                <option>Shoulders</option>
                <option>Core</option>
            </select>
        </div>

        <div>
            <input class="btn btn-danger" name="btnBack" type="submit" value="Back">
            <input class="btn btn-Primary float-right" name="btnNext" type="submit" value="Next">
        </div>

        <p class="text-center text-danger"><?php echo $outputPara ?></p>
    </form>
</div>

</body>
</html>