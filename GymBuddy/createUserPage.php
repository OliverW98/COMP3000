<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";

$outputPara = "";

if(isset($_POST['btnCreateUser'])){
   if(checkIfUserExists($_POST['userNameInput'],$_POST['emailInput'])){
       $outputPara = "username or password is taken";
   }else{
       if(empty($_POST['userNameInput']) || empty($_POST['emailInput']) || empty($_POST['passwordInput'])){
           $outputPara = "Make sure to fill all fields.";
       }else{
           createUserHalf($_POST['userNameInput'],$_POST['emailInput'],$_POST['passwordInput']);
           $outputPara = "user created";
       }


   }

}



?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

    </script>
    <title>Create User Page</title>

</head>
<body>

<div>
    <h1>Create User Page</h1>
</div>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
    <div>
        <input name="userNameInput" type="text">
        <input name="emailInput" type="text">
        <input name="passwordInput" type="password">
    </div>
    <div>
        <input name="btnCreateUser" type="submit" value="Create User">
    </div>
    <p><?php echo $outputPara?></p>
</form>
</body>
</html>
