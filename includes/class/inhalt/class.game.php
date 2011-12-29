<?php
require_once(PATH.'includes/class/inhalt/interface.inhalt.php');
class Game implements Inhalt{
  public function __construct(\skrupel\Main $main){
    parent::__construct($main);
	
  }
  
}