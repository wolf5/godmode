<?
function getAlignment($ueberschriften,$i) {
	if(substr(trim($ueberschriften[$i]),0,1)=="<" ) {
		return "right";
	} else if(substr(trim($ueberschriften[$i]),0,1)==">" ) {
  	return "left";
  } else {
  	return "left";
  }
}
?>
