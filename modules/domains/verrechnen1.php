<?php
include("../../inc/config.inc.php");
include("../../inc/func.inc.php");
include("func.inc.php");

$query=mysql_query("SELECT dom.domain, dom.kontakt,dom.betrag,dom.waehrung,abr.monate FROM Domains dom,Zahlungsarten abr  WHERE dom.id='$id' AND abr.id = dom.abrechnungsart");
list($domain,$kontakt,$betrag,$waehrung,$abr_mnt)=mysql_fetch_row($query);
$bezahltBis=domain_bezahlt_bis($id);
$raten=ceil(diff_month(strtotime("+$_config_domains_verrechnen_tage_vorher days"),strtotime(date_CH_to_EN($bezahltBis)))/12);
$betrag=($betrag * $raten);
$tmp_monate=$abr_mnt * $raten;
$text="Hosting $domain";
if(date("d",strtotime(date_CH_to_EN($bezahltBis)))=="1"){
  $zahlenBis=date("t.m.Y",strtotime("+".($tmp_monate-1)." month",strtotime(date_CH_to_EN($bezahltBis))));
} else {
	//Wüster PHP Date Bug
  if(date("d",strtotime(date_CH_to_EN($bezahltBis)))==31) {
		$zahlenBis=date("m.Y",strtotime("+$tmp_monate month",strtotime("-1 day",strtotime(date_CH_to_EN($bezahltBis)))));
		$zahlenBis="31.".$zahlenBis;
	} else {
		$zahlenBis=date("t.m.Y",strtotime("+$tmp_monate month",strtotime(date_CH_to_EN($bezahltBis))));
	}
}
$text1="$bezahltBis - $zahlenBis";

$query=mysql_query("INSERT INTO Rechnungen_positionen(kontakt,rechnung,text,text1,betrag,mwst,waehrung,datum,`key`,value) VALUES('$kontakt',NULL,'$text','$text1','$betrag','$_config_domains_mwst','$waehrung',NOW(),'domains','$id')");
if(!($error=mysql_error())) {
  $query=mysql_query("UPDATE Domains SET bezahltBis='".date_CH_to_EN($zahlenBis)."' WHERE id='$id'");
  if(!($error=mysql_error())) {
    header("Location: verrechnen.php");
  }
}
?>

<html>
<head>
  <title><?php echo $_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
  <script src="../../inc/functions.js" type="text/javascript" language="javascript"></script>
</head>
<body>
<p class=titel>Domains:Verrechnen</p>
<table width="100%" height="100%" border=0>
<tr>
	<td align=center valign=middle>
	<?php
		if($error){
			print "<b>Fehler:</b> $error";
		}
	?>
	</td>
</tr>
</table>
</body>
</html>
