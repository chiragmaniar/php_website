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
                  <h3 class="box-title">Analysis of Online Course</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" action = "" method="post">
                  <div class="box-body">
                  	 <p>
                  	 	<div class="form-group row col-md-6" style="display:block ; margin-left:5px " >
						<label for="type">Select Type:</label>
						<select name='type' id='type' class='form-control input-lg'>
							<option value=''>Select your choice</option>
							<option value="Attended">Attended</option>
							<option value="Organised">Organised</option>
						</select>
						</div>
					</p>
					<div class="form-group col-md-6">
                    <label for="fname">Faculty *</label>
                    <?php
                    include("includes/connection.php");

                    $query="SELECT * from facultydetails";
                    $result=mysqli_query($conn,$query);
                    echo "<select name='fn' id='fname' class='form-control input-lg'><option value=''>Select your choice</option>";
                    while ($row =mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['F_NAME'] ."'>" . $row['F_NAME'] ."</option>";
                    }
                    echo "</select>";
                    ?>
                    </div>
					 <div class="form-group row" style="margin-left:5px ">
                        <label for="InputDateFrom">Date from :</label>
						&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" name="min_date">

 					<br/><br/><label for="InputDateTo">Date To :</label>
					&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	<input type="date" name="max_date">
                    </div>        
                </div><!-- /.box-body -->
                  <div class="box-footer">
                    <input type="submit" class="btn btn-warning btn-lg" name="count" value = "Count Courses"></input>
                    <a href="2_dashboard_hod_online_attended.php" type="button" class="btn btn-warning btn-lg">Back to Dashboard </a>
                  </div>
				   <?php 
						if(isset($_POST['count']))
						{
							$f = 0;
							$v = 0;
							$flag1=0;
							$both_set = 0;
							$_SESSION['flag_count'] = 0;
							$_SESSION['value'] = 4;
							$_SESSION['type'] = $_POST['type'];
							if(empty($_POST['type'])){
								$result="Select type of course<br>";
								echo $result;
								$flag1=1;
							}
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
							if($f!=1 && $both_set != 2 && $flag1!=1)
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
									execute_query();	

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
		include("includes/connection.php");

	$flag=1;
	$display = 0;	
	if($_SESSION['type']=='Attended'){
	
		if($_SESSION['flag_count'] == 1)
		{
			$from_date =  $_SESSION['from_date'] ;
			$to_date = $_SESSION['to_date'] ;
			$sql1 = "select count(*) from online_course_attended inner join facultydetails on online_course_attended.Fac_ID = facultydetails.Fac_ID where Date_From >= '$from_date' and Date_From <= '$to_date' ";
			$result=mysqli_query($conn,$sql1);
			$row =mysqli_fetch_assoc($result);
			$pr="<table class='table table-stripped table-bordered ' border='1' cellpadding=5px cellspacing = 0px style='margin-bottom: 0px;'>
				<tr>
				<th>Total Count</th>";
					$pr.= "<th>".$row['count(*)']."</th></tr></table>";
			?>
			<table class="table table-stripped table-bordered " style="margin-bottom: 0px">
				<tr>
				<th>Total Count</th>
				<?php
					echo "<th>".$row['count(*)']."</th></tr>";
				?>
			</table>
<?php
			$sql1 = "select * from online_course_attended inner join facultydetails on online_course_attended.Fac_ID = facultydetails.Fac_ID where Date_From >= '$from_date' and Date_From <= '$to_date' ";
			$display = 1;
					$result=mysqli_query($conn,$sql1);
					if(mysqli_num_rows($result)>0){
					
?>
						<table class="table table-stripped table-bordered ">
							<tr>
								<th>Faculty</th>
								<th>Date From</th>
								<th>Date To</th>
								<th>Course Name</th>
							</tr>
<?php
						$pr.="<table border='1' cellspacing = 0px class='table table-stripped table-bordered'>
							<tr>
								<th>Faculty</th>
								<th>Date From</th>
								<th>Date To</th>
								<th>Course Name</th>
							</tr>";

						while($row =mysqli_fetch_assoc($result)){
							$fname = $row['F_NAME'];
							$name = $row['Course_Name'];
							$startdate = $row['Date_From'];
							$enddate = $row['Date_To'];
							echo "<tr>";
							echo "<td>".$fname."</td>";
							echo "<td>".$startdate."</td>";
							echo "<td>".$enddate."</td>";
							echo "<td>".$name."</td>";
							echo "</tr>";
							$pr.= "<tr>";
							$pr.= "<td>".$fname."</td>";
							$pr.= "<td>".$startdate."</td>";
							$pr.= "<td>".$enddate."</td>";
							$pr.= "<td>".$name."</td>";
							$pr.= "</tr>";
						}
						echo "</table>";
						$pr.= "</table>";
						$_SESSION['A_1']=$pr;
						?><a href='print_all_online.php?display=<?php echo $display;?>' style='margin-left:5px' type='button' class='btn btn-warning btn-lg' target='_blank'>Print</a><?php 
					}
					else{
						echo "No records to display<br>";
					}
		}
		else if ($_SESSION['flag_count'] == 2)
		{
				$sname = $_SESSION['sname'] ;
				$sql1 = "SELECT count(*) from online_course_attended inner join facultydetails on online_course_attended.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' ";
			$result=mysqli_query($conn,$sql1);
			$row =mysqli_fetch_assoc($result);
			$pr="<table class='table table-stripped table-bordered ' border='1' cellspacing =0 style='margin-bottom: 0px'>
				<tr>
				<th>Faculty</th>
				<th>Total Count</th></tr><tr>";
					$pr.= "<td>".$sname."</td>";
					$pr.= "<td>".$row['count(*)']."</td></tr></table>";
			?>
			<table class="table table-stripped table-bordered " style="margin-bottom: 0px">
				<tr>
				<th>Faculty</th>
				<th>Total Count</th></tr><tr>
				<?php
					echo "<td>".$sname."</td>";
					echo "<td>".$row['count(*)']."</td></tr>";
				?>
			</table>
<?php




				$sql1 = "SELECT * from online_course_attended inner join facultydetails on online_course_attended.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' ";
				$display = 2;
				
				$result=mysqli_query($conn,$sql1);
					if(mysqli_num_rows($result)>0){
					
?>
						<table class="table table-stripped table-bordered ">
							<tr>
								<th>Date From</th>
								<th>Date To</th>
								<th>Course Name</th>
							</tr>
<?php
						$pr.="<table border='1' cellspacing =0 class='table table-stripped table-bordered '>
							<tr>
								<th>Date From</th>
								<th>Date To</th>
								<th>Course Name</th>
							</tr>";
						while($row =mysqli_fetch_assoc($result)){
							$name = $row['Course_Name'];
							$startdate = $row['Date_From'];
							$enddate = $row['Date_To'];
							echo "<tr>";
							echo "<td>".$startdate."</td>";
							echo "<td>".$enddate."</td>";
							echo "<td>".$name."</td>";
							echo "</tr>";
							$pr.= "<tr>";
							$pr.= "<td>".$startdate."</td>";
							$pr.= "<td>".$enddate."</td>";
							$pr.= "<td>".$name."</td>";
							$pr.= "</tr>";
						}
						echo "</table>";
						$pr.="</table>";
						$_SESSION['A_2']=$pr;
						?><a href='print_all_online.php?display=<?php echo $display;?>' style='margin-left:5px' type='button' class='btn btn-warning btn-lg' target='_blank'>Print</a><?php
					}
					
					else{
						echo "No records to display<br>";
					}
		}
		else if($_SESSION['flag_count'] == 3)
		{
			$from_date =  $_SESSION['from_date'] ;
			$to_date = $_SESSION['to_date'] ;
			$sname = $_SESSION['sname'] ;
$sql1 = "SELECT count(*) from online_course_attended inner join facultydetails on online_course_attended.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and online_course_attended.Date_from >= '$from_date' and online_course_attended.Date_from <= '$to_date'";
			$display = 3;
			$result=mysqli_query($conn,$sql1);
			$row =mysqli_fetch_assoc($result);
			$pr="<table class='table table-stripped table-bordered ' border='1' cellspacing = 0px style='margin-bottom: 0px'>
				<tr>
				<th>Faculty</th>
				<th>Total Count</th></tr><tr>";

					$pr.= "<td>".$sname."</td>";
					$pr.= "<td>".$row['count(*)']."</td></tr></table>";
			?>
			<table class="table table-stripped table-bordered " style="margin-bottom: 0px">
				<tr>
				<th>Faculty</th>
				<th>Total Count</th></tr><tr>
				<?php
					echo "<td>".$sname."</td>";
					echo "<td>".$row['count(*)']."</td></tr>";
				?>
			</table>
<?php



			$sql1 = "SELECT * from online_course_attended inner join facultydetails on online_course_attended.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and online_course_attended.Date_from >= '$from_date' and online_course_attended.Date_from <= '$to_date'";
					$result=mysqli_query($conn,$sql1);
					if(mysqli_num_rows($result)>0){
					
?>
						<table class="table table-stripped table-bordered ">
							<tr>
								<th>Date From</th>
								<th>Date To</th>
								<th>Course Name</th>
							</tr>
<?php
						$pr.="<table class='table table-stripped table-bordered ' border='1' cellspacing = 0px >
							<tr>
								<th>Date From</th>
								<th>Date To</th>
								<th>Course Name</th>
							</tr>";
						while($row =mysqli_fetch_assoc($result)){
							$name = $row['Course_Name'];
							$startdate = $row['Date_From'];
							$enddate = $row['Date_To'];
							echo "<tr>";
							echo "<td>".$startdate."</td>";
							echo "<td>".$enddate."</td>";
							echo "<td>".$name."</td>";
							echo "</tr>";
							$pr.= "<tr>";
							$pr.= "<td>".$startdate."</td>";
							$pr.= "<td>".$enddate."</td>";
							$pr.= "<td>".$name."</td>";
							$pr.= "</tr>";
						}
						echo "</table>";
						$pr.= "</table>";
						$_SESSION['A_3']=$pr;
						?><a href='print_all_online.php?display=<?php echo $display;?>' style='margin-left:5px' type='button' class='btn btn-warning btn-lg' target='_blank'>Print</a><?php
					}
					else{
						echo "No records to display<br>";
					}
		}
	}
	if($_SESSION['type']=='Organised'){
	
		if($_SESSION['flag_count'] == 1)
		{
			$from_date =  $_SESSION['from_date'] ;
			$to_date = $_SESSION['to_date'] ;
			$sql1 = "select count(*) from online_course_organised inner join facultydetails on online_course_organised.Fac_ID = facultydetails.Fac_ID where Date_From >= '$from_date' and Date_From <= '$to_date' ";

			$result=mysqli_query($conn,$sql1);
			$row =mysqli_fetch_assoc($result);
			$pr="<table border='1' cellspacing = 0px class='table table-stripped table-bordered ' style='margin-bottom: 0px'>
				<tr>
				<th>Total Count</th>";
					$pr.= "<th>".$row['count(*)']."</th></tr></table>";
			?>
			<table class="table table-stripped table-bordered " style="margin-bottom: 0px">
				<tr>
				<th>Total Count</th>
				<?php
					echo "<th>".$row['count(*)']."</th></tr>";
				?>
			</table>
<?php


			$sql1 = "select * from online_course_organised inner join facultydetails on online_course_organised.Fac_ID = facultydetails.Fac_ID where Date_From >= '$from_date' and Date_From <= '$to_date' ";
			$display = 4;
					$result=mysqli_query($conn,$sql1);
					if(mysqli_num_rows($result)>0){
					
?>
						<table class="table table-stripped table-bordered ">
							<tr>
								<th>Faculty</th>
								<th>Date From</th>
								<th>Date To</th>
								<th>Course Name</th>
							</tr>
<?php
						$pr.="<table border='1' cellspacing = 0px class='table table-stripped table-bordered '>
							<tr>
								<th>Faculty</th>
								<th>Date From</th>
								<th>Date To</th>
								<th>Course Name</th>
							</tr>";
						while($row =mysqli_fetch_assoc($result)){
							$fname = $row['F_NAME'];
							$name = $row['Course_Name'];
							$startdate = $row['Date_From'];
							$enddate = $row['Date_To'];
							echo "<tr>";
							echo "<td>".$fname."</td>";
							echo "<td>".$startdate."</td>";
							echo "<td>".$enddate."</td>";
							echo "<td>".$name."</td>";
							echo "</tr>";
							$pr.= "<tr>";
							$pr.= "<td>".$fname."</td>";
							$pr.= "<td>".$startdate."</td>";
							$pr.= "<td>".$enddate."</td>";
							$pr.= "<td>".$name."</td>";
							$pr.= "</tr>";
						}
						echo "</table>";
						$pr.= "</table>";
						$_SESSION['O_1']=$pr;
						?><a href='print_all_online.php?display=<?php echo $display;?>' style='margin-left:5px' type='button' class='btn btn-warning btn-lg' target='_blank'>Print</a><?php
					}
					else{
						echo "No records to display<br>";
					}
		}
		else if ($_SESSION['flag_count'] == 2)
		{
				$sname = $_SESSION['sname'] ;
				$sql1 = "SELECT count(*) from online_course_organised inner join facultydetails on online_course_organised.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' ";
				$result=mysqli_query($conn,$sql1);
				$row =mysqli_fetch_assoc($result);
				$pr="<table class='table table-stripped table-bordered ' border='1' cellspacing = 0px style='margin-bottom: 0px'>
				<tr>
				<th>Faculty</th>
				<th>Total Count</th></tr><tr>";
					$pr.= "<td>".$sname."</td>";
					$pr.= "<td>".$row['count(*)']."</td></tr></table>";
			?>
			<table class="table table-stripped table-bordered " style="margin-bottom: 0px">
				<tr>
				<th>Faculty</th>
				<th>Total Count</th></tr><tr>
				<?php
					echo "<td>".$sname."</td>";
					echo "<td>".$row['count(*)']."</td></tr>";
				?>
			</table>
<?php

				$sql1 = "SELECT * from online_course_organised inner join facultydetails on online_course_organised.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' ";
				$display = 5;
				$result=mysqli_query($conn,$sql1);
					if(mysqli_num_rows($result)>0){
?>
						<table class="table table-stripped table-bordered ">
							<tr>
								<th>Date From</th>
								<th>Date To</th>
								<th>Course Name</th>
							</tr>
<?php
						$pr.="<table class='table table-stripped table-bordered ' border='1' cellspacing = 0px >
							<tr>
								<th>Date From</th>
								<th>Date To</th>
								<th>Course Name</th>
							</tr>";
						while($row =mysqli_fetch_assoc($result)){
							$name = $row['Course_Name'];
							$startdate = $row['Date_From'];
							$enddate = $row['Date_To'];
							echo "<tr>";
							echo "<td>".$startdate."</td>";
							echo "<td>".$enddate."</td>";
							echo "<td>".$name."</td>";
							echo "</tr>";
							$pr.= "<tr>";
							$pr.= "<td>".$startdate."</td>";
							$pr.= "<td>".$enddate."</td>";
							$pr.= "<td>".$name."</td>";
							$pr.= "</tr>";
						}
						echo "</table>";
						$pr.= "</table>";
						$_SESSION['O_2']=$pr;
						?><a href='print_all_online.php?display=<?php echo $display;?>' style='margin-left:5px' type='button' class='btn btn-warning btn-lg' target='_blank'>Print</a><?php
					}
					else{
						echo "No records to display<br>";
					}
		}
		else if($_SESSION['flag_count'] == 3)
		{
			$from_date =  $_SESSION['from_date'] ;
			$to_date = $_SESSION['to_date'] ;
			$sname = $_SESSION['sname'] ;
			$sql1 = "SELECT count(*) from online_course_organised inner join facultydetails on online_course_organised.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and online_course_organised.Date_from >= '$from_date' and online_course_organised.Date_from <= '$to_date'";
			$display = 6;
$result=mysqli_query($conn,$sql1);
			$row =mysqli_fetch_assoc($result);
			$pr="<table border='1' cellspacing = 0px class='table table-stripped table-bordered ' style='margin-bottom: 0px'>
				<tr>
				<th>Faculty</th>
				<th>Total Count</th></tr><tr>";				
					$pr.= "<td>".$sname."</td>";
					$pr.= "<td>".$row['count(*)']."</td></tr></table>";
			?>
			<table class="table table-stripped table-bordered " style="margin-bottom: 0px">
				<tr>
				<th>Faculty</th>
				<th>Total Count</th></tr><tr>
				<?php
					echo "<td>".$sname."</td>";
					echo "<td>".$row['count(*)']."</td></tr>";
				?>
			</table>
<?php
			$sql1 = "SELECT * from online_course_organised inner join facultydetails on online_course_organised.Fac_ID = facultydetails.Fac_ID and facultydetails.F_NAME like '%$sname%' and online_course_organised.Date_from >= '$from_date' and online_course_organised.Date_from <= '$to_date'";
					$result=mysqli_query($conn,$sql1);
					if(mysqli_num_rows($result)>0){
					
?>
						<table class="table table-stripped table-bordered ">
							<tr>
								<th>Date From</th>
								<th>Date To</th>
								<th>Course Name</th>
							</tr>
<?php
						$pr.="<table border='1' cellspacing = 0px class='table table-stripped table-bordered '>
							<tr>
								<th>Date From</th>
								<th>Date To</th>
								<th>Course Name</th>
							</tr>";
						while($row =mysqli_fetch_assoc($result)){
							$name = $row['Course_Name'];
							$startdate = $row['Date_From'];
							$enddate = $row['Date_To'];
							echo "<tr>";
							echo "<td>".$startdate."</td>";
							echo "<td>".$enddate."</td>";
							echo "<td>".$name."</td>";
							echo "</tr>";
							$pr.= "<tr>";
							$pr.= "<td>".$startdate."</td>";
							$pr.= "<td>".$enddate."</td>";
							$pr.= "<td>".$name."</td>";
							$pr.= "</tr>";
						}
						echo "</table>";
						$pr.= "</table>";
						$_SESSION['O_3']=$pr;
						?><a href='print_all_online.php?display=<?php echo $display;?>' style='margin-left:5px' type='button' class='btn btn-warning btn-lg' target='_blank'>Print</a><?php
					}
					else{
						echo "No records to display<br>";
					}
		}
	}
}
?>
<?php 
function print1($op){
	$dompdf = new DOMPDF();
	$dompdf->load_html($op);
	$dompdf->set_paper('a4', 'portrait');
	$dompdf->render();
	$dompdf->stream('hi',array('Attachment'=>0));
}
?>