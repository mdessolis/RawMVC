<?php
defined('APP') or die();

/**
 * Description of ControllerContinents
 *
 * @author mdess
 */
class ControllerContinents extends Controller {

  public function display()
  {
    $this->tpl['list'] = $this->model->getList();
    parent::display();
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
