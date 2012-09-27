<?php
include("../../inc/config.inc.php");

function addCustomer($id){
	return mysql_query("INSERT INTO Timesheet_Kontakte SET Kunde = ".$id." ");
}

function removeCustomer($id){
	return mysql_query("DELETE FROM Timesheet_Kontakte WHERE Kunde = ".$id." LIMIT 1 ");
}

function getRunning(){
	$result = mysql_query("SELECT id FROM Timesheet WHERE ISRUNNING = 1");
	$running = mysql_fetch_array($result);
	return $running['id'];
}

function setRunning($id){
	$running_id = getRunning();
	mysql_query("UPDATE Timesheet SET ISRUNNING=0,end_stamp=CURRENT_TIMESTAMP WHERE id=".$running_id);
	echo mysql_error();
	mysql_query("INSERT INTO Timesheet (`id`, `kunde`, `start_stamp`, `end_stamp`, `user`, `notice`, `ISRUNNING`) VALUES (NULL, '".$id."', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, NULL, NULL, '1')");
	echo mysql_error();
	return mysql_insert_id();
}

function updateTable($date){
	$datefilter = !empty($date)? "WHERE start_stamp >= CURDATE()": "";
	$query = "SELECT ts.id, ISRUNNING, notice, firma, firma2, start_stamp, end_stamp, TIMESTAMPDIFF(MINUTE,start_stamp,end_stamp) as ess FROM Timesheet as ts LEFT JOIN  Kontakte as con ON ( con.id = ts.Kunde) ".$datefilter." ORDER BY start_stamp DESC, end_stamp DESC, ts.id DESC";
	$result = mysql_query($query);
	$counter = 0;
	echo "<tr>";
	echo "<td>Minuten</td><td>Kunde</td><td>Notiz</td><td>Von</td><td>Bis</td><td>Aktion</td>";
	echo "</tr>";
	while ($customer = mysql_fetch_array($result)){
		$counter++;
		$id="";
		$bgcolor= $counter%2==0 ? "#ffffff":"#aaaaaa";
		if ($customer['ISRUNNING']== 1){
				$bgcolor= "#f9dada";
				$id=" id='isrunning'";
		}
		echo "<tr bgcolor=\"$bgcolor\" class='list' ".$id.">";
		echo "<td>".$customer['ess']."</td><td>".$customer['id']." ".$customer['firma']."</td><td>".$customer['notice']."</td><td>".$customer['start_stamp']."</td><td>".$customer['end_stamp']."</td>";
		echo "<td><span class='edit' id='".$customer['id']."'>edit</span></td>";
		echo "</tr>";
	}
}

function showButtons(){
	$query=mysql_query("SELECT tsk.Kunde, con.id, con.firma, con.firma2 FROM Kontakte as con, Timesheet_Kontakte as tsk WHERE con.id = tsk.Kunde ORDER BY con.id DESC");
	while ($customer = mysql_fetch_array($query)){
		echo "<button value='".$customer['id']."' class='time'".$active.">".$customer['firma']."</button>";
	}	
}

function getMessureById($id){
	$result = mysql_query("SELECT ts.id, ISRUNNING, notice, firma, firma2, start_stamp, end_stamp, TIMESTAMPDIFF(MINUTE,start_stamp,end_stamp) as ess FROM Timesheet as ts LEFT JOIN  Kontakte as con ON ( con.id = ts.Kunde) WHERE ts.id = ".$id);
	$resArray = mysql_fetch_array($result);
	echo "Kunde: ".$resArray['firma']."<br />";
	echo " ".$resArray['firma2']."<br />";
	echo "<table><tr><td rowspan='2'>Notiz:</td><td rowspan='2'><textarea name='notice'>".$resArray['notice']."</textarea></td>";
	echo "<td>von:</td><td><input name='start_stamp' value='".$resArray['start_stamp']."' /></td>";
	echo "<tr><td>bis:</td><td><input name='end_stamp' value='".$resArray['end_stamp']."' /></td></tr></table>";
	echo "<input type='hidden' value='true' name='saveChanges' />";
	echo "<input type='hidden' value='".$resArray['id']."' name='id' />";
	echo "<button id='save' onsubmit='return false'>Speichern</button>";
}

function saveChanges(){
	$query="UPDATE Timesheet SET notice='".$_POST['notice']."' WHERE id=".$_POST['id'];	
	mysql_query($query);
	echo mysql_error();
}

?>
