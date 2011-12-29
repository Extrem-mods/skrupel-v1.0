<?php
namespace skrupel;
require_once(PATH.'includes/class/libs/class.db.php');
require_once(PATH.'includes/class/class.user.php');

/** Kümmert sich um die Darstellung
 *
 * Die Klasse kümmert sich um die Darstellung der Seiteninhalte udn um das ersetzen der Language Tags ({_[filename].[Parameter]_})
 *
 */
class Main{
  private $_db;
  private $_smarty;
  private $_user;
  private $_inhalt;
  private $_phpHeader;
  private $_lang;
  private $_site;

  public function __construct(){
    global $config;
	//Datenbank
	try{
	  $this->_db = new skrupel\libs\DB("mysql:host={$config['DB']['host']};port={$config['DB']['port']};dbname={$config['DB']['dbname']}",
              $config['DB']['user'] ,$config['DB']['password']);
	} catch (skrupel\exceptions\DB $e) {
		echo 'Es konnte keine Verbindung zur Datenbank hergestellt werden.:'.$e->getMessage();
		exit();
	} catch (PDOException $e) {
		echo 'Es konnte keine Verbindung zur Datenbank hergestellt werden.:'.$e->getMessage();
		exit();
	}catch(Exception $e){
		echo 'Es konnte keine Verbindung zur Datenbank hergestellt werden.:'.$e->getMessage();
		exit();
	}
	//Smarty
	$this->_smarty = new skrupel\libs\Smarty();

    $this->compressOutput();
    $this->user = new User();
	$this->_lang = $this->_user->getLang();
      if($this->user->isLoggedIn()){
	    $this->build_site();
      }
    }else{
      $this->showLoginPanel();
    }
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
  $text = <<<EOT
<!Doctype html>
<head>
  <title>$titel</title>
  <link rel="stylesheet" type="text/css" href="includes/css/main.css">

EOT;
    foreach($header as $v){
      $text .= $v."\n";
    }
    $text .= <<<EOT
  </head>
  <body>
EOT;
    $this->write($text);
  }

  public function printFooter(){
  $text = <<<EOT
  </body>
</html>
EOT;
  $this->write($text);
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
    $text = <<<EOT
    <div class="login">
      <form action="{$_SERVER['PHP_SELF']}" method="POST">
      {_login.userName_}: <input type="text" name="login_name" value="">
      {_login.passwd_}: <input type="text" name="login_passwd" value="">
      <input type="submit" name="login_sub" value="{_login.login_}"><button href="" class="button" >{_login.lostPasswd_}</button>

      </form>
    </div>
EOT;
    $this->write($text);
  }

  private function build_site(){
    if(!empty($_GET['seite']) $seite = $_GET['seite'];
	else $seite = 'index';
	switch ($seite{
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
