<?php
include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

session_start();
$outputPara = "";

if(isset($_POST['btnCancel'])){
    header("Location: index.php");
}
if(isset($_POST['btnBack'])){
    header("Location: createUserPage.php");
}

if(isset($_POST['btnCreateUser'])){
    if(checkIfUserExists($_POST['userNameInput'],$_POST['emailInput'])){
        $outputPara = "Username or Password is taken";
    }else{
        if(empty($_POST['userNameInput']) || empty($_POST['emailInput']) || empty($_POST['passwordInput'])){
            $outputPara = "Make sure to fill all fields.";
        }else{
            // createUserHalf($_POST['userNameInput'],$_POST['emailInput'],$_POST['passwordInput']);

            $_SESSION['userName'] = $_POST['userNameInput'];
            $_SESSION['email'] = $_POST['emailInput'];
            $_SESSION['password'] = $_POST['passwordInput'];
            // $outputPara = "User Created";
        }
    }

}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script>
    </script>
    <title>Create User Page</title>
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
            <input class="form-control" name="weightInput" type="text">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="weightInput" >Kg</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="heightInput">Height</label>
            </div>
            <input class="form-control" name="heightInput" type="text">
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
            <input class="btn btn-danger" name="btnCancel" type="submit" value="Cancel">
            <input class="btn btn-secondary" name="btnBack" type="submit" value="Back">
            <input class="btn btn-primary float-right" name="btnCreateUser" type="submit" value="Next">
        </div>

    </form>
</div>

</body>
</html>