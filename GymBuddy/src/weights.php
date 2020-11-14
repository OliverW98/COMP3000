<?php


class weights extends workout
{
    private $caloriesBurnt;
    private $exercises = array();

    public function __construct($id, $title , $date , $duration ,$notes, $exercises ){
        $this->workoutID = $id;
        $this->title=$title;
        $this->date = $date;
        $this->duration = $duration;
        $this->notes = $notes;
        $this->exercises = $exercises;
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