<? 
include("../../inc/config.inc.php");
  
include("../../inc/func.inc.php");
?>

<html>
<head>
  <title><?=$_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
	<script src="../../inc/functions.js" type="text/javascript" language="javascript"></script>
</head>
<body>
<p class=titel>Rechnungen:Positionen</p>
<?
$query=mysql_query("SELECT pos.id, pos.kontakt,pos.text,pos.text1,pos.betrag,pos.waehrung,DATE_FORMAT(pos.datum,'$_config_date') FROM Rechnungen_positionen pos, Kontakte kon WHERE Rechnung is NULL AND pos.kontakt = kon.id ORDER BY kon.firma");
if(@mysql_num_rows($query)>0){
	print "<table cellpadding=2 cellspacing=0 border=0 width=\"95%\">
    <tr>
      <td width=250><b>Kontakt</b></td>
      <td width=\"*\"><b>Text</b></td>
      <td width=80 align=right><b>Datum</b></td>
      <td width=100 align=right><b>Betrag</b></td>
			<td width=130><b>Aktion</b></td>
    </tr>\n";

	for($i=0;list($id,$id_kon,$text,$text1,$betrag,$waehrung,$datum)=mysql_fetch_row($query);$i++){
		if($lastid == $id_kon){
			$i++;
		}
		if(($i%2)==0){
			$bgcolor=$_config_tbl_bgcolor1;
		} else {
			$bgcolor=$_config_tbl_bgcolor2;
		}
		$td="onclick=\"location.href='position_edit.php?id=$id'\" bgcolor=\"#$bgcolor\" valign=top";
		print "<tr onmouseover=\"setPointer(this, 'over', '#$bgcolor', '#$_config_tbl_bghover', '')\" onmouseout=\"setPointer(this, 'out', '#$bgcolor', '#$_config_tbl_bghover', '')\">
			<td width=250 bgcolor=\"#$bgcolor\" valign=top>";
		if($id_kon!=$lastid)
			print "<a href=\"../kontakte/kontakt.php?id=$id_kon&back=".urlencode($REQUEST_URI)."\">".getKontakt($id_kon)."</a></td>";
		else
			print "&nbsp;";
		print "</td>
			<td width=200 $td>$text</td>
			<td width=80 align=right $td>$datum</td>
			<td width=100 align=right $td".formatBetrag($betrag)." ".getWaehrungHtml($waehrung)."</td>
			<td width=130 bgcolor=\"#$bgcolor\" valign=top>";
		if($id_kon!=$lastid)
			print "<a href=\"erstellen1.php?id=$id_kon\">Rechnung erstellen</a>";
		print "</td>
			</tr>";
		$lastid=$id_kon;
	}
	print "</table>\n<br><br>\n";
} else {
	print "<b>Keine offene Positionen gefunden</b>";
}
?>

</body>
</html>
