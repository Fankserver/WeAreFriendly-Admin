<?php
//	Letzter Arbeitsstand:
//	Einbinden der Suchfunktion und hinzufügen der Datenbankabfrage fürs Formular...
//	ToDo:	User anzeigen und 20 pro Seite auflisten.


//	Einbinden der Config
include("./php/config.php");
include("./php/functions.php");
$moneymax = 0;
$donatorid = $_GET["donatorid"];
$steamid   = $_GET["steamid"];
$donator   = $_GET["name"];

if(isset ($_POST["update"]) && $_POST["update"] == 1){
	$userid			= $_POST["userid"];
	$betrag			= $_POST["betrag"];
	$donatorstufe	= $_POST["donatorstufe"];
	$eingang		= substr($_POST["eingang"],6,4)."-".substr($_POST["eingang"],3,2)."-".substr($_POST["eingang"],0,2);
	$donatorstart	= substr($_POST["donatorstart"],6,4)."-".substr($_POST["donatorstart"],3,2)."-".substr($_POST["donatorstart"],0,2);
	$startstamp		= mktime("", "", "", substr($_POST["donatorstart"],2,4), substr($_POST["donatorstart"],6,4), substr($_POST["donatorstart"],0,2));
	$donatorend		= date("Y-m-d",mktime(0, 0, 0, substr($_POST["donatorstart"],3,4)+$_POST["laufzeit"], substr($_POST["donatorstart"],0,2), substr($_POST["donatorstart"],6,4)));
	$today			= date("Y-m-d H:i:s");
	$empty			= "";
	$admin			= $_SERVER["PHP_AUTH_USER"];
	
	$altislife->lesen("donatoreintrag", "", "id DESC", "", "");
	$id = mysql_fetch_object($altislife->daten);
	$id = $id->id+1;
	
	// FUNKTIONSFÄHIGES STATEMENT! :-)
	$db = new mysqli($mysqlhost, $mysqluser, $mysqlpass, $mysqldb);
	if(mysqli_connect_errno()) {
		echo "Connection Failed: " . mysqli_connect_errno();
		exit();
	}
	if($stmt = $db->prepare("INSERT INTO donatoreintrag (id, userid, eingang, betrag, donatorstufe, donatorstart, donatorend, changed, changep) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)")){
		$stmt->bind_param("iississss", $id, $donatorid, $eingang, $betrag, $donatorstufe, $donatorstart, $donatorend, $empty, $admin);
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
				<p>Angemeldet als:<br><em><?php print $_SERVER['PHP_AUTH_USER']; ?></em></p>
				<br>
				<ul class="nav nav-sidebar">
					<li class="active"><a href="donatoren.php">Donator</a></li>
					<li><a href="ending.php">Donator anlegen</a></li>
				</ul>
			</div>
			<?php
			$altislife->lesen("donatoreintrag", "userid = ".$donatorid, "", "");
			for($p=0; $p<mysql_num_rows($altislife->daten); $p++){
				$money = mysql_fetch_object($altislife->daten);
				$moneymax = $moneymax + $money->betrag;
			}
			?>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<h1 class="page-header"><?print utf8_decode($donator);?></h1>
					<div class="table-responsive">
						<p>Allgemeine Informationen</p>
						<table class="table table-striped">
							<tbody>
								<tr>
									<td><strong>Steam-ID:</strong>&nbsp;&nbsp;<a href="http://steamcommunity.com/profiles/<?php print $steamid;?>" target="_blank"><?php print $steamid;?></a></td>
									<td><strong>Gesamt gespendet:</strong>&nbsp;&nbsp;<?php print $moneymax." €"; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				<?php
				?>
				<div class="col-md-12">
					<h3 class="sub-header">Neueintrag:</h3>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Eingang</th>
									<th>Betrag</th>
									<th>Donatorstufe</th>
									<th>Donatorstart</th>
									<th>Donatorende</th>
								</tr>
							</thead>
							<tbody>
								<form  id="formDonator" name="formDonator" method="post" action="">
									<input type="hidden"	name="update"	value="1">
									<input type="hidden"	name="id"		value="">
									<input type="hidden"	name="userid"	value="<?print $donatorid;?>">
									<tr>
										<td><input type="text" name="eingang"   value="<?print date("d.m.Y");?>"></td>
										<td><input type="text" name="betrag" placeholder="Betrag"></td>
										<td>
											<select class="selectpicker" name="donatorstufe">
												<option name="donatorlvl0">0</option>
												<option name="donatorlvl1">1</option>
												<option name="donatorlvl2">2</option>
												<option name="donatorlvl3">3</option>
											</select>
										</td>
										<td><input type="text" name="donatorstart"   placeholder="Donatorstart" value="<?print date("d.m.Y");?>"></td>
										<td><input type="text" name="laufzeit"		 placeholder="Laufzeit in Monaten"></td>
										<div class="form-actions" style="display: none; ">
											<input class="btn-primary" name="commit" type="submit" value="Create">
											<a class="btn close-dialog" href="#">Cancel</a>
										</div>
									</tr>
								</form>
							<tbody>
						</table>
					</div>
					<h3 class="sub-header">Suchergebnisse:</h3>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Eingang</th>
									<th>Betrag</th>
									<th>Donatorstufe</th>
									<th>Donatorstart</th>
									<th>Donatorende</th>
								</tr>
							</thead>
							<tbody>
									<?php
									$altislife->lesen("donatoreintrag", "userid = ".$donatorid, "", "");
									for($p=0; $p<mysql_num_rows($altislife->daten); $p++){
									$donator = mysql_fetch_object($altislife->daten);
									?>
										<tr>
											<?php
											$donatorstart = substr($donator->donatorstart,8,2).".".substr($donator->donatorstart,5,2).".".substr($donator->donatorstart,0,4);
											$donatorend   = substr($donator->donatorend,8,2).".".substr($donator->donatorend,5,2).".".substr($donator->donatorend,0,4);
											$eingang	  = substr($donator->eingang,8,2).".".substr($donator->eingang,5,2).".".substr($donator->eingang,0,4);
											?>
											<td><?print $eingang;?></td>
											<td><?print $donator->betrag." €";?></td>
											<td><?print $donator->donatorstufe;?></td>
											<td><?print $donatorstart;?></td>
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
