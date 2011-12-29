<?php
namespace skrupel\libs;
require_once(PATH.'includes/libs/db/class.db.php');
require_once(PATH.'includes/class/exceptions/class.db.php');
class DB extends \db{
  static protected $_instance;
  public function __construct($dsn, $user="", $passwd=""){
    parent::__construct($dsn, $user, $passwd);
  }

  public static function getDB(){
	if(self::$_instance == null){
      global $config;
	  try{
	  self::$_instance = new DB("mysql:host={$config['DB']['host']};port={$config['DB']['port']};dbname={$config['DB']['dbname']}", $config['DB']['user'] ,$config['DB']['password']);
	}catch (PDOException $e) {
	  throw new \skrupel\exceptions\DB('Es ist ein PDO Fehler aufgetreten:'.$e->getMessage(), $e->getCode()); 
	}catch(Exception $e){
		throw new \skrupel\exceptions\DB('Es ist ein Fehler aufgetreten:'.$e->getMessage(), $e->getCode()); 
	}
	}
	return self::$_instance;
  }
}
