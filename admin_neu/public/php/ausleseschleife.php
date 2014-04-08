<?php
$array = $_POST["inputLicences"];

/*	Zivilistenarea	*/
//	Fahrerlaubnis
$needle = "Fahrerlaubnis";
foreach ($array as $val) {
	if ($val === $needle){
		$civ_driver = 1;
		break;
	}
	else
		$civ_driver = 0;
}
//	Truck
$needle = "Truck";
foreach ($array as $val) {
	if ($val === $needle){
		$civ_truck = 1;
		break;
	}
	else
		$civ_truck = 0;
}
//	Flugschein
$needle = "Flugschein";
foreach ($array as $val) {
	if ($val === $needle){
		$civ_air = 1;
		break;
	}
	else
		$civ_air = 0;
}
//	Bootsschein
$needle = "Bootsschein";
foreach ($array as $val) {
	if ($val === $needle){
		$civ_boat = 1;
		break;
	}
	else
		$civ_boat = 0;
}
//	Tauchen
$needle = "Tauchen";
foreach ($array as $val) {
	if ($val === $needle){
		$civ_dive = 1;
		break;
	}
	else
		$civ_dive = 0;
}
//	Öl
$needle = "Öl";
foreach ($array as $val) {
	if ($val === $needle){
		$civ_oil = 1;
		break;
	}
	else
		$civ_oil = 0;
}
//	Waffenlizenz
$needle = "Waffenlizenz";
foreach ($array as $val) {
	if ($val === $needle){
		$civ_gun = 1;
		break;
	}
	else
		$civ_gun = 0;
}
//	Diamant
$needle = "Diamant";
foreach ($array as $val) {
	if ($val === $needle){
		$civ_diamond = 1;
		break;
	}
	else
		$civ_diamond = 0;
}
//	Kupfer
$needle = "Kupfer";
foreach ($array as $val) {
	if ($val === $needle){
		$civ_copper = 1;
		break;
	}
	else
		$civ_copper = 0;
}
//	Eisen
$needle = "Eisen";
foreach ($array as $val) {
	if ($val === $needle){
		$civ_iron = 1;
		break;
	}
	else
		$civ_iron = 0;
}
//	Sand
$needle = "Sand";
foreach ($array as $val) {
	if ($val === $needle){
		$civ_sand = 1;
		break;
	}
	else
		$civ_sand = 0;
}
//	Salz
$needle = "Salz";
foreach ($array as $val) {
	if ($val === $needle){
		$civ_salt = 1;
		break;
	}
	else
		$civ_salt = 0;
}
//	Zement
$needle = "Zement";
foreach ($array as $val) {
	if ($val === $needle){
		$civ_cement = 1;
		break;
	}
	else
		$civ_cement = 0;
}
//	Cannabis
$needle = "Cannabis";
foreach ($array as $val) {
	if ($val === $needle){
		$civ_marijuana = 1;
		break;
	}
	else
		$civ_marijuana = 0;
}
//	Heroin
$needle = "Heroin";
foreach ($array as $val) {
	if ($val === $needle){
		$civ_heroin = 1;
		break;
	}
	else
		$civ_heroin = 0;
}
//	Kokain
$needle = "Kokain";
foreach ($array as $val) {
	if ($val === $needle){
		$civ_coke = 1;
		break;
	}
	else
		$civ_coke = 0;
}
//	Rebellen
$needle = "Rebellen";
foreach ($array as $val) {
	if ($val === $needle){
		$civ_rebel = 1;
		break;
	}
	else
		$civ_rebel = 0;
}
//	Gang
$needle = "Gang";
foreach ($array as $val) {
	if ($val === $needle){
		$civ_gang = 1;
		break;
	}
	else
		$civ_gang = 0;
}

/*	Coparea	  */
//	Air
$needle = "Air";
foreach ($array as $val) {
	if ($val === $needle){
		$cop_air = 1;
		break;
	}
	else
		$cop_air = 0;
}
//	SWAT
$needle = "SWAT";
foreach ($array as $val) {
	if ($val === $needle){
		$cop_swat = 1;
		break;
	}
	else
		$cop_swat = 0;
}
//	Coastguard
$needle = "Coastguard";
foreach ($array as $val) {
	if ($val === $needle){
		$cop_cg = 1;
		break;
	}
	else
		$cop_cg = 0;
}
?>