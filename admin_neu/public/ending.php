<?php
//	Letzter Arbeitsstand:
//	Einbinden der Sichtbarkeits für Admins (Donatorlevel, Coplevel)...
//	Logfunktion einbauen !!!!! :P

//	Hannes ist doof.

$tabelle  = "players";
$playerid = $_GET["playerid"];
$timestamp = time();

//	Einbinden der Config
include("./php/config.php");
include("./php/functions.php");


//	Update der Daten.
if(isset ($_POST["pl_update"]) && $_POST["pl_update"] == 1){
	$name	 = $_POST["name"];
	$steamid = $_POST["steamid"];
	$account = $_POST["paypal"];
	$eingang = substr($_POST["eingang"],6,4)."-".substr($_POST["eingang"],3,2)."-".substr($_POST["eingang"],0,2);
	$empty = date("Y-m-d H:i:s");
	$admin = $_SERVER["PHP_AUTH_USER"];
	
	
	$altislife->lesen("donatoruser", "", "id DESC", "", "");
	$id = mysql_fetch_object($altislife->daten);
	$id = $id->id+1;

	// FUNKTIONSFÄHIGES STATEMENT! :-)
	$db = new mysqli($mysqlhost, $mysqluser, $mysqlpass, $mysqldb);
	if(mysqli_connect_errno()) {
		echo "Connection Failed: " . mysqli_connect_errno();
		exit();
	}
	if($stmt = $db->prepare("INSERT INTO donatoruser (id, name, steamid, account, ersteintrag, changep, admin) VALUES (?, ?, ?, ?, ?, ?, ?)")){
		$stmt->bind_param("issssss", $id, $name, $steamid, $account, $eingang, $empty, $admin);
		$stmt->execute();
		if ($stmt->errno) {
			echo "FAILURE!!! " . $stmt->error;
		}
		$stmt->close();
	}
	else
		print $db->error;
}
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
				<p>Angemeldet als:<br><em><<?php print print $_SERVER['PHP_AUTH_USER']; ?></em></p>
				<br>
				<ul class="nav nav-sidebar">
					<li><a href="donatoren.php">Donator</a></li>
					<li class="active"><a href="ending.php">Donator anlegen</a></li>
				</ul>
			</div>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<h1 class="page-header">Donator Eintragen</h1>
					<div class="col-md-6">
						<form  id="formDonator" name="formDonator" method="post" action="">
							<input name="pl_update" 	type="hidden" id="pl_update" 	value="1">
							<div class="form-group">
								<p><strong>Name:</strong></p>
								<input type="text" class="form-control"		name="name"		 placeholder="Name">
							</div>
							<div class="form-group">
								<p><strong>SteamID:</strong></p>
								<input type="text" class="form-control"		name="steamid"	 placeholder="SteamID">
							</div>
							<div class="form-group">
								<p><strong>PayPal-Account:</strong></p>
								<input type="text" class="form-control"		name="paypal"	 placeholder="PayPal-Account">
							</div>
							<div class="form-group">
								<p><strong>Ersteintrag:</strong></p>
								<input type="text" class="form-control"		name="ersteintrag"	 value="<?print date("d.m.Y")?>">
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-success">Änderungen speichern</button>
								<button type="reset" class="btn btn-danger" id="btnReset" value="reset">Änderungen verwerfen</button>
							</div>
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
		<script src="js/bootstrap-select.js"></script>
		<script src="js/holder.js"></script>
		<script src="js/wafgm.js"></script>
	</body>
</html>
