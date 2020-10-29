<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

session_start();
$outputPara = "";

if(isset($_POST['btnCancel'])){
    header("Location: index.php");
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

           header("Location: createUserPDPage.php");

       }
   }

}



?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <script>
    </script>
    <title>Sign up</title>
</head>
<body>
<div class="container">
    <p class="text-center"><b>Create Account</b> >>> Personal Details >>> Confirmation</p>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="userNameInput">Username</label>
            </div>
            <input class="form-control" name="userNameInput" type="text">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="emailInput">Email</label>
            </div>
            <input class="form-control" name="emailInput" type="text">
        </div>

        <div class="input-group mb-5">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="passwordInput">Password</label>
            </div>
            <input class="form-control" name="passwordInput" type="password">
        </div>

        <div>
            <input class="btn btn-danger" name="btnCancel" type="submit" value="Cancel">
            <input class="btn btn-primary float-right" name="btnCreateUser" type="submit" value="Next">
        </div>

        <p class="text-center"><?php echo $outputPara?></p>
    </form>
</div>

</body>
</html>
