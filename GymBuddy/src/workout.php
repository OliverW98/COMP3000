<?php


class workout
{
    protected $workoutID;
    protected $title;
    protected $date;
    protected $duration;
    protected $notes;

    public function __construct($id, $title , $date , $duration,$notes){
        $this->workoutID = $id;
        $this->title=$title;
        $this->date = $date;
        $this->duration = $duration;
        $this->notes = $notes;
    }

    /**
     * @return mixed
     */
    public function getWorkoutID()
    {
        return $this->workoutID;
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
}