<?php


class cycle extends workout
{

    private $distance;
    private $elevation;
    private $speed;
    private $averageWatts;
    private $caloriesBurnt;

    public function __construct($id, $title, $date, $duration, $distance, $elevation, $notes)
    {
        $this->workoutID = $id;
        $this->title = $title;
        $this->date = $date;
        $this->duration = $duration;
        $this->distance = $distance;
        $this->elevation = $elevation;
        $this->notes = $notes;
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
    public function getAverageWatts()
    {
        return $this->averageWatts;
    }

    /**
     * @param mixed $averageWatts
     */
    public function setAverageWatts($user)
    {
        $this->averageWatts = round((($this->Fg($user) + $this->Fr($user) + $this->Fa()) * $this->speed) / (1 - 0.04), 2);
        $this->setCaloriesBurnt();
    }

    private function Fg($user)
    {
        $g = 9.81;
        return $g * sin(atan($this->gradient())) * $user->getWeight();
    }

    private function Fr($user)
    {
        $g = 9.81;
        $Crr = 0.005;
        return $g * cos(atan($this->gradient())) * $user->getWeight() * $Crr;
    }

    private function Fa()
    {
        $CdA = 0.408;
        $p = 1.2041;
        return 0.5 * $CdA * $p * pow($this->speed, 2);
    }

    private function gradient()
    {
        return ($this->elevation / $this->distance);
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
    public function setCaloriesBurnt()
    {

        $this->caloriesBurnt = round(($this->averageWatts * ($this->duration * 60) / 4180) / 0.24);
    }
}