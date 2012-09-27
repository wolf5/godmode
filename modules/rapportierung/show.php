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
<body onLoad="document.getElementById('term').focus()">
<p class=titel>Rapporte</p>
<form method=get action="<?=$PHP_SELF?>">
<input type=text name=term id=term value="<?=$term?>">
<input type=submit name=search value="Suchen">
</form>
<?
if($order=="kontakt")
	$order="ORDER BY kon.firma";
else if($order=="betrag")
	$order="ORDER BY (abr.raten*dom.betrag)";
else
	$order="date";
if(!$start){
	$start=0;
}
if($term){
	$query=mysql_query("SELECT id,employee,kontakt,projekt,code,text,date,time,time_clearable FROM Rapportierug WHERE ".formatSearchString($term,array("","dom.id"))." $order LIMIT $start,$_config_entrysperpage");
} else {
	$query=mysql_query("SELECT id,employee,kontakt,projekt,code,text,DATE_FORMAT(date,'$_config_date'),time,time_clearable FROM Rapportierung ORDER BY $order LIMIT $start,$_config_entrysperpage");
}
echo mysql_error();
if(@mysql_num_rows($query)>0)
{
	print "<table border=0 cellpadding=3 cellspacing=0 width=\"95%\">
		<tr>
			<td><b><a href=\"$PHP_SELF\">Kontakt</a></b></td>
			<td><b><a href=\"$PHP_SELF?order=date\">Datum</a></b></td>
			<td><b><a href=\"$PHP_SELF?order=employee\">Mitarbeiter</a></b></td>
			<td><b><a href=\"$PHP_SELF?order=projekt\">Projekt</a></b></td>
			<td><b><a href=\"$PHP_SELF?order=code\">Code</a></b></td>
			<td><b><a href=\"$PHP_SELF?order=time\">Stunden</a></b></td>
			<td><b><a href=\"$PHP_SELF?order=text\">Text</a></b></td>
			
		</tr>\n";
	$total=0;
	for($i=0;list($id,$employee,$kontakt,$projekt,$code,$text,$date,$time,$time_clearable )=mysql_fetch_row($query);$i++)
	{
		if(($i%2)==0){
			$bgcolor=$_config_tbl_bgcolor1;
		} else {
			$bgcolor=$_config_tbl_bgcolor2;
		}
		if(strlen($text)>200) $text=substr($text,0,200)."...";
		print "<tr onmouseover=\"setPointer(this, 'over', '#$bgcolor', '#$_config_tbl_bghover', '')\" onmouseout=\"setPointer(this, 'out', '#$bgcolor', '#$_config_tbl_bghover', '')\" onclick=\"location.href='rapport.php?id=$id&back=".urlencode($REQUEST_URI)."'\">
			<td width=200 bgcolor=\"#$bgcolor\"><a href=\"../kontakte/kontakt.php?id=$kontakt&back=".urlencode($REQUEST_URI)."\">".getKontakt($kontakt)."</a></td>
			<td width=80 bgcolor=\"#$bgcolor\">$date</td>
			<td width=80 bgcolor=\"#$bgcolor\">".getEmp($employee)."</td>
			<td width=80 bgcolor=\"#$bgcolor\">$projekt</td>
			<td width=40 bgcolor=\"#$bgcolor\">$code</td>
			<td width=50 align=right bgcolor=\"#$bgcolor\">$time ($time_clearable)</td>
			<td bgcolor=\"#$bgcolor\">$text</td>
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
		$query=mysql_query("SELECT count(*) FROM Rapportierung WHERE ".formatSearchString($term,array("domain")));
	} else {
		$query=mysql_query("SELECT count(*) FROM Rapportierung");
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
	print "Keine Rapporte gefunden";
}
?>
</body>
</html>
