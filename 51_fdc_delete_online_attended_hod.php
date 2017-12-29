<?php
echo "flag  : ".$_GET['flag']."<br>";

?>
<?php
ob_start();

session_start();


//check if user has logged in or not

if(!isset($_SESSION['loggedInUser'])){
    //send the iser to login page
    header("location:index.php");
}
//connect ot database
include_once("includes/connection.php");
include_once("includes/functions.php");

$flag = $_GET['flag'];

    $id = $_SESSION['id'];

	if($flag == 1)
	{

	$sql = "delete from fdc WHERE FDC_ID = $id";

			if ($conn->query($sql) === TRUE) {
								if($_SESSION['username'] == 'hodextc@somaiya.edu')
								{
									header("location:5_fdc_dashboard_hod_online_attended.php?alert=delete");
								}		
								else
									header("location:5_fdc_dashboard_online_attended.php?alert=delete");			
				
				
				
			} 
			else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
	
	}
	else if($flag == 2)
	  header("location:5_fdc_dashboard_online_attended.php");



?>