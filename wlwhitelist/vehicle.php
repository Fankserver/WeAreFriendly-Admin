<?php
//	Vehicle Replace komplett. Logging wird korrekt gespeichert und Vehicles werden Problemlos ersetzt... :-)
//	(c) 2014 by Eisbaer | Flo

$tabelle  = "vehicles";
$playerid = $_GET["playerid"];
$vehicle  = $_POST["classn"];
$timestamp= time();
$empty = "";
$admin = $_SERVER["PHP_AUTH_USER"];


//	Einbinden der Config
include("./php/config.php");
include("./php/functions.php");


//	Update der Daten.
if(isset ($_POST["ersatz"]) AND $_POST["ersatz"] == 1){
	//	Auslesen der Fahrzeugdaten
	$carid = $_POST["carid"];
	$ersatz = $_POST["ersatz"];
	$active = "0";
	
	//	FUNKTIONSFÄHIGES STATEMENT!
	$db = new mysqli($mysqlhost, $mysqluser, $mysqlpass, $mysqldb);
	if($stmt = $db->prepare("UPDATE vehicles SET alive=?, active=? WHERE id=?")){
		$stmt->bind_param("iis", $ersatz, $active, $carid);
		$stmt->execute();
		if ($stmt->errno) {
			echo "FAILURE!!! " . $stmt->error;
		}
		$stmt->close();
	}
	else
		print $db->error;
	$db->close();

	
	
	//	Logging!
	$playerid = $_GET["playerid"];
	$vehicle  = $_POST["classn"];
	$timestamp= time();
	$empty = "";
	$admin = $_SERVER["PHP_AUTH_USER"];

	// FUNKTIONSFÄHIGES STATEMENT! :-)
	$db = new mysqli($mysqlhost, $mysqluser, $mysqlpass, $mysqldb);
	if(mysqli_connect_errno()) {
		echo "Connection Failed: " . mysqli_connect_errno();
		exit();
	}
	if($stmt = $db->prepare("INSERT INTO vehicle_repalce (id, playerid, vehicle, admin, timestamp) VALUES (?, ?, ?, ?, ?)")){
		$stmt->bind_param("isssi", $empty, $playerid, $vehicle, $admin, $timestamp);
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
//
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
						<?php if ($admin->modleitung == 1){ ?>
						<li><a href="mod_replaces.php">Replaces</a></li>
						<?php } ?>
					</ul>
				</div>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					
					<?php
					$altislife->lesen("players", "playerid = '".$playerid."'", "", "");
					$player = mysql_fetch_object($altislife->daten);
					?>
					
					<h1 class="page-header"><?print utf8_decode($player->name);?></h1>
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table">
								<tbody>
									<tr>
										<th><strong>ID:</strong></th>
										<th><strong>Seite:</strong></th>
										<th><strong>Fahrzeugtyp:</strong></th>
										<th><strong>Art:</strong></th>
										<th><strong>Zustand:</strong></th>
										<th><strong>Ort:</strong></th>
										<th><strong>Farbe:</strong></th>
										<th><strong>Inventar</strong></th>
									</tr>
									<?php
									$vehicle=$altislife->lesen($tabelle, "pid=".$player->playerid, "id", "", "J");
									$v=0;
									for($v=0; $v<mysql_num_rows($vehicle); $v++){
											$vehicles=mysql_fetch_object($vehicle);
										?>
										<form  id="formVehicles" name="formVehicles" method="post" action="">
											<input type="hidden" name="ersatz" 	id="ersatz" value="1">
											<input type="hidden" name="carid" 	id="carid" 	value="<? print $vehicles->id; ?>">
											<input type="hidden" name="classn"	id="classn"	value="<? print $vehicles->classname; ?>">
											<?php if($vehicles->alive==1){ ?>
											<tr class="success">
												<td><? print $vehicles->id; ?></td>
												<td><? if($vehicles->side=="cop"){ print "Polizei";} else{ print "Zivil";}  ?></td>
												<td><? print $vehicles->classname; ?></td>
												<td><? print $vehicles->type; ?></td>
												<td><? if($vehicles->alive==1){ print "Intakt"; } else{ print "Zerst&ouml;rt"; } ?></td>
												<td><? if($vehicles->active==1){ print "Unterwegs"; } else{ print "Garage"; } ?></td>
												<td><? print $vehicles->color; ?></td>
												<td><? print $vehicles->inventory; ?> </td>
												<td><button type="submit" class="btn btn-success">Fahrzeug ersetzen</button></td>
											</tr>
											<?php } elseif($vehicles->alive==1 AND $vehicles->active==1){ ?>
											<tr class="warning">
												<td><? print $vehicles->id; ?></td>
												<td><? if($vehicles->side=="cop"){ print "Polizei";} else{ print "Zivil";}  ?></td>
												<td><? print $vehicles->classname; ?></td>
												<td><? print $vehicles->type; ?></td>
												<td><? if($vehicles->alive==1){ print "Intakt"; } else{ print "Zerst&ouml;rt"; } ?></td>
												<td><? if($vehicles->active==1){ print "Unterwegs"; } else{ print "Garage"; } ?></td>
												<td><? print $vehicles->color; ?></td>
												<td><? print $vehicles->inventory; ?> </td>
												<td><button type="submit" class="btn btn-success">Fahrzeug ersetzen</button></td>
											</tr>
											<?php } else{ ?>
											<tr class="danger">
												<td><? print $vehicles->id; ?></td>
												<td><? if($vehicles->side=="cop"){ print "Polizei";} else{ print "Zivil";}  ?></td>
												<td><? print $vehicles->classname; ?></td>
												<td><? print $vehicles->type; ?></td>
												<td><? if($vehicles->alive==1){ print "Intakt"; } else{ print "Zerst&ouml;rt"; } ?></td>
												<td><? if($vehicles->active==1){ print "Unterwegs"; } else{ print "Garage"; } ?></td>
												<td><? print $vehicles->color; ?></td>
												<td><? print $vehicles->inventory; ?> </td>
												<td><button type="submit" class="btn btn-success">Fahrzeug ersetzen</button></td>
											</tr>
											<?php } ?>
										</form>
									<?php }	?>
								</tbody>
							</table>
					</div>

					
					<!-- AB HIER DAS FORMULAR FÜR DIE ERSETZUNGEN -->
					<?php
					$anfragen=$altislife->lesen("anfragen", "playerid='".$player->playerid."'", "id", "", "J");
					?>
					<div class="col-md-12">
						<div class="table-responsive">
							<?php if(isset($_POST["ersatz"]) AND $_POST["ersatz"] == 1){ ?>
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
