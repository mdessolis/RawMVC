<?php
defined('APP') or die();

require_once 'models/ModelCountries.php';

/**
 * Description of ControllerContinents
 *
 * @author mdess
 */
class ControllerCountries 
{
  use REST; // enable API functions

  var $model;
  public $regions =[];
  public $countries = [];
  public $view = "ViewCountries";
  
  public function __construct()
  {
    $this->model = new ModelCountries;
  }
  
  public function display()
  {
    include("views/template.php");
  }

  public function register()
  {
    foreach($_REQUEST as $field=>$value){
      if (isset($this->model->$field))
        $this->model->$field = $value;
    }
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

  public function defaultjs(){
    $this->view = "ViewCountriesJS2";
    $this->display();
  }

  
  /**
   * API  
   */
  public function api_stats(){
    $country_id = $_REQUEST['id'] ?? 0;
    $list = $this->model->getStats($country_id);
    $this->sendResponse($list);
  }




}
