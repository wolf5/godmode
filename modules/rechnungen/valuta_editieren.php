<? 
include("../../inc/config.inc.php");
  
include("../../inc/func.inc.php");
if(!$back){
	$back="bezahlte.php";
}
if($submit) {
  $query=mysql_query("UPDATE Rechnungen SET bezahlt='".date_CH_to_EN($datum)."' WHERE id='$id'");
	if(!($err=mysql_error())) {
		header("Location: $back");
	}
}
?>
<html>
<head>
  <title><?=$_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body>
<p class=titel>Rechnungen:Valuta Datum Editieren</p>
<?
if($err) {
	print "<b>Fehler:</b> $err";
}
$query=mysql_query("SELECT DATE_FORMAT(bezahlt,'$_config_date') FROM Rechnungen WHERE id='$id'");
if(@mysql_num_rows($query)<1) {
	print "<b>Fehler</b>: Rechnung nicht Gefunden<br><br>\n";
} else {
	$bezahlt=mysql_result($query,0,0);
	print "<form method=post value=\"$PHP_SELF?id=$id&back=".urlencode($back)."\">
		Datum : <input type=text name=datum value=\"$bezahlt\"><br><br>
		<input type=submit name=submit value=\"Ändern\"> <input type=button value=\"Zurück\" onclick=\"javascript:location.href='$back'\">
		</form>";		
}
?>
</body>
</html>
