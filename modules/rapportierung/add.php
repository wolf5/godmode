<?
include("../../inc/config.inc.php");
  
include("../../inc/func.inc.php");
include("func.inc.php");

if($submit) {
	if(!$employee) {
		$error="Bitte geben Sie einen Mitarbeiter an";
	} else if(!$kontakt) {
		$error="Bitte geben Sie einen Kunden an";
	} else if(!$code) {
		$error="Bitte geben Sie einen Code an";
	} else if(!isset($time_clearable)) {
    $error="Bitte geben Sie die verrechenbaren Stunden an";
  } else if(!$time) {
    $error="Bitte geben Sie die effektiven Stunden an";
  } else if(!$date) {
    $error="Bitte geben Sie das Datum an";
	} else if($time_clearable > $time) {
		$error="Die verrechenbare Zeit darf nicht gr�sser sein als die Effektive";
	} else {
		if(!$time) $time=$time_clearable;

		$query=mysql_query("INSERT INTO Rapportierung(employee,kontakt,code,ansprechperson,text,date,time,time_clearable) VALUES('$employee','$kontakt','$code','$ansprechperson','$text','$date','$time','$time_clearable')");
		if(mysql_error())
			$error=mysql_error();
		else{
			$id=NULL;
			$kontakt=NULL;
			$code=NULL;
			$time_clearable=NULL;
			$time=NULL;
			$date=NULL;
			$date=NULL;
			$ansprechperson=NULL;
			$msg="Rapport erstellt";
		}
	}
}
if(!$date) $date=date("d.m.Y");
if(!$employee) $employee=getHttpUserId();
?>
<html>
<head>
	<title><?=$_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
</head>
<body onLoad="<?=error($error)?><?=alert($msg)?>document.getElementsByName('kontakt')[0].focus()">
<p class=titel>Rapportierung:Rapport erstellen</p>
<?
print "<form method=post action=\"$PHP_SELF?id=$id\">\n";
print "<table border=0>
    <tr>
      <td width=100>Intern:</td>
      <td>".getEmpList("employee",$employee,250,"Bitte ausw�hlen")."</td>
    </tr>
		<tr>
      <td width=100>Kontakt:</td>
      <td>".getKontakteList("kontakt",$kontakt,250,"Bitte ausw�hlen")."</td>
    </tr>
		<tr>
			<td width=100>Code:</td>
			<td>".getRapportCodeList("code",0,$code,250,"Bitte Ausw�hlen")."</td>
		</tr>
    <tr>
      <td width=100 valign=top>Text:</td>
      <td><textarea name=text style=\"width:250px;height:100px;\">$text</textarea></td>
    </tr>
    <tr>
      <td width=100>Ansprechperson:</td>
      <td><input type=text maxlength=100 name=ansprechperson value=\"$ansprechperson\" style=\"width:250px\"></td>
    </tr>
    <tr>
      <td width=100>Zeit Verrechenbar:</td>
      <td><input type=text maxlength=255 name=time_clearable value=\"$time_clearable\" style=\"width:80px\"></td>
    </tr>
    <tr>
      <td width=100>Zeit Effektiv:</td>
      <td><input type=text maxlength=255 name=time value=\"$time\" style=\"width:80px\"></td>
    </tr>
    <tr>
      <td width=100>Datum:</td>
      <td><input type=text maxlength=255 name=date value=\"$date\" style=\"width:80px\"></td>
    </tr>
		</table>\n";
print "<input type=submit name=submit value=\"Hinzuf�gen\">\n</form>\n";
?>
</body>
</html>
