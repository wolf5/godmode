<?php 
include("../../inc/config.inc.php");
  
include("../../inc/func.inc.php");

	//EInnahmen pro Jahr
	$query=mysql_query("SELECT sum(dom.betrag*abr.raten) FROM Domains dom, Zahlungsarten abr WHERE dom.abrechnungsart = abr.id");
	list($gesamteinnahmen)=mysql_fetch_row($query);
	echo mysql_error();

	//Verrechnete Beträge
	$query=mysql_query("select sum(betrag) FROM Rechnungen_positionen");
	list($verrechneteBetraege)=mysql_fetch_row($query);
	
	//Eingenommene Beträge
	$query=mysql_query("select sum(pos.betrag) FROM Rechnungen_positionen pos, Rechnungen rech WHERE rech.id = pos.rechnung AND rech.bezahlt is NOT NULL");
	list($bisherigeEinnahmen)=mysql_fetch_row($query);

	
?>

<html>
<head>
  <title>Sylon godmode</title>
  <link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body>
<p class=titel>Rechnungen:Statistiken</p>
<table border=0>
<tr>
	<td width=250>Gesamteinnahmen Domains pro Jahr</td>
	<td align=right><?php print formatBetrag($gesamteinnahmen); ?></td>
</tr>
<tr>
	<td width=250>Einnahmen - Hostingkosten</td>
	<td align=right><?php=formatBetrag($gesamteinnahmen-4519.2)?></td>
</tr>
<tr>
	<td width=250>Verrechnete Beträge</td>
	<td align=right><?php print formatBetrag($verrechneteBetraege); ?>	</td>
</tr>
<tr>
	<td width=250>Bezahlte Beträge</td>
	<td align=right><?php print formatBetrag($bisherigeEinnahmen); ?></td>
</tr>
</table>
</body>
</html>
