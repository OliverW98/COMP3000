<?php


class exercise
{
    private $exerciseID;
    private $name;
    private $sets;
    private $reps;
    private $weight;

    public function __construct($id, $name, $sets , $reps , $weight){
        $this->exerciseID = $id;
        $this->name = $name;
        $this->sets = $sets;
        $this->reps = $reps;
        $this->weight = $weight;
    }

    /**
     * @return mixed
     */
    public function getExerciseID()
    {
        return $this->exerciseID;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSets()
    {
        return $this->sets;
    }

    /**
     * @return mixed
     */
    public function getReps()
    {
        return $this->reps;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

}