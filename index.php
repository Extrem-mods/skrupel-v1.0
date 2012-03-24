<?php
namespace content;

define('INDEX', true);
define('PATH', dirname(__FILE__). '/');
$protokoll = 'http';
if(!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off')
$protokoll = 'https';
define('PROTOKOLL', $protokoll);

if(is_dir(PATH.'install/')){
	@include(PATH.'includes/inc.config_example.php');
	@include(PATH.'includes/inc.config.php');
	require_once (PATH.'includes/libs/class.smarty.php');
	$dir = dirname($_SERVER['SCRIPT_NAME']);
	//!TODO translation 
	libs\Smarty::get()->addError('
	<p>Aus sicherheitsgründen kann Skrupel nicht betrieben werden, solange das Verzeichniss "'.$dir.'/install/" existiert. </p>
	<p>Wenn Sie Skrupel noch nicht instaliert haben, führen Sie bitte das <a href="'.PROTOKOLL.'://'.$_SERVER['SERVER_NAME'].$dir.'/install/">Instalationsskript</a> aus und löschen Sie anschließend das Verzeichnis.</p>');
	libs\Smarty::get()->display('header.htm');
	libs\Smarty::get()->display('error.htm');
	libs\Smarty::get()->display('footer.htm');
	die();
}

require_once (PATH.'includes/inc.config.php');
require_once (PATH.'includes/inc.hilfsfunktionen.php');

require_once('includes/class/class.main.php');
$main = new Main();

try{
$path = $main->gehtIncludePath();
}catch(\Exception $e){
	libs\Smarty::get()->addError($e->getMessage());
	libs\Smarty::get()->display('header.htm');
	libs\Smarty::get()->display('error.htm');
	libs\Smarty::get()->display('footer.htm');
	die();
}

include $path;