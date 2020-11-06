<?php


class weights
{

    private $weightsID;
    private $title;
    private $date;
    private $duration;
    private $notes;
    private $caloriesBurnt;
    private $exercises;

    public function __construct($id, $title , $date , $duration ,$notes){
        $this->weightsID = $id;
        $this->title=$title;
        $this->date = $date;
        $this->duration = $duration;
        $this->notes = $notes;
        $this->exercises = array();
    }

    /**
     * @return mixed
     */
    public function getWeightsID()
    {
        return $this->weightsID;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @return array
     */
    public function getExercises()
    {
        return $this->exercises;
    }

    public function addExercise($exercise){
       array_push($this->exercises, $exercise);
    }

}