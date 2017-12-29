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
    $query = "SELECT * from faculty where P_ID = $id";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($result);
    $Fac_ID = $row['Fac_ID'];

    $paperTitle = $row['Paper_title'];
    $startDate = $row['Date_from'];
    $endDate = $row['Date_to'];
    $paperType = $row['Paper_type'];
    $paperLevel = $row['Paper_N_I'];
	$conf = $row['conf_journal_name'];
    $paperCategory = $row['paper_category'];
    $location = $row['Location'];
    $coAuthors = $row['Paper_co_authors'];
    $volume = $row['volume'];
    $hindex = $row['h_index'];
    $fdc = $row['FDC_Y_N'];


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
    if(!$_POST['location']){
        $location="Please enterlocation<br>";
    }
    else{
        $location=validateFormData($_POST['location']);
        $location = "'".$location."'";
    }
    if(!$_POST['conf']){
        $conf="Please enter conference or journal name<br>";
    }
    else{
        $conf=validateFormData($_POST['conf']);
        $conf = "'".$conf."'";
    }
   
    //following are not required so we can directly take them as it is
    
    $coAuthors=validateFormData($_POST["coauthors"]);
    $coAuthors = "'".$coAuthors."'";
	
	
	        $volume=validateFormData($_POST["volume"]);
        $volume = "'".$volume."'";
		
		$hindex=validateFormData($_POST["hindex"]);
        $hindex = "'".$hindex."'";
		
$fdc=validateFormData($_POST["fdc"]);
        $fdc = "'".$fdc."'";
    
    //checking if there was an error or not
  $query = "SELECT Fac_ID from facultydetails where Email='".$_SESSION['loggedInEmail']."';";
        $result=mysqli_query($conn,$query);
       if($result){
            $row = mysqli_fetch_assoc($result);
            $author = $row['Fac_ID'];
	   }
				$succ = 0;
				$success1 = 0;

	$sql = "update faculty set Paper_title = $paperTitle,
                               Paper_type = $paperType,
							   Paper_N_I = $paperLevel,
							   conf_journal_name = $conf,
							   paper_category = $paperCategory,
							   Date_from = $startDate,
							   Date_to = $endDate, 
							   Location = $location,
							   Paper_co_authors =$coAuthors,
							   volume = $volume,
							   h_index = $hindex,
							   FDC_Y_N = $fdc
							   WHERE P_ID = $id";

			if ($conn->query($sql) === TRUE) 
			{
				$success = 1;
				
				if($success == 1 && preg_match('/yes/', $fdc))
				{
					$sql="INSERT INTO fdc(Fac_ID,Paper_title) VALUES ($author,$paperTitle)";
					$result = mysqli_query($conn,$sql);
					$succ =1;
					
				}	
				if($success == 1 && preg_match('/no/', $fdc))
				{
					$sql="delete from fdc where Paper_title = $paperTitle";
					$result = mysqli_query($conn,$sql);
					$succ =1;
					
				}	
					
				
					
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
			
			
			
			if($succ ==1 )
			{
					if($_SESSION['username'] == 'hodextc@somaiya.edu')
					{
					   header("location:2_dashboard_hod.php?alert=update");

					}
					else
					{
						header("location:2_dashboard.php?alert=update");

					}
			}
			else 
			   header("location:2_dashboard.php");

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
                         <label for="conf">Conference/Journal Name </label>
                         <textarea required class="form-control input-lg" id="conf" name="conf" rows="2"><?php echo $conf; ?></textarea>
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
                         <label for="location">Location *</label>
                         <input
                             <?php echo "value = '$location'"; ?>
                           required type="text" class="form-control input-lg" id="location" name="location">
                     </div>

                     <div class="form-group col-md-6">
                         <label for="coauthors">Co-Author </label>
                         <textarea class="form-control input-lg" id="coauthors" name="coauthors" rows="2">
                             <?php echo $coAuthors; ?>
                         </textarea>
                     </div>
					 
					  <div class="form-group col-md-6">
                         <label for="volume">Volume/Issue/ISSN </label>
                         <textarea class="form-control input-lg" id="volume" name="volume" rows="2">
                             <?php echo $volume; ?>
                         </textarea>
                     </div>
					<div class="form-group col-md-6">
                         <label for="location">H-Index</label>
                         <input 
						  <?php echo "value = '$hindex'"; ?>
						 type="text" class="form-control input-lg" id="hindex" name="hindex">
                     </div>	
					 <div class="form-group col-md-6">
                         <label for="fdc">Applied for FDC ? *</label>
                         <select required class="form-control input-lg" id="fdc" name="fdc">
                             <option <?php if($fdc == "yes") echo "selected = 'selected'" ?> value = "yes">Yes</option>
                             <option <?php if($fdc == "no") echo "selected = 'selected'" ?> value = "no">No</option>
                         </select>
                     </div>   
                    

                    <div class="form-group col-md-12">
                         <a href="2_dashboard.php" type="button" class="btn btn-warning btn-lg">Cancel</a>

                         <button name="update"  type="submit" class="btn btn-success pull-right btn-lg">Submit</button>

                    </div>
                </form>
                
                </div>
              </div>
           </div>      
        </section>

    
</div>
   
    
    
    
<?php include_once('footer.php'); ?>
   
   