<?
include("../../inc/config.inc.php");
include("../../inc/func.inc.php");    

if($submit) {
	if(!$nr_int) {
		$fehler="Es wurde keine Int. Produktenummer angegeben";
	} else {
	  $query=mysql_query("INSERT INTO Produkte(nr_int,nr_ext,gruppe,text1,text2,preis1,preis2,preis3,preis4,rabattstufe,warenbestand) VALUES('$nr_int','$nr_ext','$gruppe','$text1','$text2','$preis1','$preis2','$preis3','$preis4','$rabattstufe','$warenbestand')");
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
	<title><?=$_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body onLoad="document.getElementsByName('nr_int')[0].focus()">
<p class=titel>Produkte:Hinzufügen</p>
<?
if($fehler)
	print "<b>Fehler:</b> $error<br><br>\n";
print "<form method=post action=\"$PHP_SELF\">\n";
print "<table border=0>";

if($_config_produkte_int_prod_nr)
	print"<tr>
		<td width=100>Int. Prod. Nr.:</td>
		<td><input type=text name=\"nr_int\" value=\"$nr_int\" style=\"width:200px;\" maxlength=50></td>
	</tr>";
if($_config_produkte_ext_prod_nr)
   print "<tr>
     <td width=100>Ext. Prod. Nr:</td>
     <td><input type=text name=\"nr_ext\" value=\"$nr_ext\" style=\"width:200px;\" maxlength=50></td>
   </tr>";
if($_config_produkte_gruppe)
	print "<tr>
    <td width=100>Produktegruppe:</td>
    <td><input type=text name=\"gruppe\" value=\"$gruppe\" style=\"width:200px;\" maxlength=50></td>
  </tr>";
if($_config_produkte_text1)
	print "<tr>
    <td width=100>$_config_produkte_text1_name:</td>
    <td><input type=text name=\"text1\" value=\"$text1\" style=\"width:200px;\" maxlength=50></td>
  </tr>";
if($_config_produkte_text2) 
  print "<tr>
    <td width=100>$_config_produkte_text2_name:</td>
    <td><input type=text name=\"text2\" value=\"$text2\" style=\"width:200px;\" maxlength=50></td>
  </tr>";
if($_config_produkte_preis1) 
   print "<tr>
    <td width=100>$_config_produkte_preis1_name:</td>
    <td><input type=text name=\"preis1\" value=\"$preis1\" style=\"width:200px;\" maxlength=50></td>
  </tr>";
if($_config_produkte_preis2) 
   print "<tr>
    <td width=100>$_config_produkte_preis2_name:</td>
    <td><input type=text name=\"preis2\" value=\"$preis2\" style=\"width:200px;\" maxlength=50></td>
   </tr>";
if($_config_produkte_preis3) 
   print "<tr>
     <td width=100>$_config_produkte_preis3_name:</td>
     <td><input type=text name=\"preis3\" value=\"$preis3\" style=\"width:200px;\" maxlength=50></td>
   </tr>";
if($_config_produkte_preis4) 
   print "<tr>
     <td width=100>$_config_produkte_preis4_name:</td>
     <td><input type=text name=\"preis4\" value=\"$preis4\" style=\"width:200px;\" maxlength=50></td>
   </tr>";
if($_config_produkte_rabattstufe)
   print "<tr>
     <td width=100>Rabattstufe:</td>
     <td><input type=text name=\"rabattstufe\" value=\"$rabattstufe\" style=\"width:200px;\" maxlength=50></td>
   </tr>";
if($_config_produkte_warenbestand)
   print "<tr>
     <td width=100>Warenbestand:</td>
     <td><input type=text name=\"warenbestand\" value=\"$warenbestand\" style=\"width:200px;\" maxlength=50></td>
   </tr>";
print"</table>
	<input type=submit name=submit value=\"Hinzufügen\">\n</form>\n";
?>
</body>
</html>
