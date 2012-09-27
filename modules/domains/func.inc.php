<?
function domain_bezahlt_bis($id){
	global $_config_date;
	$query=mysql_query("SELECT DATE_FORMAT(bezahltBis,'$_config_date') FROM Domains WHERE id='$id'");
  if(mysql_result($query,0,0)=="" || mysql_result($query,0,0)=="00.00.0000" ) {
    $query=mysql_query("SELECT DATE_FORMAT(startDate,'$_config_date') FROM Domains WHERE id='$id'");
    return mysql_result($query,0,0);
  } else  {
    return mysql_result($query,0,0);
  }
}
function getDomain($id){
	$query=mysql_query("SELECT domain FROM Domains WHERE id='$id'");
	return mysql_result($query,0,0);
}
//As timestamps
function diff_month($in_dateLow, $in_dateHigh) {
   if ($in_dateLow > $in_dateHigh) {
/*			Wenn das Enddatum kleiner ist, wird als differenz 1 zurückgegeben
	 			$tmp = $in_dateLow;
       $in_dateLow = $in_dateHigh;
       $in_dateHigh = $tmp;*/
		 return 1;
   }

   $dateLow = $in_dateLow;
   $dateHigh = strftime('%m/%Y', $in_dateHigh);

  $periodDiff = 0;
   while (strftime('%m/%Y', $dateLow) != $dateHigh) {
       $periodDiff++;
       $dateLow = strtotime('+1 month', $dateLow);
   }
   return $periodDiff;
}
?>
