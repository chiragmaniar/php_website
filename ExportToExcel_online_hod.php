<?php
include 'includes/connection.php';
ob_start();

session_start();
$filename = "analysis"; 

if(isset($_SESSION['Sql_1']))
$sql = $_SESSION['Sql_1'];

if(isset($_SESSION['Sql_2']))
$sql = $_SESSION['Sql_2'];

if(isset($_SESSION['Sql_3']))
$sql = $_SESSION['Sql_3'];

if(isset($_SESSION['Sql_4']))
$sql = $_SESSION['Sql_4'];

if(isset($_SESSION['Sql_5']))
$sql = $_SESSION['Sql_5'];

if(isset($_SESSION['Sql_6']))
$sql = $_SESSION['Sql_6'];


$result = mysqli_query($conn,$sql) or die("Couldn't execute query:<br>" . mysqli_error(). "<br>" . mysqli_errno()); 
$file_ending = "xls";
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=$filename.xls");
header("Pragma: no-cache"); 
header("Expires: 0");
$sep = "\t"; 
$names = mysqli_fetch_fields($result) ;
foreach($names as $name){
    print ($name->name . $sep);
    }
print("\n");
while($row = mysqli_fetch_row($result)) {
    $schema_insert = "";
    for($j=0; $j<mysqli_num_fields($result);$j++) {
        if(!isset($row[$j]))
            $schema_insert .= "NULL".$sep;
        elseif ($row[$j] != "")
            $schema_insert .= "$row[$j]".$sep;
        else
            $schema_insert .= "".$sep;
    }
    $schema_insert = str_replace($sep."$", "", $schema_insert);
    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
    $schema_insert .= "\t";
    print(trim($schema_insert));
    print "\n";
}
?>

