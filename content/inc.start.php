<?php
namespace content;

libs\Smarty::get()->addHeader('<link rel="stylesheet" type="text/css" href="statics/css/start.css">');
libs\Smarty::get()->addHeader('<script type="text/Javascript">

</script>');

libs\Smarty::get()->display('header.htm');
libs\Smarty::get()->addLangFile('start');

//!TODO: News zusammensuchen
$news = array(
0 =>'bla',
2 =>'bla',
1 =>'bla'
);
libs\Smarty::get()->assign('news',$news);
libs\Smarty::get()->addLangFile('start');
libs\Smarty::get()->display('start.htm');
libs\Smarty::get()->display('footer.htm');
