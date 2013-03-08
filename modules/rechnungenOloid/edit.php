<?php 
include("../../inc/config.inc.php");
  
include("../../inc/func.inc.php");

$id = isset($_GET["id"]) ? $_GET["id"] : NULL;
$back = isset($_GET["back"]) ? $_GET["back"] : NULL;

$submit = isset($_POST["submit"]) ? $_POST["submit"] : NULL;
$datum = isset($_POST["datum"]) ? $_POST["datum"] : NULL;
$adresse = isset($_POST["adresse"]) ? $_POST["adresse"] : NULL;
$betreff = isset($_POST["betreff"]) ? $_POST["betreff"] : NULL;
$text = isset($_POST["text"]) ? $_POST["text"] : NULL;
$footer = isset($_POST["footer"]) ? $_POST["footer"] : NULL;

$_config_rechnung_head = isset($_config_rechnung_head) ? $_config_rechnung_head : Null;

if(!$back) {
	$back="offene.php";
}
if($submit) {
	$query=mysql_query("UPDATE Rechnungen SET datum='".date_CH_to_EN($datum)."',adresse='$adresse',betreff='$betreff',text='$text',footer='$footer' WHERE id='$id' AND fixiert=0");
	if($query) {
		header("Location: $back");
	} else {
		$err=mysql_error();
	}
}
?>

<html>
<head>
  <title><?php echo $_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body>
<p class=titel>Rechnungen:Rechnungen editieren</p>
<?php
if(isset($err)){
	print "<b>Fehler:</b> $err<br><br>";
}
$query = mysql_query("SELECT DATE_FORMAT(datum,'$_config_date'),adresse,betreff,text,footer,DATE_FORMAT(bezahlt,'$_config_date') FROM Rechnungen WHERE id='$id'");
list($datum,$adresse,$betreff,$text,$footer,$bezahlt)=mysql_fetch_row($query);
if($bezahlt){ 
	print "Diese Rechnung wurde am $bezahlt bezahlt.";
}
print "<form method=post action=\"" . $_SERVER["PHP_SELF"] . "?id=$id&back=".urlencode($back)."\">
	<table width=100% border=0>";
  
if(isset($_config_rechnung_head))
{
  print"<tr>
          <td height=100 valign=top>".nl2br($_config_rechnung_head)."</td>
  	    </tr>";
} 
print"<tr>
		<td height=100 valign=top>
			<textarea name=adresse style=\"width:400px;height:100px;\">$adresse</textarea>
		</td>
	</tr>
	<tr>
		<td align=right height=50 valign=top>".$_config_rechnung_ort.", <input type=text name=datum value=\"$datum\"></td>
	</tr>
	<tr>
		<td>
		<input type=text name=betreff maxlength=255 value=\"".$betreff."\" style=\"width:400px;\"><br><br>
		<textarea name=text style=\"width:400px;height:150px;\">$text</textarea>		
		</td>
	</tr>
	<tr>
		<td>
			<b>Rechnungen</b><br>
			<table border=0 width=100% cellpadding=0 cellspacing=0>
			<tr>
				<td><b>Text</b></td>
				<td><b>Text 1</b></td>
				<td align=right><b>Betrag</b></td>
			</tr>";
$query=mysql_query("SELECT id,text,text1,betrag FROM Rechnungen_positionen WHERE rechnung='$id'");

$total = 0;
for($i=0;(list($pos_id,$pos_text,$pos_text1,$betrag)=mysql_fetch_row($query));$i++){
	if(($i%2)==0){
		$bgcolor=$_config_tbl_bgcolor1;
	} else {
		$bgcolor=$_config_tbl_bgcolor2;
	}
	print "<tr>
		<td bgcolor=\"#$bgcolor\">$pos_text</td>
		<td bgcolor=\"#$bgcolor\">$pos_text1</td>
		<td bgcolor=\"#$bgcolor\" align=right>".formatBetrag($betrag)."</td>
	</tr>\n";

	$total+=$betrag;
}
print "</table>\n";

//Gutschriften
$query2=mysql_query("SELECT id,betrag,text FROM Rechnungen_gutschriften WHERE bezahlt is NULL AND bezahlt='$id'");

$total = 0;
if(@mysql_num_rows($query2)>0)
{
	print "<br><b>Gutschriften</b><br><table border=0 width=100% cellpadding=0 cellspacing=0>
      <tr>
        <td>&nbsp;</td>
        <td><b>Text</b></td>
        <td align=right><b>Betrag</b></td>
      </tr>";

	for(;list($gutschrift_id,$gutschrift_betrag,$gutschrift_text)=mysql_fetch_row($query2);$i++) {
		if(($i%2)==0){
	    $bgcolor=$_config_tbl_bgcolor1;
	  } else {
	    $bgcolor=$_config_tbl_bgcolor2;
	  }
		print "<tr>
	    <td bgcolor=\"#$bgcolor\">$gutschrift_text</td>
	    <td align=right bgcolor=\"#$bgcolor\">".formatBetrag($gutschrift_betrag)."</td>
	  </tr>\n";
		$total -= $gutschrift_betrag;	
	}
	print "</table>";
}
print "</td>
</tr>
<tr>
	<td>
		<table border=0 cellpadding=0 cellspacing=0 width=\"100%\">
		<tr>
			<td><b>Total</b></td>
			<td align=right><b>".formatBetrag($total)."</b></td>
		</tr>
	</td>
</tr>
</table>
</td>
</tr>";

if(isset($_config_rechnung_text_zusatz))
{
print "<tr>
	       <td><br>$_config_rechnung_text_zusatz</td>
      </tr>";
}

print "<tr>
	<td><br><br>
		<textarea name=footer style=\"width:400px;height:70px;\">$footer</textarea> 
	</td>
</tr>
</table><br>";

?>
<input type=submit name=submit value="Rechnung Ändern">
</form>
</body>
</html>
