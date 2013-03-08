<?php 
include("../../inc/config.inc.php"); 
include("../../inc/func.inc.php");

?>
<html><head><title><?php echo $_config_title?></title><link rel="stylesheet" href="../../main.css" type=text/css><script src="../../inc/functions.js" type="text/javascript" language="javascript"></script></head><body onLoad="document.getElementById('term').focus()"><p class=titel>Kontakte</p>
<?php

$term = isset($_GET["term"]) ? $_GET["term"] : NULL; 

if($term || isset($search_kontaktpersonen)) {
	$search_kontaktpersonen_checked="CHECKED";
}
?>
<form method=get action="<?php echo $_SERVER['PHP_SELF'];?>"> <input type=text name=term id=term value="<?php echo $term ?>"> <input type=submit name=search value="Suchen"><br></form>
<?php
$field_names=explode(",",$_config_kontakte_show_fields_name);
$fields=explode(",",$_config_kontakte_show_fields);
$field_size=explode(",",$_config_kontakte_show_field_size);
$qryStr="kon.id";
foreach($fields as $field_value){
	if($field_value=="domains"){
		$specialfields[]=$field_value;
	} else if($field_value=="kontakt"){
		//do nothing
	} else if($field_value=="fullname"){
		//do nothing
	} else {
		$qryStr.=",kon.".$field_value;
	}
}
		
if(!isset($start)){
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
	foreach($field_names as $field_name_value) {
		print "<td style=\"font-weight:bold;";
		if($field_name_value!="*"){
			print "width:".$field_name_value."px;";
		}
		print "\">".$field_name_value."</td>\n";
	}
	print "</tr>\n";
  for($i=0;$result=mysql_fetch_array($query);$i++) {
		$id=$result[0];
		if(($i%2)==0){
      $bgcolor=$_config_tbl_bgcolor1;
    } else {
      $bgcolor=$_config_tbl_bgcolor2;
    }
    print "<tr onmouseover=\"setPointer(this, 'over', '#$bgcolor', '#$_config_tbl_bghover', '')\" onmouseout=\"setPointer(this, 'out', '#$bgcolor', '#$_config_tbl_bghover', '')\" onclick=\"location.href='kontakt.php?id=$id&back=".urlencode($_SERVER['REQUEST_URI'])."'\">\n";
		foreach($fields as $field_value) {
			if($field_value=="kontakt"){
				print "	<td valign=top bgcolor=\"#$bgcolor\">".getKontakt($id)."</td>\n";
      } else if($field_value=="domains"){
        print " <td valign=top bgcolor=\"#$bgcolor\">\n";
				$query2=mysql_query("SELECT id,domain FROM Domains WHERE kontakt='$id' AND endDate is NULL");
				if(!($error=mysql_error())) {
					for($iii=0;list($domain_id,$domain)=mysql_fetch_row($query2);$iii++) {
						if($iii>0){
							echo ", ";
						}
						echo "<a href=\"../../modules/domains/domain.php?id=$domain_id&back=".urlencode($_SERVER['REQUEST_URI'])."\">$domain</a>";
		      } 
				} else {
					print "<b>Fehler:</b> $error";
				}
  	    print"</td>\n";
			} else {
				print " <td valign=top bgcolor=\"#$bgcolor\">".$result[$field_value]."</td>\n";
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
</body></html>