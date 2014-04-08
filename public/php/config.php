<?php
//	Datenbankkonfiguration und einlesen der Datenbankklasse
$mysqlhost="localhost";
$mysqluser="waf";
$mysqlpass="2sCvWamLnEfxZfX8";
$mysqldb="arma3life";

$sql=mysql_connect($mysqlhost,$mysqluser,$mysqlpass);
$db=$mysqldb;

define("MYSQL_PASS",$mysqlpass);
define("MYSQL_HOST",$mysqlhost);
define("MYSQL_USER",$mysqluser);
define("MYSQL_DB",$mysqldb);

include("waf.class.php");

$altislife=new arma($mysqlhost,$mysqluser,$mysqlpass,$mysqldb);

$altislife->lesen("admins", "admin='".$_SERVER["PHP_AUTH_USER"]."'", "", "");
$admin = mysql_fetch_object($altislife->daten);


//	Konfiguration globaler Strings (Titel, Copyright etc.)
$title = "[=WAF=] Admin 2.0";
$copy  = "(c) ".date("Y")." - powered by Eisbaer & nano ..::.. Version 1.1.1";
?>