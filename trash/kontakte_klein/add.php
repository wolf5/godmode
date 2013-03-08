<?php
include("../../inc/config.inc.php");
include("../../inc/db.inc.php");
include("../../inc/func.inc.php");

if($submit) {
	if(!$name && !$firma) {
		$fehler="Firma oder Name muss ausgefüllt werden";
	} else {
	  $query=mysql_query("INSERT INTO Kontakte(ansprechperson,name,vorname,anrede,firma,adresse,adresse2,plz,ort,tel_privat,tel_gesch,tel_mobile,fax,mail,mail2,text,konto,kontonr,blz,swift,iban) VALUES('$ansprechperson','$name','$vorname','$anrede','$firma','$adresse','$adresse2','$plz','$ort','$tel_privat','$tel_gesch','$tel_mobile','$fax','$mail','$mail2','$text','$konto','$kontonr','$blz','$swift','$iban')");
  	if($query) {
	    header("Location: show.php");
		} else {
	    $error= "Fehler: ".mysql_error($query)."<br><br>\n\n";
		}
	}
}
?>
<html>
<head>
	<title><?php echo $_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body onLoad="document.getElementsByName('anrede')[0].focus()">
<p class=titel>Kontakte:Hinzufügen</p>
<?php
if($fehler)
	print "<b>Fehler:</b> $error<br><br>\n";
print "<form method=post action=\"$PHP_SELF?id=$id&edit=1\">\n";
print "<table border=0>
    <tr>
      <td width=100>Anrede:</td>
      <td>".getAnredeList("anrede",$anrede,150)."</td>
    </tr>
		<tr>
			<td width=100>Name:</td>
			<td><input type=text name=\"name\" value=\"$name\" style=\"width:200px;\" maxlength=50></td>
		</tr>
		<tr>
			<td width=100>Vorname</td>
			<td><input type=text name=\"vorname\" value=\"$vorname\" style=\"width:200px;\" maxlength=50></td>
		</tr>
    <tr>
      <td width=100>Firma</td>
      <td><input type=text name=\"firma\" value=\"$firma\" style=\"width:200px;\" maxlength=50></td>
    </tr>
    <tr>
      <td width=100>Adresse</td>
      <td><input type=text name=\"adresse\" value=\"$adresse\" style=\"width:200px;\" maxlength=50></td>
    </tr>
		<tr>
      <td width=100>Adresse 2</td>
      <td><input type=text name=\"adresse2\" value=\"$adresse2\" style=\"width:200px;\" maxlength=50></td>
    </tr>
    <tr>
      <td width=100>PLZ / Ort</td>
      <td><input type=text name=\"plz\" value=\"$plz\" style=\"width:45px;\" maxlength=10> <input type=text name=\"ort\" value=\"$ort\" style=\"width:150px;\" maxlength=50></td>
    </tr>
    <tr>
      <td width=100>Tel. Privat</td>
      <td><input type=text name=\"tel_privat\" value=\"$tel_privat\" style=\"width:200px;\" maxlength=20></td>
    </tr>
    <tr>
      <td width=100>Tel. Gesch.</td>
      <td><input type=text name=\"tel_gesch\" value=\"$tel_gesch\" style=\"width:200px;\" maxlength=20></td>
    </tr>
    <tr>
      <td width=100>Natel</td>
      <td><input type=text name=\"tel_mobile\" value=\"$tel_mobile\" style=\"width:200px;\" maxlength=20></td>
    </tr>
		<tr>
      <td width=100>Fax</td>
      <td><input type=text name=\"fax\" value=\"$fax\" style=\"width:200px;\" maxlength=20></td>
    </tr>
		<tr>
      <td width=100>E-Mail</td>
      <td><input type=text name=\"mail\" value=\"$mail\" style=\"width:200px;\" maxlength=50></td>
    </tr>
   <tr>
      <td width=100>E-Mail 2</td>
      <td><input type=text name=\"mail2\" value=\"$mail2\" style=\"width:200px;\" maxlength=50></td>
    </tr>";
if($_config_kontakte_show_ansprechperson)
	print "<tr>
      <td width=100>Ansprechperson</td>
      <td>".getAnsprechpersonenList("ansprechperson",$ansprechperson,200)."</td>
    </tr>";
print "<tr>
      <td width=100 valign=top>Text</td>
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
		</table>\n";
print "<input type=submit name=submit value=\"Hinzufügen\">\n</form>\n";
?>
</body>
</html>
