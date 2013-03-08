<?php
include("../../inc/config.inc.php");  
include("../../inc/func.inc.php");

session_start();

$id = isset($_POST["id"]) ? $_POST["id"] : NULL;
$pos = isset($_POST["pos"]) ? $_POST["pos"] : NULL;
$gut = isset($_POST["gut"]) ? $_POST["gut"] : NULL;
$positionen = isset($_POST["positionen"]) ? $_POST["positionen"] : NULL;
$adresse = isset($_POST["adresse"]) ? $_POST["adresse"] : NULL;
$betreff = isset($_POST["betreff"]) ? $_POST["betreff"] : NULL;
$datum = isset($_POST["datum"]) ? $_POST["datum"] : NULL;
$text = isset($_POST["text"]) ? $_POST["text"] : NULL;
$footer = isset($_POST["footer"]) ? $_POST["footer"] : NULL;
$waehrung = isset($_POST["waehrung"]) ? $_POST["waehrung"] : NULL;
$zahlungsfrist = isset($_POST["zahlungsfrist"]) ? $_POST["zahlungsfrist"] : NULL;
$adresse = isset($_POST["adresse"]) ? $_POST["adresse"] : NULL;
$besrnr = isset($_POST["besrnr"]) ? $_POST["besrnr"] : NULL;

?>
<html>
<head>
	<title><?php echo $_config_title?></title>
  <link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body>
<p class=titel>Rechnungen:Rechnungen erstellen</p>
<?php

//Pr�fen ob diese Rechnung schon mal erstellt wurde
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
	if(isset($error)){
      print "<b>Fehler:</b> $error";
	} else {
				
		print "<p>Die Rechnung wurde erfolgreich gespeichert.</p>
		<p>Klicken Sie <a href=\"createPDF.php?id=$last_id\" style=\"text-decoration:underline\">hier</a> f�r eine Rechnung im PDF-Format und <a href=\"offene.php\" style=\"text-decoration:underline\">hier</a> um zu den Offenen Rechnungen zu gelangen.";
	}
} else {
	print "<b>Achtung!</b>
eine Rechnung an diesen Kunden mit diesem Betreff wurde heute schon einmal ausgel�st!<br>
Um Rechnungen ein zweites mal auszudrucken, verwenden Sie bitte den Menupunkt <a href=\"rechnungen_offene.php\">Offene Rechnungen</a>.<br><br>
Um die Rechnung ein zweites mal auszul�sen, klicken Sie <a href=\"" . $_SERVER_["PHP_SELF"] . "?force=1\" style=\"text-decoration:underline\">hier</a>."; 	
}

?>
</body>
</html>
