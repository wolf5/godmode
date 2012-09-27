<? 
include("../../inc/config.inc.php");
  
include("../../inc/func.inc.php");
?>

<html>
<head>
  <title><?=$_config_title?></title>
  <link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body onLoad="document.getElementById('term').focus()">
<p class=titel>Rechnungen:Bezahlte Rechnungen</p>
<form method=get action="<?=$PHP_SELF?>">
<input type=text name=term id=term value="<?=$term?>">
<input type=submit name=search value="Suchen">
</form>
<?
if($order=="datum"){
	$order_int="ORDER BY rech.datum";
} else if($order=="betreff") {
	$order_int="ORDER BY rech.betreff";
} else if($order=="betrag") {
	$order_int="ORDER BY betrag";
} else if($order=="id") {
	$order_int="ORDER BY rech.id";
} else if($order=="bezahlt") {
	$order_int="ORDER BY rech.bezahlt";
} else {
	$order_int="ORDER BY kon.firma";
}
if(!$start){
  $start=0;
}
if($term){
	$query=mysql_query("select rech.id, kon.id, DATE_FORMAT(rech.datum,'$_config_date'), DATE_FORMAT(rech.bezahlt,'$_config_date'),rech.betreff, sum($_config_posbetrag) as betrag FROM Rechnungen_positionen pos, Rechnungen rech, Kontakte kon WHERE rech.id = pos.rechnung AND rech.bezahlt is NOT NULL AND rech.kontakt = kon.id AND ".formatSearchString($term,array("kon.firma","kon.firma2"))." GROUP BY pos.rechnung $order_int LIMIT $start,$_config_entrysperpage");
} else {
	$query=mysql_query("select rech.id, kon.id, DATE_FORMAT(rech.datum,'$_config_date'), DATE_FORMAT(rech.bezahlt,'$_config_date'),rech.betreff, sum($_config_posbetrag) as betrag FROM Rechnungen_positionen pos, Rechnungen rech, Kontakte kon WHERE rech.id = pos.rechnung AND rech.bezahlt is NOT NULL AND rech.kontakt = kon.id GROUP BY pos.rechnung $order_int LIMIT $start,$_config_entrysperpage");
}
if(@mysql_num_rows($query)<1)
{
	print "<b>Keine Bezahlte Rechnungen</b>";
	exit;
}
print "<form action=\"$PHP_SELF\" method=post>
<table width=\"95%\" border=0 cellpadding=2 cellspacing=0>
<tr>
	<td><a href=\"$PHP_SELF\"><b>Kontakt</b></a></td>
	<td><a href=\"$PHP_SELF?order=datum\"><b>Datum</b></a></td>
	<td><a href=\"$PHP_SELF?order=bezahlt\"><b>Valuta</b></a></td>
  <td><a href=\"$PHP_SELF?order=id\"><b>Nr.</b></a></td>
	<td><a href=\"$PHP_SELF?order=betreff\"><b>Betreff</b></a></td>
	<td align=right><a href=\"$PHP_SELF?order=betrag\"><b>Betrag</b></a></td>
	<td>&nbsp;</td>
</tr>";
for($i=0;list($id,$kontakt,$datum,$bezahlt,$betreff,$betrag)=mysql_fetch_row($query);$i++)
{
	if(($i%2)==0){
		$bgcolor=$_config_tbl_bgcolor1;
	} else {
		$bgcolor=$_config_tbl_bgcolor2;
	}
	//Gutschriften vom Total abziehen
	$query2=mysql_query("SELECT sum(betrag) FROM Rechnungen_gutschriften WHERE bezahlt='$id'");
	if(mysql_num_rows($query2)>0) {
		$betrag-= mysql_result($query2,0,0);
	}
	print "<tr>
			<td bgcolor=\"#$bgcolor\"><a href=\"../../modules/kontakte/kontakt.php?id=$kontakt&back=".urlencode($REQUEST_URI)."\">".getKontakt($kontakt)."</a></td>
			<td bgcolor=\"#$bgcolor\">$datum</td>
			<td bgcolor=\"#$bgcolor\"><a href=\"valuta_editieren.php?id=$id&back=".urlencode("bezahlte.php")."\">$bezahlt</a></td>
			<td bgcolor=\"#$bgcolor\">".str_pad($id,4,"0",STR_PAD_LEFT)."</td>
			<td bgcolor=\"#$bgcolor\" width=100>$betreff</td>
			<td align=right bgcolor=\"#$bgcolor\">".formatBetrag($betrag)."</td>
			<td bgcolor=\"#$bgcolor\"><a href=\"createPDF.php?id=$id\">PDF</a></td>
		</tr>\n";
}
print "<tr>
    <td colspan=4 align=center>";
	if($term) $attr="&term=$term";
	if($order) $attr.="&order=$order";
  if($start>0){
    print "<a href=\"$PHP_SELF?start=".($start-$_config_entrysperpage)."$attr\"><<<</a>";
  }
	if($term){
		$query=mysql_query("SELECT count(*) FROM Rechnungen rech, Kontakte kon WHERE rech.bezahlt is NOT NULL AND kon.id = rech.kontakt AND ".formatSearchString($term,array("kon.firma","kon.firma2")));
	} else {
		$query=mysql_query("SELECT count(*) FROM Rechnungen WHERE bezahlt is NOT NULL");
	}
  if(($start+$_config_entrysperpage+1)<=mysql_result($query,0,0)){
    if($start>0){
      print " | ";
    }
    print "<a href=\"$PHP_SELF?start=".($start+$_config_entrysperpage)."$attr\">>>></a>";
  }
  print "</td>
    </tr>
		</table>
	</form>";
?>
</body>
</html>
