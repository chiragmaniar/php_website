<html>
<?php

/*refer video https://www.youtube.com/watch?v=UflTcEFuEyU and https://www.youtube.com/watch?v=PENbtWrVUjI 
http://www.webslesson.info/2017/04/convert-html-to-pdf-in-php-using-dompdf.html
*/


$op =  
 " <table style='width:100%'>
  <tr align='left'>
    <th>Firstname</th>
    <th>Lastname</th> 
    <th>Age</th>
  </tr>
  <tr>
    <td>Jill</td>
    <td>Smith</td> 
    <td>50</td>
  </tr>
  <tr>
    <td>Eve</td>
    <td>Jackson</td> 
    <td>94</td>
  </tr>
</table>" ;

?>
<?php


include_once 'dompdf/dompdf_config.inc.php';
//require_once 'dompdf/dompdf_config.inc.php';



$dompdf = new DOMPDF();
$dompdf->load_html($op);
//$dompdf->setPaper('A4','landscape');
$dompdf->render();

$dompdf->stream('hi',array('Attachment'=>0));



?>
</html>