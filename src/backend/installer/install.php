<?php
	require_once 'db/install_base.php';
	$login = json_decode($_POST['items']);
	$login = new loginObject($login->login,$login->password,$login->host,$login->base);
	$install = new InstallBase;
	if($install->install($login)){
		if($install->createConfig($login)){
			echo true;
		}
	}
