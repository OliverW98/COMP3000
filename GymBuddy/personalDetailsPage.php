<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$user = updateUserDetails($_SESSION['userID']);
$userCurrentSnapshot = updateUsersSnapshot($user);
$snapshotDate = $weight = $height = $BFP = $MMP = $failureOutputPara = $successOutputPara = "";

if (count($user->getSnapshots()) > 0) {
    $snapshotDate = displaySnapshotDate($userCurrentSnapshot);
    $weight = displayWeight($userCurrentSnapshot);
    $height = displayHeight($userCurrentSnapshot);
    $BFP = displayBFP($userCurrentSnapshot);
    $MMP = displayMMP($userCurrentSnapshot);
}

function updateUserDetails($userID)
{
    return getUser($userID);

}

function updateUsersSnapshot($user)
{
    $userSnapshots = $user->getSnapshots();
    if (count($userSnapshots) > 0) {
        return $userSnapshots[count($userSnapshots) - 1];
    } else {
        return null;
    }
}

function displaySnapshotDate($snapshot)
{
    $date = new DateTime($snapshot->getDate());
    return $date->format("Y-m-d");
}

function displayWeight($snapshot)
{
    return $snapshot->getWeight();
}

function displayHeight($snapshot)
{
    return $snapshot->getHeight();
}

function displayBFP($snapshot)
{
    return $snapshot->getBodyFatPercent();
}

function displayMMP($snapshot)
{
    return $snapshot->getMuscleMassPercent();
}


if (isset($_POST['btnUpdateStats'])) {
    if (empty($_POST['weightInput']) || empty($_POST['heightInput']) || empty($_POST['BFPInput']) || empty($_POST['MMPInput'])) {
        $failureOutputPara = " Stats fields must not be empty when editing";
    } else {
        $dateTime = new DateTime();
        $date = $dateTime->format("Y-m-d");
        createSnapshot($user->getUserID(), $date, $_POST['weightInput'], $_POST['heightInput'], $_POST['BFPInput'], $_POST['MMPInput']);
        $successOutputPara = "Body Stats have be edited";
        $user = updateUserDetails($_SESSION['userID']);
        $userCurrentSnapshot = updateUsersSnapshot($user);
        if (count($user->getSnapshots()) > 0) {
            $snapshotDate = displaySnapshotDate($userCurrentSnapshot);
            $weight = displayWeight($userCurrentSnapshot);
            $height = displayHeight($userCurrentSnapshot);
            $BFP = displayBFP($userCurrentSnapshot);
            $MMP = displayMMP($userCurrentSnapshot);
        }
    }
}

if (isset($_POST['btnDeleteStats'])) {
    if (empty($_POST['weightInput']) || empty($_POST['heightInput']) || empty($_POST['BFPInput']) || empty($_POST['MMPInput'])) {
        $failureOutputPara = "Stats fields must be filled to delete them.";
    } else {

        deleteSnapshot($userCurrentSnapshot->getSnapshotID());
        $successOutputPara = "Body Stats deleted";
        $user = updateUserDetails($_SESSION['userID']);
        $userCurrentSnapshot = updateUsersSnapshot($user);
        if (count($user->getSnapshots()) > 0) {
            $snapshotDate = displaySnapshotDate($userCurrentSnapshot);
            $weight = displayWeight($userCurrentSnapshot);
            $height = displayHeight($userCurrentSnapshot);
            $BFP = displayBFP($userCurrentSnapshot);
            $MMP = displayMMP($userCurrentSnapshot);
        } else {
            $snapshotDate = $weight = $height = $BFP = $MMP = "";
        }
    }
}

if (isset($_POST['btnUpdateDetails'])) {
    if (empty($_POST['dobInput']) || $_POST['genderInput'] === "Select a Gender") {
        $failureOutputPara = " Details fields must not be empty when editing";
    } else {
        editUserDetails($user->getUserID(), $_POST['dobInput'], $_POST['genderInput']);
        $successOutputPara = "Details have be edited";
        $user = updateUserDetails($_SESSION['userID']);
        $userCurrentSnapshot = updateUsersSnapshot($user);
    }
}

if (isset($_POST['btnDeleteDetails'])) {
    if (empty($_POST['dobInput']) || $_POST['genderInput'] === "Select a Gender") {
        $failureOutputPara = "Details fields must be filled to delete them.";
    } else {
        deleteUserDetails($user->getUserID());
        $successOutputPara = "Details deleted";
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
    <h3 class="text-center mt-3">This information is used to created stats for you workouts</h3>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

        <h5 class="text-center mt-3">Body Stats</h5>
        <p class="text-center">This is you body Snapshot
            for <?php echo $snapshotDate; ?> </p>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="weightInput">Weight</label>
            </div>
            <input class="form-control" name="weightInput" min="0" type="number"
                   value="<?php echo $weight ?>">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="weightInput">Kg</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="heightInput">Height</label>
            </div>
            <input class="form-control" name="heightInput" min="0" type="number"
                   value="<?php echo $height ?>">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="heightInput">Cm</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="BFPInput">Body Fat Percent</label>
            </div>
            <input class="form-control" name="BFPInput" min="0" type="number"
                   value="<?php echo $BFP ?>">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="BFPInput">%</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="MMPInput">Muscle Mass Percent</label>
            </div>
            <input class="form-control" name="MMPInput" min="0" type="number"
                   value="<?php echo $MMP; ?>">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="MMPInput">%</label>
            </div>
        </div>

        <div>
            <input class="btn btn-danger" name="btnDeleteStats" type="submit" value="Delete Stats">
            <input class="btn btn-primary float-right" name="btnUpdateStats" type="submit" value="Update Stats">
        </div>

        <h5 class="text-center mt-3">Details</h5>

        <div class="input-group mt-3 mb-3">
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
                    echo '<option>Male</option>';
                    echo '<option selected>Female</optionselected>';
                } else if ($user->getGender() == "Male") {
                    echo '<option selected>Male</option>';
                    echo '<option>Female</optionselected>';
                } else {
                    echo '<option selected>Select a Gender</option>';
                    echo '<option>Male</option>';
                    echo '<option>Female</option>';
                }
                ?>
            </select>
        </div>

        <div>
            <input class="btn btn-danger" name="btnDeleteDetails" type="submit" value="Delete Details">
            <input class="btn btn-primary float-right" name="btnUpdateDetails" type="submit" value="Update Details">
        </div>

        <p class="text-center text-success"><?php echo $successOutputPara ?></p>
        <p class="text-center text-danger"><?php echo $failureOutputPara ?></p>
    </form>
</div>

</body>
</html>
