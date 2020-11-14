<?php


class run extends workout
{
    private $distance;
    private $elevation;
    private $speed;
    private $caloriesBurnt;

    public function __construct($id, $title , $date , $duration,$distance, $elevation ,$notes){
        $this->workoutID = $id;
        $this->title=$title;
        $this->date = $date;
        $this->duration = $duration;
        $this->distance = $distance;
        $this->elevation = $elevation;
        $this->notes = $notes;
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
     * @return mixed
     */
    public function getCaloriesBurnt()
    {
        return $this->caloriesBurnt;
    }
}