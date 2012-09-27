<? 
include("../../inc/config.inc.php");
include("../../inc/func.inc.php");
?>
<html>
<head>
  <title>Sylon godmode</title>
  <link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body>
<p class=titel>Statistiken:Übersicht</p>
<br><br>
<?
$query=mysql_query("SELECT id,titel FROM Statistiken WHERE aktiv=1 ORDER BY titel");
while(list($id,$titel)=mysql_fetch_row($query)){
	print "<a href=\"statistik.php?id=$id\">$titel</a> (<a href=\"csv.php?id=$id\">CSV</a>)<br>";
}
?>
