<?
print "<table width=300 cellpadding=0 cellspacing=0>
<tr>
	<td width=100 valign=top>Domains:</td>
	<td>";
$query=mysql_query("SELECT id,domain FROM Domains WHERE kontakt='".$kontakt['id']."'");
for($i=0;list($dom_id,$domain)=mysql_fetch_row($query);$i++) {
	if($i>0) {
		print ", ";
	}
	print "<a href=\"../domains/domain.php?id=$dom_id&back=".urlencode($REQUEST_URI)."\">$domain</a>";
}
print"	</td>
</tr>
</table";
?>
