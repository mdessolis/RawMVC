<?php
defined('APP') or die();

/**
 * A singleton class used to manage access to a PDO database 
 */
class DB
{
  /**
   * Store the PDO connection
   *
   * @var PDO
   */ 
  private static $db = null;

  /**
   * Get an istance of a PDO connection to the db.
   * Uses the global variables $DB_HOST, $DB_NAME, $DB_PASSWORD and $DB_USER
   * for connecting to the mysql/mariadb database
   *
   * @return PDO object
   */
  public static function getDb()
  {
      if (self::$db == null) {
          //global constants DB_HOST, DB_NAME, DB_PASSWORD, DB_USER are defined in config.php
          try {
              self::$db = new PDO("mysql:host=". DB_HOST ."; dbname=". DB_NAME .";charset=utf8", DB_USER, DB_PASSWORD);
              self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              return self::$db;
          } catch (PDOException $e) {
              $err = $e->getMessage() . '<pre>' .$e->getTraceAsString() .'</pre>';
              die("Errore di connessione: " . $err);
          }
      } else {
          return self::$db;
      }
  }

  /**
   * Returns an object list of a query sql result.
   *
   * @param string $sql - query sql to be executed
   * @param array $param - values to bind to ? parameters in query
   * @return array of objects
   */
  public static function getQuery($sql, $param = [])
  {
      $db = self::getDb();
      $tab = $db->prepare($sql);
      $tab->execute($param);
      $elenco = [];
      while ($riga = $tab->fetch(PDO::FETCH_OBJ)) {
          $elenco[] = $riga;
      }
      return $elenco;
  }

  /**
   * Returns the first row of a query as a object
   *
   * @param string $sql - query to be executed
   * @param array $param - values to bind to ? parameters in query
   * @return array of objects
   */
  public static function getQueryRow($sql, $param =[])
  {
      $db=self::getDb();
      $tab = $db->prepare($sql);
      $tab->execute($param);

      if ($riga = $tab->fetch(PDO::FETCH_OBJ)) {
          return $riga;
      }
      return null;
  }

  /**
   * Execute a DML/DDL sql statement and return number of rows modified
   *
   * @param string $sql - statement to be executed
   * @param array $param - values to bind to ? parameters in statement 
   * @return integer - number of rows modified
   */
  public static function query($sql, $param=[])
  {
    try{
      $db=self::getDb();
      $tab = $db->prepare($sql);
      $tab->execute($param);
      return $tab->rowCount();
    } catch(PDOException $e){
        return 0;
    }
  }
}