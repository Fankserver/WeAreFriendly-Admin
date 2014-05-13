<?php
/*
 *	Hier werden die funktionen für sämtliche Scripte der übersicht halber gesammelt.
 *	Diese können durch einbinden an beliebiger Stelle eingefügt und genutzt werden.
 */

//	Funktion Explode für Aliase und Equiptment.
function multiexplode($string){
	$find	 = array("\"[`", "`]\"", "`,`");
	$replace = array("", "", "|");
	$string  = str_replace($find, $replace, $string);
	$string  = explode("|", $string);
	return $string;
}

function aliasexplode($string){
	$find 	 = array("`,`", "\"", "[`", "`]");
	$replace = array(", ", "", "", "");
	$string = str_replace($find, $replace, $string);
	return $string;
}

//	Funktion Match für Cop Lizenzen und Civ Lizenzen
function multimatch($string){
	preg_match_all("([0-9]+)",$string,$string);
	return $string;
}

function licexplode($string){
	preg_match_all("([a-z_]+)",$string,$string, PREG_PATTERN_ORDER);
	return $string;
}

//	Umwandeln der Lizenztexte für die Übersichtsausgabe.
//	Oder wie wir Entwickler sagen: Hanneskonforme Texte. :-P
function lictext($string){
	$steamwords	= array("license_cop_air", 
						"license_cop_swat", 
						"license_cop_cg", 
						"license_civ_driver", 
						"license_civ_air", 
						"license_civ_heroin", 
						"license_civ_marijuana", 
						"license_civ_gang", 
						"license_civ_boat", 
						"license_civ_oil", 
						"license_civ_dive", 
						"license_civ_truck",
						"license_civ_gun", 
						"license_civ_rebel", 
						"license_civ_coke", 
						"license_civ_diamond", 
						"license_civ_copper", 
						"license_civ_iron", 
						"license_civ_sand", 
						"license_civ_salt", 
						"license_civ_cement",
						"license_civ_sugar"
						);
						
	$hannestext	= array("Cop Fluglizenz", 
						"Cop SEK-Lizenz", 
						"Cop K&uuml;stenwache", 
						"Fahrerlizenz",
						"Fluglizenz",
						"Heroinlizenz",
						"Canabislizenz",
						"Ganglizenz",
						"Bootlizenz",
						"&Ouml;llizenz",
						"Tauchlizenz",
						"Trucklizenz",
						"Waffenlizenz",
						"Schwarzmarktlizenz",
						"Kokainlizenz",
						"Diamantenlizenz",
						"Kupferlizenz",
						"Eisenlizenz",
						"Sandlizenz",
						"Salzlizenz",
						"Zementlizenz",
						"Zuckerlizenz"
						);
	
	$string		= str_replace($steamwords, $hannestext, $string);
	return $string;
}

//	Fahrzeuge umbenennen damit man weiss welches es ist
function carreplace($string){
	$car_old = array("B_Quadbike_01_F");
	$car_new = array("Quadbike");
	$string = str_replace($car_old, $car_new, $string);
	return $string;
}
?>