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
                    <a class="nav-link" href="home.php"><b>GymBuddy</b><span class="sr-only">(current)</span></a>
                </li>
                <?php
                if (isset($_SESSION['userID'])) {
                    echo '<li class="nav-item dropdown">';
                    echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    echo 'Cardio';
                    echo '</a>';
                    echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    echo '<a class="dropdown-item" href="createCardioWorkoutPage.php">Record Cardio</a>';
                    echo '<a class="dropdown-item" href="viewCycleData.php">Cycle Stats</a>';
                    echo '<a class="dropdown-item" href="viewRunData.php">Run Stats</a>';
                    echo '</div>';
                    echo '</li>';
                    echo '<li class="nav-item dropdown">';
                    echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    echo 'Weights';
                    echo '</a>';
                    echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    echo '<a class="dropdown-item" href="createWeightsWorkoutPage.php">Record Weights</a>';
                    echo '<a class="dropdown-item" href="viewWeightsWorkoutData.php">Weights Stats</a>';
                    echo '<a class="dropdown-item" href="exerciseGuidePage.php">Weights Guide</a>';
                    echo '</div>';
                    echo '</li>';
                    echo '<li class="nav-item dropdown">';
                    echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    echo 'Meals';
                    echo '</a>';
                    echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    echo '<a class="dropdown-item" href="createMealPage.php">Record Meal</a>';
                    echo '</div>';
                    echo '</li>';
                    echo '<li class="nav-item dropdown">';
                    echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    echo 'Snapshots';
                    echo '</a>';
                    echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    echo '<a class="dropdown-item" href="viewBodySnapshots.php">View Snapshot</a>';
                    echo '</div>';
                    echo '</li>';
                    echo '<li class="nav-item dropdown">';
                    echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    echo 'Goals';
                    echo '</a>';
                    echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    echo '<a class="dropdown-item" href="viewGoals.php">My Goals</a>';
                    echo '<a class="dropdown-item" href="viewCyclingGoal.php">Cycling Goals</a>';
                    echo '</div>';
                    echo '</li>';
                    echo '<li class="nav-item"><a class="nav-link" href="personalDetailsPage.php">Personal Details</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="logOut.php">Log Out</a></li>';
                } else {
                    echo '<li class="nav-item navbar-right"><a class="nav-link" href="createUserPage.php">Sign Up</a></li>';
                    echo '<li class="nav-item navbar-right" ><a class="nav-link" href="logInPage.php">Log In</a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>
</div>