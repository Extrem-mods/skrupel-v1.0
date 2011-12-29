<?php
namespace skrupel\libs;
requre_once(PATH.'includes/libs/smarty/Smarty.class.php');
requre_once(PATH.'includes/exceptions/class.smarty.php');
class Smarty extends \Smarty{
  public function __construct(){
    parent::__construct();
  }

  public function __destruct(){
    parent::__destruct();
  }
}