<?php

define('INDEX', true);
define('PATH', dirname(__FILE__). '/');

require_once (PATH.'inc.config.php');
require_once (PATH.'includes/func/inc.hilfsfunktionen.php');

require_once(PATH.'includes/class/class.db.php');

//Anlegen der Datenbankverbindung
try{
$db = new db("mysql:host={$config['DB']['host']};port={$config['DB']['port']};dbname={$config['DB']['dbname']}",
              $config['DB']['user'] ,$config['DB']['password']);
} catch (PDOException $e) {
  echo 'Es konnte keine Verbindung zur Datenbank hergestellt werden.:'.$e->getMessage();
  exit();
}catch(Exception $e){
  echo 'Es konnte keine Verbindung zur Datenbank hergestellt werden.:'.$e->getMessage();
  exit(); 
} 
$db->setErrorCallbackFunction("dbErrorCallbackFunction");

require_once('includes/class/class.seite.php');
$seite = new Seite();
 