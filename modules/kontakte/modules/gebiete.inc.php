<?
if(!anredeIsPrivate($kontakt['anrede']) && $id !=0) {
	print "<table border=0 cellpadding=0 cellspacing=0>
      <tr>
        <td colspan=2><b>Gebiete Kontaktpersonen</b></td>
      </tr>";
	if($_config_kontakte_gebiet1) {
		print "<tr>
			<td width=100>$_config_kontakte_gebiet1:</td>
			<td>".getKontaktpersonenList("kontakt_kontakt1",$kontakt['kontakt1'],200,"Bitte Auswählen",$kontakt['id'])."</td>
		</tr>";
	}
	if($_config_kontakte_gebiet2) {
    print "<tr>
      <td width=100>$_config_kontakte_gebiet2:</td>
      <td>".getKontaktpersonenList("kontakt_kontakt2",$kontakt['kontakt2'],200,"Bitte Auswählen",$kontakt['id'])."</td>
    </tr>";
  }
	if($_config_kontakte_gebiet3) {
    print "<tr>
      <td width=100>$_config_kontakte_gebiet3:</td>
      <td>".getKontaktpersonenList("kontakt_kontakt3",$kontakt['kontakt3'],200,"Bitte Auswählen",$kontakt['id'])."</td>
    </tr>";
  }

	print "</table>";
}
?>
