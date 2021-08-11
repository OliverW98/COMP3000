<?php
include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$successOutputPara = $failureOutputPara = "";


if (isset($_POST['btnCancel'])) {
    header("Location: index.php");
}

if (isset($_POST['btnCreateMeal'])) {

    $today = new DateTime();
    $mealDate = new DateTime($_POST['dateInput']);

    $file = $_FILES['mealImage'];
    $filename = $_FILES['mealImage']['name'];
    $fileTmpName = $_FILES['mealImage']['tmp_name'];
    $fileSize = $_FILES['mealImage']['size'];
    $fileError = $_FILES['mealImage']['error'];
    $fileType = $_FILES['mealImage']['type'];

    $fileExt = explode('.', $filename);
    $fileActualExt = strtolower(end($fileExt));

    $allowedFiles = array('jpg', 'jpeg', 'png');

    if (empty($_POST['titleInput']) || empty($_POST['dateInput']) || empty($_POST['caloriesInput'])) {
        $failureOutputPara = "Required fields must be filled to record a meal";
    } elseif ($_POST['caloriesInput'] <= 0) {
        $failureOutputPara = "Calories cannot be negative";
    } elseif ($today < $mealDate) {
        $failureOutputPara = "Can't record a meal in the future";
    } elseif ($filename != "") {
        if (!in_array($fileActualExt, $allowedFiles)) {
            $failureOutputPara = "Can't upload file of this type.";
        } elseif ($fileError === 1) {
            $failureOutputPara = "There was an error whilst uploading your image.";
        } elseif ($fileSize > 25000) {
            $failureOutputPara = "Your image size is too big.";
        } else {
            $fileNewName = uniqid('', true) . "." . $fileActualExt;
            $fileDestination = '../Images/' . $fileNewName;
            move_uploaded_file($fileTmpName, $fileDestination);

            createMeal($_SESSION['userID'], $_POST['titleInput'], $_POST['dateInput'], $_POST['caloriesInput'], $_POST['notesInput'], $fileNewName);
            $successOutputPara = "Meal has been recorded";
        }
    } else {
        createMeal($_SESSION['userID'], $_POST['titleInput'], $_POST['dateInput'], $_POST['caloriesInput'], $_POST['notesInput'], null);
        $successOutputPara = "Meal has been recorded";
    }
}


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Record Meal</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col"></div>
        <div class="col-sm-8">
            <p class="text-center mt-5">Enter details about your meal</p>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

                <div class="input-group mb-3 mt-3">
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
                        <label class="input-group-text text-light bg-dark" for="caloriesInput">Calories<span
                                    style="color: red">*</span></label>
                    </div>
                    <input class="form-control" name="caloriesInput" min="0" type="number">
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
                        <label class="input-group-text text-light bg-dark" for="mealImage">Image</label>
                    </div>
                    <input class="form-control" type="file" name="mealImage" multiple="">
                </div>

                <input class="btn btn-danger" name="btnCancel" type="submit" value="Cancel">
                <input class="btn btn-success float-right" name="btnCreateMeal" type="submit" value="Record Meal">

                <p class="text-center text-success"><?php echo $successOutputPara ?></p>
                <p class="text-center text-danger"><?php echo $failureOutputPara ?></p>

            </form>
        </div>
        <div class="col"></div>
    </div>
</div>

</body>
</html>