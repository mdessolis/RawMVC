<?php
/**
Table HTML class
*/

class HTMLTable {
  private $columns = [];
  private $list = [];
  private $title = "";

  public function setTitle($title){
    $this->title = $title;
  }
  public function setColumns($columns){
    $this->columns = $columns;
  }

  public function setList($list){
    $this->list = $list;
  }

  public function __toString(){
    $t = !empty($this->title) 
            ? "<caption class=\"caption-top text-center\">{$this->title}</caption>"
            : "";
    $r = "<table class=\"table table-bordered table-striped\">
           {$t}
           <thead>
             <tr>";
    foreach($this->columns as $sqlname=>$name){
      $r .= "<th>{$name}</th>";
    }
    $r.='</tr>
        </thead>
      <tbody>';
    foreach($this->list as $riga){
      $r .= "<tr>";
      foreach($this->columns as $sqlname=>$name){
        $r .= "<td>{$riga->$sqlname}</td>";
      }
      $r .= "</tr>";
    }
    $r.= "</tbody></table>";
    return $r;
  }
}