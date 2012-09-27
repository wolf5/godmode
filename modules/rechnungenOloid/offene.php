<? 
include("../../inc/config.inc.php");
  
include("../../inc/func.inc.php");
?>

<html>
<head>
  <title><?=$_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body>
<p class=titel>Rechnungen:Offene Rechnungen</p>
<form method=get action="<?=$PHP_SELF?>">
<input type=text name=term id=term value="<?=$term?>">
<input type=submit name=search value="Suchen">
</form>
<?
if($term) {
	$query=mysql_query("SELECT rech.id,rech.fixiert,rech.kontakt,DATE_FORMAT(rech.datum,'$_config_date'),rech.betreff,rech.zahlungsfrist,rech.besrnr,rech.waehrung,sum($_config_posbetrag) FROM Rechnungen rech LEFT JOIN Rechnungen_positionen pos ON rech.id = pos.rechnung,Kontakte kon WHERE bezahlt is NULL AND ".formatSearchString($term,array("kon.firma","kon.firma2","rech.id","rech.betreff","rech.text","rech.footer"))." AND kon.id = rech.kontakt GROUP BY rech.id");
}	else {
	$query=mysql_query("SELECT rech.id,rech.fixiert,rech.kontakt,DATE_FORMAT(rech.datum,'$_config_date'),rech.betreff,rech.zahlungsfrist,rech.besrnr,rech.waehrung,sum($_config_posbetrag) FROM Rechnungen rech LEFT JOIN Rechnungen_positionen pos ON rech.id = pos.rechnung WHERE bezahlt is NULL GROUP BY rech.id");
}
if(mysql_error()){
	print "<b>Fehler:</b> ".mysql_error();
	exit;
}else if(@mysql_num_rows($query)<1)
{
	print "<b>Keine Offene Rechnungen</b>";
	exit;
}
print "<table  border=0 cellpadding=2 cellspacing=0>
<tr>
	<td><b>Kontakt</b></td>
	<td><b>Datum</b></td>
	<td><b>Nr.</b></td>
	<td><b>Betreff</b></td>
	<td><b>Betrag</b></td>
	<td><b>Aktion</b></td>
	<td><b>Mahnungen</b></td>
</tr>";
$change=-1;
for($i=0;list($id,$fixiert,$kontakt,$datum,$betreff,$zahlungsfrist,$besrnr,$waehrung,$betrag)=mysql_fetch_row($query);$i++)
{
	if($i%2==0){
		$bgcolor=$_config_tbl_bgcolor1;
	} else {
		$bgcolor=$_config_tbl_bgcolor2;
	}
	if(strtotime("+$zahlungsfrist days",strtotime(date_CH_to_EN($datum)))< strtotime(date("Y-m-d")))
		$red = " style=\"color:red\"";
	else
		$red="";
	//Gutschriften abziehen 
	$query2=mysql_query("SELECT ((betrag+((betrag/100)*mwst))*fx) FROM Rechnungen_gutschriften WHERE bezahlt='$id'");

	while(list($betrag_gut)=mysql_fetch_row($query2)) $betrag -= $betrag_gut;
	
	print "<tr>
		<td width=180 valign=top bgcolor=\"#$bgcolor\"$red><a href=\"../kontakte/kontakt.php?id=$kontakt&back=".urlencode($REQUEST_URI)."\"$red>".getKontakt($kontakt)."</a></td>
			<td width=80 valign=top bgcolor=\"#$bgcolor\"$red>$datum</td>
			<td valign=top bgcolor=\"#$bgcolor\"$red>".str_pad($id,4,"0",STR_PAD_LEFT)."</td>
			<td width=\"*\" valign=top bgcolor=\"#$bgcolor\"$red>$betreff</td>
			<td width=100 valign=top align=right bgcolor=\"#$bgcolor\"$red>".formatBetrag($betrag)." ".getWaehrungHtml($waehrung)."</td>
			<td width=280 valign=top bgcolor=\"#$bgcolor\"><a href=\"edit.php?id=$id&back=".urlencode($REQUEST_URI)."\"$red>Edit</a> ";
	print "<a href=\"bezahlt.php?id=$id&back=".urlencode($REQUEST_URI)."\"$red>Bezahlt</a> <a href=\"createPDF.php?id=$id\"$red>PDF</a> <a href=\"mahnen.php?id=$id&back=".urlencode($REQUEST_URI)."\"$red>Mahnen</a> <a href=\"delete.php?id=$id&back=".urlencode($REQUEST_URI)."\"$red>Löschen</a></td>";
	$query2=mysql_query("SELECT DATE_FORMAT(datum,'$_config_date') FROM Rechnungen_mahnungen WHERE rechnung='$id'");
	$gemahnt="";
	if(@mysql_num_rows($query2)>0)
	{
		for($ii=0;list($datum)=mysql_fetch_row($query2);$ii++)
		{
			if($ii==0)
				$gemahnt.=$datum;
			else
				$gemahnt.=", $datum";
		}
	}
	else
	{
		$gemahnt="-";
	}
	print "<td width=80 bgcolor=\"#$bgcolor\"$red>$gemahnt</td>
		</tr>\n";
}
print "<tr>
	<td colspan=3><b>Total</b>
	<td colspan=2 align=right><b>";
	if($term) {
	 $query=mysql_query("SELECT rech.id,sum($_config_posbetrag),rech.waehrung FROM Rechnungen_positionen pos, Rechnungen rech,Kontakte kon WHERE rech.id = pos.rechnung AND rech.bezahlt is NULL AND ".formatSearchString($term,array("kon.firma","kon.firma2","rech.id","rech.betreff","rech.text","rech.footer"))." AND kon.id = rech.kontakt GROUP BY rech.waehrung");
	} else {
		$query=mysql_query("SELECT rech.id,sum($_config_posbetrag),rech.waehrung FROM Rechnungen_positionen pos, Rechnungen rech WHERE rech.id = pos.rechnung AND rech.bezahlt is NULL GROUP BY rech.waehrung");
	}
for($i=0;(list($rech_id,$betrag,$waehrung)=mysql_fetch_row($query));$i++) {
	$query2=mysql_query("SELECT sum(((betrag+((betrag/100)*mwst))*fx)) FROM Rechnungen_gutschriften WHERE bezahlt='$rech_id' GROUP BY bezahlt");
	if(mysql_num_rows($query2)>0) $betrag-=mysql_result($query2,0,0);
	if($i>0) print "<br>";
  print formatBetrag($betrag)." ".getWaehrungHtml($waehrung);
}
print "</b></td>
	<td colspan=2>&nbsp;</td>
</tr>
</table>
<input type=button value=\"Exportieren\" onclick=\"javascript:location.href='export.php';\">
</form>";
?>
</body>
</html>
