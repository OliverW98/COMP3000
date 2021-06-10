<?php


class weights extends workout
{
    private $exercises;

    public function __construct($id, $title, $date, $duration, $notes, $exercises)
    {
        $this->workoutID = $id;
        $this->title = $title;
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

    public function addExercise($exercise)
    {
        array_push($this->exercises, $exercise);
    }

    /**
     * @param array $exercises
     */
    public function setExercises($exercises)
    {
        $this->exercises = $exercises;
    }
}