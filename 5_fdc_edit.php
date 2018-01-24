<?php
ob_start(); 
session_start();
if(!isset($_SESSION['loggedInUser'])){
    //send the iser to login page
    header("location:index.php");
}
include_once ("includes/functions.php");

include_once("includes/connection.php");

//include custom functions files 
include_once("includes/functions.php");
include_once("includes/scripting.php");


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

<?php 

if(isset($_POST['id'])){
    $id = $_POST['id'];
	$_SESSION['id'] = $id;
    $query = "SELECT * from fdc_online_course where FDC_ID = $id";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($result);
    $paperTitle = $row['Paper_title'];
    $min_no = $row['min_no'];
    $serial_no = $row['serial_no'];
    $period = $row['period'];
    $od_approv = $row['od_approv'];
    $od_avail = $row['od_avail'];
    $fee_sac = $row['fee_sac'];
    $fee_avail = $row['fee_avail'];
	$fac_id = $row['Fac_ID'];
				  
}
if(isset($_POST['update'])){
					//$fdc = $_SESSION['fdc'];
					$id = $_SESSION['id'];
						
					
					$min_no=validateFormData($_POST['min_no']);
					$min_no = "'".$min_no."'";
					
					$serial_no=validateFormData($_POST['serial_no']);
					$serial_no = "'".$serial_no."'";
					
					$period=validateFormData($_POST['period']);
					$period = "'".$period."'";
					$_SESSION['period'] = $period;
					
					if(isset($_POST['period']))
					{
						if($_POST['period'] == 1)
						{
							if(!isset($_POST['od_approv']))
								$od_approv = $_SESSION['a'];
							else
								$od_approv = $_POST['od_approv'];
							
							if(!isset($_POST['od_avail']))
								$od_avail = $_SESSION['b'];
							else
								$od_avail = $_POST['od_avail'];
						}
					}
					
					$fee_sac =validateFormData($_POST['fee_sac']);
					$fee_sac = "'".$fee_sac."'";
					
					$fee_avail=validateFormData($_POST['fee_avail']);
					$fee_avail = "'".$fee_avail."'";
					
					
					$sql = "update fdc_online_course set min_no = $min_no,serial_no = $serial_no,period = $period,od_approv = '$od_approv',od_avail = '$od_avail', fee_sac = $fee_sac,fee_avail =$fee_avail WHERE FDC_ID = $id";

							if ($conn->query($sql) === TRUE) {
								
								if($_SESSION['username'] == 'hodextc@somaiya.edu')
								{
									header("location:5_fdc_dashboard_hod.php?alert=update");
								}		
								else
									header("location:5_fdc_dashboard.php?alert=update");
	
							} else {
								echo "Error: " . $sql . "<br>" . $conn->error;
							}
					
						
						
						
				}
				


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
                  <h3 class="box-title">FDC Details</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
			<?php
					include("includes/connection.php");

					$query="SELECT * from facultydetails where Fac_ID = $fac_id";
					$result=mysqli_query($conn,$query);
					if($result){
						$row = mysqli_fetch_assoc($result);
						$faculty_name = $row['F_NAME'];
					}
					
			?>	
			<div class="form-group col-md-6">

                         <label for="faculty-name">Faculty Name</label>
                         <input type="text" class="form-control input-lg" id="faculty-name" name="facultyName" value="<?php echo $faculty_name; ?>" readonly>
            </div><br/> <br/> <br/> <br/> 
                <form role="form" action = "" method = "POST">
                  <div class="box-body">
				  <div class="form-group">
                         <label for="paperTitle">Paper </label>
                         <textarea class="form-control input-lg" id="paperTitle" name="paperTitle" rows="2" <?php echo $paperTitle; ?>" readonly>
						<?php echo $paperTitle; ?>
						</textarea>
					 </div>
                  <div class="form-group">
                      <label for='fdcminutesno'>FDC Approval minutes no: </label>
					  <input type='text' class="form-control" id='fdcminutesno' name='min_no' value = '<?php echo $min_no; ?>'>
                    </div>
                    <div class="form-group">
                      <label for='fdcserialno'>FDC Serial no:</label>
					  <input type='text' class="form-control"  id='fdcserialno' name='serial_no' value = '<?php echo $serial_no; ?>'>
                    </div>
                    <div class="form-group">

						<label for="course">Course is during: <br></label>
					<br>	<input type='radio' name='period' class='vac' value='0' <?php echo ($period=='0')?'checked':'' ?>> Vacation <br>
												 
						<input type='radio' name='period' class='non-vac' value='1' <?php echo ($period=='1')?'checked':'' ?>> Non-Vacation <strong>(Please click on radio button to see more options)</strong><br>
					</div>
		
		
					<div class="form-group">
				
					<div class='second-reveal'><hr/ >
									<label for="od_approved">Please mention number of ODs approved(in days):</label>
											<select name="od_approv" class="form-control" >
											  <option value="" selected disabled hidden><?php echo $od_approv;?></option>

												<?php
												
													
													$_SESSION['a']=$od_approv;

													for ($i=1; $i<=30; $i++)
													{
												?>
												<option  value="<?php echo $i; ?>"><?php echo $i;?></option>
												
												<?php
													
													}
												?>
											
											</select>
										<br>	<label for="od_availed">Please mention number of ODs availed(in days):</label>
											<select name="od_avail" class="form-control" >
										  <option value="" selected disabled hidden><?php echo $od_avail;?></option>

													<?php
													
														$_SESSION['b']=$od_avail;

													for ($i=1; $i<=30; $i++)
													{
												?>
												<option value="<?php echo $i;?>"><?php echo $i;?></option>

												<?php
													}
												?>
											</select>
					</div>
					</div>

		
                    <div class="form-group">
						<label for="fee">Registration Fee and TA Sanctioned:</label>
						<input type="text" class="form-control" id="fee" name="fee_sac" value = '<?php echo $fee_sac; ?>'>
					</div>
					<div class="form-group">
						<label for="feeavailed">Registration Fee and TA Availed:</label>
						<input type="text" class="form-control" id="feeavailed" name="fee_avail" value = '<?php echo $fee_avail; ?>'>
					</div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" name = 'update' class="btn btn-primary">Submit</button>
                    <a href="2_dashboard.php" type="button" class="btn btn-primary">Cancel</a>

                  </div>
				  
                </form>
                
                </div>
              </div>
           </div>      
        </section>
        
</div>


    
<?php include_once('footer.php'); ?>
   
   