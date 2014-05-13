<?php
//	Ausgabe der ersetzten Dinge durch die Moderatoren
//	(c) 2014 by Eisbaer | Flo

$tabelle1 = "mod_replace";
$tabelle2 = "vehicle_repalce";
$mod	  = $_GET["mods"];
$timestamp= time();
$empty 	  = "";
$admin 	  = $_SERVER["PHP_AUTH_USER"];


//	Einbinden der Config
include("./php/config.php");
include("./php/functions.php");
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
										<th><strong>Admin:</strong></th>
										<th><strong>PlayerID:</strong></th>
										<th><strong>Zeitpunkt:</strong></th>
										<th><strong>Geld:</strong></th>
										<th><strong>Lizenzen:</strong></th>
										<th><strong>Coplevel:</strong></th>
									</tr>
									<?php
									$replace=$altislife->lesen($tabelle1, "admin='".$mod."'", "timestamp DESC", "", "J");
									$v=0;
									for($v=0; $v<mysql_num_rows($replace); $v++){
											$modreplace=mysql_fetch_object($replace);
										?>
										<form  id="formVehicles" name="formVehicles" method="post" action="">
											<input type="hidden" name="id" 	id="id" 	value="<? print $modreplace->id; ?>">
											<tr class="success">
												<td><? print $modreplace->admin; ?></td>
												<td><a href="player.php?playerid=<?print $modreplace->playerid;?>" target="_blank"><?print $modreplace->playerid;?></a></td>
												<td><? print date('l, d F Y G:i:s', ($modreplace->timestamp)); ?></td>
												<td><? print $modreplace->money; ?></td>
												<td><? print $modreplace->lizenzen; ?></td>
												<td><? print $modreplace->coplevel; ?> </td>
											</tr>
										</form>
									<?php }	?>
								</tbody>
							</table>
							<BR>
							<table class="table">
								<tbody>
									<tr>
										<th><strong>Admin:</strong></th>
										<th><strong>PlayerID:</strong></th>
										<th><strong>Zeitpunkt:</strong></th>
										<th><strong>Fahrzeug:</strong></th>
									</tr>
									<?php
									$replace=$altislife->lesen($tabelle2, "admin='".$mod."'", "timestamp DESC", "", "J");
									$v=0;
									for($v=0; $v<mysql_num_rows($replace); $v++){
											$carreplace=mysql_fetch_object($replace);
										?>
										<form  id="formVehicles" name="formVehicles" method="post" action="">
											<input type="hidden" name="id" 	id="id" 	value="<? print $carreplace->id; ?>">
											<tr class="success">
												<td><? print $carreplace->admin; ?></td>
												<td><a href="player.php?playerid=<?print $carreplace->playerid;?>" target="_blank"><?print $carreplace->playerid;?></a></td>
												<td><? print date('l, d F Y G:i:s', ($carreplace->timestamp)); ?></td>
												<?php
												$carnames = $altislife->lesen("vehicles", "id='".$carreplace->vehicle."'", "", "", "J");
												$carname = mysql_fetch_object($carnames);
												?>
												<td><?print $carname->classname; ?></td>
											</tr>
										</form>
									<?php }	?>
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