<?
print "<table border=0 cellpadding=0 cellspacing=0>
      <tr>
        <td colspan=2><b>Kontaktmöglichkeiten</b></td>
      </tr>
       <tr>
         <td width=100>Telefon</td>
         <td><input type=text name=\"kontakt_telefon1\" value=\"".$kontakt['telefon1']."\" style=\"width:200px;\" maxlength=20></td>
       </tr>
         <td width=100>Telefon</td>
         <td><input type=text name=\"kontakt_telefon2\" value=\"".$kontakt['telefon2']."\" style=\"width:200px;\" maxlength=20></td>
       </tr>
       <tr>
         <td width=100>Mobile</td>
         <td><input type=text name=\"kontakt_mobile\" value=\"".$kontakt['mobile']."\" style=\"width:200px;\" maxlength=20></td>
       </tr>
       <tr>
         <td width=100>Fax</td>
         <td><input type=text name=\"kontakt_fax\" value=\"".$kontakt['fax']."\" style=\"width:200px;\" maxlength=20></td>
       </tr>
       <tr>
         <td width=100><a href=\"mailto:".$kontakt['mail']."\">E-Mail</a></td>
         <td><input type=text name=\"kontakt_mail\" value=\"".$kontakt['mail']."\" style=\"width:200px;\" maxlength=50></td>
       </tr>
       <tr>
         <td width=100><a href=\"".$kontakt['www']."\" target=\"_blank\">WWW</a></td>
         <td><input type=text name=\"kontakt_www\" value=\"".$kontakt['www']."\" style=\"width:200px;\" maxlength=50></td>
       </tr>
       </table>";

?>
