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
    <div class="row">
        <div class="col"></div>
        <div class="col-sm-8">
            <p class="text-center mt-5">Enter Exercise Information</p>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text text-light bg-dark" for="nameInput">Exercise</label>
                    </div>
                    <select class="form-control" name="nameInput" type="text">
                        <?php
                        if ($_SESSION['muscleGroup'] === "Chest") {
                            echo '<option>Barbell Bench Press</option>';
                            echo '<option>Dumbbell Bench Press</option>';
                            echo '<option>Incline Bench Press</option>';
                            echo '<option>Decline Press</option>';
                            echo '<option>Machine Chest Press</option>';
                            echo '<option>Chest Fly</option>';
                        } elseif ($_SESSION['muscleGroup'] === "Legs") {
                            echo '<option>Squat</option>';
                            echo '<option>Lunges</option>';
                            echo '<option>Romanian Deadlift</option>';
                            echo '<option>Goblet Squat</option>';
                            echo '<option>Hip Thruster</option>';
                            echo '<option>Single Leg Curl</option>';
                            echo '<option>Leg Extension</option>';
                        } elseif ($_SESSION['muscleGroup'] === "Back") {
                            echo '<option>Deadlift</option>';
                            echo '<option>Row</option>';
                            echo '<option>Barbell Bent-Over Row</option>';
                            echo '<option>Dumbbell Single-arm Row</option>';
                            echo '<option>Chest-supported Dumbbell Row</option>';
                            echo '<option>Kettlebell Swings</option>';
                        } elseif ($_SESSION['muscleGroup'] === "Arms") {
                            echo '<option>Incline Bicep Curl</option>';
                            echo '<option>Concentration Curl</option>';
                            echo '<option>Twisting Dumbbell Curl</option>';
                            echo '<option>Reverse Curl Straight Bar</option>';
                            echo '<option>One Arm Tricep Extension</option>';
                            echo '<option>Skullcrusher</option>';
                            echo '<option>Close-grip Bench Press</option>';
                            echo '<option>Barbell Palms-up Wrist Curl</option>';
                            echo '<option>Barbell Palms-down Wrist Curl</option>';
                        } elseif ($_SESSION['muscleGroup'] === "Shoulders") {
                            echo '<option>Barbell Standing Press</option>';
                            echo '<option>Seated Dumbbell Press</option>';
                            echo '<option>Arnold Press</option>';
                            echo '<option>Lateral Raise</option>';
                            echo '<option>Upright Row</option>';
                            echo '<option>Kettlebell Single-Arm Press</option>';
                            echo '<option>Front Raises</option>';
                            echo '<option>Military Press</option>';
                        } elseif ($_SESSION['muscleGroup'] === "Core") {
                            echo '<option>Plank</option>';
                            echo '<option>Butterfly Sit-up</option>';
                            echo '<option>Dead Bug</option>';
                            echo '<option>Flutter kicks</option>';
                            echo '<option>Leg raise</option>';
                            echo '<option>Bird-dog</option>';
                        }
                        ?>
                    </select>
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
        <div class="col"></div>
    </div>
</div>

</body>
</html>
