<?php

if(file_exists("$_config_root_path/modules/kontakte/func.inc.php")){
        global $_config_root_path;
        include("$_config_root_path/modules/kontakte/func.inc.php");
} 
function getGebieteList($formname,$selected,$breite,$default) {
        global $_config_kontakte_gebiet1,$_config_kontakte_gebiet2,$_config_kontakte_gebiet3;
        eval ("\$select$selected=\"SELECTED\";");
        $select="<SELECT name=\"$formname\" style=\"width:$breite\">\n";
        if(strlen($default)>0) $select.="<option value=0>$default</option>\n";
        if(strlen($_config_kontakte_gebiet1)>1) $select .="<option value=1>$_config_kontakte_gebiet1</option>\n";
        if(strlen($_config_kontakte_gebiet2)>1) $select .="<option value=2>$_config_kontakte_gebiet2</option>\n";
        if(strlen($_config_kontakte_gebiet3)>1) $select .="<option value=3>$_config_kontakte_gebiet3</option>\n";
        $select.="</SELECT>\n";
        return $select;
}

function getKontakteModulesList($formname,$selected,$breite,$default) {
  global $_config_root_path;
  $select="<SELECT name=\"$formname\" style=\"width:$breite\">\n";
  if(strlen($default)>0) $select.="<option value=0>$default</option>\n";
  $handle = opendir("$_config_root_path/modules/kontakte/modules/");
  while (false != ($file = readdir($handle))) {
    if ($file != "." && $file != ".." && $file != "CVS") {
                        $file=str_replace(".inc.php","",$file);
      if($file==$selected) {
        $select.="<option value=\"$file\" SELECTED>".ucfirst($file)."</option>";
      } else {
        $select.="<option value=\"$file\">".ucfirst($file)."</option>";
      }
    }
  }
  closedir($handle);
  $select.="</SELECT>\n";
  return $select;
}
function getModulesList($formname,$selected,$breite,$default) {
        global $_config_root_path;
        $select="<SELECT name=\"$formname\" style=\"width:$breite\">\n";
        if(strlen($default)>0) $select.="<option value=0>$default</option>\n";
        $handle = opendir("$_config_root_path/modules/");
        while (false != ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && $file != "CVS") {
                        if($file==$selected) {
                                $select.="<option value=\"$file\" SELECTED>".ucfirst($file)."</option>";
                        } else {
                                $select.="<option value=\"$file\">".ucfirst($file)."</option>";
                        }
    }
        }
        closedir($handle);
        $select.="</SELECT>\n";
        return $select;
}
function alert($msg) {
        if($msg) {
                return "alert(".escapeshellarg(urldecode($msg)).");";
        }
}
function error($msg) {
  if($msg) {
    return "alert('Fehler: ".substr(escapeshellarg(urldecode($msg)),1).");";
  }
}
function getZahlungsart($id){
 $query=mysql_query("SELECT art FROM Zahlungsarten WHERE id='$id'");
  return mysql_result($query,0,0);
}
function getZahlungsartenList($formname,$selected,$breite,$default) {
  $query=mysql_query("SELECT id,art FROM Zahlungsarten");
  $select="<SELECT name=\"$formname\" style=\"width:".$breite."px;\">\n";
        if($default) $select.="<option value=0>$default</option>\n";
  while(list($id,$art)=mysql_fetch_row($query)) {
    if($id == $selected)
      $select.="  <option value=$id SELECTED>$art</option>\n";
    else
      $select.="  <option value=$id>$art</option>\n";
  }
  $select.="</SELECT>\n";
  return $select;
}

function date_EN_to_CH($date){
        if(!checkdate(date("m",strtotime($date)),date("d",strtotime($date)),date("Y",strtotime($date)))) {
                        return FALSE;
        }
  if($date=="0000-00-00"){
                return NULL;
        } else if(strpos($date,"-")==FALSE) {
                return $date;
        } else {
    return date("d.m.Y",strtotime($date));
        }
}
function date_CH_to_EN($date){
        if(strpos($date,".")==FALSE) {
                return $date;
        } else {
                $date= preg_replace("|\b(\d+).(\d+).(\d+)\b|", "\\3-\\2-\\1", $date);
                if(checkdate(date("m",strtotime($date)),date("d",strtotime($date)),date("Y",strtotime($date)))) {
                        return $date;
                } else {
                        return FALSE;
                }
        }
}
function formatName($firma,$name,$vorname)
{
        if($firma)
                return "$firma, $name $vorname";
        else
                return "$name $vorname";
}
function formatBetrag($betrag)
{
        return number_format($betrag,2,".","'");
}
function isModule($module){
        global $_config_modules;
        return in_array($module,explode(",",$_config_modules));
}
function formatSearchString($term,$fields){
        $term=explode(" ",$term);
        foreach($term as $val){
                if(!isset($str))
                {
                  $str = Null;
                }  
                if($str){
                        $str .= "AND ";
                }
                $str.="( ";  
                foreach($fields as $key => $field){
                        if($key>0){
                                $str.="OR ";
                        }
                        if(strpos($val,"*")===FALSE) {
                                $str .= $field." LIKE '%". $val ."%' ";
                        } else {
                                $str .= $field." LIKE '".str_replace("*","%",$val)."' ";
                        }
                }
                $str.=") ";
        }
        if(isset($str))
        {
          return $str; 
        }       
}
function getWaehrungsList($formname,$selected,$breite)
{
  $query=mysql_query("SELECT id,text FROM Waehrungen");
  $select="<SELECT name=\"$formname\" style=\"width:".$breite."px;\">\n";
  while(list($id,$text)=mysql_fetch_row($query)) {
    if($id == $selected)
      $select.="  <option value=$id SELECTED>$text</option>\n";
    else
      $select.="  <option value=$id>$text</option>\n";
  }
  $select.="</SELECT>\n";
  return $select;
}
function getWaehrung($id){
  $query=mysql_query("SELECT text FROM Waehrungen WHERE id='$id'");
        if(mysql_num_rows($query)>0) {
          return mysql_result($query,0,0);
        } else {
                return false;
        }
}

function getWaehrungHtml($id){
  $query=mysql_query("SELECT html FROM Waehrungen WHERE id='$id'");
  if(mysql_num_rows($query)>0) {
    return mysql_result($query,0,0);
  } else {
    return false;
  }
}
function getFx($waehrung,$waehrung1){
        if($waehrung==$waehrung1){
                return 1;
        } else {
                $query=mysql_query("SELECT yahoo_fx FROM Waehrungen WHERE id='$waehrung'");
                if($query && mysql_num_rows($query)>0) {
                        $fx_1=mysql_result($query,0,0);
                } else {
                        return 0;
                }
                $query=mysql_query("SELECT yahoo_fx FROM Waehrungen WHERE id='$waehrung1'");
                if($query && mysql_num_rows($query)>0) {
      $fx_2=mysql_result($query,0,0);
    } else {
      return false;
    }
                $file=implode("\n",file("http://de.finance.yahoo.com/waehrungsrechner/convert?amt=1&from=$fx_1&to=$fx_2"));
                $file=explode("Zum Portfolio",substr($file,strpos($file,"Briefkurs",1000)));
                $fx = str_replace(",",".",substr($file[0], strpos($file[0],",",20) - 1 , 6));

               if(is_numeric($fx)){
                        return $fx;
                } else {
                        print "Achtung! Fx-berechnung meldet Fehler!";
                        return false;
                }
        }
}
function waehrungRound($betrag,$waehrung) {
  $query=mysql_query("SELECT round FROM Waehrungen WHERE id='$waehrung'");
  if(mysql_result($query,0,0)==5){
    return (round(20*$betrag))/20;
  } else {
    return $betrag;
  }
}
function waehrungCalc($betrag,$waehrung,$waehrung1) {
        return waehrungRound($betrag * getFx($waehrung,$waehrung1),$waehrung);
}
function getHttpUserId(){
        global $_config_user,$PHP_AUTH_USER;
        if($_config_user[$PHP_AUTH_USER]) {
                return $_config_user[$PHP_AUTH_USER];
        } else {
                return FALSE;
        }
}
function getYesNoList($formname,$width,$default) {
        $select="<SELECT name=\"$formname\" style=\"width:$width;\">";
        if($default==1)
                $select.= "<option value=0>Nein</option>
                        <option value=1 SELECTED>Ja</option>";
        else
                $select.= "<option value=0 SELECTED>Nein</option>
      <option value=1>Ja</option>";
        return $select;
}
?>