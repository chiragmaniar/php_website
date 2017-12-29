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
					$count4 = $_SESSION['a4'] ;
					$count5 = $_SESSION['a5'] ;
					$count6 = $_SESSION['a6'] ;
					$count7 = $_SESSION['a7'] ;
					$count8 = $_SESSION['a8'] ;
					$count9 = $_SESSION['a9'] ;
					$sname = $_SESSION['sname'];

					
				//$d = mysqli_real_escape_string($conn,$_GET['display']);
					$display= $_GET['display'];
			//	echo urldecode($d);
				if($display == 1)
				{
					$from_date = $_SESSION['a1']  ;
				   $to_date = $_SESSION['a2'];
					if($count4 > 0)
					{
						$sql = "select * from faculty where Date_from >= '$from_date' and Date_from <= '$to_date' and Paper_type = 'conference' and Paper_N_I = 'national'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data1[] = $row['Paper_title'];
									$conf1[] = $row['conf_journal_name'];
									
									
									
							}
						}
						}
						for($i = 0; $i < $count4; $i++)
						{
							$rowall1 .= "-".$data1[$i]."<br>";
							$confall1 .= "-".$conf1[$i]."<br>";
							
						}
					}
					else
					{
						$rowall1 = "NIL";
						$confall1 = "NIL";
					}
					
					if($count5 > 0)
					{
						$sql = "select * from faculty where Date_from >= '$from_date' and Date_from <= '$to_date' and Paper_type = 'conference' and Paper_N_I = 'international'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data2[] = $row['Paper_title'];
									$conf2[] = $row['conf_journal_name'];
									
									
							}
						}
						}
						for($i = 0; $i < $count5; $i++)
						{
							$rowall2 .= "-".$data2[$i]."<br>";
							$confall2 .= "-".$conf2[$i]."<br>";
							
						}
					}
					else
					{
						$rowall2 = "NIL";
						$confall2 = "NIL";
						
					}
					
					
					if($count6 > 0)
					{
						$sql = "select * from faculty where Date_from >= '$from_date' and Date_from <= '$to_date' and Paper_type = 'journal' and Paper_N_I = 'national'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data3[] = $row['Paper_title'];
									$conf3[] = $row['conf_journal_name'];
									
									
							}
						}
						}
						for($i = 0; $i < $count6; $i++)
						{
							$rowall3 .= "-".$data3[$i]."<br>";
							$confall3 .= "-".$conf3[$i]."<br>";
							
						}
					}
					else
					{
						$rowall3 = "NIL";
						$confall3 = "NIL";
						
					}
					
					if($count7 > 0)
					{
						$sql = "select * from faculty where Date_from >= '$from_date' and Date_from <= '$to_date' and Paper_type = 'journal' and Paper_N_I = 'international'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data4[] = $row['Paper_title'];
									$conf4[] = $row['conf_journal_name'];
									
									
									
							}
						}
						}
						for($i = 0; $i < $count7; $i++)
						{
							$rowall4 .= "-".$data4[$i]."<br>";
							$confall4 .= "-".$conf4[$i]."<br>";
							
						}
					}
					else
					{
						$rowall4 = "NIL";
						$confall4 = "NIL";
					}
					
					if($count8 > 0)
					{
						$sql = "select * from faculty where Date_from >= '$from_date' and Date_from <= '$to_date' and paper_category='peer reviewed' ";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data5[] = $row['Paper_title'];
									$conf5[] = $row['conf_journal_name'];
									
									
									
							}
						}
						}
						for($i = 0; $i < $count8; $i++)
						{
							$rowall5 .= "-".$data5[$i]."<br>";
							$confall5 .= "-".$conf5[$i]."<br>";
							
						}
					}
					else
					{
						$rowall5 = "NIL";
						$confall5 = "NIL";
					}
					
					if($count9 > 0)
					{
						$sql = "select * from faculty where Date_from >= '$from_date' and Date_from <= '$to_date' and paper_category='non peer reviewed' ";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data6[] = $row['Paper_title'];
									$conf6[] = $row['conf_journal_name'];
									
									
							}
						}
						}
						for($i = 0; $i < $count9; $i++)
						{
							$rowall6 .= "-".$data6[$i]."<br>";
							$confall6 .= "-".$conf6[$i]."<br>";
							
						}
					}
					else
					{
						$rowall6 = "NIL";
						$confall6 = "NIL";
					}
					
					$op = "<table  border ='1' class='' id = 'example1'>
					<tr> 
							
 							<td><strong>From date</strong></td>
							<td><strong>"."$from_date"."</strong></td>
							

					</tr> 
					<tr> 
								
								
								<td><strong>To date</strong></td>
								<td><strong>"."$to_date"."</strong></td>

					</tr> 
					
					<tr> 
							
 							<td><strong>Total Publications</strong></td>
							<td><strong>"."$count1"."</strong></td>
							

					</tr> 
					<tr> 
							
 							
							<td><strong>National Conferences</strong></td>
							<td><strong>"."$count4"."</strong></td>
							<td><strong>Papers</strong><br>"."$rowall1"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall1"."</td>
							

				</tr> 
				<tr> 
							
 							
							<td><strong>International Conferences</strong></td>
							<td><strong>"."$count5"."</strong></td>
							<td><strong>Papers</strong><br>"."$rowall2"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall2"."</td>
							

				</tr> 
				<tr> 
							
 							
							<td><strong>National Journals</strong></td>
							<td><strong>"."$count6"."</strong></td>
							<td><strong>Papers</strong><br>"."$rowall3"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall3"."</td>
							
				</tr> 
				<tr> 
							
 							
							<td><strong>International Journals</strong></td>
							<td><strong>"."$count7"."</strong></td>
							<td><strong>Papers</strong><br>"."$rowall4"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall4"."</td>
							
				</tr> 
				<tr> 
							
 							
							<td><strong>Peer reviewed</strong></td>
							<td><strong>"."$count8"."</strong></td>
							<td><strong>Papers</strong><br>"."$rowall5"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall5"."</td>
							
				</tr> 
				<tr> 
							
 							
							<td><strong>Non peer reviewed</strong></td>
							<td><strong>"."$count9"."</strong></td>
							<td><strong>Papers</strong><br>"."$rowall6"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall6"."</td>
							

				</tr> 
					</table>";
				}
				else if($display == 2)
				{
					if($count4 > 0)
					{
						$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and Paper_type = 'conference' and Paper_N_I = 'national'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data1[] = $row['Paper_title'];
									$conf1[] = $row['conf_journal_name'];
									
									
							}
						}
						}
						for($i = 0; $i < $count4; $i++)
						{
							$rowall1 .= "-".$data1[$i]."<br>";
							$confall1 .= "-".$conf1[$i]."<br>";

						}
					}
					else
					{
						$rowall1 = "NIL";
						$confall1 = "NIL";
					}
					
					if($count5 > 0)
					{
						$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and Paper_type = 'conference' and Paper_N_I = 'international'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data2[] = $row['Paper_title'];
									$conf2[] = $row['conf_journal_name'];
									
									
							}
						}
						}
						for($i = 0; $i < $count5; $i++)
						{
							$rowall2 .= "-".$data2[$i]."<br>";
							$confall2 .= "-".$conf2[$i]."<br>";
							
						}
					}
					else
					{
						$rowall2 = "NIL";
						$confall2 = "NIL";
						
					}
					
					if($count6 > 0)
					{
						$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and Paper_type = 'journal' and Paper_N_I = 'national'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data3[] = $row['Paper_title'];
									$conf3[] = $row['conf_journal_name'];
									
									
							}
						}
						}
						for($i = 0; $i < $count6; $i++)
						{
							$rowall3 .= "-".$data3[$i]."<br>";
							$confall3 .= "-".$conf3[$i]."<br>";
							
						}
					}
					else
					{
						$rowall3 = "NIL";
						$confall3 = "NIL";
						
					}
					
					if($count7 > 0)
					{
						$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and Paper_type = 'journal' and Paper_N_I = 'international'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data4[] = $row['Paper_title'];
									$conf4[] = $row['conf_journal_name'];
									
									
							}
						}
						}
						for($i = 0; $i < $count7; $i++)
						{
							$rowall4 .= "-".$data4[$i]."<br>";
							$confall4 .= "-".$conf4[$i]."<br>";
							
						}
					}
					else
					{
						$rowall4 = "NIL";
						$confall4 = "NIL";
					}
					
					if($count8 > 0)
					{
						$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and paper_category = 'peer reviewed'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data5[] = $row['Paper_title'];
									$conf5[] = $row['conf_journal_name'];
									
									
							}
						}
						}
						for($i = 0; $i < $count8; $i++)
						{
							$rowall5 .= "-".$data5[$i]."<br>";
							$confall5 .= "-".$conf5[$i]."<br>";
							
						}
					}
					else
					{
						$rowall5 = "NIL";
						$confall5 = "NIL";
					}
					
					if($count9 > 0)
					{
						$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and paper_category = 'non peer reviewed'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data6[] = $row['Paper_title'];
									$conf6[] = $row['conf_journal_name'];
									
									
							}
						}
						}
						for($i = 0; $i < $count9; $i++)
						{
							$rowall6 .= "-".$data6[$i]."<br>";
							$confall6 .= "-".$conf6[$i]."<br>";

						}
					}
					else
					{
						$rowall6 = "NIL";
						$confall6 = "NIL";
					}
					
					$op = "<table  border = '0.5' class='' id = 'example1'>
					
					<tr> 
							
 							<td><strong>Faculty Name</strong></td>
							<td><strong>"."$name"."</strong></td>
							

					</tr> 
					<tr> 
							
 							<td><strong>Total Publications</strong></td>
							<td><strong>"."$count1"."</strong></td>
							

					</tr> 
					<tr> 
							
 							
							<td><strong>National Conferences</strong></td>
							
							<td><strong>"."$count4"."</strong></td>
							<td><strong>Papers</strong><br>"."$rowall1"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall1"."</td>
							

							
				
				</tr> 
				<tr> 
							
 							
							<td><strong>International Conferences</strong></td>
							<td><strong>"."$count5"."</strong></td>
							<td><strong>Papers</strong><br>"."$rowall2"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall2"."</td>
							


				</tr> 
				<tr> 
							
 							
							<td><strong>National Journals</strong></td>
							<td><strong>"."$count6"."</strong></td>
							<td><strong>Papers</strong><br>"."$rowall3"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall3"."</td>
							

				</tr> 
				<tr> 
							
 							
							<td><strong>International Journals</strong></td>
							<td><strong>"."$count7"."</strong></td>
							<td><strong>Papers</strong><br>"."$rowall4"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall4"."</td>
							


				</tr> 
				<tr> 
							
 							
							<td><strong>Peer reviewed</strong></td>
							<td><strong>"."$count8"."</strong></td>
							<td><strong>Papers</strong><br>"."$rowall5"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall5"."</td>
							

				</tr> 
				<tr> 
							
 							
							<td><strong>Non peer reviewed</strong></td>
							<td><strong>"."$count9"."</strong></td>
							<td><strong>Papers</strong><br>"."$rowall6"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall6"."</td>
							

				</tr> 
				
					</table>";
				}
				else if($display == 3)
				{
					$from_date = $_SESSION['a1']  ;
				   $to_date = $_SESSION['a2'];
					if($count4 > 0)
					{
						$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and faculty.Date_from >= '$from_date' and faculty.Date_from <= '$to_date' and faculty.Paper_type = 'conference' and faculty.Paper_N_I = 'national'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data1[] = $row['Paper_title'];
									$conf1[] = $row['conf_journal_name'];
									
									
									
							}
						}
						}
						for($i = 0; $i < $count4; $i++)
						{
							$rowall1 .= "-".$data1[$i]."<br>";
							$confall1 .= "-".$conf1[$i]."<br>";
						
						}
					}
					else
					{
						$rowall1 = "NIL";
						$confall1 = "NIL";
						
					}
					
					if($count5 > 0)
					{
						$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and faculty.Date_from >= '$from_date' and faculty.Date_from <= '$to_date' and faculty.Paper_type = 'conference' and faculty.Paper_N_I = 'international'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data2[] = $row['Paper_title'];
									$conf2[] = $row['conf_journal_name'];
									
									
									
							}
						}
						}
						for($i = 0; $i < $count5; $i++)
						{
							$rowall2 .= "-".$data2[$i]."<br>";
							$confall2 .= "-".$conf2[$i]."<br>";
						
						}
					}
					else
					{
						$rowall2 = "NIL";
						$confall2 = "NIL";
						
					}
					
					if($count6 > 0)
					{
						$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and faculty.Date_from >= '$from_date' and faculty.Date_from <= '$to_date' and faculty.Paper_type = 'journal' and faculty.Paper_N_I = 'national'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data3[] = $row['Paper_title'];
									$conf3[] = $row['conf_journal_name'];
									
									
							}
						}
						}
						for($i = 0; $i < $count6; $i++)
						{
							$rowall3 .= "-".$data3[$i]."<br>";
							$confall3 .= "-".$conf3[$i]."<br>";

						}
					}
					else
					{
						$rowall3 = "NIL";
						$confall3 = "NIL";
						
					}
					
					if($count7 > 0)
					{
						$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and faculty.Date_from >= '$from_date' and faculty.Date_from <= '$to_date' and faculty.Paper_type = 'journal' and faculty.Paper_N_I = 'international'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data4[] = $row['Paper_title'];
									$conf4[] = $row['conf_journal_name'];
									
									
							}
						}
						}
						for($i = 0; $i < $count7; $i++)
						{
							$rowall4 .= "-".$data4[$i]."<br>";
							$confall4 .= "-".$conf4[$i]."<br>";
							
						}
					}
					else
					{
						$rowall4 = "NIL";
						$confall4 = "NIL";
					}
					
					if($count8 > 0)
					{
						$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and faculty.Date_from >= '$from_date' and faculty.Date_from <= '$to_date' and faculty.paper_category = 'peer reviewed'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data5[] = $row['Paper_title'];
									$conf5[] = $row['conf_journal_name'];
									
									
							}
						}
						}
						for($i = 0; $i < $count8; $i++)
						{
							$rowall5 .= "-".$data5[$i]."<br>";
							$confall5 .= "-".$conf5[$i]."<br>";
							
						}
					}
					else
					{
						$rowall5 = "NIL";
						$confall5 = "NIL";
					}
					
					if($count9 > 0)
					{
						$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and faculty.Date_from >= '$from_date' and faculty.Date_from <= '$to_date' and faculty.paper_category = 'non peer reviewed'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data6[] = $row['Paper_title'];
									$conf6[] = $row['conf_journal_name'];
									
									
							}
						}
						}
						for($i = 0; $i < $count9; $i++)
						{
							$rowall6 .= "-".$data6[$i]."<br>";
							$confall6 .= "-".$conf6[$i]."<br>";							
						}
					}
					else
					{
						$rowall6 = "NIL";
						$confall6 = "NIL";
					}
					
					
					$op = "<table border='0.5' class='' id = 'example1'>
					
					<tr> 
							
 							<td><strong>Faculty Name</strong></td>
							<td><strong>"."$name"."</strong></td>
							

					</tr> 
					<tr> 
							
 							<td><strong>From date</strong></td>
							<td><strong>"."$from_date"."</strong></td>
							

					</tr> 
					<tr> 
								
								
								<td><strong>To date</strong></td>
								<td><strong>"."$to_date"."</strong></td>

					</tr> 
					<tr> 
							
 							<td><strong>Total Publications</strong></td>
							<td><strong>"."$count1"."</strong></td>
							

					</tr> 
					<tr> 
							
 							
							<td><strong>National Conferences</strong></td>
							<td><strong>"."$count4"."</strong></td>
							<td><strong>Papers</strong><br>"."$rowall1"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall1"."</td>
							

					</tr> 
				<tr> 
							
 							
							<td><strong>International Conferences</strong></td>
							<td><strong>"."$count5"."</strong></td>
							<td><strong>Papers</strong><br>"."$rowall2"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall2"."</td>
							

				</tr> 
				<tr> 
							
 							
							<td><strong>National Journals</strong></td>
							<td><strong>"."$count6"."</strong></td>
							<td><strong>Papers</strong><br>"."$rowall3"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall3"."</td>
							
				</tr> 
				<tr> 
							
 							
							<td><strong>International Journals</strong></td>
							<td><strong>"."$count7"."</strong></td>
							<td><strong>Papers</strong><br>"."$rowall4"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall4"."</td>
							

				</tr> 
				<tr> 
							
 							
							<td><strong>Peer reviewed</strong></td>
							<td><strong>"."$count8"."</strong></td>
							<td><strong>Papers</strong><br>"."$rowall5"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall5"."</td>
							

				</tr> 
				<tr> 
							
 							
							<td><strong>Non peer reviewed</strong></td>
							<td><strong>"."$count9"."</strong></td>
							<td><strong>Papers</strong><br>"."$rowall6"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall6"."</td>
							

				</tr> 
					
					</table>";
				}
				
	
				$dompdf = new DOMPDF();
				$dompdf->load_html($op);

				$dompdf->set_paper('a4', 'portrait');
				$dompdf->render();

				$dompdf->stream('hi',array('Attachment'=>0));
				
?>