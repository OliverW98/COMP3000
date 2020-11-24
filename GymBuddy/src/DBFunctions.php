<?php

include_once('user.php');
include_once('meal.php');
include_once('workout.php');
include_once('weights.php');
include_once('cycle.php');
include_once('run.php');
include_once('exercise.php');

const DB_SERVER = "Proj-mysql.uopnet.plymouth.ac.uk";
const DB_USER = "COMP3000_OWilkes";
const DB_PASSWORD = 'FdpA151*';
const DB_DATABASE = "COMP3000_OWilkes";

function getConnection()
{
    $dataSourceName = 'mysql:dbname=' . DB_DATABASE . ';host=' . DB_SERVER;
    $dbConnection = null;
    try {
        $dbConnection = new PDO($dataSourceName, DB_USER, DB_PASSWORD);

    } catch (PDOException $err) {
        echo 'Connection failed: ', $err->getMessage();
    }
    return $dbConnection;
}

function getUser($userID)
{

    $userData = getUserDetails($userID);

    $usersMeals = getUsersMeals($userID);

    $usersWorkouts = getUsersWorkouts($userID);

    return $user = constructUserObject($userData, $usersMeals, $usersWorkouts);
}

function constructUserObject($userData, $usersMeals, $usersWorkouts)
{

    $mealsArray = array();
    $workoutsArray = array();

    for ($i = 0; $i < count($usersMeals); $i++) {
        $mealID = $usersMeals[$i]['mealID'];
        $title = $usersMeals[$i]['title'];
        $date = $usersMeals[$i]['mealDate'];
        $caloriesIntake = $usersMeals[$i]['caloriesIntake'];
        $notes = $usersMeals[$i]['notes'];

        $meal = new meal($mealID, $title, $date, $caloriesIntake, $notes);

        array_push($mealsArray, $meal);
    }

    for ($i = 0; $i < count($usersWorkouts); $i++) {

        $workoutID = $usersWorkouts[$i]['workoutID'];
        $type = $usersWorkouts[$i]['type'];
        $title = $usersWorkouts[$i]['title'];
        $date = $usersWorkouts[$i]['workoutDate'];
        $duration = $usersWorkouts[$i]['duration'];
        $distance = $usersWorkouts[$i]['distance'];
        $elevation = $usersWorkouts[$i]['elevation'];
        $notes = $usersWorkouts[$i]['notes'];

        if ($type == 0) {

            $cycle = new cycle($workoutID, $title, $date, $duration, $distance, $elevation, $notes);

            array_push($workoutsArray, $cycle);

        } elseif ($type == 1) {

            $run = new run($workoutID, $title, $date, $duration, $distance, $elevation, $notes);

            array_push($workoutsArray, $run);

        } elseif ($type == 2) {

            $workoutExercises = getWorkoutExercises($workoutID);
            $exercisesArray = array();

            for ($j = 0; $j < count($workoutExercises); $j++) {
                $exerciseID = $workoutExercises[$j]['exerciseID'];
                $name = $workoutExercises[$j]['name'];
                $sets = $workoutExercises[$j]['sets'];
                $reps = $workoutExercises[$j]['reps'];
                $weight = $workoutExercises[$j]['weight'];

                $exercise = new exercise($exerciseID, $name, $sets, $reps, $weight);

                array_push($exercisesArray, $exercise);
            }
            $weights = new weights($workoutID, $title, $date, $duration, $notes, $exercisesArray);

            array_push($workoutsArray, $weights);
        }
    }


    for ($i = 0; $i < count($userData); $i++) {
        $userID = $userData[$i]['userID'];
        $userName = $userData[$i]['userName'];
        $email = $userData[$i]['email'];
        $password = $userData[$i]['password'];
        $userWeight = $userData[$i]['userWeight'];
        $userHeight = $userData[$i]['userHeight'];
        $dob = $userData[$i]['dateOfBirth'];
        $gender = $userData[$i]['gender'];
    }

    return $user = new user($userID, $userName, $email, $password, $userWeight, $userHeight, $dob, $gender, $mealsArray, $workoutsArray);
}

function checkIfUserExists($userName, $email)
{
    $result = getConnection()->query("select userID from users where userName = '" . $userName . "' or email = '" . $email . "' ");
    if ($result->rowCount() == 0) {
        return false;
    } else {
        return true;
    }
}

function checkIfLoginCorrect($userName, $email, $password)
{
    $result = getConnection()->query("select userID from users where (userName = '" . $userName . "' or email = '" . $email . "') and password = '" . $password . "' ");
    if ($result->rowCount() == 0) {
        return false;
    } else {
        return true;
    }
}

function createUserHalf($userName, $email, $password)
{
    $statement = getConnection()->prepare("CALL createUserHalf ('" . $userName . "','" . $email . "','" . $password . "')");
    $statement->execute();
}

function createUserFull($userName, $email, $password, $weight, $height, $dob, $gender)
{
    $statement = getConnection()->prepare("CALL createUserFull ('" . $userName . "','" . $email . "','" . $password . "','" . $weight . "','" . $height . "','" . $dob . "','" . $gender . "')");
    $statement->execute();
}

function logInUser($userNameEmail, $password)
{
    $statement = getConnection()->prepare("CALL logInUser('" . $userNameEmail . "','" . $password . "')");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]['userID'];
}

function getWorkoutID($date)
{
    $statement = getConnection()->prepare("CALL getWorkoutID('" . $date . "')");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]['workoutID'];
}

function getUserDetails($userID)
{
    $statement = getConnection()->prepare("CALL getUserDetails('" . $userID . "')");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);;
}

function getUsersMeals($userID)
{
    $statement = getConnection()->prepare("CALL getUsersMeals('" . $userID . "')");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getUsersWorkouts($userID)
{
    $statement = getConnection()->prepare("CALL getUsersWorkouts('" . $userID . "')");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getWorkoutExercises($workoutID)
{
    $statement = getConnection()->prepare("CALL getWorkoutExercises('" . $workoutID . "')");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function editUserDetails($userID, $weight, $height, $dob, $gender)
{
    $statement = getConnection()->prepare("CALL editUserDetails ('" . $userID . "','" . $weight . "','" . $height . "','" . $dob . "','" . $gender . "')");
    $statement->execute();
}

function editMeal($mealID, $title, $mealDate, $caloriesIntake, $notes)
{
    $statement = getConnection()->prepare("CALL editMeal ('" . $mealID . "','" . $title . "','" . $mealDate . "','" . $caloriesIntake . "','" . $notes . "')");
    $statement->execute();
}

function editCardioWorkout($workoutID, $title, $date, $duration, $distance, $elevation, $notes)
{
    $statement = getConnection()->prepare("CALL editCardioWorkout ('" . $workoutID . "','" . $title . "','" . $date . "','" . $duration . "','" . $distance . "','" . $elevation . "','" . $notes . "')");
    $statement->execute();
}

function deleteUserDetails($userID)
{
    $statement = getConnection()->prepare("CALL deleteUserDetails ('" . $userID . "')");
    $statement->execute();
}

function deleteWorkout($workoutID)
{
    $statement = getConnection()->prepare("CALL deleteWorkout ('" . $workoutID . "')");
    $statement->execute();
}

function deleteMeal($mealID)
{
    $statement = getConnection()->prepare("CALL deleteMeal ('" . $mealID . "')");
    $statement->execute();
}

function createMeal($userID, $title, $mealDate, $caloriesIntake, $notes)
{
    $statement = getConnection()->prepare("CALL createMeal ('" . $userID . "','" . $title . "','" . $mealDate . "','" . $caloriesIntake . "','" . $notes . "')");
    $statement->execute();
}

function createExercise($workoutID, $name, $sets, $reps, $weight)
{
    $statement = getConnection()->prepare("CALL createExercise ('" . $workoutID . "','" . $name . "','" . $sets . "','" . $reps . "','" . $weight . "')");
    $statement->execute();
}

function createWorkout($userID, $type, $title, $date, $duration, $distance, $elevation, $notes)
{
    $statement = getConnection()->prepare("CALL createWorkout ('" . $userID . "','" . $type . "','" . $title . "','" . $date . "','" . $duration . "','" . $distance . "','" . $elevation . "','" . $notes . "')");
    $statement->execute();
}
