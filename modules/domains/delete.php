<?php 
session_start();
include("../../inc/config.inc.php");
  
include("../../inc/func.inc.php");
include("func.inc.php");
if(!$back) {
	$back="show.php";
}
if(!$backno) {
	$backno=$back;
}
if($del) {
	$query=mysql_query("UPDATE Domains SET endDate=NOW() WHERE id='$del'");
	if($query) {
		header("Location: ".urldecode($back));
	} else {
		$err=mysql_error();
	}
}
?>
<html>
<head>
	<title><?php echo $_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body>
<p class=titel>Domains:Domain Löschen</p>
<?php
	if($err){
		print "<b>Fehler:</b> $err<br><br>";
	}
	print "Möchten Sie die Domain '".getDomain($id)."' wirklich Löschen?<br><br>
<a href=\"$PHP_SELF?del=$id&back=".urldecode($back)."\">[ Ja ]</a> <a href=\"".urldecode($backno)."\">[ Nein ]</a>";
?>
</body>
</html>
