<?php 
    class Validate{
        public function validateMail($email){
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                require_once 'db/database_functions.php';
                $dbfunc = new DataBase();
                $dbfunc->Connect();
            } else {
                return false;
            }
        }
        public function validatePassword($pass){
            
            $pattern_pass = "/^(?=.*[a-z])(?=.*\\d).{6,}$/i";
            if(preg_match($pattern_pass, $pass)){
                return true;
            }else{
                return false;
            }
        }
        public function validateLogin($login){
            $pattern_login = "/^[0-9a-zA-Z]{6,}$/";
            if(preg_match($pattern_login, $login)){
                require_once 'db/database_functions.php';
                $dbfunc = new DataBase();
                $dbfunc->Connect();
            }else{
                return false;
            }
        }
    }