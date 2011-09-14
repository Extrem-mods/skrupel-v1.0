<?php

class user{
  protected $_id;
  protected $_nick;
  protected $_email;

  public function __construct(){
  }
    
  public function isLoggedIn(){
    return false;
  }  
}