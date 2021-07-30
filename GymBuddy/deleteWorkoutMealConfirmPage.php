<?php
include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$activity = $_SESSION['activityToDelete'];

$datetime = new DateTime($activity->getDate());
$date = "{$datetime->format('Y-m-d')}T{$datetime->format('H:i')}";


function unsetSessions()
{
    unset($_SESSION['activityToDelete']);
}

if (isset($_POST['btnCancel'])) {
    unsetSessions();
    header("Location: index.php");
}

if (isset($_POST['btnDeleteActivity'])) {
    if (get_class($activity) == "meal") {
        deleteMeal($activity->getMealID());
        unlink('../Images/' . $activity->getImageName());
    } else {
        deleteWorkout($activity->getWorkoutID());
        unlink('../Images/' . $activity->getImageName());
    }

    unsetSessions();
    header("Location: index.php");
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Activity</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col"></div>
        <div class="col-sm-8">
            <?php
            if (get_class($activity) == "meal") {
                echo '<p class="text-center mt-5">Are you sure you want to delete this meal?</p>';
            } else {
                echo '<p class="text-center mt-5">Are you sure you want to delete this workout?</p>';
            }

            ?>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text text-light bg-dark" for="titleInput">Title</label>
                    </div>
                    <input class="form-control" name="titleInput" disabled value="<?php echo $activity->getTitle() ?>"
                           type="text">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text text-light bg-dark" for="dateInput">Date</label>
                    </div>
                    <input class="form-control" name="dateInput" disabled value="<?php echo $date ?>"
                           type="datetime-local">
                </div>
                <div>
                    <input class="btn btn-primary" name="btnCancel" type="submit" value="Cancel">
                    <?php
                    if (get_class($activity) == "meal") {
                        echo '<input class="btn btn-danger float-right" name="btnDeleteActivity" type="submit" value="Delete Meal">';
                    } else {
                        echo '<input class="btn btn-danger float-right" name="btnDeleteActivity" type="submit" value="Delete Workout">';
                    }

                    ?>
                </div>
            </form>
        </div>
        <div class="col"></div>
    </div>
</div>

</body>
</html>
