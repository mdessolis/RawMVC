<?php
/**
 * Class Controller
 * 
 * Base class
 */

abstract class Controller {
  protected $model;
  protected $option;
  protected $view;
  protected $tpl;

  function __construct()
  {
    $this->tpl = new class{}; // empty object
    $option=$_REQUEST['option'] ?? "Home";
    require("components/".lcfirst($option)."/Model".ucfirst($option).".php");
    $model_name = "Model".ucfirst($option);
    $this->model = new $model_name;
    $this->option = lcfirst($option);
    $this->view = ucfirst($option);
  }

  function display(){
    include ("template/template.php");
  }
}