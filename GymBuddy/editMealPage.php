<?php
include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$failureOutputPara = "";
$meal = $_SESSION['mealToEdit'];

$datetime = new DateTime($meal->getDate());
$date = "{$datetime->format('Y-m-d')}T{$datetime->format('H:i')}";

if (isset($_POST['btnCancel'])) {
    unset($_SESSION['mealToEdit']);
    header("Location: index.php");
}
if (isset($_POST['btnEditMeal'])) {

    $today = new DateTime();
    $mealDate = new DateTime($_POST['dateInput']);

    if (empty($_POST['titleInput']) || empty($_POST['dateInput']) || empty($_POST['caloriesInput'])) {
        $failureOutputPara = "Required fields must be filled to edit a meal";
    } elseif ($_POST['caloriesInput'] <= 0) {
        $failureOutputPara = "Calories cannot be negative";
    } elseif ($today < $mealDate) {
        $failureOutputPara = "Meal cannot occur in the future";
    } else {
        editMeal($meal->getMealID(), $_POST['titleInput'], $_POST['dateInput'], $_POST['caloriesInput'], $_POST['notesInput']);
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
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
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

        <input class="btn btn-danger" name="btnCancel" type="submit" value="Cancel">
        <input class="btn btn-warning float-right" name="btnEditMeal" type="submit" value="Edit">

        <p class="text-center text-danger"><?php echo $failureOutputPara ?></p>

    </form>
</div>

</body>
</html>
