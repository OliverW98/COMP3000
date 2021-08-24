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
                        class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
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

function displayLegExercises()
{
    echo '<div class="row">';
    echo '<div class="col-sm-5">';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Squat</h5>';
    echo ' <p class="card-text">Take the bar out of the rack with it resting on your rear shoulder muscles. Take two big steps back
                and
                stand with your feet roughly shoulder-width apart, toes pointing slightly out. Keep your spine in
                alignment by looking at a spot on the floor about two metres in front of you, then “sit” back and
                down
                as if you’re aiming for a chair. Descend until your hip crease is below your knee. Keep your weight
                on
                your heels as you drive back up.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/vbC2hOH9xALHDA4LDQ" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Lunges</h5>';
    echo ' <p class="card-text">Stand tall with feet hip-width apart. Engage your core. Take a big step forward with right leg. Start
                to
                shift your weight forward so heel hits the floor first. Lower your body until right thigh is
                parallel to
                the floor and right shin is vertical. Press into right heel to drive back up to starting
                position.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/xVY5yNsqIG4Sn6GrD8" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Leg Extension</h5>';
    echo ' <p class="card-text">Lift the weight while exhaling until your legs are almost straight. Do not lock your knees. Keep your
                back against the backrest and do not arch your back. Exhale and lower the weight back to starting
                position.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/pLX6ectTsgRRFqlR1h" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '</div>';
    echo '<div class="col-sm-5">';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Romanian Deadlift</h5>';
    echo ' <p class="card-text">To start the move, stand with the bar or weight in your hands as opposed to the floor. Slowly lower
                the
                weight with a slight bend in your knees, bending at the hips and keeping your back straight. Lower
                until
                you feel a slight stretch in your hamstrings – usually when the weight has just passed your knees –
                then
                drive your hips forwards and use your hamstrings to power back up to standing.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/1piTkJcjERDlii1YBd" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Goblet Squat</h5>';
    echo ' <p class="card-text">Stand with your feet slightly wider than hip-distance apart, your toes angled slightly outward. Hold
                a
                kettlebell in both hands at your chest. Engage your core and look straight ahead. Press your hips
                back
                and begin bending your knees to perform the squat. Inhale as you perform this downward phase. Check
                your
                position at the bottom of the squat—your elbows should be positioned on the inside of either knee at
                the
                lowest point of the squat. Press through your heels and reverse the motion to return to the starting
                position. Exhale as you rise.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/FU4Lrp79KXq361zkJx" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Hip Thruster</h5>';
    echo ' <p class="card-text">Start seated on the floor, knees bent, feet slightly wider than hip-distance apart. The toes can be
                turned out just slightly. The upper back (lower scapula) should be resting against the edge of the
                weight bench in the center of the bench. Place the weight bar across the hips. Squeeze the glutes
                and
                press the bar straight up until the hips are in line with the shoulders and the knees. Slowly lower
                the
                bar down until the hips are just a few inches off the floor. Squeeze the glutes and lift again.</p>';
    echo '</div>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Single Leg Curl</h5>';
    echo ' <p class="card-text">Start seated on the floor, knees bent, feet slightly wider than hip-distance apart. The toes can be
                turned out just slightly. The upper back (lower scapula) should be resting against the edge of the
                weight bench in the center of the bench. Place the weight bar across the hips. Squeeze the glutes
                and
                press the bar straight up until the hips are in line with the shoulders and the knees. Slowly lower
                the
                bar down until the hips are just a few inches off the floor. Squeeze the glutes and lift again.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/hukR0o9mEdgLEFuB6v" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

function displayBackExercises()
{
    echo '<div class="row">';
    echo '<div class="col-sm-5">';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Deadlift</h5>';
    echo ' <p class="card-text">To get into starting position, make sure to stand up right against the bar, lower your hips to reach
                the
                bar. Your hand should be slightly wider than the width of your shoulder. Once you’ve got a hold of
                the
                bar, push your hips back to the point where you feel tension in your hamstrings. Brace your abs and
                maintain a tall spine. Engage your lats and keep your chest proud throughout the whole movement.
                Lift
                the bar smoothly off the floor by extending your knees until you are standing in upright position,
                whilst keeping your abs tight, shoulders engaged and the bar close to your body. Exhale as you reach
                the
                top and squeeze your glutes. Slowly lower the bar back to the floor.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/ayt3lZxRcrjQdPxIq5" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Row</h5>';
    echo ' <p class="card-text">Begin by having your arms completely outstretched as this move targets the lats and this position best engages the area. Keep your head, back and spine neutrally aligned, with your chest elevated and core engaged. With a small bend in your knees, pull the attachment in towards your body to just below the naval, initiating the move by driving your elbows towards your hips, keeping the elbows in. As the attachment reaches your torso, squeeze your lats and shoulder blades, holding the contraction for 1-2sec. Reverse to the start.</p>';
    echo '</div>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Barbell Bent-Over Row</h5>';
    echo ' <p class="card-text">Bend the knees slightly and bring the torso forward over a bar, whilst keeping the back straight.
                Grasp
                the bar with an overhand grip. Keep the upper body stationary and pull the barbell to the torso and
                pause. Return bar under control to the starting position and repeat.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/x0x77jWTfKiiiTxaed" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '</div>';
    echo '<div class="col-sm-5">';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Dumbbell Single-arm Row</h5>';
    echo ' <p class="card-text">Bring the dumbbell up to your chest, concentrating on lifting it with your back and shoulder muscles
                rather than your arms. Keep your chest still as you lift. At the top of the movement, squeeze your
                shoulder and back muscles. Lower the dumbbell slowly until your arm is fully extended again. Do all
                your
                reps on one arm before switching to the other side.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/W6GmnJJimka2hRLBMz" width="270" height="480" frameBorder="0"
                    class="giphy-embed" allowFullScreen></iframe>';
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
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Chest-supported Dumbbell Row</h5>';
    echo ' <p class="card-text">Set an incline bench at 45 degrees. Approach the bench with your chest toward the angled pad, then
                lean
                onto it. Plant your feet firmly on the floor, and let your arms hang straight down, palms facing
                each
                other. This is the starting position. Squeeze your shoulder blades together and drive your elbows
                toward
                the ceiling, bringing the dumbbells to your ribcage. Then slowly reverse the move.</p>';
    echo '</div>';
    echo '</div>';
    echo '<div class="col-sm-5">';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Kettlebell Swings</h5>';
    echo ' <p class="card-text">Start with the kettlebell on the floor slightly in front of you and between your feet, which should
                be
                shoulder-width apart. Bending slightly at the knees but hingeing mainly at the hips, grasp the
                kettlebell and pull it back between your legs to create momentum. Drive your hips forwards and
                straighten your back to send the kettlebell up to shoulder height. Let the bell return back between
                your
                legs and repeat the move.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/DpCbUDiEx4gmtx3UMB" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

function displayArmExercises()
{
    echo '<div class="row">';
    echo '<div class="col-sm-5">';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Incline Bicep Curl</h5>';
    echo ' <p class="card-text">Sit down against the workout bench, keeping your back straight and your abdominal muscles tight. lift
                each dumbbell, palms up, toward your shoulders. It’s important to keep your upper arms tight so that
                you
                can isolate the biceps brachii muscle as you move your lower arms only. Slowly lower the dumbbells
                back
                down to your starting position.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/zqCuEtBzMyAcHa103b" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Concentration Curl</h5>';
    echo ' <p class="card-text">Slowly curl the weight up, only moving your forearms – the position of your upper arm on your thigh
                will
                help you keep it still during the exercise. At the top of the move, pause for a beat and squeeze
                your
                biceps, then slowly lower the weight back to the start.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/PdSlIWNLHLs1G3hWze" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Close-grip Bench Press</h5>';
    echo ' <p class="card-text">Lie flat on the bench using a close grip (about shoulder width). Inhale and slowly bring the bar down
                toward your chest keeping elbows close to your body for the entire exercise. Exhale and push the bar
                up
                using the triceps muscles and locking arms at the top of the movement.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/sMKLVslu3EGTS5WRSP" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Barbell Palms-up Wrist Curl</h5>';
    echo ' <p class="card-text">Use your arms to grab the barbell with a supinated grip (palms up) and bring them up so that your
                forearms are resting against the flat bench. Your wrists should be hanging over the edge. Start out
                by
                curling your wrist upwards and exhaling. Slowly lower your wrists back down to the starting position
                while inhaling.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/mhyNUJwveiaa5SYLU0" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Barbell Palms-down Wrist Curl</h5>';
    echo ' <p class="card-text">Use your arms to grab the barbell with a pronated grip (palms down) and bring them up so that your
                forearms are resting against the flat bench. Your wrists should be hanging over the edge. Start out
                by
                curling your wrist upwards and exhaling. Slowly lower your wrists back down to the starting position
                while inhaling.</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="col-sm-5">';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Twisting Dumbbell Curl</h5>';
    echo ' <p class="card-text">Your arms should be slightly bent and your palms facing in towards your body. Curl the dumbbell up.
                As
                you curl up rotate the dumbbell from a neutral position (palms facing in) to an underhand position
                (palms facing up). Squeeze your bicep at the top of the movement, and then slowly lower the weight
                back
                down without letting it touch your body.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/jB70QNuiO7oVVNzFOe" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Reverse Curl Straight Bar</h5>';
    echo ' <p class="card-text">Stand with hands and feet shoulder-width apart. Grip the barbell palms facing down while keeping your
                body straight and chest lifted. Holding the upper arms stationary, exhale and lift the bar toward
                your
                shoulders bending at the elbows. Continue to curl the bar toward your shoulders until you feel a
                complete biceps contraction. Slowly lower the bar with control to the start position.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/XVD8BL31jLTKjYnt0Q" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">One Arm Tricep Extension</h5>';
    echo ' <p class="card-text">Lift the dumbbell up so that it is at shoulder height and then extend your arm up over your head.
                Your
                entire arm should be perpendicular to the floor. The dumbbell should be over your head. Your other
                hand
                can be extended out the the side, held by your waist or can support the arm that has the dumbbell.
                urn
                your wrist until the palm of your hand is facing forward and your pinkie is facing the ceiling. This
                is
                the starting position. Bring the dumbbell behind your head slowly as you hold your upper arm
                stationary.
                Inhale as you do so, and stop for a second when your triceps are fully extended. Flex your triceps
                and
                return to the starting position.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/KQtfMPk9m5ms3NDQWX" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Skullcrusher</h5>';
    echo ' <p class="card-text">Hold the dumbbell with both hands above your chest. Move the weight down toward the rear of your head
                by
                flexing your elbows while exhaling. Continue lowering the weight behind the head until the dumbbell
                head
                is about in line with the bench top, or even a little higher. Reverse the movement until the weight
                is
                held above the chest in the starting position again.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/qElZRzo7uhmG1ML8PZ" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

function displayShoulderExercises()
{
    echo '<div class="row">';
    echo '<div class="col-sm-5">';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Barbell Standing Press</h5>';
    echo ' <p class="card-text">Set your hands on the barbell so that they’re sightly wider than shoulder width apart. Set your feet
                are
                roughly shoulder-width apart. Before initiating the press, contract the lats, brace the abs, and
                tuck
                the chin. Press the barbell by keeping it positioned in the meat of the hands and driving it
                directly
                overhead. Lower the bar back down to the starting position with control.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/6kPOPuz76CuqRjLSIj" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Arnold Press</h5>';
    echo ' <p class="card-text">Position the end of the dumbbells on your knees and sit down on the bench. Kick your knees up one at
                a
                time in order to get each dumbbell into place. Once the dumbbells are in place, rotate your palms so
                they are facing you. Take a deep breath then press the dumbbells overhead by extending the elbows
                and
                contracting the deltoids. As you press, rotate the dumbbells until your palms are facing forward.
                Slowly
                lower the dumbbells back to the starting position.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/mHKEPoovTpo5ZA6VkC" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Seated Dumbbell Press</h5>';
    echo ' <p class="card-text">Position the end of the dumbbells on your knees and sit down on the bench. Kick your knees up one at
                a
                time in order to get each dumbbell into place. Once the dumbbells are in place, rotate your palms so
                they are facing forward. Take a deep breath then press the dumbbells overhead by extending the
                elbows
                and contracting the deltoids. Slowly lower the dumbbells back to the starting position.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/rhf3a47EHgK5wf7Q0m" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '</div>';
    echo '<div class="col-sm-5">';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Lateral Raise</h5>';
    echo ' <p class="card-text">Keep your back straight, brace your core, and then slowly lift the weights out to the side until your
                arms are parallel with the floor, with the elbow slightly bent. Then lower them back down, again in
                measured fashion.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/aq8ulHsgAYfQ0i3p7R" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Upright Row</h5>';
    echo ' <p class="card-text">Using an overhand grip with hands shoulder-width apart. Keeping your chest up and your abs braced,
                raise
                the bar or weights to your shoulders, leading with your elbows. Keep the lifting stage smooth to
                avoid
                excess strain on your wrists, elbows or shoulder joint. Pause in this top position, focusing on
                squeezing your traps as hard as possible, then slowly lower the weight back to the start
                position.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/gLFqaTDHGUgMFHsuB7" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Kettlebell Single-Arm Press</h5>';
    echo ' <p class="card-text">Tuck your elbow close to your side so that your forearm is vertical and the weight is in front of
                your
                chest. This is called the rack position, and every rep begins from here. You can extend your
                opposite
                arm out to your side to help you balance. Press the kettlebell overhead, maintaining your shoulder
                position as you do so. As you press, allow your elbow to move away from your body and your arm to go
                upward in an arcing motion.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/xrA1sWoIFc3aiohyCq" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="col-sm-5">';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Front Raises</h5>';
    echo ' <p class="card-text">Begin by holding both dumbbells of equal weight in front of your thighs with your palms facing your
                body. Keeping your back straight and feet shoulder-width apart, lift the dumbbells in front of you
                in a
                controlled manner until your hands are in line with your shoulders. Pause, then slowly lower back to
                the
                starting position.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/M6MZfhiKwG1p6RDvG3" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="col-sm-5">';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Military Press</h5>';
    echo ' <p class="card-text">Grab the bar with hands slightly wider than shoulder-width, palms facing forwards. tand with your
                feet
                together, like a soldier on parade and squeeze your glutes and core muscles hard to give you a solid
                base to press from. With the bar level with your chin, make sure your elbows are pointing forwards
                rather than flaring out to your sides. Take a sharp breath in, tense your glutes and torso, and
                drive
                the bar straight up, breathing out as you press. Lower the bar under control to chin level.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/KRt2HrDHtz41xWHxgT" width="270" height="480" frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

function displayCoreExercises()
{
    echo '<div class="row">';
    echo '<div class="col-sm-5">';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Plank</h5>';
    echo ' <p class="card-text">Forearms on the floor with elbows aligned below shoulders and arms parallel to your body at about
                shoulder width. Ground toes into the floor and squeeze glutes to stabilize your body. Your legs
                should
                be working.
                Neutralize your neck and spine by looking at a spot on the floor about a foot beyond your hands.
                Your
                head should be in line with your back.</p>';
    echo '</div>';
    echo '<img src="../Images/IMG_5335.jpg" width="350" height="280">';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Butterfly Sit-up</h5>';
    echo ' <p class="card-text">Lie faceup on the floor with your arms extended past your head, your knees bent, and the soles of
                your
                feet facing one another. In one fluid movement, raise your torso to a sitting position as your reach
                forward with both hands to touch your ankles. Slowly lower your torso back to the starting
                position.</p>';
    echo '</div>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Dead Bug</h5>';
    echo ' <p class="card-text">Lie flat on your back with your arms extended towards the ceiling. Then lift your legs and bend your
                knees at 90° so your lower legs are parallel with the floor. Slowly lower your right arm behind your
                head and extend your left leg forwards at the same time, exhaling as you go. Keep going until your
                arm
                and leg are just above the floor, being careful not to raise your back off the floor. Then, as you
                inhale, slowly return to the starting position and repeat with the opposite limbs.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/WwhkEh0a2KcysFLmUO"  frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '</div>';
    echo '<div class="col-sm-5">';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Flutter kicks</h5>';
    echo ' <p class="card-text">Lie on your back and extend your legs up to a 45-degree angle. Keep your arms straight and in line
                with
                the floor, palms facing down. Lift your head, neck and shoulders slightly off the ground. Keeping
                your
                legs stick straight and glued together with your toes pointed, start lowering one leg. Raise your
                lowered
                leg and lower the other, focusing on keeping your core engaged.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/UZhxOF2HYWyrdbcwAu"  frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Leg raise</h5>';
    echo ' <p class="card-text">Lay flat with your arms at your sides and legs stretched out next to each other, then raise those
                legs.
                Even if you can’t hold them perfectly rigid, keep your legs as straight as possible, and lift them
                until
                they are pointing at the ceiling, or as near as you can get. Make sure your toes are pointed. Then
                lower
                them back down, being careful to keep your movements measured.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/lT1iqykdYRcmhNy3zm"  frameBorder="0"
                    class="giphy-embed card-img-bottom" allowFullScreen></iframe>';
    echo '</div>';
    echo '<div class="card mt-3 mx-auto border-dark" style="width: 25rem;">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Bird-dog</h5>';
    echo ' <p class="card-text">Kneel with knees hip-width apart and hands firmly on the ground about shoulder-width apart. point the
                arm
                out straight in front and extend the opposite leg behind you. You should form one straight line from
                your hand to your foot, keeping hips squared to the ground. If your low back begins to sag, raise
                your
                leg only as high as you can while keeping your back straight. Hold for a few seconds, then return
                your
                hands and knees. Switch to the other side.</p>';
    echo '</div>';
    echo '<iframe src="https://giphy.com/embed/SSNo6fdE5MIoyc8XQW"  frameBorder="0"
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
        <h1 class="text-center mt-3">Exercise Guide</h1>
        <p class="text-center mt-3">Select a muscle group for which you would like to see example exercises
            for. </p>
        <div class="row">
            <div class="col"></div>
            <div class="col-sm-5">
                <div class="input-group mb-3 mt-3">
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
                        <input class="btn btn-success" name="btnSelect" type="submit" value="Select">
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
            displayLegExercises();
        } elseif ($_POST['selMuscleGroup'] === "Back") {
            displayBackExercises();
        } elseif ($_POST['selMuscleGroup'] === "Arms") {
            displayArmExercises();
        } elseif ($_POST['selMuscleGroup'] === "Shoulders") {
            displayShoulderExercises();
        } elseif ($_POST['selMuscleGroup'] === "Core") {
            displayCoreExercises();
        }
    }

    ?>

</div>
</body>
</html>