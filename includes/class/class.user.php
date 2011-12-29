<?php
namespace skrupel;
class user{
  protected $_db;
  protected $_id;
  protected $_nick;

  public function __construct(){
	try{
	  $this->_db = libs\DB::getDB();
	}catch(\skrupel\exceptions\DB $e){
		echo $e->getMessage();
		return;
	}
    $this->tryLogin();
  }

  public function __destruct(){
    $this->_db = NULL;
  }

  private function tryAutoLogin(){
	return;
  }

  private function tryLogin(){
    global $config;
    $this->checkLogout();
	$this->tryAutoLogin();
    if(!$this->isLoggedIn()){
      if(!empty($_POST['login_name']) && !empty($_POST['login_passwd'])){
        $user = $this->_db->select($config['tables']['user'], 'login_name like :lname', array(":lname" => "%{$_POST['login_name']}"), 'id, nick, passwd, salt');
        if(!empty($user[0])){
          if($user[0]['passwd'] == self::passwdHash($_POST['login_passwd'], $user[0]['salt'])){ //llogin erfolgreich
            $this->login($user[0]['id'], $user[0]['nick']);
          }
        }
      }
    }
  }

  public function isLoggedIn(){
    if(!empty($_SESSION['auth']) && $_SESSION['auth']['login'] === true && $_SESSION['auth']['id'] > 0)	return true;
	else return false;
  }
  private function login($id, $nick){
	$this->_id = $id;
	$this->_nick = $nick;
	$_SESSION['auth'] = array('login'=>true, 'id' => $this->_id, 'nick' => $this->_nick);
  }
  private function checkLogout(){
    if(!empty($_GET['logout']) && $_GET['logout'] == 'true'){
      unset($_SESSION['auth']);
      header("HTTP/1.1 303 See Other");
      Header("Location: http://{$_SERVER['SERVER_NAME']}{$_SERVER['PHP_SELF']}");
      exit();
    }
  }

  public function getLang(){
	global $config;
    if($this->isLoggedIn()){
      $lang = $this->getInfo('lang');
	  return $lang['lang'];
    }else{
      return $config['lang'];
    }
  }
  public function getInfo($option){
	if(!$this->isLoggedIn())  return NULL;
	$optionen = array('id', 'nick', 'email'); // Infos ueber den USer die auserhalb der User KLasse interesant sein koennten (also KEIN passwort, KEIN SALT etc.)
	$op2 = '';
	if(is_array($option)){
	  foreach($option as $op){
	    $op =  strlower($op);
		if(in_array($op, $optionen)) $op2 .= $op .', ';
	  }
	  if(!empty($op2)) $op2 = substr($op2, 0, -2);
	  else return NULL;
	}else{
      $op2 = strlower($option);
	  if(!in_array($option, $optionen))	return NULL;
	}
	$info = $this->_db->select($config['tables']['user'], 'id like :id', array(":id" => "%{$this->_id}"), $op2);
	return $info[0];
  }

  static function registUser($name, $email, $passwd=''){

  }
  /** fuer das erstellen eines Psswortes
   *
   */
  static function passwdHash($passwd, $salt, $algo = 'sha256'){
    $hash = $passwd;
    //Rundenfunktion zum ausbremsen von Brute-Force-Angriffe
    for($i = 0; $i<256; $i++){
      $hash = hash($algo, ($i%2?$passwd:$salt).$hash);
    }
    return $hash;
  }
}