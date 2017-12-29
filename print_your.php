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
				$c1 = $_SESSION['count1'];
				$c4 = $_SESSION['count4'];
				$c5 = $_SESSION['count5'];
				$c6 = $_SESSION['count6'];
				$c7 = $_SESSION['count7'];
				$c8 = $_SESSION['count8'];
				$c9 = $_SESSION['count9'];
				
					if($c4 > 0)
					{
						if($set == 0)
						{
							$sql = "select * from faculty where Fac_ID = $Fac_ID and Paper_type = 'conference' and Paper_N_I = 'national'";
						}
						else if($set == 1 )
							$sql1 = "select * from faculty where Date_from >= '$from_date' and Date_from <= '$to_date' and Fac_ID = $Fac_ID and Paper_type = 'conference' and Paper_N_I = 'national'" ;

						
						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data1[] = $row['Paper_title'];
									$conf1[] = $row['conf_journal_name'];
									
							}
						}
						}
						for($i = 0; $i < $c4; $i++)
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
					
					if($c5 > 0)
					{
						if($set == 0)
						{
						
							$sql = "select * from faculty where Fac_ID = $Fac_ID and Paper_type = 'conference' and Paper_N_I = 'international'" ;
						}
						else if($set == 1)
							$sql = "select * from faculty where Date_from >= '$from_date' and Date_from <= '$to_date' and Fac_ID = $Fac_ID and Paper_type = 'conference' and Paper_N_I = 'international'" ;

							
						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data2[] = $row['Paper_title'];
									$conf2[] = $row['conf_journal_name'];

							}
						}
						}
						for($i = 0; $i < $c5; $i++)
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
					
					if($c6 > 0)
					{
						if($set == 0)
						{
						
							$sql = "select * from faculty where Fac_ID = $Fac_ID and Paper_type = 'journal' and Paper_N_I = 'national'" ;
						}
						else if($set == 1)
							$sql = "select * from faculty where Date_from >= '$from_date' and Date_from <= '$to_date' and Fac_ID = $Fac_ID and Paper_type = 'journal' and Paper_N_I = 'national'" ;

							
						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data3[] = $row['Paper_title'];
									$conf3[] = $row['conf_journal_name'];
									
							}
						}
						}
						for($i = 0; $i < $c6; $i++)
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
					
					if($c7 > 0)
					{
						if($set == 0)
						{
						
							$sql = "select * from faculty where Fac_ID = $Fac_ID and Paper_type = 'journal' and Paper_N_I = 'international'" ;
						}
						else if($set == 1)
							$sql = "select * from faculty where Date_from >= '$from_date' and Date_from <= '$to_date' and Fac_ID = $Fac_ID and Paper_type = 'journal' and Paper_N_I = 'international'" ;

							
						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data4[] = $row['Paper_title'];
									$conf4[] = $row['conf_journal_name'];
									
							}
						}
						}
						for($i = 0; $i < $c7; $i++)
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
					
					if($c8 > 0)
					{
						if($set == 0)
						{
						
							$sql = "select * from faculty where Fac_ID = $Fac_ID and paper_category = 'peer reviewed'" ;
						}
						else if($set == 1)
							$sql = "select * from faculty where Date_from >= '$from_date' and Date_from <= '$to_date' and Fac_ID = $Fac_ID and paper_category = 'peer reviewed'" ;

							
						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data5[] = $row['Paper_title'];
									$conf5[] = $row['conf_journal_name'];
									
							}
						}
						}
						for($i = 0; $i < $c8; $i++)
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
					
					if($c9 > 0)
					{
						if($set == 0)
						{
						
							$sql = "select * from faculty where Fac_ID = $Fac_ID and paper_category = 'non peer reviewed'" ;
						}
						else if($set == 1)
							$sql = "select * from faculty where Date_from >= '$from_date' and Date_from <= '$to_date' and Fac_ID = $Fac_ID and paper_category = 'non peer reviewed'" ;

							
						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data6[] = $row['Paper_title'];
									$conf6[] = $row['conf_journal_name'];
									
							}
						}
						}
						for($i = 0; $i < $c9; $i++)
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
					
					
				$op = "<table  border='1' class='table table-stripped table-bordered' id = 'example1'>
				<tr> 
							
 							<td><strong>Total Publications Count</strong></td>
							<td><strong>"."$c1"."</strong></td>

				</tr> 
				<tr> 
							
 							<td>National Conferences</td>
							<td>"."$c4"."</td>
							<td><strong>Papers</strong><br>"."$rowall1"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall1"."</td>
							

				</tr>	
				<tr> 
							
 							<td>International Conferences</td>
							<td>"."$c5"."</td>
							<td><strong>Papers</strong><br>"."$rowall2"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall2"."</td>
							

				</tr>	
				<tr> 
							
 							<td>National Journal</td>
							<td>"."$c6"."</td>
							<td><strong>Papers</strong><br>"."$rowall3"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall3"."</td>
							

				</tr>	
				<tr> 
							
 							<td>International Journal</td>
							<td>"."$c7"."</td>
							<td><strong>Papers</strong><br>"."$rowall4"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall4"."</td>
							

				</tr>		
				<tr> 
							
 							<td><strong>Peer reviewed</strong></td>
							<td><strong>"."$c8"."</strong></td>
							<td><strong>Papers</strong><br>"."$rowall5"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall5"."</td>
							

				</tr>	
				<tr> 
							
 							<td><strong>Non-peer reviewed</strong></td>
							<td><strong>"."$c9"."</strong></td>
							<td><strong>Papers</strong><br>"."$rowall6"."</td>
							<td><strong>Conference/Journal</strong><br>"."$confall6"."</td>
							

				</tr>		
				</table>";

				$dompdf = new DOMPDF();
				$dompdf->load_html($op);
				$dompdf->set_paper('a4', 'portrait');
				$dompdf->render();

				$dompdf->stream('hi',array('Attachment'=>0));
				
?>