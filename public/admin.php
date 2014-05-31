<?php
//	Ausgabe der ersetzten Dinge durch die Moderatoren
//	(c) 2014 by Eisbaer | Flo

$tabelle1 = "admins";
$mod	  = $_GET["mods"];
$timestamp= time();
$empty 	  = "";
$admin 	  = $_SERVER["PHP_AUTH_USER"];


//	Einbinden der Config
include("./php/config.php");
include("./php/functions.php");


//	Update der Daten.
if(isset ($_POST["pl_update"]) AND $_POST["pl_update"] == 1){
	
	$adminid		= $_POST["adminid"];
	$adminname		= $_POST["admin"];
	$adminlevel		= $_POST["adminlevel"];
	
	if($_POST["whitelist"] == "on")
		$whitelist = 1;
	else
		$whitelist = 0;
	
	if($_POST["donatorstatus"] == "on")
		$donatorstatus = 1;
	else
		$donatorstatus = 0;

	if($_POST["copstatus"] == "on")
		$copstatus = 1;
	else
		$copstatus = 0;

	if($_POST["rebellenstatus"] == "on")
		$rebellenstatus = 1;
	else
		$rebellenstatus = 0;

	if($_POST["adminstatus"] == "on")
		$adminstatus = 1;
	else
		$adminstatus = 0;
		
	if($_POST["modleitung"] == "on")
		$modleitung = 1;
	else
		$modleitung = 0;

	
	//	FUNKTIONSFÄHIGES STATEMENT!
	$db = new mysqli($mysqlhost, $mysqluser, $mysqlpass, $mysqldb);
	if($stmt = $db->prepare("UPDATE admins SET level=?, whitelist=?, copstatus=?, donatorstatus=?, rebellenstatus=?, adminstatus=?, modleitung=? WHERE id=?")){
		$stmt->bind_param("iiiiiiii", $adminlevel, $whitelist, $copstatus, $donatorstatus, $rebellenstatus, $adminstatus, $modleitung, $adminid);
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
					</ul>
				</div>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					
					<?php
					$altislife->lesen($tabelle1, "admin='".$mod."'", "", "");
					$admin = mysql_fetch_object($altislife->daten);
					?>
					<form  id="formLicences" name="formLicenses" method="post" action="">
						<input name="pl_update" 	type="hidden" id="pl_update" 	value="1">
						<input name="adminid" 		type="hidden" id="adminid" 		value="<?print $admin->id;?>">
						<input name="admin" 		type="hidden" id="admin" 		value="<?print $admin->admin;?>">
						<input name="adminlevel"	type="hidden" id="adminlevel"	value="<?print $admin->level;?>">
						<h1 class="page-header"><?print utf8_decode($admin->admin);?></h1>
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table">
									<div class="form-group">
										<p><strong>Adminlevel:</strong></p>
										<select class="selectpicker" name="adminlevel">
											<option name="adminlevel0"  	<?php if($admin->level == 0){print "selected";}?>>0</option>
											<option name="adminlevel1"  	<?php if($admin->level == 1){print "selected";}?>>1</option>
											<option name="adminlevel2"  	<?php if($admin->level == 2){print "selected";}?>>2</option>
											<option name="adminlevel3"  	<?php if($admin->level == 3){print "selected";}?>>3</option>
											<option name="adminlevel4"  	<?php if($admin->level == 4){print "selected";}?>>4</option>
											<option name="adminlevel5"  	<?php if($admin->level == 5){print "selected";}?>>5</option>
											<option name="adminlevel6"  	<?php if($admin->level == 6){print "selected";}?>>6</option>
											<option name="adminlevel7"  	<?php if($admin->level == 7){print "selected";}?>>7</option>
											<option name="adminlevel8"  	<?php if($admin->level == 8){print "selected";}?>>8</option>
											<option name="adminlevel9"  	<?php if($admin->level == 9){print "selected";}?>>9</option>
										</select>
									</div>
									<div class="form-group">
										<p><strong>Whitelist:</strong>&nbsp;<input type="checkbox" name="whitelist" 		<?php if($admin->whitelist == 1){print "checked";}?>></p>
										<p><strong>Coplevel:</strong>&nbsp;<input type="checkbox" name="copstatus"   		<?php if($admin->copstatus  == 1){print "checked";}?>></p>
										<p><strong>Donatorstatus:</strong>&nbsp;<input type="checkbox" name="donatorstatus" <?php if($admin->donatorstatus  == 1){print "checked";}?>></p>
										<p><strong>Adminlevel:</strong>&nbsp;<input type="checkbox" name="adminstatus"   	<?php if($admin->adminstatus  == 1){print "checked";}?>></p>
										<p><strong>Rebellstatus:</strong>&nbsp;<input type="checkbox" name="rebellenstatus" <?php if($admin->rebellenstatus  == 1){print "checked";}?>></p>
										<p><strong>Modleitung:</strong>&nbsp;<input type="checkbox" name="modleitung"   	<?php if($admin->modleitung  == 1){print "checked";}?>></p>
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