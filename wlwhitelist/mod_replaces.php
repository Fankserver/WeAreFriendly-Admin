<?php
//	Vehicleauflistung komplett.
//	(c) 2014 by Eisbaer | Flo

//	Einbinden der Config
include("./php/config.php");
include("./php/functions.php");
$tabelle = "admins";

$maxzeilen=20;

$offset=intval($_GET["offset"]);

if(strlen($_GET["admin"])>0){
	$field = "admin";
	$suche = $_GET["admin"];
	$suchabfrage = $field." = '".$suche."'";
}
else
	$suchabfrage = "";

$suche=$_GET["suche"];


/*
for($i=0; $i<count($suche); $i++) {
	$einschraenkung=current($suche);
	if(strlen($einschraenkung)) {
		if(strlen($suchabfrage)>0) {
			$suchabfrage.=" AND ";
			$getsuche.="&";
		}
		$suchabfrage.=key($suche)." like '%%".$einschraenkung."%%'";
		$getsuche.="suche[".key($suche)."]=".urlencode($einschraenkung);
	}
	next($suche);
}
*/

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
			<h1 class="page-header">Moderator Ersetungen</h1>
			
			<?php
			$altislife->lesen($tabelle, "", "admin", "");
			?>
				<div class="col-md-6">
					<form action="mod_replace.php" method="GET">
					<input type="hidden" name="abfrage" value="1">
						<div class="form-group">
							<div class="form-group">
								<p><strong>Moderatoren:</strong></p>
								<select class="selectpicker" name="mods">
								<?php
								for($m=0; $m<mysql_num_rows($altislife->daten); $m++){
									$moderatoren = mysql_fetch_object($altislife->daten);
									?>
									<option name="mods<?print $m;?>"><?print utf8_decode($moderatoren->admin); ?></option>
									<?php
								}
								?>
								</select>
							</div>
						</div>
						<button type="submit" class="btn btn-default">Abfrage starten</button>
						<button type="reset" class="btn btn-default" value="reset">Zur&uuml;cksetzen</button>
					</form>
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
	<script src="js/holder.js"></script>
	</body>
</html>
