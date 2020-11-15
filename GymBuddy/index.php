<?php

include $_SERVER['DOCUMENT_ROOT']."/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';


if(isset($_SESSION['userID'])){
    $user = getUser($_SESSION['userID']);
    $usersMeals = $user->getMeals();
    $usersWorkouts = $user->getWorkouts();

}


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home page</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <?php
            // var_dump($usersWorkouts);
            if(isset($_SESSION['userID'])){
                if (count($usersMeals) <= 0){
                    echo '<p class="text-center">User does not have any workouts recorded</p>';
                }else{

                }
            }else{
                echo '<p class="text-center">Please Log In to see your workouts</p>';
            }

            ?>
        </div>
        <div class="col-sm-6">
            <p class="text-center" style="font-size: 40px">Meals</p>
            <?php

            if(isset($_SESSION['userID'])){
                if (count($usersMeals) <= 0){
                    echo '<p class="text-center">User does not have any meals recorded</p>';
                }else{
                    foreach ($usersMeals as $meal){
                        echo '<div class="card mt-3 mx-auto" style="width: 25rem;">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">'.$meal->getTitle().'</h5>';
                        echo '<p class="card-text">'.$meal->getNotes().'</p>';
                        echo '</div>';
                        echo '<ul class="list-group list-group-flush">';
                        echo '<li class="list-group-item">Date : '.$meal->getDate().'</li>';
                        echo ' <li class="list-group-item">'.$meal->getCalorieIntake().' Cals</li>';
                        echo '</ul>';
                        echo '<div class="card-body">';
                        echo '<input class="btn btn-danger" name="btnDeleteMeal" type="submit" value="Delete">';
                        echo '<input class="btn btn-primary float-right" name="btnEditMeal" type="submit" value="Edit">';
                        echo '</div>';
                        echo '</div>';
                    }
                }
            }else{
                echo '<p class="text-center">Please Log In to see your meals</p>';
            }

            ?>
        </div>

    </div>

</div>
</body>
</html>