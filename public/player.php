<?php
//	Mod Replace komplett. Logging wird korrekt gespeichert und Vehicles werden Problemlos ersetzt... :-)
//	(c) 2014 by Eisbaer | Flo

$tabelle  = "players";
$playerid = $_GET["playerid"];
$timestamp = time();

#$tables = array();
#$args	= array();

//	Einbinden der Config
include("./php/config.php");
include("./php/functions.php");

//	Auslesen der Tabelle mit den Infos über die Player.
$altislife->lesen($tabelle, "playerid = '".$playerid."'", "", "");
$werte = mysql_fetch_object($altislife->daten);


//	Update der Daten.
if(isset ($_POST["pl_update"]) AND $_POST["pl_update"] == 1){
	include("./php/ausleseschleife.php");
	
	$playeruid = $_POST["player_uid"];
	$playerid1 = $_POST["player_id"];
	$playername = $_POST["player_name"];
	$playerid = $_POST["player_id"];
	$cash = $_POST["money_hand"];
	$bankacc = $_POST["money_bank"];
	$coplevel = $_POST["coplevel"];	
	$donatorlvl = $_POST["donatorlvl"];
	$cop_gear = $_POST["cop_gear"];
	$civ_gear = $_POST["civ_gear"];
	$aliases = $_POST["aliases"];
	$adminlevel = $_POST["adminlevel"];
	
	if($_POST["arrested"] == "on")
		$arrested = 1;
	else
		$arrested = 0;

	if($_POST["blacklist"] == "on")
		$blacklist = 1;
	else
		$blacklist = 0;
	
	$coplic2 = "\"[[`license_cop_air`,".$cop_air."], [`license_cop_swat`,".$cop_swat."], [`license_cop_cg`,".$cop_cg."]]\"";
	$civlic2 = "\"[[`license_civ_driver`,".$civ_driver."],[`license_civ_air`,".$civ_air."],[`license_civ_heroin`,".$civ_heroin."],[`license_civ_marijuana`,".$civ_marijuana."],[`license_civ_gang`,".$civ_gang."],[`license_civ_boat`,".$civ_boat."],[`license_civ_oil`,".$civ_oil."],[`license_civ_dive`,".$civ_dive."],[`license_civ_truck`,".$civ_truck."],[`license_civ_gun`,".$civ_gun."],[`license_civ_rebel`,".$civ_rebel."],[`license_civ_coke`,".$civ_coke."],[`license_civ_diamond`,".$civ_diamond."],[`license_civ_copper`,".$civ_copper."],[`license_civ_iron`,".$civ_iron."],[`license_civ_sand`,".$civ_sand."],[`license_civ_salt`,".$civ_salt."],[`license_civ_cement`,".$civ_cement."]]\"";
	
	
	//	FUNKTIONSFÄHIGES STATEMENT!
	$db = new mysqli($mysqlhost, $mysqluser, $mysqlpass, $mysqldb);
	if($stmt = $db->prepare("UPDATE players SET cash=?, bankacc=?, coplevel=?, cop_licenses=?, civ_licenses=?, arrested=?, donatorlvl=?, blacklist=? WHERE playerid = ?")){
		$stmt->bind_param("iisssssss", $cash, $bankacc, $coplevel, $coplic2, $civlic2, $arrested, $donatorlvl, $blacklist, $playerid1);
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
	$empty = "";
	$admin = $_SERVER["PHP_AUTH_USER"];

	//	Logging - Cash
	$cashflow = 0;
	$cashflow_hand = 0;
	$cashflow_bank = 0;
	if($cash != $_POST["money_hand_old"]){
		if($cash > $_POST["money_hand_old"]){ $cashflow_hand = $cash - $_POST["money_hand_old"]; }
		elseif($cash < $_POST["money_hand_old"]){ $cashflow_hand = $_POST["money_hand_old"] - $cash; }
	}
	if($bankacc != $_POST["money_bank_old"]){
		if($bankacc > $_POST["money_bank_old"]){ $cashflow_bank = $bankacc - $_POST["money_bank_old"]; }
		elseif($bankacc < $_POST["money_bank_old"]){ $cashflow_bank = $_POST["money_bank_old"] - $bankacc; }
	}
	$cashflow = $cashflow_hand + $cashflow_bank;
	
	//	if($cash != $_POST["money_hand_old"]){$cashflow_hand = $cash - $_POST["money_hand_old"];}
	//	if($bankacc != $_POST["money_bank_old"]){$cashflow_bank = $bankacc - $_POST["money_bank_old"];}
	//	$cashflow = $cashflow_hand + $cashflow_bank;
	
	
	//	Logging - Lizenzen
	$lizenzen_text = "";
	if($civ_driver	!= $_POST["li_driver_old"]){$lizenzen_text = $lizenzen_text."Fahrlizenz, ";}
	if($civ_truck	!= $_POST["li_truck_old"]){$lizenzen_text = $lizenzen_text."Trucklizenz, ";}
	if($civ_air		!= $_POST["li_air_old"]){$lizenzen_text = $lizenzen_text."Fluglizenz, ";}
	if($civ_boat	!= $_POST["li_boat_old"]){$lizenzen_text = $lizenzen_text."Bootslizenz, ";}
	if($civ_gang	!= $_POST["li_gang_old"]){$lizenzen_text = $lizenzen_text."Ganglizenz, ";}
	if($civ_heroin 	!= $_POST["li_heroin_old"]){$lizenzen_text = $lizenzen_text."Heroinlizenz, ";}
	if($civ_marijuana!= $_POST["li_marijuana_old"]){$lizenzen_text = $lizenzen_text."Marijuanalizenz, ";}
	if($civ_coke	!= $_POST["li_coke_old"]){$lizenzen_text = $lizenzen_text."Kokalizenz, ";}
	if($civ_diamond	!= $_POST["li_diamond_old"]){$lizenzen_text = $lizenzen_text."Diamantlizenz, ";}
	if($civ_copper 	!= $_POST["li_copper_old"]){$lizenzen_text = $lizenzen_text."Kupferlizenz, ";}
	if($civ_iron 	!= $_POST["li_iron_old"]){$lizenzen_text = $lizenzen_text."Eisenlizenz, ";}
	if($civ_sand	!= $_POST["li_sand_old"]){$lizenzen_text = $lizenzen_text."Sandlizenz, ";}
	if($civ_salt 	!= $_POST["li_salt_old"]){$lizenzen_text = $lizenzen_text."Salzlizenz, ";}
	if($civ_cement 	!= $_POST["li_cement_old"]){$lizenzen_text = $lizenzen_text."Zementlizenz, ";}
	
	if($arrested != $_POST["arrested_old"]){$lizenzen_text = $lizenzen_text."Gefaengnisstatus, ";}
	if($blacklist != $_POST["blacklist_old"]){$lizenzen_text = $lizenzen_text."Blacklisted, ";}
	
	//	Logging Spezial
	$coplevel_text = "";
	$donator_text = ""; 	
	if($coplevel != $_POST["coplevel_old"]){$coplevel_text = "Coplevel von ".$_POST["coplevel_old"]." auf ".$coplevel." geaendert";}
	if($donatorlvl != $_POST["donlvl_old"]){$donator_text = "Donatorlevel von ".$_POST["donlvl_old"]." auf ".$donatorlvl." geaendert";}
	
	// FUNKTIONSFÄHIGES STATEMENT! :-)
	$db = new mysqli($mysqlhost, $mysqluser, $mysqlpass, $mysqldb);
	if(mysqli_connect_errno()) {
		echo "Connection Failed: " . mysqli_connect_errno();
		exit();
	}
	if($stmt = $db->prepare("INSERT INTO mod_replace (id, admin, playerid, timestamp, money, lizenzen, coplevel, donatorstatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")){
		$stmt->bind_param("ississss", $empty, $admin, $playerid, $timestamp, $cashflow, $lizenzen_text, $coplevel_text, $donator_text);
		$stmt->execute();
		if ($stmt->errno) {
			echo "FAILURE!!! " . $stmt->error;
		}
		$stmt->close();
	}
	else
		print $db->error;
	$db->close();
}


// Kontakt erfassen
	
if(isset ($_POST["kontakt_eintragen"]) && $_POST["kontakt_eintragen"] == 1){
	$empty = "";
	$admin = $_SERVER["PHP_AUTH_USER"];
	$kontakt_art = $_POST["kontakt_art"];
	$kontakt_text = $_POST["kontakt_text"];
	$verhalten = $_POST["kontakt_verhalten"];
	
	// FUNKTIONSFÄHIGES STATEMENT! :-)
	$db = new mysqli($mysqlhost, $mysqluser, $mysqlpass, $mysqldb);
	if(mysqli_connect_errno()) {
		echo "Connection Failed: " . mysqli_connect_errno();
		exit();
	}
	if($stmt = $db->prepare("INSERT INTO anfragen (id, admin, playerid, text, art, timestamp, verhalten) VALUES (?, ?, ?, ?, ?, ?, ?)")){
		$stmt->bind_param("isssiii", $empty, $admin, $playerid, $kontakt_text, $kontakt_art, $timestamp, $verhalten);
		$stmt->execute();
		if ($stmt->errno) {
			echo "FAILURE!!! " . $stmt->error;
		}
		$stmt->close();
	}
	else
		print $db->error;
	$db->close();
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="shortcut icon" href="../../assets/ico/favicon.ico">

		<title><?print $title;?></title>

		<!-- Bootstrap core CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-select.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="css/dashboard.css" rel="stylesheet">

		<!-- Just for debugging purposes. Don't actually copy this line! -->
		<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php"><?print $title;?></a>
				</div>
			</div>
		</div>

		<div class="container-fluid">
			<div class="row placeholders">
				<div class="col-sm-3 col-md-2 sidebar">
					<p>Angemeldet als:<br><em><? print $_SERVER["PHP_AUTH_USER"]; ?></em></p>
					<br>
					<ul class="nav nav-sidebar">
						<li class="active"><a href="index.php">Hauptmen&uuml;</a></li>
						<li><a href="players.php">Spieler</a></li>
						<li><a href="vehicles.php">Fahrzeuge</a></li>
						<?php if ($admin->donatorstatus == 1){ ?>
						<li><a href="donatoren.php">Donator</a></li>
						<?php } ?>
					</ul>
				</div>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					
					<?php
					$altislife->lesen($tabelle, "playerid = '".$playerid."'", "", "");
					$player = mysql_fetch_object($altislife->daten);
					?>
					
					<h1 class="page-header"><?print utf8_decode($player->name);?> - <a href="banrequest.php?playerid=<?php print $player->playerid;?>"><button type="submit" class="btn">Ban Anfragen</button></a></h1>
					<div class="col-md-6">
						<div class="table-responsive">
							<p>Allgemeine Informationen</p>
							<table class="table table-striped">
								<tbody>
									<tr>
										<td><strong>Steam-ID:</strong></td>
										<td><ul><li><a href="http://steamcommunity.com/profiles/<?php print $player->playerid;?>" target="_blank"><?php print $player->playerid;?></a></ul></li></td>
									</tr>
									<?php	
									if($admin->donatorstatus == 1){ ?>
										<tr>
											<td><strong>Donator:</strong></td>
											<td>
												<ul>
													<?php if($player->donatorlvl>0){ ?>
														<li><strong>Stufe <?php print $player->donatorlvl;?></strong></li>
													<?php }
													elseif($player->donatorlvl==0){ ?>
														<li>Stufe <?php print $player->donatorlvl;?></li>
													<?php } ?>
												</ul>
											</td>
										</tr>
										<?php
									}
									//	Anzeigen des Adminlevels!
									//	Adminlevel aus "players" oder aus "admins" anzeigen??
									if($admin->adminstatus == 1){
										?>
										<tr>
											<td><strong>Admin:</strong></td>
											<td>
												<ul>
													<?php if($player->adminlevel>0){ ?>
														<li><strong>Stufe <?php print $player->adminlevel;?></strong></li>
													<?php }
													elseif($player->adminlevel==0){ ?>
														<li>Stufe <?php print $player->adminlevel;?></li>
													<?php } ?>
												</ul>
											</td>
										</tr>
										<?php
									}
									?>
									<tr>
										<td><strong>Finanzen:</strong></td>
										<td>
											<ul>
												<li>Konto: <strong class="text-danger">$<?php print $player->bankacc;?></strong></li>
												<li>Bargeld: <strong>$<?php print $player->cash;?></strong></li>
											</ul>
										</td>
									</tr>
									<tr>
										<td><strong>Aliase:</strong></td>
										<td>
										<?php
										$aliases = multiexplode($player->aliases);
										?>
											<ul>
												<?php
												foreach($aliases AS $aliase){
													?>
													<li><?print utf8_decode($aliase);?></li>
													<?php
												}
												?>
											</ul>
										</td>
									</tr>
									<tr>
										<td><strong>Lizenzen:</strong></td>
										<td>
											<ul>
												<?php
												$civlic = licexplode($player->civ_licenses);
												$civact = multimatch($player->civ_licenses);
												//print lictext($licenses);
												$l=0;
												for($l=0; $l<count($civlic[0]); $l++){
													if($civact[0][$l] == 1){
														?>
														<li><?print lictext($civlic[0][$l]);?></li>
														<?php
													}
												}
												//	Cop Lizenzen
												$coplic = licexplode($player->cop_licenses);
												$copact = multimatch($player->cop_licenses);
												//print lictext($licenses);
												$l=0;
												for($l=0; $l<count($coplic[0]); $l++){
													if($copact[0][$l] == 1){
														?>
														<li><strong><?print lictext($coplic[0][$l]);?></strong></li>
														<?php
													}
												}
												?>
											</ul>
										</td>
									</tr>
									<tr>
										<td><strong>Polizei:</strong></td>
										<td>
											<ul>
												<?php
												if($admin->copstatus == 1){ ?>
													<?php if($player->coplevel>0){ ?>
														<li><strong>Level <?php print $player->coplevel;?></strong></li>
													<?php }
													elseif($player->coplevel==0){ ?>
														<li>Level <?php print $player->coplevel;?></li>
													<?php 
													}
												}
												?>
												
												<?php if($player->blacklist==1){ ?>
													<li><strong class="text-danger">Auf der Blacklist</strong></li>
												<?php }
												else{ ?>
													<li>Nicht auf der Blacklist</li>
												<?php }
												?><?php if($player->arrested==1){ ?>
													<li><strong class="text-danger">Im Gef&auml;ngnis</strong></li>
												<?php }
												else{ ?>
													<li>Nicht im Gef&auml;ngnis</li>
												<?php }
												?>
											</ul>
										</td>
									</tr>
									<tr>
										<td><strong>Fahrzeuge:</strong></td>
										<td>
											<ul>
											<?php
											$fahrzeuge=$altislife->lesen("vehicles", "pid=".$player->playerid, "id", "", "J");
											$fahrzeuge=mysql_num_rows($fahrzeuge);
											?>
											<li><? print $fahrzeuge; ?> Fahrzeuge</li><br><a href="vehicle.php?playerid=<?php print $player->playerid;?>"><button type="submit" class="btn btn-info">Fahrzeuge Anzeigen</button></a>
											</ul>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-6 licences">
						<form  id="formLicences" name="formLicenses" method="post" action="">
							<input name="pl_update" 	type="hidden" id="pl_update" 	value="1">
							<input name="player_id" 	type="hidden" id="player_id" 	value="<?print $player->playerid;?>">
							<!--<input name="adminlevel" 	type="hidden" id="adminlevel" 	value="<?print $player->adminlevel;?>">-->
							<input name="adminid"		type="hidden" id="adminid"		value="<?print $admins->id;?>">
							<input name="admin"			type="hidden" id="admin"		value="<?print $admins->admin;?>">
							
							<?php
							$civli = multimatch($player->civ_licenses);
							$copli = multimatch($player->cop_licenses);
							?>
							
							<!-- Alte Lizenzen Übertragen... -->
							<input name="li_driver_old"		type="hidden"		value="<?print $civli[0][0];?>">
							<input name="li_air_old"		type="hidden"		value="<?print $civli[0][1];?>">
							<input name="li_heroin_old"		type="hidden"		value="<?print $civli[0][2];?>">
							<input name="li_marijuana_old"	type="hidden"		value="<?print $civli[0][3];?>">
							<input name="li_gang_old"		type="hidden"		value="<?print $civli[0][4];?>">
							<input name="li_boat_old"		type="hidden"		value="<?print $civli[0][5];?>">
							<input name="li_oil_old"		type="hidden"		value="<?print $civli[0][6];?>">
							<input name="li_dive_old"		type="hidden"		value="<?print $civli[0][7];?>">
							<input name="li_truck_old"		type="hidden"		value="<?print $civli[0][8];?>">
							<input name="li_gun_old"		type="hidden"		value="<?print $civli[0][9];?>">
							<input name="li_rebel_old"		type="hidden"		value="<?print $civli[0][10];?>">
							<input name="li_coke_old"		type="hidden"		value="<?print $civli[0][11];?>">
							<input name="li_diamond_old"	type="hidden"		value="<?print $civli[0][12];?>">
							<input name="li_copper_old"		type="hidden"		value="<?print $civli[0][13];?>">
							<input name="li_iron_old"		type="hidden"		value="<?print $civli[0][14];?>">
							<input name="li_sand_old"		type="hidden"		value="<?print $civli[0][15];?>">
							<input name="li_salt_old"		type="hidden"		value="<?print $civli[0][16];?>">
							<input name="li_cement_old"		type="hidden"		value="<?print $civli[0][17];?>">
							
							<input name="li_cop_air_old"	type="hidden"		value="<?print $copli[0][0];?>">
							<input name="li_cop_swat_old"	type="hidden"		value="<?print $copli[0][1];?>">
							<input name="li_cop_cg_old"		type="hidden"		value="<?print $copli[0][2];?>">
							<input name="coplevel_old"		type="hidden"		value="<?print $player->coplevel;?>">
							<input name="donlvl_old"		type="hidden"		value="<?print $player->donatorlvl;?>">
							<input name="arrested_old"		type="hidden"		value="<?print $player->arrested;?>">
							<input name="blacklisted_old"	type="hidden"		value="<?print $player->blacklist;?>">
							<input name="money_bank_old"	type="hidden"		value="<?print $player->bankacc;?>">
							<input name="money_hand_old"	type="hidden"		value="<?print $player->cash;?>">
							
							<?php if($admin->copstatus == 0){ ?>
								<input name="coplevel"		type="hidden"		value="<?print $player->coplevel;?>">
							<?php } ?>
							<?php if($admin->donatorstatus == 0){ ?>
								<input name="donatorlvl"		type="hidden"		value="<?print $player->donatorlvl;?>">
							<?php } ?>
							
							<div class="form-group">
								<p><strong>Lizenzen:</strong></p>

								<select multiple class="selectpicker" name="inputLicences[]" data-selected-text-format="count" data-count-selected-text="{0} von {1}" data-none-selected-text="Keine Lizenzen">
									<!--Auswahlbereich für die Fahrzeuglizenzen-->
									<optgroup label="Fahrzeug-Lizenzen">
										<option name="li_driver"  	<?php if($civli[0][0]  == 1){print "selected";}?>>Fahrerlaubnis</option>
										<option name="li_truck"   	<?php if($civli[0][8]  == 1){print "selected";}?>>Truck</option>
										<option name="li_air"     	<?php if($civli[0][1]  == 1){print "selected";}?>>Flugschein</option>
										<option name="li_boat"    	<?php if($civli[0][5]  == 1){print "selected";}?>>Bootsschein</option>
										<option name="li_dive"    	<?php if($civli[0][7]  == 1){print "selected";}?>>Tauchen</option>
									</optgroup>
									
									<!--Auswahlbereich für die Verarbeitungslizenzen-->
									<optgroup label="Verarbeitungs-Lizenzen">
										<option name="li_oil"     	<?php if($civli[0][6]  == 1){print "selected";}?>>Oel</option>
										<option name="li_gun"     	<?php if($civli[0][9]  == 1){print "selected";}?>>Waffenlizenz</option>
										<option name="li_diamond" 	<?php if($civli[0][12] == 1){print "selected";}?>>Diamant</option>
										<option name="li_copper"  	<?php if($civli[0][13] == 1){print "selected";}?>>Kupfer</option>
										<option name="li_iron"   	<?php if($civli[0][14] == 1){print "selected";}?>>Eisen</option>
										<option name="li_sand"  	<?php if($civli[0][15] == 1){print "selected";}?>>Sand</option>
										<option name="li_salt"    	<?php if($civli[0][16] == 1){print "selected";}?>>Salz</option>
										<option name="li_cement"    <?php if($civli[0][17] == 1){print "selected";}?>>Zement</option>
									</optgroup> 
									
									<!--Auswahlbereich für die Illegale Lizenzen-->
									<optgroup label="Illegale Lizenzen">
										<option name="li_marijuana" <?php if($civli[0][3]  == 1){print "selected";}?>>Cannabis</option>
										<option name="li_heroin"    <?php if($civli[0][2]  == 1){print "selected";}?>>Heroin</option>
										<option name="li_coke"      <?php if($civli[0][11] == 1){print "selected";}?>>Kokain</option> 
									</optgroup> 
									
									<!--Auswahlbereich für die Gruppen Lizenzen-->
									<optgroup label="Gruppen-Lizenzen">
										<option name="li_rebel"     <?php if($civli[0][10] == 1){print "selected";}?>>Rebellen</option>
										<option name="li_gang"      <?php if($civli[0][4]  == 1){print "selected";}?>>Gang</option>
									</optgroup>

									
									<!--Auswahlbereich für die Cop Lizenzen-->
									<optgroup label="Polizei-Lizenzen">
										<option name="li_cop_air"   <?php if($copli[0][0]  == 1){print "selected";}?>>Air</option>
										<option name="li_cop_swat"  <?php if($copli[0][1]  == 1){print "selected";}?>>SWAT</option>
										<option name="li_cop_cg"    <?php if($copli[0][2]  == 1){print "selected";}?>>Coastguard</option>
									</optgroup>
								</select>
							</div>
							<?php
							if($admin->copstatus == 1){
								?>
								<div class="form-group">
									<p><strong>Coplevel:</strong></p>
									<select class="selectpicker" name="coplevel">
									<option name="coplevel0"  	<?php if($player->coplevel == 0){print "selected";}?>>0</option>
									<option name="coplevel1"  	<?php if($player->coplevel == 1){print "selected";}?>>1</option>
									<option name="coplevel2"  	<?php if($player->coplevel == 2){print "selected";}?>>2</option>
									<option name="coplevel3"  	<?php if($player->coplevel == 3){print "selected";}?>>3</option>
									<option name="coplevel4"  	<?php if($player->coplevel == 4){print "selected";}?>>4</option>
									<option name="coplevel5"  	<?php if($player->coplevel == 5){print "selected";}?>>5</option>
									<option name="coplevel6"  	<?php if($player->coplevel == 6){print "selected";}?>>6</option>
									<option name="coplevel7"  	<?php if($player->coplevel == 7){print "selected";}?>>7</option>
									<option name="coplevel8"  	<?php if($player->coplevel == 8){print "selected";}?>>8</option>
									<option name="coplevel9"  	<?php if($player->coplevel == 9){print "selected";}?>>9</option>
									</select>
								</div>
								<?php
							}
							if($admin->donatorstatus == 1){
								?>
								<div class="form-group">
									<p><strong>Donatorlevel:</strong></p>
									<select class="selectpicker" name="donatorlvl">
									<option name="donatorlvl0"  <?php if($player->donatorlvl == 0){print "selected";}?>>0</option>
									<option name="donatorlvl1"  <?php if($player->sonatorlvl == 1){print "selected";}?>>1</option>
									<option name="donatorlvl2"  <?php if($player->donatorlvl == 2){print "selected";}?>>2</option>
									<option name="donatorlvl3"  <?php if($player->donatorlvl == 3){print "selected";}?>>3</option>
									</select>
								</div>
								<?php
							}
							?>
							<div class="form-group">
								<p><strong>Blacklist:</strong>&nbsp;<input type="checkbox" name="blacklist" <?php if($player->blacklist == 1){print "checked";}?>></p>
								<p><strong>Arrested:</strong>&nbsp;<input type="checkbox" name="arrested"   <?php if($player->arrested  == 1){print "checked";}?>></p>
							</div>
							<div class="form-group">
								<label for="money_bank">Kontostand:</label>
								<input type="number" class="form-control"  name="money_bank" min="0" max="999999999" value="<?print $player->bankacc;?>">
							</div>
							<div class="form-group">
								<label for="money_hand">Bargeld:</label>
								<input type="number" class="form-control"  name="money_hand" min="0" max="999999999" value="<?print $player->cash;?>">
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-success">Eingaben Speichern</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<button type="reset" class="btn btn-danger" id="btnReset" value="reset">Verwerfen</button>
								<BR><BR>
								<form>
									<input name="kontaktfeld" type="hidden" class="kontaktfeld" value="1">
										<button type="submit" class="btn btn-warning">Nur Kontakt Eintragen</button>
								</form>&nbsp;&nbsp;&nbsp;&nbsp;
							</div>
						</form>
					</div>
					
					<!-- AB HIER DAS FORMULAR FÜR DIE ERSETZUNGEN -->
					<?php
					$anfragen=$altislife->lesen("anfragen", "playerid='".$player->playerid."'", "id", "", "J");
					?>
					<div class="col-md-12">
						<div class="table-responsive">
							<?php if($_POST["kontaktfeld"] == 1 OR $_POST["pl_update"] == 1){ ?>
							<h2>Neuer Eintrag:</h2>
							<form  id="formLicences" name="formLicenses" method="post" action="">
								<input name="kontakt_eintragen" type="hidden" class="kontakt_eintragen" 	value="1">
								<table class="table">
									<tbody>
										<tr>
											<th><strong></strong></th>
											<th><strong></strong></th>
											<th><strong></strong></th>
											<th><strong></strong></th>
											<th><strong></strong></th>
										</tr>
										<tr>
											<td>
												<select class="selectpicker" name="kontakt_art">
													<optgroup label="Art des Kontaktes">
														<option value="0" selected>Bitte wählen...</option>
														<option value="1">Polizeilevel</option>
														<option value="2">Ersatz wegen RDM</option>
														<option value="3">Ersatz wegen Bug</option>
														<option value="4">Ersatz sonstiges</option>
														<option value="5">Verwarnung</option>
														<option value="6">VRDM</option>
														<option value="7">RDM</option>
														<option value="8">VRDM in Safezone</option>
														<option value="9">RDM in Safezone</option>
														<option value="10">Beleidigung</option>
														<option value="11">Griefing</option>
														<option value="12">Donator</option>
													</optgroup>
												</select>
											</td>
											<td>
											<select class="selectpicker" name="kontakt_verhalten">
													<optgroup label="Art des Kontaktes">
														<option value="0">Unbekannt</option>
														<option value="5">Patzig/Angepisst</option>
														<option value="4">Uneinsichtig</option>
														<option value="3"selected>Neutral</option>
														<option value="2">Einsichtig</option>
														<option value="1">Sehr gut</option>
													</optgroup>
												</select>
											</td>
											<td><textarea class="form-control" name="kontakt_text" rows="3"></textarea></td>
											<td><button type="submit" class="btn btn-success">Änderungen speichern</button></td>
										</tr>
									</tbody>
								</table>
							</form>
							<?php } ?>
							<table class="table">
								<tbody>
									<tr>
										<th><strong>Administrator:</strong></th>
										<th><strong>Zeitpunkt:</strong></th>
										<th><strong>Art des Kontaktes:</strong></th>
										<th><strong>Verhalten:</strong></th>
										<th><strong>Vorfall:</strong></th>
									</tr>
									<?php
									while($anfragen_details = mysql_fetch_object($anfragen)){
										if($anfragen_details->art == 0){$art_text = "ohne Grundangabe";}
										if($anfragen_details->art == 1){$art_text = "Polizei Level";}
										if($anfragen_details->art == 2){$art_text = "Ersatz wegen RDM";}
										if($anfragen_details->art == 3){$art_text = "Ersatz wegen Bug";}
										if($anfragen_details->art == 4){$art_text = "Ersatz sonstiges";}
										if($anfragen_details->art == 5){$art_text = "Verwarnung";}
										if($anfragen_details->art == 6){$art_text = "VRDM";}
										if($anfragen_details->art == 7){$art_text = "RDM";}
										if($anfragen_details->art == 8){$art_text = "VRDM in Savezone";}
										if($anfragen_details->art == 9){$art_text = "RDM in Savezone";}
										if($anfragen_details->art == 10){$art_text = "Beleidigung";}
										if($anfragen_details->art == 11){$art_text = "Griefing";}
										if($anfragen_details->art == 12){$art_text = "Donator";}
										
										if($anfragen_details->verhalten == 0){$verhalten_text = "Unbekannt";}
										if($anfragen_details->verhalten == 1){$verhalten_text = "Sehr gut";}
										if($anfragen_details->verhalten == 2){$verhalten_text = "Einsichtig";}
										if($anfragen_details->verhalten == 3){$verhalten_text = "Neutral";}
										if($anfragen_details->verhalten == 4){$verhalten_text = "Uneinsichtig";}
										if($anfragen_details->verhalten == 5){$verhalten_text = "Patzig/Angepisst";}
																		
										$ts_ausgabe = date('l, d F Y G:i:s', ($anfragen_details->timestamp));
										?>
										<tr>
											<td><? print $anfragen_details->admin; ?></td>
											<td><? print $ts_ausgabe; ?></td>
											<td><? print $art_text; ?></td>
											<td><? print $verhalten_text; ?></td>
											<td><? print $anfragen_details->text; ?></td>
										</tr>
									<? } ?>
								</tbody>
							</table>
						</div>
					</div>
					
					<!-- HIER ENDET DAS FORMULAR FÜR DIE ERSETZUNGEN -->
					<div class="col-footer">
						<h5 class="footer">
						<footer><cite title="Footer Copyright"><?print $copy;?></cite></footer>
						</h5>
					</div>
				</div>
			</div>
		</div>

		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/bootstrap-select.js"></script>
		<script src="js/holder.js"></script>
		<script src="js/wafgm.js"></script>
	</body>
</html>