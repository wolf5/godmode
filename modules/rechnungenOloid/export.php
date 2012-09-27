<? 
include("../../inc/config.inc.php");
include("../../inc/func.inc.php");

if(!$back){
	$back="offene.php";
}
if(!$backno){
	$backno=$back;
}
function kontoExistiert($nr) {
	global $buchhaltung,$_config_mysql_buchhaltung_db;
	mysql_select_db($_config_mysql_buchhaltung_db);
	$query=mysql_query("SELECT count(*) FROM $buchhaltung"."_Konto WHERE nr='$nr'");
	return mysql_result($query,0,0);
}
function createKonto($nr,$kontakt,$typ) {
	global $buchhaltung,$_config_mysql_buchhaltung_db;
  mysql_select_db($_config_mysql_buchhaltung_db);
	
	$query=mysql_query("SELECT max(sort) FROM $buchhaltung"."_Konto");
  $sort=@mysql_result($query,0,0)+1;
	$query=mysql_query("SELECT id FROM $buchhaltung"."_Nebenkonto WHERE name='Debitoren'");
	$nebenkonto=@mysql_result($query,0,0);
	$query=mysql_query("INSERT INTO $buchhaltung"."_Konto(nr,name,nebenkonto,typ,waehrung,show_waehrung,show_belegnr,show_mwst,show_datum,sort) Values('$nr','$kontakt','$nebenkonto','$typ',1,1,1,1,1,'$sort')");
	return (strlen(mysql_error()==0));
}	

if($submit) {
	$query=mysql_query("SELECT rech.id,rech.datum,sum((pos.betrag*pos.anzahl)*pos.fx),mwst,rech.kontakt,rech.waehrung,rech.fx,kon.firma FROM Rechnungen rech,Rechnungen_positionen pos,Kontakte kon WHERE kon.id=rech.kontakt AND rech.id = pos.rechnung AND rech.fixiert=0 AND rech.bezahlt IS NULL GROUP BY rech.id");
	if(mysql_num_rows($query)>0) {
		while((list($id,$datum,$betrag,$mwst,$kontakt,$waehrung,$fx,$firma)=mysql_fetch_row($query)) && !$error) {
			mysql_select_db($_config_mysql_db);
			$kt_soll=str_replace("%KONTAKT%",$kontakt,$_config_export_rechnungen_soll);
			$kt_haben=str_replace("%KONTAKT%",$kontakt,$_config_export_rechnungen_haben);
			$kontakt_txt=getKontakt($kontakt);
			$query2=mysql_query("UPDATE Rechnungen SET fixiert='1' WHERE id='$id'");
		
			//MWSt.-Satz berechnen
      $query2=mysql_query("SELECT sum($_config_posbetrag) FROM Rechnungen_positionen pos WHERE pos.rechnung='$id'");
      $betragMwst=mysql_result($query2,0,0);
      if($betragMwst == $betrag) {
        $mwst = 0;
      } else {
        $mwst = (($betragMwst / $betrag)-1)*100;
      }
			
      mysql_select_db($_config_mysql_buchhaltung_db);
			
			$query2=mysql_query("SELECT id FROM Buchhaltungen WHERE selected=1");
			$buchhaltung=mysql_result($query2,0,0);

      if(!kontoExistiert($kt_soll)) {
        createKonto($kt_soll,$kontakt_txt,1);
      }
      if(!kontoExistiert($kt_haben)) {
        createKonto($kt_haben,$kontakt_txt,2);
      }
			$query3=mysql_query("INSERT INTO Queue(datum,beschreibung,kt_haben,kt_soll,betrag,waehrung,kurs,mwst,mwst_feld,belegnr) VALUES('$datum','Debit: $id, $firma','$kt_haben','$kt_soll','$betrag','$waehrung','$fx','$mwst',NULL,'I".str_pad($id,5,"0",STR_PAD_LEFT)."')");
			$error=mysql_error();
			mysql_select_db($_config_mysql_db);
		}
		if(!$error) {
			header("Location: $back");
		}	
	}
}
?>
<html>
<head>
  <title><?=$_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body>
<p class=titel>Rechnungen:Rechnungen Exportieren</p>
<?
if($err) {
	print "<b>Fehler:</b> $err";
}
$query=mysql_query("SELECT rech.id, rech.text,sum($_config_posbetrag),rech.kontakt FROM Rechnungen rech,Rechnungen_positionen pos WHERE rech.id = pos.rechnung AND rech.fixiert=0 AND rech.bezahlt IS NULL GROUP BY rech.id");
if(mysql_error()) {
	print "<b>Fehler:</b> ".mysql_error();
} else if(@mysql_num_rows($query)<1) {
	print "<b>Fehler</b>: Keine Rechnungen zum Exportieren<br><br>\n";
} else {
	print "Folgende Rechnungen werden Exportiert:<br><br>
		<table border=0>
		<tr>
			<td><b>Kontakt</b></td>
			<td><b>Betreff</b></td>
			<td><b>Betrag</b></td>
		</tr>";
	while(list($id,$text,$betrag,$kontakt)=mysql_fetch_row($query)) {
		print "<tr>
			<td>".getKontakt($kontakt)."</td>
			<td>$betreff</td>
			<td>".formatBetrag($betrag)."</td>
		</tr>";
	}
	print "</table>
		<form method=post value=\"$PHP_SELF?id=$id&back=".urlencode($back)."\">
		<input type=submit name=submit value=\"Ausführen\"> <input type=button value=\"Zurück\" onclick=\"javascript:location.href='$backno'\">
		</form>";		
}
?>
</body>
</html>
