<?php
$handle = fopen ("daten.txt", "r");
$handle2 = fopen ("daten_2.txt", "w");

while (!feof($handle)) {
	$buffer = fgets($handle, 4096);
	if(is_numeric(substr($buffer,0,4)) && substr($buffer,4,1)==";") {
		$data=trim(str_replace("\n","\\"."n",($buffer)))."\n";
		fputs($handle2,str_replace("\r","\\r ",str_replace("\n","\\"."n",($str)))."\n");
		$str=$buffer;
	} else {
		$str.=$buffer;
	}
}
fclose ($handle2);
fclose ($handle);

