<?php 
include("../../inc/config.inc.php");
include("../../inc/db.inc.php");  
include("../../inc/func.inc.php");
?>

<html>
<head>
  <title>Sylon godmode</title>
  <link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body>
<p class=titel>Statistiken:Excel Sheets</p>
<br><br>
<?php
$query=mysql_query("select DATE_FORMAT(rech.datum,'$_config_date') as datum, rech.id,rech.kontakt,rech.betreff,sum(pos.betrag) as betrag  FROM Rechnungen rech, Rechnungen_positionen pos WHERE pos.rechnung = rech.id AND rech.bezahlt is NULL GROUP BY rech.id");
if(mysql_num_rows($query)>0){
	$file=fopen("excel/offene_rechnungen.csv","w");
	fputs($file,"Rech. Nr.;Datum;Text;Kontakt;Betrag\n");
	while(list($datum,$id,$kontakt,$text,$betrag)=mysql_fetch_row($query)){
		fputs($file,"$id;$datum;$text;".getKontakt($kontakt).";".formatBetrag($betrag)."\n");
	}
	fclose($file);
}
?>
<a href="excel/offene_rechnungen.csv">Offene Rechnungen</a>
</body>
</html>
