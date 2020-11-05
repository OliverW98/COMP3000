<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$outputPara ="";

if(isset($_POST['btnCancel'])){
    header("Location: index.php");
}

if(isset($_POST['btnLogIn'])){
    if(empty($_POST['userNameEmailInput']) || empty($_POST['passwordInput'])){
        $outputPara = "Enter details before logging in";
    }else if(checkIfLoginCorrect($_POST['userNameEmailInput'],$_POST['userNameEmailInput'],$_POST['passwordInput'])){
        logInUser($_POST['userNameEmailInput'],$_POST['passwordInput']);
        header("Location: index.php");
    }else{
        $outputPara = "Log in details do not match";
    }
}
?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign up</title>
</head>
<body>
<div class="container">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="input-group mt-3 mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="userNameEmailInput">Username/Email</label>
            </div>
            <input class="form-control" name="userNameEmailInput" type="text">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="passwordInput">Password</label>
            </div>
            <input class="form-control" name="passwordInput" type="password">
        </div>

        <div>
            <input class="btn btn-danger" name="btnCancel" type="submit" value="Cancel">
            <input class="btn btn-primary float-right" name="btnLogIn" type="submit" value="Log In">
        </div>
        <p class="text-danger text-center"><?php echo $outputPara  ?></p>
    </form>
</div>

</body>
</html>
