<?
if($updated=="00.00.0000") {
	$updated="-";
}
if($id != 0) {
	print "<table border=0 cellpadding=0 cellspacing=0 width=300>
			 <tr>
					<td width=100>Adressnummer:</td>
					<td>".$kontakt['id']."</td>
			 </tr>
       <tr>
         <td width=100>Erfasst:</td>
         <td>".$kontakt['erfasst']."</td>
       </tr>
         <td width=100>Updated:</td>
         <td>".$kontakt['updated']."</td>
       </tr>
       </table>";
	if(isModule("domains")) {
		include("domains.inc.php");
	}
}
?>
