<?php 
session_start();
include("../../inc/config.inc.php");
include("../../inc/db.inc.php");  
include("../../inc/func.inc.php");

if($del)
{
	$query=mysql_query("UPDATE Kontakte SET aktiv=0 WHERE id='$id'");
	if($query) {
		if($kontakte_back){
			header("Location: $kontakte_back");
		} else {
			header("Location: show.php");
		}
	} else {
		$err=mysql_error();
	}
}
?>
<html>
<head>
	<title><?php echo $_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body>
<p class=titel>Kontakte:Kontakt Löschen</p>
<?php
	if($err){
		print "<b>Fehler:</b> $err<br><br>";
	}
	print "Möchten Sie den Kontakt '".getKontakt($id)."' wirklich Löschen?<br><br>
<a href=\"$PHP_SELF?del=1&id=$id\">[ Ja ]</a> <a href=\"show.php\">[ Nein ]</a>";
?>
</body>
</html>
