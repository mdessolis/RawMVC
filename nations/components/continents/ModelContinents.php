<?php
defined('APP') or die();

/**
 * Model used by ControllerContinents to manage table Continents
 */
class ModelContinents
{
  // Qui dovete dichiare tutti gli attributi della tabella, rispettando la stessa denominazione
  // usata nel db.

  /**
   * Continent id - PK
   *
   * @var integer
   */
  public $continent_id = null;

  /**
   * Continent name
   *
   * @var string
   */
  public $name = '';

  /**
   * Loads a row with pk $id from the db table and store the values
   * into class properties
   *
   * @param [type] $id
   * @return void
   */
  public function load($id)
  {
    if ($row = DB::getQueryRow(
      "
      SELECT *
        FROM continents
        WHERE continent_id=?
      ",
      [$id]
    )) {
      foreach ($this as $key => $value) {
        $this->$key = $row->$key;
      }
      return true;
    }
    return false;
  }

  /**
   * Updates/inserts a row into db table, using class properties as
   * values. If continent_id is empty performs an insert, otherwise
   * performs an update
   *
   * @return integer - number of rows modified
   */
  public function store()
  {
    if (empty($this->continent_id)) {
      $n = DB::query(
        "
        INSERT INTO continents(name)
               VALUES (?)
        ",
        [$this->name]
      );
    } else {
      $n = DB::query(
        "
      UPDATE continents SET
        name=?
      WHERE continent_id=?
      ",
        [$this->name, $this->continent_id]
      );
    }
    return $n;
  }

  /**
   * Deletes a row from the db table. The row is identified by continent_id value
   *
   * @return integer - number of rows deleted
   */
  public function delete()
  {
    /**
     * Use of try..catch could be helpful in case of
     * data integrity violation during the delete execution
     */
    try {
      return DB::query(
        "
        DELETE 
         FROM continents
         WHERE continent_id=?
        ",
        [$this->continent_id]
      );
    } catch (Exception $e) {
      return 0;
    }
  }

  /**
   * Gets a list of objects 
   * with the content of table Continents
   *
   * @param string $filter - optional filter to be added to the query
   * @return array of objects of type ModelContinent
   */
  public function getList($filter = '1')
  {
    $list = DB::getQuery("
      SELECT *
        FROM continents
        WHERE ?
    ", [$filter]);
    return $list;
  }
}