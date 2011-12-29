<?php
namespace skrupel\inhalt{
  require_once(PATH.'includes/class/inhalt/interface.inhalt.php');
  class Start implements Inhalt{
	private $_smarty;
	
	public __construct(\skrupel\Main $main){
		parent::__construct($main);
	}
	public __destruct(){
	}
  }
}