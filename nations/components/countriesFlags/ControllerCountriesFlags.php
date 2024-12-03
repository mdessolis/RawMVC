<?php
defined('APP') or die();

/**
 * Description of ControllerContinents
 *
 * @author mdess
 */
class ControllerCountriesFlags extends Controller
{
  use REST;
  
  public function js(){
    $this->view = "CountriesJS";
    parent::display();
  }
  public function register()
  {
    foreach($_REQUEST as $field=>$value){
      if (isset($this->model->$field))
        $this->model->$field = $value;
    }
    $this->model->flag = !empty($_FILES['flag']['name']) ? $_FILES['flag'] : $_REQUEST['old_flag'];
    $this->model->store();
    $this->model = new ModelCountriesFlags;
    parent::display();
  }

  public function delete()
  {
    $id = $_REQUEST['id'] ?? 0;
    if ($this->model->load($id)) {
      $this->model->delete();
    }
    parent::display();
  }

  public function edit()
  {
    $id = $_REQUEST['id'] ?? 0;
    $this->model->load($id);
    parent::display();
  }

}
