<?php 
session_start();
 if(!isset($_SESSION['loggedInUser'])){
    //send the iser to login page
    header("location:index.php");
}
include_once('head.php'); ?>
<?php include_once('header.php'); ?>
<?php

	    include_once('sidebar_hod.php');
  
?>
<?php 
include_once("includes/functions.php");

//include custom functions files 
include_once("includes/scripting.php");

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
                  <h3 class="box-title">Analysis</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action = "" method="post">
                  <div class="box-body">
                    <div class="form-group">
                        <label for="InputName">Enter your name :</label>
						<input type="text" placeholder="FirstName  MiddleName  LastName" name="fn">

 						
                    </div>
					 <div class="form-group">
                        <label for="InputDateFrom">Date from :</label>
						&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" name="min_date">

 					<br/><br/><label for="InputDateTo">Date To :</label>
					&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	<input type="date" name="max_date">
                    </div>
                   
                   
                    
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <input type="submit" class="btn btn-warning btn-lg" name="count" value = "Count Publications"></input>
                    <a href="2_dashboard_hod.php" type="button" class="btn btn-warning btn-lg">Back to Dashboard </a>

                  </div>
				   <?php 
						if(isset($_POST['count']))
						{
							$f = 0;
							$v = 0;
							$both_set = 0;
							$_SESSION['flag_count'] = 0;
							$_SESSION['value'] = 4;
							
							if (empty($_POST['min_date']) && empty($_POST['max_date']))
							{
								$result="Date field cannot be empty<br>";
								$v = 1;

								
							}
							if (empty($_POST['fn']))
							{
								$result="Name cannot be empty<br>";
								$v = 2;
				
							}
							if(empty($_POST['fn']) && empty($_POST['min_date']))
							{
								$result="Both fields cannot be empty<br>";
								$f = 1;
								$both_set = 1;
							}
							if(!empty($_POST['fn']) && !empty($_POST['min_date']))
							{
								
								$both_set = 2;
							}
							if((strtotime($_POST['min_date']))>(strtotime($_POST['max_date'])))
									{
											$result="Incorrect date entered. Date from cannot be greater than Date to<br>";
											echo '<div class="error">'.$result.'</div>';
											$flag=1;
									}
									if(strtotime($_POST['min_date'])>strtotime(date('Y-m-d H:i:s')))
									{
										$result="Date from cannot be greater than today's date<br>";
										echo '<div class="error">'.$result.'</div>';
										$flag=1;
									}
									if(strtotime($_POST['max_date'])>strtotime(date('Y-m-d H:i:s')))
									{
										$result="Date to cannot be greater than today's date<br>";
										echo '<div class="error">'.$result.'</div>';
										$flag=1;
									}
						
							
							if($f == 1)
							{
								echo '<div class="error">'.$result.'</div>';

							}
							
							if($f!=1 && $both_set != 2)
							{
							
								if ($v !=1 )
								{
									$_SESSION['from_date'] = $_POST['min_date'];
									$_SESSION['to_date'] = $_POST['max_date'];
									$_SESSION['flag_count'] = 1;
									execute_query()	;	

								}
								else if($v !=2)
								{
									$_SESSION['sname'] = validateFormData($_POST['fn']);
									$_SESSION['flag_count'] = 2;
									execute_query()	;	

								}
							}
							else if($both_set == 2)
							{
								$_SESSION['from_date'] = $_POST['min_date'];
								$_SESSION['to_date'] = $_POST['max_date'];
								$_SESSION['sname'] = validateFormData($_POST['fn']);

								$_SESSION['flag_count'] = 3;
								execute_query();
							}
							
	
						}	//end of count
						
				   ?>
				   
				   
				   
				   
                
<?php	
function execute_query()
{
	include_once("includes/connection.php");

	$flag=1;
	$count2 = 0;
	$count3 = 0;
	$count4 = 0;
	$count5 = 0;
	$count6 = 0;
	$count7 = 0;
	$count8 = 0;
	$count9 = 0;
	
		
		$display = 0;	
		
		if($_SESSION['flag_count'] == 1)
		{
			$from_date =  $_SESSION['from_date'] ;
			$to_date = $_SESSION['to_date'] ;
			$sql1 = "select * from faculty where Date_from >= '$from_date' and Date_from <= '$to_date' ";
			$display = 1;
		}
		else if ($_SESSION['flag_count'] == 2)
		{
				$sname = $_SESSION['sname'] ;
				$sql1 = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' ";

				$display = 2;

		}
		else if($_SESSION['flag_count'] == 3)
		{
			$from_date =  $_SESSION['from_date'] ;
			$to_date = $_SESSION['to_date'] ;
			$sname = $_SESSION['sname'] ;
			$sql1 = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and faculty.Date_from >= '$from_date' and faculty.Date_from <= '$to_date'";
		
		//	$sql1 = "select * from faculty where F_NAME like '%$sname%' and Date_from >= '$from_date' and Date_from <= '$to_date'" ;
			$display = 3;

		}
		if($res1 = mysqli_query($conn,$sql1)){
		if(mysqli_num_rows($res1) > 0){

		$count1 = mysqli_num_rows($res1);
		while($row = $res1->fetch_assoc()) 
		{	
			if($display == 2 || $display == 3)
			{
				$fname = $row['F_NAME'];
					$_SESSION['fname'] = $fname;
			//	$paper_title[] = $row['Paper_title'];


			}
			$paper_type = $row['Paper_type'];
			$paper_n_i = $row['Paper_N_I'];
			$cate=$row['paper_category'];
			//$fname = $row['F_NAME'];
			
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
				
				$count4++;
				
			}	
			else if($paper_type == 'conference' && $paper_n_i == 'international')
			{
				
				$count5++;
				
			}	
			else if($paper_type == 'journal' && $paper_n_i == 'national')
			{
				
				$count6++;
				
			}	
			else if($paper_type == 'journal' && $paper_n_i == 'international')
			{
				
				$count7++;
				
			}
					
			else
			{
				$flag = 0;
			}
			if($cate=='peer reviewed')
			{
				$count8++;
				
			}
			else if($cate=='non peer reviewed')
			{
				$count9++;
			}
			else
			{
				$flag=0;
			}
				
		}//end of while		
		}//end of if
		else
			$count1=0;
		
		
	}	
		
	?>
		
		
		
			
				
		<?php
		
		
		
			if($count1 == 0)
			{
				echo "Record not found Try Again!!";
			}
			
			else if($count1 !=0 && $display == 1)
			{
		?>	
		<h4>Total Paper Publications</h4>

		<table class="table table-stripped table-bordered">
				<tr> 
							<td><strong>From Date</strong></td>
						  				  
						  <td><strong>To Date</strong></td>
 							<td><strong>Total Publications Count</font></strong></td>
		
				</tr>	
					<tr > 
						  <td><?php echo $from_date; 
						  $_SESSION['a1'] = $from_date;
						  ?></td>
						  <td><?php echo $to_date;
						  $_SESSION['a2'] = $to_date;
		
						  ?></td>	
						  <td><?php echo $count1;
							  $_SESSION['a3'] = $count1;

							?></td>
						  
         
					</tr>
		
				</table>
				<br>
				<table class="table table-stripped table-bordered">
				<tr> 
							<td><strong>From Date</strong></td>
						  				  
						  <td><strong>To Date</strong></td>
							<td><strong>National Conferences</font></strong></td>
							<td><strong>International Conferences</font></strong></td>

							<td><strong>National Journals</font></strong></td>
							<td><strong>International Journals</font></strong></td>
							

							
				
				</tr>	
					<tr> 
						 <td><?php echo $from_date; ?></td>
						  <td><?php echo $to_date; ?></td>			  
						  <td><?php echo $count4;
							$_SESSION['a4'] = $count4;
						  ?></td>
						  <td><?php echo $count5; 
 							$_SESSION['a5'] = $count5;

						  ?></td>
						  <td><?php echo $count6;
  							$_SESSION['a6'] = $count6;

						  
						  ?></td>
						  <td><?php echo $count7; 
  							$_SESSION['a7'] = $count7;

						  ?></td>

						           
         
					</tr>
					<?php
				if($count4 > 0)
				{
					$sql = "select * from faculty where Date_from >= '$from_date' and Date_from <= '$to_date' and Paper_type = 'conference' and Paper_N_I = 'national'";

					if($res1 = mysqli_query($conn,$sql)){
					if(mysqli_num_rows($res1) > 0){

						while($row = $res1->fetch_assoc()) 
						{
								$papertitle1[] = $row['Paper_title'];
								$conf1[] = $row['conf_journal_name'];
								
						}
					}
					}
					
				}
				if($count5 > 0)
				{
					$sql = "select * from faculty where Date_from >= '$from_date' and Date_from <= '$to_date' and Paper_type = 'conference' and Paper_N_I = 'international'";

					if($res1 = mysqli_query($conn,$sql)){
					if(mysqli_num_rows($res1) > 0){

						while($row = $res1->fetch_assoc()) 
						{
								$papertitle2[] = $row['Paper_title'];
								$conf2[] = $row['conf_journal_name'];
								
						}
					}
					}
					
				}
				if($count6 > 0)
				{
					$sql = "select * from faculty where Date_from >= '$from_date' and Date_from <= '$to_date' and Paper_type = 'journal' and Paper_N_I = 'national'";

					if($res1 = mysqli_query($conn,$sql)){
					if(mysqli_num_rows($res1) > 0){

						while($row = $res1->fetch_assoc()) 
						{
								$papertitle3[] = $row['Paper_title'];
								$conf3[] = $row['conf_journal_name'];
								
						}
					}
					}
					
				}
				if($count7 > 0)
				{
					$sql = "select * from faculty where Date_from >= '$from_date' and Date_from <= '$to_date' and Paper_type = 'journal' and Paper_N_I = 'international'";

					if($res1 = mysqli_query($conn,$sql)){
					if(mysqli_num_rows($res1) > 0){

						while($row = $res1->fetch_assoc()) 
						{
								$papertitle4[] = $row['Paper_title'];
								$conf4[] = $row['conf_journal_name'];
								
						}
					}
					}
					
				}
				
				?>
				<tr>
						<td></td>
						<td></td>
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
						<td></td>
						<td></td>
						<td><?php 
						echo "<strong>Conference/Journal Name</strong>"."<br>";
						if($count4 == 0)
							echo "None";
						else{
						for($i = 0; $i<$count4; $i++)
						{
							echo "-"." " ;
							echo $conf1[$i];
							
							echo "<br>";
						}
						}
						?></td>
						<td><?php 
						echo "<strong>Conference/Journal Name</strong>"."<br>";
						if($count5 == 0)
							echo "None";
						else{
						for($i = 0; $i<$count5; $i++)
						{
							echo "-"." " ;
							echo $conf2[$i];
							echo "<br>";
						}
						}
						?></td>
						<td><?php 
						echo "<strong>Conference/Journal Name</strong>"."<br>";
						if($count6 == 0)
							echo "None";
						else{
							for($i = 0; $i<$count6; $i++)
							{
								echo "-"." " ;
								echo $conf3[$i];
								echo "<br>";
							}
						}
						?></td>
						<td><?php 
						echo "<strong>Conference/Journal Name</strong>"."<br>";
						if($count7 == 0)
							echo "None";
						else{
							for($i = 0; $i<$count7; $i++)
							{
								echo "-"." " ;
								echo $conf4[$i];
								echo "<br>";
							}
						}
						?></td>
				</tr>				
					
				</table>
				<br>
				
				
				
				
				
			<table class="table table-stripped table-bordered">
				<tr> 
							<td><strong>From Date</strong></td>
						  				  
						  <td><strong>To Date</strong></td>
							<td><strong>Peer Reviewed Journals</font></strong></td>
							<td><strong>Non Peer Reviewed Journal</font></strong></td>

						
							

							
				
				</tr>	
					<tr> 
						 <td><?php echo $from_date; ?></td>
						  <td><?php echo $to_date; ?></td>			  
						  <td><?php echo $count8; 
						  $_SESSION['a8'] = $count8;
						  ?></td>
						  <td><?php echo $count9; 
						  $_SESSION['a9'] = $count9;
						  ?></td>
						           
         
					</tr>
					<?php
					if($count8 > 0)
					{
						$sql = "select * from faculty where Date_from >= '$from_date' and Date_from <= '$to_date' and paper_category='peer reviewed' ";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$papertitle5[] = $row['Paper_title'];
									$conf5[] = $row['conf_journal_name'];
									
							}
						}
						}
						
					}
					if($count9 > 0)
					{
						$sql = "select * from faculty where Date_from >= '$from_date' and Date_from <= '$to_date' and paper_category='non peer reviewed' ";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$papertitle6[] = $row['Paper_title'];
									$conf6[] = $row['conf_journal_name'];
									
							}
						}
						}
						
					}
					?>
					<tr>
						<td></td>
						<td></td>
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
						<tr>
						<td></td>
						<td></td>
						<td><?php 
						echo "<strong>Conference/Journal Name</strong>"."<br>";
						if($count8 == 0)
							echo "None";
						else{
						for($i = 0; $i<$count8; $i++)
						{
							echo "-"." " ;
							echo $conf5[$i];
							echo "<br>";
						}
						}
						?></td>
						<td><?php 
						echo "<strong>Papers</strong>"."<br>";
						if($count9 == 0)
							echo "None";
						else{
						for($i = 0; $i<$count9; $i++)
						{
							echo "-"." " ;
							echo $conf6[$i];
							echo "<br>";
						}
						}
						?></td>
						</tr>
				</table>	
		<?php
			
			}
			else if($display == 2)
			{ ?>
				<table class="table table-stripped table-bordered">
				<tr> 
							<td><strong>Faculty Name</strong></td>
						  				  
 							<td><strong>Total Publications Count</font></strong></td>
		
				</tr>	
					<tr> 
						  <td><?php echo $fname; 
						  $_SESSION['name'] = $fname;
						  ?></td>
						  <td><?php echo $count1;
							$_SESSION['a3'] = $count1;
						  ?></td>
						  
         
					</tr>
		
				</table>
				<br>
				<table class="table table-stripped table-bordered">
				<tr> 
							<td><strong>Faculty Name</strong></td>
						  				  
							<td><strong>National Conferences</font></strong></td>
							<td><strong>International Conferences</font></strong></td>

							<td><strong>National Journals</font></strong></td>
							<td><strong>International Journals</font></strong></td>

							
				
				</tr>	
				<?php
				if($count4 > 0)
				{
					$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and faculty.Paper_type = 'conference' and faculty.Paper_N_I = 'national'";

					if($res1 = mysqli_query($conn,$sql)){
					if(mysqli_num_rows($res1) > 0){

						while($row = $res1->fetch_assoc()) 
						{
								$papertitle1[] = $row['Paper_title'];
								$conf1[] = $row['conf_journal_name'];
						}
					}
					}
					
				}
				if($count5 > 0)
				{
					$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and faculty.Paper_type = 'conference' and faculty.Paper_N_I = 'international'";

					if($res1 = mysqli_query($conn,$sql)){
					if(mysqli_num_rows($res1) > 0){

						while($row = $res1->fetch_assoc()) 
						{
								$papertitle2[] = $row['Paper_title'];
								$conf2[] = $row['conf_journal_name'];
								
						}
					}
					}
					
				}
				if($count6 > 0)
				{
					$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and faculty.Paper_type = 'journal' and faculty.Paper_N_I = 'national'";

					if($res1 = mysqli_query($conn,$sql)){
					if(mysqli_num_rows($res1) > 0){

						while($row = $res1->fetch_assoc()) 
						{
								$papertitle3[] = $row['Paper_title'];
								$conf3[] = $row['conf_journal_name'];
								
						}
					}
					}
					
				}
				if($count7 > 0)
				{
					$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and faculty.Paper_type = 'journal' and faculty.Paper_N_I = 'international'";

					if($res1 = mysqli_query($conn,$sql)){
					if(mysqli_num_rows($res1) > 0){

					while($row = $res1->fetch_assoc()) 
					{
							$papertitle4[] = $row['Paper_title'];
							$conf4[] = $row['conf_journal_name'];
							
					}
					}
					}
					
				}
				
				?>
					<tr> 
						  <td><?php echo $fname; ?></td>			  
						  <td><?php echo $count4;
							$_SESSION['a4'] = $count4;
						  ?></td>
						  <td><?php echo $count5; 
  							$_SESSION['a5'] = $count5;

						  ?></td>
						  <td><?php echo $count6; 
							$_SESSION['a6'] = $count6;
						  
						  ?></td>
						  <td><?php echo $count7; 
							$_SESSION['a7'] = $count7;
						  
						  ?></td>

						           
         
					</tr>
					<tr>
						<td><strong>Paper</strong></td>
						<td><?php 
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
						<td><?php 
						if($count5 == 0)
							echo "None";
						else{
						for($j = 0; $j<$count5; $j++)
						{
							echo "-"." " ;
							echo $papertitle2[$j];
							echo "<br>";
						}
						}
						?></td>
						<td><?php 
						if($count6 == 0)
							echo "None";
						else{
						for($j = 0; $j<$count6; $j++)
						{
							echo "-"." " ;
							echo $papertitle3[$j];
							echo "<br>";
						}
						}
						?></td>
						<td><?php 
						if($count7 == 0)
							echo "None";
						else{
						for($j = 0; $j<$count7; $j++)
						{
							echo "-"." " ;
							echo $papertitle4[$j];
							echo "<br>";
						}
						}
						?></td>
						
						
					</tr>
					<tr>
						<td><strong>Conference/Journal Name</strong></td>
						<td><?php 
						if($count4 == 0)
							echo "None";
						else{
						for($i = 0; $i<$count4; $i++)
						{
							echo "-"." " ;
							echo $conf1[$i];
							echo "<br>";
						}
						}
						
						?></td>
						<td><?php 
						if($count5 == 0)
							echo "None";
						else{
						for($j = 0; $j<$count5; $j++)
						{
							echo "-"." " ;
							echo $conf2[$j];
							echo "<br>";
						}
						}
						?></td>
						<td><?php 
						if($count6 == 0)
							echo "None";
						else{
						for($j = 0; $j<$count6; $j++)
						{
							echo "-"." " ;
							echo $conf3[$j];
							echo "<br>";
						}
						}
						?></td>
						<td><?php 
						if($count7 == 0)
							echo "None";
						else{
						for($j = 0; $j<$count7; $j++)
						{
							echo "-"." " ;
							echo $conf4[$j];
							echo "<br>";
						}
						}
						?></td>
						
						
					</tr>
				</table>
				
				<br>
				<table class="table table-stripped table-bordered">
				<tr> 
							<td><strong>Faculty Name</strong></td>
						  				  
							<td><strong>Peer Reviewed Journals</font></strong></td>
							<td><strong>Non Peer Reviewed Journals</font></strong></td>

						
				
				</tr>	
				
				<?php 
				if($count8 > 0)
				{
					$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and faculty.paper_category = 'peer reviewed'";

					if($res1 = mysqli_query($conn,$sql)){
					if(mysqli_num_rows($res1) > 0){

					while($row = $res1->fetch_assoc()) 
					{
							$papertitle5[] = $row['Paper_title'];
							$conf5[] = $row['conf_journal_name'];
					}
					}
					}
					
				}
				if($count9 > 0)
				{
					$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and faculty.paper_category = 'non peer reviewed'";

					if($res1 = mysqli_query($conn,$sql)){
					if(mysqli_num_rows($res1) > 0){

					while($row = $res1->fetch_assoc()) 
					{
							$papertitle6[] = $row['Paper_title'];
							$conf6[] = $row['conf_journal_name'];
							
					}
					}
					}
					
				}
				?>
					<tr> 
						  <td><?php echo $fname; ?></td>			  
						  <td><?php echo $count8;
							$_SESSION['a8'] = $count8;

						  ?></td>
						  <td><?php echo $count9; 
 							$_SESSION['a9'] = $count9;

						  ?></td>
						 
         
					</tr>
					<tr>
						<td><strong>Paper</strong></td>
						<td><?php 
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
						
						<td><?php 
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
				<tr>
						<td><strong>Conference/Journal Name</strong></td>
						<td><?php 
						if($count8 == 0)
							echo "None";
						else{
						for($i = 0; $i<$count8; $i++)
						{
							echo "-"." " ;
							echo $conf5[$i];
							echo "<br>";
						}
						}
						?></td>
						
						<td><?php 
						if($count9 == 0)
							echo "None";
						else{
						for($i = 0; $i<$count9; $i++)
						{
							echo "-"." " ;
							echo $conf6[$i];
							echo "<br>";
						}
						}
						?></td>				
						
						
				</tr>
				</table>
				
				
				
				
				
		<?php
			}
			else if($display == 3)
			{ ?>
				<table class="table table-stripped table-bordered">
				<tr> 
							<td><strong>Faculty Name</strong></td>
						  				  
 							<td><strong>Total Publications Count</font></strong></td>
		
				</tr>	
					<tr> 
						  <td><?php echo $fname; 
 						  $_SESSION['name'] = $fname;

						  ?></td>
						  <td><?php echo $count1;
						  $_SESSION['a3'] = $count1;

						  ?></td>
						  
         
					</tr>
		
				</table>
				<br>
				
				<table class="table table-stripped table-bordered">
				<tr> 
							<td><strong>Faculty Name</strong></td>
							<td><strong>From Date</strong></td>
							<td><strong>To Date</strong></td>
							
						  				  
							<td><strong>National Conferences</font></strong></td>
							<td><strong>International Conferences</font></strong></td>

							<td><strong>National Journals</font></strong></td>
							<td><strong>International Journals</font></strong></td>
							
	

							
				
				</tr>	
					<tr> 
						  <td><?php echo $fname; ?></td>	
						  <td><?php echo $from_date; ?></td>			  
						  <td><?php echo $to_date; ?></td>			  
						  
						  <td><?php echo $count4;
							$_SESSION['a4'] = $count4;
						  ?></td>
						  <td><?php echo $count5;
							$_SESSION['a5'] = $count5;

						  ?></td>
						  <td><?php echo $count6;
							$_SESSION['a6'] = $count6;

						  ?></td>
						  <td><?php echo $count7;
							$_SESSION['a7'] = $count7;

						  ?></td>
						         
         
					</tr>
					<?php
					$sname = $_SESSION['sname'];
					if($count4 > 0)
					{
						$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and faculty.Date_from >= '$from_date' and faculty.Date_from <= '$to_date' and faculty.Paper_type = 'conference' and faculty.Paper_N_I = 'national'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$papertitle1[] = $row['Paper_title'];
									$conf1[] = $row['conf_journal_name'];
							}
						}
						}
						
					}
					if($count5 > 0)
					{
						$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and faculty.Date_from >= '$from_date' and faculty.Date_from <= '$to_date' and faculty.Paper_type = 'conference' and faculty.Paper_N_I = 'international'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$papertitle2[] = $row['Paper_title'];
									$conf2[] = $row['conf_journal_name'];
									
							}
						}
						}
						
					}
					if($count6 > 0)
					{
						$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and faculty.Date_from >= '$from_date' and faculty.Date_from <= '$to_date' and faculty.Paper_type = 'journal' and faculty.Paper_N_I = 'national'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$papertitle3[] = $row['Paper_title'];
									$conf3[] = $row['conf_journal_name'];
									
							}
						}
						}
						
					}
					if($count7 > 0)
					{
						$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and faculty.Date_from >= '$from_date' and faculty.Date_from <= '$to_date' and faculty.Paper_type = 'journal' and faculty.Paper_N_I = 'international'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$papertitle4[] = $row['Paper_title'];
									$conf4[] = $row['conf_journal_name'];
									
							}
						}
						}
						
					}
					?>
					<tr>
						<td><strong>Paper</strong></td>
						<td></td>
						<td></td>

						<td><?php 
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
						<td><?php 
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
						<td><?php 
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
						<td><?php 
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
						<td><strong>Conference/Journal Name</strong></td>
						<td></td>
						<td></td>

						<td><?php 
						if($count4 == 0)
							echo "None";
						else{
						for($i = 0; $i<$count4; $i++)
						{
							echo "-"." " ;
							echo $conf1[$i];
							echo "<br>";
						}
						}
						
						?></td>
						<td><?php 
						if($count5 == 0)
							echo "None";
						else{
						for($i = 0; $i<$count5; $i++)
						{
							echo "-"." " ;
							echo $conf2[$i];
							echo "<br>";
						}
						}
						
						?></td>
						<td><?php 
						if($count6 == 0)
							echo "None";
						else{
						for($i = 0; $i<$count6; $i++)
						{
							echo "-"." " ;
							echo $conf3[$i];
							echo "<br>";
						}
						}
						
						?></td>
						<td><?php 
						if($count7 == 0)
							echo "None";
						else{
						for($i = 0; $i<$count7; $i++)
						{
							echo "-"." " ;
							echo $conf4[$i];
							echo "<br>";
						}
						}
						
						?></td>
					</tr>	
					
				</table>
				
				<br>
				<table class="table table-stripped table-bordered">
				<tr> 
							<td><strong>Faculty Name</strong></td>
							<td><strong>From Date</strong></td>
							<td><strong>To Date</strong></td>
							
						
							<td><strong>Peer Reviewed Journals</font></strong></td>
							<td><strong>Non Peer Reviewed Journals</font></strong></td>
							
	

							
				
				</tr>	
					<tr> 
						  <td><?php echo $fname; ?></td>	
						  <td><?php echo $from_date; ?></td>	
							<?php $_SESSION['a1'] = $from_date;	?>					  
						  <td><?php echo $to_date; ?></td>			  
							<?php $_SESSION['a2'] = $to_date;	?>					  
						  
						  <td><?php echo $count8; 
 							$_SESSION['a8'] = $count8;

						  ?></td>
						  <td><?php echo $count9; 
  							$_SESSION['a9'] = $count9;

						  ?></td>
						  
  
         
					</tr>
					<?php
					$sname = $_SESSION['sname'];
					if($count8 > 0)
					{
						$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and faculty.Date_from >= '$from_date' and faculty.Date_from <= '$to_date' and faculty.paper_category = 'peer reviewed'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$papertitle5[] = $row['Paper_title'];
									$conf5[] = $row['conf_journal_name'];
							}
						}
						}
						
					}
					if($count9 > 0)
					{
						$sql = "SELECT * from faculty inner join facultydetails on faculty.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and faculty.Date_from >= '$from_date' and faculty.Date_from <= '$to_date' and faculty.paper_category = 'non peer reviewed'";

						if($res1 = mysqli_query($conn,$sql)){
						if(mysqli_num_rows($res1) > 0){

							while($row = $res1->fetch_assoc()) 
							{
									$papertitle6[] = $row['Paper_title'];
									$conf6[] = $row['conf_journal_name'];
									
							}
						}
						}
						
					}
					?>
					<tr>
						<td><strong>Paper</strong></td>
						<td></td>
						<td></td>

						<td><?php 
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
						<td><?php 
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
					<tr>
						<td><strong>Conference/Journal Name</strong></td>
						<td></td>
						<td></td>

						<td><?php 
						if($count8 == 0)
							echo "None";
						else{
						for($i = 0; $i<$count8; $i++)
						{
							echo "-"." " ;
							echo $conf5[$i];
							echo "<br>";
						}
						}
						
						?></td>
						<td><?php 
						if($count9 == 0)
							echo "None";
						else{
						for($i = 0; $i<$count9; $i++)
						{
							echo "-"." " ;
							echo $conf6[$i];
							echo "<br>";
						}
						}
						
						?></td>
					</tr>	
				</table>

		<?php
			}
			if($count1 != 0)
			{
			?>
	<a href="print_all.php?display=<?php echo $display;?>" class="btn btn-warning btn-lg" target="_blank">Print</a> 
			<?php } ?>

			
<?php }	//end of function

?>

          
                </form>
                
                </div>
              </div>
           </div>      
        </section>
	</div>	
	    
    
<?php include_once('footer.php'); ?>