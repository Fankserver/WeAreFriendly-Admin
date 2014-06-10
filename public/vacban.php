<?php
//	Ausgabe der ersetzten Dinge durch die Moderatoren
//	(c) 2014 by Eisbaer | Flo

$tabelle1 = "account";
$timestamp= time();
$empty 	  = "";
$admin 	  = $_SERVER["PHP_AUTH_USER"];
$steamid  = $_GET["inputSteamId"];


//	Einbinden der Config
include("./php/config_vac.php");
include("./php/functions.php");


//	Update der Daten.
if(isset ($_POST["pl_update"]) AND $_POST["pl_update"] == 1){
	
	$id				= $_POST["id"];
	$i_steamid		= $_POST["steamid"];
	$b_vacbanned	= $_POST["vacbanned"];
	$s_battleyeguid	= $_POST["battleye"];
	$dt_check		= $_POST["dt_check"];
	
	if($_POST["bypassvnc"] == "on")
		$b_bypassvnc = 1;
	else
		$b_bypassvnc = 0;
	
	if($_POST["bypasscountry"] == "on")
		$b_bypasscountry = 1;
	else
		$b_bypasscountry = 0;

	
	//	FUNKTIONSFÄHIGES STATEMENT!
	$db = new mysqli($mysqlhost, $mysqluser, $mysqlpass, $mysqldb);
	if($stmt = $db->prepare("UPDATE account SET b_bypassvac=?, b_bypasscountry=? WHERE i_steamid=?")){
		$stmt->bind_param("ssi", $b_bypassvnc, $b_bypasscountry, $i_steamid);
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
<html lang="de">
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
						<?php if ($_SERVER["PHP_AUTH_USER"] == "eisbaer"){ ?>
						<li><a href="admins.php">Admins</a></li>
						<?php } ?>
						<?php if ($_SERVER["PHP_AUTH_USER"] == "eisbaer" OR $_SERVER["PHP_AUTH_USER"] == "marten3010"){ ?>
						<li><a href="vacbans.php">VAC Konsole</a></li>
						<?php } ?>
					</ul>
				</div>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					
					<?php
					$altislife->lesen($tabelle1, "i_steamid='".$steamid."'", "", "");
					$vactool = mysql_fetch_object($altislife->daten);
					?>
					<form  id="formLicences" name="formLicenses" method="post" action="">
						<input name="id" 			type="hidden" id="id" 			value="<?print $vactool->id;?>">
						<input name="steamid" 		type="hidden" id="steamid" 		value="<?print $vactool->i_steamid;?>">
						<input name="vacbanned" 	type="hidden" id="vacbanned" 	value="<?print $vactool->b_vacbanned;?>">
						<input name="battleye"		type="hidden" id="battleye"		value="<?print $vactool->s_battleyeguid;?>">
						<h1 class="page-header"><?print utf8_decode($vactool->i_steamid);?></h1>
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table">>
									<div class="form-group">
										<p><strong>Steam VAC Ban:</strong>&nbsp;<input type="checkbox" name="bypassvnc" 			<?php if($vactool->b_bypassvnc == 1){print "checked";}?>></p>
										<p><strong>Country Restriction:</strong>&nbsp;<input type="checkbox" name="bypasscountry"   <?php if($vactool->b_bypasscountry  == 1){print "checked";}?>></p>
									</div>
									<BR><button type="submit" class="btn btn-success">Änderungen speichern</button>
								</table>
								<BR>
							</div>
						</div>
					</form>
					<div class="col-footer">
						<h5 class="footer">
							<footer><cite title="Footer Copyright"><?print $copy;?></cite></footer>
						</h5>
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