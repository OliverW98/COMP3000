<?php

include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Exercise</title>
</head>
<body>
<div class="container">
    <p class="text-center">Enter Exercise Information</p>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="titleInput">Title</label>
            </div>
            <input class="form-control" name="titleInput" type="text">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="dateInput">Date</label>
            </div>
            <input class="form-control" name="dateInput" type="datetime-local">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="durationInput">Duration</label>
            </div>
            <input class="form-control" name="durationInput" type="number">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="durationInput" >Mins</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text text-light bg-dark" for="notesInput">Notes</label>
            </div>
            <input class="form-control" name="notesInput" type="number">
            <div class="input-group-append">
                <label class="input-group-text text-light bg-dark" for="notesInput" >Kg</label>
            </div>
        </div>

        <div>
            <table class="table" id="exerciseTable">
                <thead class="thead-dark mt-3">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Exercise</th>
                    <th scope="col">Sets</th>
                    <th scope="col">Reps</th>
                    <th scope="col">Weights</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>yeye</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                    <td>yeye</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                    <td>yeye</td>
                </tr>
                </tbody>
            </table>

        </div>

        <div>
            <input class="btn btn-primary" name="btnNext" type="submit" value="Add Exercise">
            <input class="btn btn-success float-right" name="btnCreateWorkout" type="submit" value="Record Workout">
        </div>

        <p class="text-center text-danger"><?php echo $outputPara?></p>
    </form>
</div>

</body>
</html>
