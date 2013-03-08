<?php 
session_start();
include("../../inc/config.inc.php");
  
include("../../inc/func.inc.php");

$id = isset($_GET["id"]) ? $_GET["id"] : NULL;
$del = isset($_GET["del"]) ? $_GET["del"] : NULL;
$back = isset($_GET["back"]) ? $_GET["back"] : NULL;

if(!$back) {
	$back="show.php";
}
if(!$backno) {
	$backno=$back;
}
if($del)
{
	if($del==$_config_kontakte_me) {
		$err="Sie können die Hauptfirma nicht Löschen";
	} else {
		$query=mysql_query("UPDATE Kontakte SET aktiv=0 WHERE id='$del'");
		if($query) {
			header("Location: ".urldecode($back));
		} else {
			$err=mysql_error();
		}
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
<a href=\"" . $_SERVER["PHP_SELF"] . "?del=$id&back=".urlencode($back)."\">[ Ja ]</a> <a href=\"".urldecode($backno)."\">[ Nein ]</a>";
?>
</body>
</html>
