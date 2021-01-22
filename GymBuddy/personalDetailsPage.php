<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$user = updateUserDetails($_SESSION['userID']);
$userCurrentSnapshot = updateUsersSnapshot($user);
$weight = $height = $BFP = $MMP = $dob = $gender = $failureOutputPara = $successOutputPara = "";

$weight = displayWeight($userCurrentSnapshot);
$height = displayHeight($userCurrentSnapshot);
$BFP = displayBFP($userCurrentSnapshot);
$MMP = displayMMP($userCurrentSnapshot);
$dob = displayDOB($user);
$gender = displayGender($user);


function updateUserDetails($userID)
{
    return getUser($userID);

}

function updateUsersSnapshot($user)
{
    $userSnapshots = $user->getSnapshots();
    return $userSnapshots[count($userSnapshots) - 1];
}

function displayWeight($snapshot)
{
    return $snapshot->getWeight();
}

function displayHeight($snapshot)
{
    return $snapshot->getWeight();
}

function displayBFP($snapshot)
{
    return $snapshot->getWeight();
}

function displayMMP($snapshot)
{
    return $snapshot->getWeight();
}

function displayDOB($user)
{
    return $user->getDob();
}

function displayGender($user)
{
    return $user->getGender();
}

if (isset($_POST['btnUpdate'])) {
    if (empty($_POST['weightInput']) || empty($_POST['heightInput']) || empty($_POST['BFPInput']) || empty($_POST['MMPInput']) || empty($_POST['dobInput']) || empty($_POST['genderInput'])) {
        $failureOutputPara = "Fields must not be empty when editing";
    } else {
        $dateTime = new DateTime();
        $date = $dateTime->format("Y-m-d");
        editUserDetails($user->getUserID(), $_POST['dobInput'], $_POST['genderInput']);
        createSnapshot($user->getUserID(), $date, $_POST['weightInput'], $_POST['heightInput'], $_POST['BFPInput'], $_POST['MMPInput']);
        $successOutputPara = "Personal Details have be edited";
        $user = updateUserDetails($_SESSION['userID']);
        $userCurrentSnapshot = updateUsersSnapshot($user);
    }
}

if (isset($_POST['btnDelete'])) {
    if (empty($_POST['weightInput']) || empty($_POST['heightInput']) || empty($_POST['BFPInput']) || empty($_POST['MMPInput']) || empty($_POST['dobInput']) || empty($_POST['genderInput'])) {
        $failureOutputPara = "Fields must be filled to delete them.";
    } else {
        deleteUserDetails($user->getUserID());
        deleteSnapshot($userCurrentSnapshot->getSnapshotID());
        $successOutputPara = "Personal Details deleted";
        $user = updateUserDetails($_SESSION['userID']);
        $userCurrentSnapshot = updateUsersSnapshot($user);
    }
}


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
            <input class="form-control" name="weightInput" min="0" type="number"
                   value="<?php echo $userCurrentSnapshot->getWeight(); ?>">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="weightInput">Kg</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="heightInput">Height</label>
            </div>
            <input class="form-control" name="heightInput" min="0" type="number"
                   value="<?php echo $userCurrentSnapshot->getHeight(); ?>">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="heightInput">Cm</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="BFPInput">Body Fat Percent</label>
            </div>
            <input class="form-control" name="BFPInput" min="0" type="number"
                   value="<?php echo $userCurrentSnapshot->getBodyFatPercent(); ?>">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="BFPInput">%</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="MMPInput">Muscle Mass Percent</label>
            </div>
            <input class="form-control" name="MMPInput" min="0" type="number"
                   value="<?php echo $userCurrentSnapshot->getMuscleMassPercent(); ?>">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="MMPInput">%</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="dobInput">Date Of Birth</label>
            </div>
            <input class="form-control" name="dobInput" type="date" value="<?php echo $user->getDob(); ?>">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="genderInput">Gender</label>
            </div>
            <select class="form-control" name="genderInput">
                <?php if ($user->getGender() == "Female") {
                    echo '<option>Female</option>';
                    echo '<option>Male</option>';
                } else {
                    echo '<option>Male</option>';
                    echo '<option>Female</option>';
                }
                ?>
            </select>
        </div>

        <div>
            <input class="btn btn-danger" name="btnDelete" type="submit" value="Delete">
            <input class="btn btn-primary float-right" name="btnUpdate" type="submit" value="Update">
        </div>

        <p class="text-center text-success"><?php echo $successOutputPara ?></p>
        <p class="text-center text-danger"><?php echo $failureOutputPara ?></p>
    </form>
</div>

</body>
</html>
