<?php
trait ControllerApi {

  public function sendResponse($message, $responseCode=200, $type="json"){
    switch($type){
      case 'json': 
        $contentType = "application/json";
        $content = json_encode($message);
        break;

      case 'html':
        $contentType = "text/html";
        $content = $message;
        break;

      case 'txt':
      default:
        $contentType = "text/plain";
        $content = $message;
        break;
    }
    header("Content-type: {$contentType}; charset=UTF-8");
    http_response_code($responseCode);
    echo $content;

  }

  public function api(){ 
    $this->execute_method();
  }

  private function execute_method(){
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    if (in_array($method, ['GET', 'PUT', 'POST', 'DELETE']) ){
      $task = "api_{$method}";
      $this->$task();
    } else {
      $this->sendResponse("Method not supported", 405);
    }
  }

  private function api_POST(){
    $filled = false;
    foreach($_REQUEST as $key=>$val){
      if (isset($this->model->$key) && !empty($val)){
        $this->model->$key = $val;
        $filled = true;
      }
    }
    if ($filled) {
      if ($this->model->store()==1) {
          $this->sendResponse("OK", 200);
      } else {
          $this->sendResponse("Incorrect data", 400);
      }
    } else {
      $this->sendResponse("Empty data", 400);     
    }
  }

  private function api_PUT(){
    $this->api_POST();
  }

  private function api_GET(){
    $id = $_REQUEST['id'] ?? 0;
    if (empty($id)){
      $result = $this->model->getList();
    } else {
      if (!$this->model->load($id)){
        $this->sendResponse("Unknown id", 400);
        return;
      }
      $result = $this->model;
    }
    $this->sendResponse($result);
  }
  
  private function api_DELETE(){
    $id = $_REQUEST['id'] ?? 0;
    if ($this->model->load($id)) {
      if ($this->model->delete()==1){
        $this->sendResponse("OK");
      } else {
        $this->sendResponse("Integrity violation", 400);
      }
    } else {
      $this->sendResponse("Unknown ID", 400);
    }
  }
}