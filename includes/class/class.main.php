<?php
namespace content;

require_once(PATH.'includes/libs/class.db.php');
require_once(PATH.'includes/libs/class.smarty.php');
require_once(PATH.'includes/class/class.user.php');
require_once(PATH.'includes/class/class.content.php');

/** Verwaltungsklasse
 *
 *
 */
class Main{
  private $_user;
  private $_content;

  public function __construct(){
    global $config;

	$error = '';
	$this->_user = new User();
	try{
		$this->_user->tryLogin();
	}catch(exceptions\User $e){
		$error = $e->getMessage();
	}
	$this->_lang = $this->_user->getLang();
	libs\Smarty::get()->setLang($this->_lang);
	libs\Smarty::get()->assign('error', $error);
  }

  public function __destruct(){
  }

  	public function gehtIncludePath(){
		$include = PATH.'content/';
		$i = 0;
		$item ='start';
		while(is_dir($include)){
			$tmp = MENUE::getInstance()->get($i);
			if(empty($tmp)) break;
			$item = $tmp;
			$include.=$item.'/';			
			$i++;
		}
		throw new \Exception('Startpunkt "'. $include.'inc.'.$item.'.php" nicht gefunden.');
	}
}
