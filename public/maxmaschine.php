<?php
//	[=WAF=] Maxmaschine
//	(c) 2014 by Eisbaer | Flo

$tabelle  = "players";
//$wafmod = $_SERVER["PHP_AUTH_USER"];


//	Einbinden der Config
include("./php/config.php");
include("./php/functions.php");

$steamid = array("76561198037202795", "76561198070761657", "76561198125743088");
// $steamid = array("76561198037202795","76561198070761657","76561198125743088","76561198051466749","76561198051466749","76561198107643686","76561198082354005","76561198048877641","76561198070666461","76561198022091758","76561198045185480","76561197977381749","76561198112672974","76561197977650430","76561198110124106","76561198038925501","76561197994217604","76561197976361038","76561198068351046","76561198003611104","76561198009924766","76561197970274406","76561197967539064","76561198069957443","76561197965456523","76561198010858329","76561198057416294","76561198085110709","76561198012555840","76561197962847576","76561198039104037","76561197985847004","76561198003099564","76561198068278445","76561197988932155","76561198118866658","76561198037671365","76561198124442532","76561198072335769","76561198124629295","76561198055732250","76561198031882304","76561198062490883","76561198061583535","76561198063387689","76561198049136627","76561198039489213","76561198050717856","76561198067143925","76561198052683042","76561198045686115","76561198028729294","76561198057388939","76561198034505967","76561198041582893","76561198048092048","76561198093013466","76561198025913858","76561198057004262","76561198083682684","76561198083682684","76561198067120766","76561198078703424","76561198090943352","76561197960405139","76561198044909023","76561198050794852","76561198059483093","76561198019417875","76561197980143071","76561198119434626","76561198026981347","76561198050687127","76561198040049122","76561198060727579","76561197997297726","76561197971614618","76561198088900828","76561198070642733","76561198031529451","76561198048833907","76561198057016078","76561198054555099","76561197961094080","76561197983772048","76561198006740388","76561198015946862","76561198052130252","76561198054645412","76561198051117695","76561198088062798","76561197973560191","76561198048991645","765611980745816","76561198072563755","76561198067842708","76561198062534659","76561198073577423","76561198086337258","76561198067262215","76561197960291969","76561198015830901","76561198089639617","76561198060592388","76561198092844818","76561198053569407","76561197960345779","76561198065248334","76561198025078167","76561198071202468","76561197977395374","76561197990394599","76561198028596654","76561198026306194","76561197986356653","76561198070185304","76561198040287629","76561198033469109","76561198055116184","76561197978597450","76561197960857952","76561198001462875","76561197986637590","76561198072375282","76561197960291894","76561198125773384","76561198035808025","76561198031381012","6561197984019583","76561198059515903","76561197968771438","76561197991739454","76561197994657329","76561198073578449","76561197970426335","76561198102526678","76561198096687566","76561198072093497","76561197970880431","76561198040285287","76561198045719870","76561198082916259","76561198074130101","76561198039292677","76561198081292039","76561197998384290","76561197993577218","76561197960431282","76561198022321044","76561198046806584","76561198064292761","76561198000090500","76561197982441782","76561198008208037","76561198049790527","76561198010304244","76561197985943846","76561198062710253","76561198024061524","76561198084319654","76561198027990664","76561198063885337","765611979977609","76561197994193700","76561198090984148","76561198067057641","76561198047879146","76561197963573004","76561197972645711","76561198086280749","76561198021249161","76561198119062787","76561198067214274","76561198042865402","76561198122429310","76561198011842789","76561198044698960","76561198044636276","76561197988286919","76561198007217275","76561198007894287","76561197989131573","76561197961069966","76561198040347569","76561197982891838","76561197970885405","76561198002446275","76561197986475760","76561198065410007","76561198012193949","76561198016104237","76561198086983263","76561197985220616","76561198060259905","76561197999138158","76561197978264352","76561197984841352","76561197999060849","76561198059013794","76561198106519015","76561198093560787","76561198097640977","76561198010925684","76561197986017920","76561197980028310","76561198059857407","76561198065803596","76561198002166686","76561198049400746","76561198130023322","76561198080842781","76561198032192516","76561198065378726","76561198051189724","76561198061344765","76561198105336493","6561198054837031","76561197998334255","76561198076344921","76561198074091908","76561198064677754","76561198136696849","76561198123104282");


print "Starte Maxmaschine 2.0...<br><br>";

for($e=0; $e < count($steamid); $e++){
	//	Auslesen der Tabelle mit den Infos über die Player.
	$altislife->lesen($tabelle, "playerid = '".$steamid[$e]."'", "", "");
	$playerold = mysql_fetch_object($altislife->daten);


	//	Update der Daten.		
	//if(isset($_POST["wafmod"])){
	//	$wafmod = $_POST["wafmod"]; 
	//}
	//else
	$wafmod = "maxpfeiffer";
	
	
	$playerid1 = $steamid[$e];
	$cop_air = "0";
	$cop_swat = "0";
	$cop_cg = "0";
	$coplevel = "0";
	$coplic2 = "\"[[`license_cop_air`,".$cop_air."], [`license_cop_swat`,".$cop_swat."], [`license_cop_cg`,".$cop_cg."]]\"";
	
	
	//	FUNKTIONSFÄHIGES STATEMENT!
	$db = new mysqli($mysqlhost, $mysqluser, $mysqlpass, $mysqldb);
	if(mysqli_connect_errno()){
		echo "Connection Failed: " . mysqli_connect_errno();
		exit();
	}
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
	if(mysqli_connect_errno()){
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
	
	print "Coplevel von: <b>".$playerold->name."</b> von ".$playerold->coplevel." auf ".$coplevel." geaendert.<br>";
}
$anzahl = count($steamid);
print "<br>Maxmaschine 2.0 erfolgreich beendet. Es wurden ".$anzahl." Polizisten degradiert.";
?>