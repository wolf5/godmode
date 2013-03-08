<?php
include("../../inc/config.inc.php");
  
include("../../inc/func.inc.php");

if($submit) {
	if(!$kontakt) {
		$error="Bitte geben Sie einen Kunden an";
	} else if(!$text) {
		$error="Bitte geben Sie einen Text an";
	} else if(!$betrag || !is_numeric($betrag)) {
		$error="Bitte geben Sie einen Betrag an";
	} else {
		$query=mysql_query("INSERT INTO Rechnungen_positionen(kontakt,rechnung,text,text1,betrag,waehrung,datum) VALUES('$kontakt',NULL,'$text','$text1','$betrag','$waehrung',NOW())");
		
		if(mysql_error())
			$error=mysql_error();
		else{
			header("Location: positionen.php");
		}
	}
}
?>
<html>
<head>
	<title><?php echo $_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body onLoad="document.getElementsByName('kontakt')[0].focus()">
<p class=titel>Rechungen:Position hinzufügen</p>
<?php
if($error){
	print "<b>Fehler:</b> $error<br><br>";
}	
print "<form method=post action=\"$PHP_SELF?id=$id&edit=1\">\n";
print "<table border=0>
    <tr>
      <td width=100>Kontakt:</td>
      <td>".getKontakteList("kontakt",$kontakt,250,"Bitte auswählen")."</td>
    </tr>
		<tr>
			<td width=100>Text:</td>
			<td><input type=text maxlength=255 name=text value=\"$text\" style=\"width:250px\"></td>
		</tr>
		<tr>
			<td width=100>Text 1:</td>
			<td><input type=text maxlength=255 name=text1 value=\"$text1\" style=\"width:250px\"></td>
		</tr>
    <tr>
      <td width=100>Betrag</td>
      <td><input type=text name=betrag value=\"$betrag\" style=\"width:100px;\"></td>
    </tr>
		<tr>
      <td width=100>Währung</td>
      <td>".getWaehrungsList("waehrung",$waehrung,100)."</td>
    </tr>
		</table>\n";
print "<input type=submit name=submit value=\"Hinzufügen\">\n</form>\n";
?>
</body>
</html>
