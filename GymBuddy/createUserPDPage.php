<?php
include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

session_start();
$outputPara = "";

if(isset($_POST['btnCancel'])){
    header("Location: index.php");
    session_destroy();
}
if(isset($_POST['btnBack'])){
    header("Location: createUserPage.php");
}

if(isset($_POST['btnSkip'])){
    header("Location: createUserConfirmPage.php");
    $_SESSION['weight'] = "";
    $_SESSION['height'] = "";
    $_SESSION['dob'] = "";
    $_SESSION['gender'] = "";
}


if(isset($_POST['btnAddDetails'])){
    if(empty($_POST['weightInput']) || empty($_POST['heightInput']) || empty($_POST['dobInput'] || $_POST['genderInput'] == "Select a Gender")){
        $outputPara = "Make sure to fill all fields and a gender is selected.";
        // issue with Gender select box:
        // if statement will not read the select properly.
    }else{
        $_SESSION['weight'] = $_POST['weightInput'];
        $_SESSION['height'] = $_POST['heightInput'];
        $_SESSION['dob'] = $_POST['dobInput'];
        $_SESSION['gender'] = $_POST['genderInput'];

        header("Location: createUserConfirmPage.php");
    }


}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script>
    </script>
    <title>Add Personal Details</title>
</head>
<body>
<div class="container">
    <p class="text-center">Create Account >>> <b>Personal Details</b> >>> Confirmation</p>
    <p>Personal details are optional. However if they are not filled out some statics will not be calculated.</p>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="weightInput">Weight</label>
            </div>
            <input class="form-control" name="weightInput" type="number">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="weightInput" >Kg</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="heightInput">Height</label>
            </div>
            <input class="form-control" name="heightInput" type="number">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="heightInput" >Cm</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="dobInput">Date of Birth :</label>
            </div>
            <input class="form-control" name="dobInput" type="date">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="genderInput">Gender :</label>
            </div>
            <select class="form-control" name="genderInput">
                <option>Select a Gender</option>
                <option>Male</option>
                <option>Female</option>
            </select>
        </div>

        <div>
            <div class="btn-group">
                <input class="btn btn-danger" name="btnCancel" type="submit" value="Cancel">
                <input class="btn btn-secondary" name="btnBack" type="submit" value="Back">
            </div>

            <div class="btn-group float-right">
                <input class="btn btn-secondary" name="btnSkip" type="submit" value="Skip">
                <input class="btn btn-primary" name="btnAddDetails" type="submit" value="Add Details">
            </div>
        </div>

        <p class="text-center text-danger"><?php echo $outputPara?></p>

    </form>
</div>

</body>
</html>