<? 
include("../../inc/config.inc.php");
  
include("../../inc/func.inc.php");
if(!$back){
	$back="offene.php";
}
if(!$backno){
	$backno=$back;
}
if($submit) {
	$query=mysql_query("SELECT waehrung FROM Rechnungen WHERE id='$id'");
	$waehrung=mysql_result($query,0,0);
	$fx1 = getFx($waehrung,1);
  $query=mysql_query("UPDATE Rechnungen SET bezahlt='".date_CH_to_EN($datum)."',fx1='$fx1' WHERE id='$id'");
	if(!($error=mysql_error())) {
	  //Gutschriften
/*		if(isModule("domains")) {
			$query=mysql_query("SELECT Rechnungen_positionen.id FROM Rechnungen_positionen,Rechnungen WHERE Rechnungen.id = '$id' AND Rechnungen_positionen.rechnung = Rechnungen.id");
			while(list($pos_id)=mysql_fetch_row($query)) {
			  $query2=mysql_query("UPDATE Rechnungen_gutschriften SET auszahlen=1 WHERE abhaengig='$pos_id'");
			}
		}*/
		//Schnitstellen Buha
		if($_config_bezahlte_rechnungen_buchen || $_config_kursveraenderungen_buchen) {
			$query=mysql_query("SELECT betreff,bezahlt,waehrung,fx,fx1,kontakt FROM Rechnungen WHERE id='$id'");
      list($text,$datum,$waehrung,$fx,$fx1,$kontakt)=mysql_fetch_row($query);
			$kt_soll=str_replace("%KONTAKT%",$kontakt,$_config_bezahlte_rechnungen_soll);
  	  $kt_haben=str_replace("%KONTAKT%",$kontakt,$_config_bezahlte_rechnungen_haben);
	    $kontakt_txt=getKontakt($kontakt);
			
			$query=mysql_query("SELECT sum(((betrag*fx)+(((betrag*fx)/100)*mwst))*anzahl) FROM Rechnungen_positionen WHERE rechnung='$id'");
      $betrag=mysql_result($query,0,0);
			$kursdifferenz = ($fx-$fx1)*$betrag;
			mysql_select_db($_config_mysql_buchhaltung_db);
		}
		if($_config_bezahlte_rechnungen_buchen) {
			$query=mysql_query("INSERT INTO Queue(datum,beschreibung,kt_haben,kt_soll,betrag,waehrung,kurs,mwst,mwst_feld,belegnr) VALUES('".date_CH_to_EN($datum)."','Dbz; $kontakt_txt; $text; RG-Dat: $datum; RG-N: $id','$kt_haben','$kt_soll','$betrag','$waehrung','$fx','0',NULL,'b".str_pad($id,5,"0",STR_PAD_LEFT)."')");
			$error=mysql_error();
		}
		/*
		if($_config_kursveraenderungen_buchen) {
			if($fx != $fx1) {
				$query=mysql_query("INSERT INTO Queue(datum,beschreibung,kt_haben,kt_soll,betrag,waehrung,kurs,mwst,mwst_feld,belegnr,no_ask) VALUES('".date_CH_to_EN($datum)."','Kursveränderungen: $text','$_config_kursveraenderungen_haben','$_config_kursveraenderungen_soll','$kursdifferenz','1','1','0',NULL,'Godmode Import','1')");
	      $error=mysql_error();
			}
		}
		*/
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
<p class=titel>Rechnungen:Rechnung als Bezahlt Markieren</p>
<?
if($err) {
	print "<b>Fehler:</b> $err";
}
$query=mysql_query("SELECT text, betrag FROM Rechnungen_positionen WHERE rechnung='$id'");
if(@mysql_num_rows($query)<1) {
	print "<b>Fehler</b>: Rechnung hat keine Positionen<br><br>\n";
} else {
	print "<form method=post value=\"$PHP_SELF?id=$id&back=".urlencode($back)."\">
		Datum : <input type=text name=datum value=\"".date("d.m.Y")."\"><br><br>
		<input type=submit name=submit value=\"Ausführen\"> <input type=button value=\"Zurück\" onclick=\"javascript:location.href='$backno'\">
		</form>";		
}
?>
</body>
</html>
