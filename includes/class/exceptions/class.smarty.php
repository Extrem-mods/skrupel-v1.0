<?php
namespace skrupel\exceptions;
class Smarty extends \Exception{
  
  public function __construct($message = null, $code = 0){
    parent::__construct($message, $code = );
  }
}