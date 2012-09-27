<?
include("inc/config.inc.php");
?>
<html>
<head>
	<title><?=$_config_title?></title>
	<link rel="stylesheet" href="menu.css" type=text/css>
</head>
<body>
<base target=main>
<div class=titel2><?=$_config_title?></div><br>
<?
if(!$_config_modules){
	print "<b>Fehler:</b> $"."config_modules ist nicht definiert<br><br>\n</body>\n</html>";
	exit;
}

foreach(split(",",$_config_modules) as $module){
	$module=trim($module);
	$menufile=@file("modules/$module/menu.inc.php");
	if(!$menufile){
		print "<b>Fehler:</b> Menufile f&uuml;r Modul $module nicht gefunden<br><br>\n";
		continue;
	}
	print "<p>";
	for($i=0;$menufile[$i];$i++){
		if(strstr($menufile[$i],"=")===FALSE){
			print "<b>".$menufile[$i]."</b><br>\n";
		} else if($menufile[$i]==""){
			print "<br>\n";
		} else {
			print "<a href=\"modules/$module/".substr($menufile[$i],strpos($menufile[$i],"=")+1,strlen($menufile[$i])-strpos($menufile[$i],"="))."\">".substr($menufile[$i],0,strpos($menufile[$i],"="))."</a><br>\n";
		}
	}
	print "</p>\n";

}
?>
<!--<b>Personen</b><br>
<a href="personen_anzeigen.php">Anzeigen/Editieren</a><br>
<a href="personen_neu.php">Hinzufügen</a><br>
<a href="personen_del.php">Löschen</a><br><br>

<b>Domains</b><br>
<a href="domains_anzeigen.php">Anzeigen/Editieren</a><br>
<a href="domains_neu.php">Hinzufügen</a><br>
<a href="domains_del.php">L&ouml;schen</a><br><br>

<b>Rechnungen</b><br>
<a href="rechnungen_erstellen.php">Rechnungen erstellen</a><br>
<a href="rechnungen_offene.php">Offene Rechnungen</a><br>
<a href="rechnungen_bezahlte.php">Bezahlte Rechnungen</a><br>
<a href="rechnungen_gutschriften.php">Gutschriften</a><br>
<a href="rechnungen_statistiken.php">Statistiken</a><br>-->
</body>
</html>
