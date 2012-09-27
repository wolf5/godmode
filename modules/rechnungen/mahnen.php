<? 
include("../../inc/config.inc.php");
  
include("../../inc/func.inc.php");
include("func.inc.php");
if(!$back) {
	$back="offene.php";
}
if($submit) {
  if(mail($an,$betreff,$nachricht,"From: $von")) {
    $query = mysql_query("INSERT INTO Rechnungen_mahnungen(rechnung,datum,von,an,betreff,nachricht) VALUES('$rechnung',NOW(),'$von','$an','$betreff','$nachricht')");
    if($query) {
			header("Location: ".urldecode($back));
		} else {
			$err = mysql_error();
		} 
  }
  else {
		$err = "Mahnung konnte nicht verschickt werden";
	}
}
?>

<html>
<head>
  <title><?=$_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body>
<p class=titel>Rechnungen:Mahnen</p>
<?
if($err) {
	print "<b>Fehler:</b> $err";
}
$query = mysql_query("SELECT rech.kontakt,DATE_FORMAT(rech.datum,'$_config_date'),rech.betreff FROM Rechnungen rech WHERE  rech.id='$id'");
list($kontakt,$datum,$betreff)=mysql_fetch_row($query);
$text=$_config_rechnung_mahnung_text1;
//Name, Andrede, Mail
list($name,$anrede,$mail) = getRechnungsAdresseMail($kontakt);
$text=str_replace("%ANREDE%",$anrede,$text);
$text=str_replace("%NAME%",$name,$text);
$text=str_replace("%DATUM%",$datum,$text);
print "<form method=post action=\"$PHP_SELF?back=".urlencode($back)."\">
<input type=hidden name=rechnung value=$id>
<table border=0>
<tr>
  <td width=100>Von:</td>
  <td><input type=text name=von value=\"$_config_mahnung_from\" style=\"width:300px\"></td>
</tr>
<tr>
	<td width=100>An:</td>
	<td><input type=text name=an value=\"$name <$mail>\" style=\"width:300px\"></td>
</tr>
<tr>
	<td width=100>Betreff:</td>
	<td><input type=text name=betreff value=\"Mahnung: Rechnung vom $datum\" style=\"width:300px;\">
</tr>
<tr>
	<td width=100 valign=top>Nachricht:</td>
	<td>
		<textarea name=nachricht style=\"width:500px; height:300px;\">$text</textarea>
	</td>
</tr>
<tr>
	<td colspan=2><input type=submit name=submit value=\"Abschicken\"></td>
</tr>
</table>
</form>";
?>
</body>
</html>
