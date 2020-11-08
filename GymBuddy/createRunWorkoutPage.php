<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$outputPara = "";

if(isset($_POST['btnCreateWorkout'])){

    $today = new DateTime();
    $workoutDate = new DateTime($_POST['dateInput']);

    if(empty($_POST['titleInput'])|| empty($_POST['dateInput'])|| empty($_POST['durationInput']) ||
        empty($_POST['distanceInput']) || empty($_POST['elevationInput'])|| empty($_POST['notesInput'])){
        $outputPara = "Fields must be filled to record a workout";
    }elseif ($today < $workoutDate){
        $outputPara = "Can't record a workout in the future";
    }else{
        createRunCycleWorkout($_SESSION['userID'], "1",$_POST['titleInput'], $_POST['dateInput'], $_POST['durationInput']
            ,$_POST['distanceInput'],$_POST['elevationInput'],$_POST['notesInput']);
        header("Location: home.php");
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
    <p class="text-center">Enter Details about your run</p>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="titleInput">Title</label>
            </div>
            <input class="form-control" name="titleInput" type="text">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="dateInput">Date</label>
            </div>
            <input class="form-control" name="dateInput" type="datetime-local">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="durationInput">Duration</label>
            </div>
            <input class="form-control" name="durationInput" type="number">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" min="0" for="durationInput" >Mins</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="distanceInput">Distance</label>
            </div>
            <input class="form-control" name="distanceInput" min="0" type="number">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="distanceInput" >M</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="elevationInput">Elevation</label>
            </div>
            <input class="form-control" name="elevationInput" min="0" type="number">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="elevationInput" >M</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="notesInput">Notes</label>
            </div>
            <textarea class="form-control" name="notesInput" maxlength="300" style="resize: none;height: 90px;"></textarea>
        </div>

        <div>
            <input class="btn btn-success float-right" name="btnCreateWorkout" type="submit" value="Record Workout">
        </div>

        <p class="text-center text-danger"><?php echo $outputPara?></p>
    </form>
</div>

</body>
</html>