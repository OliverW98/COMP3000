<?php

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