<?php

include_once ('user.php');
include_once ('meal.php');

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

function getUser($userID){

   $userData = getUserDetails($userID);

   $usersMeals = getUsersMeals($userID);

   return $user = constructUserObject($userData,$usersMeals);
}

function constructUserObject($userData,$usersMeals){

    $mealsArray = array();

    for ($i=0; $i<count($usersMeals); $i++){
        $mealID = $usersMeals[$i]['mealID'];
        $title = $usersMeals[$i]['title'];
        $date = $usersMeals[$i]['mealDate'];
        $caloriesIntake = $usersMeals[$i]['caloriesIntake'];
        $notes = $usersMeals[$i]['notes'];

        $meal = new meal($mealID, $title, $date, $caloriesIntake, $notes);

        array_push($mealsArray , $meal);
    }

    for ($i=0; $i<count($userData);$i++){
        $userID = $userData[$i]['userID'];
        $userName = $userData[$i]['userName'];
        $email = $userData[$i]['email'];
        $password = $userData[$i]['password'];
        $userWeight = $userData[$i]['userWeight'];
        $userHeight = $userData[$i]['userHeight'];
        $dob = $userData[$i]['dateOfBirth'];
        $gender = $userData[$i]['gender'];
    }

    return $user = new user($userID,$userName,$email,$password,$userWeight,$userHeight,$dob,$gender,$mealsArray);
}

function checkIfUserExists($userName, $email){
   $result = getConnection()->query("select userID from users where userName = '". $userName."' or email = '".$email."' ");
    if($result->rowCount() == 0){
        return false;
    } else{
        return true;
    }
}

function checkIfLoginCorrect($userName, $email, $password){
    $result = getConnection()->query("select userID from users where (userName = '". $userName."' or email = '".$email."') and password = '".$password."' ");
    if($result->rowCount() == 0){
        return false;
    } else{
        return true;
    }
}

function createUserHalf($userName, $email, $password){
    $statement = getConnection()->prepare("CALL createUserHalf ('" . $userName . "','" . $email . "','" . $password . "')");
    $statement->execute();
}

function createUserFull($userName, $email, $password , $weight, $height, $dob , $gender){
    $statement = getConnection()->prepare("CALL createUserFull ('" . $userName . "','" . $email . "','" . $password . "','" . $weight . "','" . $height . "','" . $dob . "','" . $gender . "')");
    $statement->execute();
}

function logInUser($userNameEmail, $password){
    $statement = getConnection()->prepare("CALL logInUser('".$userNameEmail."','".$password."')");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]['userID'];
}

function getWorkoutID($date){
    $statement = getConnection()->prepare("CALL getWorkoutID('".$date."')");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]['workoutID'];
}

function getUserDetails($userID){
    $statement = getConnection()->prepare("CALL getUserDetails('" . $userID . "')");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);;
}
function getUsersMeals($userID){
    $statement = getConnection()->prepare("CALL getUsersMeals('" . $userID . "')");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function editUserDetails($userID, $weight, $height, $dob , $gender){
    $statement = getConnection()->prepare("CALL editUserDetails ('" . $userID . "','" . $weight . "','" . $height . "','" . $dob . "','" . $gender . "')");
    $statement->execute();
}

function deleteUserDetails($userID){
    $statement = getConnection()->prepare("CALL deleteUserDetails ('" . $userID . "')");
    $statement->execute();
}

function createMeal($userID,$title,$mealDate,$caloriesIntake,$notes){
    $statement = getConnection()->prepare("CALL createMeal ('" . $userID . "','" . $title . "','" . $mealDate . "','" . $caloriesIntake . "','" . $notes . "')");
    $statement->execute();
}

function createWeightsWorkout($userID,$type,$title,$date,$duration,$notes){
    $statement = getConnection()->prepare("CALL createWeightsWorkout ('" . $userID . "','" . $type . "','" . $title . "','" . $date . "','" . $duration . "','" . $notes . "')");
    $statement->execute();
}

function createExercise($workoutID,$name,$sets,$reps,$weight){
    $statement = getConnection()->prepare("CALL createExercise ('".$workoutID."','".$name."','".$sets."','".$reps."','".$weight."')");
    $statement->execute();
}

function createRunCycleWorkout($userID, $type , $title, $date , $duration , $distance , $elevation , $notes){
    $statement = getConnection()->prepare("CALL createRunCycleWorkout ('" . $userID . "','" . $type . "','" . $title . "','" . $date . "','" . $duration . "','" . $distance . "','" . $elevation . "','" . $notes . "')");
    $statement->execute();
}
