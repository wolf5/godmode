<?php 
include("../../inc/config.inc.php");
include("../../inc/func.inc.php");

$order = isset($_GET["order"]) ? $_GET["order"] : NULL;
$start = isset($_GET["start"]) ? $_GET["start"] : NULL;
$term = isset($_GET["term"]) ? $_GET["term"] : NULL;
?>

<html>
<head>
  <title><?php echo $_config_title?></title>
  <link rel="stylesheet" href="../../main.css" type=text/css>
	<script src="../../inc/functions.js" type="text/javascript" language="javascript"></script>
</head>
<body onLoad="document.getElementById('term').focus()">
<p class=titel>Rechnungen:Gutschriften</p>
<form method=get action="<?php echo $_SERVER["PHP_SELF"] ?>">
<input type=text name=term id=term value="<?php echo $term ?>">
<input type=submit name=search value="Suchen">
</form>
<?php
if($order=="kontakt"){
	$order="kon.firma";
} else if($order=="text"){
	$order="gut.text";
} else if($order=="betrag"){
	$order="gut.betrag";
} else if($order=="aktiv"){
	$order="gut.auszahlen";
} else {
	$order="gut.id";
}
if(!$start){
	  $start=0;
}
if($term){
	$query=mysql_query("SELECT gut.id,gut.kontakt,gut.betrag,gut.text,gut.auszahlen FROM Rechnungen_gutschriften gut, Kontakte kon WHERE gut.bezahlt is NULL AND gut.kontakt = kon.id AND ".formatSearchString($term,array("kon.firma","kon.firma2","gut.text","gut.betrag"))." ORDER BY $order");
} else {
  $query=mysql_query("SELECT gut.id,gut.kontakt,gut.betrag,gut.text,gut.auszahlen FROM Rechnungen_gutschriften gut, Kontakte kon WHERE kon.id = gut.kontakt AND bezahlt is NULL ORDER BY $order");
}
echo mysql_error();
	if(@mysql_num_rows($query)>0)
	{
		print "<table width=\"95%\" border=0 cellpadding=2 cellspacing=0>
		<tr>
			<td><b><a href=\"" . $_SERVER["PHP_SELF"] . "?order=kontakt\">Kontakt</a></b></td>
      <td><b><a href=\"" . $_SERVER["PHP_SELF"] . "?order=text\">Text</a></b></td>
      <td align=right><b><a href=\"" . $_SERVER["PHP_SELF"] . "?oder=betrag\">Betrag</a></b></td>
			<td><b><a href=\"" . $_SERVER["PHP_SELF"] . "?order=aktiv\">Aktiv</a></b></td>
		</tr>\n";
		for($i=0;list($id,$kontakt,$betrag,$grund,$aktiv)=mysql_fetch_row($query);$i++) {
			if(($i%2)==0){
				$bgcolor=$_config_tbl_bgcolor1;
			} else {
				$bgcolor=$_config_tbl_bgcolor2;
			}
			//if($bezahlt==1)                       Wofür gebraucht?
			//	$ckecked="CHECKED";
			if($aktiv==1)
				$aktiv="Ja";
			else
				$aktiv="Nein";
			print "<tr onmouseover=\"setPointer(this, 'over', '#$bgcolor', '#$_config_tbl_bghover', '')\" onmouseout=\"setPointer(this, 'out', '#$bgcolor', '#$_config_tbl_bghover', '')\" onclick=\"location.href='gutschriften_edit.php?id=$id&back=".urlencode($_SERVER["PHP_SELF"])."'\">
				<td width=250 valign=top bgcolor=\"#$bgcolor\"><a href=\"../kontakte/kontakt.php?id=$kontakt&back=".urlencode($_SERVER["PHP_SELF"])."\">".getKontakt($kontakt)."</a></td>
				<td valign=top bgcolor=\"#$bgcolor\">$grund</td>
				<td width=30 valign=top align=right bgcolor=\"#$bgcolor\">".formatBetrag($betrag)."</td>
				<td width=40 valign=top bgcolor=\"#$bgcolor\">$aktiv</td>
			</tr>";
		}
		print "</table><br>";
}
else
	print "<b>Keine Offene Gutschriften</b><br><br>";
print "[ <a href=\"gutschriften_add.php\">Neu</a> ]\n";

	?>
</body>
</html>
