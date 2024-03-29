<?php

include_once('user.php');
include_once('snapshot.php');
include_once('meal.php');
include_once('workout.php');
include_once('weights.php');
include_once('cycle.php');
include_once('run.php');
include_once('exercise.php');
include_once('goal.php');

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

    $userSnapshots = getUsersSnapshots($userID);

    $usersMeals = getUsersMeals($userID);

    $usersWorkouts = getUsersWorkouts($userID);

    $usersGoals = getUsersGoals($userID);

    $user = constructUserObject($userData, $userSnapshots, $usersMeals, $usersWorkouts, $usersGoals);

    $userCurrentSnapshot = $user->getSnapshots();
    if (count($user->getSnapshots()) > 0) {
        foreach ($user->getWorkouts() as $workout) {
            if (get_class($workout) == "cycle") {
                $workout->setAverageWatts($userCurrentSnapshot[count($userCurrentSnapshot) - 1]);
            } elseif (get_class($workout) == "run") {
                $workout->setCaloriesBurnt($userCurrentSnapshot[count($userCurrentSnapshot) - 1], $user->getDob(), $user->getGender());
            }
        }
    }

    return $user;
}

function getUserWithYear($userID, $year)
{

    $userData = getUserDetails($userID);

    $userSnapshots = getUsersSnapshotsByYear($userID, $year);

    $usersMeals = getUsersMealsByYear($userID, $year);

    $usersWorkouts = getUsersWorkoutsByYear($userID, $year);

    $usersGoals = getUsersGoals($userID);

    $user = constructUserObject($userData, $userSnapshots, $usersMeals, $usersWorkouts, $usersGoals);

    $userCurrentSnapshot = $user->getSnapshots();
    if (count($user->getSnapshots()) > 0) {
        foreach ($user->getWorkouts() as $workout) {
            if (get_class($workout) == "cycle") {
                $workout->setAverageWatts($userCurrentSnapshot[count($userCurrentSnapshot) - 1]);
            } elseif (get_class($workout) == "run") {
                $workout->setCaloriesBurnt($userCurrentSnapshot[count($userCurrentSnapshot) - 1], $user->getDob(), $user->getGender());
            }
        }
    }
    return $user;
}


function constructUserObject($userData, $userSnapshots, $usersMeals, $usersWorkouts, $usersGoals)
{
    $snapshotArray = array();
    $mealsArray = array();
    $workoutsArray = array();
    $goalArray = array();


    for ($i = 0; $i < count($userSnapshots); $i++) {
        $snapshotID = $userSnapshots[$i]['bodySnapshotID'];
        $date = $userSnapshots[$i]['snapshotDate'];
        $weight = $userSnapshots[$i]['userWeight'];
        $height = $userSnapshots[$i]['userHeight'];
        $bodyFatPercent = $userSnapshots[$i]['bodyFatPercent'];
        $muscleMassPercent = $userSnapshots[$i]['muscleMassPercent'];

        $snapshot = new snapshot($snapshotID, $date, $weight, $height, $bodyFatPercent, $muscleMassPercent);

        array_push($snapshotArray, $snapshot);
    }


    for ($i = 0; $i < count($usersMeals); $i++) {
        $mealID = $usersMeals[$i]['mealID'];
        $title = $usersMeals[$i]['title'];
        $date = $usersMeals[$i]['mealDate'];
        $caloriesIntake = $usersMeals[$i]['caloriesIntake'];
        $notes = $usersMeals[$i]['notes'];
        $imageName = $usersMeals[$i]['imageName'];

        $meal = new meal($mealID, $title, $date, $caloriesIntake, $notes, $imageName);

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
        $imageName = $usersWorkouts[$i]['imageName'];

        if ($type == 0) {

            $cycle = new cycle($workoutID, $title, $date, $duration, $distance, $elevation, $notes, $imageName);

            array_push($workoutsArray, $cycle);

        } elseif ($type == 1) {

            $run = new run($workoutID, $title, $date, $duration, $distance, $elevation, $notes, $imageName);

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
            $weights = new weights($workoutID, $title, $date, $duration, $notes, $imageName, $exercisesArray);

            array_push($workoutsArray, $weights);
        }
    }

    for ($i = 0; $i < count($usersGoals); $i++) {
        $goalID = $usersGoals[$i]['goalID'];
        $type = $usersGoals[$i]['goalType'];
        $title = $usersGoals[$i]['goalTitle'];
        $value = $usersGoals[$i]['goalValue'];

        $goal = new goal($goalID, $type, $title, $value);

        array_push($goalArray, $goal);
    }


    for ($i = 0; $i < count($userData); $i++) {
        $userID = $userData[$i]['userID'];
        $userName = $userData[$i]['userName'];
        $email = $userData[$i]['email'];
        $password = $userData[$i]['password'];
        $dob = $userData[$i]['dateOfBirth'];
        $gender = $userData[$i]['gender'];
    }

    return new user($userID, $userName, $email, $password, $dob, $gender, $snapshotArray, $mealsArray, $workoutsArray, $goalArray);
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

function createUserFull($userName, $email, $password, $dob, $gender)
{
    $statement = getConnection()->prepare("CALL createUserFull ('" . $userName . "','" . $email . "','" . $password . "','" . $dob . "','" . $gender . "')");
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

function getUsersSnapshots($userID)
{
    $statement = getConnection()->prepare("CALL getUsersSnapshots('" . $userID . "')");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getUsersSnapshotsByYear($userID, $year)
{
    $statement = getConnection()->prepare("CALL getUsersSnapshotsByYear('" . $userID . "','" . $year . "')");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getUsersMeals($userID)
{
    $statement = getConnection()->prepare("CALL getUsersMeals('" . $userID . "')");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getUsersMealsByYear($userID, $year)
{
    $statement = getConnection()->prepare("CALL getUsersMealsByYear('" . $userID . "', '" . $year . "')");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getUsersWorkouts($userID)
{
    $statement = getConnection()->prepare("CALL getUsersWorkouts('" . $userID . "')");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getUsersWorkoutsByYear($userID, $year)
{
    $statement = getConnection()->prepare("CALL getUsersWorkoutsByYear('" . $userID . "', '" . $year . "')");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getWorkoutExercises($workoutID)
{
    $statement = getConnection()->prepare("CALL getWorkoutExercises('" . $workoutID . "')");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getUsersGoals($userID)
{
    $statement = getConnection()->prepare("CALL getUsersGoals('" . $userID . "')");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function editUserDetails($userID, $dob, $gender)
{
    $statement = getConnection()->prepare("CALL editUserDetails ('" . $userID . "','" . $dob . "','" . $gender . "')");
    $statement->execute();
}

function editMeal($mealID, $title, $mealDate, $caloriesIntake, $notes, $imageName)
{
    $statement = getConnection()->prepare("CALL editMeal ('" . $mealID . "','" . $title . "','" . $mealDate . "','" . $caloriesIntake . "','" . $notes . "','" . $imageName . "')");
    $statement->execute();
}

function editExercise($exerciseID, $name, $sets, $reps, $weight)
{
    $statement = getConnection()->prepare("CALL editExercise ('" . $exerciseID . "','" . $name . "','" . $sets . "','" . $reps . "','" . $weight . "')");
    $statement->execute();
}

function editWorkout($workoutID, $title, $date, $duration, $distance, $elevation, $notes, $imageName)
{
    $statement = getConnection()->prepare("CALL editWorkout ('" . $workoutID . "','" . $title . "','" . $date . "','" . $duration . "','" . $distance . "','" . $elevation . "','" . $notes . "','" . $imageName . "')");
    $statement->execute();
}

function editGoal($goalID, $value)
{
    $statement = getConnection()->prepare("CALL editGoal ('" . $goalID . "','" . $value . "')");
    $statement->execute();
}


function deleteUserDetails($userID)
{
    $statement = getConnection()->prepare("CALL deleteUserDetails ('" . $userID . "')");
    $statement->execute();
}


function deleteSnapshot($userID)
{
    $statement = getConnection()->prepare("CALL deleteSnapshot ('" . $userID . "')");
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

function deleteExercise($exerciseID)
{
    $statement = getConnection()->prepare("CALL deleteExercise ('" . $exerciseID . "')");
    $statement->execute();
}

function deleteGoal($goalID)
{
    $statement = getConnection()->prepare("CALL deleteGoal ('" . $goalID . "')");
    $statement->execute();
}

function createSnapshot($userID, $date, $weight, $height, $BFP, $MMP)
{
    $statement = getConnection()->prepare("CALL createSnapshot ('" . $userID . "','" . $date . "','" . $weight . "','" . $height . "','" . $BFP . "','" . $MMP . "')");
    $statement->execute();
}

function createMeal($userID, $title, $mealDate, $caloriesIntake, $notes, $imageName)
{
    $statement = getConnection()->prepare("CALL createMeal ('" . $userID . "','" . $title . "','" . $mealDate . "','" . $caloriesIntake . "','" . $notes . "','" . $imageName . "')");
    $statement->execute();
}

function createExercise($workoutID, $name, $sets, $reps, $weight)
{
    $statement = getConnection()->prepare("CALL createExercise ('" . $workoutID . "','" . $name . "','" . $sets . "','" . $reps . "','" . $weight . "')");
    $statement->execute();
}

function createWorkout($userID, $type, $title, $date, $duration, $distance, $elevation, $notes, $imageName)
{
    $statement = getConnection()->prepare("CALL createWorkout ('" . $userID . "','" . $type . "','" . $title . "','" . $date . "','" . $duration . "','" . $distance . "','" . $elevation . "','" . $notes . "','" . $imageName . "')");
    $statement->execute();
}

function createGoal($userID, $type, $title, $value)
{
    $statement = getConnection()->prepare("CALL createGoal ('" . $userID . "','" . $type . "','" . $title . "','" . $value . "')");
    $statement->execute();
}
