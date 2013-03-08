<?php 
include("../../inc/config.inc.php");
  
include("../../inc/func.inc.php");
?>
<html>
<head>
  <title><?php echo $_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
	<script src="../../inc/functions.js" type="text/javascript" language="javascript"></script>
	<script  type="text/javascript" language="javascript">
	<!--
		function setValue(val){
			opener.document.getElementsByName('produkt[<?php=$field?>]')[0].value = val;
			self.close();
		}
	//-->
	</script>
</head>
<body onLoad="document.getElementById('term').focus()">
<p class=titel>Produkt Suchen</p>

<form method=get action="<?php=$PHP_SELF?>">
<input type=hidden name=field value=<?php=$field?>>
<input type=text name=term id=term value="<?php=$term?>">
<input type=submit name=search value="Suchen">
</form>
<?php
$_config_entrysperpage=10;
if(!$start){
  $start=0;
}
if($term){
	$query=mysql_query("SELECT nr_int,text1 FROM Produkte WHERE ".formatSearchString($term,array("nr_int","nr_ext","text1","text2"))." ORDER BY text1 LIMIT $start,$_config_entrysperpage");
	$attr="&term=$term";
} else {
	$query=mysql_query("SELECT nr_int,text1 FROM Produkte ORDER BY text1 LIMIT $start,$_config_entrysperpage");
}
if(@mysql_num_rows($query)>0)
{
  print "<table border=0 cellpadding=3 cellspacing=0 width=\"95%\">";
  for($i=0;list($nr_int,$text1)=mysql_fetch_array($query);$i++) {
		if(($i%2)==0){
      $bgcolor=$_config_tbl_bgcolor1;
    } else {
      $bgcolor=$_config_tbl_bgcolor2;
    }
    print "<tr onmouseover=\"setPointer(this, 'over', '#$bgcolor', '#$_config_tbl_bghover', '')\" onmouseout=\"setPointer(this, 'out', '#$bgcolor', '#$_config_tbl_bghover', '')\" onclick=\"javascript:setValue('$nr_int');\">
			<td valign=top bgcolor=\"#$bgcolor\"$style>$text1</td>";

		print "</tr>\n";
	}
  print "<tr>
    <td colspan=2 align=center>";
  if($start>0){
    print "<a href=\"$PHP_SELF?field=$field&start=".($start-$_config_entrysperpage)."$attr\"><<<</a>";
  }
	if($term){
	  $query=mysql_query("SELECT count(*) FROM Kontakte WHERE aktiv=1 AND ".formatSearchString($term,array("firma","firma2",)));
	} else {
		$query=mysql_query("SELECT count(*) FROM Kontakte WHERE aktiv=1");
	}
  if(($start+$_config_entrysperpage+1)<=mysql_result($query,0,0)) {
    if($start>0){
      print " | ";
    }
    print "<a href=\"$PHP_SELF?field=$field&start=".($start+$_config_entrysperpage)."$attr\">>>></a>";
  }
  print "</td>
    </tr>
		</table>\n";
} else {
	print "Kein Produkte gefunden";
}
?>

</body>
</html>
