<?php
//	[=WAF=] Maxmaschine
//	(c) 2014 by Eisbaer | Flo

$tabelle  = "players";
$wafmod = $_SERVER["PHP_AUTH_USER"];


//	Einbinden der Config
include("./php/config.php");
include("./php/functions.php");

$steamid = array("76561198037202795", "76561198070761657", "76561198125743088");


print "Starte Maxmaschine 2.0...<br><br>";

for($e=0; $e < count($steamid); $e++){
	//	Auslesen der Tabelle mit den Infos über die Player.
	$altislife->lesen($tabelle, "playerid = '".$steamid[$e]."'", "", "");
	$playerold = mysql_fetch_object($altislife->daten);


	//	Update der Daten.		
	if(isset($_POST["wafmod"])){
		$wafmod = $_POST["wafmod"]; 
	}
	else
		$wafmod = "eisbaer";
	
	
	$playerid1 = $steamid[$e];
	$cop_air = "0";
	$cop_swat = "0";
	$cop_cg = "0";
	$coplevel = "0";
	$coplic2 = "\"[[`license_cop_air`,".$cop_air."], [`license_cop_swat`,".$cop_swat."], [`license_cop_cg`,".$cop_cg."]]\"";
	
	
	//	FUNKTIONSFÄHIGES STATEMENT!
	$db = new mysqli($mysqlhost, $mysqluser, $mysqlpass, $mysqldb);
	if($stmt = $db->prepare("UPDATE players SET coplevel=?, cop_licenses=? WHERE playerid = ?")){
		$stmt->bind_param("sss", $coplevel, $coplic2, $playerid1);
		$stmt->execute();
		if ($stmt->errno) {
			echo "FAILURE!!! " . $stmt->error;
		}
		$stmt->close();
	}
	else
		print $db->error;
	$db->close();
	
	
	
	//	Ab hier beginnt das Logging der Spielerdaten!
	$admin = $wafmod;
	$empty = "";
	
	//	Logging Spezial
	$cashflow = "0";
	$lizenzen_text = "";
	$coplevel_text = "";
	$donator_text = ""; 	
	if($coplevel != $playerold->coplevel){
		$coplevel_text = "Coplevel von ".$playerold->coplevel." auf ".$coplevel." geaendert. powered by Maxmaschine.";
	}
	else{
		$coplevel_text = "Coplevel nicht geaendert!";
	}
	
	// FUNKTIONSFÄHIGES STATEMENT! :-)
	$db = new mysqli($mysqlhost, $mysqluser, $mysqlpass, $mysqldb);
	if(mysqli_connect_errno()) {
		echo "Connection Failed: " . mysqli_connect_errno();
		exit();
	}
	if($stmt = $db->prepare("INSERT INTO mod_replace (id, admin, playerid, timestamp, money, lizenzen, coplevel, donatorlvl) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")){
		$stmt->bind_param("ississss", $empty, $admin, $playerid1, $timestamp, $cashflow, $lizenzen_text, $coplevel_text, $donator_text);
		$stmt->execute();
		if ($stmt->errno) {
			echo "FAILURE!!! " . $stmt->error;
		}
		$stmt->close();
	}
	else
		print $db->error;
	$db->close();
	
	print "Coplevel der SteamID: ".$playerold->name." von ".$playerold->coplevel." auf ".$coplevel." geaendert.<br>";
}
$anzahl = count($steamid);
print "<br>Maxmaschine 2.0 erfolgreich beendet. Es wurden ".$anzahl." Polizisten degradiert. ;
?>