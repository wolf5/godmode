<?
function getKontakteList($formname,$selected,$breite,$text_null)
{
  $query = mysql_query("SELECT id, firma, name, vorname FROM Kontakte WHERE aktiv=1 ORDER BY concat(firma,name)");

  $select="<SELECT NAME=\"$formname\" style=\"width:".$breite."px;\">
<option value=0>$text_null</option>\n";

  while(list($id,$firma,$name,$vorname)=@mysql_fetch_row($query))
  {
    $name_show=formatName($firma,$name,$vorname);

    if($id == $selected)
      $select.="<option value=$id SELECTED>$name_show</option>\n";
    else
      $select.="<option value=$id>$name_show</option>\n";
  }
  $select.="</SELECT>\n";
  return $select;
}
function getAdminList($formname,$selected,$breite,$text_null)
{
  $query = mysql_query("SELECT id, name, vorname FROM Kontakte WHERE aktiv=1 AND admin=1 ORDER BY name");
  
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
function getAnsprechpersonenList($formname,$selected,$breite)
{
  $query=mysql_query("SELECT id,name,vorname FROM Kontakte WHERE admin=1 AND aktiv=1");
  $select = "<SELECT name=\"$formname\" style=\"width:$breite;\">\n";
  while(list($id,$name,$vorname)=mysql_fetch_row($query))
  {
    if($id == $selected)
      $select.="  <option value=\"$id\" SELECTED>$vorname $name</option>\n";
    else
      $select.="  <option value=\"$id\">$vorname $name</option>\n";
  }
  $select.="</SELECT>";
  return $select;
}
function getAnredeList($formname,$selected,$breite)
{
  $query=mysql_query("SELECT id,anrede FROM Kontakte_anreden");
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
function getKontakt($id){
	$query=@mysql_query("SELECT firma,name,vorname FROM Kontakte WHERE id='$id'");
	if($query){
		list($firma,$name,$vorname)=mysql_fetch_row($query);
		return formatName($firma,$name,$vorname);
	} else {
		return false;
	}
}
function getKontaktFirma($id){
  $query=@mysql_query("SELECT firma FROM Kontakte WHERE id='$id'");
	if($query && mysql_num_rows($query)>0){
	  return @mysql_result($query,0,0);
	} else {
		return false;
	}
}
function getKontaktName($id){
  $query=@mysql_query("SELECT name FROM Kontakte WHERE id='$id'");
	if($query && mysql_num_rows($query)>0) {
	  return mysql_result($query,0,0);
	} else {
		return false;
	}
}
function getKontaktVorname($id){
  $query=@mysql_query("SELECT vorname FROM Kontakte WHERE id='$id'");
	if($query && mysql_num_rows($query)>0) {
	  return mysql_result($query,0,0);
	} else {
		return false;
	}
}

function getAnrede($id){
	$query=@mysql_query("SELECT anrede FROM Kontakte_anreden WHERE id='$id'");
  if($query && mysql_num_rows($query)>0) {
    return mysql_result($query,0,0);
  } else {
    return false;
  }
}
?>
