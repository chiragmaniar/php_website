<?php

/*built in functions used
 trim()
 stripslashed()
 htmlspecialchars()
 strip_tags()
 str_replace() args:old , new , string data 
*/
function validateFormData($formData){
	
	
			
    $formData=trim(stripslashes(htmlspecialchars(strip_tags(str_replace(array('(',')'),'',$formData)),ENT_QUOTES)));
    return $formData;
		
	
}
function validatePassword($formData){
    $formData=trim(stripslashes(htmlspecialchars($formData)));
    return $formData;
}

?>