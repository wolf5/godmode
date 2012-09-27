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
<p class=titel>Produkte</p>
<form method=get action="<?=$PHP_SELF?>">
<input type=text name=term id=term value="<?=$term?>">
<input type=submit name=search value="Suchen">
</form>
<?
if(!$order)
	$order="nr_int";
if(!$start){
	$start=0;
}
if($term){
	$query=mysql_query("SELECT id,nr_int,nr_ext,gruppe,text1,preis1 FROM Produkte WHERE ".formatSearchString($term,array("nr_int","nr_ext","gruppe","text1","text2","preis1","preis2","preis3","preis4","rabattstufe","warenbestand"))."ORDER BY $order LIMIT $start,$_config_entrysperpage");
} else {
	$query=mysql_query("SELECT id,nr_int,nr_ext,gruppe,text1,preis1 FROM Produkte ORDER BY $order LIMIT $start,$_config_entrysperpage");
	
}
if(@mysql_num_rows($query)>0)
{
	print "<table border=0 cellpadding=3 cellspacing=0 width=\"95%\">
		<tr>
			<td><b><a href=\"$PHP_SELF?oder=nr_int\">Int. Prod. Nr.</a></b></td>
			<td><b><a href=\"$PHP_SELF?order=nr_ext\">Ext. Prod. Nr.</a></b></td>
			<td><b><a href=\"$PHP_SELF?order=gruppe\">Prod. Gruppe</a></b></td>
			<td><b><a href=\"$PHP_SELF?order=text1\">$_config_produkte_text1_name</a></b></td>
			<td><b><a href=\"$PHP_SELF?order=preis1\">$_config_produkte_preis1_name</a></b></td>
		</tr>\n";
	for($i=0;list($id,$nr_int,$nr_ext,$gruppe,$text1,$preis1)=mysql_fetch_row($query);$i++)
	{
		if(($i%2)==0){
			$bgcolor=$_config_tbl_bgcolor1;
		} else {
			$bgcolor=$_config_tbl_bgcolor2;
		}
		if(strlen($text1)>100) {
			$text1=substr($text1,0,100)."...";
		}
		print "<tr onmouseover=\"setPointer(this, 'over', '#$bgcolor', '#$_config_tbl_bghover', '')\" onmouseout=\"setPointer(this, 'out', '#$bgcolor', '#$_config_tbl_bghover', '')\" onclick=\"location.href='edit.php?id=$id'\">
			<td width=100 align=right bgcolor=\"#$bgcolor\">$nr_int</td>
			<td width=100 align=right bgcolor=\"#$bgcolor\">$nr_ext</td>
			<td width=100 bgcolor=\"#$bgcolor\">$gruppe</td>
			<td width=\"*\" bgcolor=\"#$bgcolor\">$text1</td>
			<td width=50 align=right bgcolor=\"#$bgcolor\">".formatBetrag($preis1)."</td>
		</tr>\n";
	}
	print "<tr>
		<td colspan=6 align=center>";
	if($term){
    $attr="&term=$term";
  }
	if($start>0){
		print "<a href=\"$PHP_SELF?start=".($start-$_config_entrysperpage)."$attr\"><<<</a>";
	}
	if($term){
		$query=mysql_query("SELECT count(*) FROM Produkte WHERE ".formatSearchString($term,array("nr_int","nr_ext","gruppe","text1","text2","preis1","preis2","preis3","preis4","rabattstufe","warenbestand")));
	} else {
		$query=mysql_query("SELECT count(*) FROM Produkte");
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
	print "Keine Produkte gefunden";
}
?>
</body>
</html>
