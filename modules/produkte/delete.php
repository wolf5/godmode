<? 
include("../../inc/config.inc.php");
include("../../inc/func.inc.php");

if(!$back) {
	$back="show.php";
}
if(!$backno) {
	$backno=$back;
}
if($del) {
	$query=mysql_query("DELETE FROM Produkte WHERE id='$del'");
	if($query) {
		header("Location: ".urldecode($back));
	} else {
		$err=mysql_error();
	}
}
?>
<html>
<head>
	<title><?=$_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body>
<p class=titel>Produkte:Produkt L�schen</p>
<?
	if($err){
		print "<b>Fehler:</b> $err<br><br>";
	}
	$query=mysql_query("SELECT text1,nr_int FROM Produkte WHERE id='$id'");
	print "M�chten Sie das Produkt '".mysql_result($query,0,0)." (".mysql_result($query,0,1).")' wirklich L�schen?<br><br>
<a href=\"$PHP_SELF?del=$id&back=".urldecode($back)."\">[ Ja ]</a> <a href=\"".urldecode($backno)."\">[ Nein ]</a>";
?>
</body>
</html>
