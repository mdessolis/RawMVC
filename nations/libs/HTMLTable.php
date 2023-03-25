<?php
defined('APP') or die();

class HTMLTable {

protected $headers = null;
protected $list = [];
protected $cols = [];
protected $title = null;
protected $tableOptions = '';
 
public function setTableOptions($options) {
  $this->tableOptions = $options;
}

public function setHeaders($headers) {
  $this->headers = $headers;
}

public function setList($list, $cols = []) {
  $this->list = $list;
  $this->cols = $cols;
}

public function setTitle($title) {
  $this->title = $title;
}

public function render() {
  $r = "<table {$this->tableOptions}>";
  if ($this->title) {
    $r .= "<caption>{$this->title}</caption>";
  }
  if ($this->headers) {
    $r .= '<thead><tr>';
    foreach ($this->headers as $th) {
      $r .= "<th>{$th}</th>";
    }
    $r .= '</tr></thead>';
  }
  $r .= '<tbody>';
  foreach ($this->list as $row) {
    $r .= '<tr>';
    if (!empty($this->cols)) {
      foreach ($this->cols as $col) {
        $r .= "<td>{$row->$col}</td>";
      }
    } else {
      foreach ($row as $td) {
        $r .= "<td>{$td}</td>";
      }
    }
    $r .= '</tr>';
  }
  $r .= '</tbody></table>';
  return $r;
}

}