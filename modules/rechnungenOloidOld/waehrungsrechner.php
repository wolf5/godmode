<?php 
include("../../inc/config.inc.php");
include("../../inc/func.inc.php");

?>
<html>
<head>
	<title><?php echo $_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body onLoad="javascript:document.getElementById('betrag').focus()">
<p class=titel>Rechnungen:Währungsrechner</p>
<form method=post action="<?php=$PHP_SELF?>">
<?php
if($betrag) {
	$query=mysql_query("SELECT text FROM Waehrungen WHERE id='$waehrung1'");
	print "Betrag in ".mysql_result($query,0,0).": ".formatBetrag(($betrag * getFx($waehrung,$waehrung1)))."<br><br>";
}
print "<table border=0>
	<tr>
		<td>Betrag</td>
		<td><input type=text id=betrag name=betrag value=\"$betrag\"></td>
	</tr>
	<tr>
		<td>Währung</td>
		<td>".getWaehrungsList("waehrung",$waehrung,100)."</td>
	</tr>
	<tr>
		<td>Zielwährung</td>
		<td>".getWaehrungsList("waehrung1",$waehrung1,100)."</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type=submit value=\"Umrechnen\"></td>
	</tr>
	</table>";
?>
</form>
</body>
</html>
