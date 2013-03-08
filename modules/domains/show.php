<?php
include("../../inc/config.inc.php");
 
include("../../inc/func.inc.php");	
?>
<html>
<head>
  <title><?php echo $_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
	<script src="../../inc/functions.js" type="text/javascript" language="javascript"></script>
</head>
<body onLoad="document.getElementById('term').focus()">
<p class=titel>Domains</p>
<form method=get action="<?php=$PHP_SELF?>">
<input type=text name=term id=term value="<?php=$term?>">
<input type=submit name=search value="Suchen">
</form>
<?php
if($order=="kontakt")
	$order="ORDER BY kon.firma";
else if($order=="betrag")
	$order="ORDER BY (abr.raten*dom.betrag)";
else
	$order="ORDER BY dom.domain";
if(!$start){
	$start=0;
}
if($term){
	$query=mysql_query("SELECT dom.id, dom.domain, kon.id, dom.startDate, dom.endDate, abr.raten * dom.betrag FROM Kontakte kon,Domains dom ,Zahlungsarten abr WHERE dom.kontakt = kon.id AND dom.abrechnungsart = abr.id AND dom.endDate is NULL AND ".formatSearchString($term,array("dom.domain","dom.id"))." $order LIMIT $start,$_config_entrysperpage");
} else {
	$query=mysql_query("SELECT dom.id, dom.domain, kon.id, dom.startDate, dom.endDate, (abr.raten * dom.betrag) FROM Kontakte kon,Domains dom ,Zahlungsarten abr WHERE dom.kontakt = kon.id AND dom.abrechnungsart = abr.id AND dom.endDate is NULL $order LIMIT $start,$_config_entrysperpage");
}
if(@mysql_num_rows($query)>0)
{
	print "<table border=0 cellpadding=3 cellspacing=0 width=\"95%\">
		<tr>
			<td><b><a href=\"$PHP_SELF\">Domain</a></b></td>
			<td><b><a href=\"$PHP_SELF?order=person\">Kontakt</a></b></td>
			<td><b><a href=\"$PHP_SELF?order=betrag\">Betrag</a></b></td>
		</tr>\n";
	$total=0;
	for($i=0;list($id,$domain,$kontakt,$startDate,$endDate,$betrag)=mysql_fetch_row($query);$i++)
	{
		if(($i%2)==0){
			$bgcolor=$_config_tbl_bgcolor1;
		} else {
			$bgcolor=$_config_tbl_bgcolor2;
		}
		$total+=$betrag;
		print "<tr onmouseover=\"setPointer(this, 'over', '#$bgcolor', '#$_config_tbl_bghover', '')\" onmouseout=\"setPointer(this, 'out', '#$bgcolor', '#$_config_tbl_bghover', '')\" onclick=\"location.href='domain.php?id=$id&back=".urlencode($REQUEST_URI)."'\">
			<td width=200$ bgcolor=\"#$bgcolor\">$domain</td>
			<td bgcolor=\"#$bgcolor\"><a href=\"../kontakte/kontakt.php?id=$kontakt&back=".urlencode($REQUEST_URI)."\">".getKontakt($kontakt)."</a></td>
			<td width=50 align=right bgcolor=\"#$bgcolor\">".formatBetrag($betrag)."</td>
		</tr>\n";
	}
	print "<tr>
		<td colspan=3 align=center>";
	if($term){
    $attr="&term=$term";
  }
	if($start>0){
		print "<a href=\"$PHP_SELF?start=".($start-$_config_entrysperpage)."$attr\"><<<</a>";
	}
	if($term){
		$query=mysql_query("SELECT count(*) FROM Domains WHERE endDate is NULL AND ".formatSearchString($term,array("domain")));
	} else {
		$query=mysql_query("SELECT count(*) FROM Domains where endDate is NULL");
	}
	if(($start+$_config_entrysperpage+1)<=mysql_result($query,0,0)){
		if($start>0){
			print " | ";
		}
		print "<a href=\"$PHP_SELF?start=".($start+$_config_entrysperpage)."$attr\">>>></a>";
	}
	print "</td>
		</tr>
		</table>\n";
} else {
	print "Keine Domains gefunden";
}
?>
</body>
</html>
