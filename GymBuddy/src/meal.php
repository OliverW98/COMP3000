<?php


class meal
{

    private $mealID;
    private $title;
    private $date;
    private $calorieIntake;
    private $notes;


    function __construct($mealID,$title,$date,$calorieIntake,$notes){
        $this->mealID = $mealID;
        $this->title = $title;
        $this->date = $date;
        $this->calorieIntake = $calorieIntake;
        $this->notes = $notes;
    }

    /**
     * @return mixed
     */
    public function getMealID()
    {
        return $this->mealID;
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
    public function getCalorieIntake()
    {
        return $this->calorieIntake;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

}