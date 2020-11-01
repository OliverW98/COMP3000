<?php

include_once ('user.php');

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


   return $user = constructUserObject($userData);
}

function constructUserObject($userData){

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

    var_dump($userData);
    var_dump($userID);

    return $user = new user($userID,$userName,$email,$password,$userWeight,$userHeight,$dob,$gender);
}


function checkIfUserExists($userName, $email){
   $result = getConnection()->query("select userID from users where userName = '". $userName."' or email = '".$email."' ");
    if($result->rowCount() == 0){
        return false;
    } else{
        return true;
    }
}

function createUserHalf($userName, $email, $password)
{
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

    $_SESSION['userID'] = $result[0]['userID'];

    var_dump($_SESSION['userID']);

}

function getUserDetails($userID){

    $statement = getConnection()->prepare("CALL GetUserDetails('" . $userID . "')");
    $statement->execute();
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $data;

}