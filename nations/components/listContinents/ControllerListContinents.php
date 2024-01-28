<?php
defined('APP') or die();

class ControllerListContinents extends Controller{

  function display(){
    $this->tpl->list = $this->model->getListContinents();
   
    parent::display();
  }

  function listRegions() {
    $continent_id = $_GET['continent_id'] ?? 1;
    $this->tpl->list = $this->model->getListRegions($continent_id);
    $this->tpl->name = $this->model->getContinent($continent_id)->name;
    $this->view = "ListRegions";
    parent::display();
  }
}