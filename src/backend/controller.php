<?php
switch($_POST['action']){
    case 'install':
    require 'installer/install.php';
    break;
    case 'validate':
    require 'validate/validate.php';
    break;

}