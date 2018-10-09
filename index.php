<?php
	define('REALPATH', getcwd());
	define('CONFIG', REALPATH.'/src/backend/db/config.ini');
	define('PAGE', REALPATH.'/src/templates/page.php');
	define('SCRIPTS', REALPATH.'src/frontend/scripts/');
	define('CONTROLLER', REALPATH.'/src/backend/controller.php');
	define('SELECTOR', REALPATH."/src/backend/selector.php");

	require SELECTOR;
	if(file_exists(CONFIG)){
		$install = true;		
	}else{
		$install = false;
		
	}
	$checker = new Selector($install);
  require PAGE;