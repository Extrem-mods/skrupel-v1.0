<?php
namespace content\libs;
require_once(PATH.'includes/libs/smarty/Smarty.class.php');
require_once(PATH.'includes/class/exceptions/class.smarty.php');
class Smarty extends \Smarty{
	protected $_lang;
	protected $_headers = array();
	protected $_errors = array();
	
	protected $_lang_files = null;
	
	static protected $_instance = null;
	
  public function __construct(){
    parent::__construct();
	$this->setTemplateDir(PATH.'content/templates/');
	$this->setCacheDir(PATH.'cache/smarty/');
	$this->setCompileDir(PATH.'cache/smarty/com/');
    $this->setConfigDir(PATH.'cache/smarty/conf/');
	
	//Caching
	//$this->caching = Smarty::CACHING_LIFETIME_CURRENT;
	//Debug Modus
	$this->debugging = false;
	///////////////////////////////
	//Standart Titel festlegen
	global $config;
	$this->assign('title', $config['titel']);
	
	$this->assignByRef('headers', $this->_headers);
	$this->assignByRef('errors', $this->_errors);
  }

  public function __destruct(){
    parent::__destruct();
  }
  
  public function setLang($lang){
	$this->_lang = $lang;
  }
  
  public function addLangFile($file){
	$lang = $this->getTemplateVars('lang');
	$this->clearAssign('lang');
	//if(file_exists(PATH.'lang/'. $this->lang.'/lang.'.$file.'.php'))
	include(PATH.'lang/'. $this->_lang.'/lang.'.$file.'.php');
	$this->assign('lang', $lang);	
  }
  
  static public function get(){
	if(self::$_instance === null) self::$_instance = new namespace\Smarty();
	return self::$_instance;
  }
  public function addHeader($header){
	if(is_array($header))	$this->_headers = $this->_headers + $header;
	else $this->_headers[] = $header;
  }
  public function addError($error){
	if(is_array($error)) $this->_errors = $this->_errors + $error;
	else $this->_errors[] = $error;
  }
}