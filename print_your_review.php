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
							$sql = "select * from paper_review where Fac_ID = $Fac_ID and Paper_type = 'conference' and Paper_N_I = 'national'";
						}
						else if($set == 1 )
							$sql1 = "select * from paper_review where Date_from >= '$from_date' and Date_from <= '$to_date' and Fac_ID = $Fac_ID and Paper_type = 'conference' and Paper_N_I = 'national'" ;

						
						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data1[] = $row['Paper_title'];
									
									
							}
						}
						}
						for($i = 0; $i < $c4; $i++)
						{
							$rowall1 .= "-".$data1[$i]."<br>";
						}
					}
					else
						$rowall1 = "NIL";
					
					if($c5 > 0)
					{
						if($set == 0)
						{
						
							$sql = "select * from paper_review where Fac_ID = $Fac_ID and Paper_type = 'conference' and Paper_N_I = 'international'" ;
						}
						else if($set == 1)
							$sql = "select * from paper_review where Date_from >= '$from_date' and Date_from <= '$to_date' and Fac_ID = $Fac_ID and Paper_type = 'conference' and Paper_N_I = 'international'" ;

							
						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data2[] = $row['Paper_title'];
							}
						}
						}
						for($i = 0; $i < $c5; $i++)
						{
							$rowall2 .= "-".$data2[$i]."<br>";
						}
						
					}
					else
						$rowall2 = "NIL";
					
					if($c6 > 0)
					{
						if($set == 0)
						{
						
							$sql = "select * from paper_review where Fac_ID = $Fac_ID and Paper_type = 'journal' and Paper_N_I = 'national'" ;
						}
						else if($set == 1)
							$sql = "select * from paper_review where Date_from >= '$from_date' and Date_from <= '$to_date' and Fac_ID = $Fac_ID and Paper_type = 'journal' and Paper_N_I = 'national'" ;

							
						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data3[] = $row['Paper_title'];
							}
						}
						}
						for($i = 0; $i < $c6; $i++)
						{
							$rowall3 .= "-".$data3[$i]."<br>";
						}
						
					}
					else
						$rowall3 = "NIL";
					
					if($c7 > 0)
					{
						if($set == 0)
						{
						
							$sql = "select * from paper_review where Fac_ID = $Fac_ID and Paper_type = 'journal' and Paper_N_I = 'international'" ;
						}
						else if($set == 1)
							$sql = "select * from paper_review where Date_from >= '$from_date' and Date_from <= '$to_date' and Fac_ID = $Fac_ID and Paper_type = 'journal' and Paper_N_I = 'international'" ;

							
						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data4[] = $row['Paper_title'];
							}
						}
						}
						for($i = 0; $i < $c7; $i++)
						{
							$rowall4 .= "-".$data4[$i]."<br>";
						}
						
					}
					else
						$rowall4 = "NIL";
					
					if($c8 > 0)
					{
						if($set == 0)
						{
						
							$sql = "select * from paper_review where Fac_ID = $Fac_ID and paper_category = 'peer reviewed'" ;
						}
						else if($set == 1)
							$sql = "select * from paper_review where Date_from >= '$from_date' and Date_from <= '$to_date' and Fac_ID = $Fac_ID and paper_category = 'peer reviewed'" ;

							
						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data5[] = $row['Paper_title'];
							}
						}
						}
						for($i = 0; $i < $c8; $i++)
						{
							$rowall5 .= "-".$data5[$i]."<br>";
						}
						
					}
					else
						$rowall5 = "NIL";
					
					if($c9 > 0)
					{
						if($set == 0)
						{
						
							$sql = "select * from paper_review where Fac_ID = $Fac_ID and paper_category = 'non peer reviewed'" ;
						}
						else if($set == 1)
							$sql = "select * from paper_review where Date_from >= '$from_date' and Date_from <= '$to_date' and Fac_ID = $Fac_ID and paper_category = 'non peer reviewed'" ;

							
						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$data6[] = $row['Paper_title'];
							}
						}
						}
						for($i = 0; $i < $c9; $i++)
						{
							$rowall6 .= "-".$data6[$i]."<br>";
						}
						
					}
					else
						$rowall6 = "NIL";
					
					
					
				$op = "<table  border='1' class='table table-stripped table-bordered' id = 'example1'>
				<tr> 
							
 							<td><strong>Total Publications Count</strong></td>
							<td><strong>"."$c1"."</strong></td>

				</tr> 
				<tr> 
							
 							<td>National Conferences</td>
							<td>"."$c4"."</td>
							<td><strong>"."$rowall1"."</strong></td>

				</tr>	
				<tr> 
							
 							<td>International Conferences</td>
							<td>"."$c5"."</td>
							<td><strong>"."$rowall2"."</strong></td>

				</tr>	
				<tr> 
							
 							<td>National Journal</td>
							<td>"."$c6"."</td>
							<td><strong>"."$rowall3"."</strong></td>

				</tr>	
				<tr> 
							
 							<td>International Journal</td>
							<td>"."$c7"."</td>
							<td><strong>"."$rowall4"."</strong></td>

				</tr>		
				<tr> 
							
 							<td><strong>Peer reviewed</strong></td>
							<td><strong>"."$c8"."</strong></td>
							<td><strong>"."$rowall5"."</strong></td>

				</tr>	
				<tr> 
							
 							<td><strong>Non-peer reviewed</strong></td>
							<td><strong>"."$c9"."</strong></td>
							<td><strong>"."$rowall6"."</strong></td>

				</tr>		
				</table>";

				$dompdf = new DOMPDF();
				$dompdf->load_html($op);
				$dompdf->set_paper('a4', 'portrait');
				$dompdf->render();

				$dompdf->stream('hi',array('Attachment'=>0));
				
?>