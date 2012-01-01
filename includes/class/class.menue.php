<?php
namespace content;

class Menue{

	static private $_instance = null;
	protected $_menue = array();

	protected function __construct(){
		$query_string = $_SERVER['QUERY_STRING'];

		$end_pos = 0;
		$first_and = strpos($query_string, '&');
		$first_equal = strpos($query_string, '=');

		if($first_and === false && $first_equal === false){
			$end_pos = strlen($query_string);
		}elseif($first_equal === false || $first_and < $first_equal){
			$end_pos = $first_and;
		}
		$this->_menue = explode('-', substr($query_string, 0,$end_pos));
	}
	
	public static function getInstance(){
		if(self::$_instance === null)	self::$_instance = new Menue();
		return self::$_instance;
	}

	public function getPos($pos){
		if(isset($this->_menue[$pos])) return $this->_menue[$pos];
			else return null;
	}

	public function get($pos){
		return $this->getPos($pos);
	}

	public function getString(){
		return implode('-', $this->_menue);
	}
	public function getArray(){
		return $this->_menue;
	}
}