<?php

class user{
  protected $_id;
  protected $_nick;
  protected $_email;
  protected $_seite;

  public function __construct(&$seite){
    $this->_seite = $seite; 
    $this->tryLogin();
  }
  public function __destruct(){
    $this->_seite = NULL;
  }
  
  private function tryAutoLogin(){
  }
  
  private function tryLogin(){
    global $db, $config, $seite;
    $this->checkLogout();
    if(!empty($_SESSION['auth']) && $_SESSION['auth']['login'] == true) $this->tryAutoLogin();
    else{
      if(!empty($_POST['login_name']) && !empty($_POST['login_passwd'])){
        $user = $db->select($config['tables']['user'], 'name like :username', array(":username" => "%{$_POST['login_name']}"), 'id, passwd, salt');
        if(!empty($user[0])){
          if($user[0]['passwd'] == self::passwdHash($_POST['login_passwd'], $user[0]['salt'])){ //llogin erfolgreich
          }else{  //Login fehlgeschlagen
          $this->_seite->write('<div class="error">{_login.loginFail_}</div>');
          }
        }else{
          $this->_seite->write('<div class="error">{_login.loginFail_}</div>');
        }
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
  
  public function getLang(){
    if(isLoggedIn()){
      global $db;
      //!TODO
      $lang =  $db->select($config['tables']['user'], 'id like :id', array(':id' => "%{$this->_id}"), 'lang');
            
    }else{
      global $config;
      return $config['lang'];
    }    
  }
  private function registUser($name, $email, $passwd=''){
    
  }  
  /** für das erstellen eines Psswortes 
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