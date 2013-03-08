<?php
print "<table border=0 cellpadding=0 cellspacing=0>
      <tr>
        <td colspan=2><b>Kontoinformationen</b></td>
      </tr>
      <tr>
        <td width=100>Konto</td>
        <td><input type=text name=\"kontakt_konto\" value=\"".$_SESSION["kontakt"]['konto']."\" style=\"width:200px;\" maxlength=50></td>
      </tr>
      <tr>
        <td width=100>Konto Nr.</td>
        <td><input type=text name=\"kontakt_kontonr\" value=\"".$_SESSION["kontakt"]['kontonr']."\" style=\"width:200px;\" maxlength=50></td>
      </tr>
      <tr>
        <td width=100>BLZ</td>
        <td><input type=text name=\"kontakt_blz\" value=\"".$_SESSION["kontakt"]['blz']."\" style=\"width:200px;\" maxlength=50></td>
      </tr>
      <tr>
        <td width=100>Swift</td>
        <td><input type=text name=\"kontakt_swift\" value=\"".$_SESSION["kontakt"]['swift']."\" style=\"width:200px;\" maxlength=50></td>
      </tr>
      <tr>
       <td width=100>Iban</td>
       <td><input type=text name=\"kontakt_iban\" value=\"".$_SESSION["kontakt"]['iban']."\" style=\"width:200px;\" maxlength=50></td>
     </tr>
    </table>";
?>
