<?
session_start();
include("../../inc/config.inc.php");
include("../../inc/func.inc.php");
include("func2.inc.php");

$HTTP_POST_VARS   = !empty($HTTP_POST_VARS)   ? $HTTP_POST_VARS   : $_POST;


echo saveKontakte();

$kontaktpersonen = $_SESSION["kontaktpersonen"];





?>
<html>
<head>
	<title><?=$_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
	<script src="../../inc/functions.js" type="text/javascript" language="javascript"></script>
</head>
<body onLoad="javascript:error('<?=$error?>');document.getElementsByName('kontaktperson_anrede')[0].focus();">
<p class=titel>Kontakte:Kontaktperson</p>
<?

$key = $_REQUEST["key"];

print "<form method=post action=\"kontakt.php?key=$key\">\n";

$key = $_REQUEST["key"];
//= $key-1;

//echo "key=".$key." kp bei key =".$kontaktpersonen[$key]['id']."-> ".$_REQUEST["key"];

print "<table border=0>
		<tr>
			<td width=100>ID</td>
			<td>".$kontaktpersonen[$key]['id']."</td>
		</tr>	
    <tr>
      <td width=100>Anrede:</td>
      <td>".getAnredeList("kontaktperson_anrede",$kontaktpersonen[$key]['anrede'],150)."</td>
    </tr>
		<tr>
			<td width=100>Name:</td>
			<td><input type=text name=\"kontaktperson_name\" value=\"".$kontaktpersonen[$key]['name']."\" style=\"width:200px;\" maxlength=50></td>
		</tr>
		<tr>
			<td width=100>Vorname</td>
			<td><input type=text name=\"kontaktperson_vorname\" value=\"".$kontaktpersonen[$key]['vorname']."\" style=\"width:200px;\" maxlength=50></td>
		</tr>
		<tr>
      <td width=100>Position:</td>
      <td><input type=text name=\"kontaktperson_position\" value=\"".$kontaktpersonen[$key]['position']."\" style=\"width:200px;\" maxlength=50></td>
    </tr>
		<tr>
      <td width=100>Abteilung:</td>
      <td><input type=text name=\"kontaktperson_abteilung\" value=\"".$kontaktpersonen[$key]['abteilung']."\" style=\"width:200px;\" maxlength=50></td>
    </tr>";
	if($_config_kontakte_kontaktpersonen_show_adresse) 
		print "<tr>
      <td width=100>Adresse</td>
      <td><input type=text name=\"kontaktperson_adresse\" value=\"".$kontaktpersonen[$key]['adresse']."\" style=\"width:200px;\" maxlength=50></td>
    </tr>
		<tr>
      <td width=100>Adresse 2</td>
      <td><input type=text name=\"kontaktperson_adresse2\" value=\"".$kontaktpersonen[$key]['adresse2']."\" style=\"width:200px;\" maxlength=50></td>
    </tr>
    <tr>
      <td width=100>PLZ / Ort</td>
      <td><input type=text name=\"kontaktperson_plz\" value=\"".$kontaktpersonen[$key]['plz']."\" style=\"width:45px;\" maxlength=10> <input type=text name=\"kontaktperson_ort\" value=\"".$kontaktpersonen[$key]['ort']."\" style=\"width:150px;\" maxlength=50></td>
    </tr>";
	
print "<tr>
      <td width=100>Tel. Privat</td>
      <td><input type=text name=\"kontaktperson_tel_privat\" value=\"".$kontaktpersonen[$key]['tel_privat']."\" style=\"width:200px;\" maxlength=20></td>
    </tr>
		<tr>
      <td width=100>Tel. Direkt</td>
      <td><input type=text name=\"kontaktperson_tel_direkt\" value=\"".$kontaktpersonen[$key]['tel_direkt']."\" style=\"width:200px;\" maxlength=20></td>
    </tr>
    <tr>
      <td width=100>Tel. Gesch.</td>
      <td><input type=text name=\"kontaktperson_tel_gesch\" value=\"".$kontaktpersonen[$key]['tel_gesch']."\" style=\"width:200px;\" maxlength=20></td>
    </tr>
    <tr>
      <td width=100>Mobile</td>
      <td><input type=text name=\"kontaktperson_tel_mobile\" value=\"".$kontaktpersonen[$key]['tel_mobile']."\" style=\"width:200px;\" maxlength=20></td>
    </tr>
		<tr>
      <td width=100>Fax</td>
      <td><input type=text name=\"kontaktperson_fax\" value=\"".$kontaktpersonen[$key]['fax']."\" style=\"width:200px;\" maxlength=20></td>
    </tr>
		<tr>
      <td width=100>E-Mail</td>
      <td><input type=text name=\"kontaktperson_mail\" value=\"".$kontaktpersonen[$key]['mail']."\" style=\"width:200px;\" maxlength=50></td>
    </tr>
   <tr>
      <td width=100>E-Mail 2</td>
      <td><input type=text name=\"kontaktperson_mail2\" value=\"".$kontaktpersonen[$key]['mail2']."\" style=\"width:200px;\" maxlength=50></td>
    </tr>
		<tr>
      <td width=100 valign=top>Text</td>
      <td><textarea name=\"kontaktperson_text\" style=\"width:200px;height:100px\">".$kontaktpersonen[$key]['text']."</textarea></td>
    </tr>
		</table>\n";
print "<input type=submit name=submit value=\"Ändern\"> <input type=button onclick=\"javascript:location.href='kontakt.php'\" value=\"Abbrechen\">\n</form>\n";
?>


<?

  echo "<pre>";
  print_r($_SESSION);
  echo "</pre>";
  
?>
</body>
</html>
