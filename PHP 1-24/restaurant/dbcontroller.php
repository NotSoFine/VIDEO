<?php
    class DB{
        private $host="127.0.0.1";
        private $user="root";
        private $password="";
        private $database="dbresto";
        private $connection;

        public function __construct()
        {
            $this->connection = $this-> connectionDB();
        }

        public function connectionDB() 
        {
            $connection = mysqli_connect($this->host,$this->user,$this->password,$this->database);
            return $connection;
        }
        public function getALL ($sql)
        {
            $result = mysqli_query($this->connection,$sql);
            while ($row=mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            return $data;
        } 
        public function getITEM($sql){
            $result = mysqli_query($this->connection,$sql);
            $row = mysqli_fetch_assoc($result);
            return $row;
        }
        public function rowCOUNT($sql){
            $result = mysqli_query($this->connection,$sql);
            $count = mysqli_num_rows($result);
            return $count;
        }
        public function runSQL($sql){
            $result = mysqli_query($this->connection,$sql);
        }
        public function message($text=""){
            echo $text;
        }
    }
?>