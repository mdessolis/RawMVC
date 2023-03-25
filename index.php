<?php
define('APP',1);
session_start();

require 'config.php';
require 'utils/DB.php';
require 'controllers/Controller.php';
require 'utils/HTMLTable.php';
require 'utils/HTMLTablePaged.php';
require 'controllers/ControllerApi.php';

$option = ucfirst($_REQUEST['option'] ?? 'Home');
$task = $_REQUEST['task'] ?? 'default';

$_REQUEST['option'] = $option;
$_REQUEST['task'] = $task;

if (empty($_SESSION['username'])){
  if (!($option=='Home' && in_array($task, ['login','checkLogin'] ))){
    $option = "Home";
    $task="login";
  }
}
/*
$options lists the options active for the site. This array will be used in the
template.php to show the main menu
*/
$options = [
  'Home'        => 'Home',
  'Continents'  => 'Continents',
  'Countries'   => 'Countries',    
];

if (isset($options[$option])){
  $controller_name = "Controller".$option;
} else {
  $controller_name = "ControllerHome";
}

require "controllers/{$controller_name}.php";
$controller = new $controller_name;

if (method_exists($controller,$task)) {
  $controller->$task();
} else {
  die("Task incorrect");
}

