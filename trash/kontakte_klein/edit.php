<?php 
include("../../inc/config.inc.php");
include("../../inc/db.inc.php");  
include("../../inc/func.inc.php");

if($submit){
  if(!$name && !$firma){
    $fehler="Firma oder Name muss ausgefüllt werden";
	} else {
    $query_update=mysql_query("UPDATE Kontakte SET ansprechperson='$ansprechperson',name='$name',vorname='$vorname',anrede='$anrede',titel='$titel',firma='$firma',firma2='$firma2',abteilung='$abteilung',adresse='$adresse',adresse2='$adresse2',plz='$plz',ort='$ort',land='$land',tel_privat='$tel_privat',tel_gesch='$tel_gesch',tel_direkt='$tel_direkt',tel_mobile='$tel_mobile',fax='$fax',mail='$mail',mail2='$mail2',admin='$admin',text='$text',konto='$konto',kontonr='$kontonr',blz='$blz',swift='$swift',iban='$iban' WHERE id='$id'");
    if($query_update){
      header("Location: detail.php?id=$id");
		} else {
      $fehler="<b>Fehler</b>: Die Datenbank konnte nicht Aktualisiert werden.";
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
<p class=titel>Kontakte:Editieren</p>
<?php
if($fehler)
	print $fehler."<br>\n";

$query=mysql_query("SELECT id,ansprechperson,name,vorname,firma,firma2,abteilung,anrede,titel,adresse,adresse2,plz,ort,land,tel_privat,tel_gesch,tel_direkt,tel_mobile,fax,mail,mail2,admin,text,konto,kontonr,blz,swift,iban FROM Kontakte kon WHERE kon.id='$id' AND kon.aktiv=1");

if($query)
{
	if($query_update||!$submit)
		list($id,$ansprechperson,$name,$vorname,$firma,$firma2,$abteilung,$anrede,$titel,$adresse,$adresse2,$plz,$ort,$land,$tel_privat,$tel_gesch,$tel_direkt,$tel_mobile,$fax,$mail,$mail2,$admin,$text,$konto,$kontonr,$blz,$swift,$iban)=mysql_fetch_row($query);
	
	$ansprechperson=getAnsprechpersonenList("ansprechperson",$ansprechperson,"150");
	$anrede=getAnredeList("anrede",$anrede,"150");
	if($plz==0)
		$plz="";
	print "<form method=post action=\"$PHP_SELF?id=$id\">\n<table border=0>
   <tr>
     <td width=150>Name:</td>
     <td><input type=text name=\"name\" value=\"$name\" style=\"width:200px;\" maxlength=50></td>
   </tr>
   <tr>
     <td width=150>Vorname</td>
     <td><input type=text name=\"vorname\" value=\"$vorname\" style=\"width:200px;\" maxlength=50></td>
   </tr>
   <tr>
     <td width=150>Anrede</td>
     <td>".getAnredeList("anrede",$anrede,"150")."</td>
   </tr>
   <tr>
     <td width=150>Titel</td>
     <td><input type=text name=\"titel\" value=\"$titel\" style=\"width:200px;\" maxlength=50></td>
   </tr>
   <tr>
     <td width=150>Firma</td>
     <td><input type=text name=\"firma\" value=\"$firma\" style=\"width:200px;\" maxlength=50></td>
   </tr>
   <tr>
     <td width=150>Firma Zusatz</td>
     <td><input type=text name=\"firma2\" value=\"$firma2\" style=\"width:200px;\" maxlength=50></td>
   </tr>
   <tr>
     <td width=150>Abteilung</td>
     <td><input type=text name=\"abteilung\" value=\"$abteilung\" style=\"width:200px;\" maxlength=50></td>
   </tr>
   <tr>
     <td width=150>Adresse</td>
     <td><input type=text name=\"adresse\" value=\"$adresse\" style=\"width:200px;\" maxlength=50></td>
   </tr>
   <tr>
     <td width=150>Adresse 2</td>
     <td><input type=text name=\"adresse2\" value=\"$adresse2\" style=\"width:200px;\" maxlength=50></td>
   </tr>
   <tr>
     <td width=150>PLZ / Ort</td>
     <td><input type=text name=\"plz\" value=\"$plz\" style=\"width:45px;\" maxlength=10> <input type=text name=\"ort\" value=\"$ort\" style=\"width:150px;\" maxlength=50></td>
   </tr>
     <td width=150>Land</td>
     <td><input type=text name=\"land\" value=\"$land\" style=\"width:200px;\" maxlength=20></td>
   </tr>
	<tr>
     <td width=150>Tel. Privat</td>
     <td><input type=text name=\"tel_privat\" value=\"$tel_privat\" style=\"width:200px;\" maxlength=20></td>
   </tr>
   <tr>
     <td width=150>Tel. Gesch.</td>
     <td><input type=text name=\"tel_gesch\" value=\"$tel_gesch\" style=\"width:200px;\" maxlength=20></td>
   </tr>
     <td width=150>Tel. Direkt.</td>
     <td><input type=text name=\"tel_direkt\" value=\"$tel_direkt\" style=\"width:200px;\" maxlength=20></td>
   </tr>
   <tr>
     <td width=150>Mobile</td>
     <td><input type=text name=\"tel_mobile\" value=\"$tel_mobile\" style=\"width:200px;\" maxlength=20></td>
   </tr>
   <tr>
     <td width=150>Fax</td>
     <td><input type=text name=\"fax\" value=\"$fax\" style=\"width:200px;\" maxlength=20></td>
   </tr>
   <tr>
     <td width=150>e-mail</td>
     <td><input type=text name=\"mail\" value=\"$mail\" style=\"width:200px;\" maxlength=50></td>
   </tr>
   <tr>
     <td width=150>e-mail 2</td>
     <td><input type=text name=\"mail2\" value=\"$mail2\" style=\"width:200px;\" maxlength=50></td>
   </tr>
	 <tr>
	 	<td width=150>Admin</td>
		<td>
			<select name=admin width=150>";
				if($admin==1){
					print "<option value=0>Nein</option>
						<option value=1 SELECTED>Ja</option>\n";
				} else {
					print "<option value=0 SELECTED>Nein</option>
            <option value=1>Ja</option>\n";
				}
print "</select>
		</td>";
if($_config_kontakte_show_ansprechperson){
	print "<tr>
     <td width=150>Ansprechperson</td>
     <td>".getAnsprechpersonenList("ansprechperson",$ansprechperson,"150")."</td>
   </tr>";
}
print "<tr>
    <td width=150 valign=top>Text</td>
    <td><textarea name=text style=\"width:200px;height:100px\">$text</textarea></td>
  </tr>
	<tr>
  	<td width=150>Konto</td>
    <td><input type=text name=\"konto\" value=\"$konto\" style=\"width:200px;\" maxlength=50></td>
  </tr>
  <tr>
    <td width=150>Konto Nr.</td>
    <td><input type=text name=\"kontonr\" value=\"$kontonr\" style=\"width:200px;\" maxlength=50></td>
  </tr>
  <tr>
    <td width=150>BLZ</td>
    <td><input type=text name=\"blz\" value=\"$blz\" style=\"width:200px;\" maxlength=50></td>
  </tr>
  <tr>
    <td width=150>Swift</td>
    <td><input type=text name=\"swift\" value=\"$swift\" style=\"width:200px;\" maxlength=50></td>
  </tr>
   <tr>
     <td width=150>Iban</td>
     <td><input type=text name=\"iban\" value=\"$iban\" style=\"width:200px;\" maxlength=50></td>
   </tr>
	</table>
	 <input type=submit name=submit value=\"&Auml;ndern\">\n</form><br><br>\n[ <a href=\"detail.php?id=$id\">View-only</a> ] [ <a href=\"show.php\">Übersicht</a> ]";
	
} else {
	print "Fehler: User existiert ev. nicht\n";
}


?>
</body>
</html>
