
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
$paperTitle = $startDate = $endDate = $paperType = $paperLevel = $paperCategory = $location = $coauthors = $volume = "";
$flag= 0;
$success = 0;
		$fid = $_SESSION['Fac_ID'];
	$count1 = $_SESSION['count'];
	
        $faculty_name= $_SESSION['loggedInUser'];

$query="SELECT * from faculty where Fac_ID = $fid ";
    $result=mysqli_query($conn,$query);
	if(mysqli_num_rows($result)>0){
        $row=mysqli_fetch_assoc($result);
		
	}
//check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

if(isset($_POST['add'])){

    //the form was submitted
    
	$paperTitle_array = $_POST['paperTitle'];
	$paperType_array = $_POST['paperType'];
	$paperLevel_array = $_POST['paperLevel'];
		$conf_array = $_POST['conf'];

	$paperCategory_array = $_POST['paperCategory'];

	$startDate_array = $_POST['startDate'];
	$endDate_array = $_POST['endDate'];
	$location_array = $_POST['location'];
	$coauthors_array = $_POST['coauthors'];
	$volume_array = $_POST['volume'];
	$hindex_array = $_POST['hindex'];

	
		$fdc_array = $_POST['fdc'];

	/*	$min_no_array=$_POST['min_no'];
		$serial_no_array=$_POST['serial_no'];
				$period_array = $_POST['period'];

		$od_approv_array=$_POST['od_approv'];
		$od_avail_array=$_POST['od_avail'];
		$fee_sac_array=$_POST['fee_sac'];
		$fee_avail_array=$_POST['fee_avail'];*/
	
	
    //check for any blank input which are required
    		
for($i=0; $i<count($paperTitle_array);$i++)
{
$paperTitle = mysqli_real_escape_string($conn,$paperTitle_array[$i]);
$paperType = mysqli_real_escape_string($conn,$paperType_array[$i]);
$paperLevel = mysqli_real_escape_string($conn,$paperLevel_array[$i]);
$conf = mysqli_real_escape_string($conn,$conf_array[$i]);

$paperCategory = mysqli_real_escape_string($conn,$paperCategory_array[$i]);

$startDate = mysqli_real_escape_string($conn,$startDate_array[$i]);
$endDate = mysqli_real_escape_string($conn,$endDate_array[$i]);
$location = mysqli_real_escape_string($conn,$location_array[$i]);
$coauthors = mysqli_real_escape_string($conn,$coauthors_array[$i]);
$volume = mysqli_real_escape_string($conn,$volume_array[$i]);
$hindex = mysqli_real_escape_string($conn,$hindex_array[$i]);


$fdc = mysqli_real_escape_string($conn,$fdc_array[$i]);
$_SESSION['fdc'] = $fdc;


 
  if(empty($_POST['paperTitle[]'])){
        $nameError="Please enter a Title";
		$flag = 0;
    }
    else{
        $paperTitle=validateFormData($paperTitle);
        $paperTitle = "'".$paperTitle."'";
		$flag=1;
    }
	if(empty($_POST['paperType[]'])){
        $nameError="Please enter a Type";
		$flag = 0;
    }
    else{
        $paperType=validateFormData($paperType);
        $paperType = "'".$paperType."'";
		$flag=1;
    }
	if(empty($_POST['paperLevel[]'])){
        $nameError="Please enter a level";
		$flag = 0;
    }
    else{
        $paperLevel=validateFormData($paperLevel);
        $paperLevel = "'".$paperLevel."'";
		$flag=1;
    }	
	if(empty($_POST['conf[]'])){
        $nameError="Please enter a conference/journal name";
		$flag = 0;
    }
    else{
        $conf=validateFormData($conf);
        $conf = "'".$conf."'";
		$flag=1;
    }	
	if(empty($_POST['paperCategory[]'])){
        $nameError="Please enter a category";
		$flag = 0;
    }
    else{
        $paperCategory=validateFormData($paperCategory);
        $paperCategory = "'".$paperCategory."'";
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

	 $coAuthors=validateFormData($coauthors);
    $coAuthors = "'".$coAuthors."'";
	
	
	        $volume=validateFormData($volume);
        $volume = "'".$volume."'";
	
		$hindex=validateFormData($hindex);
        $hindex = "'".$hindex."'";
		
	
	  //checking if there was an error or not
        $query = "SELECT Fac_ID from facultydetails where Email='".$_SESSION['loggedInEmail']."';";
        $result=mysqli_query($conn,$query);
       if($result){
            $row = mysqli_fetch_assoc($result);
            $author = $row['Fac_ID'];
	   }


        $sql="INSERT INTO faculty(Fac_ID,Paper_title,Paper_type,Paper_N_I,conf_journal_name,paper_category,Date_from,Date_to, Location,Paper_co_authors,volume, h_index,FDC_Y_N) VALUES ('$author','$paperTitle','$paperType','$paperLevel','$conf','$paperCategory','$startDate','$endDate','$location',$coAuthors,$volume,$hindex,'$fdc')";

			if ($conn->query($sql) === TRUE) {
				$success = 1;
			//header("location:2_dashboard.php?alert=success");

					


			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
			if($success == 1 && $fdc == 'yes')
			{
				$sql="INSERT INTO fdc(Fac_ID,Paper_title) VALUES ('$author','$paperTitle')";
				$result = mysqli_query($conn,$sql);
				
			}
			
			

			
				
				
		
				
		
 
}//end of for
			if($success == 1)	
			{
				$query = "SELECT * FROM faculty where Fac_ID = $author and FDC_Y_N = 'yes' ;";
				$result = mysqli_query($conn,$query);
				 if(mysqli_num_rows($result)>0 ){
 					header("location:5_fdc_dashboard.php?alert=success");

				 }
				 else
  					header("location:2_dashboard.php?alert=success");

			}

			        
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
                  <h3 class="box-title">Paper Publication/Presentation</h3>
				 
                </div><!-- /.box-header -->
                <!-- form start -->
	
				<div class="form-group col-md-6">

                         <label for="faculty-name">Faculty Name</label>
                         <input required type="text" class="form-control input-lg" id="faculty-name" name="facultyName" value="<?php echo $faculty_name; ?>" readonly>
                     </div><br/> <br/> <br/> <br/> 
	<?php
			
					for($k=0; $k<$_SESSION['count'] ; $k++)
					{

				?>
            <p>   ***********************************************************
			<form role="form" method="POST" class="row" action ="" style= "margin:10px;" >
					
				
                     <div class="form-group col-md-6">
                         <label for="paper-title">Title *</label>
                      <!--   <input required type="text" class="form-control input-lg" id="paper-title" name="paperTitle[]">-->
					  <input  type="text" class="form-control input-lg"  name="paperTitle[]">
                     </div>
                     <div class="form-group col-md-6">
                         <label for="paper-type">Paper Type *</label>
                         <select required class="form-control input-lg" id="paper-type" name="paperType[]">
                             <option value = "conference">Conference</option>
                             <option value = "journal">Journal</option>
                         </select>
                     </div>
                     <div class="form-group col-md-6">
                         <label for="paper-level">Paper Level *</label>
                         <select required class="form-control input-lg" id="paper-level" name="paperLevel[]">
                             <option value = "national">National</option>
                             <option value = "international">International</option>
                         </select>
                     </div>
					  <div class="form-group col-md-6">
                         <label for="conf">Conference/Journal Name </label>
                         <textarea required class="form-control input-lg" id="conf" name="conf[]" rows="2"></textarea>
                     </div>
                     <div class="form-group col-md-6">
                         <label for="paper-category">Paper Category *</label>
                         <select required class="form-control input-lg" id="paper-category" name="paperCategory[]">
                             <option value = "peer reviewed">Peer Reviewed</option>
                             <option value = "non peer reviewed">Non Peer Reviewed</option>
                         </select>
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
                         <label for="location">Location *</label>
                         <input required type="text" class="form-control input-lg" id="location" name="location[]">
                     </div>

                     <div class="form-group col-md-6">
                         <label for="coauthors">Co-Author </label>
                         <textarea class="form-control input-lg" id="coauthors" name="coauthors[]" rows="2"></textarea>
                     </div>
                     <div class="form-group col-md-6">
                         <label for="volume">Volume/Issue/ISSN </label>
                         <textarea class="form-control input-lg" id="volume" name="volume[]" rows="2"></textarea>
                     </div>		
					 <div class="form-group col-md-6">
                         <label for="location">H-Index</label>
                         <input type="text" class="form-control input-lg" id="hindex" name="hindex[]">
                     </div>	
					 <div class="form-group col-md-6">
                         <label for="fdc">Applied for FDC ? *</label>
                         <select required class="form-control input-lg" id="fdc" name="fdc[]">
                             <option value = "yes">Yes</option>
                             <option value = "no">No</option>
                         </select>
                     </div>
                   <?php
					}
					?>
					<br/>
                    <div class="form-group col-md-12">
                         <a href="2_dashboard.php" type="button" class="btn btn-warning btn-lg">Cancel</a>

                         <button name="add"  type="submit" class="btn btn-success pull-right btn-lg">Submit</button>
                    </div>
                </form>
                </div>
              </div>
           </div>      
        </section>

    
</div>
   
    
    
    
<?php include_once('footer.php'); ?>
   
   