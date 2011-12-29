<?php
namespace skrupel;
use \skrupel\libs as libs;
require_once(PATH.'includes/libs/class.db.php');
require_once(PATH.'includes/libs/class.smarty.php');
require_once(PATH.'includes/class/class.user.php');

/** Kümmert sich um die Darstellung
 *
 *
 */
class Main{
  private $_user;
  private $_inhalt;
  private $_phpHeader;

  public function __construct(){
    global $config;

    $this->compressOutput();
    $this->_user = new User();
	$this->_lang = $this->_user->getLang();
	libs\Smarty::get()->setLang($this->_lang);
      if($this->_user->isLoggedIn()){
	    $this->build_site();
      }else $this->showLoginPanel();
  }

  public function __destruct(){
    $this->printFooter();
    echo $this->_inhalt;
  }

  /** Schreibt text in den cash, welche beim beenden der Klasse ausgegeben wird.
   *
   *@param $text der auszugebende Text
   */
  public function write($text){
    if(preg_match_all('/{_(?P<file>\w+)\.(?P<opt>\w+)_}/', $text,$matches, PREG_SET_ORDER)){
      foreach($matches as $match){
        global $lang;
        if(empty($lang[$match['file']]))  include_once(PATH.'lang/'.$this->_lang.'/lang.'.$match['file'].'.php');
        $text = str_replace($match[0], $lang[$match['file']][$match['opt']], $text);
      }
    }
    $this->_inhalt .= $text. "\n";
  }

  public function printHeader($titel = '', $header = NULL){
    if(empty($titel)){
      global $config;
      $titel = $config['titel'];
    }
    if(!is_array($header)) $header = array($header);
	$text = '';
    foreach($header as $v){
      $text .= $v."\n";
    }
	libs\Smarty::get()->assign('title', $titel);
	libs\Smarty::get()->assign('header', $text);
    $this->write(libs\Smarty::get()->fetch('header.htm'));
  }

  public function printFooter(){
	$this->write(libs\Smarty::get()->fetch('footer.htm'));
  }

  private function compressOutput(){
    if(strpos(getenv('HTTP_ACCEPT_ENCODING'),'gzip') !== FALSE){
      ob_start('ob_gzhandler');
    }else{
      ob_start();
    }
  }
  /** Gibt den Anmeldebildschirm aus
   *
   */
  private function showLoginPanel(){
    $this->printHeader(null, '<link rel="stylesheet" type="text/css" href="includes/css/login.css">');
	libs\Smarty::get()->addLangFile('login');
    $this->write(libs\Smarty::get()->fetch('login.htm'));
  }

  private function build_site(){
    if(!empty($_GET['seite'])) $seite = $_GET['seite'];
	else $seite = 'index';
	switch ($seite){
	case 'game':
		require_once(PATH.'includes/class/ihnalt/class.game.php');
		$this->site = new skrupel\inhalt\Game($this);
	break;
	case 'forum':
	require_once(PATH.'includes/class/ihnalt/class.forum.php');
		$this->site = new skrupel\inhalt\Forum($this);
	break;
	case 'index':
	default:
	require_once(PATH.'includes/class/ihnalt/class.start.php');
		$this->site = new skrupel\inhalt\Start($this);

	break;
	}

  }
}
