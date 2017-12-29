
<?php
ob_start();
session_start();
 if(!isset($_SESSION['loggedInUser'])){
    //send the iser to login page
    header("location:index.php");
}
				include_once 'dompdf/dompdf_config.inc.php';
				include_once("includes/connection.php");

				   
				   $count1 = $_SESSION['a3'];
					$name = $_SESSION['name'];
					$sname = $_SESSION['sname'];

					
				//$d = mysqli_real_escape_string($conn,$_GET['display']);
					$display= $_GET['display'];
			//	echo urldecode($d);
				if($display==1)
				{
					$dompdf = new DOMPDF();
					$dompdf->load_html($_SESSION['A_1']);

					$dompdf->set_paper('a4', 'portrait');
					$dompdf->render();

					$dompdf->stream('hi',array('Attachment'=>0));
					
				}
				if($display==2)
				{
					$dompdf = new DOMPDF();
					$dompdf->load_html($_SESSION['A_2']);

					$dompdf->set_paper('a4', 'portrait');
					$dompdf->render();

					$dompdf->stream('hi',array('Attachment'=>0));
					
				}
				if($display==3)
				{
					$dompdf = new DOMPDF();
					$dompdf->load_html($_SESSION['A_3']);

					$dompdf->set_paper('a4', 'portrait');
					$dompdf->render();

					$dompdf->stream('hi',array('Attachment'=>0));
					
				}
				if($display==4)
				{
					$dompdf = new DOMPDF();
					$dompdf->load_html($_SESSION['O_1']);

					$dompdf->set_paper('a4', 'portrait');
					$dompdf->render();

					$dompdf->stream('hi',array('Attachment'=>0));
					
				}
				if($display==5)
				{
					$dompdf = new DOMPDF();
					$dompdf->load_html($_SESSION['O_2']);

					$dompdf->set_paper('a4', 'portrait');
					$dompdf->render();

					$dompdf->stream('hi',array('Attachment'=>0));
					
				}
				if($display==6)
				{
					$dompdf = new DOMPDF();
					$dompdf->load_html($_SESSION['O_3']);

					$dompdf->set_paper('a4', 'portrait');
					$dompdf->render();

					$dompdf->stream('hi',array('Attachment'=>0));
					
				}
?>