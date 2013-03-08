<?php 
include("../../inc/config.inc.php");
  
include("../../inc/func.inc.php");

if($submit) {
	$query=mysql_query("INSERT INTO Rechnungen_gutschriften(kontakt,text,betrag,waehrung,datum) values ('$kontakt','$text','$betrag','$waehrung',NOW())");
	if($query){
		header("Location: gutschriften.php");
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
<body onLoad="document.getElementsByName('kontakt')[0].focus()">
<p class=titel>Rechnungen:Neue Gutschrift</p>
<?php
	if($error){
		print "<b>Fehler:</b> $error<br><br>";
	}
	print "<form method=post action=\"$PHP_SELF\">\n";
	print "<table border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td width=150>Gutschrift zugunsten:</td>
			<td>".getKontakteList("kontakt",$kontakt,250,"Bitte Auswählen")."</td>
		</tr>
    <tr>
      <td width=150 valign=top>Text:</td>
      <td><textarea height=4 style=\"width:250;\" name=\"text\">$text</textarea></td>
    </tr>
		<tr>
      <td width=150>Währung:</td>
      <td>".getWaehrungsList("waehrung",$waehrung,100)."</td>
    </tr>
		<tr>
      <td width=150>Betrag:</td>
      <td><input type=text name=betrag style=\"width:100;\" value=\"$betrag\"></td>
    </tr>
		<tr>
		</table><br><br>\n
		<input type=submit name=submit value=\"Hinzuf&uuml;gen\">\n</form>\n";
?>
</body>
</html>
