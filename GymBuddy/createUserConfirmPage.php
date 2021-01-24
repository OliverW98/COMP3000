<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$failureOutputPara = "";
$successOutputPara = "";

if (isset($_POST['btnCancel'])) {
    header("Location: index.php");
}
if (isset($_POST['btnBack'])) {
    header("Location: createUserPDPage.php");
}

if (isset($_POST['btnCreateUser'])) {
    $failureOutputPara = "";
    $successOutputPara = "";
    if (checkIfUserExists($_POST['userNameInput'], $_POST['emailInput'])) {
        $failureOutputPara = "User already exists";
    } elseif (empty($_POST['weightInput'])) {
        createUserHalf($_SESSION['userName'], $_SESSION['email'], $_SESSION['password']);
        $successOutputPara = "Sign up complete";
    } else {
        createUserFull($_SESSION['userName'], $_SESSION['email'], $_SESSION['password'], $_SESSION['dob'], $_SESSION['gender']);
        $userID = logInUser($_SESSION['userName'], $_SESSION['password']);
        $dateTime = new DateTime();
        $date = $dateTime->format("Y-m-d");
        createSnapshot($userID, $date, $_SESSION['weight'], $_SESSION['height'], $_SESSION['BFP'], $_SESSION['MMP']);
        $successOutputPara = "Sign up complete";
    }
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm sign up</title>
</head>
<body>
<div class="container">
    <p class="text-center">Create Account >>> Personal Details >>> <b>Confirmation</b></p>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="userNameInput">Username</label>
            </div>
            <input class="form-control" name="userNameInput" type="text" value="<?php echo $_SESSION['userName'] ?>"
                   disabled>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="emailInput">Email</label>
            </div>
            <input class="form-control" name="emailInput" type="text" value="<?php echo $_SESSION['email'] ?>" disabled>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="passwordInput">Password</label>
            </div>
            <input class="form-control" name="passwordInput" type="password"
                   value="<?php echo $_SESSION['password'] ?>" disabled>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="weightInput">Weight</label>
            </div>
            <input class="form-control" name="weightInput" type="text" value="<?php echo $_SESSION['weight'] ?>"
                   disabled>
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="weightInput">Kg</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="heightInput">Height</label>
            </div>
            <input class="form-control" name="heightInput" type="text" value="<?php echo $_SESSION['height'] ?>"
                   disabled>
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="heightInput">Cm</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="BFPInput">Body Fat Percent</label>
            </div>
            <input class="form-control" name="BFPInput" type="text" value="<?php echo $_SESSION['BFP'] ?>" disabled>
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="BFPInput">%</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="MMPInput">Muscle Mass Percent</label>
            </div>
            <input class="form-control" name="MMPInput" type="text" value="<?php echo $_SESSION['MMP'] ?>" disabled>
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="MMPInput">%</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="dobInput">Date Of Birth</label>
            </div>
            <input class="form-control" name="dobInput" type="text" value="<?php echo $_SESSION['dob'] ?>" disabled>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="genderInput">Gender</label>
            </div>
            <input class="form-control" name="genderInput" type="text" value="<?php echo $_SESSION['gender'] ?>"
                   disabled>
        </div>

        <div>
            <div class="btn-group">
                <input class="btn btn-danger" name="btnCancel" type="submit" value="Cancel">
                <input class="btn btn-secondary" name="btnBack" type="submit" value="Back">
            </div>
            <input class="btn btn-success float-right" name="btnCreateUser" type="submit" value="Sign Up">
        </div>

        <p class="text-center text-success"><?php echo $successOutputPara ?></p>
        <p class="text-center text-danger"><?php echo $failureOutputPara ?></p>
    </form>
</div>

</body>
</html>
