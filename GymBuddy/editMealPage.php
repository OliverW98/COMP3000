<?php
include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$failureOutputPara = "";
$meal = $_SESSION['mealToEdit'];
$mealImageName = "No_Image_Available.jpg";

if ($meal->getImageName() != "") {
    $mealImageName = $meal->getImageName();
}

$datetime = new DateTime($meal->getDate());
$date = "{$datetime->format('Y-m-d')}T{$datetime->format('H:i')}";

if (isset($_POST['btnCancel'])) {
    unset($_SESSION['mealToEdit']);
    header("Location: index.php");
}

if (isset($_POST['btnDeleteImage'])) {
    editMeal($meal->getMealID(), $meal->getTitle(), $meal->getDate(), $meal->getCalorieIntake(), $meal->getNotes(), null);
    unlink('../Images/' . $meal->getImageName());
    $mealImageName = "No_Image_Available.jpg";
}

if (isset($_POST['btnEditMeal'])) {

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
        $failureOutputPara = "Required fields must be filled to edit a meal";
    } elseif ($_POST['caloriesInput'] <= 0) {
        $failureOutputPara = "Calories cannot be negative";
    } elseif ($today < $mealDate) {
        $failureOutputPara = "Meal cannot occur in the future";
    } elseif ($filename != "") {
        if (!in_array($fileActualExt, $allowedFiles)) {
            $failureOutputPara = "Can't upload file of this type.";
        } elseif ($fileError === 1) {
            $failureOutputPara = "There was an error whilst uploading your image.";
        } elseif ($fileSize > 10000) {
            $failureOutputPara = "Your image size is too big.";
        }
    } else {
        $fileNewName = "";
        if ($filename != "") {
            $fileNewName = uniqid('', true) . "." . $fileActualExt;
            $fileDestination = '../Images/' . $fileNewName;
            move_uploaded_file($fileTmpName, $fileDestination);
        }
        editMeal($meal->getMealID(), $_POST['titleInput'], $_POST['dateInput'], $_POST['caloriesInput'], $_POST['notesInput'], $fileNewName);
        header("Location: index.php");
    }
}


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Meal</title>
</head>
<body>
<div class="container">
    <p class="text-center mt-5">Edit details about your meal</p>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
        <div class="input-group mb-3 mt-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="titleInput">Title<span
                            style="color: red">*</span></label>
            </div>
            <input class="form-control" name="titleInput" value="<?php echo $meal->getTitle() ?>" type="text">
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
                <label class="input-group-text text-light bg-dark" for="caloriesInput">Calories<span
                            style="color: red">*</span></label>
            </div>
            <input class="form-control" name="caloriesInput" min="0" value="<?php echo $meal->getCalorieIntake() ?>"
                   type="number">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="notesInput">Notes</label>
            </div>
            <textarea class="form-control" name="notesInput" maxlength="300"
                      style="resize: none;height: 90px;"><?php echo $meal->getNotes() ?></textarea>
        </div>


        <div class="row mb-3">
            <div class="col-sm-3">
                <img src="../Images/<?php echo $mealImageName ?>" style="height: auto; width: 100%;"
                     class="rounded float-left">
            </div>
            <div class="col-sm-2">
                <input class="btn btn-danger ml-3" name="btnDeleteImage" type="submit" value="Delete Image">
            </div>
            <div class="col">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text text-light bg-dark" for="mealImage">Add Image</label>
                    </div>
                    <input class="form-control" type="file" name="mealImage" multiple="">
                </div>
            </div>
        </div>


        <input class="btn btn-danger" name="btnCancel" type="submit" value="Cancel">
        <input class="btn btn-warning float-right" name="btnEditMeal" type="submit" value="Edit">

        <p class="text-center text-danger"><?php echo $failureOutputPara ?></p>

    </form>
</div>

</body>
</html>
