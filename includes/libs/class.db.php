<?php
namespace skrupel\libs;
requre_once(PATH.'includes/libs/db/class.db.php');
requre_once(PATH.'includes/exceptions/class.db.php');
class DB extends db{
  static protected $_instance;
  protected function __construct($dsn, $user="", $passwd=""){
    parent::__construct($dsn, $user, $passwd);
  }

  public function __destruct(){
    parent::__destruct();
  }
  public static function getBD(){
	if(self::instance == null){
      global $config;
	  try{
	  self::$_instance = new skrupel\libs\DB("mysql:host={$config['DB']['host']};port={$config['DB']['port']};dbname={$config['DB']['dbname']}", $config['DB']['user'] ,$config['DB']['password']);
	}catch (PDOException $e) {
	  throw new \skrupel\exceptions\DB('Es ist ein PDO Fehler aufgetreten:'.$e->getMessage(), $e->getCode()); 
	}catch(Exception $e){
		throw new \skrupel\exceptions\DB('Es ist ein Fehler aufgetreten:'.$e->getMessage(), $e->getCode()); 
	}
	}
	return self::$_instance;
  }
}
