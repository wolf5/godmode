<? 
include("../../inc/config.inc.php");
include("../../inc/func.inc.php");

if($submit) {
	$query=mysql_query("SELECT `key`,`value` FROM `Konfiguration`");
	while(list($key,$value)=mysql_fetch_row($query)) {
		if(isset($$key) && $value != $$key) {
			$query2=mysql_query("UPDATE `Konfiguration` SET `value` = '".$$key."' WHERE `key` = '$key'");
			if(($error=mysql_error())) {
				break;
			}
		}
	}
}
?>
<html>
<head>
	<title><?=$_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body <?=error($error);?>>
<p class=titel>Konfiguration</p>
<form method=post action="<?=$PHP_SELF?>?submit=1">
<table border=0>
<?
$query=mysql_query("SELECT `context`,`key`,`value`,`text`,`inputtype` FROM `Konfiguration` ORDER BY `context`,`text`");
while((list($context,$key,$value,$text,$inputtype)=mysql_fetch_row($query))) {
	if(!$old_context || $old_context!=$context) {
		$old_context=$context;
		print "<tr>
			<td colspan=2>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=2><b>$context</b></td>
		</tr>";
	}
	print "<tr>
		<td valign=top>$text</td>
		<td>";
	if($inputtype=="input") {
		print "<input type=text style=\"width:250px;\" name=\"$key\" value=\"$value\">";
	} else if($inputtype=="textarea") {
		print "<textarea style=\"width:250px;height:100px;\" name=\"$key\">$value</textarea>";
	} else if($inputtype=="bool") {
		print "<SELECT style=\"width:60px\" name=\"$key\">\n";
		if($value=="true") {
			print "	<option value=true SELECTED>Ja</option>\n	<option value=false>Nein</option>\n";
		} else {
			print "	<option value=true>Ja</option>\n	<option value=false SELECTED>Nein</option>\n";
		}
	} else {
		eval("print $inputtype;");
	}
	print "</td>
	</tr>";
}
?>
</table>
<input type=submit value="Ändern">
</form>
</body>
</html>
