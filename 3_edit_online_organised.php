<?php
session_start();
//check if user has logged in or not

if(!isset($_SESSION['loggedInUser'])){
    //send the user to login page
    header("location:index.php");
}
//connect to database
include_once("includes/connection.php");

//include custom functions files 
include_once("includes/functions.php");

//setting error variables
$nameError="";
$emailError="";
$courseName = $startDate = $endDate = $paperType = $paperLevel = $paperCategory = $location = $coAuthors = "";

$Fac_ID=null;
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $query = "SELECT * from online_course_organised where OC_O_ID = $id";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($result);
    //print_r($row);
    $Fac_ID = $row['Fac_Id'];
    $courseName = $row['Course_Name'];
    $startDate = $row['Date_From'];
    $endDate = $row['Date_To'];
    $organised = $row['Organised_By'];
    $purpose = $row['Purpose'];
    $target_audience = $row['Target_Audience'];
}			
			$query2 = "SELECT * from facultydetails where Fac_ID = $Fac_ID";
			$result2 = mysqli_query($conn,$query2);
			if($result2)
			{
	            $row = mysqli_fetch_assoc($result2);
				$F_NAME = $row['F_NAME'];

			}
	   
//check if the form was submitted
if(isset($_POST['update'])){
    //the form was submitted
    $clientName=$clientEmail=$clientPhone=$clientAddress=$clientCompany=$clientNotes="";
    
    //check for any blank input which are required
    
   if(!$_POST['courseName']){
        $nameError="Please enter a Course Name<br>";
    }
    else{
        $courseName=validateFormData($_POST['courseName']);
        $courseName = "'".$courseName."'";
    }
    
    if(!$_POST['startDate']){
        $nameError="Please enter a start date<br>";
    }
    else{
        $startDate=validateFormData($_POST['startDate']);
        $startDate = "'".$startDate."'";
    }
    if(!$_POST['endDate']){
        $nameError="Please enter an end date<br>";
    }
    else{
        $endDate=validateFormData($_POST['endDate']);
        $endDate = "'".$endDate."'";
    }
    if(!$_POST['organised']){
        $organised="Please enter Organised By<br>";
    }
    else{
        $organised=validateFormData($_POST['organised']);
        $organised = "'".$organised."'";
    }
    if(!$_POST['target_audience']){
        $target_audience="Please enter Target Audience<br>";
    }
    else{
        $target_audience=validateFormData($_POST['target_audience']);
        $target_audience = "'".$target_audience."'";
    }
   
    //following are not required so we can directly take them as it is
    
    $purpose=validateFormData($_POST["purpose"]);
    $purpose = "'".$purpose."'";	
		

    
    //checking if there was an error or not
  $query = "SELECT Fac_ID from facultydetails where Email='".$_SESSION['loggedInEmail']."';";
        $result=mysqli_query($conn,$query);
       if($result){
            $row = mysqli_fetch_assoc($result);
            $author = $row['Fac_ID'];
	   }
				$succ = 0;
				$success1 = 0;

	$sql = "update online_course_organised set Course_Name = $courseName,
							   Date_from = $startDate,
							   Date_to = $endDate, 
							   Organised_by = $organised,
							   Purpose =$purpose,
                               Target_Audience = $target_audience
							   WHERE OC_O_ID = $id";

			if ($conn->query($sql) === TRUE) 
			{
				$success = 1;		
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
			if($success ==1 )
			{
					if($_SESSION['username'] == 'hodextc@somaiya.edu')
					{
					   header("location:2_dashboard_hod_online_organised.php?alert=update");
					}
					else
					{
						header("location:2_dashboard_online_organised.php?alert=update");
					}
			}
			else 
			   header("location:2_dashboard_online_organised.php");

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
    
     
            <form role="form" method="POST" class="row" action ="" style= "margin:10px;" >
                    
                    <input type = 'hidden' name ='id' value = '<?php echo $id; ?>'>
                     <div class="form-group col-md-6">
                         <label for="paper-title">Name of course *</label>
                      <!--   <input required type="text" class="form-control input-lg" id="paper-title" name="course[]">-->
                      <input  type="text" class="form-control input-lg" value='<?php echo $courseName; ?>'  name="courseName">
                     </div>

                     <div class="form-group col-md-6">
                         <label for="start-date">Start Date *</label>
                         <input required type="date" class="form-control input-lg" value='<?php echo $startDate; ?>' id="start-date" name="startDate"
                         placeholder="03:10:10">
                     </div>

                    <div class="form-group col-md-6">
                         <label for="end-date">End Date *</label>
                         <input required type="date" class="form-control input-lg" <?php echo "value= '$endDate'"; ?> id="end-date" name="endDate"
                         placeholder="03:10:10">
                     </div>

                    <div class="form-group col-md-6">
                         <label for="location">Course organised by *</label>
                         <input required type="text" class="form-control input-lg" <?php echo "value= '$organised'"; ?> id="organised" name="organised">
                     </div>
                       
                     <div class="form-group col-md-6">
                         <label for="details">Purpose of Course * </label>
                         <textarea  required class="form-control input-lg"  id="purpose" name="purpose" rows="2" value="$row"><?php echo $purpose; ?></textarea>
                     </div>
                     <div class="form-group col-md-6">
                         <label for="target_audience">Target Audience * </label>
                         <textarea  required class="form-control input-lg"  id="target_audience" name="target_audience" rows="2" value="$row"><?php echo $target_audience; ?></textarea>
                     </div>

                    <br/>
                    <div class="form-group col-md-12">
                         <a href="2_dashboard_online_organised.php" type="button" class="btn btn-warning btn-lg">Cancel</a>

                         <button name="update"  type="submit" class="btn btn-success pull-right btn-lg">Submit</button>
                    </div>
                </form>
                </div>
              </div>
           </div>      
        </section>
</div>
<?php include_once('footer.php'); ?>