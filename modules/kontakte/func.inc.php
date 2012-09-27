<?
function getKontakteList($formname,$selected,$breite,$text_null)
{
  $query = mysql_query("SELECT id, firma, firma2 FROM Kontakte WHERE aktiv=1 ORDER BY firma");

  $select="<SELECT ID=\"$formname\" NAME=\"$formname\" style=\"width:".$breite."px;\">
<option value=0>$text_null</option>\n";

  while(list($id,$firma,$firma2)=@mysql_fetch_row($query))
  {
		if($firma2) {
			$firma.=", ".$firma2;
		}
		if(strlen($firma)>100) {
			$firma=substr($firma,0,100)."...";
		}
    if($id == $selected)
      $select.="<option value=$id SELECTED>$firma</option>\n";
    else
      $select.="<option value=$id>$firma</option>\n";
  }
  $select.="</SELECT>\n";
  return $select;
}
function getEmpList($formname,$selected,$breite,$text_null) {
	global $_config_kontakte_me;
  $query = mysql_query("SELECT id, name, vorname FROM Kontakte_kontaktpersonen WHERE firma='$_config_kontakte_me' ORDER BY name");
  $select="<SELECT NAME=\"$formname\" style=\"width:".$breite."px;\">
		<option value=0>$text_null</option>\n";
  while(list($id,$name,$vorname)=@mysql_fetch_row($query))
  {
    $name_show=formatName("",$name,$vorname);
    if($id == $selected)
      $select.="<option value=$id SELECTED>$name_show</option>\n";
    else
      $select.="<option value=$id>$name_show</option>\n";
  }
  $select.="</SELECT>\n";
  return $select;
}
function getEmp($id) {
  $query = mysql_query("SELECT name, vorname FROM Kontakte_kontaktpersonen WHERE id='$id'");
	list($name,$vorname)=mysql_fetch_row($query);
	return trim("$vorname $name");
}

function getKontaktpersonenList($formname,$selected,$breite,$text_null,$firma) {
  $query = mysql_query("SELECT id, name, vorname FROM Kontakte_kontaktpersonen WHERE firma='$firma' ORDER BY name");
  $select="<SELECT NAME=\"$formname\" style=\"width:".$breite."px;\">
    <option value=0>$text_null</option>\n";
  while(list($id,$name,$vorname)=@mysql_fetch_row($query))
  {
    $name_show=formatName("",$name,$vorname);
    if($id == $selected)
      $select.="<option value=$id SELECTED>$name_show</option>\n";
    else
      $select.="<option value=$id>$name_show</option>\n";
  }
  $select.="</SELECT>\n";
  return $select;
}
function getAnredeList($formname,$selected,$breite)
{
  $query=mysql_query("SELECT id,anrede FROM Kontakte_anreden ORDER BY id");
  $select = "<SELECT name=\"$formname\" style=\"width:$breite"."px;\">\n";
  while(list($id,$anrede)=mysql_fetch_row($query))
  {
    if($id == $selected)
      $select.="  <option value=\"$id\" SELECTED>$anrede</option>\n";
    else
      $select.="  <option value=\"$id\">$anrede</option>\n";
  }
  $select.="</SELECT>\n";
  return $select;
}
function getAnrede($id){
  $query=@mysql_query("SELECT anrede FROM Kontakte_anreden WHERE id='$id'");
  if($query && mysql_num_rows($query)>0) {
    return mysql_result($query,0,0);
  } else {
    return false;
  }
}
function getKontakt($id){
	$query=@mysql_query("SELECT anrede,firma,firma2 FROM Kontakte WHERE id='$id'");
	if(mysql_num_rows($query)>0){
		list($anrede,$firma,$firma2)=mysql_fetch_row($query);
		if($anrede==3) {
			/*if($firma2) {
	      $firma.=", ".$firma2;
  	  }*/
	    if(strlen($firma)>100) {
	      $firma=substr($firma,0,100)."...";
	    }
			return $firma;
		} else {
			return "$firma2 $firma";
		}
	} else {
		return false;
	}
}
function isPrivate($id) {
	$query=mysql_query("SELECT anr.privat FROM Kontakte_anreden anr, Kontakte kont WHERE kont.anrede = anr.id AND kont.id='$id'");
	if(mysql_num_rows($query)>0) {
		return mysql_result($query,0,0);
	} else {
		return false;
	}
}
function anredeIsPrivate($id) {
  $query=mysql_query("SELECT privat FROM Kontakte_anreden WHERE id='$id'");
  if(mysql_num_rows($query)>0) {
    return mysql_result($query,0,0);
  } else {
    return false;
  }
}

?>
