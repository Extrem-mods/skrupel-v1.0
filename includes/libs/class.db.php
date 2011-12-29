<?php
namespace skrupel\libs;
requre_once(PATH.'includes/libs/db/class.db.php');
requre_once(PATH.'includes/exceptions/class.db.php');
class DB extends db{
  public function __construct($dsn, $user="", $passwd=""){
    parent::__construct($dsn, $user, $passwd);
  }

  public function __destruct(){
    parent::__destruct();
  }
}
