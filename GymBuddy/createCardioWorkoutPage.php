<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$outputPara = $successOutputPara = "";

if (isset($_POST['btnCancel'])) {
    header("Location: index.php");
}

if (isset($_POST['btnCreateWorkout'])) {

    $today = new DateTime();
    $workoutDate = new DateTime($_POST['dateInput']);

    $file = $_FILES['cardioImage'];
    $filename = $_FILES['cardioImage']['name'];
    $fileTmpName = $_FILES['cardioImage']['tmp_name'];
    $fileSize = $_FILES['cardioImage']['size'];
    $fileError = $_FILES['cardioImage']['error'];
    $fileType = $_FILES['cardioImage']['type'];

    $fileExt = explode('.', $filename);
    $fileActualExt = strtolower(end($fileExt));

    $allowedFiles = array('jpg', 'jpeg', 'png');

    if (empty($_POST['titleInput']) || empty($_POST['dateInput']) || empty($_POST['durationInput']) ||
        empty($_POST['distanceInput'])) {
        $outputPara = "Required fields must be filled to record a workout";
    } elseif ($_POST['typeInput'] === "Select a Type") {
        $outputPara = "Must select a cardio type";
    } elseif ($today < $workoutDate) {
        $outputPara = "Can't record a workout in the future";
    } elseif ($filename != "") {
        if (!in_array($fileActualExt, $allowedFiles)) {
            $failureOutputPara = "Can't upload file of this type.";
        } elseif ($fileError === 1) {
            $failureOutputPara = "There was an error whilst uploading your image.";
        } elseif ($fileSize > 10000) {
            $failureOutputPara = "Your image size is too big.";
        } else {
            $type = $elevation = "";
            if ($_POST['typeInput'] === "Run") {
                $type = "1";
            } elseif ($_POST['typeInput'] === "Cycle") {
                $type = "0";
            }
            if ($_POST['elevationInput'] === "") {
                $elevation = "0";
            } else {
                $elevation = $_POST['elevationInput'];
            }
            $fileNewName = uniqid('', true) . "." . $fileActualExt;
            $fileDestination = '../Images/' . $fileNewName;
            move_uploaded_file($fileTmpName, $fileDestination);

            createWorkout($_SESSION['userID'], $type, $_POST['titleInput'], $_POST['dateInput'], $_POST['durationInput']
                , $_POST['distanceInput'], $elevation, $_POST['notesInput'], $fileNewName);
            $successOutputPara = "Workout has been recorded";
        }
    } else {
        $type = $elevation = "";
        if ($_POST['typeInput'] === "Run") {
            $type = "1";
        } elseif ($_POST['typeInput'] === "Cycle") {
            $type = "0";
        }
        if ($_POST['elevationInput'] === "") {
            $elevation = "0";
        } else {
            $elevation = $_POST['elevationInput'];
        }
        createWorkout($_SESSION['userID'], $type, $_POST['titleInput'], $_POST['dateInput'], $_POST['durationInput']
            , $_POST['distanceInput'], $elevation, $_POST['notesInput'], null);
        $successOutputPara = "Workout has been recorded";
    }
}


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Record Cardio Workout</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col"></div>
        <div class="col-sm-8">
            <p class="text-center mt-5">Enter Details about your workout</p>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text text-light bg-dark" for="typeInput">Cardio Type<span
                                    style="color: red">*</span></label>
                    </div>
                    <select class="form-control" name="typeInput">
                        <option>Select a Type</option>
                        <option>Run</option>
                        <option>Cycle</option>
                    </select>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text text-light bg-dark" for="titleInput">Title<span
                                    style="color: red">*</span></label>
                    </div>
                    <input class="form-control" name="titleInput" type="text">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text text-light bg-dark" for="dateInput">Date<span
                                    style="color: red">*</span></label>
                    </div>
                    <input class="form-control" name="dateInput" type="datetime-local">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text text-light bg-dark" for="durationInput">Duration<span
                                    style="color: red">*</span></label>
                    </div>
                    <input class="form-control" name="durationInput" min="0" type="number">
                    <div class="input-group-append">
                        <label class="input-group-text text-light bg-dark" for="durationInput">Mins</label>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text text-light bg-dark" for="distanceInput">Distance<span
                                    style="color: red">*</span></label>
                    </div>
                    <input class="form-control" name="distanceInput" min="0" type="number">
                    <div class="input-group-append">
                        <label class="input-group-text text-light bg-dark" for="distanceInput">M</label>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text text-light bg-dark" for="elevationInput">Elevation</label>
                    </div>
                    <input class="form-control" name="elevationInput" min="0" type="number">
                    <div class="input-group-append">
                        <label class="input-group-text text-light bg-dark" for="elevationInput">M</label>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text text-light bg-dark" for="notesInput">Notes</label>
                    </div>
                    <textarea class="form-control" name="notesInput" maxlength="300"
                              style="resize: none;height: 90px;"></textarea>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text text-light bg-dark" for="cardioImage">Image</label>
                    </div>
                    <input class="form-control" type="file" name="cardioImage" multiple="">
                </div>


                <div>
                    <input class="btn btn-danger" name="btnCancel" type="submit" value="Cancel">
                    <input class="btn btn-success float-right" name="btnCreateWorkout" type="submit"
                           value="Record Workout">
                </div>

                <p class="text-center text-success"><?php echo $successOutputPara ?></p>
                <p class="text-center text-danger"><?php echo $outputPara ?></p>
            </form>
        </div>
        <div class="col"></div>
    </div>
</div>

</body>
</html>