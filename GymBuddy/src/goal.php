<?php

class goal
{
    private $goalID;
    private $type;
    private $title;
    private $value;


    public function __construct($goalID, $type, $title, $value)
    {
        $this->goalID = $goalID;
        $this->type = $type;
        $this->title = $title;
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getGoalID()
    {
        return $this->goalID;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
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
    public function getValue()
    {
        return $this->value;
    }

}