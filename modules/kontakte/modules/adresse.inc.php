<?
	if(anredeIsPrivate($kontakt['anrede'])) {
		$text_text1="Name";
		$text_text2="Vorname";
	} else {			 
		$text_text1="Firma";
		$text_text2="Zusatz";
	}
	print "<table border=0 cellpadding=0 cellspacing=0>
      <tr>
        <td colspan=2><b>Adresse</b></td>
      </tr>
      <tr>
        <td width=100>Anrede</td>
        <td>
					<SELECT name=kontakt_anrede onChange=\"javascript:changeAnrede(this.value)\" style=\"width:200px\">";
						$query=mysql_query("SELECT id,anrede FROM Kontakte_anreden");
					  while(list($anrede_id,$anrede_text)=mysql_fetch_row($query)) {
				    	if($anrede_id == $kontakt['anrede'])
					      print "  <option value=\"$anrede_id\" SELECTED>$anrede_text</option>\n";
					    else
					      print "  <option value=\"$anrede_id\">$anrede_text</option>\n";
					  }
	print"	</SELECT>
				</td>
      </tr>
      <tr>
        <td width=100>$text_text1</td>
        <td><input type=text id=\"firma\" name=\"kontakt_firma\" value=\"".$kontakt['firma']."\" style=\"width:200px;\" maxlength=50></td>
      </tr>
      <tr>
        <td width=100>$text_text2</td>
        <td><input type=text name=\"kontakt_firma2\" value=\"".$kontakt['firma2']."\" style=\"width:200px;\" maxlength=50></td>
      </tr>
      <tr>
        <td width=100>Adresse</td>
        <td><input type=text name=\"kontakt_adresse\" value=\"".$kontakt['adresse']."\" style=\"width:200px;\" maxlength=50></td>
      </tr>
      <tr>
        <td width=100>Adresse 2</td>
        <td><input type=text name=\"kontakt_adresse2\" value=\"".$kontakt['adresse2']."\" style=\"width:200px;\" maxlength=50></td>
        </tr>
      <tr>
        <td width=100>PLZ / Ort</td>
        <td><input type=text name=\"kontakt_plz\" value=\"".$kontakt['plz']."\" style=\"width:45px;\" maxlength=10> <input type=text name=\"kontakt_ort\" value=\"".$kontakt['ort']."\" style=\"width:150px;\" maxlength=50></td>
      </tr>
        <td width=100>Land</td>
        <td><input type=text name=\"kontakt_land\" value=\"".$kontakt['land']."\" style=\"width:200px;\" maxlength=20></td>
      </tr>
      </table>";
?>
