<?php


class user
{

    private $userID;
    private $userName;
    private $email;
    private $password;
    private $dob;
    private $gender;
    private $snapshots;
    private $meals;
    private $workouts;
    private $goals;

    public function __construct($userId, $userName, $email, $password, $dob, $gender, array $snapshots, array $meals, array $workouts, array $goals)
    {
        $this->userID = $userId;
        $this->userName = $userName;
        $this->email = $email;
        $this->password = $password;
        $this->dob = $dob;
        $this->gender = $gender;
        $this->snapshots = $snapshots;
        $this->meals = $meals;
        $this->workouts = $workouts;
        $this->goals = $goals;
    }

    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }


    /**
     * @return mixed
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return array
     */
    public function getSnapshots()
    {
        return $this->snapshots;
    }

    /**
     * @return array
     */
    public function getMeals()
    {
        return $this->meals;
    }

    /**
     * @return array
     */
    public function getWorkouts()
    {
        return $this->workouts;
    }

    /**
     * @return array
     */
    public function getGoals()
    {
        return $this->goals;
    }

}