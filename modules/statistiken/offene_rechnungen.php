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
<p class=titel>Statistiken:Offene Rechnungen</p>
<br><br>
<?
$query=mysql_query("select DATE_FORMAT(rech.datum,'$_config_date') as datum, rech.id,rech.kontakt,sum($_config_posbetrag) as betrag,sum(($_config_posbetrag)*rech.fx) as betrag_chf,rech.waehrung,rech.betreff,rech.zahlungsfrist  FROM Rechnungen rech, Rechnungen_positionen pos WHERE pos.rechnung = rech.id AND rech.bezahlt is NULL GROUP BY rech.id ORDER BY datum");
echo mysql_error();
if(mysql_num_rows($query)>0){
	print "<table border=0 cellspacing=0>
	<tr>
		<td><b>Rech.-Nr.</b></td>
		<td><b>Kontakt</b></td>
		<td width=100><b>Datum</b></td>
		<td width=100><b>Zahlungsfrist</b></td>
		<td width=100><b>Text</b></td>
		<td align=right width=100><b>Betrag</b></td>
		<td align=right width=100><b>Betrag CHF</b></td>
	</tr>\n";
	$total=0;
	for($i=0;(list($datum,$id,$kontakt,$betrag,$betrag_chf,$waehrung,$text,$zahlungsfrist)=mysql_fetch_row($query));$i++) {
		if(($i%2)==0){
      $bgcolor=$_config_tbl_bgcolor1;
    } else {
      $bgcolor=$_config_tbl_bgcolor2;
    }
		print "<tr>
			<td valign=top bgcolor=\"$bgcolor\">$id</td>
			<td valign=top bgcolor=\"$bgcolor\">".getKontakt($kontakt)."</td>
			<td width=100 valign=top bgcolor=\"$bgcolor\">$datum</td>
			<td width=100 valign=top bgcolor=\"$bgcolor\">".date($_config_date_php,strtotime("+$zahlungsfrist days",strtotime(date_CH_to_EN($datum))))."</td>
			<td valign=top bgcolor=\"$bgcolor\">$text</td>";
			if($betrag!=$betrag_chf) {
				print "<td align=right valign=top bgcolor=\"$bgcolor\">".formatBetrag($betrag)." ".getWaehrungHtml($waehrung)."</td>";
			} else {
				print "<td bgcolor=\"$bgcolor\">&nbsp;</td>";
			}
			print "<td align=right valign=top bgcolor=\"$bgcolor\">".formatBetrag($betrag_chf)."</td>
		</tr>";
		$total+=$betrag_chf;
	}
	print "<tr>
			<td colspan=6><b>Total</b></td>
			<td align=right><b>".formatBetrag($total)."</b></td>
		</tr>
		</table>";
}
?>
</body>
</html>
