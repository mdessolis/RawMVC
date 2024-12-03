<?php
trait REST {

  /**
   * Send a message to the client
   * 
   */
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

  /**
   * Manages a request 
   * execute a method according to the Request method:
   * GET - performs a query with api_GET
   * POST/PUT - performs an insert/update in the db with api_POST
   * DELETE - performs a delete in the db with api_DELETE 
   * PATCH - performs partial update of a resource in the db with api_PATCH
   */
  public function api(){ 
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    if (in_array($method, ['GET', 'PUT', 'POST', 'DELETE', 'PATCH']) ){
      $task = "api_{$method}";
      $this->$task();
    } else {
      $this->sendResponse("Method not supported", 405);
    }
  }

  /**
   * Execute a POST Request
   * Receives in the $_REQUEST array the values to be stored,
   * copies these values in the model object and call the store()
   * method
   * 
   */
  private function api_POST(){
    $filled = false;
    foreach($_REQUEST as $key=>$val){
      if (isset($this->model->$key) ){
        $this->model->$key = $val;
        $filled = true;
      }
    }
    if ($filled) { // $filled is used to prohibit empty requests
      if ($this->model->store()==1) {
          $this->sendResponse("OK", 200);
      } else {
          $this->sendResponse("Not modified", 208);
      }
    } else {
      $this->sendResponse("Empty data", 400);     
    }
  }

  /**
   * Execute a PUT request
   * We consider this method equivalent to a POST request
   * since the store routine in the model manages both the
   * creation and the update of a resource in the db
   */
  private function api_PUT(){
    $this->api_POST();
  }

  /**
   * Execute a GET request
   * Perform a query on the db according to the parameters
   * added to the query string:
   * - no parameters: returns the entire table content
   * - id: returns the resource with a specific id
   * - search: returns all the resources containing a search word
   * It needs a method getFilteredList to be defined in the model
   */
  private function api_GET(){
    $id = $_REQUEST['id'] ?? 0;
    if (empty($id)){
      $search = $_REQUEST['search'] ?? '1';
      $result = $this->model->getFilteredList($search);
    } else {
      if (!$this->model->load($id)){
        $this->sendResponse("Unknown id", 404);
        return;
      }
      $result = $this->model;
    }
    $this->sendResponse($result);
  }
  
  /**
   * Execute a DELETE request
   * Receives the id of a resource and if it exists
   * performs the delete() method 
   * The id is received in the body of the request
   * in a json format
   */
  private function api_DELETE(){
    $input = json_decode(file_get_contents("php://input"));
    $id = $input->id ?? 0;
    if ($this->model->load($id)) {
      if ($this->model->delete()==1){
        $this->sendResponse("OK");
      } else {
        $this->sendResponse("Integrity violation", 400);
      }
    } else {
      $this->sendResponse("Unknown ID: " . $id, 400);
    }
  }

  /**
   * Execute a PATCH request
   * Receives a list of values to be updated in a resource,
   * loads the resource in the model object, changes the
   * values and performs the store method.
   */
  private function api_PATCH(){
    $input = json_decode(file_get_contents("php://input"));
    $id = $input->id ?? 0;
    if ($this->model->load($id)){
      foreach($input as $key=>$val){
        if (isset($this->model->$key)){
          $this->model->$key = $val;
        }
      }
      if ($this->model->store()==1) {
          $this->sendResponse("OK", 200);
      } else {
          $this->sendResponse("Not modified", 208);
      }
    } else {
      $this->sendResponse("Unknown id", 404);
    }
  }
}
