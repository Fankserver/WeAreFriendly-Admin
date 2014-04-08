<?php
//	Letzter Arbeitsstand:
//	Einbinden der Suchfunktion und hinzufügen der Datenbankabfrage fürs Formular...
//	ToDo:	User anzeigen und 20 pro Seite auflisten.


//	Einbinden der Config
include("./php/config.php");
include("./php/functions.php");


$maxzeilen=20;

$offset=intval($_GET["offset"]);

if(strlen($_GET["inputSteamId"])>0){
	$field = "playerid";
	$suche = $_GET["inputSteamId"];
	$suchabfrage = $field." = '".$suche."'";
}
	
elseif(strlen($_GET["inputPlayerName"])>0){
	$field = "name";
	$suche = $_GET["inputPlayerName"];
	$suchabfrage = $field." = '".$suche."'";
}

elseif(strlen($_GET["inputAccount"])>0){
	$field = "account";
	$suche = $_GET["inputAccount"];
	$suchabfrage = $field." like '%%".$suche."%%'";
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
				<p>Angemeldet als:<br><em><?php print $_SERVER["PHP_AUTH_USER"]; ?></em></p>
				<br>
				<ul class="nav nav-sidebar">
					<li class="active"><a href="index.php">Donator</a></li>
					<li><a href="ending.php">Donator anlegen</a></li>
				</ul>
			</div>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">Donator-Informationen</h1>

				<div class="col-md-6">
					<form action="" method="get">
						<div class="form-group">
							<label for="inputSteamId">Steam-ID</label>
							<input type="text" class="form-control" name="inputSteamId" placeholder="Steam-ID eingeben">
						</div>
						<div class="form-group">
							<label for="inputPlayerName">Spielername</label>
							<input type="text" class="form-control" name="inputPlayerName" placeholder="Spielername eingeben">
						</div>
						<div class="form-group">
							<label for="inputAccount">PayPal-Account</label>
							<input type="text" class="form-control" name="inputAccount" placeholder="Alias eingeben">
						</div>
						<button type="submit" class="btn btn-default">Suche starten</button>
						<button type="reset" class="btn btn-default" value="reset">Zurücksetzen</button>
					</form>
				</div>

				<?php
				//	Hier geschieht das Auslesen der Player Datenbank. Damit die Seite nicht zu voll ist, werden immer nur 20 Player pro Content angezeigt!
				//	$altislife->lesen($tabelle, $suchabfrage, $sortierung, "$offset, $maxzeilen");
				$altislife->lesen("donatoruser", $suchabfrage, "", "");
				?>
				<div class="col-md-12">
					<h3 class="sub-header">Suchergebnisse:</h3>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Steam-ID</th>
									<th>Name</th>
									<th>PayPal-Account</th>
									<th>Donatorende</th>
								</tr>
							</thead>
							<tbody>
								<?php
								for($p=0; $p<mysql_num_rows($altislife->daten); $p++){
								$donator = mysql_fetch_object($altislife->daten);
								?>
									<tr>
										<td><a href="donator.php?donatorid=<?print $donator->id;?>&steamid=<?print $donator->steamid;?>&name=<?print $donator->name;?>"><?print $donator->steamid;?></a></td>
										<td><?print utf8_decode($donator->name);?></td>
										<td><?print $donator->account;?></td>
										<?php
										$details = $altislife->lesen("donatoreintrag", "userid = ".$donator->id, "", "", "J");
										$detailszeile = mysql_fetch_object($details);
										$donatorend = substr($detailszeile->donatorend,8,2).".".substr($detailszeile->donatorend,5,2).".".substr($detailszeile->donatorend,0,4);
										?>
										<td><?print $donatorend;?></td>
									</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>
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
