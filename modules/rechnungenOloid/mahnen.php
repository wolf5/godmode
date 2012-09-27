<? 
include("../../inc/config.inc.php");
include("../../inc/func.inc.php");
include("func.inc.php");

if($submit) {
	$query=mysql_query("INSERT INTO Rechnungen_mahnungen(rechnung,datum,adresse,betreff,text,footer,zahlungsfrist,besrnr) VALUES('$id','".date_CH_to_EN($datum)."','$adresse','$betreff','$text','$footer','$zahlungsfrist','$besrnr')");
	if(!$error=mysql_error()) {
		$last_id=mysql_insert_id();
		if($newpos_text) {
			$query=mysql_query("SELECT kontakt,waehrung,fx FROM Rechnungen WHERE id='$id'");
			list($kontakt,$waehrung,$fx)=mysql_fetch_row($query);
			$query=mysql_query("INSERT INTO Rechnungen_positionen(kontakt,rechnung,text,text1,betrag,waehrung,fx,datum,`key`,value) VALUES('$kontakt','0','$newpos_text','$newpos_text1','$newpos_betrag','$waehrung','$fx',NOW(),'mahnung','$last_id')");
		}
		header("Location: createPDF.php?type=mahnung&id=$last_id");
	}
		
}
?>

<html>
<head>
  <title><?=$_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body <?=error($error)?>>
<p class=titel>Rechnungen:Mahnung erstellen</p>
<?
if(!$submit) {
	$query=mysql_query("SELECT kontakt,DATE_FORMAT(datum,'$_config_date'),adresse, betreff, text,footer,waehrung,besrnr FROM Rechnungen WHERE id='$id'");
	list($kontakt,$datum,$adresse,$betreff,$text,$footer,$waehrung,$besrnr)=mysql_fetch_row($query);
	$betreff=str_replace("%DATUM%",$datum,$betreff);
	$text=str_replace("%DATUM%",$datum,$text);
	$footer=str_replace("%DATUM%",$datum,$footer);
	$_config_rechnung_mahnung_subject=str_replace("%DATUM%",$datum,$_config_rechnung_mahnung_subject);
	$betreff=$_config_rechnung_mahnung_subject;
	$zahlungsfrist=$_config_mahnung_rechnung_zahlungsfrist;
}
print "<form method=post action=\"$PHP_SELF?id=$id\">
	<table width=100% border=0>
	<tr>
		<td height=100 valign=top>
			<textarea name=adresse style=\"width:400px;height:100px;\">$adresse</textarea>
		</td>
	</tr>
	<tr>
		<td align=right height=50 valign=top>".$_config_rechnung_ort.", <input type=text name=datum value=\"".date("d.m.Y")."\"></td>
	</tr>
	<tr>
		<td>
		
		<input type=text name=betreff maxlength=255 value=\"".$betreff."\" style=\"width:400px;\"><br><br>
		<SELECT onChange=\"document.getElementById('text').value=this.value\" style=\"width:400px;background-color:#$_config_tbl_bgcolor1;\">
			<option value=\"".str_replace("%USER%",getEmp(getHttpUserId()),$text)."\">Rechnungstext</option>			
			<option value=\"".str_replace("%USER%",getEmp(getHttpUserId()),$_config_rechnung_mahnung_text_1)."\">".get1Line($_config_rechnung_mahnung_text_1)."</option>
			<option value=\"".str_replace("%USER%",getEmp(getHttpUserId()),$_config_rechnung_mahnung_text_2)."\">".get1Line($_config_rechnung_mahnung_text_2)."</option>
			<option value=\"".str_replace("%USER%",getEmp(getHttpUserId()),$_config_rechnung_mahnung_text_3)."\">".get1Line($_config_rechnung_mahnung_text_3)."</option>
      <option value=\"".str_replace("%USER%",getEmp(getHttpUserId()),$_config_rechnung_mahnung_text_4)."\">".get1Line($_config_rechnung_mahnung_text_4)."</option>
      <option value=\"".str_replace("%USER%",getEmp(getHttpUserId()),$_config_rechnung_mahnung_text_5)."\">".get1Line($_config_rechnung_mahnung_text_5)."</option>
		</SELECT><br>
		<textarea name=text id=text style=\"width:400px;height:150px;\">".str_replace("%USER%",getEmp(getHttpUserId()),$text)."</textarea>		
		</td>
	</tr>
	<tr>
		<td>
			<b>Rechnungen</b><br>
			<table border=0 width=100% cellspacing=0>
			<tr>
				<td style=\"width:60px;\"><b>Anzahl</b></td>
				<td><b>Text</b></td>
				<td><b>Text 1</b></td>
				<td align=right><b>Betrag</b></td>
			</tr>";
$query=mysql_query("SELECT id,anzahl,text,text1,$_config_posbetrag,waehrung FROM Rechnungen_positionen pos WHERE rechnung='$id'");
for($i=0;(list($pos_id,$pos_anzahl,$pos_text,$pos_text1,$betrag,$waehrung_pos)=mysql_fetch_row($query));$i++){
	if(($i%2)==0){
		$bgcolor=$_config_tbl_bgcolor1;
	} else {
		$bgcolor=$_config_tbl_bgcolor2;
	}
	print "<tr>
		<td bgcolor=\"#$bgcolor\">$pos_anzahl</td>
		<td bgcolor=\"#$bgcolor\">$pos_text</td>
		<td bgcolor=\"#$bgcolor\">$pos_text1</td>
		<td bgcolor=\"#$bgcolor\" align=right>".formatBetrag($betrag)." ".getWaehrungHtml($waehrung_pos)."</td>
	</tr>\n";
}
if(($i%2)==0){
  $bgcolor=$_config_tbl_bgcolor1;
} else {
  $bgcolor=$_config_tbl_bgcolor2;
}
print "<tr>
    <td bgcolor=\"#$bgcolor\"></td>
    <td bgcolor=\"#$bgcolor\"><input type=text style=\"width:100px\" name=newpos_text value=\"$newpos_text\"></td>
    <td bgcolor=\"#$bgcolor\"><input type=text style=\"width:100px\" name=newpos_text1 value\"$newpos_text1\"></td>
    <td bgcolor=\"#$bgcolor\" align=right><input type=text style=\"width:50px\" name=newpos_betrag value=\"$newpos_betrag\"></td>
  </tr>\n";
print "</table>\n";

//Gutschriften
$query2=mysql_query("SELECT id,betrag,waehrung,text FROM Rechnungen_gutschriften WHERE bezahlt is NULL AND kontakt='$id' AND auszahlen=1");
if(@mysql_num_rows($query2)>0)
{
	print "<br><b>Gutschriften</b><br><table border=0 width=100% cellpadding=0 cellspacing=0>
      <tr>
        <td>&nbsp;</td>
        <td><b>Text</b></td>
        <td align=right><b>Betrag</b></td>
      </tr>";

	for($i=0;list($gutschrift_id,$gutschrift_betrag,$gutschrift_waehrung,$gutschrift_text)=mysql_fetch_row($query2);$i++) {
		if(($i%2)==0){
	    $bgcolor=$_config_tbl_bgcolor1;
	  } else {
	    $bgcolor=$_config_tbl_bgcolor2;
	  }
		print "<tr>
	    <td style=\"width:30px;\" bgcolor=\"#$bgcolor\"><input type=checkbox name=\"gut[$i]\" value=\"$gutschrift_id\" checked></td>
	    <td bgcolor=\"#$bgcolor\">$gutschrift_text</td>
	    <td align=right bgcolor=\"#$bgcolor\">".formatBetrag($gutschrift_betrag)." ".getWaehrungHtml($gutschrift_waehrung)."</td>
	  </tr>\n";
	}
	print "</table>";
}
print "</td>
</tr>
<tr>
	<td>
		<table border=0 cellpadding=0 cellspacing=0 width=\"100%\">
		<tr>
			<td valign=top><b>Total</b></td>
			<td align=right><b>";
//Total berechnen
			$query1=mysql_query("SELECT sum($_config_posbetrag),waehrung FROM Rechnungen_positionen pos WHERE rechnung='$id' GROUP BY waehrung");
			for($i=0;(list($total_betrag,$total_waehrung)=mysql_fetch_row($query1));$i++) {
				if($i>0) print "<br>";
				print formatBetrag($total_betrag)." ".getWaehrungHtml($total_waehrung);
			}
print "</b></td>
		</tr>
	</td>
</tr>
</table>
<p><b>Währung</b><br>
Mahnung erstellen in: ".getWaehrungHtml($waehrung)."</p>
<p><b>Zahlungsfrist</b><br>
<input type=text style=\"width:30;text-align:right\" maxlength=3 name=\"zahlungsfrist\" value=\"$zahlungsfrist\"> Tage</p>
<p><b>Besr Nr.</b><br>
<input type=text style=\"width:250;\" name=\"besrnr\" value=\"$besrnr\"></p>
</td>
</tr>
<tr>
	<td><br><br>
    <SELECT onChange=\"document.getElementById('footer').value=this.value\" style=\"width:400px;background-color:#$_config_tbl_bgcolor1;\">
			<option value=\"".str_replace("%USER%",getEmp(getHttpUserId()),$footer)."\">Rechnungstext</option>
      <option value=\"".str_replace("%USER%",getEmp(getHttpUserId()),$_config_rechnung_mahnung_text2_1)."\">".get1Line($_config_mahnung_rechnung_text2_1)."</option>
      <option value=\"".str_replace("%USER%",getEmp(getHttpUserId()),$_config_rechnung_mahnung_text2_2)."\">".get1Line($_config_mahnung_rechnung_text2_2)."</option>
      <option value=\"".str_replace("%USER%",getEmp(getHttpUserId()),$_config_rechnung_mahnung_text2_3)."\">".get1Line($_config_mahnung_rechnung_text2_3)."</option>
      <option value=\"".str_replace("%USER%",getEmp(getHttpUserId()),$_config_rechnung_mahnung_text2_4)."\">".get1Line($_config_mahnung_rechnung_text2_4)."</option>
      <option value=\"".str_replace("%USER%",getEmp(getHttpUserId()),$_config_rechnung_mahnung_text2_5)."\">".get1Line($_config_mahnung_rechnung_text2_5)."</option>
    </SELECT><br>

		<textarea name=footer id=footer style=\"width:400px;height:70px;\">".str_replace("%USER%",getEmp(getHttpUserId()),$footer)."</textarea> 
	</td>
</tr>
</table><br>";

?>
<input type=submit name=submit value="Mahnung Drucken">
</form>
</body>
</html>
