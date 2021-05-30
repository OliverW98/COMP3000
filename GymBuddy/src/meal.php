<?php


class meal
{

    private $mealID;
    private $title;
    private $date;
    private $calorieIntake;
    private $notes;
    private $imageName;
    private $img_dir;


    function __construct($mealID, $title, $date, $calorieIntake, $notes, $imageName, $img_dir)
    {
        $this->mealID = $mealID;
        $this->title = $title;
        $this->date = $date;
        $this->calorieIntake = $calorieIntake;
        $this->notes = $notes;
        $this->imageName = $imageName;
        $this->img_dir = $img_dir;
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