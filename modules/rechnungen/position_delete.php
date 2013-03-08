<?php 
include("../../inc/config.inc.php");
include("../../inc/func.inc.php");
include("func.inc.php");
if(!$back) {
	$back="positionen.php";
}
if(!$backno) {
	$backno=$back;
}
if($del) {
	if(isModule("domains")) {
		$query=mysql_query("SELECT `key`,`value`,`text1` FROM `Rechnungen_positionen` WHERE `id` = '$del'");
		list($key,$value,$text1)=mysql_fetch_row($query);
		if($key=="domains"){
			$datum = trim(substr($text1,0,strpos($text1,"-")));
			$query=mysql_query("UPDATE Domains SET bezahltBis='".date_CH_to_EN($datum)."' WHERE id='$value'");
		}
	}
	$query=mysql_query("DELETE FROM Rechnungen_positionen WHERE id='$del'");
	if(!($error=mysql_error())) {
		header("Location: ".urldecode($back));
	}
}
?>
<html>
<head>
	<title><?php echo $_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body>
<p class=titel>Rechnungen:Position Löschen</p>
<?php
	if($err){
		print "<b>Fehler:</b> $err<br><br>";
	}
	$query=mysql_query("SELECT text FROM Rechnungen_positionen WHERE id='$id'");
	$text=mysql_result($query,0,0);
	print "Möchten Sie die Position '$text' wirklich Löschen?<br><br>
<a href=\"$PHP_SELF?del=$id&back=".urldecode($back)."\">[ Ja ]</a> <a href=\"".urldecode($backno)."\">[ Nein ]</a>";
?>
</body>
</html>
