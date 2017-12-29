<?php
session_start();
 if(!isset($_SESSION['loggedInUser'])){
    //send the iser to login page
    header("location:index.php");
}
				include_once 'dompdf/dompdf_config.inc.php';
				include_once("includes/connection.php");

				   
				$Fac_ID = $_SESSION['Fac_ID'];	
				$set = $_SESSION['set'];
				if($set == 1)
				{
					$from_date =  $_SESSION['from_date'] ;
					$to_date = $_SESSION['to_date'] ;
				}
				$dateset = $_SESSION['dateset'];
				if($_SESSION['type']=='Organised'){
					$sql1 = "select * from online_course_organised where Date_from >= '$from_date' and Date_from <= '$to_date' and Fac_ID = $Fac_ID ";
						$display = 1;
						$result=mysqli_query($conn,$sql1);
						if(mysqli_num_rows($result)>0){

							$op="<table border='1' cellspacing='0' id = 'example1' class='table table-stripped table-bordered'>
								<tr>
									<th><strong>Date From</strong></th>
									<th><strong>Date To</strong></th>
									<th><strong>Course Name</strong></th>
								</tr>";
							while($row =mysqli_fetch_assoc($result)){
								$name = $row['Course_Name'];
								$startdate = $row['Date_From'];
								$enddate = $row['Date_To'];
								$op.= "<tr>";
								$op.="<td><strong>".$startdate."</strong></td>";
								$op.="<td><strong>".$enddate."</strong></td>";
								$op.="<td><strong>".$name."</strong></td>";
								$op.="</tr>";
							}
							$op.= "</table>";
						}
						echo $op;
						$dompdf = new DOMPDF();
				$dompdf->load_html($op);
				$dompdf->set_paper('a4', 'portrait');
				$dompdf->render();

				$dompdf->stream('hi',array('Attachment'=>0));
				}
				
				if($_SESSION['type']=='Attended'){
					$sql1 = "select * from online_course_attended where Date_from >= '$from_date' and Date_from <= '$to_date' and Fac_ID = $Fac_ID ";
						$display = 1;
						$result=mysqli_query($conn,$sql1);
						if(mysqli_num_rows($result)>0){

							$op="<table border='1' cellspacing='0' class='table table-stripped table-bordered'>
								<tr>
									<th>Date From</th>
									<th>Date To</th>
									<th>Course Name</th>
								</tr>";
							while($row =mysqli_fetch_assoc($result)){
								$name = $row['Course_Name'];
								$startdate = $row['Date_From'];
								$enddate = $row['Date_To'];
								$op.= "<tr>";
								$op.="<td>".$startdate."</td>";
								$op.="<td>".$enddate."</td>";
								$op.="<td>".$name."</td>";
								$op.="</tr>";
							}
							$op.= "</table>";
						}
						echo $op;
						
						$dompdf = new DOMPDF();
				$dompdf->load_html($op);
				$dompdf->set_paper('a4', 'portrait');
				$dompdf->render();

				$dompdf->stream('hi',array('Attachment'=>0));
				}
				

?>