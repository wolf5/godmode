<?php
function getRechnungsAdresse($kontakt) {
  global $_config_kontakte_gebiete_rechnungen;
  $query=mysql_query("SELECT kontakt$_config_kontakte_gebiete_rechnungen FROM Kontakte WHERE id='$kontakt'");
  $kont=@mysql_result($query,0,0);
  if($kont) {
    $query=mysql_query("SELECT kon.firma, konp.name, konp.vorname,konp.adresse,konp.adresse2,konp.plz,konp.ort FROM Kontakte kon, Kontakte_kontaktpersonen konp WHERE konp.firma = kon.id AND konp.id='$kont'");
    list($firma,$name,$vorname,$adresse,$adresse2,$plz,$ort)=mysql_fetch_row($query);
      if(!$adresse) {
        $query=mysql_query("SELECT adresse,adresse2,plz,ort FROM Kontakte WHERE id='$kontakt'");
        list($adresse,$adresse2,$plz,$ort)=mysql_fetch_row($query);
      }
      return preg_replace("#\n+#","\n","$firma\n$vorname $name\n$adresse\n$adresse2\n$plz $ort");
  } else {
    $query=mysql_query("SELECT firma,adresse,adresse2,plz,ort FROM Kontakte WHERE id='$kontakt'");
    list($firma,$adresse,$adresse2,$plz,$ort)=mysql_fetch_row($query);
    return preg_replace("#\n+#","\n","$firma\n$adresse\n$adresse2\n$plz $ort");
  }
}

function getRechnungsAdresseMail($kontakt) {
	global $_config_kontakte_gebiete_rechnungen;
	$query=mysql_query("SELECT kontakt$_config_kontakte_gebiete_rechnungen FROM Kontakte WHERE id='$kontakt'");
  $kont=mysql_result($query,0,0);
  if($kont) {
    $query=mysql_query("SELECT konp.name, konp.vorname,anr.anrede_lang, konp.mail FROM Kontakte kon, Kontakte_kontaktpersonen konp,Kontakte_anreden anr WHERE konp.id='$kont' AND anr.id = konp.anrede");
    list($name,$vorname,$anrede,$mail)=mysql_fetch_row($query);
     return array("$name $vorname","$anrede $name",$mail);
  } else {
    $query=mysql_query("SELECT firma,mail FROM Kontakte WHERE id='$kontakt'");
    list($firma,$mail)=mysql_fetch_row($query);
    return array($firma,"Sehr geehrte Damen und Herren",$mail);
  }

}
function get1Line($str) {
	if(strpos($str,"\n")) {
		return substr($str,0,strpos($str,"\n"));
	} else {
		return $str;
	}
}
?>
