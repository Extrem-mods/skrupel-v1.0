<?php
namespace skrupel;

define('INDEX', true);
define('PATH', dirname(__FILE__). '/');

require_once (PATH.'includes/inc.config.php');
require_once (PATH.'includes/inc.hilfsfunktionen.php');

require_once('includes/class/class.main.php');
$main = new Main();
 