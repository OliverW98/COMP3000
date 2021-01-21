<?php


class snapshot
{

    private $snapshotID;
    private $date;
    private $weight;
    private $height;
    private $bodyFatPercent;
    private $muscleMassPercent;

    function __construct($snapshotID, $date, $weight, $height, $bodyFatPercent, $muscleMassPercent)
    {
        $this->snapshotID = $snapshotID;
        $this->date = $date;
        $this->weight = $weight;
        $this->height = $height;
        $this->bodyFatPercent = $bodyFatPercent;
        $this->muscleMassPercent = $muscleMassPercent;
    }

    /**
     * @return mixed
     */
    public function getSnapshotID()
    {
        return $this->snapshotID;
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
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return mixed
     */
    public function getBodyFatPercent()
    {
        return $this->bodyFatPercent;
    }

    /**
     * @return mixed
     */
    public function getMuscleMassPercent()
    {
        return $this->muscleMassPercent;
    }
}