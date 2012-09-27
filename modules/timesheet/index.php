<?php
include("./inc/func.inc.php");
?>
<html>
<head>
  <title>Sylon godmode</title>
  <link rel="stylesheet" href="../../main.css" type=text/css>
  <link rel="stylesheet" href="inc/css/ts.css" type=text/css>
  <script type="text/javascript" src="inc/js/jquery-1.4.4.min.js"></script>
  <script type="text/javascript" src="inc/js/jquery.stopwatch.js"></script>
  <script type="text/javascript" src="inc/js/func.js"></script>
</head>
<body>
<p class=titel>Zeiterfassung</p>
<br><br>
<div id="stopwatch"></div>
<fieldset>
<legend>Kunden</legend>
<?
	showButtons();
?>
</fieldset>
<?php if(empty($_GET['nolist'])){?>
<fieldset id="tableFS">
<legend>Liste von <?php echo date("F j, Y")?></legend>
<div id="tableDiv">
	<table id="timesheet" width="100%" cellpadding="3" cellspacing="0">
	<? 
		updateTable(true);
	?>
	</table>
</div>
</fieldset>
<?php }?>
<table width="100%" height="200px">
<tr>
<td width="50%">
<fieldset class="dFS">
	<legend>Details</legend>
	<form id="editForm">
	</form>
</fieldset>
</td>
<td width="50%">
<fieldset class="dFS">
	<legend>Uhr</legend>
	<div id="clock">
	</div>
</fieldset>
</td>
</tr>
</table>
</body>
</html>

