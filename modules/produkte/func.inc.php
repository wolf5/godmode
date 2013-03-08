<?php
function getProdukteList($formname,$selected,$breite,$text_null) {
	global $_config_produkte_show_field_in_select;
  $query = mysql_query("SELECT id,$_config_produkte_show_field_in_box FROM Produkte");
  $select="<SELECT NAME=\"$formname\" style=\"width:".$breite."px;\">
	<option value=0>$text_null</option>\n";

  while(list($id,$field)=@mysql_fetch_row($query))
  {
    if($id == $selected)
      $select.="<option value=$id SELECTED>$field</option>\n";
    else
      $select.="<option value=$id>$field</option>\n";
  }
  $select.="</SELECT>\n";
  return $select;
}
function getPreiseList($formname,$selected,$breite,$text_null) {
	global $_config_produkte_preis1,$_config_produkte_preis1_name,$_config_produkte_preis2,$_config_produkte_preis2_name,$_config_produkte_preis3,$_config_produkte_preis3_name,$_config_produkte_preis4,$_config_produkte_preis4_name;

  $select="<SELECT NAME=\"$formname\" style=\"width:".$breite."px;\">
  <option value=0>$text_null</option>\n";

  for($i=1;$i<=4;$i++) {
		$var="_config_produkte_preis$i";
		if($$var) {
			$var="_config_produkte_preis".$i."_name";
	    if($i == $selected) {
	      $select.="<option value=$i SELECTED>".$$var."</option>\n";
	    } else {
	      $select.="<option value=$i>".$$var."</option>\n";
			}
		}
  }
  $select.="</SELECT>\n";
  return $select;
}

?>
