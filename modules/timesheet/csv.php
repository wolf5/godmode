<?php 
include("../../inc/config.inc.php");
include("../../inc/func.inc.php");
if(substr($_SERVER["PATH_INFO"],strlen($_SERVER["PATH_INFO"])-3,3)!="csv") {
	if($statid) die("Loop detected");
	$query=mysql_query("SELECT filename FROM Statistiken WHERE id='$id'");
	$filename=mysql_result($query,0,0);
	header("Location: $PHP_SELF/$filename?statid=$id&start=$start&end=$end&sort=$sort&order=$order");
} else {
	$query=mysql_query("SELECT sql,ueberschriften,filename,datumsfeld,total FROM Statistiken WHERE id='$statid'");
	list($sql,$ueberschriften,$filename,$datumsfeld,$total)=mysql_fetch_row($query);
	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=$filename");
	header("Cache-control: private");
	eval("\$sql = \"$sql\";");
	if($start) {
  	$sql= str_replace("WHERE","WHERE $datumsfeld >= '".date_CH_to_EN($start)."' AND",$sql);
	}
		if($end) {
	  $sql= str_replace("WHERE","WHERE $datumsfeld <= '".date_CH_to_EN($end)."' AND",$sql);
	}
	if($sort) {
	  $sql = substr($sql,0,strpos(strtolower($sql),"order by"))."ORDER BY $sort";
	  if($order){
	    $sql.= " ".$order;
	  }
	}
	$query=mysql_query($sql);
	if(mysql_num_rows($query)>0){
		$ueberschriften = str_replace(">","",$ueberschriften);
    $ueberschriften = str_replace("<","",$ueberschriften);
		print $ueberschriften."\n";
		$total_val= array();
		while($row=mysql_fetch_row($query)){
			for($i=0;$i<mysql_num_fields($query);$i++) {
				print str_replace("\r","",str_replace("\n","",($row[$i]))).",";
				if(is_numeric($row[$i])) $total_val[$i]+=$row[$i];
			}
			print "\n";
		}
	}
	if(strlen($total)>0) {
  	$total = explode(",",$total);
    for($i=0;$i<mysql_num_fields($query);$i++) {
      if(in_array(mysql_field_name($query,$i),$total)) {
				print $total_val[$i];
			}
			print ",";
    }
  }

}
?>
