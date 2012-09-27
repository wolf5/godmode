<?php
include("./inc/func.inc.php");

if (!empty($_POST['action'])){
    echo $_POST['action'] == "add" ? addCustomer($_POST['id']) : removeCustomer($_POST['id']); 
}

if (!empty($_POST['change'])){
	echo setRunning($_POST['id']);
}

if (!empty($_POST['updateTable'])){
	updateTable(true);	
}

if (!empty($_POST['edit'])){
	getMessureById($_POST['id']);	
}

if (!empty($_POST['saveChanges'])){
	saveChanges();
}

?>