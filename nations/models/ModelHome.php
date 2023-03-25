<?php
defined('APP') or die();

class ModelHome {
  public function check($username, $password){
    return DB::getQueryRow("
    SELECT * 
      FROM users
      WHERE username = ? and password = ?
    ",[$username, $password]);
  }
} 