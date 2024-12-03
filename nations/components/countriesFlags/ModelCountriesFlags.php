<?php
defined('APP') or die();

Class ModelCountriesFlags {

  // Table fields
  public $country_id = 0;
  public $name = '';
  public $area = 0;
  public $national_day = '';
  public $country_code2 = '';
  public $country_code3 = '';
  public $region_id = 0;
  public $flag = '';
  public $old_flag = '';
  public $message = '';
  // region_name is not a table field but is added in order to be shown in the table view
  public $region_name = ''; 
  
  /**
   * Loads in memory from the db the region identified by the country_id
   * @param mixed $id - the country_id
   * @return void
   */
  public function load($id) {
    if ($row = DB::getQueryRow("
      select countries.*, regions.name as region_name 
        from countries join regions using (region_id)
        where country_id=?
      ", 
      [$id])) {
      foreach ($this as $key => $value) {
        if (isset($row->$key))
          $this->$key = $row->$key;
      }
      return true;
    }
    return false;
  }

  /**
   * Inserts/Updates a country in the table countries
   * 
   * @return int - number of record inserted/updated (should be 1)
   */
  public function store() {
    if (!empty($this->flag['name'])){
      $target_dir = "components/countriesFlags/flags/";
      $target_file = $target_dir . basename($this->flag['name']);
      if (!empty($this->old_flag)){
        unlink($target_dir. $this->old_flag);
      }
      if (!move_uploaded_file($this->flag['tmp_name'], $target_file)){
        return 0;
      }
      $this->flag = $this->flag['name'];
    } 
    if (empty($this->country_id)) {
      $n = DB::query("
        INSERT INTO countries
          (name, area, national_day, country_code2, country_code3, region_id, flag) 
        VALUES
          (?, ?, ?, ?, ?, ?, ?)
        ", 
        [
          $this->name,
          $this->area,
          $this->national_day,
          $this->country_code2,
          $this->country_code3,
          $this->region_id,
          $this->flag
        ] );
    } else {
      $n = DB::query("
      UPDATE countries SET 
        name=?,
        area=?,
        national_day=?,
        country_code2=?,
        country_code3=?,
        region_id=?,
        flag=? 
      WHERE country_id=?
      ", [ 
          $this->name,
          $this->area,
          $this->national_day,
          $this->country_code2,
          $this->country_code3,
          $this->region_id, 
          $this->flag,
          $this->country_id
        ]);
    }
    return $n;
  }

  /**
   * Deletes a country from the table countries. The country to be deleted is identified
   * by the country_id property. The query prevents from deletion countries which have
   * been listed in country_stats.
   * 
   * @return int - number of records deleted
   */
  public function delete() {
    return DB::query("
      delete from countries 
       where country_id=?
        and country_id not in 
          (select country_id from country_stats)
      ", 
       [$this->country_id]);
  }

  /**
   * Gets a list of objects of class ModelCountries from the table countries
   * 
   * @param mixed $filter - a string representing a where condition to add to the query
   * @return array - array of objects of class ModelCountries
   */
  public function getList($filter = '1', $params=[]) {
    $tab = DB::getQuery("
      SELECT countries.*, regions.name AS region_name  
        FROM countries JOIN regions USING (region_id)
        WHERE {$filter}
        ORDER BY countries.name
    ", $params);
    return $tab;
  }

  /**
   * Performs a word search in the table on the columns regions.name and countries.nama
   * 
   */
  public function getFilteredList($search){
    $search = '%'.$search.'%';
    return $this->getList("
      regions.name LIKE ? OR countries.name LIKE ?
    ", [$search, $search]);
  }

  /**
   * Extracts the last 10 statistics from the country provided as parameter
   * 
   * It's used by ViewCountriesJS to generate a popup table when the user
   * passes with the mouse over tha name of the country
   */
  public function getStats($country_id){
    return DB::getQuery("
    SELECT * 
      FROM country_stats
      WHERE country_id = ?
      ORDER BY year DESC
      LIMIT 10
    ", [$country_id]);
  }

  /**
   * Returns the list of Regions with their corresponding continent
   * 
   * It is needed by ViewCountries in order to generate the option list of the region_id select tag
   * 
   */
  public function getRegions()
  {
    return DB::getQuery("
    select  regions.region_id, 
            regions.name as region_name,
            continents.name as continent_name 
      from regions join continents using (continent_id)
      order by continents.name, regions.name
  ");
  }
}
