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

if(getConnection() != null){
    var_dump("connected");
}
?>