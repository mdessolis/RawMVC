<?php
defined('APP') or die();

class ControllerLogin extends Controller{
  
  function checkLogin() {
    $username = $_POST['username'] ?? $_COOKIE['username'] ?? '';
    $password = $_POST['password'] ?? $_COOKIE['password'] ?? '';
    if ($user = $this->model->check($username, $password)){
      $_SESSION['user'] = (array) $user;
      if (isset($_REQUEST['rememberme']) || isset($_COOKIE['username'])){
        setcookie('username', $username, time()+3600*24);
        setcookie('password', $password, time()+3600*24);
      }
      header("Location: ?");
    } else {
      $this->tpl->msg = "Nome utente e/o password errati";
    }
    parent::display();
  }

  function logout(){
    unset($_SESSION['user']);
    parent::display();
  }
}