<?php
include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$successOutputPara = $failureOutputPara = "";

if (isset($_POST['btnCreateMeal'])) {

    $today = new DateTime();
    $mealDate = new DateTime($_POST['dateInput']);

    if (empty($_POST['titleInput']) || empty($_POST['dateInput']) || empty($_POST['caloriesInput'])) {
        $failureOutputPara = "Required fields must be filled to record a meal";
    } elseif ($_POST['caloriesInput'] <= 0) {
        $failureOutputPara = "Calories cannot be negative";
    } elseif ($today < $mealDate) {
        $failureOutputPara = "Can't record a meal in the future";
    } else {
        createMeal($_SESSION['userID'], $_POST['titleInput'], $_POST['dateInput'], $_POST['caloriesInput'], $_POST['notesInput']);
        $successOutputPara = "Meal has been recorded";
    }
}


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Meal</title>
</head>
<body>
<div class="container">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

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

        <input class="btn btn-success float-right" name="btnCreateMeal" type="submit" value="Record Meal">

        <p class="text-center text-success"><?php echo $successOutputPara ?></p>
        <p class="text-center text-danger"><?php echo $failureOutputPara ?></p>

    </form>
</div>

</body>
</html>