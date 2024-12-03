# RawMVC

This is a simple php MVC structure I'm planning to use with my students.

It is not intended to be used in a production environment, obviously, since it lacks several patterns and functionalities. The aim is just to give a starting point learning this framework.   

## Principles of MVC

MVC stands for ***Model-View-Controller***. It's an architectural pattern used to organize the main logic of a program in distinct classes in order to separate the *business logic* (i.e. database, but non only), from the *presentation* (i.e. web, but not only).

Thus, the **Model** class manages mainly all the operations involved with the business logic and data access (database, sensors, etc.) and creates the objects with the data to be presented. The **View** organizes the data computed by the Model into, for example, a web page. The **Controller** supervises all the operations in order to check which methods execute from a Model and which View use for the presentation (html, json, xml, etc).  

## Main structure

This example uses a directory structure in which controllers, models and views are saved separately.

It is possible, with a few changes in the code, to give a different structure. For example, create a MVC tree for each module.

Anyway, at the moment the proposed structure is the following:

   index.php
   (dir) home
      ControllerHome.php
      ModelHome.php
      ViewHome.php
   (dir) login
      ControllerLogin.php
      ModelLogin.php
      ViewLogin.php
   (dir) option1
      ControllerOption1.php
      ModelOption1.php
      ViewOption1.php
      ViewOption1-1.php
   (dir) template
      template.php
      stile.css
   (dir) bootstrap
   (dir) libs
      DB.php
      Tabella.php
      Controller.php

As you can see there's a root page called **index.php** which has to be always the starting point of the entire application. It defines some constants used in the other pages, includes the main MVC classes and calls the Home or the requested Controller.

    <?php
    define('APP',1);

    require 'config.php';
    require 'utils/DB.php';
    require 'controllers/Controller.php';
    require 'utils/HTMLTable.php';

    $option = $_REQUEST['option'] ?? 'home';
    $task = $_REQUEST['task'] ?? 'default';

    $_REQUEST['option'] = $option;
    $_REQUEST['task'] = $task;

    $controller_name = "Controller".ucfirst($option);
    if (!file_exists("controllers/{$controller_name}.php")) {
      $controller_name = "ControllerHome";
    }

    require "controllers/{$controller_name}.php";

    $controller = new $controller_name;

    if (isset($controller->$task)) {
      $controller->$task();
    } else {
      $controller->default();
    }

The constant APP is used by the other pages in order to check that that page is called by index.php. Thus, every other page should start with

    <?php defined('APP') or die(); ?>

## Working example

As a working example, we use a standard mysql database used by many sites, Nations.

![MariaDB sample database](https://www.mariadbtutorial.com/wp-content/uploads/2019/10/mariadb-sample-database.png)

In order to connect to the database you should add a root file named `config.php` with the following content:

    <?php
    const DB_HOST = "";
    const DB_NAME = "";
    const DB_USER = "";
    const DB_PASSWORD = "";

replacing the empty strings with the appropriate connection details to you db.

You can create your db nation by importing in mysql/mariadb the following file: [DB Nation](nations/sql/nation.sql)

