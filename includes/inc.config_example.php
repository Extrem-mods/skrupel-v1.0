<?php
namespace skrupel;

//Datenbankzugangsdaten
$config['DB']['host']      ='localhost';
$config['DB']['port']      ='3306';
$config['DB']['dbname']    ='';
$config['DB']['user']      ='';
$config['DB']['password']  ='';

//Adminzugangsdaten   //? USer Gruppen (admin/user)?
$config['admin']['name']   = 'admin';
$config['admin']['passwd'] = 'admin';
$config['admin']['email']  = 'info@server.de';

$config['lang']            = 'de';

$config['titel'] = 'Skrupel - Tribute Compilation';


$config['playerColor'][0]  = '#1DC710';    //gruen
$config['playerColor'][1]  = '#E5E203';    //gelb
$config['playerColor'][2]  = '#EAA500';    //orange
$config['playerColor'][3]  = '#875F00';    //braun
$config['playerColor'][4]  = '#bb0000';    //rot
$config['playerColor'][5]  = '#D700C1';    //rosa
$config['playerColor'][6]  = '#7D10C7';    //lila
$config['playerColor'][7]  = '#101DC7';    //blau
$config['playerColor'][8]  = '#049EEF';    //hellblau
$config['playerColor'][9]  = '#10C79B';   //tuerkis

/////////////////////////////////////////////////////////////////////////////////

$config['tables']['planeten'] = 'skrupel_planeten';
$config['tables']['spiele']='skrupel_spiele';
$config['tables']['schiffe']='skrupel_schiffe';
$config['tables']['kampf']='skrupel_kampf';
$config['tables']['user']='skrupel_user';
$config['tables']['sternenbasen']='skrupel_sternenbasen';
$config['tables']['neuigkeiten']='skrupel_neuigkeiten';
$config['tables']['chat']='skrupel_chat';
$config['tables']['forum_thema']='skrupel_forum_thema';
$config['tables']['forum_beitrag']='skrupel_forum_beitrag';
$config['tables']['huellen']='skrupel_huellen';
$config['tables']['anomalien']='skrupel_anomalien';
$config['tables']['nebel']='skrupel_nebel';
$config['tables']['politik']='skrupel_politik';
$config['tables']['politik_anfrage']='skrupel_politik_anfrage';
$config['tables']['konplaene']='skrupel_konplaene';
$config['tables']['info']='skrupel_info';
$config['tables']['ordner']='skrupel_ordner';
$config['tables']['scan']='skrupel_scan';
$config['tables']['begegnung']='skrupel_begegnung';

/////////////////////////////////////////////////////////////////////////////////

date_default_timezone_set('Europe/Berlin');
//Error Behandlung, bei bedarf aktivieren
ini_set('display_errors', 0);
ini_set('log_errors', 0);
ini_set('ignore_repeated_errors', 1);
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('error_log', 'C:/skrupel/log/log.txt');
