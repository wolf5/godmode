<? 
session_start();
include("../../inc/config.inc.php");
include("../../inc/db.inc.php");  
include("../../inc/func.inc.php");
$referer=$GLOBALS["HTTP_REFERER"];
if((!strstr($referer,"kontakte/detail.php") && !strstr($referer,"kontakte/edit.php")) || !$kontakte_back){
	$kontakte_back=$referer;
	session_register("kontakte_back");
}
?>
<html>
<head>
	<title><?=$_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body>
<p class=titel>Kontakte:Details</p>
<?
$query=mysql_query("SELECT id,admin,ansprechperson,name,vorname,firma,firma2,abteilung,titel,anrede,adresse,adresse2,plz,ort,land,tel_privat,tel_gesch,tel_direkt,tel_mobile,fax,mail,mail2,text,konto,kontonr,blz,swift,iban FROM Kontakte kon WHERE kon.id='$id' AND kon.aktiv=1");
if($query)
{
	list($id,$admin,$ansprechperson_id,$name,$vorname,$firma,$firma2,$abteilung,$titel,$anrede,$adresse,$adresse2,$plz,$ort,$land,$tel_privat,$tel_gesch,$tel_direkt,$tel_mobile,$fax,$mail,$mail2,$text,$konto,$kontonr,$blz,$swift,$iban)=mysql_fetch_row($query);

	//Ansprechperson
	$query=mysql_query("SELECT id,name,vorname FROM Kontakte WHERE id='$ansprechperson_id'");
	list($admin_id,$admin_name,$admin_vorname)=mysql_fetch_row($query);
	$ansprechperson="<a href=\"detail.php?id=$admin_id\">$admin_vorname $admin_name</a>";
		
	//PLZ Korrektur
	if($plz==0)
		$plz="";
	
	//Domains des Users
	if(isModule("domains")){
		$query=mysql_query("SELECT id, domain FROM Domains WHERE (kontakt='$id' OR techkontakt='$id') AND endDate is NULL");
		for($i=0;list($domain_id,$domain_name)=mysql_fetch_row($query);$i++){
			if($i==0){
				$domains.="<a href=\"../../modules/domains/detail.php?id=$domain_id\">$domain_name</a>";
			} else {
				$domains.=", <a href=\"../../modules/domains/detail.php?id=$domain_id\">$domain_name</a>";
			}
		}
	}
	print "<table border=0>\n";
	if($anrede)
    print "<tr>
      <td width=150>Anrede:</td>
      <td>".getAnrede($anrede)."</td>
    </itr>\n";
	if($titel)
    print "<tr>
      <td width=150>Titel</td>
      <td>$titel</td>
    </tr>\n";
	if($name||$vorname)
		print "<tr>
			<td width=150>Name/Vorname:</td>
			<td>$name $vorname</td>
		</tr>\n";
	if($firma)
		print "<tr>
      <td width=150>Firma</td>
      <td>$firma</td>
    </tr>\n";
	if($firma2)
    print "<tr>
      <td width=150>Firma Zusatz</td>
      <td>$firma2</td>
    </tr>\n";
	if($abteilung)
    print "<tr>
      <td width=150>Abteilung</td>
      <td>$abteilung</td>
    </tr>\n";

	if($adresse)
		print "<tr>
      <td width=150>Adresse</td>
      <td>$adresse</td>
    </tr>\n";
	if($adresse2)
    print "<tr>
      <td width=150>Adresse 2</td>
      <td>$adresse2</td>
    </tr>\n";
	if($plz||$ort)
		print "<tr>
      <td width=150>PLZ/Ort</td>
      <td>$plz $ort</td>
    </tr>\n";
	if($land)
    print "<tr>
      <td width=150>Land</td>
      <td>$land</td>
    </tr>\n";
	if($tel_privat)
		print "<tr>
      <td width=150>Tel. Privat</td>
      <td>$tel_privat</td>
		</tr>\n";
	if($tel_gesch)
		print "<tr>
      <td width=150>Tel. Gesch.</td>
      <td>$tel_gesch</td>
    </tr>\n";
	if($tel_direkt)
    print "<tr>
      <td width=150>Tel. Direkt</td>
      <td>$tel_direkt</td>
    </tr>\n";
	if($tel_mobile)
		print "<tr>
      <td width=150>Mobile</td>
      <td>$tel_mobile</td>
    </tr>\n";
  if($fax)
    print "<tr>
      <td width=150>Fax</td>
      <td>$fax</td>
    </tr>\n";	
  if($mail)
    print "<tr>
      <td width=150>E-Mail</td>
      <td><a href=\"mailto:$mail\">$mail</a></td>
    </tr>\n";
  if($mail2)
    print "<tr>
      <td width=150>E-Mail 2</td>
      <td><a href=\"mailto:$mail2\">$mail2</a></td>
    </tr>\n";
	if($ansprechperson && $_config_kontakte_show_ansprechperson)
		print "<tr>
      <td width=150>Ansprechperson</td>
      <td>$ansprechperson</td>
    </tr>\n";
	if($domains)
		print "<tr>
      <td width=150>Domains</td>
      <td>$domains</td>
    </tr>\n";
	if($admin)
		print "<tr>
      <td width=150>Admin</td>
      <td>Ja</td>
    </tr>\n";
	if($text)
    print "<tr>
      <td width=150 valign=top>Text</td>
      <td>$text</td>
    </tr>\n";
	if($konto)
    print "<tr>
      <td width=150 valign=top>Konto</td>
      <td>$konto</td>
    </tr>\n";
  if($kontonr)
    print "<tr>
      <td width=150 valign=top>Konto Nr.</td>
      <td>$kontonr</td>
    </tr>\n";
  if($blz)
    print "<tr>
      <td width=150 valign=top>BLZ</td>
      <td>$blz</td>
    </tr>\n";
  if($swift)
    print "<tr>
      <td width=150 valign=top>Swift</td>
      <td>$swift</td>
    </tr>\n";
  if($iban)
    print "<tr>
      <td width=150 valign=top>Iban</td>
      <td>$iban</td>
    </tr>\n";
	print "</table>\n<br><br>
	<a href=\"$kontakte_back\">[ Zurück ]</a> <a href=\"edit.php?id=$id\">[ Editieren ]</a> <a href=\"delete.php?id=$id\">[ Löschen ]</a>";
	
} else {
	print "Fehler: User existiert ev. nicht\n";
}


?>
</body>
</html>
