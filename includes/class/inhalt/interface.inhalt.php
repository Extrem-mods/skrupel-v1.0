<?php
namespace skrupel\inhalt{
  interface Inhalt{
	protected $_main;

    public function __construct(\skrupel\Main $main){
	  $this->main = $main;
    }
  }
}