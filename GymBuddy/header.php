<?php


session_start();


?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
      crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>

<div class="navbar navbar-expand-lg navbar-dark bg-dark">
        <nav>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             Workouts
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Cycle</a>
                            <a class="dropdown-item" href="#">Run</a>
                            <a class="dropdown-item" href="#">Weights</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Meals</a>
                    </li>
                    <?php
                        if(isset($_SESSION['userID'])){
                            echo '<li class="nav-item"><a class="nav-link" href="personalDetailsPage.php">Personal details</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="logOut.php">Log out</a></li>';
                        }else{
                            echo '<li class="nav-item"><a class="nav-link" href="createUserPage.php">Sign up</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="logInPage.php">Login</a></li>';
                        }
                    ?>
                </ul>

            </div>
        </nav>
    </div>