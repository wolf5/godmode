<?php 
include("../../inc/config.inc.php");
include("../../inc/func.inc.php");

$term = isset($_GET["term"]) ? $_GET["term"] : NULL;
$start = isset($_GET["start"]) ? $_GET["start"] : 0;
$field_names = isset($field_names) ? $field_names : NULL;    

?>

<html>
<head>
  <title><?php echo $_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
	<script src="../../inc/functions.js" type="text/javascript" language="javascript"></script>
	<script  type="text/javascript" language="javascript">
	<!--
		function setValue(val){
			opener.document.getElementById('kontakt').value = val;
			self.close();
		}
	//-->
	</script>
</head>
<body onLoad="document.getElementById('term').focus()">
<p class=titel>Kontakt Suchen</p>

<form method=get action="<?php echo $_SERVER["PHP_SELF"] ?>">
<input type=text name=term id=term value="<?php echo $term?>">
<input type=submit name=search value="Suchen">
</form>
<?php
if($term){
	$query=mysql_query("SELECT id,firma FROM Kontakte kon WHERE aktiv=1 AND ".formatSearchString($term,array("id","firma","firma2","text"))." ORDER BY firma LIMIT $start,$_config_entrysperpage");
	$attr="&term=$term";
} else {
	$query=mysql_query("SELECT id,firma FROM Kontakte kon WHERE aktiv=1 ORDER BY firma LIMIT $start,$_config_entrysperpage");
}
echo mysql_error();
if(@mysql_num_rows($query)>0)
{
  print "<table border=0 cellpadding=3 cellspacing=0 width=\"95%\">
    <tr>";
	for($i=0;$field_names[$i];$i++) {
		print "<td style=\"font-weight:bold;";
		if($field_size[$i]!="*"){
			print "width:".$field_size[$i]."px;";
		}
		print "\">".$field_names[$i]."</td>\n";
	}
	print "</tr>\n";
  for($i=0;list($id,$firma)=mysql_fetch_array($query);$i++) {
		if(($i%2)==0){
      $bgcolor=$_config_tbl_bgcolor1;
    } else {
      $bgcolor=$_config_tbl_bgcolor2;
    }
    print "<tr onmouseover=\"setPointer(this, 'over', '#$bgcolor', '#$_config_tbl_bghover', '')\" onmouseout=\"setPointer(this, 'out', '#$bgcolor', '#$_config_tbl_bghover', '')\" onclick=\"javascript:setValue('$id');\">
			<td valign=top bgcolor=\"#$bgcolor\">$firma</td>";

		print "</tr>\n";
	}
  print "<tr>
    <td colspan=2 align=center>";
  if($start>0){
    print "<a href=\"" . $_SERVER["PHP_SELF"] . "?start=".($start-$_config_entrysperpage)."$attr\"><<<</a>";
  }
	if($term){
	  $query=mysql_query("SELECT count(*) FROM Kontakte WHERE aktiv=1 AND ".formatSearchString($term,array("firma","firma2")));
	} else {
		$query=mysql_query("SELECT count(*) FROM Kontakte WHERE aktiv=1");
	}
  if(($start+$_config_entrysperpage+1)<=mysql_result($query,0,0)) {
    if($start>0){
      print " | ";
    }
    print "<a href=\"" . $_SERVER["PHP_SELF"] . "?start=".($start+$_config_entrysperpage)."$attr\">>>></a>";
  }
  print "</td>
    </tr>
		</table>\n";
} else {
	print "Keine Kontakte gefunden";
}
?>

</body>
</html>
