<?php

namespace System;

use LDAP\Result;
use PDO;
use PDOException;

class Database
{

    private $app;

    private static $connect;

    private $table;

    private array $data = [];

    private array $bindings = [];

    private $lastInsertId = '';

    private $where = [];

    private $selects = [];

    private $joins = [];

    private  $limit;

    private  $offset;

    private  $rows;

    private  $orderBy = [];

    public function __construct(Application $app)
    {
        $this->app = $app;

        if (!$this->isConnected()) {
            $this->connect();
        }
    }

    private function isConnected()
    {


        return self::$connect instanceof PDO;
    }

    private function connect()
    {

        $cData =  require  $this->app->files->to('config.php');


        extract($cData);

        try {
            self::$connect = new PDO('mysql:host=' . $server . '; dbname=' . $dbname, $dbuser, $dbpass);
            self::$connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            self::$connect->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$connect->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
            self::$connect->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
            self::$connect->exec('SET NAMES utf8mb4');

            

        } catch (PDOException $e) {
           
            die($e->getMessage());
        }
    }

    public function connection()
    {
        return self::$connect;
    }

    //Set Select:
    public function select($select){
        $this->selects[] = $select;

        return $this;
    }

    //Set join:
    public function join($join){
        $this->joins[] = $join;

        return $this;
    }

        //Set Limit && Ofset:
        public function limits($limit, $offset = 0){
            $this->limit = $limit;
            $this->offset = $offset;
    
            return $this;
        }


        public function orderBy($orderBy, $sort = 'ASC'){
           $this->orderBy = [$orderBy, $sort];

           return $this;

        }
        
        //Set Fetch Return stdClass(obj) | null 
        public function single($table = null){
          
        

            if($table){
                $this->table($table);
            }
            $sql = $this->fetchStatement();

           $Result =  $this->query($sql, $this->bindings)->fetch();
           $this->reset();
           return $Result;
        }


         //Set Fetch Return stdClass(obj) | null 
         public function all($table = null){
          
        

            if($table){
                $this->table($table);
            }
            $sql = $this->fetchStatement();

           $query =  $this->query($sql, $this->bindings);
           
           $Result = $query->fetchAll();

           $this->rows = $query->rowCount();

           $this->reset();

           return $Result;
        }

        public function rows(){
            return $this->rows;
        }

        private function fetchStatement(){
            //$sql = '';
            $sql = "SELECT ";

            if($this->selects){
                $sql .= implode(',', $this->selects );
            }else{
                $sql .= " * ";
            }

            $sql .= " FROM " . $this->table;

            if($this->joins){
                $sql .= implode(' ', $this->joins );
            }

            if($this->where){
                $sql .= " WHERE ". implode(' ', $this->where);
            }

            if($this->limit){
                $sql .= " LIMITS {$this->limit} ";
            }

            if($this->offset){
                $sql .= " OFFSET {$this->offset} ";
            }

            if($this->orderBy){
                $sql .= " ORDER BY " . implode(' ', $this->orderBy) . ' ';
            }

            return $sql;
        }



    public function table($table)
    {
        $this->table = $table;

        return $this;
    }

    public function from($table)
    {
        return $this->table($table);
    }

    public function data($key, $value = null)
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
            $this->addToBindings($key);
        } else {
            $this->data[$key] = $value;
            $this->addToBindings($value);
        }

        return $this;
    }

    public function insert($table = null)
    {
        if ($table) {
            $this->table = $table;
        }

        $sql = " INSERT INTO {$this->table} SET ";

        $sql .= $this->setFiled();
        

      //echo $sql;

       $this->query($sql, $this->bindings);
       $this->lastInsertId = $this->connection()->lastInsertId();

       $this->reset();

       return $this;
    }

    private function addToBindings($value)
    {
        if(is_array($value)){
            $this->bindings = array_merge($this->bindings, array_values($value));
        }else{
            $this->bindings[] = $value;
        }
       
    }

    public function query(...$bindings){

        //php .< 5.6  > 5.6   ...$bindings as method param
        //$bindings = fun_get_args();

   
        $sql = array_shift($bindings);

        if(count($bindings) == 1 && is_array($bindings)){
            $bindings = $bindings[0];
        }

      try {

        $query = $this->connection()->prepare($sql);


        foreach ($bindings as $key => $value) {
            $query->bindValue($key + 1, _e($value), PDO::PARAM_STR);
        }

        $query->execute();

        
        return $query;

      } catch (PDOException $e) {

        echo $sql;
        pr($this->bindings);
        die($e->getMessage());
        
      }

    }

    public function getLastId(){
        return $this->lastInsertId;
    }

    public function where(...$bindings){
        
        $sql = array_shift($bindings);

        $this->addToBindings($bindings);

        $this->where[] = $sql;
        return $this;
    }

    public function update($table = null)
    {
        if ($table) {
            $this->table = $table;
        }

        $sql = "UPDATE {$this->table} SET ";

        foreach (array_keys( $this->data) as $key ) {
             
                $sql .= '`' . $key .  '` = ? , ';
           
           
            //$this->addToBindings($value);
        }

        $sql = rtrim($sql, ', ');

       // echo $sql;

       if($this->where){
        $sql .= ' WHERE '. implode('',$this->where);
       }



       $this->query($sql, $this->bindings);
 
       pr($this->bindings);

       $this->reset();

       return $this;
    }

    public function delete($table = null)
    {
        if ($table) {
            $this->table = $table;
        }

        $sql = "DELETE FROM {$this->table}  ";

        foreach (array_keys( $this->data) as $key ) {
             
                $sql .= '`' . $key .  '` = ? , ';
           
           
            //$this->addToBindings($value);
        }

        $sql = rtrim($sql, ', ');

       // echo $sql;

       if(!$this->where){
        die('Please Select The recods you want to delete');
       }else{
        $sql .= ' WHERE '. implode('',$this->where);
       }



       $this->query($sql, $this->bindings);
 
       pr($this->bindings);
       $this->reset();
       
       return $this;
    }

    public function reset(){
        $this->data = [];
        $this->bindings = [];
        $this->selects = [];
        $this->where = [];
        $this->joins = [];
        $this->orderBy = [];
        $this->limit = null;
        $this->offset = null;
        $this->table = null;
        $this->rows = 0;
    }

    public function setFiled(){
        $sql = '';
        foreach (array_keys($this->data) as $key) {
           
            $sql .= '`' . $key .  '` = ?, ';
           // $this->addToBindings($value);
        }

        $sql = rtrim($sql, ' , ');

        return $sql;
    }
}
