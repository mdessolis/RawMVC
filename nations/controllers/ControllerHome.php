<?php
defined('APP') or die();

require ("models/ModelHome.php");

class ControllerHome{
  var $model;
  var $view  = "Home";
  var $msg   = "";

  function __construct()
  {
    $this->model = new ModelHome;
  }
  function display(){
    include ("views/template.php");
  }

  function login(){
    $this->view = "Login";
    $this->display();
  }

  function checkLogin() {
    $this->view = "Home";
    $username = $_POST['username'] ?? $_COOKIE['username'] ?? '';
    $password = $_POST['password'] ?? $_COOKIE['password'] ?? '';
    if ($user = $this->model->check($username, $password)){
      $_SESSION['user'] = (array) $user;
      if (isset($_REQUEST['rememberme']) || isset($_COOKIE['username'])){
        setcookie('username', $username, time()+3600*24);
        setcookie('password', $password, time()+3600*24);
      }
    } else {
      $this->msg = "Nome utente e/o password errati";
      $this->view = "Login";
    }
    $this->display();
  }

  function logout(){
    unset($_SESSION['user']);
    $this->display();
  }
}