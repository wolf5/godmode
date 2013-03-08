<?php 
include("../../inc/config.inc.php");
  
include("../../inc/func.inc.php");
include("func.inc.php");
if(!$back) {
	$back="offene.php";
}
if(!$backno) {
	$backno=$back;
}
if($del) {
	if($rem_pos) {
		$query=mysql_query("DELETE FROM Rechnungen_positionen WHERE rechnung='$del'");
		$query1=mysql_query("DELETE FROM Rechnungen_gutschriften WHERE bezahlt='$del'");
	} else {
		$query=mysql_query("UPDATE Rechnungen_positionen SET rechnung=NULL WHERE rechnung='$del'");
		$query1=mysql_query("UPDATE Rechnungen_gutschriften SET bezahlt=NULL WHERE bezahlt='$del'");
	}
	if(!($error=mysql_error())) {
		$query=mysql_query("DELETE FROM Rechnungen WHERE id='$del'");
		if(!($error=mysql_error())) {
			header("Location: ".urldecode($back));
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
<p class=titel>Rechnungen:Rechnung Löschen</p>
<?php
	if($error){
		print "<b>Fehler:</b> $error<br><br>";
	}
	$query=mysql_query("SELECT kontakt,DATE_FORMAT(datum,'$_config_date'),betreff FROM Rechnungen WHERE id='$id'");
	list($kontakt,$datum,$text)=mysql_fetch_row($query);
	print "Möchten Sie die Rechnung an <b>".getKontakt($kontakt)."</b> vom <b>$datum</b> mit dem Titel <b>$text</b> wirklich Löschen?<br>
	<form method=post action=\"$PHP_SELF\" name=delform>
	<input type=hidden name=del value=$id>
	<input type=hidden name=back value=\"$back\">
	<input type=checkbox name=rem_pos value=true checked> Positionen Löschen<br><br> 
<a href=\"#\" onclick=\"javascript:document.delform.submit();\">[ Ja ]</a> <a href=\"".urldecode($backno)."\">[ Nein ]</a>";
?>
</body>
</html>
