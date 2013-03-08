<?php
include("../../inc/config.inc.php");
  
include("../../inc/func.inc.php");
session_start();
if(!$force){
	session_register("pos");
	session_register("gut");
	session_register("positionen");
  session_register("adresse");
  session_register("betreff");
  session_register("datum");
  session_register("text");
  session_register("footer");		
	session_register("id");
	session_register("waehrung");
	session_register("zahlungsfrist");
}
?>
<html>
<head>
	<title><?php echo $_config_title?></title>
  <link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body>
<p class=titel>Rechnungen:Rechnungen erstellen</p>
<?php
//Prüfen ob diese Rechnung schon mal erstellt wurde
$query=mysql_query("SELECT id FROM Rechnungen WHERE kontakt='$id' AND betreff='$betreff' AND datum = NOW()");
if(@mysql_num_rows($query)==0 || $force==1) {
	$query=mysql_query("INSERT INTO Rechnungen(kontakt,waehrung,fx,datum,adresse,betreff,text,footer,zahlungsfrist,besrnr) VALUES('$id','$waehrung','".getFx($waehrung,1)."','".date_CH_to_EN($datum)."','$adresse','$betreff','$text','$footer','$zahlungsfrist','$besrnr')");
	if(!mysql_error()) {
		$last_id=mysql_insert_id();
		if($pos) {
			foreach($pos as $pos_id) {
				$query=mysql_query("SELECT waehrung FROM Rechnungen_positionen WHERE id='$pos_id'");
				$waehrung_pos=mysql_result($query,0,0);
				$fx=getFx($waehrung_pos,$waehrung);
				$query=mysql_query("UPDATE Rechnungen_positionen SET rechnung='$last_id',fx='$fx' WHERE id='$pos_id'");
				if(mysql_error()){
					$error=mysql_error();
				}
			}
		}
		if($gut) {
			foreach($gut as $gut_id) {
				$query=mysql_query("SELECT waehrung FROM Rechnungen_gutschriften WHERE id='$gut_id'");
				$waehrung_pos=mysql_result($query,0,0);
				$fx=getFx($waehrung_pos,$waehrung);
				$query=mysql_query("UPDATE Rechnungen_gutschriften SET bezahlt='$last_id',fx='$fx' WHERE id='$gut_id'");
				if(mysql_error()){
	         $error=mysql_error();
	       }
			}
		}
	} else {
		$error=mysql_error();	
	}
	if($error){
      print "<b>Fehler:</b> $error";
	} else {
		session_unregister("pos");
		session_unregister("gut");
		session_unregister("adresse");
		session_unregister("betreff");
		session_unregister("datum");
		session_unregister("text");
		session_unregister("footer");
		session_unregister("id");
		session_unregister("waehrung");
		
		print "<p>Die Rechnung wurde erfolgreich gespeichert.</p>
		<p>Klicken Sie <a href=\"createPDF.php?id=$last_id\" style=\"text-decoration:underline\">hier</a> für eine Rechnung im PDF-Format und <a href=\"positionen.php\" style=\"text-decoration:underline\">hier</a> um zurückzukehren.";
	}
} else {
	print "<b>Achtung!</b>
eine Rechnung an diesen Kunden mit diesem Betreff wurde heute schon einmal ausgelöst!<br>
Um Rechnungen ein zweites mal auszudrucken, verwenden Sie bitte den Menupunkt <a href=\"rechnungen_offene.php\">Offene Rechnungen</a>.<br><br>
Um die Rechnung ein zweites mal auszulösen, klicken Sie <a href=\"$PHP_SELF?force=1\" style=\"text-decoration:underline\">hier</a>."; 	
}

?>
</body>
</html>
