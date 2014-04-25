<?php
//	Datenbankkonfiguration und einlesen der Datenbankklasse
$mysqlhost="localhost";
$mysqluser="wafwl";
$mysqlpass="2sCvWamLnEfxZfX8";
$mysqldb="arma3lifewhitelist";

$sql=mysql_connect($mysqlhost,$mysqluser,$mysqlpass);
$db=$mysqldb;

define("MYSQL_PASS",$mysqlpass);
define("MYSQL_HOST",$mysqlhost);
define("MYSQL_USER",$mysqluser);
define("MYSQL_DB",$mysqldb);

include("waf.class.php");

$altislife=new arma($mysqlhost,$mysqluser,$mysqlpass,$mysqldb);

class DatabaseManager{
    function DatabaseManager(){
        mysql_connect($mysqlhost, $mysqluser, $mysqlpass);
        mysql_select_db($mysqldb);
    }

    function query($query){
        $result = mysql_query($query);
        return $result;
    }

} 

$altislife->lesen("admins", "admin='".$_SERVER["PHP_AUTH_USER"]."'", "", "");
$admin = mysql_fetch_object($altislife->daten);


//	Konfiguration globaler Strings (Titel, Copyright etc.)
$title = "[=WAF=] Admin 2.0";
$copy  = "(c) ".date("Y")." - powered by Eisbaer & nano ..::.. Version 1.1.2";
?>