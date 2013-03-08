<?php 
include("../../inc/config.inc.php");
  
include("../../inc/func.inc.php");
if(!$back){
	$back="gutschriften.php";
}
if(!$backno){
	$backno=$back;
}
if($del)
{
	$query=mysql_query("DELETE FROM Rechnungen_gutschriften WHERE id='$del'");
	if($query) {
		header("Location: ".urldecode($back));
	} else {
		$error=mysql_error();
	}
}
?>
<html>
<head>
	<title><?php echo $_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body>
<p class=titel>Rechnungen:Gutschrift Löschen</p>
<?php
	$query=mysql_query("SELECT kontakt, betrag, text FROM Rechnungen_gutschriften WHERE id='$id'");
	list($kontakt,$betrag,$text)=mysql_fetch_row($query);
	print "<p>Möchten Sie die Gutschrift <b>$text</b> für <b>".getKontakt($kontakt)."</b> über ".formatBetrag($betrag)." wirklich Löschen?</p><p>[ <a href=\"$PHP_SELF?del=$id&back=".urlencode($back)."\">Ja</a> ] [ <a href=\"".urldecode($backno)."\">Nein</a> ]</p>";
?>
</body>
</html>
