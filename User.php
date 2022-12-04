<?php

require_once './DB.php';

Class User extends DB{

    function __construct($first_name, $last_name ,$age ,$email){
        $this->first_name = (string) $first_name;
        $this->last_name = (string) $last_name;
        $this->age = (string) $age;
        $this->email = (string) $email;
    }

    // save new document
    public function save(){
        $user = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'age' => $this->age,
            'email' => $this->email
        ];

        $result = $this->add($user);
        return $result;  
    }

    // find user by parameter - you can choose the param you want to search with 
    static function findUser($by ,$value){
        $data = DB::find($by ,$value);
        return $data;  
    }

    // update the user + add new rows 
    static function update($by ,$value , $attr , $newValue){
        $result = DB::updateUser($by ,$value , $attr , $newValue);
        return $result;
    }

    // search which document value to read 
    static function read($by ,$value , $row){
        $result = DB::getRow($by ,$value , $row);
        return $result;
    }
}

// to set new user you need to create new object  
// $user = new User('john' ,'doe' , 40 , 'g@gmail.com');

// the rest functions you can use like that
// echo User::read('first_name' ,'john' ,'age');

