<?php 
session_start();
include("../../inc/config.inc.php");
  
include("../../inc/func.inc.php");
include("func2.inc.php");

$debugLogString="";

$HTTP_POST_VARS   = !empty($HTTP_POST_VARS)   ? $HTTP_POST_VARS   : $_POST;


if(!$_SESSION["back"]){
    
  $_SESSION["back"] = "show.php";
}

/**
 * if id id set get the content for kontakt array and kontaktpersonen array!
 */ 

$id = isset($_GET['id']) ? $_GET['id'] : NULL;
$key = isset($_GET['key']) ? $_GET['key'] : NULL;
$submit_form = isset($_POST['submit_form']) ? $_POST['submit_form'] : NULL;
$kontakt = isset($_SESSION['kontakt']) ? $_SESSION['kontakt'] : NULL;
$kontaktpersonen = isset($_SESSION['kontaktpersonen']) ? $_SESSION['kontaktpersonen'] : NULL;

if(isset($id)) {

	if(isset($_SESSION["kontakt"])) {
		//session_unregister($kontakt);
		unset($_SESSION["kontakt"]);
	}
  
  if(isset($_SESSION["kontaktpersonen"])) {
    //session_unregister($kontaktpersonen);
    unset($_SESSION["kontaktpersonen"]);
    $kontaktpersonen = NULL;
  }
  
  
  $query=mysql_query("SELECT id,DATE_FORMAT(erfasst,'$_config_date') as erfasst,DATE_FORMAT(updated,'$_config_date') as updated,aktiv,firma,firma2,anrede,adresse,adresse2,plz,ort,land,telefon1,telefon2,mobile,fax,mail,www,text,konto,kontonr,blz,swift,iban,pl,kontakt1,kontakt2,kontakt3 FROM Kontakte WHERE id='$id'");
	
  
  if(!($error=mysql_error())) {
  
		$kontakt=array();
	  $kontakt = mysql_fetch_array($query, MYSQL_ASSOC);

		//session_register("kontakt");
		$_SESSION["kontakt"] = $kontakt; 
		
		$query = mysql_query("SELECT id, name,vorname, anrede,position,abteilung,adresse,adresse2,plz,ort,land,tel_privat,tel_gesch,tel_direkt,tel_mobile,fax,mail,mail2,text FROM Kontakte_kontaktpersonen WHERE firma = '$id' AND NOT firma='0'");

	
  	if(!($error=mysql_error())) {        	
      
			$kontaktpersonen=array();
			for($i=0;$i<mysql_num_rows($query);$i++) {
				$kontaktpersonen[$i] = mysql_fetch_array($query, MYSQL_ASSOC);
				//$errorMsgFlo .=   $kontaktpersonen[$i];
			}
			//session_register("kontaktpersonen");
			$_SESSION["kontaktpersonen"] = $kontaktpersonen;
		}
	}
	if(!$kontakt['anrede']) {
		$kontakt['anrede']=$_config_kontakte_default_anrede;
	}



/**
 * if kontaktpersonId is update the arrays and save it ( with putting the submitform =1)!
 */ 

} else {
  $debugLogString.="<h1>else:</h1><p>";
  $debugLogString.=saveKontakte();
  $debugLogString.="</p>";
	//saveKontakte();
	//$submit_form=1;
	
}




if($submit_form)
{
  if($submit_form==1){
    if(!$kontakt['firma']){
      $error="Firma oder Name muss ausgefüllt werden";
  	
    
    }else {
  	
      	/**
      	 * Update or Insert into kontakt Table 
      	 */   	
      	 
      	 
      		//UPDATE the kontakt values in database
      		if( $kontakt['id']>0 ) {	
          	
        		  $keys = array_keys($kontakt);
        			$sql="";
        		  for($i=0;$i<count($keys);$i++) {
          		    if($i>0) $sql.=", ";
          		    $sql.=$keys[$i]."='".$kontakt[$keys[$i]]."'";
        		  }
        		  $myQueryString = "UPDATE Kontakte SET updated=NOW(),$sql WHERE id='".$kontakt['id']."'";   			
        			$query=mysql_query($myQueryString);
      		  
      	 
      		//INSERT the kontakt values in database 
          }else {
        			$keys = array_keys($kontakt);
        			$fields="";
        			$values="";
        			for($i=0;$i<count($keys);$i++) {
          				if($i>0) {
          					$fields.=",";
          					$values.=",";
        				  }
          				$fields.=$keys[$i];
          				$values.="'".$kontakt[$keys[$i]]."'";  				
        			}  			
        			$myQueryString =  "INSERT INTO Kontakte($fields,erfasst) VALUES($values,NOW())";      					
        			$query=mysql_query($myQueryString);
              
      		}
      		
      	
        
        /**
      	 * Update or Insert into kontaktpersonen Table 
      	 */  
      		
      		
      		if(!($error=mysql_error())) {
      		
      			for($i=0;$i<count($kontaktpersonen);$i++) {
          				unset($sql,$fields,$values);
          				$keys = array_keys($kontaktpersonen[$i]);
          
                  //try to get the kontaktperosn wit iteration id if there is one in db
          				$query=mysql_query("SELECT count(*) FROM Kontakte_kontaktpersonen WHERE id='".$kontaktpersonen[$i]['id']."'");
          				
          				
          				
          				//UPDATE the kontaktpersonen values in database because ther was a entry found with the iteration id
          				if(mysql_result($query,0,0)>0) {
                    for($ii=0;$ii<count($keys);$ii++) {
                      if($ii>0) $sql.=", ";
                      $sql.=$keys[$ii]."='".$kontaktpersonen[$i][$keys[$ii]]."'";
                    }
                    $query=mysql_query("UPDATE Kontakte_kontaktpersonen SET $sql WHERE id='".$kontaktpersonen[$i]['id']."'");
                    
          				
                  //INSERT the kontaktpersonen values in database otherwise
                  }else {
          		      for($ii=0;$ii<count($keys);$ii++) {
          		        if($ii>0) {
          		          $fields.=",";
          		          $values.=",";
          		        }
          		        $fields.=$keys[$ii];
          		        $values.="'".$kontaktpersonen[$i][$keys[$ii]]."'";
          		      }
          		      $query=mysql_query("INSERT INTO Kontakte_kontaktpersonen(firma,$fields) VALUES('".$kontakt['id']."',$values)");
          				}
      			}
      			
            if(!($error=mysql_error())) {
              session_destroy();
              header("Location: " . $_SESSION["back"]);
            }
            
            
      		}
  	 }
  }
}
?>
<html>
<head>
	<title><?php echo $_config_title?></title>
	<link rel="stylesheet" href="../../main.css" type=text/css>
	<script src="../../inc/functions.js" type="text/javascript" language="javascript"></script>
	<script type="text/javascript" language="javascript">
	<!--
		var state;
		state=<?php echo $kontakt['anrede']?>;
		function changeAnrede(newState) {
			if((state==1 || state==2) && newState==3) {
				document.getElementById('submit_form').value=2;
				document.kontaktform.submit();
			} else if(state==3 || (newState==1 && newState==2)) {
				document.getElementById('submit_form').value=2;
				document.kontaktform.submit();
			}
		}
		function showKontaktPerson(id) {
		  //alert(id);
			document.kontaktform.action='kontaktperson.php?key='+id;
			alert(document.kontaktform.action);
			document.kontaktform.submit();
			//alert('Diese Funktion ist vorübergehend nicht in Betrieb.');
		}
	//-->
	</script>
</head>
<body onLoad="javascript:error('<?php echo addslashes($error) ?>'); document.getElementById('firma').focus();">
<?php echo $debugLogString?>
<p class="titel">Kontakte:Kontakt</p>
<?php 
if(count($kontakt)>0) {
	print "<form method=post action=\"" .$_SERVER["PHP_SELF"]. "\" name=\"kontaktform\">
	<input type=\"hidden\" name=\"submit_form\" id=\"submit_form\" value=\"1\">
	<table border=0 cellpadding=0 cellspacing=0 width=\"95%\">";
	if(isset($_config_kontakte_module1) || isset($_config_kontakte_module2 )){
		print "
			<tr>
				<td align=left valign=top >";
		if(isset($_config_kontakte_module1)) {
			foreach(explode(";",$_config_kontakte_module1) as $module) {
				include("modules/$module.inc.php");
			}
		}
		print "</td>
				<td width=\"*\">&nbsp;</td>
				<td align=right valign=top>";
    if(isset($_config_kontakte_module2)) {
      foreach(explode(";",$_config_kontakte_module2) as $module) {
        include("modules/$module.inc.php");
      }
    }
		print "</td>
			</tr>";
	}
	if(isset($_config_kontakte_module3) || isset($_config_kontakte_module4)){
		print "<tr>
				<td colspan=3 height=30>&nbsp;</td>
			</tr>
			<tr>
				<td align=left valign=top>";
    if(isset($_config_kontakte_module3)) {
      foreach(explode(";",$_config_kontakte_module3) as $module) {
        include("modules/$module.inc.php");
      }
    }
		print "</td>
				<td width=\"*\">&nbsp;</td>
				<td align=right valign=top>";
    if(isset($_config_kontakte_module4)) {
      foreach(explode(";",$_config_kontakte_module4) as $module) {
        include("modules/$module.inc.php");
      }
    }
		print "
				</td>
			</tr>";
	}
	if(isset($_config_kontakte_module5) || isset($_config_kontakte_module6)){
    print "<tr>
        <td colspan=3 height=30>&nbsp;</td>
      </tr>
      <tr>
        <td align=left valign=top>";
    if(isset($_config_kontakte_module5)) { 
			foreach(explode(";",$_config_kontakte_module5) as $module) {
				include("modules/$module.inc.php");
			}
    }
    print "</td>
        <td width=\"*\">&nbsp;</td>
        <td align=right valign=top>";
    if(isset($_config_kontakte_module6)) {
			foreach(explode(";",$_config_kontakte_module6) as $module) {
				include("modules/$module.inc.php");
			}
    }
    print "
        </td>
      </tr>";
	}
	if(isset($_config_kontakte_module7) || isset($_config_kontakte_module8)){
    print "<tr>
        <td colspan=3 height=30>&nbsp;</td>
      </tr>
      <tr>
        <td align=left valign=top>";
    if(isset($_config_kontakte_module7)) {
      foreach(explode(";",$_config_kontakte_module7) as $module) {
        include("modules/$module.inc.php");
      }
    }
    print "</td>
        <td width=\"*\">&nbsp;</td>
        <td align=right valign=top>";
    if(isset($_config_kontakte_module8)) {
      foreach(explode(";",$_config_kontakte_module8) as $module) {
        include("modules/$module.inc.php");
      }
    }
    print "
        </td>
      </tr>";
  }
	print "</table><br>
	<input type=\"submit\" name=\"submit_button\" value=\"Speichern\"> <input type=\"button\" onclick=\"javascript:location.href='".urldecode($_SESSION["back"])."'\" value=\"Abbrechen\"> <input type=button onclick=\"javascript:location.href='delete.php?id=$id&back=".urlencode($_SESSION["back"])."&backno=".urlencode($_SERVER["REQUEST_URI"])."'\" value=\"Löschen\">\n"; 
	if(!anredeIsPrivate($kontakt['anrede'])) {
		//Kontaktpersonen
		print "<hr noshade width=95% align=left>";
		if(count($kontaktpersonen)>0) {
			print "<table width=95% border=0 cellpadding=0 cellspacing=0>
			<tr>
				<td><b>Name</b>
				<td><b>Position</b></td>
				<td><b>e-mail Adresse</b>
				<td><b>Telefon</b>
			</tr>\n";
			for($i=0;$i<(count($kontaktpersonen));$i++) {
				if($kontaktpersonen[$i]['tel_direkt']) {
					$tel=$kontaktpersonen[$i]['tel_direkt']." (Direkt)";
				} else if($kontaktpersonen[$i]['tel_mobilet']) {
					$tel=$kontaktpersonen[$i]['tel_mobile']." (Mobile)";
				} else if($kontaktpersonen[$i]['tel_gesch']) {
					$tel=$kontaktpersonen[$i]['tel_gesch']."  (Geschäft)";
				} else if($kontaktpersonen[$i]['tel_privat']) {
					$tel=$kontaktpersonen[$i]['tel_privat']."  (Privat)";
				} else {
					$tel="";
				}
		    if(($i%2)==0){
		      $bgcolor=$_config_tbl_bgcolor1;
		    } else {
		      $bgcolor=$_config_tbl_bgcolor2;
		    }
				print "<tr onmouseover=\"setPointer(this, 'over', '#$bgcolor', '#$_config_tbl_bghover', '')\" onmouseout=\"setPointer(this, 'out', '#$bgcolor', '#$_config_tbl_bghover', '')\" onclick=\"showKontaktPerson(".($i).");\">
					<td valign=top bgcolor=\"#$bgcolor\" width=\"25%\">".formatName("",$kontaktpersonen[$i]['name'],$kontaktpersonen[$i]['vorname'])."</td>
		      <td valign=top bgcolor=\"#$bgcolor\" width=\"25%\">".$kontaktpersonen[$i]['position']."</td>
		      <td valign=top bgcolor=\"#$bgcolor\" width=\"25%\"><a href=\"mailto:".$kontaktpersonen[$i]['mail']."\">".$kontaktpersonen['mail'][$i]."</a></td>
		      <td valign=top bgcolor=\"#$bgcolor\" width=\"25%\">$tel</td>
				</tr>";
			}
			print "</table>";
		}
		print "<br><a href=\"#\" onclick=\"showKontaktPerson(-1);\">[ Neue Kontaktperson ]</a><br><br>";
	}
} else {
		print "Fehler: Kontakt existiert ev. nicht\n";
}

?>
</form> 
<br />
<br />
<br />
<br />
<?php
  if($id)
  {
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
  }  
?>
</body>
</html>
