<?
include("inc/config.inc.php");
include("inc/db.inc.php");
//Tabellen Löschen
if($sql) {
$query=mysql_query("DELETE FROM Kontakte WHERE id != 1");
$query=mysql_query("DELETE FROM Kontakte_kontaktpersonen WHERE firma!=1");
}
$handle = fopen ("daten_2.txt", "r");
while (!feof($handle)) {
	$buffer = fgets($handle, 4096);
$jee=$buffer;
	$buffer = split(";",str_replace("\"","",str_replace("'","\\'",$buffer)));
	$firma=$buffer[2];
	$anrede = $buffer[14];
	if (!(stristr($anrede,"Sehr geehrte Damen und Herren")===FALSE)) {
    $anrede=3;
  } else if (!(stristr($anrede,"Monsieur le Maire")===FALSE)) {
    $anrede=6;
  } else if (!(stristr($anrede,"Herrn")===FALSE)) {
    $anrede=2;
  } else if (!(stristr($anrede,"Sehr geehrte Frau")===FALSE)) {
    $anrede=2;
  } else if (!(stristr($anrede,"Madame, cher Monsieur")===FALSE)) {
    $anrede=8;
  } else if (!(stristr($anrede,"Monsieur")===FALSE)) {
    $anrede=4;
  } else if (!(stristr($anrede,"Mister")===FALSE)) {
    $anrede=7;
  } else if (!(stristr($anrede,"Liebe")===FALSE)) {
    $anrede=2;
  } else if (!(stristr($anrede,"Lieber")===FALSE)) {
    $anrede=1;
  } else if (!(stristr($anrede,"Mrs.")===FALSE)) {
    $anrede=9;
  } else if (!(stristr($anrede,"Madame")===FALSE)) {
    $anrede=5;
  } else if (!(stristr($anrede,"Mr")===FALSE)) {
    $anrede=7;
  } else if (!(stristr($anrede,"Madam")===FALSE)) {
    $anrede=10;
  } else if (!(stristr($anrede,"Herr")===FALSE)) {
    $anrede=1;
  } else if (!(stristr($anrede,"Miss")===FALSE)) {
    $anrede=11;
  }
	if(!is_numeric($anrede)) {
			$anrede=3;
	}
	$firma=$buffer[2];
	$vorname=$buffer[6];
	$name=$buffer[7];
	$position=$buffer[8];
	$adresse1=$buffer[9];
	$adresse2==$buffer[10];
	$land==$buffer[11];
	$plz==$buffer[12];
	$ort=$buffer[13];
	$telefon1=$buffer[15];
	$tel_direkt=$buffer[16];
	$tel_mobile=$buffer[17];
	$tel_privat=$buffer[18];
	$fax=$buffer[19];
	$email=$buffer[23];
	$text=$buffer[30];
	$www=$buffer[32];
	if($email=="") {
		$email=$buffer[33];
	}
	$blz=$buffer[34];
	$konto=$buffer[35];
	$kundennummer=$buffer[31];
if($sql){
	if(strlen(trim($firma))>0) {
		$query=mysql_query("INSERT INTO Kontakte(erfasst,firma,firma2,adresse,adresse2,plz,ort,land,telefon1,telefon2,mobile,fax,mail,www) VALUES(NOW(),'$firma','$firma2','$adresse','$adresse2','$plz','$ort','$land','$telefon1','',NULL,'$fax','$mail','$www')");
		echo mysql_error();
		$query=mysql_query("INSERT INTO Kontakte_kontaktpersonen(firma,name,vorname,position,adresse,adresse2,plz,ort,tel_privat,tel_gesch,tel_direkt,tel_mobile,fax,mail,mail2,text,anrede) VALUES('".mysql_insert_id()."','$name','$vorname','$position','','','','','$tel_privat','$telefon','$tel_direkt','$tel_mobile','$fax','$email',NULL,'$text','$anrede')");
		echo mysql_error();
	} else if(strlen(trim($name))>0) {
		$query=mysql_query("INSERT INTO Kontakte(erfasst,firma,firma2,adresse,adresse2,plz,ort,land,telefon1,telefon2,mobile,fax,mail,www,anrede) VALUES(NOW(),'$name','$vorname','$adresse','$adresse2','$plz','$ort','$land','$telefon1','$telefon2','$mobile','$fax','$mail','$www','$anrede')");
		echo mysql_error();
	} else {
//		echo str_replace("\n","",$jee)."\n";
	}
}
}
fclose ($handle);

