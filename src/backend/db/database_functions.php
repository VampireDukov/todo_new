<?php
    class DataBase{
        private function getConfig(){
            $file = 'config.ini';
            if (!file_exists($file)) {
                $file = 'config.ini';
            }
            $config = parse_ini_file($file, true);
            $config = json_encode($config);
            $config = json_decode($config);
            return $config;
        }
        private function DBConnect($login){
            try{
                $conn = new PDO("mysql:host=$login->host;dbname=$login->base", $login->login, $login->password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
           }     
           catch(PDOException $e){
                die();
           }  
        }
        private function checkData($checked_value,$what_to_check,$conn,$table){
            $stmt = $conn->query("SELECT $what_to_check FROM $table WHERE login=':login'");
            $stmt->execute(array(':login' => $checked_value));
            $data = $stmt->fetchAll();
            print_r($data);
        }
        private function regUser(){
            
        }
        public function Connect(){
            $login = $this->getConfig();
            $conn = $this-> DBConnect($login);
            $this->checkData('adam','login',$conn,'users');
        }
    }