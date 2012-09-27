<? 
include("../../inc/config.inc.php");
include("../../inc/func.inc.php");
include("func.inc.php");

if($submit) {
	//www.domain.ch verhindern
	if(substr($domain,0,4)=="www.") $domain=substr($domain,4);
	
	//Überprüfen ob alle benötigten felder ausgefüllt wurden
	if(!$domain || !$kontakt || !$startDate || strlen($betrag)<1 ||!$abrechnungsart){
		$error="Die Felder Domain, Kontakt, Seit, Betrag und Abrechnungsart müssen ausgefüllt sein";
	} else if($gutschrift_kontakt && !$betrag){
		$error="Gutschrift, aber keinen Betrag angegeben";
	} else	{
		//Prüfen ob Domain in DB existiert
		$query=mysql_query("SELECT count(*) FROM Domains WHERE domain='$domain'");
		list($exist)=mysql_fetch_row($query);
		if($exist){
			$error="Domain existiert bereits";
		} else {
			//Neue Domain in DB schreiben
	  	$query=mysql_query("INSERT INTO Domains(domain,aliase,kontakt,startDate,betrag, waehrung,abrechnungsart,text) values ('$domain','$aliase','$kontakt','".date_CH_to_EN($startDate)."','$betrag','$waehrung','$abrechnungsart','$text')");
			$domain_id=mysql_insert_id();
			if(!($error=mysql_error())) {
				//Mail an Admin
				//TODO: Richtige Kontaktperson
				if($_config_domains_inform_admin && $inform_admin){
					$msg = "Domain : $domain\nKunde  : ".getKontakt($id)."\ne-mail : $mail\nDatum  : ".date($_config_date_php)."\n\n";
					if($inform_admin_comment){
						$msg.="Kommentar:\n$inform_admin_comment\n";
					}
					mail($_config_domains_inform_admin_mail,"Neuer Kunde: $domain",$msg,"From: $_config_domains_inform_admin_from <$_config_domains_inform_admin_from_mail>");						      
				}
				//Domain Verrechnen
				if($verrechnen) {
					$query=mysql_query("SELECT dom.domain, dom.kontakt,dom.betrag,dom.waehrung,abr.monate FROM Domains dom,Zahlungsarten abr  WHERE dom.id='$domain_id' AND abr.id = dom.abrechnungsart");
					list($domain,$kontakt,$betrag,$waehrung,$abr_mnt)=mysql_fetch_row($query);
					$bezahltBis=domain_bezahlt_bis($domain_id);
					$raten=ceil(diff_month(strtotime("+$_config_domains_verrechnen_tage_vorher days"),strtotime(date_CH_to_EN($bezahltBis)))/12);
					$betrag=($betrag * $raten);
					$tmp_monate=$abr_mnt * $raten;
					$text="Hosting $domain";
					if(date("d",strtotime(date_CH_to_EN($bezahltBis)))=="1"){
				 		$zahlenBis=date("t.m.Y",strtotime("+".($tmp_monate-1)." month",strtotime(date_CH_to_EN($bezahltBis))));
					} else {
					  //Wüster PHP Date Bug
					  if(date("d",strtotime(date_CH_to_EN($bezahltBis)))==31) {
					    $zahlenBis=date("m.Y",strtotime("+$tmp_monate month",strtotime("-1 day",strtotime(date_CH_to_EN($bezahltBis)))));
					    $zahlenBis="31.".$zahlenBis;
					  } else {
					    $zahlenBis=date("t.m.Y",strtotime("+$tmp_monate month",strtotime(date_CH_to_EN($bezahltBis))));
					  }
					}
					$text1="$startDate- $zahlenBis";
						
					$query=mysql_query("INSERT INTO Rechnungen_positionen(kontakt,rechnung,text,text1,betrag,mwst,waehrung,datum,`key`,value) VALUES('$kontakt',NULL,'$text','$text1','$betrag','$_config_domains_mwst','$waehrung',NOW(),'domains','$domain_id')");
					$pos_id=mysql_insert_id();
					
					if(!($error=mysql_error())){
						$query=mysql_query("UPDATE Domains SET bezahltBis='".date_CH_to_EN($zahlenBis)."' WHERE id='$domain_id'");
						if(!($error=mysql_error())){
							//Wenn eine Gutschrift gemacht wurde, diese in die DB schreiben
							if($gutschrift_kontakt>0)	{
			  	   	 $query=mysql_query("INSERT INTO Rechnungen_gutschriften(kontakt,datum,betrag,text,auszahlen,abhaengig) VALUES('$gutschrift_kontakt',NOW(),'$gutschrift_betrag','$gutschrift_text','0','$pos_id')");
								if(!($error=mysql_error())) {
									header("Location: show.php");
								} else {
									$error="Die Gutschrift konnte nicht gespeichert werden.\nFehler: $error";
								} 
							} else 
								header("Location: show.php");
							}
						}
  	      }
					//Ende Verrechnen	
				} else {
					header("Location: show.php");
				}	
		}
	}
}
?>
<html>
<head>
	<title><?=$_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
	<script src="../../inc/functions.js" type="text/javascript" language="javascript"></script>
	<script language="javascript" type="text/javascript">
	<!--
		var kontakt;
		var text;
		var betrag;
		function showGutschrift(show) {
				document.getElementById('gutschrift_betrag').disabled = (!show);
				document.getElementById('gutschrift_kontakt').disabled = (!show);
				document.getElementById('gutschrift_text').disabled = (!show);
		}
	//-->
	</script>
</head>
<body onLoad="javascript:error('<?=$error?>');document.getElementById('domain').focus()">
<p class=titel>Domains:Hinzufügen</p>
<script language="JavaScript">
<!--
var changeText=1;
function getBetrag(raten){
	document.getElementById('gutschrift_betrag').value=((document.getElementById('betrag').value/12)*raten);
}
function fillText(){
	if(changeText)
		document.getElementById('gutschrift_text').value='Vermittlung ' + document.getElementById('domain').value
}
-->
</script>
<?
	if(!$startDate){
		$startDate=date("d.m.Y");
	}
	if(strlen($preis)<1){
		$betrag=$_config_domains_default_betrag;
	}
	print "<form method=post action=\"$PHP_SELF\">
		<table border=0>
    <tr>
      <td width=100>Domain</td>
      <td><input type=text id=domain name=domain value=\"$domain\" style=\"width:250px;\" id=\"domain\"";
	if(isModule("rechnungen")) {
		print " onchange=\"javascript:fillText()\"";
	}
  if($verrechnen||!isset($verrechnen)){
    $checked=" CHECKED";
  } else {
    $checked="";
  }

	print "></td>
    </tr>
    <tr>
      <td width=100>Aliase</td>
      <td><input type=text name=\"aliase\" value=\"$aliase\" style=\"width:250px;\"></td>
    </tr>

		<tr>
			<td width=100>Kontakt:</td>
			<td>".getKontakteList("kontakt",$kontakt,"250","Bitte Auswählen")."</td>
		</tr>
    <tr>
      <td width=100>Seit:</td>
      <td><input type=text name=\"startDate\" value=\"$startDate\" style=\"width:250px;\"></td>
    </tr>
		<tr>
	     <td width=100>Betrag:</td>
    	 <td><input type=text name=betrag id=betrag value=\"$betrag\" style=\"width:250px;\"></td>
    </tr>
		<tr>
       <td width=100>Währung:</td>
       <td>".getWaehrungsList("waehrung",$waehrung,"250")."</td>
    </tr>
		<tr>
       <td width=100>Abrechnungsart:</td>
       <td>".getZahlungsartenList("abrechnungsart",$abrechnungsart,"250","")."</td>
    </tr>
		<tr>
			<td width=100 valign=top>Text:</td>
			<td><textarea style=\"width:250;height:50;\" name=text>$text</textarea></td>
		</tr>
		<tr>
      <td colspan=2><b>Sofort Verrechnen</b></td>
    </tr>
    <tr>
      <td></td>
      <td><input type=checkbox value=1 name=verrechnen$checked onclick=\"javascript:showGutschrift(this.checked)\"> Ja</td>
    </tr>";
	if(isModule("rechnungen")){
		print"<tr>
			<td colspan=2><b>Gutschrift</b></td>
		</tr>
		<tr>
			<td>Zugunsten von:</td>
			<td>".getKontakteList("gutschrift_kontakt",$gutschrift_kontakt,"250","Keine Gutschrift")."</td>
		</tr>
		<tr>
			<td>Text:</td>
			<td><input type=text name=gutschrift_text id=gutschrift_text value=\"$gutschrift_text\" style=\"width:250px;\" onchange=\"javascript:changeText=0\"></td>
		</tr>
		<tr>
			<td valign=top>Betrag</td>
			<td><input type=text name=gutschrift_betrag id=gutschrift_betrag value=\"$gutschrift_betrag\" style=\"width:250px;\"><br>Anzahl gutgeschriebener Raten: <a href=\"#\" onclick=\"javascript:getBetrag(1)\">1</a> <b><a href=\"#\" onclick=\"javascript:getBetrag(2)\">2</a></b> <a href=\"#\" onclick=\"javascript:getBetrag(3)\">3</a> <b><a href=\"#\" onclick=\"javascript:getBetrag(4)\">4</a></b> <a href=\"#\" onclick=\"javascript:getBetrag(5)\">5</a> </td>
		</tr>";
	}
	if($_config_domains_inform_admin){
		if($inform_admin){
			$checked=" CHECKED";
		} else {
			$checked="";
		}
		print "<tr>
				<td colspan=2><b>Admin Informieren</b></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type=checkbox value=1 name=inform_admin$checked> Ja</td>
			</tr>
			<tr>
				<td>Kommentar:</td>
				<td><input type=text name=inform_admin_comment value=\"$inform_admin_comment\" style=\"width:250px;\"></td>
			</tr>";

	}
	print "</table>\n<br><br>\n
		<input type=submit name=submit value=\"Hinzuf&uuml;gen\">\n</form>\n";

?>
</body>
</html>
