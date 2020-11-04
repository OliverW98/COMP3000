<?php
include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$successOutputPara=$failureOutputPara="";

if(isset($_POST['btnCreateMeal'])){
    if(empty($_POST['titleInput']) || empty($_POST['dateInput']) || empty($_POST['caloriesInput']|| empty($_POST['notesInput']))){
        $failureOutputPara = "Fields must be filled to create meal";
    }else{
        createMeal($_SESSION['userID'],$_POST['titleInput'] , $_POST['dateInput'] , $_POST['caloriesInput'], $_POST['notesInput']);
        $successOutputPara = "Meal has been created and recorded";
    }
}


?>
<html lang="en">
<head>
    <style>
        textarea{
            resize: none;
            height: 400px;
        }
    </style>
    <meta charset="UTF-8">
    <title>Add Personal Details</title>
</head>
<body>
<div class="container">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

        <div class="input-group mb-3 mt-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="titleInput">Title</label>
            </div>
            <input class="form-control" name="titleInput" type="text">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="dateInput">Date</label>
            </div>
            <input class="form-control" name="dobInput" type="date">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="caloriesInput">Calories</label>
            </div>
            <input class="form-control" name="caloriesInput" type="number">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="notesInput">Notes</label>
            </div>
            <textarea class="form-control" name="notesInput" style="resize: none;height: 90px;"></textarea>
        </div>

        <input class="btn btn-success float-right" name="btnCreateMeal" type="submit" value="Create Meal">

        <p class="text-center text-success"><?php echo $successOutputPara?></p>
        <p class="text-center text-danger"><?php echo $failureOutputPara?></p>

    </form>
</div>

</body>
</html>