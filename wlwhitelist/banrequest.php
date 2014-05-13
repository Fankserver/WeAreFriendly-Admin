<?php
//	Mod Replace komplett. Logging wird korrekt gespeichert und Vehicles werden Problemlos ersetzt... :-)
//	(c) 2014 by Eisbaer | Flo

$tabelle  = "banrequest";
$playerid = $_GET["playerid"];
$timestamp = time();

$tables = array();
$args	= array();

//	Einbinden der Config
include("./php/config.php");
include("./php/functions.php");


//	Update der Daten.

if(isset ($_POST["request_senden"]) AND $_POST["request_senden"] == 1){
	$empty = "";
	$playerid = $_POST["player_id"];
	$bangrund = $_POST["bangrund"];
	$vorfall = $_POST["vorfall"]; 
	$admin = $_SERVER["PHP_AUTH_USER"];
	$datetime  = date("Y-m-d H:i:s", $timestamp);
	
	// FUNKTIONSFÄHIGES STATEMENT! :-)
	$db = new mysqli($mysqlhost, $mysqluser, $mysqlpass, $mysqldb);
	if(mysqli_connect_errno()) {
		echo "Connection Failed: " . mysqli_connect_errno();
		exit();
	}
	if($stmt = $db->prepare("INSERT INTO banrequest (id, playerid, datetime, bangrund, vorfall, admin) VALUES (?, ?, ?, ?, ?, ?)")){
		$stmt->bind_param("isssss", $empty, $playerid, $datetime, $bangrund, $vorfall, $admin);
		$stmt->execute();
		if ($stmt->errno) {
			echo "FAILURE!!! " . $stmt->error;
		}
		$stmt->close();
	}
	else
		print $db->error;
}

//
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
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
						<li><a href="whitelisting.php">Player Whitelist</a></li>
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
					<!-- AB HIER DAS FORMULAR FÜR DIE BANREQUESTS -->
					<?php
					$request=$altislife->lesen($tabelle, "playerid='".$playerid."'", "id", "", "J");
					?>
					<div class="col-md-12">
						<div class="table-responsive">
							<h2>Banrequest f&uuml;r <? print $player->name; ?></h2>
							<form  id="formLicences" name="formLicenses" method="post" action="">
								<input name="request_senden" type="hidden" class="request_senden" 	value="1">
								<input name="player_id" 	type="hidden"  class="player_id" 		value="<? print $playerid; ?>">
								<table class="table">
									<tbody>
										<tr>
											<th><strong></strong></th>
											<th><strong></strong></th>
											<th><strong></strong></th>
											<th><strong></strong></th>
										</tr>
										<tr>
											<td>
											<select class="selectpicker" name="bangrund">
													<optgroup label="Art des Kontaktes">
														<option selected>RDM</option>
														<option>VRDM</option>
														<option>RDM in Safezone</option>
														<option>VRDM in Safezone</option>
														<option>Sonstiges</option>
													</optgroup>
												</select>
											</td>
											<td><textarea class="form-control" name="vorfall" rows="3"></textarea></td>
											<td></td>
											<td><button type="submit" class="btn btn-success">Änderungen speichern</button></td>
										</tr>
									</tbody>
								</table>
							</form>
							<table class="table">
								<tbody>
									<tr>
										<th><strong>Administrator:</strong></th>
										<th><strong>Zeitpunkt:</strong></th>
										<th><strong>Grund:</strong></th>
										<th><strong>Vorfall:</strong></th>
									</tr>
									<?php
									while($request_details = mysql_fetch_object($request)){
										?>
										<tr>
											<td><? print $request_details->admin; ?></td>
											<td><? print $request_details->datetime; ?></td>
											<td><? print $request_details->bangrund; ?></td>
											<td><? print $request_details->vorfall; ?></td>
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