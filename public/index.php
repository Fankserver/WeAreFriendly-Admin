<?php
//	Einbinden der Config
include("./php/config.php");
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
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"> AltisLife Public Server <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="">AltisLife Public Server</a></li>
							<?php if($admin->whitelist == 1){ ?>
								<li><a href="../wlwhitelist">AltisLife Whitelist Server</a></li>
							<?php } ?>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
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
				<h2 class="page-header">Aktuelle Infos</h2>
				<blockquote>
					<h3>Admintool 2.0</h3>
					<br>
					Wie ihr seht wurde das Admintool 2.0 veröffentlicht...<br><br>
					Viel Spaß beim benutzen,<br>
					Eisbaer | Flo
				</blockquote>
				<hr />
			</div>
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
	<script src="js/holder.js"></script>
	</body>
</html>
