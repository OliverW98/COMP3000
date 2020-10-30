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




}