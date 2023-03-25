<?php
defined('APP') or die();

require_once 'models/ModelContinents.php';
/**
 * Description of ControllerContinents
 *
 * @author mdess
 */
class ControllerContinents
{
  var $model;
  var $view = "ViewContinents";

  public function __construct()
  {
    $this->model = new ModelContinents;
  }

  public function display()
  {
    include("views/template.php");
  }

  public function register()
  {
    $this->model->continent_id = $_REQUEST['continent_id'];
    $this->model->name = $_REQUEST['name'];
    $this->model->store();
    $this->display();
  }

  public function delete()
  {
    $id = $_REQUEST['id'] ?? 0;
    if ($this->model->load($id)) {
      $this->model->delete();
    }
    $this->display();
  }

  public function edit()
  {
    $id = $_REQUEST['id'] ?? 0;
    $this->model->load($id);
    $this->display();
  }

}