<?php
session_start();

/* the constant APP will be used at the start of each file of the
   application to check that the file is not accessed directly 
   */
define('APP',1);

/* config.php contains the initialisation of the constants used
   to connect to the db
*/
require '../config.php';

// DB.php is a simple class used to access and execute queries on the mysql db
require 'libs/DB.php';

// HTMLTable is a simple class used to generate an HTML table from a list
require 'libs/Tabella.php';

// Controller is an abstract class used as ancestor of every other Controller
require 'libs/Controller.php';

// REST is a trait class which could be associated to a Controller to provide it with RESTful webservice functions
require 'controllers/REST.php';

/* All the routing inside the application is managed with two querystring parameters, option and task
   option tells which Controller execute and task which function inside the controller.
   The default option is Home, corresponding to ControllerHome
*/
$option = lcfirst($_REQUEST['option'] ?? 'home');

// the default task is display. Every controller should declare one
$task = $_REQUEST['task'] ?? 'display';

/* if we need an access reserved for only authenticated users reroute the task and option to the login
   page.
   This block could be changed according to different use cases. For example we could provide public access
   for some tasks or more granulated access depending on user role

if (empty($_SESSION['user'])){
  if ($task != 'checkLogin'){
    $option = "Home";
    $task="login";
  }
}
*/
// $controller_name contains the name of the controller class to be activated
$controller_name = "Controller".ucfirst($option);

// check if the controller class exists in the controllers folder
if (is_file("components/{$option}/{$controller_name}.php")){
  require "components/{$option}/{$controller_name}.php";
} else {
  die ("Wrong operation");
}

// Now that we have the class available we could create an istance
$controller = new $controller_name;

// if the task required exists as a function inside the controller it will be executed
if (method_exists($controller,$task)) {
  $controller->$task();
} else {
  $controller->display();
}

