<?php

class ImgWrapper{
  const PNG = 1;
  const GIF = 2;
  private $_localPath = '/images/';
  //private $_remothePath = '';
  private $_order = array(PNG,GIF);
  
  public function __construct(){
  }
  
  public function getClientOrder(){
    return $_order;
  }
  
  public function getImgPath($img){
    foreach($_order as $v){
      swicth($v){
          case PNG:
          if(!(file_exists($_localPath.'$img.png') && self::clientSupport(PNG)))  continue 2;
          return $_localPath.'$img.png';
          case GIF:
          if(!(file_exists($_localPath.'$img.gif') && self::clientSupport(GIF)))  continue 2;
          return $_localPath.'$img.gif';        
      }
      return NULL;
    }
  }
  /*
  public setRemotePath($path){
    if(is_dir($path) &&  is_dir($path.'/png/') && is_dir($path.'/gif/')){
      $this->_remothePath = $path;
      return true;
    }
    return false;
  )
  */
  public static clientSupport($typ){
    return true;
    
  }  
}