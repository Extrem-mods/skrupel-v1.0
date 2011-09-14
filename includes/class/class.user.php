<?php

class user{
  protected $_id;
  protected $_nick;
  protected $_email;

  public function __construct(){
  $this->tryLogin();
  }
  private function tryAutoLogin(){
  }
  private function tryLogin(){
    $this->checkLogout();
    if(!empty($_SESSION['auth']) && $_SESSION['auth']['login'] == true) $this->tryAutoLogin();
    else{
      if(!empty($_POST['login_name']) && !empty($_POST['login_passwd'])){
        global $db, $config;
        $user = $db->select($config['tables']['user'], 'name like :username', array(":username" => "%{$_POST['login_name']}"));
        
      }
    }
  }    
  public function isLoggedIn(){
    return false;
  }
  private function checkLogout(){
    if(!empty($_GET['logout']) && $_GET['logout'] == 'true'){
      unset($_SESSION['auth']);
      header("HTTP/1.1 303 See Other");
      Header("Location: http://{$_SERVER['SERVER_NAME']}{$_SERVER['PHP_SELF']}");
      exit(); 
    }
  }
  
  static function passwdHash($passwd, $salt, $algo = 'sha256'){
    $hash = $passwd;
    //Rundenfunktion zum ausbremsen von Brute-Force-Angriffe
    for($i = 0; $i<256; $i++){
      $hash = $hash($algo, ($i%2?$passwd:$salt).$hash);  
    }
    return $hash;
  }
  public function getLang(){
    
  }  
}