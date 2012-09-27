<? 
include("../../inc/config.inc.php");
include("../../inc/func.inc.php");
include("../produkte/func.inc.php");
if($erstellen) {
	$anz_objekte=count($produkt);
	if(!$kontakt) {
		$err="Bitte geben Sie einen Kontakt an";
	} else {
		for($i=0;$i<$anz_objekte;$i++) {
			if($produkt[$i] && !$preis[$i]) {
				$err="Geben Sie für Artikel ".($i+1)." bitte einen Preis an";
			} else if($produkt[$i] && !$anzahl[$i]) {
				$err="Geben Sie für Artikel ".($i+1)." bitte eine Stückzahl an";
			}
			if($produkt[$i]) $has_artikel=1;
		}
		if(!$has_artikel) {
			$err="Bitte geben Sie mindestens einen Artikel an";
		}
	}
	if(!$err) {
		$query=mysql_query("DELETE FROM Rechnungen_positionen WHERE kontakt='$kontakt' AND rechnung IS NULL");

		for($i=0;$i<$anz_objekte;$i++) {
			if($produkt[$i]) {
				$query=mysql_query("SELECT text1,text2,waehrung,preis".$preis[$i].",nr_int FROM Produkte WHERE nr_int='".$produkt[$i]."'");
				if(!($err=mysql_error())) {
					list($text1,$text2,$waehrung,$betrag,$nr_int)=mysql_fetch_row($query);
					eval("\$waehrung = \$_config_produkte_preis".$preis[$i]."_waehrung;");
					if($preis1[$i]) {
						$betrag=$preis1[$i];
					}
					$query=mysql_query("INSERT INTO Rechnungen_positionen(kontakt,rechnung,text,text1,anzahl,betrag,waehrung,datum,mwst,`key`,`value`) VALUES('$kontakt',NULL,'$text1','$text2','".$anzahl[$i]."','$betrag','$waehrung',NOW(),'".$mwst[$i]."','produkt','$nr_int')");
					if($query) {
						if($popup) {
							$showErstellen=1;
						} else {
							header("Location: erstellen1.php?id=$kontakt");
						}
					} else {
						$err=mysql_error();
					}
				} else {
					$err=mysql_error();
				}
			}
		}
		if($position_anzahl) {
			$query=mysql_query("INSERT INTO Rechnungen_positionen(kontakt,rechnung,text,text1,anzahl,betrag,waehrung,datum,mwst) VALUES('$kontakt',NULL,'".$position_text."','','$position_anzahl','$position_betrag','1',NOW(),'".$position_mwst."')");
		}
	}
}
if(!$rows) {
	$rows=3;
}
if(substr($action,0,3)=="add") {
	$rows++;
} else if(substr($action,0,3)=="del") {
	$delete = trim(substr($action,3));
	$rows--;
}
?>

<html>
<head>
  <title><?=$_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
	<script src="../../inc/functions.js" type="text/javascript" language="javascript"></script>
	<script language="JavaScript" type="text/javascript">
	<!--
	function submit_form(arg){
		document.getElementsByName('action')[0].value = arg;
		document.Formular.submit();
	}
  function popup(file) {
    window.open(file,'find','width=300,height=650,left=30,top=50,resizable=yes,scrollbars=no');
  }
	function setMwst(value) {
		<?
			for($i=0;$i<$rows;$i++) {
				print "document.getElementsByName('mwst[$i]')[0].value=value;";
			}
		?>
	}
  function setPreis(value) {
    <?
      for($i=0;$i<$rows;$i++) {
        print "document.getElementsByName('preis[$i]')[0].value=value;";
      }
    ?>
  }
	//-->
	</script>
</head>
<body<?
if($showErstellen) print " onLoad=\"javascript:opener.location.href='erstellen1.php?id=$kontakt';\"";
?>>
<p class=titel>Rechnungen:Rechnung erstellen</p>
<a href="#" onclick="javascript:window.open('<?=$PHP_SELF?>?popup=1','rechnung_erstellen','fullscreen=no,scrollbars=auto,status=yes,menubar=no,toolbar=no,width=600,height=400,resizable=yes');">In neuem Fenster</a><br><br>
<?
if($err) {
	print "<b>Fehler:</b> $err<br><br>";
}
print "<form method=post name=\"Formular\" action=\"$PHP_SELF\">
	<input type=hidden name=rows value=\"$rows\">
	<input type=hidden name=action>
	<input type=hidden name=popup value=\"$popup\">
	<table border=0>
	<tr>
		<td width=100>Kontakt</td>
		<td>&nbsp;</td>
		<td><input type=text name=kontakt value=\"$kontakt\" id=kontakt> <a href=\"javascript:popup('findkontakt.php');\">S</a></td>
		<td>&nbsp;</td>
		<td>".str_replace("<SELECT","<SELECT onChange=\"javascript:setPreis(this.value);\"",str_replace("120px;","120px;background-color:#$_config_tbl_bgcolor1;",getPreiseList("","",120,"Standard")))."</td>
		<td><input style=\"width:50px;background-color:#$_config_tbl_bgcolor1\" onChange=\"javascript:setMwst(this.value);\"></td>
	</tr>";
for($i=0,$ii=0;$ii<$rows;$i++) {
	  if($i == $delete && isset($delete)) {
    continue;
  }
	if(!$anzahl[$i] && !isset($anzah[$i])) {
		$anzahl[$i]=$_config_produkte_default_num_artikel;
	}
	if($produkt[$i] && $preis[$i]) {
		$query=mysql_query("SELECT preis".$preis[$ii]." FROM Produkte WHERE nr_int='".$produkt[$i]."'");
		$preis1[$ii]=mysql_result($query,0,0);
	}
	print "<tr>
			<td width=100>Position ".($ii+1)."</td>
			<td><input type=text size=4 maxlength=11 name=\"anzahl[$i]\" value=\"".$anzahl[$i]."\">
			<td><input type=text name=produkt[$ii] value=\"".$produkt[$i]."\"> <a href=\"javascript:popup('findprodukt.php?field=$ii')\">S</a></td>
			 <td><input type=input name=\"preis1[$ii]\" value=\"$preis1[$i]\" style=\"width:50px\"> 
			<td>".str_replace("<SELECT","<SELECT onchange=\"javascript:document.getElementsByName('preis1[$i]')[0].value='';\" ",getPreiseList("preis[$ii]",$preis[$i],120,"Bitte Auswählen"))."</td>
			<td><input type=input name=\"mwst[$ii]\" value=\"$mwst[$i]\" style=\"width:50px\"> ";
	if($rows>1) {
		print "<a href=\"#\" onclick=\"javascript:submit_form('del$ii')\">-</a>";
	}
	if(($ii+1)==$rows) {
		print " <a href=\"#\" onclick=\"javascript:submit_form('add')\">+</a>";
	}
	print "</td>
		</tr>";
	$ii++;
}
print "<tr>
	<td>Freie Position:</td>
	<td><input type=text size=4 maxlength=11 name=\"position_anzahl\" value=\"".$position_anzahl."\">
	<td><input type=text name=\"position_text\" value=\"".$position_text."\"></td>
	<td>&nbsp;</td>
	<td><input type=text style=\"width:50px\" name=\"position_betrag\" value=\"".$position_betrag."\"></td>
	<td><input type=input name=\"position_mwst\" value=\"".$position_mwst."\" style=\"width:50px\"></td>
</tr>

<tr>
		<td width=100>&nbsp;</td>
		<td colspan=3><input type=submit value=\"Erstellen\" name=erstellen> <input type=button value=\"Aktualisieren\" onclick=\"javascript:submit_form('upd')\">
	</tr>
	</table>
	</form>";
?>

</body>
</html>
