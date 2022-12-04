<?php

require 'vendor/autoload.php';

Class DB {

  // connect to localhost mongo 
  static function connectToDb(){
    return new \MongoDB\Driver\Manager("mongodb://localhost:27017");
  }

  // add new document you can set which db to score to 
  public function add($data ,$db='users'){
    try{
      $con = DB::connectToDb();
      $bulk = new \MongoDB\Driver\BulkWrite;
      $bulk->insert($data);
      $result = $con->executeBulkWrite("test.$db", $bulk);
      
      if($result) return 'Inserted new document';
      else return 'Could not insert new document';
    }catch(\Exception $e){
      return 'Could not insert new document' . $e->getMessage();
    }
  }

  // update or add parameters by search the document and update 
  static function updateUser($by ,$value , $attr , $newValue){
    try{
      $con = DB::connectToDb();
      $bulk = new \MongoDB\Driver\BulkWrite;
      $bulk->update([$by => $value] ,['$set' => [$attr => $newValue]]);
      $result = $con->executeBulkWrite('test.users', $bulk);

      if($result) return 'Updated '.$attr.' : '.$newValue;
    }catch(\Exception $e){
      return 'Could not insert new document' . $e->getMessage();
    }
  }

  // return the document or documents from set db
  static function find($by ,$value ,$db='users' ,$all=false){
    $data = [];
    try{
      $filter = [$by => ['$eq' => $value]];
      $options = [
        'projection' => ['_id' => 0],
        'sort' => ['x' => -1],
      ];

      if($all) $filter = $options = [];
      $con = DB::connectToDb();
      $query = new \MongoDB\Driver\Query($filter, $options);
      $result = $con->executeQuery("test.$db", $query);

      foreach ($result as $document) {
        $data[] = $document;
      }

      return json_encode($data);
    }catch(\Exception $e){
      return 'Could not insert new document' . $e->getMessage();
    }
  }

  //return the row from document
  static function getRow($by ,$value ,$row){   
    try{
      $result = DB::find($by ,$value);
      $user = json_decode($result,1);
      $user = reset($user);

      if(isset($user[$row])) return $user[$row];
      else return 'This parameter doesn\'t exist';
    }catch(\Exception $e){
      return 'Could not find user parameter' . $e->getMessage();
    }
  }

  // get all the rows set on the param from all documents on db
  public function getRows($params){  
    try{
      $data = [];
      $result = DB::find('' ,'', 'cars' ,true);

      foreach(json_decode($result,1) as $index=>$car){

        foreach($params as $row){
          $data[$index][$row] = isset($car[$row]) ? $car[$row] : '';
        }  
      }
      return json_encode($data);
    }catch(\Exception $e){
      return 'Could not find user parameter' . $e->getMessage();
    }
  }
}