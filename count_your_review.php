<?php 
ob_start();

session_start();
 if(!isset($_SESSION['loggedInUser'])){
    //send the iser to login page
    header("location:index.php");
}
include_once("includes/connection.php");


include_once('head.php'); ?>
<?php include_once('header.php'); ?>
<?php 
if($_SESSION['username'] == 'hodextc@somaiya.edu')
  {
	    include_once('sidebar_hod.php');

  }
  else
	  include_once('sidebar.php');
 ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

<!-- Main content -->
        <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Technical Papers Reviewed Analysis</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action = "count_your_review.php" method="post">
                  <div class="box-body">
                    
					 <div class="form-group">
                        <label for="InputDateFrom">Date from :</label>
					<input type="date" name="min_date">
<p>
 						<label for="InputDateTo">Date To :</label>
						<input type="date" name="max_date"></p>
                    </div>
                   
                   
                    
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <input type="submit" class="btn btn-warning btn-lg" name="count_total" value = "Count Publications"></input>
                    <a href="2_dashboard_review.php" type="button" class="btn btn-warning btn-lg">Back  </a>

                  </div>
				   <?php 
   							$display = 0;
							$Fac_ID = $_SESSION['Fac_ID'];	
							$a=0;
							$dateset=0;
							$flag=1;
							$count2 = 0;
							$count3 = 0;
							$set = 0;
							$_SESSION['count1'] = 0;
							
							$_SESSION['count4'] = 0;
							$_SESSION['count5'] = 0;
							$_SESSION['count6'] = 0;
							$_SESSION['count7'] = 0;
							$_SESSION['count8'] = 0;
							$_SESSION['count9'] = 0;							

						if(isset($_POST['count_total']))
						{
							
								if (!empty($_POST['min_date']) && !empty($_POST['max_date']))
								{
										$set = 1;
										if((strtotime($_POST['min_date']))>(strtotime($_POST['max_date'])))
										{
												$result="Incorrect date entered. Date from cannot be greater than Date to<br>";
												echo '<div class="error">'.$result.'</div>';
												$a=1;
												$dateset = 1;
										}
										if(strtotime($_POST['min_date'])>strtotime(date('Y-m-d H:i:s')))
										{
											$result="Date from cannot be greater than today's date<br>";
											echo '<div class="error">'.$result.'</div>';
											$a=1;
											$dateset = 1;

										}
										if(strtotime($_POST['max_date'])>strtotime(date('Y-m-d H:i:s')))
										{
											$result="Date to cannot be greater than today's date<br>";
											echo '<div class="error">'.$result.'</div>';
											$a=1;
											$dateset = 1;
											
										}
										if($a == 1)
										{	
											echo '<div class="error">'.$result.'</div>';
										}
													
								
										else if($dateset== 0 && $a == 0)
										{
											$_SESSION['from_date'] = $_POST['min_date'];
											$_SESSION['to_date'] = $_POST['max_date'];
										
										
											$from_date =  $_SESSION['from_date'] ;
											$to_date = $_SESSION['to_date'] ;
											$sql1 = "select * from paper_review where Date_from >= '$from_date' and Date_from <= '$to_date' and Fac_ID = $Fac_ID ";
											$display = 1;
										}
								}
								else
								{
									$result="Date fields cannot be empty<br>";
									echo '<div class="error">'.$result.'</div>';

								}

						}
						// showing default table	
								if($display != 1)
								{
									$sql1 = "select * from paper_review where Fac_ID = $Fac_ID" ;

								}
							
													
							
							
							
								
								if($res1 = mysqli_query($conn,$sql1)){
									if(mysqli_num_rows($res1) > 0){
										
									while($row = $res1->fetch_assoc()) 
									{
										$paper_type = $row['Paper_type'];
										$paper_n_i = $row['Paper_N_I'];
										$cate=$row['paper_category'];
									$_SESSION['count1'] = mysqli_num_rows($res1);
									
									
								
								if($paper_type == 'conference')
								{
									
									$count2++;
									
								}	
								else if($paper_type == 'journal')
								{
									
									$count3++;
									
								}	
								else
								{
									$flag = 0;
								}
								
								if($paper_type == 'conference' && $paper_n_i == 'national')
								{
									
									$_SESSION['count4']++;
									
								}	
								else if($paper_type == 'conference' && $paper_n_i == 'international')
								{
									
									$_SESSION['count5']++;
									
								}	
								else if($paper_type == 'journal' && $paper_n_i == 'national')
								{
									
									$_SESSION['count6']++;
									
								}	
								else if($paper_type == 'journal' && $paper_n_i == 'international')
								{
									
									$_SESSION['count7']++;
									
								}
										
								else
								{
									$flag = 0;
								}	
								
								if($cate=='peer reviewed')
								{
									$_SESSION['count8']++;
									
								}
								else if($cate=='non peer reviewed')
								{
									$_SESSION['count9']++;
								}
								else
								{
									$flag=0;
								}								

									}//while
								}//inner if
								else
										echo "No records to display";
								}//outer if		
								
						?>	
				<?php 
					if($_SESSION['count1'] > 0 )
					{
					$count4 = $_SESSION['count4'];
					$count5 = $_SESSION['count5'];
					$count6 = $_SESSION['count6'];
					$count7 = $_SESSION['count7'];
					$count8 = $_SESSION['count8'];
					$count9 = $_SESSION['count9'];
					if($set == 1)
					{
					$from_date =  $_SESSION['from_date'] ;
					$to_date = $_SESSION['to_date'] ;
					}
					if($count4 > 0)
					{
						if($set == 0)
						{
						
							$sql1 = "select * from paper_review where Fac_ID = $Fac_ID and Paper_type = 'conference' and Paper_N_I = 'national'" ;
						}
						else if($set == 1)
							$sql1 = "select * from paper_review where Date_from >= '$from_date' and Date_from <= '$to_date' and Fac_ID = $Fac_ID and Paper_type = 'conference' and Paper_N_I = 'national'" ;

							
						if($res1 = mysqli_query($conn,$sql1)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$papertitle1[] = $row['Paper_title'];
							}
						}
						}
						
					}
					if($count5 > 0)
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
									$papertitle2[] = $row['Paper_title'];
							}
						}
						}
						
					}
					if($count6 > 0)
					{
						if($set == 0)
						{
							$sql = "select * from paper_review where Fac_ID = $Fac_ID and Paper_type = 'journal' and Paper_N_I = 'national'";
						}
						else if($set == 1)
							$sql = "select * from paper_review where Date_from >= '$from_date' and Date_from <= '$to_date' and Fac_ID = $Fac_ID and Paper_type = 'journal' and Paper_N_I = 'national'" ;

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$papertitle3[] = $row['Paper_title'];
							}
						}
						}
						
					}
					if($count7 > 0)
					{
						if($set == 0)
						{
							$sql = "select * from paper_review where Fac_ID = $Fac_ID and Paper_type = 'journal' and Paper_N_I = 'international'";
						}
						else if($set == 1)
							$sql = "select * from paper_review where Date_from >= '$from_date' and Date_from <= '$to_date' and Fac_ID = $Fac_ID and Paper_type = 'journal' and Paper_N_I = 'international'" ;

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$papertitle4[] = $row['Paper_title'];
							}
						}
						}
						
					}
					if($count8 > 0)
					{
						if($set == 0)
						{
						
							$sql = "select * from paper_review where Fac_ID = $Fac_ID and paper_category='peer reviewed' ";
						}
						else if($set == 1)
							$sql = "select * from paper_review where Date_from >= '$from_date' and Date_from <= '$to_date' and Fac_ID = $Fac_ID and paper_category = 'peer reviewed'" ;

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$papertitle5[] = $row['Paper_title'];
							}
						}
						}
						
					}
					if($count9 > 0)
					{
						if($set == 0)
						{
							$sql = "select * from paper_review where Fac_ID = $Fac_ID and paper_category='non peer reviewed' ";
						}
						else if($set == 1)
							$sql = "select * from paper_review where Date_from >= '$from_date' and Date_from <= '$to_date' and Fac_ID = $Fac_ID and paper_category = 'non peer reviewed'" ;

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$papertitle6[] = $row['Paper_title'];
							}
						}
						}
						
					}
					$_SESSION['set'] = $set;
				 ?>
				 <h4>Total Paper Publications</h4>

				<table  class='table table-stripped table-bordered' id = 'example1'>
				<tr> 
							
 							<td><strong>Total Technical Papers Reviewed Count</strong></td>
							<td><strong><?php echo $_SESSION['count1']; ?></strong></td>

				</tr>	
				<tr> 
							
 							<td>National Conferences</td>
							<td><?php echo $_SESSION['count4']; ?></td>
							<td><?php 
							echo "<strong>Papers</strong>"."<br>";
							if($count4 == 0)
								echo "None";
							else{
							for($i = 0; $i<$count4; $i++)
							{
								echo "-"." " ;
								echo $papertitle1[$i];
								echo "<br>";
							}
							}
							?></td>

				</tr>	
				<tr> 
							
 							<td>International Conferences</td>
							<td><?php echo $_SESSION['count5']; ?></td>
							<td><?php 
							echo "<strong>Papers</strong>"."<br>";
							if($count5 == 0)
								echo "None";
							else{
							for($i = 0; $i<$count5; $i++)
							{
								echo "-"." " ;
								echo $papertitle2[$i];
								echo "<br>";
							}
							}
							?></td>
				</tr>		
				<tr> 
							
 							<td>National Journal</td>
							<td><?php echo $_SESSION['count6']; ?></td>
							<td><?php 
							echo "<strong>Papers</strong>"."<br>";
							if($count6 == 0)
								echo "None";
							else{
								for($i = 0; $i<$count6; $i++)
								{
									echo "-"." " ;
									echo $papertitle3[$i];
									echo "<br>";
								}
							}
							?></td>
				</tr>	
				<tr> 
							
 							<td>International Journal</td>
							<td><?php echo $_SESSION['count7']; ?></td>
							<td><?php 
							echo "<strong>Papers</strong>"."<br>";
							if($count7 == 0)
								echo "None";
							else{
								for($i = 0; $i<$count7; $i++)
								{
									echo "-"." " ;
									echo $papertitle4[$i];
									echo "<br>";
								}
							}
							?></td>
				</tr>		
				<tr> 
							
 							<td><strong>Peer reviewed</strong></td>
							<td><strong><?php echo $_SESSION['count8']; ?></strong></td>
<td><?php 
						echo "<strong>Papers</strong>"."<br>";
						if($count8 == 0)
							echo "None";
						else{
						for($i = 0; $i<$count8; $i++)
						{
							echo "-"." " ;
							echo $papertitle5[$i];
							echo "<br>";
						}
						}
						?></td>
						
				</tr>	
				<tr> 
							
 							<td><strong>Non-peer reviewed</strong></td>
							<td><strong><?php echo $_SESSION['count9']; ?></strong></td>
							<td><?php 
							echo "<strong>Papers</strong>"."<br>";
							if($count9 == 0)
								echo "None";
							else{
							for($i = 0; $i<$count9; $i++)
							{
								echo "-"." " ;
								echo $papertitle6[$i];
								echo "<br>";
							}
							}
							?></td>
				</tr>		
				</table>
			
               <a href="print_your_review.php" type="button" class="btn btn-warning btn-lg" target="_blank">Print</a>
			<?php 
			}//end of if
			?>
                </form>
                
                </div>
              </div>
           </div>      
        </section>
	</div>	
	
	   
    
<?php include_once('footer.php'); ?>