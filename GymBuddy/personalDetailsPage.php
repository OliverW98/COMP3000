<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$user = updateUserDetails($_SESSION['userID']);
$failureOutputPara = $successOutputPara = "";

function updateUserDetails($userID){

  return getUser($userID);

}

if(isset($_POST['btnEdit'])){
    if(empty($_POST['weightInput']) || empty($_POST['heightInput']) || empty($_POST['dobInput'] || empty($_POST['genderInput']))){
        $failureOutputPara = "Fields must not be empty when editing";
    }else{
        editUserDetails($user->getUserID(),$_POST['weightInput'],$_POST['heightInput'], $_POST['dobInput'] ,$_POST['genderInput']);
        $successOutputPara = "Personal Details have be edited";
        $user = updateUserDetails($_SESSION['userID']);
    }
}

if(isset($_POST['btnDelete'])){
    if(empty($_POST['weightInput']) || empty($_POST['heightInput']) || empty($_POST['dobInput'] || empty($_POST['genderInput']))){
        $failureOutputPara = "Fields must be filed to delete them.";
    }else{
        deleteUserDetails($user->getUserID());
        $successOutputPara = "Personal Details deleted";
        $user = updateUserDetails($_SESSION['userID']);
    }
}


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script>
    </script>
    <title>Personal Details</title>
</head>
<body>
<div class="container">
    <p class="text-center mt-3">These details are need for some stats you may want to track</p>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="weightInput">Weight</label>
            </div>
            <input class="form-control" name="weightInput" type="number" value="<?php echo $user->getWeight();?>">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="weightInput" >Kg</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="heightInput">Height</label>
            </div>
            <input class="form-control" name="heightInput" type="number" value="<?php echo $user->getHeight();?>">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="heightInput" >Cm</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="dobInput">Date Of Birth</label>
            </div>
            <input class="form-control" name="dobInput" type="date" value="<?php echo $user->getDob();?>">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="genderInput">Gender</label>
            </div>
            <select class="form-control" name="genderInput">
                <?php if($user->getGender() == "Female") {
                    echo '<option>Female</option>';
                    echo '<option>Male</option>';
                }else{
                    echo '<option>Male</option>';
                    echo '<option>Female</option>';
                }
                    ?>
            </select>
        </div>

        <div>
            <input class="btn btn-danger" name="btnDelete" type="submit" value="Delete">
            <input class="btn btn-primary float-right" name="btnEdit" type="submit" value="Edit">
        </div>

        <p class="text-center text-success"><?php echo $successOutputPara?></p>
        <p class="text-center text-danger"><?php echo $failureOutputPara?></p>
    </form>
</div>

</body>
</html>
