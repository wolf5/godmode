<?php
include("../../inc/config.inc.php");
include("../../inc/func.inc.php");
include("func.inc.php");
if(!$back) {
	$back="show.php";
}
//www.domain.ch verhindern
if(substr($domain,0,4)=="www.") $domain=substr($domain,4);
	
if($submit) {
	if(!$domain || !$kontakt || !$startDate || $betrag=="" || !$abrechnungsart)
		$error="Die Felder Domain, Kontakt, Seit, Betrag und Abrechnungsart müssen ausgefüllt werden";
	else
	{
		$query_update=mysql_query("UPDATE Domains SET domain='$domain',aliase='$aliase',kontakt='$kontakt',startDate='".date_CH_to_EN($startDate)."', betrag='$betrag',waehrung='$waehrung',abrechnungsart='$abrechnungsart', text='$text' WHERE id='$id'");
		if($query_update){
			if($submit=="Ändern & Zurück") {
				header("Location: ".urldecode($back));
			} 
		}	else {
			$error="Der Datenbankeintrag konnte nicht geändert werden";
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
<p class=titel>Domains:Domain</p>
<?php
$query=mysql_query("SELECT dom.domain, dom.aliase,dom.kontakt, DATE_FORMAT(dom.startDate,'$_config_date'), dom.betrag, dom.waehrung,dom.abrechnungsart,dom.text FROM Domains dom WHERE dom.id='$id'");
if(@mysql_num_rows($query)>0) {
	if(!$query_update)
		list($domain, $aliase, $kontakt, $startDate,$betrag,$waehrung,$abrechnungsart,$text)=mysql_fetch_row($query);
	if($error)
		print "<b>Fehler:</b> $error<br><br>\n";
	print "<form method=post action=\"$PHP_SELF?id=$id&back=".urlencode($back)."\">\n<table border=0i cellpadding=0 cellspacing=0>
    <tr>
      <td width=100>Domain</td>
      <td><input type=text name=\"domain\" value=\"$domain\" style=\"width:250px;\"></td>
    </tr>
    <tr>
      <td width=100>Aliase</td>
      <td><input type=text name=\"aliase\" value=\"$aliase\" style=\"width:250px;\"></td>
    </tr>
		<tr>
			<td width=100>";
	if($kontakt) {
		print "<a href=\"../kontakte/kontakt.php?id=$kontakt\">Kontakt:</a>";
	} else {
		print "Kontakt";
	}
		print "</td>
			<td>".getKontakteList("kontakt",$kontakt,250,"Bitte Auswählen")."</td>
		</tr>
    <tr>
      <td width=100>Seit:</td>
      <td><input type=text name=\"startDate\" value=\"$startDate\" style=\"width:250px;\"></td>
    </tr>
		<tr>
      <td width=100>Bezahlt bis:</td>
      <td style=\"padding:2px 2px 2px 2px\">".domain_bezahlt_bis($id)."</td>
    </tr>
		<tr>
      <td width=100>Betrag:</td>
      <td><input type=text name=\"betrag\" value=\"$betrag\" style=\"width:250px;\"></td>
    </tr>
		<tr>
      <td width=100>Währung:</td>
      <td>".getWaehrungsList("waehrung",$waehrung,250)."</td>
    </tr>
    <tr>
      <td width=100>Abrechnungsart:</td>
      <td>".getZahlungsartenList("abrechnungsart",$abrechnungsart,"250","")."</td>
    </tr>
		<tr>
      <td width=100 valign=top>Text:</td>
      <td><textarea style=\"width:250;height:50;\" name=text>$text</textarea></td>
    </tr>
		</table><br><br>\n<input type=submit name=submit value=\"&Auml;ndern\"> <input type=submit name=submit value=\"&Auml;ndern & Zurück\"> <input type=button onclick=\"javascript:location.href='".urldecode($back)."'\" value=\"Zurück\"> <input type=button onclick=\"javascript:location.href='delete.php?id=$id&back=".urldecode($back)."&backno=".urlencode($REQUEST_URI)."'\" value=\"Löschen\"></form>\n";
	
} else {
	print "Fehler: User existiert ev. nicht\n";
}


?>
</body>
</html>
