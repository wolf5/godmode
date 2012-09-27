<? 
/*include("../../inc/config.inc.php");
include("../../inc/func.inc.php");*/
/*include("../../inc/config.inc.php");*/
include("inc/func.inc.php");
?>

<html>
<head>
  <title>Sylon godmode</title>
  <link rel="stylesheet" href="../../main.css" type=text/css>
  <script type="text/javascript" src="inc/js/jquery-1.4.4.min.js"></script>
  <script type="text/javascript" src="inc/js/func.js"></script>
</head>
<body>
<p class=titel>Kundenverwaltung</p>
<br><br>

<table>
<?
$query=mysql_query("select ts.Kunde, con.id, firma, firma2 from Kontakte as con LEFT JOIN  Timesheet_Kontakte as ts ON ( con.id = ts.Kunde) where con.aktiv = 1");
echo mysql_error();
while ($customer = mysql_fetch_array($query)){
	echo "<tr>";
	echo "<td>";
	if (!empty($customer['Kunde']))
		echo "<td><input type='checkbox' checked='checked' value='".$customer['id']."' id='".$customer['id']."' name='remove' class='cBox'/></td>";
	else
		echo "<td><input type='checkbox' name='add'  value='".$customer['id']."' id='".$customer['id']."' class='cBox'/></td>";
	echo "<td>".$customer['id']."</td><td>".$customer['firma']."</td><td>".$customer['firma2']."</td>";
	echo "</tr>";
}
?>
</table>
</body>
</html>
