<?php 
session_start();
include("../../inc/config.inc.php");
  
include("../../inc/func.inc.php");
include("func.inc.php");
if(!$back) {
  $back="show.php";
}
if(!$backno) {
  $backno=$back;
}
if($del) {
  $query=mysql_query("DELETE FROM Rapportierung WHERE id='$del'");
  if($query) {
    header("Location: ".urldecode($back));
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
<p class=titel>Rapportierung:Rapport Löschen</p>
<?php
  if($err){
    print "<b>Fehler:</b> $err<br><br>";
  }
  $query=mysql_query("SELECT text,DATE_FORMAT(date,'$_config_date') FROM Rapportierung WHERE id='$id'");
  list($text,$date)=mysql_fetch_row($query);
  if(strlen($text)>200) $text=substr($text,0,200)."...";
  print "Möchten Sie den Rapport $text vom $date wirklich Löschen?<br><br>
<a href=\"$PHP_SELF?del=$id&back=".urldecode($back)."\">[ Ja ]</a> <a href=\"".urldecode($backno)."\">[ Nein ]</a>";
?>
</body>
</html>

