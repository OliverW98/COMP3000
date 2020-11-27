<?php


class exercise
{
    private $exerciseID;
    private $name;
    private $sets;
    private $reps;
    private $weight;

    public function __construct($id, $name, $sets, $reps, $weight)
    {
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

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $reps
     */
    public function setReps($reps)
    {
        $this->reps = $reps;
    }

    /**
     * @param mixed $sets
     */
    public function setSets($sets)
    {
        $this->sets = $sets;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
}