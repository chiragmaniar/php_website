<?php
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




//setting error variables
$nameError="";
$emailError="";
$paperTitle = $startDate = $endDate = $paperType = $paperLevel = $paperCategory = $location = $coAuthors = "";

if(isset($_POST['id'])){
    $id = $_POST['id'];
    $query = "SELECT * from paper_review where paper_review_ID = $id";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($result);
    $Fac_ID = $row['Fac_ID'];

    $paperTitle = $row['Paper_title'];
    $startDate = $row['Date_from'];
    $endDate = $row['Date_to'];
    $paperType = $row['Paper_type'];
    $paperLevel = $row['Paper_N_I'];
    $paperCategory = $row['paper_category'];
    $organized = $row['organised_by'];
    $details = $row['details'];
    $volume = $row['volume'];



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
    
   if(!$_POST['paperTitle']){
        $nameError="Please enter a Title<br>";
    }
    else{
        $paperTitle=validateFormData($_POST['paperTitle']);
        $paperTitle = "'".$paperTitle."'";
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
    if(!$_POST['paperType']){
        $nameError="Please select paper type<br>";
    }
    else{
        $paperType=validateFormData($_POST['paperType']);
        $paperType = "'".$paperType."'";
    }
    if(!$_POST['paperLevel']){
        $nameError="Please enter paper level<br>";
    }
    else{
        $paperLevel=validateFormData($_POST['paperLevel']);
        $paperLevel = "'".$paperLevel."'";
    }
    if(!$_POST['paperCategory']){
        $nameError="Please enter paper category<br>";
    }
    else{
        $paperCategory=validateFormData($_POST['paperCategory']);
        $paperCategory = "'".$paperCategory."'";
    }
    if(!$_POST['organized']){
        $organized="Please enter organised by details<br>";
    }
    else{
        $organized=validateFormData($_POST['organized']);
        $organized = "'".$organized."'";
    }
   
    //following are not required so we can directly take them as it is
    
    $details=validateFormData($_POST["details"]);
    $details = "'".$details."'";
	
	
	        $volume=validateFormData($_POST["volume"]);
        $volume = "'".$volume."'";
		
		
		

    
    //checking if there was an error or not
  $query = "SELECT Fac_ID from facultydetails where Email='".$_SESSION['loggedInEmail']."';";
        $result=mysqli_query($conn,$query);
       if($result){
            $row = mysqli_fetch_assoc($result);
            $author = $row['Fac_ID'];
	   }
				$succ = 0;
				$success1 = 0;

	$sql = "update paper_review set Paper_title = $paperTitle,
                               Paper_type = $paperType,
							   Paper_N_I = $paperLevel,
							   paper_category = $paperCategory,
							   Date_from = $startDate,
							   Date_to = $endDate, 
							   organised_by = $organized,
							   details =$details,
							   volume = $volume
							  
							   WHERE paper_review_ID = $id";

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
					   header("location:2_dashboard_hod_review.php?alert=update");

					}
					else
					{
						header("location:2_dashboard_review.php?alert=update");

					}
			}
			else 
			   header("location:2_dashboard_review.php");

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
                  <h3 class="box-title">Paper Presentation/Publication</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="POST" class="row" action ="" style= "margin:10px;" >
                    <input type = 'hidden' name ='id' value = '<?php echo $id; ?>'>
                     <div class="form-group col-md-6">
                         <label for="paper-title">Title *</label>
                         <input required type="text" class="form-control input-lg" id="paper-title" name="paperTitle" value = '<?php echo $paperTitle; ?>' >
                     </div>
                     <div class="form-group col-md-6">
                         <label for="paper-type">Paper Type *</label>
                         <select required class="form-control input-lg" id="paper-type" name="paperType">
                             <option <?php if($paperType == "conference") echo "selected = 'selected'" ?>  value = "conference">Conference</option>
                             <option <?php if($paperType == "journal") echo "selected = 'selected'" ?> value = "journal">Journal</option>
                         </select>
                     </div>
                     <div class="form-group col-md-6">
                         <label for="paper-level">Paper Level *</label>
                         <select required class="form-control input-lg" id="paper-level" name="paperLevel">
                             <option <?php if($paperLevel == "national") echo "selected = 'selected'" ?> value = "national">National</option>
                             <option  <?php if($paperLevel == "international") echo "selected = 'selected'" ?> value = "international">International</option>
                         </select>
                     </div>
                     <div class="form-group col-md-6">
                         <label for="paper-category">Paper Category *</label>
                         <select required class="form-control input-lg" id="paper-category" name="paperCategory">
                             <option  <?php if($paperCategory == "peer reviewed") echo "selected = 'selected'" ?> value = "peer reviewed">Peer Reviewed</option>
                             <option <?php if($paperCategory == "non peer reviewed") echo "selected = 'selected'" ?> value = "non peer reviewed">Non Peer Reviewed</option>
                         </select>
                     </div>
                     <div class="form-group col-md-6">
                         <label for="start-date">Start Date *</label>
                         <input 
                             <?php echo "value = '$startDate'"; ?>
                           required type="date" class="form-control input-lg" id="start-date" name="startDate"
                         placeholder="03:10:10">
                     </div>

                    <div class="form-group col-md-6">
                         <label for="end-date">End Date *</label>
                         <input
                             <?php echo "value = '$endDate'"; ?>
                           required type="date" class="form-control input-lg" id="end-date" name="endDate"
                         placeholder="03:10:10">
                     </div>
                    
                    <div class="form-group col-md-6">
                         <label for="organized">Organized by*</label>
                         <input
                             <?php echo "value = '$organized'"; ?>
                           required type="text" class="form-control input-lg" id="organized" name="organized">
                     </div>

                     <div class="form-group col-md-6">
                         <label for="details">Details of Program/Your Role *</label>
                         <textarea class="form-control input-lg" id="details" name="details" rows="2">
                             <?php echo $details; ?>
                         </textarea>
                     </div>
					 
					  <div class="form-group col-md-6">
                         <label for="volume">Volume/Issue/ISSN </label>
                         <textarea class="form-control input-lg" id="volume" name="volume" rows="2">
                             <?php echo $volume; ?>
                         </textarea>
                     </div>
					
					 

                    <div class="form-group col-md-12">
                         <a href="2_dashboard_review.php" type="button" class="btn btn-warning btn-lg">Cancel</a>

                         <button name="update"  type="submit" class="btn btn-success pull-right btn-lg">Submit</button>

                    </div>
                </form>
                
                </div>
              </div>
           </div>      
        </section>

    
</div>
   
    
    
    
<?php include_once('footer.php'); ?>
   
   