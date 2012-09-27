<?

//Version
$_config_version="2002123102";
//Database
$_config_mysql_host="localhost";
$_config_mysql_user="wolf5";
$_config_mysql_password="donttellityourmom";
$_config_mysql_db="wolf5_gm";

//General Configuration
$_config_root_path="/var/www/godmode";
$_config_whois_program="/usr/bin/whois";


//Module: Filemanager
//$_config_filemanager_directory="/home//godmode/modules/filemanager/files";
//$_config_filemanager_directory_http="/modules/filemanager/files";


$conn=mysql_connect($_config_mysql_host,$_config_mysql_user,$_config_mysql_password);
mysql_select_db($_config_mysql_db);
   
                       


$query=mysql_query("SELECT `key`,`value` FROM Konfiguration");

while(list($key,$value)=mysql_fetch_row($query)) {
	if($value=="true"||$value=="false") {
		eval("\$_config_"."$key = ($value=='true');");
	} else {
		eval("\$_config_"."$key ='$value';");
	}
}


$_config_date_php=str_replace("%","",$_config_date);
$_config_posbetrag="pos.anzahl*((pos.betrag+((pos.betrag/100)*pos.mwst))*pos.fx)";
?>
