<?php


class user
{

    private $userID;
    private $userName;
    private $email;
    private $password;
    private $weight;
    private $height;
    private $dob;
    private $gender;

    public function __construct($userId,$userName ,$email,$password,$weight,$height,$dob,$gender){
        $this->userID = $userId;
        $this->userName =$userName;
        $this->email = $email;
        $this->password=$password;
        $this->weight=$weight;
        $this->height=$height;
        $this->dob=$dob;
        $this->gender=$gender;

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


}