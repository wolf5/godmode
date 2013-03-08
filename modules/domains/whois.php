<?php 
include("../../inc/config.inc.php");
?>
<html>
<head>
	<title><?php echo $_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body onLoad="javascript:document.getElementById('site').focus()">
<p class=titel>Domains:Whois</p>
<form method=post action="<?php=$PHP_SELF?>">
<input type=text id=site name=site value="<?php=$site?>">
<input type=submit value="Whois">
</form>
<pre>
<?php
print shell_exec("$_config_whois_program ".escapeshellarg($site));
?>
</pre>
</body>
</html>
