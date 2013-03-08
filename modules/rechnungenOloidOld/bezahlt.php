<?php 
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
			$query=mysql_query("SELECT betreff,waehrung,fx,fx1 FROM Rechnungen WHERE id='$id'",$conn);
      list($text,$waehrung,$fx,$fx1)=mysql_fetch_row($query);
			$query=mysql_query("SELECT sum(betrag*fx) FROM Rechnungen_positionen WHERE rechnung='$id'",$conn);
      $betrag=mysql_result($query,0,0);
			$kursdifferenz = ($fx-$fx1)*$betrag;
			$buhadb = mysql_connect($_config_mysql_buchhaltung_host,$_config_mysql_buchhaltung_user,$_config_mysql_buchhaltung_password);
			mysql_select_db($_config_mysql_buchhaltung_db,$buhadb);
		}
		if($_config_bezahlte_rechnungen_buchen) {
			$query=mysql_query("INSERT INTO Queue(datum,beschreibung,kt_haben,kt_soll,betrag,waehrung,kurs,mwst,mwst_feld,belegnr) VALUES('".date_CH_to_EN($datum)."','$text','$_config_bezahlte_rechnungen_haben','$_config_bezahlte_rechnungen_soll','$betrag','$waehrung','$fx','0',NULL,'Godmode Import')",$buhadb);
			$error=mysql_error();
		}
		if($_config_kursveraenderungen_buchen) {
			if($fx != $fx1) {
				$query=mysql_query("INSERT INTO Queue(datum,beschreibung,kt_haben,kt_soll,betrag,waehrung,kurs,mwst,mwst_feld,belegnr,no_ask) VALUES('".date_CH_to_EN($datum)."','Kursveränderungen: $text','$_config_kursveraenderungen_haben','$_config_kursveraenderungen_soll','$kursdifferenz','1','1','0',NULL,'Godmode Import','1')",$buhadb);
	      $error=mysql_error();
			}
		}
		if(!$error) {
			header("Location: $back");
		}	
	}
}
?>
<html>
<head>
  <title><?php echo $_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body>
<p class=titel>Rechnungen:Rechnung als Bezahlt Markieren</p>
<?php
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
