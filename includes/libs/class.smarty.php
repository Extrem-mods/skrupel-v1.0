<?php
namespace skrupel\libs;
requre_once(PATH.'includes/libs/smarty/Smarty.class.php');
requre_once(PATH.'includes/exceptions/class.smarty.php');
class Smarty extends \Smarty{
	protected $_lang;
	protected $_lang_files = null;
	
	static protected $_instance = null;
	
  protected function __construct(){
    parent::__construct();
	$this->setTemplateDir(PATH.'includes/templates/');
	$this->setCacheDir(PATH.'cache/smarty/');
  }

  public function __destruct(){
    parent::__destruct();
  }
  public function setLang($lang){
	$this->_lang = $lang;
  }
  public function addLangFile($file){
  
  }
  static public function get(){
	if(self::$_instance === null) self::$_instance = new namespace\Smarty();
	return self::$_instance;
  }
}