<?
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
		$query=mysql_query("UPDATE Rechnungen_positionen SET kontakt='$kontakt',text='$text',text1='$text1',betrag='$betrag',waehrung='$waehrung' WHERE id='$id'");
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
	<title><?=$_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body onLoad="document.getElementsByName('kontakt')[0].focus()">
<p class=titel>Rechungen:Position Editieren</p>
<?
if($error){
	print "<b>Fehler:</b> $error<br><br>";
}	
$query=mysql_query("SELECT kontakt,text,text1,betrag,waehrung FROM Rechnungen_positionen WHERE id='$id'");
list($kontakt,$text,$text1,$betrag,$waehrung)=mysql_fetch_row($query);
print "<form method=post action=\"$PHP_SELF?id=$id\">\n";
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
print "<input type=submit name=submit value=\"Ändern\"> <input type=button value=\"Löschen\" onclick=\"javascript:location.href='position_delete.php?id=$id&back=positionen.php&backno=".urlencode($REQUEST_URI)."'\">\n</form>\n";
?>
</body>
</html>
