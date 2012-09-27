<?
function saveKontakte() {
  global $kontaktpersonen;
	global $kontakt;
  global $HTTP_POST_VARS;
	global $key;
	

	
	$key = $_REQUEST["key"];
	
        $test="<br>1) key = ".$key;
      	
	      //if key is -1 it is a new adress - then apend ist at the end
      	if($key < 0) {
      		$key = count($kontaktpersonen);
      	}

      	$test .= "<br>2) key = ".$key;
      	$test .= "<br>count(kontaktpersonen) = ".count($kontaktpersonen);
      	
      	//$test = 1;
      
      
      //iterate over http_post_vars	
      	while(list ($arr_key, $arr_value) = each($HTTP_POST_VARS)) {
      	
      	//$error2 .=" in if !error".$test;
      	
      	$test .= "<br>arr_key = ".$arr_key." >>arr_value = ".$arr_value;
      	
          //save content to kontaktpersonen if the arr_key name contains  "kontaktperson_""     	  
      		if(!(strstr($arr_key,"kontaktperson_") === FALSE)) {
      			$kontaktpersonen[$key][substr($arr_key,14)] = $arr_value;
      
          //save content to kontakt if the arr_key name contains  "kontakt_""
      		} else if(!(strstr($arr_key,"kontakt_") === FALSE)) {
      			$kontakt[substr($arr_key,8)] = $arr_value;
      		}
      		
      		//$test ++;
        }
        
        $_SESSION["kontakt"] = $kontakt;
        $_SESSION["kontaktpersonen"] = $kontaktpersonen;
      	//session_register("kontakt");
      	//session_register("kontaktpersonen");

  return $test;
}
?>
