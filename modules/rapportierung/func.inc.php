<?php
function getRapportCodeList($formname,$projekt,$selected,$breite,$text_null) {
  $query = mysql_query("SELECT code, name FROM Rapportierung_code WHERE projekt='$projekt' ORDER BY name");
	echo mysql_error();

  $select="<SELECT ID=\"$formname\" NAME=\"$formname\" style=\"width:".$breite."px;\">
		<option value=0>$text_null</option>\n";
  while(list($code,$name)=@mysql_fetch_row($query)) {
    if($code == $selected)
      $select.="<option value=$code SELECTED>$name</option>\n";
    else
      $select.="<option value=$code>$name</option>\n";
  }
  $select.="</SELECT>\n";
  return $select;
}
?>
