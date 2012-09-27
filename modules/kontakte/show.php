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
<p class=titel>Kontakte</p>
<?
if(!$term || $search_kontaktpersonen) {
	$search_kontaktpersonen_checked="CHECKED";
}
?>
<form method=get action="<?=$PHP_SELF?>">
<input type=text name=term id=term value="<?=$term?>">
<input type=submit name=search value="Suchen"><br>
</form>
<?
$field_names=split(",",$_config_kontakte_show_fields_name);
$fields=split(",",$_config_kontakte_show_fields);
$field_size=split(",",$_config_kontakte_show_field_size);
$qryStr="kon.id";
for($i=0;$fields[$i];$i++){
	if($fields[$i]=="domains"){
		$specialfields[]=$fields[$i];
	} else if($fields[$i]=="kontakt"){
		//do nothing
	} else if($fields[$i]=="fullname"){
		//do nothing
	} else {
		$qryStr.=",kon.".$fields[$i];
	}
}
		
if(!$start){
  $start=0;
}
if($term){
	$query=mysql_query("SELECT $qryStr FROM Kontakte kon WHERE aktiv=1 AND ".formatSearchString($term,array("id","firma","firma2","text","adresse","adresse2","ort"))." ORDER BY firma LIMIT $start,$_config_entrysperpage");
	$attr="&term=$term";
} else {
	$query=mysql_query("SELECT $qryStr FROM Kontakte kon WHERE aktiv=1 ORDER BY firma LIMIT $start,$_config_entrysperpage");
}
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
  for($i=0;$result=mysql_fetch_array($query);$i++) {
		$id=$result[0];
		if(($i%2)==0){
      $bgcolor=$_config_tbl_bgcolor1;
    } else {
      $bgcolor=$_config_tbl_bgcolor2;
    }
    print "<tr onmouseover=\"setPointer(this, 'over', '#$bgcolor', '#$_config_tbl_bghover', '')\" onmouseout=\"setPointer(this, 'out', '#$bgcolor', '#$_config_tbl_bghover', '')\" onclick=\"location.href='kontakt.php?id=$id&back=".urlencode($REQUEST_URI)."'\">\n";
		for($ii=0;$fields[$ii];$ii++) {
			if($fields[$ii]=="kontakt"){
				print "	<td valign=top bgcolor=\"#$bgcolor\"$style>".getKontakt($id)."</td>\n";
      } else if($fields[$ii]=="domains"){
        print " <td valign=top bgcolor=\"#$bgcolor\"$style>\n";
				$query2=mysql_query("SELECT id,domain FROM Domains WHERE kontakt='$id' AND endDate is NULL");
				if(!($error=mysql_error())) {
					for($iii=0;list($domain_id,$domain)=mysql_fetch_row($query2);$iii++) {
						if($iii>0){
							echo ", ";
						}
						echo "<a href=\"../../modules/domains/domain.php?id=$domain_id&back=".urlencode($REQUEST_URI)."\">$domain</a>";
		      } 
				} else {
					print "<b>Fehler:</b> $error";
				}
  	    print"</td>\n";
			} else {
				print " <td valign=top bgcolor=\"#$bgcolor\"$style>".$result[$fields[$ii]]."</td>\n";
			}

    }

		print "</tr>\n";
	}
  print "<tr>
    <td colspan=2 align=center>";
  if($start>0){
    print "<a href=\"$PHP_SELF?start=".($start-$_config_entrysperpage)."$attr\"><<<</a>";
  }
	if($term){
	  $query=mysql_query("SELECT count(*) FROM Kontakte WHERE aktiv=1 AND ".formatSearchString($term,array("id","firma","firma2","text")));
	} else {
		$query=mysql_query("SELECT count(*) FROM Kontakte WHERE aktiv=1");
	}
  if(($start+$_config_entrysperpage+1)<=mysql_result($query,0,0)) {
    if($start>0){
      print " | ";
    }
    print "<a href=\"$PHP_SELF?start=".($start+$_config_entrysperpage)."$attr\">>>></a>";
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
