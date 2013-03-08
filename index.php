<?php 
	include("inc/config.inc.php");
?>
<html>
<head>
	<title><?php echo $_config_title ?></title>
</head>
<frameset cols="160,*" frameborder="0" framespacing="0" border="0">
	<frame src="menu.php" name=menu scrolling=no border=0>
	<frame src="<?php 
	if($_config_startmodule){
		print "modules/".$_config_startmodule."/";
	} else {
		print "modules/domains/";
	}
	?>" name=main>
</frameset>
</html>
