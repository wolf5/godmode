<? 
include("../../inc/config.inc.php");
include("../../inc/func.inc.php");
include("func.inc.php");

$query=mysql_query("SELECT titel,sql,ueberschriften,filename,datumsfeld,total FROM Statistiken WHERE id='$id'");
list($titel,$sql,$ueberschriften,$filename,$datumsfeld,$total)=mysql_fetch_row($query);
?>
<html>
<head>
  <title>Sylon godmode</title>
  <link rel="stylesheet" href="../../main.css" type=text/css>
	<style type="text/css">
		.gitternetz { border-style:solid;border-collapse: collapse;border-width:1px;empty-cells:show;border-color: #000000 }
	</style>
</head>
<body>
<p class=titel>Statistiken:<?=$titel?></p>
<?
print "<a href=\"csv.php?id=$id&start=$start&end=$end&sort=$sort&order=$order\">CSV</a>
<br><br>";

if($datumsfeld)
	print "<form method=post action=\"$PHP_SELF?id=$id\">
<table border=0 cellpadding=0>
<tr>
	<td>Anfang:</td>
	<td><input type=text maxlength=10 name=start value=\"$start\"></td>
</tr>
<tr>
  <td>Ende:</td>
  <td><input type=text maxlength=10 name=end value=\"$end\"></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type=submit value=\"Aktualisieren\"></td>
</tr>
</table>
</form>
<br>";

eval("\$sql = \"$sql\";");
if($start) {
	$sql= str_replace("WHERE","WHERE $datumsfeld >= '".date_CH_to_EN($start)."' AND",$sql);
} 
if($end) {
	$sql= str_replace("WHERE","WHERE $datumsfeld <= '".date_CH_to_EN($end)."' AND",$sql);
}
if($sort) {
	if(stristr($sql,"ORDER BY")) {
		$sql = substr($sql,0,strpos(strtolower($sql),"order by"))."ORDER BY $sort";
	} else {
		$sql.= " ORDER BY $sort";
	}
	if($order){
		$sql.= " ".$order;
	}
}
$query=mysql_query($sql);
if(mysql_error())  print "Fehler: ".mysql_error()."<br><br>SQL Query:<br>".$sql;
if(mysql_num_rows($query)>0){
	print "<table border=0 cellspacing=0 cellpadding=2 class=gitternetz>
	<tr>\n";
	$i=0;
	$ueberschriften=split(",",$ueberschriften);
	foreach($ueberschriften as $ueberschrift) {
		$ueberschrift = str_replace(">","",$ueberschrift);
		$ueberschrift = str_replace("<","",$ueberschrift);
		if($sort==mysql_field_name($query,$i)) {
			$order="DESC";
		} else {
			$order="ASC";
		}
		print "	<td class=gitternetz align=".getAlignment($ueberschriften,$i)."><b><nobr><a href=\"$PHP_SELF?id=$id&start=$start&end=$end&sort=".mysql_field_name($query,$i)."&order=$order\">$ueberschrift</a></nobr></b></td>\n";
		$i++;
	}
	print "</tr>\n";
	$total_val = array();
	while($row=mysql_fetch_row($query)){
		print "<tr>\n";
		for($i=0;$i<mysql_num_fields($query);$i++) {
			if(strlen($row[$i])==0) $row[$i]="&nbsp;";
			if(is_numeric($row[$i])) $total_val[$i]+=$row[$i];
			print "	<td class=gitternetz valign=top align=".getAlignment($ueberschriften,$i).">".$row[$i]."</td>\n";
		}
		print "</tr>\n";
	}
	
	if(strlen($total)>0) {
		$total = split(",",$total);
		print "<tr>\n";
		for($i=0;$i<mysql_num_fields($query);$i++) {
			if(in_array(mysql_field_name($query,$i),$total)) {
				print "	<td class=gitternetz align=".getAlignment($ueberschriften,$i)."><b>".formatBetrag($total_val[$i])."</b></td>\n";
			} else {
				print "	<td class=gitternetz>&nbsp;</td>\n";
			}
		}
		print "</tr>\n";
	}
	print "</table>";
}
?>
