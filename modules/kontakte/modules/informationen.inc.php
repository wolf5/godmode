<?
	print "     <table border=0 cellpadding=0 cellspacing=0>
      <tr>
        <td colspan=2><b>Informationen</b></td>
      </tr>
      <tr>
        <td width=100>Projektleiter</td>
        <td>".getEmpList("kontakt_pl",$kontakt['pl'],200,"Bitte Auswählen")."</td>
      </tr>
      <tr>
        <td width=100 valign=top>Informationen</td>
        <td><textarea name=\"kontakt_text\" style=\"width:200px;height:100px;\">".$kontakt['text']."</textarea></td>
      </tr>
    </table>";
?>
