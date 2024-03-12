<?php

class Signup
{
    private $error = "";

    public function evaluate($data)
    {
        //Check If the values from a Post/Form are valid
        foreach ($data as $key => $value) 
        {
            if(empty($value))
            {
                $this->error .= $key . " is empty!<br>";
            }
            if($key == "email")
            {
                if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $value)){
                    $this->error .= "Invalid email address!<br>";
                }
            }
            if($key == "first_name")
            {
                if(is_numeric($value)){
                    $this->error .=  "First name cant be a number<br>";
                }
                if(strstr($value, " ")){
                    $this->error .=  "First name cant have spaces<br>";
                }
            }
            if($key == "last_name")
            {
                if(is_numeric($value)){
                    $this->error .= " Last name cant be a number<br>";
                }
                if(strstr($value, " ")){
                    $this->error .=  "Last name cant have spaces<br>";
                }
            }


        }

        if($this->error == "")
        {
            //No Error
            $this->create_user($data);
        }
        else
        {
            return $this->error;
        }
    }

    public function create_user($data)
    {
        //Data from Form
        $first_name = ucfirst($data['first_name']);
        $last_name = ucfirst($data['last_name']);
        $gender = $data['gender'];
        $email = $data['email'];
        $password = $data['password'];

        //Create These:
        $url_address = strtolower($first_name) . "." . strtolower($last_name);
        $userid = $this->create_userid();

    

        //Create Query using data from form
        $query = "insert into users (userid,first_name,last_name,gender,email,password,url_address) values ('$userid','$first_name','$last_name','$gender','$email','$password','$url_address')";
        
 
        $DB = new Database();
        $DB->save($query);
    }

    // private function create_url()
    // {

    // }

    private function create_userid()
    {   //Randomly Generated Number (NOTE: IN THE FUTURE YOU WOULDN'T WANT TO MATCH ANY OF THE CURRENT USER)
        $length = rand(4,19);
        $number = "";

        for ($i=0; $i < $length; $i++)
        { 
            $new_rand = rand(0,9);
            $number = $number . $new_rand;
        }

        return $number;
    }
    
}