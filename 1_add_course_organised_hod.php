    
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

//include custom functions files 
include_once("includes/functions.php");
include_once("includes/scripting.php");



//setting error variables
$nameError="";
$emailError="";
$course = $startDate = $endDate = $organised = $purpose = $target = "";
$flag= 0;
$success = 0;
		
	$count1 = $_SESSION['count'];
	
        $faculty_name= $_SESSION['loggedInUser'];

// $query="SELECT * from online_course_attended where Fac_ID = $fid ";
//     $result=mysqli_query($conn,$query);
// 	if(mysqli_num_rows($result)>0){
//         $row=mysqli_fetch_assoc($result);
		
// 	}
//check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

if(isset($_POST['add'])){

    //the form was submitted
    $fname_array = $_POST['fname'];
	$course_array = $_POST['course'];
	$startDate_array = $_POST['startDate'];
	$endDate_array = $_POST['endDate'];
	$organised_array = $_POST['organised'];
    $purpose_array = $_POST['purpose'];
    $target_array = $_POST['target'];

	/*	$min_no_array=$_POST['min_no'];
		$serial_no_array=$_POST['serial_no'];
				$period_array = $_POST['period'];

		$od_approv_array=$_POST['od_approv'];
		$od_avail_array=$_POST['od_avail'];
		$fee_sac_array=$_POST['fee_sac'];
		$fee_avail_array=$_POST['fee_avail'];*/
	
	
    //check for any blank input which are required
    		
for($i=0; $i<count($course_array);$i++)
{
    $fname = mysqli_real_escape_string($conn,$fname_array[$i]);
$course = mysqli_real_escape_string($conn,$course_array[$i]);

$startDate = mysqli_real_escape_string($conn,$startDate_array[$i]);
$endDate = mysqli_real_escape_string($conn,$endDate_array[$i]);
$organised = mysqli_real_escape_string($conn,$organised_array[$i]);
$purpose = mysqli_real_escape_string($conn,$purpose_array[$i]);
$target = mysqli_real_escape_string($conn,$target_array[$i]);

 
  if(empty($_POST['course[]'])){
        $nameError="Please enter Course Name";
		$flag = 0;
    }
    else{
        $course=validateFormData($course);
        $course = "'".$course."'";
		$flag=1;
    }
		
    if(empty($_POST['startDate[]'])){
        $nameError="Please enter a start date";
		$flag = 0;
    }
    else{
        $startDate=validateFormData($startDate);
        $startDate = "'".$startDate."'";
		$flag=1;
    }
	
	 if(empty($_POST['endDate[]'])){
        $nameError="Please enter end date";
		$flag = 0;
    }
    else{
        $endDate=validateFormData($endDate);
        $endDate = "'".$endDate."'";
		$flag=1;
    }
	 if(empty($_POST['location[]'])){
        $nameError="Please enter location";
    }
    else{
        $location=validateFormData($location);
        $location = "'".$location."'";
    }
	  
	  //following are not required so we can directly take them as it is

		
	
	  //checking if there was an error or not
        $query = "SELECT Fac_ID from facultydetails where F_NAME= '$fname'";
        echo $query;
        $result=mysqli_query($conn,$query);
       if($result){
            echo "stringdsandknaslkdnklasndlnasklndklnasdlnlansdklnaslndldnlasklnk";
            $row = mysqli_fetch_assoc($result);
            $author = $row['Fac_ID'];
       }

        $sql="INSERT INTO online_course_organised(Fac_ID,Course_Name, Date_from, Date_to,Organised_by, Purpose, Target_Audience) VALUES ('$author','$course','$startDate','$endDate','$organised','$purpose','$target')";
			if ($conn->query($sql) === TRUE) {
				$success = 1;
                header("location:2_dashboard_hod_online_organised.php?alert=success");
			//header("location:2_dashboard.php?alert=success");
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
			//Commented as no fdc in organised
            /*if($success == 1 && $fdc == 'yes')
			{
				$sql="INSERT INTO fdc(Fac_ID,Course_Name) VALUES ('$author','$course')";
				$result = mysqli_query($conn,$sql);
				
			}*/
}//end of for
            //Commented as no fdc in organised
            /*
			if($success == 1)	
			{
				$query = "SELECT * FROM online_course_organised where Fac_ID = $author and FDC_Y_N = 'yes' ;";
				$result = mysqli_query($conn,$query);
				 if(mysqli_num_rows($result)>0 ){
 					header("location:5_fdc_dashboard.php?alert=success");

				 }
				 else
  					header("location:2_dashboard_online_organised.php?alert=success");
			}*/		        
}
}
//close the connection
mysqli_close($conn);
?>
<?php include_once('head.php'); ?>
<?php include_once('header.php'); ?>
<?php 
if($_SESSION['username'] == 'hodextc@somaiya.edu')
  {
	    include_once('sidebar_hod.php');

  }
  else
	  include_once('sidebar.php');

?>
 
<div class="content-wrapper">
    
    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Online Course Organised</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
	
				
	<?php
			
					for($k=0; $k<$_SESSION['count'] ; $k++)
					{

				?>
            <p>   ***********************************************************
			<form role="form" method="POST" class="row" action ="" style= "margin:10px;" >
					


                    <div class="form-group col-md-6">
                    <label for="fname">Faculty *</label>

                    <?php
                    include("includes/connection.php");

                    $query="SELECT * from facultydetails";
                    $result=mysqli_query($conn,$query);
                    echo "<select name='fname[]' id='fname' class='form-control input-lg'>";
                    while ($row =mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['F_NAME'] ."'>" . $row['F_NAME'] ."</option>";
                    }
                    echo "</select>";
                    ?>
                    </div>

				
                     <div class="form-group col-md-6">
                         <label for="course-name">Name of course *</label>
                      <!--   <input required type="text" class="form-control input-lg" id="paper-title" name="course[]">-->
					  <input  required type="text" class="form-control input-lg"  name="course[]">
                     </div>

                     <div class="form-group col-md-6">
                         <label for="start-date">Start Date *</label>
                         <input required type="date" class="form-control input-lg" id="start-date" name="startDate[]"
                         placeholder="03:10:10">
                     </div>

                    <div class="form-group col-md-6">
                         <label for="end-date">End Date *</label>
                         <input required type="date" class="form-control input-lg" id="end-date" name="endDate[]"
                         placeholder="03:10:10">
                     </div>

                    <div class="form-group col-md-6">
                         <label for="organised">Course organised by *</label>
                         <input required type="text" class="form-control input-lg" id="organised" name="organised[]">
                     </div>

                     <div class="form-group col-md-6">
                         <label for="purpose">Purpose of Course * </label>
                         <textarea  required class="form-control input-lg" id="purpose" name="purpose[]" rows="2"></textarea>
                     </div>
                     
					 <div class="form-group col-md-6">
                         <label for="target">Target Audience * </label>
                         <textarea  required class="form-control input-lg" id="target" name="target[]" rows="2"></textarea>
                     </div>
                     
                   <?php
					}
					?>
					<br/>
                    <div class="form-group col-md-12">
                         <a href="2_dashboard_hod_online_organised.php" type="button" class="btn btn-warning btn-lg">Cancel</a>

                         <button name="add"  type="submit" class="btn btn-success pull-right btn-lg">Submit</button>
                    </div>
                </form>
                </div>
              </div>
           </div>      
        </section>
</div>
<?php include_once('footer.php'); ?>

