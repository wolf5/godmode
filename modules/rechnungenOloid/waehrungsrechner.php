<?php 
include("../../inc/config.inc.php");
include("../../inc/func.inc.php");

$betrag = isset($_GET["betrag"]) ? $_GET["betrag"] : NULL;
$waehrung = isset($_GET["waehrung"]) ? $_GET["waehrung"] : NULL;
$waehrung1 = isset($_GET["waehrung1"]) ? $_GET["waehrung1"] : NULL;

?>
<html>
<head>
	<title><?php echo $_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body onLoad="javascript:document.getElementById('betrag').focus()">
<p class=titel>Rechnungen:W�hrungsrechner</p>
<form method="get" action="<?php echo $_SERVER["PHP_SELF"] ?>">
<?php
if($betrag) {
	$query=mysql_query("SELECT text FROM Waehrungen WHERE id='$waehrung1'");
	print "Betrag in ".mysql_result($query,0,0).": ".formatBetrag(($betrag * getFx($waehrung,$waehrung1)))."<br><br>";
}

print "<table border=0>
	<tr>
		<td>Betrag</td>
		<td><input type=text id=betrag name=betrag value=\"" . $betrag . "\"></td>
	</tr>
	<tr>
		<td>W�hrung</td>
		<td>".getWaehrungsList("waehrung",$waehrung,100)."</td>
	</tr>
	<tr>
		<td>Zielw�hrung</td>
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
