<? 
include("../../inc/config.inc.php");
?>
<html>
<head>
	<title><?=$_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body onLoad="javascript:document.getElementById('site').focus()">
<p class=titel>Domains:Whois</p>
<form method=post action="<?=$PHP_SELF?>">
<input type=text id=site name=site value="<?=$site?>">
<input type=submit value="Whois">
</form>
<pre>
<?
print shell_exec("$_config_whois_program ".escapeshellarg($site));
?>
</pre>
</body>
</html>
