<?php 

require_once './DB.php';

Class Car extends DB{

    function __construct($model, $color ,$type ,$number){
    $this->model = (string) $model;
    $this->color = (string) $color;
    $this->type = (string) $type;
    $this->number = (string) $number;
    }

    // save new document
    public function save(){
        $car = [
            'model' => $this->model,
            'color' => $this->color,
            'type' => $this->type,
            'number' => $this->number
        ];

        $result = $this->add($car ,'cars');
        return $result;  
    }

    // read multiple rows from collection
    static function read($params=[]){
        $result = DB::getRows($params);
        return $result;
    }

}

// return all documents parameters that set 
// echo Car::read(['type','number']);

