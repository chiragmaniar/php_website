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
            <div class="col-xs-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Online Course Analysis</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action = "count_your_online.php" method="post">
                  <div class="box-body">
                    <div class="form-group col-md-2">
			<label for="type">Select Type:</label>
			<select name='type' id='type' class='form-control input-lg'>
				<option value="Attended">Attended</option>
				<option value="Organised">Organised</option>
			</select>
		</div>
					 <div class="form-group">
                        <label for="InputDateFrom">Date from :</label>
					<input type="date" name="min_date"><br><br>
 						<label for="InputDateTo">Date To :</label>
						<input type="date" name="max_date">
                    </div>
                   
                   
                    
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <input type="submit" class="btn btn-warning btn-lg" name="count_total" value = "Count Courses"></input>
                    <a href="2_dashboard_online_attended.php" type="button" class="btn btn-warning btn-lg">Back to Home </a>

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
										/*if(strtotime($_POST['min_date'])>strtotime(date('Y-m-d H:i:s')))
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
											
										}*/
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
								$_SESSION['type']=$_POST['type'];
								$total1=0;$total2=0;
				if($_POST['type']=='Attended'){
					?><table class="table table-stripped table-bordered" style="margin-bottom: 0px ">
						<tr>
							<th>Total Count</th>
							<?php
								$sql1 = "select count(Course_Name) from online_course_attended where Date_from >= '$from_date' and Date_from <= '$to_date' and Fac_ID = $Fac_ID ";			
								$result=mysqli_query($conn,$sql1);
								$row =mysqli_fetch_assoc($result);

								echo "<th>".$row['count(Course_Name)']."</th></tr></table>";							
							?>
						</tr>
					</table>
					<?php
					$sql1 = "select Date_From,Date_To,Course_Name from online_course_attended where Date_From >= '$from_date' and Date_From <= '$to_date' and Fac_ID = $Fac_ID ";
					$display = 1;
					$_SESSION['sql_att']=$sql1;
					$result=mysqli_query($conn,$sql1);
					if(mysqli_num_rows($result)>0){
						$total1+=1;
?>
						<table class="table table-stripped table-bordered ">
							<tr>
								<th>Date From</th>
								<th>Date To</th>
								<th>Course Name</th>
							</tr>
<?php
						while($row =mysqli_fetch_assoc($result)){
							$name = $row['Course_Name'];
							$startdate = $row['Date_From'];
							$enddate = $row['Date_To'];
							echo "<tr>";
							echo "<td>".$startdate."</td>";
							echo "<td>".$enddate."</td>";
							echo "<td>".$name."</td>";
							echo "</tr>";
						}
						echo "</table><a href='print_your_online.php' type='button' class='btn btn-warning btn-lg' target='_blank'>Print</a>&nbsp<a href='ExportToExcel_online.php' type='button' class='btn btn-warning btn-lg' target='_blank'>Export To Excel</a>";
					}
					else{
						echo "No records to display<br>";
					}
				}
				if($_POST['type']=='Organised'){
					?><table class="table table-stripped table-bordered" style="margin-bottom: 0px ">
						<tr>
							<th>Total Count</th>
							<?php
								$sql1 = "select count(Course_Name) from online_course_organised where Date_From >= '$from_date' and Date_From <= '$to_date' and Fac_ID = $Fac_ID ";			
								$result=mysqli_query($conn,$sql1);
								
								$row =mysqli_fetch_assoc($result);

								echo "<th>".$row['count(Course_Name)']."</th></tr></table>";							
							?>
						</tr>
					</table>
					<?php
					$sql1 = "select Date_From,Date_To,Course_Name from online_course_organised where Date_From >= '$from_date' and Date_From <= '$to_date' and Fac_ID = $Fac_ID ";
					$display = 1;
					$result=mysqli_query($conn,$sql1);
					$_SESSION['sql_org']=$sql1;
					if(mysqli_num_rows($result)>0){
						$total2+=1;
?>
						<table class="table table-stripped table-bordered ">
							<tr>
								<th>Date From</th>
								<th>Date To</th>
								<th>Course Name</th>
							</tr>
<?php
						while($row =mysqli_fetch_assoc($result)){
							$name = $row['Course_Name'];
							$startdate = $row['Date_From'];
							$enddate = $row['Date_To'];
							echo "<tr>";
							echo "<td>".$startdate."</td>";
							echo "<td>".$enddate."</td>";
							echo "<td>".$name."</td>";
							echo "</tr>";
						}
						echo "</table><a href='print_your_online.php' type='button' class='btn btn-warning btn-lg' target='_blank'>Print</a>&nbsp<a href='ExportToExcel_online.php' type='button' class='btn btn-warning btn-lg' target='_blank'>Export To Excel</a>";
					}
					else{
						echo "No records to display<br>";
					}
				}
			}
		}
								else
								{
									$result="Date fields cannot be empty<br>";
									echo '<div class="error">'.$result.'</div>';
								}
								$_SESSION['set']=$set;
								$_SESSION['dateset']=$dateset;
						}
						?>
                </form>
                </div>
              </div>
           </div>      
        </section>
	</div>	
	
	   
    
<?php include_once('footer.php'); ?>