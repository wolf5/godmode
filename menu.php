<?php
include("inc/config.inc.php");
?>
<html>
<head>
	<title><?php echo $_config_title?></title>
	<link rel="stylesheet" href="menu.css" type=text/css>
</head>
<body>
<base target=main>
<div class=titel2><?php echo $_config_title?></div><br>
<?php
if(!isset($_config_modules)){
	print "<b>Fehler:</b> $"."config_modules ist nicht definiert<br><br>\n</body>\n</html>";
  exit;
}

foreach(explode(",",$_config_modules) as $module){
	$module=trim($module);
	$menufile=@file("modules/$module/menu.inc.php");
	if(!$menufile){
		print "<b>Fehler:</b> Menufile f&uuml;r Modul $module nicht gefunden<br><br>\n";
		continue;
	}
	print "<p>";   
	foreach ($menufile as $menufile_value){
		if(strstr($menufile_value,"=")===FALSE){
			print "<b>".$menufile_value."</b><br>\n";
		} else if($menufile_value==""){
			print "<br>\n";
		} else {
			print "<a href=\"modules/$module/".substr($menufile_value,strpos($menufile_value,"=")+1,strlen($menufile_value)-strpos($menufile_value,"="))."\" target=main>".substr($menufile_value,0,strpos($menufile_value,"="))."</a><br>\n";
		}
	}
	print "</p>\n";
      
}

?>
<br>

</body>
</html>
