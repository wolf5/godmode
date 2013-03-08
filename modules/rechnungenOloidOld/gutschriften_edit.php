<?php 
include("../../inc/config.inc.php");
  
include("../../inc/func.inc.php");
if(!$back) {
	$back="gutschriften.php";
}
if($submit) {
	$query=mysql_query("UPDATE Rechnungen_gutschriften SET kontakt='$kontakt',text='$text',betrag='$betrag',auszahlen='$aktiv',datum='".date_CH_to_EN($datum)."'  WHERE id='$id'");
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
<p class=titel>Rechnungen:Gutschrift Editieren</p>
<?php
	if($error){
		print "<b>Fehler:</b> $error<br><br>";
	}
	$query=mysql_query("SELECT kontakt,DATE_FORMAT(datum,'$_config_date'),betrag,text,auszahlen FROM Rechnungen_gutschriften WHERE id='$id'");
	list($kontakt,$datum,$betrag,$text)=mysql_fetch_row($query);
	
	print "<form method=post action=\"$PHP_SELF?id=$id&back=".urlencode($back)."\">
	<input type=hidden name=referer value=\"".$GLOBALS["HTTP_REFERER"]."\">
	<table border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td width=150>Gutschrift zugunsten:</td>
			<td>".getKontakteList("kontakt",$kontakt,250,"Bitte Auswählen")."</td>
		</tr>
    <tr>
      <td width=150 valign=top>text:</td>
      <td><textarea height=4 style=\"width:250;\" name=\"text\">$text</textarea></td>
    </tr>
		<tr>
      <td width=150>Betrag:</td>
      <td><input type=text name=betrag style=\"width:250;\" value=\"".formatBetrag($betrag)."\"></td>
    </tr>
    <tr>
      <td width=150>Datum:</td>
      <td><input type=text name=datum style=\"width:250;\" value=\"$datum\"></td>
    </tr>
		<tr>
			<td>Aktiv</td>
			<td>
				<select name=aktiv>
					<option value=1";
		if($aktiv==1){
			print " SELECTED";
		}
		print">Ja</option>
					<option value=0";
		if($aktiv==0){
      print " SELECTED";
    }
		print ">Nein</option>
				</select>
			</td>
		<tr>
		</table><br><br>\n
		<input type=submit name=submit value=\"Ändern\"> <input type=button value=\"Löschen\" onclick=\"javascript:location.href='gutschriften_delete.php?id=$id&back=".urlencode($back)."&backno=".urlencode($REQUEST_URI)."'\">\n</form>\n";

?>
</body>
</html>
