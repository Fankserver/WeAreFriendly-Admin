<?php
//	Vehicle Replace komplett. Logging wird korrekt gespeichert und Vehicles werden Problemlos ersetzt... :-)
//	(c) 2014 by Eisbaer | Flo

$tabelle  = "whitelist";
$timestamp= time();
$empty = "";
$admin = $_SERVER["PHP_AUTH_USER"];


//	Einbinden der Config
include("./php/config_whitelist.php");
include("./php/functions.php");


//	Update der Daten.
if(isset ($_POST["eintrag"]) AND $_POST["eintrag"] == 1){
	$id = $_POST["id"];
	$i_steamid = $_POST["i_steamid"];
	$i_serverid = "1";
	$s_character = $_POST["s_character"];
	
	//	FUNKTIONSFÄHIGES STATEMENT!
	$db = new mysqli($mysqlhost, $mysqluser, $mysqlpass, $mysqldb);
	if($stmt = $db->prepare("INSERT INTO whitelist (id, i_steamid, i_serverid, s_character) VALUES (?, ?, ?, ?)")){
		$stmt->bind_param("iiss", $empty, $i_steamid, $i_serverid, $s_character);
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
elseif(isset ($_POST["loeschen"]) AND $_POST["loeschen"] == 1){
	$wl_id = $_POST["wl_id"];
	
	//	FUNKTIONSFÄHIGES STATEMENT!
	$db = new mysqli($mysqlhost, $mysqluser, $mysqlpass, $mysqldb);
	if($stmt = $db->prepare("DELETE FROM whitelist WHERE id =?")){
		$stmt->bind_param("i", $wl_id);
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
					<h1 class="page-header">Player Whitelist</h1>
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table">
								<tbody>
									<tr>
										<th><strong>ID:</strong></th>
										<th><strong>SteamID:</strong></th>
										<th><strong>Alias:</strong></th>
										<th><strong></strong></th>
									</tr>
									<?php
									$altislife->lesen($tabelle, "", "id", "");
									$v=0;
									for($v=0; $v<mysql_num_rows($altislife->daten); $v++){
											$wl_player=mysql_fetch_object($altislife->daten);
										?>
										<form  id="formVehicles" name="formVehicles" method="post" action="">
											<input type="hidden" name="loeschen" id="loeschen"	value="1">
											<input type="hidden" name="wl_id" 		 id="wl_id"		value="<? print $wl_player->id; ?>">

											<tr>
												<td><?print $wl_player->id;?></td>
												<td><?print $wl_player->i_steamid;?></td>
												<td><?print $wl_player->s_character;?></td>
												<td><button type="submit" class="btn btn-success">Spieler L&ouml;schen</button></td>
											</tr>
											<?php } ?>
										</form>
								</tbody>
							</table>
					</div>
					<div class="table-responsive">
						<table class="table">
							<tbody>
								<tr>
									<th><strong>ID:</strong></th>
									<th><strong>SteamID:</strong></th>
									<th><strong>Alias:</strong></th>
									<th><strong></strong></th>
								</tr>
								<?php
								$altislife->lesen($tabelle, "", "id", "");
								$v=0;
								for($v=0; $v<mysql_num_rows($altislife->daten); $v++){
										$wl_player=mysql_fetch_object($altislife->daten);
									?>
									<form  id="formVehicles" name="formVehicles" method="post" action="">
										<input type="hidden" name="eintrag" id="eintrag" value="1">
										<!--<input type="hidden" name="id" 		id="id"		 value="<? print $wl_player->id; ?>">-->
										<tr>
											<td><input type="text" name="id"   			value="<?print $wl_player->id;?>"></td>
											<td><input type="text" name="i_steamid"		placeholder="Steam ID"></td>
											<td><input type="text" name="s_character"	placeholder="Spielername"></td>
											<td><button type="submit" class="btn btn-success">Spieler Eintragen</button></td>
										</tr>
										<?php } ?>
									</form>
							</tbody>
						</table>
					</div>

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
