<?php

include "header.php";

//creating a weight workout
unset($_SESSION['tempExerciseArray']);
unset($_SESSION['titleInput']);
unset($_SESSION['dateInput']);
unset($_SESSION['durationInput']);
unset($_SESSION['notesInput']);

//creating a user
unset($_SESSION['userName']);
unset($_SESSION['email']);
unset($_SESSION['password']);
unset($_SESSION['userName']);
unset($_SESSION['email']);
unset($_SESSION['password']);
unset($_SESSION['weight']);
unset($_SESSION['height']);
unset($_SESSION['BFP']);
unset($_SESSION['MMP']);
unset($_SESSION['dob']);
unset($_SESSION['gender']);
header("Location: index.php");
?>