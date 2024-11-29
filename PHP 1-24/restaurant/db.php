<?php
    class DB{
    //property
    public $host = "127.0.0.1";
    private $user = "root";
    private $password = "";
    private $database = "dbresto";
    
    public function __construct()
    {
        echo "construct";
    }
    //method
    public function selectData(){
        echo 'select data';
    }
    public function getDatabase(){
        return $this->database;
    }
    public function show(){
        $this->selectData();
    }
    public static function insertData(){
        echo "static function";
    }
    }
    DB::insertData();
    $db = new DB;
    // }
    // $db = new DB;
    // echo '<br>';
    // $db->selectData();
    // echo '<br>';
    // $db->$host;
    // echo '<br>';
    // echo $db->getDatabase().'<br>';
    // $db->show();

?>