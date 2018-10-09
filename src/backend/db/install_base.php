<?php
class loginObject
	{
		
		function __construct($login,$password,$host,$base)
		{
			$this->login = $login;
			$this->password = $password;
			$this->host = $host;
			$this->base = $base;
		}
	}
	
	class InstallBase{
		public function createConfig($config) {
   			$file ='config.ini';

			 
			chdir('db');
   			$fh = fopen($file, "w");
    		if (!is_resource($fh)) {
        		$this->writeErrors('Cannot create config file');
            }
          
    		foreach ($config as $key => $value) {
    		    fwrite($fh, sprintf("%s = %s\n", $key, $value));
    		}
    		fclose($fh);
            return true; 
		}
		private function writeErrors($e){
			$file = 'error_log.log';
			if (!file_exists($file)) {
				$fh = fopen($file, "w");
        		fwrite($fh, date('Y-m-d/h:i')."\n".$e."\n");
        	    fclose($fh);
    			
			}
			else{
				$fh = fopen($file, "a");
        		fwrite($fh, date('Y-m-d/H:i')."\n".$e."\n");
        		fclose($fh);
			}
		}

		private function firstConnectDB($login){
		
        	 
        	try{
            	$conn = new PDO("mysql:host=$login->host", $login->login, $login->password);
            	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            	return  $conn;
         	}     
         	catch(PDOException $e){
            	$this->writeErrors('Wrong database host, login or password');
            	die();
         	}  
    	} 
    	private function connectDB($login){
    
         	try{
          		$conn = new PDO("mysql:host=$login->host;dbname=$login->base", $login->login, $login->password);
          	 	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            	return $conn;
         	}     
         	catch(PDOException $e){
            	$this->writeErrors('Database connection failed');
            	die();
         	}  
      	} 
		private function createDB($conn,$base){
			try{	
				$stmt = $conn ->query("CREATE DATABASE IF NOT EXISTS $base");
				return true;
			}
			catch(PDOException $e){
				$this->writeErrors($e->getMessage());
				die();
			}
		}
		private function checkExistsTable($table,$conn){
			try {
				$stmt = $conn->query("SELECT 1 FROM $table LIMIT 1");
				return false;
			}
			catch(Exception $e){
				return true;

			}
		}
		private function createUsersTable($conn){
			$try = $this->checkExistsTable('users',$conn);
			if ($try === true) {
				$stmt = $conn->query("CREATE TABLE users (userID INT(100) AUTO_INCREMENT PRIMARY KEY,
														login VARCHAR(12) NOT NULL,
														mail VARCHAR(30) NOT NULL,
														password VARCHAR(100) NOT NULL,
														
														ipAddress VARCHAR(16) NOT NULL,
														regDate VARCHAR(20) NOT NULL,
														lastLoginDate VARCHAR(20) NOT NULL,
														logNow BOOLEAN NOT NULL,
														active BOOLEAN NOT NULL )");
				return true;
			}
			else{
				$this->writeErrors('Users table exists');
				return true;
			}
		}

		private function createNotesTable($conn){
			$try = $this->checkExistsTable('notes',$conn);
			if ($try === true) {
				$conn->query("CREATE TABLE notes (noteID INT(100) AUTO_INCREMENT PRIMARY KEY,
													userID INT(100) NOT NULL,
													comment VARCHAR(999) NOT NULL)");
				return true;
			}
			else{
				$this->writeErrors('Notes table exists');
				return true;
			}
		}
		public function install($login){
		
			$conn = $this->firstConnectDB($login);
			if ($conn != false) {
				$conn = $this->createDB($conn,$login->base);
			}
			else{
				$this->writeErrors('Database connection failed');
				return false;
			}
			$conn = $this-> connectDB($login);
			if ($conn != false) {
				$check = $this->createUsersTable($conn);
				$check = $this->createNotesTable($conn);
			}
			else{
		
				$this->writeErrors('Cannot create tables');
				return false;
			}
			if ($conn != false || $check != false){
				return true;
			}
			else{
				return false;
			}
		}	
	}