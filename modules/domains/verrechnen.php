<?
include("../../inc/config.inc.php");
include("../../inc/func.inc.php");
include("func.inc.php");
?>

<html>
<head>
  <title><?=$_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
  <script src="../../inc/functions.js" type="text/javascript" language="javascript"></script>
</head>
<body>
<p class=titel>Domains:Verrechnen</p>
<?
$query2=mysql_query("SELECT id,art,monate FROM Zahlungsarten");
for($i=0;list($abrechnungsart_id,$abrechungsart_art,$abrechnungsart_monate)=mysql_fetch_row($query2);$i++){
	if($order=="domain"){
		$order="domain";
	} else if($order=="betrag"){
		$order="betrag";
	} else {
		$order="firma";
	}
	$query=mysql_query("SELECT dom.id,domain,kontakt,startDate,betrag,waehrung FROM Domains dom,Kontakte kon WHERE betrag>0 AND endDate is NULL AND  abrechnungsart=$abrechnungsart_id AND dom.kontakt = kon.id ORDER BY $order");
	if(@mysql_num_rows($query)>0) {
		$header=0;
		for($i=0;list($id,$domain,$kontakt,$startDate,$betrag,$waehrung)=mysql_fetch_row($query);) {
			//14 Tage vorher verrechnen
			if(strtotime(date_CH_to_EN(domain_bezahlt_bis($id))) <  strtotime("+14 days")) {
				$domain_verrechnet=1;
				if($header==0){
					$header=1;
					print "<div class=titel2>Domains $abrechungsart_art</div>
				    <table cellpadding=2 cellspacing=0 border=0>
				    <tr>
				      <td width=300><a href=\"$PHP_SELF?order=kontakt\"><b>Kontakt</b></a></td>
				      <td width=150><a href=\"$PHP_SELF?order=domain\"><b>Domain</b></a></td>
				      <td width=100><b>Bezahlt bis</b></td>
				      <td width=50 align=right><b>Raten</b></td>
				      <td width=80 align=right><a href=\"$PHP_SELF?order=betrag\"><b>Betrag</b></a></td>
				      <td width=80 align=right><b>Total</b></td>
				    </tr>\n";
					}				
					if(($i%2) == 0){
 	    		 $bgcolor=$_config_tbl_bgcolor1;
			    } else {
			      $bgcolor=$_config_tbl_bgcolor2;
			    }
					$bezahltBis = domain_bezahlt_bis($id);
					$raten_faellig=ceil(diff_month(strtotime("+$_config_domains_verrechnen_tage_vorher days"),strtotime(date_CH_to_EN($bezahltBis)))/12);
					
					print "<tr onmouseover=\"setPointer(this, 'over', '#$bgcolor', '#$_config_tbl_bghover', '')\" onmouseout=\"setPointer(this, 'out', '#$bgcolor', '#$_config_tbl_bghover', '')\" onclick=\"location.href='verrechnen1.php?id=$id'\">
						<td width=300 bgcolor=\"#$bgcolor\">";
					if($kontakt!=$lastkontakt) {
						print "<a href=\"../../modules/kontakte/kontakt.php?id=$kontakt\">".getKontakt($kontakt)."</a></td>";
					} else {
						print "&nbsp;";
					}
					print "<td width=150 bgcolor=\"#$bgcolor\"><a href=\"domain.php?id=$id\">$domain</a></td>
						<td width=100 bgcolor=\"#$bgcolor\">$bezahltBis</td>
						<td width=50 align=right bgcolor=\"#$bgcolor\">$raten_faellig</td>
						<td width=80 align=right bgcolor=\"#$bgcolor\">".formatBetrag($betrag)." ".getWaehrungHtml($waehrung)."</td>
						<td width=80 align=right bgcolor=\"#$bgcolor\">".formatBetrag($betrag*$raten_faellig)." ".getWaehrungHtml($waehrung)."</td>
					</tr>";
					$lastkontakt=$kontakt;
					$i++;
			}
		}
		if($header==1){
			print "</table>\n<br><br>\n";
		}
	}
}
if(!$domain_verrechnet){
		print "Keine Domains zu verrechnen";
}
?>

</body>
</html>
