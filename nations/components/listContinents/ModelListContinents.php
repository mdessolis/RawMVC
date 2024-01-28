<?php
defined('APP') or die();

class ModelListContinents {
  
  public function getListContinents(){
    return DB::getQuery("
      SELECT *
        FROM continents
    ");
  }

  public function getListRegions($continent_id){
    return DB::getQuery("
      SELECT *
        FROM regions
       WHERE continent_id = ?
    ", [$continent_id]);
  }

  public function getContinent($continent_id){
    return DB::getQueryRow("
      SELECT *
        FROM continents
       WHERE continent_id = ?
    ", [$continent_id]);
  }
} 