<?php


class run extends workout
{
    private $distance;
    private $elevation;
    private $speed;
    private $caloriesBurnt;

    public function __construct($id, $title, $date, $duration, $distance, $elevation, $notes, $imageName)
    {
        $this->workoutID = $id;
        $this->title = $title;
        $this->date = $date;
        $this->duration = $duration;
        $this->distance = $distance;
        $this->elevation = $elevation;
        $this->notes = $notes;
        $this->imageName = $imageName;
        $this->setSpeed();
    }

    /**
     * @return mixed
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @return mixed
     */
    public function getElevation()
    {
        return $this->elevation;
    }

    /**
     * @return mixed
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * @param mixed $speed
     * This is meters per second
     */
    private function setSpeed()
    {
        $this->speed = ($this->distance / ($this->duration * 60));
    }

    /**
     * @return mixed
     */
    public function getCaloriesBurnt()
    {
        return $this->caloriesBurnt;
    }

    /**
     * @param mixed $caloriesBurnt
     */
    public function setCaloriesBurnt($user, $dob, $gender)
    {
        $this->caloriesBurnt = $this->BMR($user, $dob, $gender) * ($this->Mets() * ($this->getDuration() / 60)) / 24;
    }

    private function BMR($user, $dob, $gender)
    {
        if ($gender == "Male") {
            return 66.47 + (13.75 * $user->getWeight()) + (5.003 * $user->getHeight()) - (6.755 * $this->age($dob));
        } else {
            return 655.1 + (9.563 * $user->getWeight()) + (1.85 * $user->getHeight()) - (4.676 * $this->age($dob));
        }
    }

    private function Mets()
    {
        $speed = ($this->speed * 3.6);
        if ($speed <= 6.4) {
            return 6;
        } elseif ($speed >= 6.4 && $speed <= 8.0) {
            return 6;
        } elseif ($speed >= 8.0 && $speed <= 8.4) {
            return 8.3;
        } elseif ($speed >= 8.4 && $speed <= 9.7) {
            return 9;
        } elseif ($speed >= 9.7 && $speed <= 10.8) {
            return 9.8;
        } elseif ($speed >= 10.8 && $speed <= 11.3) {
            return 10.5;
        } elseif ($speed >= 11.3 && $speed <= 12.1) {
            return 11;
        } elseif ($speed >= 12.1 && $speed <= 12.9) {
            return 11.5;
        } elseif ($speed >= 12.9 && $speed <= 13.8) {
            return 11.8;
        } elseif ($speed >= 13.8 && $speed <= 14.5) {
            return 12.3;
        } elseif ($speed >= 14.5 && $speed <= 16.1) {
            return 12.8;
        } elseif ($speed >= 16.1 && $speed <= 17.7) {
            return 14.5;
        } elseif ($speed >= 17.7 && $speed <= 19.3) {
            return 16;
        } elseif ($speed >= 19.3 && $speed <= 20.9) {
            return 19;
        } elseif ($speed >= 20.9 && $speed <= 22.5) {
            return 19.9;
        } elseif ($speed >= 22.5) {
            return 23;
        }
    }


    private function age($dob)
    {
        $dob = new DateTime($dob);
        $birthDate = "{$dob->format('m/d/Y')}";

        $birthDate = explode("/", $birthDate);
        //get age from date or birthdate
        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
            ? ((date("Y") - $birthDate[2]) - 1)
            : (date("Y") - $birthDate[2]));
        return $age;
    }

}