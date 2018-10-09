<?php 
    require_once 'validate_object.php';
    $validation = new Validate;
    $items =json_decode($_POST['items']);
    switch($items->name){
        case 'email':
        echo $validation->validateMail($items->value);
        break;
        case 'password':
        echo $validation->validatePassword($items->value);
        break;
        case 'login':
        echo $validation->validateLogin($items->value);
        break;
    }