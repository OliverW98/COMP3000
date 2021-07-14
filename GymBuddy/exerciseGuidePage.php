<?php
include $_SERVER['DOCUMENT_ROOT'] . "/COMP3000/GymBuddy/src/DBFunctions.php";
include_once 'header.php';

$outputPara = "";

function displayChestExercises()
{
    echo '<div class="row">';
    echo '<div class="col-sm-5">';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Barbell Bench Press</h5>';
    echo ' <p class="card-text">Grip the bar with hands just wider than shoulder-width apart, so when
                        you’re at
                        the bottom of your move
                        your hands are directly above your elbows. This allows for maximum force generation. Bring
                        the
                        bar
                        slowly down to your chest as you breathe in. Push up as you breathe out, gripping the bar
                        hard
                        and
                        watching a spot on the ceiling rather than the bar, so you can ensure it travels the same
                        path
                        every
                        time.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/E3irczshX1TAyUZyuR" width="270" height="480" frameBorder="0"
                        class="giphy-embed card-img-bottom " allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Dumbbell Bench Press</h5>';
    echo ' <p class="card-text">Grip each dumbbell firmly and then squeeze your shoulder blades together. From there, kick one knee
                up to
                drive a dumbbell to your shoulder. Then, drive the other knee up. Once your back is on the bench,
                you
                want to squeeze your shoulder blades together. Also, make sure your
                feet are actively pressing into the floor. The elbows should be directly underneath the wrist, as
                this
                will help keep the shoulder joint in proper positioning. Keep your elbows pointed at 45 degrees, and
                begin to lower the weight. Avoid letting your arms waver from your pressing path. Once your back is
                tight and the weight is sitting at chest level, drive the dumbbells up over your chest.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/KrTebEJXOMVWq1BMtP" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Incline Bench Press</h5>';
    echo ' <p class="card-text">Lie flat on an incline bench and set your hands just outside of shoulder width. Set your shoulder
                blades
                by pinching them together and driving them into the bench. Take a deep breath and allow your spotter
                to
                help you with the lift off in order to maintain tightness through your upper back. Let the weight
                settle
                and ensure your upper back remains tight after lift off. Inhale and allow the bar to descend slowly
                by
                unlocking the elbows. Lower the bar in a straight line to the base of the sternum (breastbone) and
                touch
                the chest. Push the bar back up in a straight line by pressing yourself into the bench, driving your
                feet into the floor for leg drive, and extending the elbows.</p>';
    echo '</div>';
    echo '            <iframe src="https://giphy.com/embed/dHbPVgJNHLzhOBq1aX" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '</div>';
    echo '<div class="col-sm-5">';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Decline Press</h5>';
    echo ' <p class="card-text">Apply a grip that suits you best (Preference is key, but most apply a medium width), whilst keeping
                your
                body straight and controlled, un rack the barbell and position the bar just above your chest. Whilst
                inhaling a deep breath, gradually lower the bar down until it touches your chest. Pause for a brief
                second and let the fibres stretch across the chest. Once the pause has occurred, exhale your breath
                and
                return the bar back to where it started. Throughout this phase of the movement, all the tension
                should
                be via your pectorals, with the triceps being the assistance.</p>';
    echo '</div>';
    echo '            <iframe src="https://giphy.com/embed/dHbPVgJNHLzhOBq1aX" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Machine Chest Press</h5>';
    echo ' <p class="card-text">Sit comfortably on the machine with your feet placed firmly on the floor about shoulder-width apart.
                Grasp the handles with a full grip, thumb circled around the handle, and maintain a neutral wrist
                position with your wrists in line with your forearms. Push the bars outward to full extension but
                without locking out the elbow, exhaling as you press out. Pause briefly at full extension, then
                allow
                the bars to return toward your chest and breathe in during this recovery.</p>';
    echo '</div>';
    echo '            <iframe src="https://giphy.com/embed/dHbPVgJNHLzhOBq1aX" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Chest Fly</h5>';
    echo ' <p class="card-text">Lie with your head and shoulders supported by the bench and your feet flat on the floor. Hold the
                dumbbells directly above your chest, palms facing each other, then lower the weights in an arc out
                to
                the sides as far as is comfortable. Use your pectoral muscles to reverse the movement back to the
                start.
                Keep a slight bend in your elbows throughout and don’t arch your back.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/DsWAL5lkEBh7SjA83j" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exercise Guide</title>
</head>
<body>
<div class="container">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="row">
            <div class="col"></div>
            <div class="col-sm-5">
                <div class="input-group mb-3 mt-5">
                    <div class="input-group-prepend">
                        <label class="input-group-text text-light bg-dark" for="nameInput">Muscle Group</label>
                    </div>
                    <select class="form-control" name="selMuscleGroup" type="text">
                        <option>Choose Muscle Group...</option>
                        <option>Chest</option>
                        <option>Legs</option>
                        <option>Back</option>
                        <option>Arms</option>
                        <option>Shoulders</option>
                        <option>Core</option>
                    </select>
                    <div class="input-group-append">
                        <input class="btn btn-Primary" name="btnSelect" type="submit" value="Select">
                    </div>
                </div>
                <p class="text-center text-danger"><?php echo $outputPara ?></p>
            </div>
            <div class="col"></div>
        </div>
    </form>

    <?php

    if (isset($_POST['btnSelect'])) {
        if ($_POST['selMuscleGroup'] === "Choose Muscle Group...") {
            $outputPara = "You must choose a muscle group";
        } elseif ($_POST['selMuscleGroup'] === "Chest") {
            displayChestExercises();
        } elseif ($_POST['selMuscleGroup'] === "Legs") {
            $_SESSION['muscleGroup'] = $_POST['selMuscleGroup'];
        } elseif ($_POST['selMuscleGroup'] === "Back") {
            $_SESSION['muscleGroup'] = $_POST['selMuscleGroup'];
        } elseif ($_POST['selMuscleGroup'] === "Arms") {
            $_SESSION['muscleGroup'] = $_POST['selMuscleGroup'];
        } elseif ($_POST['selMuscleGroup'] === "Shoulders") {
            $_SESSION['muscleGroup'] = $_POST['selMuscleGroup'];
        } elseif ($_POST['selMuscleGroup'] === "Core") {
            $_SESSION['muscleGroup'] = $_POST['selMuscleGroup'];
        }
    }

    ?>

</div>
</body>
</html>